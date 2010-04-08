<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Authenticate
 */

/**
 * 
 */
require_once 'QuickBooks/Authenticate.php';

/**
 * 
 */
class QuickBooks_Authenticate_Ldap implements QuickBooks_Authenticate
{
	protected $_ldap_host;
	
	protected $_ldap_port;
	
	protected $_ldap_basedn;
	
	protected $_ldap_ssl;
	
	protected $_ldap_tls;
	
	protected $_ldap_version;
	
	/**
	 * 
	 * 
	 * <code>
	 * $dsn = "ldap://ldap.your-domain.com/ou=People,dc=your-domain,dc=com?ssl=0&tls=1&version=3";
	 * </code>
	 * 
	 * @param string $dsn
	 */
	public function __construct($dsn)
	{
		$parse = parse_url($dsn);
		
		$parse_defaults = array(
			'host' => 'localhost', 
			'port' => 389, 
			'path' => '/ou=People,dc=localhost', 
			'query' => '', 
			);
		$parse = array_merge($parse_defaults, $parse);
		
		$this->_ldap_host = $parse['host']; 
		$this->_ldap_port = $parse['port'];
		$this->_ldap_basedn = substr($parse['path'], 1);
		
		$params = array();
		parse_str($parse['query'], $params);
		
		$param_defaults = array(
			'ssl' => 0, 
			'tls' => 0, 
			'version' => 0, 
			'attribute' => 'uid', 
			);
		$params = array_merge($param_defaults, $params);
		
		$this->_ldap_ssl = (boolean) $params['ssl'];
		$this->_ldap_tls = (boolean) $params['tls'];
		$this->_ldap_version = (integer) $params['version'];
		$this->_ldap_attribute = $params['attribute'];
		
		if ($this->_ldap_ssl)
		{
			$this->_ldap_host = 'ldaps://' . $this->_ldap_host;
			$this->_ldap_tls = false;
			
			if ($this->_ldap_port == 389)	// if it's the default for plain-text LDAP... 
			{
				$this->_ldap_port = 636;	// ...change it to the default for SSL
			}
		}
	}
	
	/**
	 * 
	 * 
	 * @param string $username
	 * @param string $password
	 * @param string $company_file
	 * @param integer $wait_before_next_update
	 * @param integer $min_run_every_n_seconds
	 * @return boolean
	 */
	public function authenticate($username, $password, &$company_file, &$wait_before_next_update, &$min_run_every_n_seconds)
	{
		if (!strlen(trim($username)) or 
			!strlen(trim($password)))
		{
			return false;	
		}
		
		if ($ds = ldap_connect($this->_ldap_host, $this->_ldap_port))
		{
			if ($this->_ldap_version)
			{
				if (!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, (int) $this->_ldap_version)) 
				{
					return false;
				}
			}
			
			if ($this->_ldap_tls)
			{
				if (!ldap_start_tls($ds)) 
				{
					return false;
				}
			}
			
			if ($r = ldap_search($ds, $this->_ldap_basedn, $this->_ldap_attribute . '=' . $username))
			{
				$entries = ldap_get_entries($ds, $r);
				if (!empty($entries[0]))
				{
					return @ldap_bind($ds, $entries[0]['dn'], $password);
				}
			}
		}
		
		return false;
	}
}
