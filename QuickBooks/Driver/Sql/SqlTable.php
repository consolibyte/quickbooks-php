<?php
/**
@file SqlTable.php
@author Roger Dueck
**/

define('TINYINT',1);
define('SMALLINT',2);
define('MEDIUMINT',3);
define('INTEGER',4);
define('BIGINT',5);
define('DECIMAL',6);

class SqlTable {
	protected $db;
	protected string $tableName;
	protected array $schema = [];

	public function __construct($driver, string $table) {
		$this->db = $driver;
		$this->tableName = $table;
	}

	public function getSchema(): array {
		if ($this->schema) return $this->schema;

		$errnum = 0;
		$errmsg = '';

		$q = "SHOW CREATE TABLE $this->tableName";
		$schemaSQL = $this->db->get_var($q,$errnum,$errmsg,0,1);
		if ($schemaSQL === false) return false;
		if (($pos = strpos($schemaSQL, 'SQL SECURITY DEFINER VIEW'))) {
			$search = ' AS select `';
			$str = substr($schemaSQL, strpos($schemaSQL, $search, $pos)+strlen($search));
			list($baseTable,$remainder) = explode('`.`',$str,2);
			$pos = strpos($remainder,'`');
			if (substr($remainder,$pos,3) == '`.`') {
				$baseTable .= '.'.substr($remainder,0,$pos);
			}
			$q = "SHOW CREATE TABLE $baseTable";
			$schemaSQL = $this->db->get_var($q,$errnum,$errmsg,0,1);
		}
		$lines = explode("\n", $schemaSQL);
		foreach ($lines as $line) {
			list($f,$def) = explode(' ', trim($line), 2);
			$f = trim($f, '`');
			$this->schema[$f] = rtrim($def,',');
		}

		return $this->schema;
	}

	public function getFieldDef($fieldName) {
		if (empty($this->schema)) $this->getSchema();

		$def = $this->schema[$fieldName];
		list($type,$extras) = explode(' ',$def,2);
		if (($pos = strpos($type,'(')) !== false) {
			$precision = rtrim(substr($type,$pos+1),')');
			$type = substr($type,0,$pos);

			if (($pos = strpos($precision,','))) {
				$length = intval(substr($precision,0,$pos));
				$decimals = intval(substr($precision,$pos+1));
			}
			else {
				$length = intval($precision);
				$decimals = 0;
			}
		}
		else {
			$length = null;
			$decimals = null;
		}

		return (object)[
			'def'=>$def,
			'type'=>$type,
			'length'=>$length,
			'decimals'=>$decimals,
			'extras'=>$extras
		];
	}

