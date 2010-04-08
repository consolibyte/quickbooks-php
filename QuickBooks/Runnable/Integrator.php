<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/** 
 * QuickBooks server base class
 */
QuickBooks_Loader::load('/QuickBooks/Server.php');

/**
 * API Server (OOP interface to qbXML)
 */
QuickBooks_Loader::load('/QuickBooks/Runnable/API.php');

/**
 * QuickBooks API class (OOP interface to qbXML)
 */
QuickBooks_Loader::load('/QuickBooks/API.php');

/**
 * QuickBooks integrator base class
 */
QuickBooks_Loader::load('/QuickBooks/Integrator.php');

/**
 * Integrator singleton
 */
QuickBooks_Loader::load('/QuickBooks/Integrator/Singleton.php');

/**
 * Integrator server callbacks
 */
QuickBooks_Loader::load('/QuickBooks/Callbacks/Integrator/Callbacks.php');

/**
 * QuickBooks integrator base class
 */
abstract class QuickBooks_Runnable_Integrator extends QuickBooks_Runnable_API
{
	/**
	 * 
	 * 
	 * 
	 */
	public function __construct(
		$dsn_or_conn, 
		$integrator_dsn_or_conn, 
		$email, 
		$user, 
		$map = array(), 
		$onerror = array(), 
		$hooks = array(), 
		$log_level = QUICKBOOKS_LOG_NORMAL, 
		$soap = QUICKBOOKS_SOAPSERVER_BUILTIN, 
		$wsdl = QUICKBOOKS_WSDL, 
		$soap_options = array(), 
		$handler_options = array(), 
		$driver_options = array(), 
		$api_options = array(), 
		$source_options = array(), 
		$integrator_options = array(), 
		$callback_options = array())
	{		
		// Callback options
		$integrator_callback_options = array(
			'_error_email' => $email, 
			'_error_subject' => 'QuickBooks Error on ' . $_SERVER['HTTP_HOST'], 
			'_error_from' => 'quickbooks@' . implode('.', array_slice(explode('.', $_SERVER['HTTP_HOST']), -2)), 
			);
		
		$integrator_onerror = array();
		
		$integrator_hooks = array();
		
		// QuickBooks_Server_API::__construct( ... )
		parent::__construct(
			$dsn_or_conn, 
			$user, 
			$map, 
			$integrator_onerror,
			$integrator_hooks, 
			$log_level, 
			$soap, 
			$wsdl, 
			$soap_options, 
			$handler_options, 
			$driver_options,
			$api_options, 
			$source_options, 
			$callback_options);
		
		$source_type = QUICKBOOKS_API_SOURCE_ONLINE_EDITION;
		$source_dsn = null;
		
		// Set up the API 
		// $api_driver_dsn, $user, $source_type, $source_dsn, $api_options = array(), $source_options = array(), $driver_options = array(), $callback_options = array()
		$API = QuickBooks_API_Singleton::getInstance($dsn_or_conn, $user, $source_type, $source_dsn, $api_options, $source_options, $driver_options, $callback_options);
		$this->_api = $API; // new QuickBooks_API($dsn_or_conn, $user, $source_type, $source_dsn, $api_options, $source_options, $driver_options, $callback_options);
		
		// Set up the integrator
		$this->_integrator = $this->_integratorFactory($integrator_dsn_or_conn, $integrator_options, $API);
		
		// Initialize the Integrator singleton
		$tmp = QuickBooks_Integrator_Singleton::getInstance($this->_integrator);
		
		// Integrator options (shared between the server component and actual integrator)
		//$this->_integrator_config = $this->_integratorDefaults($integrator_options);
	}
	
	public function useDebugMode($yes_or_no)
	{
		return $this->_api->useDebugMode( (boolean) $yes_or_no );
	}
	
	public function useTestEnvironment($yes_or_no)
	{
		return $this->_api->useTestEnvironment( (boolean) $yes_or_no );
	}
	
	public function useLiveEnvironment($yes_or_no)
	{
		return $this->_api->useLiveEnvironment( (boolean) $yes_or_no );
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public function run($print = false)
	{
		// 
		parent::run();
		
		// 
		$user = $this->_api->user();
		
		// Call this method
		$requestID = null;
		$hook = null;
		$err = null;
		$hook_data = array();
		$callback_config = array();
		QuickBooks_Callbacks_Integrator_Callbacks::onAuthenticate(
			$requestID, 
			$user, 
			$hook, 
			$err, 
			$hook_data, 
			$callback_config);
		
		if ($print)
		{
			print(get_class($this));
		}
		
		return true;
	}
		
	/**
	 * 
	 * 
	 * @param string $integrator_dsn_or_conn
	 * @param array $integrator_options
	 */
	abstract protected function _integratorFactory($integrator_dsn_or_conn, $integrator_options, $API);
}
