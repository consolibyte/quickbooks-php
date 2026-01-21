<?php

/**
 * SQLite backend for the QuickBooks SOAP server
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

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_SALT'))
{
    /**
     * Salt used when hashing to create ticket values
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_SALT', QUICKBOOKS_DRIVER_SQL_SALT);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX'))
{
    /**
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX', QUICKBOOKS_DRIVER_SQL_PREFIX);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_QUEUETABLE'))
{
    /**
     * MySQL table name to store queued requests in
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_QUEUETABLE', QUICKBOOKS_DRIVER_SQL_QUEUETABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_USERTABLE'))
{
    /**
     * MySQL table name to store usernames/passwords for the QuickBooks SOAP server
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_USERTABLE', QUICKBOOKS_DRIVER_SQL_USERTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_TICKETTABLE'))
{
    /**
     * The table name to store session tickets in
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_TICKETTABLE', QUICKBOOKS_DRIVER_SQL_TICKETTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_LOGTABLE'))
{
    /**
     * The table name to store log data in
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_LOGTABLE', QUICKBOOKS_DRIVER_SQL_LOGTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_RECURTABLE'))
{
    /**
     * The table name to store recurring events in
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_RECURTABLE', QUICKBOOKS_DRIVER_SQL_RECURTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_IDENTTABLE'))
{
    /**
     * The table name to store identifiers in
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_IDENTTABLE', QUICKBOOKS_DRIVER_SQL_IDENTTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_CONFIGTABLE'))
{
    /**
     * The table name to store configuration options in
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_CONFIGTABLE', QUICKBOOKS_DRIVER_SQL_CONFIGTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_NOTIFYTABLE'))
{
    /**
     * The table name to store notifications in
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_NOTIFYTABLE', QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE);
}

if (!defined('QUICKBOOKS_DRIVER_SQL_SQLITE_CONNECTIONTABLE'))
{
    /**
     * The table name to store connection data in
     *
     * @var string
     */
    define('QUICKBOOKS_DRIVER_SQL_SQLITE_CONNECTIONTABLE', QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE);
}

/**
 * QuickBooks MySQL back-end driver
 */