	/** Enlarge database field to fit the given value.
		Adapted from DatabaseInserter.php::enlargeField().
	**/
	public function enlargeField (string $fieldName, $val, bool $enlargeDecimals=false): bool {
		$fieldInfo = $this->getFieldDef($fieldName);
		if (!$fieldInfo) {
			error_log("ERROR: Field '$fieldName' not found in table '$this->tableName'.");
			return false;
		}

		// These should be const
		// strTypes are only those that we can enlarge; we intentionally omit BLOB, TEXT, ENUM, and SET
		$intTypes = ['tinyint'=>1,'smallint'=>2,'mediumint'=>3,'int'=>4,'bigint'=>5];
		$decTypes = ['decimal'=>1,'numeric'=>2,'float'=>3,'double'=>4];
		$strTypes = ['char'=>1,'varchar'=>2,'binary'=>3,'varbinary'=>4];

		if (isset($intTypes[$fieldInfo->type]) || isset($decTypes[$fieldInfo->type])) {
			// Don't enlarge for numbers that use scientific notation!
			// The following algorithm doesn't support it, and the values may be too large.
			if (strpos($val, 'e') !== false) {
				error_log("NOTICE: Not enlarging field for '$val' since it appears to use scientific notation");
				return false;
			}

			$length = strlen($val);
			$decimals = 0;
			$pos = strpos($val,'.');
			if ($pos !== false) {
				$length--;
				$decimals = $length - $pos;
			}
			if ($val < 0) $length--;
			$whole = $length - $decimals;

			$nWhole = max($whole, $fieldInfo->length-$fieldInfo->decimals);
			$nDecimal = $enlargeDecimals ? max($decimals, $fieldInfo->decimals) : $fieldInfo->decimals;
			$nDigits = $nWhole + $nDecimal;
			if ($nDigits < $fieldInfo->length && $nDecimal <= $fieldInfo->decimals && $val <= $this->getMax($fieldInfo)) {
				error_log("NOTICE: Enlargment not needed to store '$val' ($nDigits,$nDecimal) in '$fieldName' ($fieldInfo->length,$fieldInfo->decimals)");
				return false;
			}

			error_log("$fieldName=$val doesn't fit into $fieldInfo->def (type=$fieldInfo->type)");
			$newLen = $nDigits;
			$newTypeCode = $this->getNumericStorageType($nDigits,$nDecimal,$val,$fieldInfo->type);
			if (!$newTypeCode) {
				error_log("NewTypeCode=".json_encode($newTypeCode));
				return false;
			}
			$newType = $this->getNumericSqlType($newTypeCode,$nDigits,$nDecimal);
			if (!$newType) return false;
		}
		elseif (isset($strTypes[$fieldInfo->type])) {
			$length = strlen($val);
			if ($length > 65532) {
				error_log("ERROR: Attempting to store $length chars in '$fieldName' exceeds 65532-char limit");
				return false;
			}
			if ($length <= $fieldInfo->length) {
				error_log("NOTICE: Enlargement not needed to store $length chars in $fieldInfo->length-char '$fieldName'");
				return false;
			}

			error_log("$fieldName=$val doesn't fit into $fieldInfo->def");
			$newLen = $length;
			$newType = "$fieldInfo->type($newLen)";
			$nDecimal = 0;
		}
		else {
			error_log("ERROR: '$fieldName' is not number or string, so cannot be enlarged to accommodate '$val'");
			return false;
		}

		$q = "ALTER TABLE $this->tableName MODIFY COLUMN $fieldName $newType $fieldInfo->extras";
		error_log("Increasing field size: $q;");
		$errnum = 0;
		$errmsg = '';
		if (!$this->db->query($q,$errnum,$errmsg)) return false;
		$this->schema[$fieldName] = "$newType $fieldInfo->extras";

		return true;
	}

	public function getNumericStorageType(int $nDigits, int $nDecimal, $val=0, string $currentType='') {
		$intTypeLevels = [TINYINT=>1,SMALLINT=>2,MEDIUMINT=>3,INTEGER=>4,BIGINT=>5];
		$intTypeNames = ['tinyint'=>TINYINT,'smallint'=>SMALLINT,'mediumint'=>MEDIUMINT,'int'=>INTEGER,'bigint'=>BIGINT];

		if ($nDecimal) return DECIMAL;
		else {
			$currentTypeInt = $intTypeNames[$currentType] ?? 0;
			$level = $intTypeLevels[$currentTypeInt] ?? 0;
			if ($val === null) $val = 0;
			if ($nDigits > 10 || $val > 2147483647 || $val < -2147483648) $minType = BIGINT;
			elseif ($nDigits > 7 || $val > 8388607 || $val < -8388608) $minType = INTEGER;
			elseif ($nDigits > 5 || $val > 32767 || $val < -32768) $minType = MEDIUMINT;
			elseif ($nDigits > 3 || $val > 127 || $val < -128) $minType = SMALLINT;
			else $minType = TINYINT;
			if ($intTypeLevels[$minType] > $level) $type = $minType;
			else $type = $currentTypeInt;

			return $type;
		}
	}

	public function getNumericSqlType($typeCode,$length,$decimals) {
		if ($decimals) $sqlType = "decimal($length,$decimals)";
		elseif ($typeCode == TINYINT) $sqlType = "tinyint($length)";
		elseif ($typeCode == SMALLINT) $sqlType = "smallint($length)";
		elseif ($typeCode == MEDIUMINT) $sqlType = "mediumint($length)";
		elseif ($typeCode == INTEGER) $sqlType = "int($length)";
		elseif ($typeCode == BIGINT) $sqlType = "bigint($length)";
		else {
			error_log("Unknown type: $typeCode");
			return null;
		}

		return $sqlType;
	}

	public function getMax($fieldInfo) {
		$length = $fieldInfo->length;
		switch ($fieldInfo->type) {
		case TINYINT: if ($length == 3) return 127;
		case SMALLINT: if ($length == 5) return 32767;
		case MEDIUMINT: if ($length == 7) return 8388607;
		case INTEGER: if ($length == 10) return 2147483647;
		case BIGINT: if ($length == 19) return 9223372036854775807;
		default:
            $step = 1 / pow(10, $fieldInfo->decimals);
			return pow(10, $length - $fieldInfo->decimals) - $step;
		}
	}
}
