<?php

/**
 * MySQL backend for the QuickBooks SOAP server
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
 * This backend driver is for a MySQL database. You can use the 
 * {@see QuickBooks_Utilities} class to initalize the five tables in the MySQL 
 * database. 
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

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_SALT'))
{
	/**
	 * Salt used when hashing to create ticket values
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_SALT', QUICKBOOKS_DRIVER_SQL_SALT);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX'))
{
	/**
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX', QUICKBOOKS_DRIVER_SQL_PREFIX);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_QUEUETABLE'))
{
	/**
	 * MySQL table name to store queued requests in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_QUEUETABLE', QUICKBOOKS_DRIVER_SQL_QUEUETABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_USERTABLE'))
{
	/**
	 * MySQL table name to store usernames/passwords for the QuickBooks SOAP server
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_USERTABLE', QUICKBOOKS_DRIVER_SQL_USERTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_TICKETTABLE'))
{
	/**
	 * The table name to store session tickets in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_TICKETTABLE', QUICKBOOKS_DRIVER_SQL_TICKETTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_LOGTABLE'))
{
	/**
	 * The table name to store log data in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_LOGTABLE', QUICKBOOKS_DRIVER_SQL_LOGTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_RECURTABLE'))
{
	/**
	 * The table name to store recurring events in
	 * 
	 * @var string
	 */
	 define('QUICKBOOKS_DRIVER_SQL_MYSQL_RECURTABLE', QUICKBOOKS_DRIVER_SQL_RECURTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_IDENTTABLE'))
{
	/**
	 * The table name to store identifiers in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_IDENTTABLE', QUICKBOOKS_DRIVER_SQL_IDENTTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_CONFIGTABLE'))
{
	/**
	 * The table name to store configuration options in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_CONFIGTABLE', QUICKBOOKS_DRIVER_SQL_CONFIGTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_NOTIFYTABLE'))
{
	/**
	 * The table name to store notifications in
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_NOTIFYTABLE', QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_MYSQL_CONNECTIONTABLE'))
{
	/**
	 * The table name to store connection data in 
	 *
	 * @var string
	 */
	define('QUICKBOOKS_DRIVER_SQL_MYSQL_CONNECTIONTABLE', QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE);
}

/**
 * QuickBooks MySQL back-end driver
 */
class QuickBooks_Driver_Sql_Mysql extends QuickBooks_Driver_Sql
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
	 * Create a new MySQL back-end driver
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
				'scheme' => 'mysql', 
				'host' => 'localhost', 
				'port' => 3306, 
				'user' => 'root', 
				'pass' => '', 
				'path' => '/quickbooks',
				);
			
			$parse = QuickBooks_Utilities::parseDSN($dsn_or_conn, $defaults);
			
			//print_r($parse);
			
			$this->_connect($parse['host'], $parse['port'], $parse['user'], $parse['pass'], substr($parse['path'], 1), $config['new_link'], $config['client_flags']);
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
		$res = $this->_query("SHOW TABLES ", $errnum, $errmsg);
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
		if ($port)
		{
			$this->_conn = mysql_connect($host . ':' . $port, $user, $pass, $new_link, $client_flags) or die('host: ' . $host . ', user: ' . $user . ', pass: XXXX, mysql_error(): ' . mysql_error());
		}
		else
		{
			$this->_conn = mysql_connect($host, $user, $pass, $new_link, $client_flags) or die('host: ' . $host . ', user: ' . $user . ', pass: XXXX, mysql_error(): ' . mysql_error());
		}
			
		// Select the correct database
		$tmp = mysql_select_db($db, $this->_conn) or die(mysql_error());
		
		// Support UTF-8 chars
		mysql_query("SET NAMES 'utf8'", $this->_conn);
		
		/*
		static $connections = array();
		$connections[] = $user . ':' . $pass . '@' . $host . ':' . $port . '/' . $db;
		mysql_query("INSERT INTO quickbooks_log ( msg, log_datetime ) VALUES ( 'MySQL connection #" . count($connections) . ", " . print_r($connections, true) . "', NOW() )", $this->_conn) or die(mysql_error());
		*/
		
		return $tmp;
	}
	
	/**
	 * Fetch an array from a database result set
	 * 
	 * @param resource $res
	 * @return array
	 */
	protected function _fetch($res)
	{
		return mysql_fetch_assoc($res);
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
		
		//print($sql . "\n\n");
		$res = mysql_query($sql, $this->_conn);
		//mysql_query("INSERT INTO quickbooks_log ( msg, log_datetime ) VALUES ( '" . mysql_real_escape_string($sql) . "', NOW() ) ");
		
		/*
		CREATE TABLE quickbooks_debug (
		  quickbooks_debug_id int(10) unsigned NOT NULL AUTO_INCREMENT,
		  msg text NOT NULL,
		  debug_datetime datetime NOT NULL,
		  PRIMARY KEY (quickbooks_debug_id)
		) ENGINE=MyISAM
		*/
		
		// Debugging... 
		/*
		mysql_query("
			INSERT INTO
				quickbooks_debug
			(
				msg, 
				debug_datetime 
			)
			VALUES
			(
				'" . $this->_escape($sql) . "', 
				NOW() 
			)");
		*/
		
		if (!$res)
		{
			$errnum = mysql_errno($this->_conn);
			$errmsg = mysql_error($this->_conn);
			
			//print($sql);
			
			trigger_error('Error Num.: ' . $errnum . "\n" . 'Error Msg.:' . $errmsg . "\n" . 'SQL: ' . $sql, E_USER_ERROR);
			return false;
		}
		
		return $res;
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected function _fields($table)
	{
		$sql = "SHOW FIELDS FROM " . $table;
		
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
		return mysql_affected_rows($this->_conn);
	}
	
	/**
	 * Tell the last inserted AUTO_INCREMENT value
	 * 
	 * @return integer
	 */
	public function last()
	{
		return mysql_insert_id($this->_conn);
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
		if (mysql_num_rows($res) > 0)
		{
			return mysql_data_seek($res, 0);
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
		return mysql_real_escape_string($str, $this->_conn);
	}
	
	/**
	 * Count the number of rows returned from the database
	 * 
	 * @param resource $res
	 * @return integer
	 */
	protected function _count($res)
	{
		return mysql_num_rows($res);
	}
	
	/**
	 * Override for the default SQL generation functions, MySQL-specific field generation function
	 * 
	 * @param string $name
	 * @param array $def
	 * @return string
	 */
	protected function _generateFieldSchema($name, $def)
	{
		switch ($def[0])
		{
			case QUICKBOOKS_DRIVER_SQL_SERIAL:
				
				$sql = $name . ' int(10) unsigned NOT NULL '; // AUTO_INCREMENT 
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP:
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP_ON_INSERT_OR_UPDATE:
				
				$sql = $name . ' TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ';
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP_ON_UPDATE:
				
				$sql = $name . ' TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP ';
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_TIMESTAMP_ON_INSERT:
				
				$sql = $name . ' TIMESTAMP DEFAULT CURRENT_TIMESTAMP ';
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_BOOLEAN:
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
				
				return $sql;
			case QUICKBOOKS_DRIVER_SQL_INTEGER:
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
				
				return $sql;
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
				return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MYSQL_LOGTABLE;
			case QUICKBOOKS_DRIVER_SQL_QUEUETABLE:
				return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MYSQL_QUEUETABLE;
			case QUICKBOOKS_DRIVER_SQL_RECURTABLE:
				return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MYSQL_RECURTABLE;
			case QUICKBOOKS_DRIVER_SQL_TICKETTABLE:
				return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MYSQL_TICKETTABLE;
			case QUICKBOOKS_DRIVER_SQL_USERTABLE:
				return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MYSQL_USERTABLE;
			case QUICKBOOKS_DRIVER_SQL_CONFIGTABLE:
				return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MYSQL_CONFIGTABLE;
			//case QUICKBOOKS_DRIVER_SQL_IDENTTABLE:
			//	return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MYSQL_IDENTTABLE;
			//case QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE:
			//	return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MYSQL_NOTIFYTABLE;
			//case QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE:
			//	return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . QUICKBOOKS_DRIVER_SQL_MYSQL_CONNECTIONTABLE;
			default:
				return QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX . $table;
		}
	}
	
	protected function _mapSalt($salt)
	{
		switch ($salt)
		{
			case QUICKBOOKS_DRIVER_SQL_SALT:
				return QUICKBOOKS_DRIVER_SQL_MYSQL_SALT;
			default:
				return $salt;
		}
	}
	
	protected function _generateCreateTable($name, $arr, $primary = array(), $keys = array(), $uniques = array(), $if_not_exists = true)
	{
		$arr_sql = parent::_generateCreateTable($name, $arr, $primary, $keys, $uniques, $if_not_exists);
		
		if (is_array($primary) and count($primary) == 1)
		{
			$primary = current($primary);
		}
		
		if (is_array($primary))
		{
			//ALTER TABLE  `quickbooks_ident` ADD PRIMARY KEY (  `qb_action` ,  `unique_id` )
			$arr_sql[] = 'ALTER TABLE ' . $name . ' ADD PRIMARY KEY ( ' . implode(', ', $primary) . ' ) ';
		}
		else if ($primary)
		{
			$arr_sql[] = 'ALTER TABLE ' . $name . ' ADD PRIMARY KEY(' . $primary . '); ';
			
			if ($arr[$primary][0] == QUICKBOOKS_DRIVER_SQL_SERIAL)
			{
				// add the auto-increment
				$arr_sql[] = 'ALTER TABLE ' . $name . ' CHANGE ' . $primary . ' ' . $primary . ' INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;';
			}
		}
		
		foreach ($keys as $key)
		{
			if (is_array($key))		// compound key
			{
				$arr_sql[] = 'ALTER TABLE ' . $name . ' ADD INDEX(' . implode(', ', $key) . ');';
			}
			else
			{
				$arr_sql[] = 'ALTER TABLE ' . $name . ' ADD INDEX(' . $key . ');';
			}
		}
		
		return $arr_sql;
	}
}
