<?php

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks');

require_once 'QuickBooks.php';

$dir = '/Users/kpalmer/Projects/QuickBooks/QuickBooks/QBXML/Schema/Object';

$i = 0;
$dh = opendir($dir);
while (false !== ($file = readdir($dh)))
{
	if ($file{0} == '.')
	{
		continue;
	}
	
	//print('file: ' . $file . "\n");
	
	$tmp = explode('.', $file);
	
	if (substr(current($tmp), -5, 5) != 'AddRq')
	{
		continue;
	}
	
	if (current($tmp) != 'CheckAddRq')
	{
		continue;
	}
	
	include_once $dir . '/' . $file;
	
	$obj = null;
	$code1 = _gen($tmp, $obj);
	
	$code2 = _gen($tmp, $obj, 'ItemLineAdd');
	$code3 = _gen($tmp, $obj, 'ItemGroupLineAdd');
	$code4 = _gen($tmp, $obj, 'ExpenseLineAdd');
	$code5 = _gen($tmp, $obj, 'ApplyCheckToTxnAdd');
	
	$fp = fopen('./tmp_Check.php', 'w+');
	fwrite($fp, $code1);
	fclose($fp);
	
	$fp = fopen('./tmp_ItemLine.php', 'w+');
	fwrite($fp, $code2);
	fclose($fp);

	$fp = fopen('./tmp_ItemGroupLine.php', 'w+');
	fwrite($fp, $code3);
	fclose($fp);

	$fp = fopen('./tmp_ExpenseLine.php', 'w+');
	fwrite($fp, $code4);
	fclose($fp);

	$fp = fopen('./tmp_ApplyCheckToTxn.php', 'w+');
	fwrite($fp, $code5);
	fclose($fp);


	//print($code2);

	/*
	$fp = fopen('./tmp_JournalDebitLine.php', 'w+');
	fwrite($fp, $code3);
	fclose($fp);	
	*/
	
	//print($code);
}
	