class QuickBooks_Driver_Sql_Sqlite extends QuickBooks_Driver_Sql
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
     *
     */
    protected $_database;

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
            $trim = false;
            if (false === strpos($dsn_or_conn, ':///'))
            {
                $dsn_or_conn = str_replace('://', '://localhost/', $dsn_or_conn);
                $trim = true;
            }

            $defaults = array(
                'scheme' => 'mysql',
                'host' => 'localhost',
                'port' => 3306,
                'user' => 'root',
                'pass' => '',
                'path' => '/quickbooks',
            );

            $parse = QuickBooks_Utilities::parseDSN($dsn_or_conn, $defaults);

            if ($trim)
            {
                $parse['path'] = substr($parse['path'], 1);
            }

            //print_r($parse);
            //exit;

            $this->_connect($parse['host'], $parse['port'], $parse['user'], $parse['pass'], $parse['path'], $config['new_link'], $config['client_flags']);
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
            $this->_mapTableName(QUICKBOOKS_DRIVER_SQL_IDENTTABLE) => false,
            $this->_mapTableName(QUICKBOOKS_DRIVER_SQL_TICKETTABLE) => false,
            $this->_mapTableName(QUICKBOOKS_DRIVER_SQL_USERTABLE) => false,
            $this->_mapTableName(QUICKBOOKS_DRIVER_SQL_RECURTABLE) => false,
            $this->_mapTableName(QUICKBOOKS_DRIVER_SQL_QUEUETABLE) => false,
            $this->_mapTableName(QUICKBOOKS_DRIVER_SQL_LOGTABLE) => false,
            $this->_mapTableName(QUICKBOOKS_DRIVER_SQL_CONFIGTABLE) => false,
            $this->_mapTableName(QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE) => false,
            $this->_mapTableName(QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE) => false,
        );

        $errnum = 0;
        $errmsg = '';
        $res = $this->_query("SELECT * FROM sqlite_master WHERE type = 'table' ", $errnum, $errmsg);
        while ($arr = $this->_fetch($res))
        {
            $table = $arr['tbl_name'];

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
        $this->_conn = sqlite_open($db) or die('db: ' . $db . '');

        return true;
    }

    /**
     * Fetch an array from a database result set
     *
     * @param resource $res
     * @return array
     */
    protected function _fetch($res)
    {
        return sqlite_fetch_array($res, SQLITE_ASSOC);
    }

    /**
     * Query the database
     *
     * @param string $sql
     * @return resource
     */
    protected function _query($sql, &$errnum, &$errmsg, $offset = 0, $limit = null)
    {
        if ($limit and strtoupper(substr(trim($sql), 0, 6)) == 'SELECT')
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
        else if ($offset and strtoupper(substr(trim($sql), 0, 6)) == 'SELECT')
        {
            // @todo Should this be implemented...?
        }

        $res = sqlite_query($this->_conn, $sql);

        if (!$res)
        {
            //$errnum = mysql_errno($this->_conn);
            //$errmsg = mysql_error($this->_conn);
            $errnum = -99;
            $errmsg = 'SQLLite Query Error';

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
        //return mysql_affected_rows($this->_conn);
        return 0;
    }

    /**
     * Tell the last inserted AUTO_INCREMENT value
     *
     * @return integer
     */
    public function last()
    {
        //return mysql_insert_id($this->_conn);
        return sqlite_last_insert_rowid($this->_conn);
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
        sqlite_rewind($res);
    }

    /**
     * Escape a string for the database
     *
     * @param string $str
     * @return string
     */
    protected function _escape($str)
    {
        //return mysql_real_escape_string($str, $this->_conn);
        return sqlite_escape_string($str);
    }

    /**
     * Count the number of rows returned from the database
     *
     * @param resource $res
     * @return integer
     */
    protected function _count($res)
    {
        //return mysql_num_rows($res);
        return sqlite_num_rows($res);
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

                $sql = $name . ' INTEGER PRIMARY KEY  '; // AUTO_INCREMENT
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
                $sql = $name . ' int(10) ';

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
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . QUICKBOOKS_DRIVER_SQL_SQLITE_LOGTABLE;
            case QUICKBOOKS_DRIVER_SQL_QUEUETABLE:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . QUICKBOOKS_DRIVER_SQL_SQLITE_QUEUETABLE;
            case QUICKBOOKS_DRIVER_SQL_RECURTABLE:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . QUICKBOOKS_DRIVER_SQL_SQLITE_RECURTABLE;
            case QUICKBOOKS_DRIVER_SQL_TICKETTABLE:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . QUICKBOOKS_DRIVER_SQL_SQLITE_TICKETTABLE;
            case QUICKBOOKS_DRIVER_SQL_USERTABLE:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . QUICKBOOKS_DRIVER_SQL_SQLITE_USERTABLE;
            case QUICKBOOKS_DRIVER_SQL_CONFIGTABLE:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . QUICKBOOKS_DRIVER_SQL_SQLITE_CONFIGTABLE;
            case QUICKBOOKS_DRIVER_SQL_IDENTTABLE:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . QUICKBOOKS_DRIVER_SQL_SQLITE_IDENTTABLE;
            case QUICKBOOKS_DRIVER_SQL_NOTIFYTABLE:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . QUICKBOOKS_DRIVER_SQL_SQLITE_NOTIFYTABLE;
            case QUICKBOOKS_DRIVER_SQL_CONNECTIONTABLE:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . QUICKBOOKS_DRIVER_SQL_SQLITE_CONNECTIONTABLE;
            default:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_PREFIX . $table;
        }
    }

    protected function _mapSalt($salt)
    {
        switch ($salt)
        {
            case QUICKBOOKS_DRIVER_SQL_SALT:
                return QUICKBOOKS_DRIVER_SQL_SQLITE_SALT;
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

        /*
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
        */

        return $arr_sql;
    }
}