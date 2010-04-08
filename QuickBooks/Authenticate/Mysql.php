<?php

/**
 * Authenticate QuickBooks Web Connector users against a MySQL database
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Authenticate
 */

/**
 * Base QuickBooks constants
 */
require_once 'QuickBooks.php';

/**
 * Authenticate interface
 */
require_once 'QuickBooks/Authenticate.php';

/**
 * Utilities for parsing DSN strings
 */
require_once 'QuickBooks/Utilities.php';

/**
 * Authenticate a QuickBooks Web Connector user against a MySQL database
 */
class QuickBooks_Authenticate_Mysql implements QuickBooks_Authenticate
{
	/**
	 * MySQL table name
	 * @var string
	 */
	protected $_table_name;
	
	/**
	 * MySQL field name which contains usernames
	 * @var string
	 */
	protected $_field_username;
	
	/**
	 * MySQL field name which contains passwords
	 * @var string
	 */
	protected $_field_password;
	
	/**
	 * Callback function used for encryption/hashing
	 * @var string
	 */
	protected $_crypt_function;
	
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
	 * MySQL database connection
	 * @var resource
	 */
	protected $_conn;
	
	/**
	 * Create a new instance of the MySQL Web Connector authenticator
	 * 
	 * @param string $dsn	A DSN-style MySQL connection string (i.e.: mysql://your-username:your-password@your-localhost:port/your-database)
	 */
	public function __construct($dsn)
	{
		$conn_defaults = array(
			'scheme' => 'mysql', 
			'user' => 'root', 
			'pass' => '',
			'host' => 'localhost',  
			'port' => 3306,
			'path' => '/quickbooks',  
			'query' => '', 
			);
		
		$param_defaults = array(
			'table_name' => 'quickbooks_user', 
			'field_username' => 'qb_username', 
			'field_password' => 'qb_password', 
			'field_company_file' => null, 
			'field_wait_before_next_update' => null, 
			'field_min_run_every_n_seconds' => null, 
			'crypt_function' => 'sha1', 
			);
		
		// mysql://user:pass@localhost:port/database?table_name=quickbooks_user&field_username=username&field_password=password&crypt_function=md5
		$parse = QuickBooks_Utilities::parseDSN($dsn, $conn_defaults);
		
		$vars = array();
		parse_str($parse['query'], $vars);
		
		$param_defaults = array_merge($param_defaults, $vars);
		
		$this->_conn = mysql_connect($parse['host'] . ':' . $parse['port'], $parse['user'], $parse['pass'], true);
		mysql_select_db(substr($parse['path'], 1), $this->_conn);
		
		$this->_table_name = mysql_real_escape_string($param_defaults['table_name'], $this->_conn);
		$this->_field_username = mysql_real_escape_string($param_defaults['field_username'], $this->_conn);
		$this->_field_password = mysql_real_escape_string($param_defaults['field_password'], $this->_conn);
		$this->_crypt_function = $param_defaults['crypt_function'];
		
		$this->_field_company_file = $param_defaults['field_company_file'];
		$this->_field_wait_before_next_update = $param_defaults['field_wait_before_next_update'];
		$this->_field_min_run_every_n_seconds = $param_defaults['field_min_run_every_n_seconds'];
	}
	
	/**
	 * Perform authentication against a MySQL database
	 * 
	 * @param string $username
	 * @param string $password
	 * @return boolean
	 */
	public function authenticate($username, $password, &$company_file, &$wait_before_next_update, &$min_run_every_n_seconds)
	{
		$func = $this->_crypt_function;
		
		$res = mysql_query("
			SELECT 
				* 
			FROM 
				" . $this->_table_name . " 
			WHERE 
				" . $this->_field_username . " = '" . mysql_real_escape_string($username, $this->_conn) . "' AND 
				" . $this->_field_password . " = '" . mysql_real_escape_string($func($password), $this->_conn) . "' ");
		
		if ($arr = mysql_fetch_assoc($res))
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