function _gen($tmp, $obj, $base = '')
{
	$code = '';
	
	$class = 'QuickBooks_QBXML_Schema_Object_' . current($tmp);
	$obj = new $class;
	
	$type = str_replace('QuickBooks_QBXML_Schema_Object_', '', $class);
	$type = substr($type, 0, -5);
	
	$paths = $obj->paths();
	$count = count($paths);
	print('CLASS: ' . $class . "\n");
	
	$genclass = 'QuickBooks_Object_' . $type;
	
	if ($base)
	{
		$genclass = 'QuickBooks_Object_' . $type . '_' . $base;
	}
	
	$code = '<?php ' . "\n";
	$code .= '/**' . "\n";
	$code .= ' * ' . $type . ' class for QuickBooks ' . "\n";
	$code .= ' * ' . "\n";
	$code .= ' * @author Keith Palmer Jr. <keith@ConsoliBYTE.com>' . "\n";
	$code .= ' * @license LICENSE.txt' . "\n";
	$code .= ' * ' . "\n";
	$code .= ' * @package QuickBooks' . "\n";
	$code .= ' * @subpackage Object' . "\n";
	$code .= ' */ ' . "\n";
	$code .= "\n";
	$code .= '/**' . "\n";
	$code .= ' * QuickBooks base includes' . "\n";
	$code .= ' */' . "\n";
	$code .= 'require_once \'QuickBooks.php\';' . "\n";
	$code .= '' . "\n";
	$code .= '/**' . "\n";
	$code .= ' * QuickBooks object base class' . "\n";
	$code .= ' */' . "\n";
	$code .= 'require_once \'QuickBooks/Object.php\';' . "\n";
	$code .= '' . "\n";
	$code .= '/**' . "\n";
	$code .= ' * ' . "\n";
	$code .= ' */' . "\n";
	$code .= 'class ' . $genclass . ' extends QuickBooks_Object' . "\n";
	$code .= '{' . "\n";
	$code .= '	/**' . "\n";
	$code .= '	 * Create a new ' . $genclass . ' object' . "\n";
	$code .= '	 * ' . "\n";
	$code .= '	 * @param array $arr' . "\n";
	$code .= '	 */' . "\n";
	$code .= '	public function __construct($arr = array())' . "\n";
	$code .= '	{' . "\n";
	$code .= '		parent::__construct($arr);' . "\n";
	$code .= '	}' . "\n";
	$code .= "\n";


	for ($i = 0; $i < $count; $i++)
	{
		$path = $paths[$i];
		
		print('PATH: {' . $path . '}' . "\n");
		
		if ($base)
		{
			if (substr($path, 0, strlen($base)) != $base)
			{
				print('	CONTINUE because ' . substr($path, 0, strlen($base)) . ' != ' . $base . "\n");
				continue;
			}
			
			$path = trim(substr($path, strlen($base)));
		}
		
		if (!trim($path))
		{
			continue;
		}
				
		/*if ($path == 'Desc')
		{
			$paths1 = array_slice($paths, 0, $i);
			$paths2 = array_slice($paths, $i);
			
			$paths = array_merge($paths1, array( 'Description' ), $paths2);
			
			//print_r($paths);
			//exit;
		}*/
		
		//print('	path: ' . $path . "\n");
				
		if ($path == 'IncludeRetElement')
		{
			continue;
		}
		else if (false === strpos($path, ' '))
		{
			$datatype = $obj->dataType($path);
			
			switch ($datatype)
			{
				case QUICKBOOKS_DATATYPE_DATE:
					$sparams = '$date';
					$gparams = '$format = null';
					$smethod = 'setDateType(\'{path}\', $date);';
					$gmethod = 'getDateType(\'{path}\', $format);';
					$greturn = 'string';
					break;
				case QUICKBOOKS_DATATYPE_FLOAT:
					$sparams = '$value';
					$gparams = '';
					$smethod = 'setAmountType(\'{path}\', $value);';
					$gmethod = 'getAmountType(\'{path}\');';
					$greturn = 'float';			
					break;
				case QUICKBOOKS_DATATYPE_BOOLEAN:
					$sparams = '$bool';
					$gparams = '';
					$smethod = 'setBooleanType(\'{path}\', $bool);';
					$gmethod = 'getBooleanType(\'{path}\');';
					$greturn = 'boolean';								
					break;
				default:
					$sparams = '$value';
					$gparams = '';
					$smethod = 'set(\'{path}\', $value);';
					$gmethod = 'get(\'{path}\');';
					$greturn = 'string';
					break;
			}
			
			$smethod = str_replace('{path}', $path, $smethod);
			$gmethod = str_replace('{path}', $path, $gmethod);
			
			$tmp_sdocparams = explode(',', $sparams);
			$sdocparams = '';
			foreach ($tmp_sdocparams as $param)
			{
				$sdocparams .= "\t" . ' * @param ' . $greturn . ' ' . trim($param) . "\n";
			}
			
			$tmp_gdocparams = explode(',', $gparams);
			$gdocparams = '';
			foreach ($tmp_gdocparams as $param)
			{
				if (trim($param))
				{
					$gdocparams .= "\t" . ' * @param ? ' . trim($param) . "\n";
				}
			}
			
			$code .= "\t" . '// Path: ' . $path . ', datatype: ' . $datatype . "\n";
			$code .= "\t" . "\n";
			$code .= "\t" . '/**' . "\n";
			$code .= "\t" . ' * Set the ' . $path . ' for the ' . $type . "\n";
			$code .= "\t" . ' * ' . "\n";
			$code .= $sdocparams;
			$code .= "\t" . ' * @return boolean' . "\n";
			$code .= "\t" . ' */' . "\n";
			$code .= "\t" . 'public function set' . $path . '(' . $sparams . ')' . "\n";
			$code .= "\t" . '{' . "\n";
			$code .= "\t" . "\t" . 'return $this->' . $smethod . "\n";
			$code .= "\t" . '}' . "\n";
			$code .= "\n";
			$code .= "\t" . '/**' . "\n";
			$code .= "\t" . ' * Get the ' . $path . ' for the ' . $type . "\n";
			$code .= "\t" . ' * ' . "\n";
			$code .= $gdocparams;
			$code .= "\t" . ' * @return ' . $greturn . "\n";
			$code .= "\t" . ' */' . "\n";
			$code .= "\t" . 'public function get' . $path . '(' . $gparams . ')' . "\n";
			$code .= "\t" . '{' . "\n";
			$code .= "\t" . "\t" . 'return $this->' . $gmethod . "\n";
			$code .= "\t" . '}' . "\n";
			$code .= "\n";
			
			if ($path == 'Desc')
			{
				$code .= "\t" . '/**' . "\n";
				$code .= "\t" . ' * @see ' . $genclass . '::setDesc()' . "\n";
				$code .= "\t" . ' */' . "\n";
				$code .= "\t" . 'public function setDescription(' . $sparams . ')' . "\n";
				$code .= "\t" . '{' . "\n";
				$code .= "\t" . "\t" . '$this->setDesc(' . $sparams . '); ' . "\n";
				$code .= "\t" . '}' . "\n";
				$code .= "\n";
				$code .= "\t" . '/**' . "\n";
				$code .= "\t" . ' * @see ' . $genclass . '::getDesc()' . "\n";
				$code .= "\t" . ' */' . "\n";				
				$code .= "\t" . 'public function getDescription(' . $gparams . ')' . "\n";
				$code .= "\t" . '{' . "\n";
				$code .= "\t" . "\t" . '$this->getDesc(' . $gparams . ');' . "\n";
				$code .= "\t" . '}' . "\n";				
			}
			else if ($path == 'TxnDate')
			{
				$code .= "\t" . '/**' . "\n";
				$code .= "\t" . ' * @see ' . $genclass . '::setTxnDate()' . "\n";
				$code .= "\t" . ' */' . "\n";
				$code .= "\t" . 'public function setTransactionDate(' . $sparams . ')' . "\n";
				$code .= "\t" . '{' . "\n";
				$code .= "\t" . "\t" . '$this->setTxnDate(' . $sparams . '); ' . "\n";
				$code .= "\t" . '}' . "\n";
				$code .= "\n";
				$code .= "\t" . '/**' . "\n";
				$code .= "\t" . ' * @see ' . $genclass . '::getTxnDate()' . "\n";
				$code .= "\t" . ' */' . "\n";				
				$code .= "\t" . 'public function getTransactionDate(' . $gparams . ')' . "\n";
				$code .= "\t" . '{' . "\n";
				$code .= "\t" . "\t" . '$this->getTxnDate(' . $gparams . ');' . "\n";
				$code .= "\t" . '}' . "\n";								
			}
		}
		else
		{
			if ( 
				(substr($path, -6) == 'ListID' and substr_count($path, ' ') == 1) or 
				
				false
				)
			{
				print("\n\n");
				print($path);
				print("\n\n");
				//exit;
				
				$set = 'set' . str_replace('Ref ', '', $path);
				$setapp = 'set' . substr(str_replace('Ref ', '', $path), 0, -6) . 'ApplicationID';
				$get = 'get' . str_replace('Ref ', '', $path);
				$constant = 'QUICKBOOKS_OBJECT_' . strtoupper(str_replace('Ref ListID', '', $path));
				
				if (false !== strpos($path, 'Parent'))
				{
					$constant = 'QUICKBOOKS_OBJECT_' . strtoupper($type);
				}
				
				$code .= "\t" . '// Path: ' . $path . ', datatype: ' . null . "\n";
				$code .= "\t" . "\n";
				$code .= "\t" . '/**' . "\n";
				$code .= "\t" . ' * Set the ' . $path . ' for the ' . $type . "\n";
				$code .= "\t" . ' * ' . "\n";
				$code .= "\t" . ' * @param string $ListID		The ListID of the record to reference' . "\n";
				$code .= "\t" . ' * @return boolean' . "\n";
				$code .= "\t" . ' */' . "\n";
				$code .= "\t" . 'public function ' . $set . '($ListID)' . "\n";
				$code .= "\t" . '{' . "\n";
				$code .= "\t" . "\t" . 'return $this->set(\'' . $path . '\', $ListID);' . "\n";
				$code .= "\t" . '}' . "\n";
				$code .= "\n";
				$code .= "\t" . '/**' . "\n";
				$code .= "\t" . ' * Get the ' . $path . ' for the ' . $type . "\n";
				$code .= "\t" . ' * ' . "\n";
				
				$code .= "\t" . ' * @return string' . "\n";
				$code .= "\t" . ' */' . "\n";
				$code .= "\t" . 'public function ' . $get . '()' . "\n";
				$code .= "\t" . '{' . "\n";
				$code .= "\t" . "\t" . 'return $this->get(\'' . $path . '\');' . "\n";
				$code .= "\t" . '}' . "\n";
				$code .= "\n";
				$code .= "\t" . '/**' . "\n";
				$code .= "\t" . ' * Set the primary key for the related record within your own application for the ' . $type . "\n";
				$code .= "\t" . ' * ' . "\n";
				$code .= "\t" . ' * @param mixed $value			The primary key within your own application' . "\n";
				$code .= "\t" . ' * @return string' . "\n";
				$code .= "\t" . ' */' . "\n";
				$code .= "\t" . 'public function ' . $setapp . '($value)' . "\n";
				$code .= "\t" . '{' . "\n";
				$code .= "\t" . "\t" . 'return $this->set(\'' . substr($path, 0, -7) . ' \' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(' . $constant . ', QUICKBOOKS_LISTID, $value));' . "\n";
				$code .= "\t" . '}' . "\n";
				$code .= "\n";
				
				
			}
			else if (
				(substr($path, -8) == 'FullName' and substr_count($path, ' ') == 1)
				)
			{
				$set = 'set' . str_replace('Ref Full', '', $path);
				
				$get = 'get' . str_replace('Ref Full', '', $path);
				
				
				$code .= "\t" . '// Path: ' . $path . ', datatype: ' . null . "\n";
				$code .= "\t" . "\n";
				$code .= "\t" . '/**' . "\n";
				$code .= "\t" . ' * Set the ' . $path . ' for the ' . $type . "\n";
				$code .= "\t" . ' * ' . "\n";
				$code .= "\t" . ' * @param string $FullName		The FullName of the record to reference' . "\n";
				$code .= "\t" . ' * @return boolean' . "\n";
				$code .= "\t" . ' */' . "\n";
				$code .= "\t" . 'public function ' . $set . '($FullName)' . "\n";
				$code .= "\t" . '{' . "\n";
				$code .= "\t" . "\t" . 'return $this->set(\'' . $path . '\', $FullName);' . "\n";
				$code .= "\t" . '}' . "\n";
				$code .= "\n";
				$code .= "\t" . '/**' . "\n";
				$code .= "\t" . ' * Get the ' . $path . ' for the ' . $type . "\n";
				$code .= "\t" . ' * ' . "\n";
				
				$code .= "\t" . ' * @return string' . "\n";
				$code .= "\t" . ' */' . "\n";
				$code .= "\t" . 'public function ' . $get . '()' . "\n";
				$code .= "\t" . '{' . "\n";
				$code .= "\t" . "\t" . 'return $this->get(\'' . $path . '\');' . "\n";
				$code .= "\t" . '}' . "\n";
				$code .= "\n";
				
			}
			
		}
	}
	
	$code .= '}' . "\n";
	$code .= "\n";
	
	//
	return $code;
	
	print("\n\n");
	$i++;
	
	if ($i >= 1)
	{
		exit;
	}
}

?>