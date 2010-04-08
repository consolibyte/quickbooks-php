<?php

/**
 * 
 * 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * 
 *
 */
QuickBooks_Loader::load('/QuickBooks/Server/Integrator.php');

/**
 * 
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_MODULE_WHMCS', 'whmcs');

/**
 * Enabled status - user is enabled
 * @var string
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_WHMCS_STATUS_ENABLED', 'e');

/**
 * Disabled status - user is disabled
 * @var string
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_WHMCS_STATUS_DISABLED', 'd');

/**
 * Hold status - used when we may fetch accounts, sales tax items, ship methods, etc. from Foxycart, but not send any transactions to it
 * @var string
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_WHMCS_STATUS_HOLD', 'h');

define('QUICKBOOKS_SERVER_INTEGRATOR_WHMCS_TABLE_USER', 'qb_whmcs_integration_user');
define('QUICKBOOKS_SERVER_INTEGRATOR_WHMCS_TABLE_LOG', 'qb_whmcs_integration_log');

/**
 * 
 * 
 */
class QuickBooks_Server_Integrator_Whmcs extends QuickBooks_Server_Integrator
{
	/**
	 * 
	 */
	protected $_api;
	
	/**
	 * 
	 */
	protected $_integrator;
	
	protected $_whmcs_user;
	
	protected $_whmcs_pass;
	
	protected $_whmcs_url;
	
	/**
	 * Create and return an instance of the iterator
	 * 
	 * @param string $integrator_dsn_or_conn
	 * @param array $integrator_options
	 * @return QuickBooks_Integrator_*
	 */
	protected function _integratorFactory($integrator_dsn_or_conn, $integrator_options, $API)
	{
		$init = array();
		$Driver = QuickBooks_Driver_Factory::create($integrator_dsn_or_conn, $integrator_options);
		return new QuickBooks_Integrator_Whmcs($Driver, $integrator_options, $API, $init);
	}
	
