<?php

/**
 * PgSQL backend for the QuickBooks SOAP server
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * You need to use some sort of backend to facilitate communication between the 
 * SOAP server and your application. The SOAP server stores queue requests 
 * using the backend. 
 * 
 * This backend driver is for a PostgreSQL database. You can use the 
 * {@see QuickBooks_Utilities} class to initalize the five tables in the 
 * PostgreSQL database. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 *  
 * @package QuickBooks
 * @subpackage Driver
 */

/**
 * QuickBooks driver base class
 */
QuickBooks_Loader::load('/QuickBooks/Driver.php');

/**
 * QuickBooks driver SQL base class
 */
QuickBooks_Loader::load('/QuickBooks/Driver/Sql.php', false);

/**
 * QuickBooks utilities class
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_SALT'))
{
	/**
	 * Salt used when hashing to create ticket values
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_SALT', QUICKBOOKS_DRIVER_SQL_SALT);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX'))
{
	/**
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX', QUICKBOOKS_DRIVER_SQL_PREFIX);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_QUEUETABLE'))
{
	/**
	 * MySQL table name to store queued requests in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_QUEUETABLE', QUICKBOOKS_DRIVER_SQL_QUEUETABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_USERTABLE'))
{
	/**
	 * MySQL table name to store usernames/passwords for the QuickBooks SOAP server
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_USERTABLE', QUICKBOOKS_DRIVER_SQL_USERTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_TICKETTABLE'))
{
	/**
	 * The table name to store session tickets in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_TICKETTABLE', QUICKBOOKS_DRIVER_SQL_TICKETTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_LOGTABLE'))
{
	/**
	 * The table name to store log data in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_LOGTABLE', QUICKBOOKS_DRIVER_SQL_LOGTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_RECURTABLE'))
{
	/**
	 * The table name to store recurring events in
	 * 
	 * @var string
	 */
	 define('QUICKBOOKS_DRIVER_SQL_PGSQL_RECURTABLE', QUICKBOOKS_DRIVER_SQL_RECURTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_IDENTTABLE'))
{
	/**
	 * The table name to store identifiers in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_IDENTTABLE', QUICKBOOKS_DRIVER_SQL_IDENTTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_CONFIGTABLE'))
{
	/**
	 * The table name to store configuration options in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_CONFIGTABLE', QUICKBOOKS_DRIVER_SQL_CONFIGTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_NOTIFYTABLE'))
{
	/**
	 * The table name to store notifications in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_NOTIFYTABLE', QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_PGSQL_CONNECTIONTABLE'))
{
	/**
	 * The table name to store connection data in 
	 *
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_PGSQL_CONNECTIONTABLE', QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE);
}

/**
 * QuickBooks PostgreSQL back-end driver
 */
class QuickBooks_Driver_Sql_Pgsql extends QuickBooks_Driver_Sql
{
	/**
	 * PostgreSQL connection resource
	 * 
	 * @var resource
	 */
	protected $_conn;
	
	/**
	 * User-defined hook functions
	 * 
	 * @var array 
	 */
	protected $_hooks;
	
	/**
	 * 
	 */
	protected $_last_result;
	
	/**
	 * 
	 */
	protected $_schema;
    
    /**
     * The table last used by $this->insert() 
     * @var string 
     */
    protected $last_insert_table;
	
	/**
	 * Create a new MySQL back-end driver
	 * 
	 * @param string $dsn		A DSN-style connection string (i.e.: "mysql://your-mysql-username:your-mysql-password@your-mysql-host:port/your-mysql-database")
	 * @param array $config		Configuration options for the driver (not currently supported)
	 */
	public function __construct($dsn_or_conn, $config)
	{
		$config = $this->_defaults($config);
		
		if (is_resource($dsn_or_conn))
		{
			$this->_conn = $dsn_or_conn;
		}
		else
		{
			$defaults = array(
				'scheme' => 'pgsql', 
				'host' => 'localhost', 
				'port' => 5432, 
				'user' => 'pgsql', 
				'pass' => '', 
				'path' => '/quickbooks',
				);
			
			$parse = QuickBooks_Utilities::parseDSN($dsn_or_conn, $defaults);
			
			$this->_connect($parse['host'], $parse['port'], $parse['user'], $parse['pass'], substr($parse['path'], 1), $config['new_link']);
		}

		// Call the parent constructor too
		parent::__construct($dsn_or_conn, $config);
	}
	
	/**
	 * Merge an array of configuration options with the defaults
	 * 
	 * @param array $config
	 * @return array 
	 */
	protected function _defaults($config)
	{
		$defaults = array(
			'new_link' => true, 
			);
		
		return array_merge($defaults, $config);
	}
	
	protected function _initialized()
	{
		$required = array(
			//$this->_mapTableName(QUICKBOOKS_DRIVER_SQL_IDENTTABLE) => false, 
			$this->_mapTableName(QUICKBOOKS_DRIVER_SQL_TICKETTABLE) => false, 
			$this->_mapTableName(QUICKBOOKS_DRIVER_SQL_USERTABLE) => false, 
			$this->_mapTableName(QUICKBOOKS_DRIVER_SQL_RECURTABLE) => false, 
			$this->_mapTableName(QUICKBOOKS_DRIVER_SQL_QUEUETABLE) => false, 
			$this->_mapTableName(QUICKBOOKS_DRIVER_SQL_LOGTABLE) => false, 
			$this->_mapTableName(QUICKBOOKS_DRIVER_SQL_CONFIGTABLE) => false, 
			//$this->_mapTableName(QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE) => false, 
			//$this->_mapTableName(QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE) => false, 
			);
		
		$errnum = 0;
		$errmsg = '';
		$res = $this->_query("
			SELECT 
				table_name
			FROM
				information_schema.tables
			WHERE
				table_schema = '" . $this->_escape($this->_schema) . "' AND table_type = 'BASE TABLE' ", $errnum, $errmsg);
		while ($arr = $this->_fetch($res))
		{
			$table = current($arr);
			
			if (isset($required[$table]))
			{
				$required[$table] = true;
			}
		}
		
		foreach ($required as $table => $exists)
		{
			if (!$exists)
			{
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Connect to the database
	 * 
	 * @param string $host				The hostname the database is located at
	 * @param integer $port				The port the database is at
	 * @param string $user				Username for connecting
	 * @param string $pass				Password for connecting
	 * @param string $db				The database name
	 * @param boolean $new_link			TRUE for establishing a new link to the database, FALSE to re-use an existing one
	 * @param integer $client_flags		Database connection flags (see the PHP/MySQL documentation)
	 * @return boolean
	 */
	protected function _connect($host, $port, $user, $pass, $db, $new_link, $client_flags = null)
	{
		$this->_schema = null;
		
		$tmp = array();
		
		if ($host)
		{
			$tmp[] = 'host=' . $host;
		}
		
		if ((int) $port)
		{
			$tmp[] = 'port=' . (int) $port;
		}
		
		if ($user)
		{
			$tmp[] = 'user=' . $user;
		}
		
		if ($pass)
		{
			$tmp[] = 'password=' . $pass;
		}
			
		if ($db)
		{
			if (false !== strpos($db, '.'))
			{
				$explode = explode('.', $db);
				
				//$tmp[] = 'schema=' . $explode[0];
				
				$this->_schema = $explode[1];
				
				$tmp[] = 'dbname=' . $explode[0];
			}
			else
			{
				$tmp[] = 'dbname=' . $db;
			}
		}
		
		$str = implode(' ', $tmp);
		
		if ($new_link)
		{
			$this->_conn = pg_connect($str, PGSQL_CONNECT_FORCE_NEW);
		}
		else
		{
			$this->_conn = pg_connect($str);
		}
		
		if ($this->_schema)
		{
			//print('SETTING HERE: [' . $this->_schema . ']');
			
			$errnum = 0;
			$errmsg = null;
			$this->_query("SET search_path TO " . $this->_escape($this->_schema) . ', public', $errnum, $errmsg);
		}
		else
		{
			// Default to using the 'public' schema
			$this->_schema = 'public';
		}
		
		//$errnum = 0;
		//$errmsg = null;
		//print_r($this->_fetch($this->_query("SHOW search_path", $errnum, $errmsg)));
		//die('SCHEMA IS: ' . $this->_schema);
	}
	
	/**
	 * 
	 */
	protected function _fields($table)
	{
		$list = array();
		
		$sql = "
			SELECT 
				column_name 
			FROM 
				information_schema.columns
			WHERE
				table_name = '" . $this->_escape($table) . "' ";
		
		$errnum = 0;
		$errmsg = "";
		$res = $this->_query($sql, $errnum, $errmsg);
		while ($arr = $this->_fetch($res))
		{
			$list[] = current($arr);
		}
		
		return $list;
	}
	
	/**
	 * Fetch an array from a database result set
	 * 
	 * @param resource $res
	 * @return array
	 */
	protected function _fetch($res, $print = false)
	{
		$arr = pg_fetch_assoc($res);
		
		$booleans = array(
			QUICKBOOKS_DRIVER_SQL_FIELD_TO_SYNC,
			QUICKBOOKS_DRIVER_SQL_FIELD_TO_VOID,
			QUICKBOOKS_DRIVER_SQL_FIELD_TO_DELETE,
			QUICKBOOKS_DRIVER_SQL_FIELD_TO_SKIP,
			QUICKBOOKS_DRIVER_SQL_FIELD_FLAG_SKIPPED, 
			QUICKBOOKS_DRIVER_SQL_FIELD_FLAG_DELETED,
			QUICKBOOKS_DRIVER_SQL_FIELD_FLAG_VOIDED			
			);
		
		if ($arr)
		{
			foreach ($arr as $key => $value)
			{
				if (in_array($key, $booleans))
				{
					if ($value == 'f')
					{
						$value = false;
					}
					else if ($value == 't')
					{
						$value = true;
					}
					else
					{
						$value = null;
					}
					
					$arr[$key] = $value;
				}
			}
		}
		
		if (is_array($arr))
		{
			reset($arr);
		}
		
		/*
		if ($print)
		{
			print('{{');
			print_r($arr);
			die('}} OUTPUT STOP');
		}
		*/
		
		return $arr;
	}
	
	/**
	 * Query the database
	 * 
	 * @param string $sql
	 * @return resource
	 */
	protected function _query($sql, &$errnum, &$errmsg, $offset = 0, $limit = null)
	{
		if (strtoupper(substr(trim($sql), 0, 6)) != 'UPDATE')
		{
			// PostgreSQL does not support LIMIT for UPDATE queries
			
			if ($limit)
			{
				if ($offset)
				{
					$sql .= " LIMIT " . (int) $offset . ", " . (int) $limit;
				}
				else
				{
					$sql .= " LIMIT " . (int) $limit;
				}
			}
			else if ($offset)
			{
				// @todo Should this be implemented...?
			}		
		}
		
		// 
		$boolean_fixes = array(
			'qbsql_to_skip != 1' => 		' qbsql_to_skip <> TRUE ', 
			'qbsql_to_delete != 1' => 		' qbsql_to_delete <> TRUE ', 
			'qbsql_to_delete = 1' => 		' qbsql_to_delete = TRUE ', 
			'qbsql_flag_deleted != 1' => 	' qbsql_flag_deleted <> TRUE ', 
			'qbsql_to_void != 1' => 		' qbsql_to_void <> TRUE ', 
			'qbsql_to_void = 1' => 			' qbsql_to_void = TRUE ', 
			'qbsql_flag_voided != 1' => 	' qbsql_flag_voided <> TRUE ', 
			);
		
		$sql = str_replace(array_keys($boolean_fixes), array_values($boolean_fixes), $sql);
		
		// Run the query
		$res = pg_query($this->_conn, $sql);
		
		$this->_last_result = $res;
		
		if (!$res)
		{
			$errnum = -1;
			$errmsg = pg_last_error($this->_conn);
			
			trigger_error('PostgreSQL Error: ' . $errmsg . ', SQL: ' . $sql, E_USER_ERROR);
			return false;
		}
		
		return $res;
	}
	
	/**
	 * Issue a query to the SQL server
	 * 
	 * @param string $sql
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return resource
	 */
	/*public function query($sql, &$errnum, &$errmsg, $offset = 0, $limit = null)
	{
		return $this->_query($sql, $errnum, $errmsg, $offset, $limit);
	}*/
	
	/**
	 * Tell the number of rows the last run query affected
	 * 
	 * @return integer
	 */
	public function affected()
	{
		return pg_affected_rows($this->_last_result);
	}
	
	/**
	 * Tell the last inserted AUTO_INCREMENT value
	 * 
	 * @return integer
	 */
	public function last()
	{
        $errnum = 0;
        $errmsg = '';
        
        // get the current table's primary key
        $sql = "SELECT               
                pg_attribute.attname, 
                format_type(pg_attribute.atttypid, pg_attribute.atttypmod) 
            FROM pg_index, pg_class, pg_attribute 
            WHERE 
                pg_class.oid = '" . $this->last_insert_table . "'::regclass AND
                indrelid = pg_class.oid AND
                pg_attribute.attrelid = pg_class.oid AND 
                pg_attribute.attnum = any(pg_index.indkey)
                AND indisprimary";
        
        $res = $this->query($sql, $errnum, $errmsg);
        
        $sequence = pg_fetch_result($res, 0, 0);
        
        // get the last ID
        $sql = "select currval(pg_get_serial_sequence('" . $this->last_insert_table . "', '" . $sequence . "'));";
        
        $res = $this->query($sql, $errnum, $errmsg);
        
        $last_insert_id = pg_fetch_result($res, 0, 0);
        
		return $last_insert_id;
	}
	
	/**
	 * Tell the number of records in a result resource
	 * 
	 * @param resource $res
	 * @return integer
	 */
	public function count($res)
	{
		return $this->_count($res);
	}
	
	/**
	 * Escape a string
	 * 
	 * @param string $str
	 * @return string
	 */
	public function escape($str)
	{
		return $this->_escape($str);
	}
	
	/**
	 * Fetch a record from a result set
	 * 
	 * @param resource $res
	 * @return array
	 */
	public function fetch($res)
	{
		return $this->_fetch($res);
	}
	
	/**
	 * Rewind the result set
	 *
	 * @param resource $res
	 * @return boolean
	 */
	public function rewind($res)
	{
		if (pg_num_rows($res) > 0)
		{
			pg_fetch_assoc($res, 0);
		}
		
		return true;
	}
	
	/**
	 * Escape a string for the database
	 * 
	 * @param string $str
	 * @return string
	 */
	protected function _escape($str)
	{
		return pg_escape_string($this->_conn, $str);
	}
	
	/**
	 * Count the number of rows returned from the database
	 * 
	 * @param resource $res
	 * @return integer
	 */
	protected function _count($res)
	{
		return pg_num_rows($res);
	}
	
	/**
	 * Map a default SQL table name to a PostgreSQL table name
	 * 
	 * @param string
	 * @return string
	 */
	/**
	 * Map a default SQL table name to a MySQL table name
	 * 
	 * @param string
	 * @return string
	 */
	protected function _mapTableName($table)
	{
		switch ($table)
		{
			case QUICKBOOKS_DRIVER_SQL_LOGTABLE:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_PGSQL_LOGTABLE;
			case QUICKBOOKS_DRIVER_SQL_QUEUETABLE:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_PGSQL_QUEUETABLE;
			case QUICKBOOKS_DRIVER_SQL_RECURTABLE:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_PGSQL_RECURTABLE;
			case QUICKBOOKS_DRIVER_SQL_TICKETTABLE:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_PGSQL_TICKETTABLE;
			case QUICKBOOKS_DRIVER_SQL_USERTABLE:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_PGSQL_USERTABLE;
			case QUICKBOOKS_DRIVER_SQL_CONFIGTABLE:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_PGSQL_CONFIGTABLE;
			case QUICKBOOKS_DRIVER_SQL_IDENTTABLE:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_PGSQL_IDENTTABLE;				
			case QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_PGSQL_NOTIFYTABLE;
			case QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_PGSQL_CONNECTIONTABLE;
			default:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_PREFIX . $table;
		}
	}
	
	/**
	 * Map an encryption salt to a PostgreSQL-specific encryption salt
	 * 
	 * @param string $salt
	 * @return string
	 */
	protected function _mapSalt($salt)
	{
		switch ($salt)
		{
			case QUICKBOOKS_DRIVER_SQL_SALT:
				return QUICKBOOKS_DRIVER_SQL_PGSQL_SALT;
			default:
				return $salt;
		}
	}
	
	/**
	 * Override for the default SQL generation functions, PostgreSQL-specific field generation function
	 * 
	 * @param string $name
	 * @param array $def
	 * @return string
	 */
	protected function _generateFieldSchema($name, $def)
	{
		switch ($def[0])
		{
            case QUICKBOOKS_DRIVER_SQL_INTEGER:
				$sql = '"' . $name . '" INTEGER ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' DEFAULT NULL ';
					}
					else
					{
						$sql .= ' DEFAULT ' . (int) $def[2];
					}
				}
				
				break;
			case QUICKBOOKS_DRIVER_SQL_DECIMAL:
				$sql = '"' . $name . '" DECIMAL ';
		
				if (!empty($def[1]))
				{
					$tmp = explode(',', $def[1]);
					if (count($tmp) == 2)
					{
						$sql .= '(' . (int) $tmp[0] . ',' . (int) $tmp[1] . ') ';
					}
				}
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' NULL ';
					}
					else
					{
						if (isset($tmp) and count($tmp) == 2)
						{
							$sql .= ' DEFAULT ' . sprintf('%01.'. (int) $tmp[1] . 'f', (float) $def[2]);
						}
						else
						{
							$sql .= ' DEFAULT ' . sprintf('%01.2f', (float) $def[2]);
						}
					}
				}
				
				if (isset($tmp))
				{
					unset($tmp);
				}
				
				break;
			case QUICKBOOKS_DRIVER_SQL_FLOAT:
				$sql = '"' . $name . '" FLOAT ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' NULL ';
					}
					else
					{
						$sql .= ' DEFAULT ' . sprintf('%01.2f', (float) $def[2]);
					}
				}
				
				break;
			case QUICKBOOKS_DRIVER_SQL_BOOLEAN:
				$sql = '"' . $name . '" BOOLEAN ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' DEFAULT NULL ';
					}
					else if ($def[2])
					{
						$sql .= ' DEFAULT TRUE ';
					}
					else
					{
						$sql .= ' DEFAULT FALSE ';
					}
				}
				else
				{
					$sql .= ' NOT NULL ';
				}
				
				break;
			case QUICKBOOKS_DRIVER_SQL_SERIAL:
				$sql = '"' . $name . '" SERIAL NOT NULL '; // AUTO_INCREMENT 
				
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP:
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP_ON_INSERT_OR_UPDATE:
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP_ON_UPDATE:
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP_ON_INSERT:
			case QUICKBOOKS_DRIVER_SQL_DATETIME:
				
				$sql = '"' . $name . '" timestamp without time zone ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' DEFAULT NULL ';
					}
					else
					{
						$sql .= ' DEFAULT ' . $def[2] . ' NOT NULL ';
					}
				}
				else
				{
					$sql .= ' NOT NULL ';
				}
				

			/*case QUICKBOOKS_DRIVER_SQL_BOOLEAN:
				$sql = $name . ' tinyint(1) ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' DEFAULT NULL ';
					}
					else if ($def[2])
					{
						$sql .= ' DEFAULT 1 ';
					}
					else
					{
						$sql .= ' DEFAULT 0 ';
					}
				}
				
				return $sql;*/				
            case QUICKBOOKS_DRIVER_SQL_VARCHAR:
				$sql = '"' . $name . '" VARCHAR';
				
				/*if ($name == 'ListID')
				{
					print('LIST ID:');
					print_r($def);
				}*/
				
				if (!empty($def[1]))
				{
					$sql .= '(' . (int) $def[1] . ') ';
				}
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' DEFAULT NULL ';
					}
					else if ($def[2] === false)
					{
						$sql .= ' NOT NULL ';
					}
					else
					{
						$sql .= " NOT NULL DEFAULT '" . $def[2] . "' ";
					}
				}
				else
				{
					$sql .= ' NOT NULL ';
				}
				
				break;
			case QUICKBOOKS_DRIVER_SQL_CHAR:
				$sql = '"' . $name . '" CHAR';
				
				if (!empty($def[1]))
				{
					$sql .= '(' . (int) $def[1] . ') ';
				}
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' DEFAULT NULL ';
					}
					else
					{
						$sql .= " NOT NULL DEFAULT '" . $def[2] . "' ";
					}
				}
				else
				{
					$sql .= ' NOT NULL ';
				}
				
				break;
			default:
			case QUICKBOOKS_DRIVER_SQL_TEXT:
				$sql = '"' . $name . '" TEXT ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' DEFAULT NULL ';
					}
					else
					{
						$sql .= " NOT NULL DEFAULT '" . $def[2] . "' ";
					}
				}
				else
				{
					$sql .= ' NOT NULL ';
				}
				
				break;
		}
        return $sql;
	}
	
	/**
	 * Override for the default SQL generation functions, PostgreSQL-specific field generation function
	 * 
	 * @param string $name
	 * @param array $arr
	 * @param array $primary
	 * @param array $keys
	 * @return array
	 */
	protected function _generateCreateTable($name, $arr, $primary = array(), $keys = array(), $uniques = array(), $if_not_exists = true)
	{
		$arr_sql = parent::_generateCreateTable('"' . $name . '"', $arr, $primary, $keys, $if_not_exists);
		
		if (is_array($primary) and count($primary) == 1)
		{
			$primary = current($primary);
		}
		
		if (is_array($primary))
		{
			//ALTER TABLE  `quickbooks_ident` ADD PRIMARY KEY (  `qb_action` ,  `unique_id` )
			//$arr_sql[] = 'ALTER TABLE ' . $name . ' ADD PRIMARY KEY ( ' . implode(', ', $primary) . ' ) ';
		}
		else if ($primary)
		{
			$arr_sql[] = 'ALTER TABLE ONLY "' . $name . '" 
				ADD CONSTRAINT "' . $name . '_pkey" PRIMARY KEY ("' . $primary . '");';
		}
		
		foreach ($keys as $key)
		{
			if (is_array($key))		// compound key
			{
				$arr_sql[] = 'CREATE INDEX "' . implode('_', $key) . '_' . $name . '_index" ON "' . $name . '" USING btree ("' . implode('", "', $key) . '")';
			}
			else
			{
				$arr_sql[] = 'CREATE INDEX "' . $key . '_' . $name . '_index" ON "' . $name . '" USING btree ("' . $key . '")';
			}
		}
		
		return $arr_sql;
	}
	
	public function foldsToLower()
	{
		return true;
	}

    
    /**
	 * Insert a new record into an SQL table
	 * 
	 * @param string $table
	 * @param object $object
	 * @return boolean
	 */
	public function insert($table, $object, $discov_and_resync = true)
    {
        $this->last_insert_table = $table;
        
        return parent::insert($table, $object, $discov_and_resync);
    }
}
