<?php

/**
 * QuickBooks API Server   
 * 
 * *** This is BETA quality code. Only a subset of QuickBooks data is supported.
 * Lots of things are probably broken. USE AT YOUR OWN RISK! ***
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 *  
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * QuickBooks Driver singleton (single point of access to a variable)
 */
QuickBooks_Loader::load('/QuickBooks/Driver/Singleton.php');

/**
 * QuickBooks API singleton (single point of access to a variable)
 */
QuickBooks_Loader::load('/QuickBooks/API/Singleton.php');

/**
 * QuickBooks Server base class
 */
QuickBooks_Loader::load('/QuickBooks/Server.php');

/**
 * API sources (we need this for some default constants)
 */
QuickBooks_Loader::load('/QuickBooks/API.php');

/**
 * API callback/handler routines
 */
QuickBooks_Loader::load('/QuickBooks/Callbacks/API/Callbacks.php');

/**
 * API error handlers
 */
QuickBooks_Loader::load('/QuickBooks/Callbacks/API/Errors.php');

/**
 * Handler base class (we need this for some hook consants)
 */
QuickBooks_Loader::load('/QuickBooks/Handlers.php');

/**
 * QuickBooks API Server class
 * 
 * The QuickBooks API Server class provides an OOP interface to building and 
 * executing requests against QuickBooks. This server provides an interface 
 * for the QuickBooks Web Connector to connect against. 
 * 
 * You can use the {@see QuickBooks_API} class to queue up requests for this 
 * server. 
 */
class QuickBooks_Server_API extends QuickBooks_Server
{
	/**
	 * QuickBooks API server class
	 * 
	 * @param string $dsn_or_conn
	 * @param array $map
	 * @param array $onerror
	 * @param array $hooks
	 * @param integer $log_level
	 * @param string $soap
	 * @param string $wsdl
	 * @param array $soap_options
	 * @param array $handler_options
	 * @param array $driver_options
	 * @param array $callback_options
	 */
	public function __construct(
		$dsn_or_conn, 
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
		$callback_options = array())
	{
		// NORMAL:
		// $dsn_or_conn, $map, $onerror = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_BUILTIN, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array()
		
		// SQL:
		// $dsn_or_conn, $how_often, $mode, $conflicts, $users = null, $map = array(), $onerror = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_BUILTIN, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array())
		
		$api_map = array();
		
		foreach (get_class_methods('QuickBooks_Callbacks_API_Callbacks') as $method)
		{
			if (strtolower(substr($method, -7)) == 'request')
			{
				$action = substr($method, 0, -7);
				
				$api_map[$action] = array( 
					'QuickBooks_Callbacks_API_Callbacks::' . $action . 'Request', 
					'QuickBooks_Callbacks_API_Callbacks::' . $action . 'Response' );
			}
		}
		
		// Register default API error handlers, and merge them with user-supplied handlers
		$api_onerror = array(
			1 => 'QuickBooks_Callbacks_API_Errors::e1_notfound', 
			500 => 'QuickBooks_Callbacks_API_Errors::e500_notfound',  
			//'*' => 'QuickBooks_Server_API_Errors::catchall', 
			);
		
		// By default, we register our own error handlers. If the user wants to 
		//	register their own error handlers, their error handlers override 
		//	the API error handlers, and they'll be expected to handle all of 
		//	those errors themselves. 
		$api_onerror = $this->_merge($api_onerror, $onerror, false);
		
		// Register default API hooks, and merge them with user-supplied hooks
		$api_hooks = array(
			);
		
		// Merge user-defined hooks with our API hooks
		$api_hooks = $this->_merge($api_hooks, $hooks, true);
		
		// Initialize the Driver singleton 
		$tmp = QuickBooks_Driver_Singleton::getInstance($dsn_or_conn, $driver_options, $hooks, $log_level);
		
		$source_type = QuickBooks_API::SOURCE_WEB;
		$source_dsn = null;
		
		// Initialize the API singleton
		$tmp = QuickBooks_API_Singleton::getInstance($dsn_or_conn, $user, $source_type, $source_dsn, $api_options, $source_options, $driver_options, $callback_options);
		
		// $dsn_or_conn, $map, $onerror = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_BUILTIN, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array()
		parent::__construct(
			$dsn_or_conn, 
			$api_map, 
			$api_onerror, 
			$api_hooks, 
			$log_level, 
			$soap, 
			$wsdl, 
			$soap_options, 
			$handler_options, 
			$driver_options, 
			$callback_options);
	}
}
