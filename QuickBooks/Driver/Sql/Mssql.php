<?php

/**
 * Microsoft SQL Server backend for the QuickBooks SOAP server
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
 * This backend driver is for a Microsoft SQL Server database. You can use the 
 * {@see QuickBooks_Utilities} class to initalize the tables in the Microsoft 
 * SQL database. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 *  
 * @package QuickBooks
 * @subpackage Driver
 */

/**
 * Base QuickBooks constants
 */
require_once 'QuickBooks.php';

/**
 * QuickBooks driver base class
 */
require_once 'QuickBooks/Driver.php';

/**
 * QuickBooks driver SQL base class
 */
require_once 'QuickBooks/Driver/Sql.php';

/**
 * QuickBooks utilities class
 */
require_once 'QuickBooks/Utilities.php';

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_SALT'))
{
	/**
	 * Salt used when hashing to create ticket values
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_SALT', QUICKBOOKS_DRIVER_SQL_SALT);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX'))
{
	/**
	 * 
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX', QUICKBOOKS_DRIVER_SQL_PREFIX);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_QUEUETABLE'))
{
	/**
	 * MySQL table name to store queued requests in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_QUEUETABLE', QUICKBOOKS_DRIVER_SQL_QUEUETABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_USERTABLE'))
{
	/**
	 * MySQL table name to store usernames/passwords for the QuickBooks SOAP server
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_USERTABLE', QUICKBOOKS_DRIVER_SQL_USERTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_TICKETTABLE'))
{
	/**
	 * The table name to store session tickets in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_TICKETTABLE', QUICKBOOKS_DRIVER_SQL_TICKETTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_LOGTABLE'))
{
	/**
	 * The table name to store log data in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_LOGTABLE', QUICKBOOKS_DRIVER_SQL_LOGTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_RECURTABLE'))
{
	/**
	 * The table name to store recurring events in
	 * 
	 * @var string
	 */
	 define('QUICKBOOKS_DRIVER_SQL_MSSQL_RECURTABLE', QUICKBOOKS_DRIVER_SQL_RECURTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_IDENTTABLE'))
{
	/**
	 * The table name to store identifiers in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_IDENTTABLE', QUICKBOOKS_DRIVER_SQL_IDENTTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_CONFIGTABLE'))
{
	/**
	 * The table name to store configuration options in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_CONFIGTABLE', QUICKBOOKS_DRIVER_SQL_CONFIGTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_NOTIFYTABLE'))
{
	/**
	 * The table name to store notifications in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_NOTIFYTABLE', QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_CONNECTIONTABLE'))
{
	/**
	 * The table name to store connection data in 
	 *
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_CONNECTIONTABLE', QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_OAUTHTABLE'))
{
	/**
	 * The table name to store oauth data in 
	 *
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_OAUTHTABLE', QUICKBOOKS_DRIVER_SQL_OAUTHTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_MESSAGE_LEVEL'))
{
	/**
	 * Define the default message level to set the SQL server connection to (set to 17 to ignore notices)
	 * 
	 * @var integer
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_MESSAGE_LEVEL', 1);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MSSQL_ERROR_LEVEL'))
{
	/**
	 * Define the minimum error level MS SQL will report
	 *
	 * @var integer
	 */
	define('QUICKBOOKS_DRIVER_SQL_MSSQL_ERROR_LEVEL', 0);
}

/**
 * QuickBooks MySQL back-end driver
 */
class QuickBooks_Driver_Sql_Mssql extends QuickBooks_Driver_Sql
{
	/**
	 * MySQL connection resource
	 * 
	 * @var resource
	 */
	protected $_conn;
	
	/**
	 * Log level (debug, verbose, normal)
	 * 
	 * @var integer
	 */
	protected $_log_level;
	
	/**
	 * User-defined hook functions
	 * 
	 * @var array 
	 */
	protected $_hooks;
	
	/**
	 * Create a new Microsoft SQL Server back-end driver
	 * 
	 * @param string $dsn		A DSN-style connection string (i.e.: "mysql://your-mysql-username:your-mysql-password@your-mysql-host:port/your-mysql-database")
	 * @param array $config		Configuration options for the driver (not currently supported)
	 */
	public function __construct($dsn_or_conn, $config)
	{
		$config = $this->_defaults($config);
		$this->_log_level = (int) $config['log_level'];
		
		if (is_resource($dsn_or_conn))
		{
			$this->_conn = $dsn_or_conn;
		}
		else
		{
			$defaults = array(
				'scheme' => 'mssql', 
				'host' => 'localhost', 
				'port' => 1433, 
				'user' => 'admin', 
				'pass' => '', 
				'path' => '/quickbooks',
				);
			
			$parse = QuickBooks_Utilities::parseDSN($dsn_or_conn, $defaults);
			
			$this->_connect($parse['host'], $parse['port'], $parse['user'], $parse['pass'], substr($parse['path'], 1), $config['new_link'], $config['client_flags']);
		}
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
			'log_level' => QUICKBOOKS_LOG_NORMAL,
			'client_flags' => 0, 
			'new_link' => true, 
			);
		
		return array_merge($defaults, $config);
	}
	
	/**
	 * Tell whether or not the SQL driver has been initialized
	 * 
	 * @return boolean
	 */
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
				table_name AS name 
			FROM
				INFORMATION_SCHEMA.Tables 
			WHERE 
				TABLE_TYPE = 'BASE TABLE' ", $errnum, $errmsg);
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
	protected function _connect($host, $port, $user, $pass, $db, $new_link, $client_flags)
	{
		mssql_min_message_severity(QUICKBOOKS_DRIVER_SQL_MSSQL_MESSAGE_LEVEL);
		mssql_min_error_severity(QUICKBOOKS_DRIVER_SQL_MSSQL_ERROR_LEVEL);
		
		if ($port)
		{
			$this->_conn = mssql_connect($host, $user, $pass, $new_link) or die('host: ' . $host . ', user: ' . $user . ', pass: ' . $pass . ' mysql_error(): ' . mssql_get_last_message());
		}
		else
		{
			$this->_conn = mssql_connect($host . ':' . $port, $user, $pass, $new_link) or die('host: ' . $host . ', user: ' . $user . ', pass: ' . $pass . ' mysql_error(): ' . mssql_get_last_message());
		}
		
		return mssql_select_db($db, $this->_conn);
	}
	
	/**
	 * Fetch an array from a database result set
	 * 
	 * @param resource $res
	 * @return array
	 */
	protected function _fetch($res)
	{
		$arr = mssql_fetch_assoc($res);
		
		// What's going on with this...? 
		foreach ($arr as $key => $value)
		{
			$arr[$key] = trim($value);
		}
		
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
		if ($limit)
		{
			$sql = str_replace(array( "SELECT ", "SELECT\n", "SELECT\r" ), 'SELECT TOP ' . (int) $limit . ' ' . "\n", $sql);
			
			/*
select * from (
 select top 10 emp_id,lname,fname from (
    select top 30 emp_id,lname,fname
    from employee
   order by lname asc
 ) as newtbl order by lname desc
) as newtbl2 order by lname asc			
			*/
			
			if ($offset)
			{
				
			}
			else
			{
				
			}
		}
		else if ($offset)
		{
			// @todo Does this need to be implemented...?
		}
		
		$res = mssql_query($sql, $this->_conn);
		
		if (!$res)
		{
			$errnum = 1;
			$errmsg = mssql_get_last_message();
			
			//print($sql);
			
			trigger_error('Error: ' . $errmsg . "\n" . 'SQL: ' . $sql, E_USER_ERROR);
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
		return mssql_rows_affected($this->_conn);
	}
	
	/**
	 * Tell the last inserted AUTO_INCREMENT value
	 * 
	 * @return integer
	 */
	public function last()
	{
		$errnum = 0;
		$errmsg = null;
		if ($res = $this->_query("SELECT SCOPE_IDENTITY() AS last_insert_id"))
		{
			$arr = $this->_fetch($res);
			return $arr['last_insert_id'];
		}
		
		return 0;
	}
	
	/**
	 * Rewind the result set
	 *
	 * @param resource $res
	 * @return boolean
	 */
	public function rewind($res)
	{
		if (mssql_num_rows($res) > 0)
		{
			return mssql_data_seek($res, 0);
		}
		
		return true;
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
	 * Escape a string for the database
	 * 
	 * @param string $str
	 * @return string
	 */
	protected function _escape($str)
	{
		$str = str_replace("\0", '[NULL]', $str);
		$str = str_replace("'", "''", $str);
		
		return $str;
	}
	
	/**
	 * Count the number of rows returned from the database
	 * 
	 * @param resource $res
	 * @return integer
	 */
	protected function _count($res)
	{
		return mssql_num_rows($res);
	}
	
	/**
	 * Override for the default SQL generation functions, MSSQL-specific field generation function
	 * 
	 * The Microsoft SQL Server PHP module is retarded, and for some reason 
	 * decides to cast anything as DEFAULT NULL unless you specify them just as 
	 * NULL. Specifying DEFAULT NULL doesn't work. This is contrary to the 
	 * actual SQL Server Studio tool, which actually works like it should. 
	 * 
	 * WTF? Seriously, I just wasted like 4 hours trying to figure out what I 
	 * did wrong, and it turns out the stupid module is just stupid. 
	 * 
	 * @param string $name
	 * @param array $def
	 * @return string
	 */
	protected function _generateFieldSchema($name, $def)
	{
		$sql = '';
		switch ($def[0])
		{
			case QUICKBOOKS_DRIVER_SQL_SERIAL:
				
				$sql = $name . ' integer NOT NULL IDENTITY(1, 1) '; // AUTO_INCREMENT 
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP:
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP_ON_INSERT_OR_UPDATE:
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP_ON_UPDATE:
				
				$sql = $name . ' TIMESTAMP ';
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_DATETIME:
			case QUICKBOOKS_DRIVER_SQL_DATE:
				$sql = $name . ' DATETIME ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' NULL ';
					}
				}
				else
				{
					$sql .= ' NOT NULL ';
				}
				
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_VARCHAR:
				$sql = $name . ' VARCHAR';
				
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
						$sql .= ' NULL ';
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
				
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_CHAR:
				$sql = $name . ' CHAR';
				
				if (!empty($def[1]))
				{
					$sql .= '(' . (int) $def[1] . ') ';
				}
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' NULL ';
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
				
				return $sql;		
			case QUICKBOOKS_DRIVER_SQL_TEXT:
				$sql = $name . ' TEXT ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' NULL ';
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
				
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_INTEGER:
				
				$sql = $name . ' INTEGER ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' NULL ';
					}
					else
					{
						$sql .= ' DEFAULT ' . (int) $def[2];
					}
				}
				
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_BOOLEAN:
				$sql = $name . ' tinyint ';
				
				if (isset($def[2]))
				{
					if (strtolower($def[2]) == 'null')
					{
						$sql .= ' NULL ';
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
				
				return $sql;
			/*case QUICKBOOKS_DRIVER_SQL_INTEGER:
				$sql = $name . ' int(10) unsigned ';
				
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
				else
				{
					$sql .= ' NOT NULL ';
				}
				
				return $sql;*/
			default:
				
				return parent::_generateFieldSchema($name, $def);
		}
	}
	
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
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_LOGTABLE;
			case QUICKBOOKS_DRIVER_SQL_QUEUETABLE:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_QUEUETABLE;
			case QUICKBOOKS_DRIVER_SQL_RECURTABLE:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_RECURTABLE;
			case QUICKBOOKS_DRIVER_SQL_TICKETTABLE:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_TICKETTABLE;
			case QUICKBOOKS_DRIVER_SQL_USERTABLE:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_USERTABLE;
			case QUICKBOOKS_DRIVER_SQL_CONFIGTABLE:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_CONFIGTABLE;
			case QUICKBOOKS_DRIVER_SQL_IDENTTABLE:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_IDENTTABLE;				
			case QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_NOTIFYTABLE;
			case QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_CONNECTIONTABLE;
			case QUICKBOOKS_DRIVER_SQL_OAUTHTABLE:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MSSQL_OAUTHTABLE;
			default:
				return $table;
		}
	}
	
	protected function _mapSalt($salt)
	{
		switch ($salt)
		{
			case QUICKBOOKS_DRIVER_SQL_SALT:
				return QUICKBOOKS_DRIVER_SQL_MSSQL_SALT;
			default:
				return $salt;
		}
	}
	
	protected function _fields($table)
	{
		$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'" . $table . "'";
		
		$list = array();
		
		$errnum = 0;
		$errmsg = '';
		$res = $this->_query($sql, $errnum, $errmsg);
		while ($arr = $this->_fetch($res))
		{
			$list[] = current($arr);
		}

		return $list;
	}
}