	/**
	 * Handle a SOAP request
	 * 
	 * @param boolean $return
	 * @param boolean $debug
	 * @return mixed
	 */
	public function handle($return = false, $debug = false)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$this->_doWHMCSCheck();
		}
		
		return parent::handle($return, $debug);
	}

	protected function _whmcsLog($message, $user)
	{
		$errnum = 0;
		$errmsg = null;
		return $this->_integrator->query("
			INSERT INTO
				" . QUICKBOOKS_SERVER_INTEGRATOR_WHMCS_TABLE_LOG . "
			(
				whmcs_log_msg, 
				whmcs_log_datetime,
				whmcs_user
			) VALUES (
				'" . $this->_integrator->escape($message) . "', 
				'" . date('Y-m-d H:i:s') . "',
				'" . $this->_integrator->escape($user) . "' 
			)", $errnum, $errmsg);
	}
	
	protected function _doWHMCSCheck()
	{
		$counter_max = 100;
		$failed_max = 10;
		
		$WHMCS_USER = $this->_api->user();
		
		$this->_whmcs_user = $this->_whmcsConfig('whmcs_user_username');
		$this->_whmcs_pass = $this->_whmcsConfig('whmcs_user_password');
		$this->_whmcs_url = $this->_whmcsConfig('whmcs_user_url');
		$this->_whmcs_crypt = $this->_whmcsConfig('whmcs_user_encryption');
		
		$tables = array(
			'invoices', 
			);
		
		for ($i = 0; $i < $counter_max; $i++)
		{
			foreach ($tables as $table)
			{
				$errnum = null;
				$errmsg = null;
				$type = null;
				$data = $this->_whmcsCall('table', array( 'table' => $table, 'offset' => 0 ), $errnum, $errmsg, $type);
				
				$j = count($data);
				for ($j = 0; $j < $count; $j++)
				{
					
				}
			}
		}
		
		return true;
	}
	
	protected function _whmcsSave($table)
	{
		
	}
	
	protected function _whmcsCall($action, $args, &$errnum, &$errmsg, &$type)
	{
		// Get the username
		$user = $this->_api->user();
		
		// Our HTTP POST client
		$HTTP = new QuickBooks_HTTP($this->_whmcs_url);
		
		// Turn off SSL verification stuff
		$HTTP->verifyPeer(false);
		$HTTP->verifyHost(false);
		
		// 
		$args['action'] = $action;
		$args['username'] = md5($this->_whmcs_user);
		$args['password'] = md5($this->_whmcs_pass);
		
		// 
		$HTTP->setGETValues($args);
		
		// 
		$this->_whmcsLog('Making HTTP request to [' . $this->_whmcs_url . '] with data: {' . print_r($args, true) . '}', $user);
		
		// Make the SOAP call
		$http_return = $HTTP->GET();
		
		// 
		$this->_whmcsLog('Retrieved HTTP response: {' . print_r($http_return, true) . '}', $user);
		
		if ($HTTP->errorNumber())
		{
			$errnum = -1;
			$errmsg = 'HTTP error: ' . $HTTP->errorNumber() . ': ' . $HTTP->errorMessage();
			return false;
		}
		
		if (empty($http_return))
		{
			$errnum = -2;
			$errmsg = 'Received empty response from API server...?';
			return false;
		}
		
		// Decrypt it if it's encrypted 
		$KEY_GOES_HERE = '';
		$return = $this->_whmcsDecrypt($http_return, $KEY_GOES_HERE);
		
		// 
		$return = $this->_whmcsParse($return);	
		
		// 
		$whmcs_errnum = 0;
		$whmcs_errmsg = '';
		if ($this->_whmcsIsError($http_return, $whmcs_errnum, $whmcs_errmsg))
		{
			$errnum = -4;
			$errmsg = 'WHMCS returned an error: ' . $whmcs_errnum . ': ' . $whmcs_errmsg;
			return false;	
		}
		
		$this->_whmcsLog('Parsed WHMCS response: {' . print_r($return, true) . '}', $user);
		
		return $return;
	}
	
	protected function _whmcsDecrypt($str, $key)
	{
		return $str;
	}
	
	protected function _whmcsParse($str)
	{
		$arr = unserialize($str);
		
		$fields = $arr['fields'];
		
		$list = array();
		for ($i = 0; $i < $arr['count']; $i++)
		{
			$list[$i] = array_combine($fields, $arr['data'][$i]);
		}
		
		//header('Content-Type: text/plain');
		//print_r($list);
		//exit;
		
		return $list;
	}
	
	protected function _whmcsIsError($str, &$errnum, &$errmsg)
	{
		// status=error;message=Invoice ID Not Found;
		
		if (substr($str, 0, 12) == 'status=error')
		{
			$errnum = -3;
			$errmsg = substr($str, 13, -1);
			
			return true;
		}
		else if (substr($str, 0, 12) == 'result=error')
		{
			$errnum = -6;
			$errmsg = substr($str, 18, -1);
			
			return true;
		}
		
		$errnum = 0;
		$errmsg = '';
		return false;
	}
	
	/**
	 * Load a configuration variable from the WHMCS user table
	 * 
	 * @param string $key		The key for the configuration value to load
	 * @param mixed $set		If you want to also *set* the value, pass in the value to set here
	 * @return mixed			The configuration key
	 */
	protected function _whmcsConfig($key, $set = null)
	{
		$API = $this->_api;
		
		static $cache = null;
		
		// Get the username... 
		$user = $API->user();

		// Get the SQL driver
		$Database = $this->_integrator;
		
		// Set the value...
		if ($set)
		{
			$sql = "
				UPDATE 
					" . QUICKBOOKS_SERVER_INTEGRATOR_WHMCS_TABLE_USER . "
				SET
					" . $key . " = '" . $set . "' 
				WHERE
					whmcs_user_name = '" . $Database->escape($user) . "' ";
			
			$errnum = null;
			$errmsg = null;
			$Database->query($sql, $errnum, $errmsg);
			
			$cache = null;
		}
		
		if (is_null($cache))
		{
			$errnum = null;
			$errmsg = null;
			$res = $Database->query("SELECT * FROM " . QUICKBOOKS_SERVER_INTEGRATOR_WHMCS_TABLE_USER . " WHERE whmcs_user_name = '" . $Database->escape($user) . "' ", $errnum, $errmsg);
			if ($arr = $Database->fetch($res))
			{
				$cache = $arr;
			}
		}
		
		if ($cache and 
			isset($cache[$key]))
		{
			return $cache[$key];
		}
		
		return null;
	}	
}
