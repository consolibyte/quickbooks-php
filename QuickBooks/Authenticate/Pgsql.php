<?php

/**
 * Authenticate QuickBooks Web Connector users via a PostgreSQL database
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Authenticate
 */

/**
 * Authenticate interface
 */
require_once 'QuickBooks/Authenticate.php';

/**
 * Utilities for parsing DSN strings
 */
require_once 'QuickBooks/Utilities.php';

/**
 * Authenticate QuickBooks Web Connector users via a PostgreSQL database
 * 
 * This is a custom authentication handler 
 */
class QuickBooks_Authenticate_Pgsql implements QuickBooks_Authenticate
{
	/**
	 * 
	 */
	protected $_table_name;
	
	/**
	 * 
	 */
	protected $_field_username;
	
	/**
	 * 
	 */
	protected $_field_password;
	
	/**
	 * Callback function to use for hashing/encryption
	 * @var string
	 */
	protected $_crypt_function;
	
	/**
	 * PostgreSQL database connection resource
	 * @var resource
	 */
	protected $_conn;
	
	/**
	 * Field name that holds company files
	 * @var string
	 */
	protected $_field_company_file;
	
	/**
	 * Field name that holds an integer indicating to wait N seconds before the next update
	 * @var integer 
	 */
	protected $_field_wait_before_next_update;
	
	/**
	 * Field name that holds an integer indicating to run only ever N seconds (or slower)
	 * @var integer
	 */
	protected $_field_min_run_every_n_seconds;
	
	/**
	 * Create a new PostgreSQL database authenticator
	 * 
	 * @param string $dsn		A DSN-style connection string for PostgreSQL (i.e.: pgsql://username:password@hostname:port/database)
	 */
	public function __construct($dsn)
	{
		$conn_defaults = array(
			'scheme' => 'pgsql', 
			'user' => 'pgsql', 
			'pass' => '',
			'host' => 'localhost',  
			'port' => 5432,
			'path' => '/quickbooks',  
			'query' => '', 
			);
		
		$param_defaults = array(
			'table_name' => 'quickbooks_user', 
			'field_username' => 'qb_username', 
			'field_password' => 'qb_password', 
			'crypt_function' => 'sha1', 
			'field_company_file' => null, 
			'field_wait_before_next_update' => null, 
			'field_min_run_every_n_seconds' => null, 
			);
		
		// mysql://user:pass@localhost:port/database?table_name=quickbooks_user&field_username=username&field_password=password&crypt_function=md5
		$parse = QuickBooks_Utilities::parseDSN($dsn, $conn_defaults);
		
		$vars = array();
		parse_str($parse['query'], $vars);
		
		$param_defaults = array_merge($param_defaults, $vars);
		
		$conn_str = '';
		if (strlen($parse['host']))
		{
			$conn_str .= ' host=' . $parse['host'];
		}
		
		if (strlen($parse['port']))
		{
			$conn_str .= ' port=' . (int) $parse['port'];
		}
		
		if (strlen($parse['user']))
		{
			$conn_str .= ' user=' . $parse['user'];
		}
		
		if (strlen($parse['pass']))
		{
			$conn_str .= ' password=' . $parse['pass'];
		}
		
		$conn_str .= ' dbname=' . substr($parse['path'], 1);
		
		$this->_conn = pg_connect($conn_str, PGSQL_CONNECT_FORCE_NEW);
		
		$this->_table_name = pg_escape_string($this->_conn, $param_defaults['table_name']);
		$this->_field_username = pg_escape_string($this->_conn, $param_defaults['field_username']);
		$this->_field_password = pg_escape_string($this->_conn, $param_defaults['field_password']);
		$this->_crypt_function = $param_defaults['crypt_function'];
		
		$this->_field_company_file = $param_defaults['field_company_file'];
		$this->_field_wait_before_next_update = $param_defaults['field_wait_before_next_update'];
		$this->_field_min_run_every_n_seconds = $param_defaults['field_min_run_every_n_seconds'];
	}
	
	/**
	 * Perform authentication against PostgreSQL database table
	 * 
	 * @param string $username
	 * @param string $password
	 * @return boolean
	 */
	public function authenticate($username, $password, &$company_file, &$wait_before_next_update, &$min_run_every_n_seconds)
	{
		$func = $this->_crypt_function;
		
		$res = pg_query($this->_conn, "
			SELECT 
				* 
			FROM 
				" . $this->_table_name . " 
			WHERE 
				" . $this->_field_username . " = '" . pg_escape_string($this->_conn, $username) . "' AND 
				" . $this->_field_password . " = '" . pg_escape_string($this->_conn, $func($password)) . "' ");
		
		if ($arr = pg_fetch_assoc($res))
		{
			if ($this->_field_company_file)
			{
				$company_file = $arr[$this->_field_company_file];
			}
			
			if ($this->_field_wait_before_next_update and (int) $arr[$this->_field_wait_before_next_update])
			{
				$wait_before_next_update = (int) $arr[$this->_field_wait_before_next_update];
			}
			
			if ($this->_field_min_run_every_n_seconds and (int) $arr[$this->_field_min_run_every_n_seconds])
			{
				$min_run_every_n_seconds = (int) $arr[$this->_field_min_run_every_n_seconds];
			}
			
			return true;
		}
		
		return false;
	}
}
