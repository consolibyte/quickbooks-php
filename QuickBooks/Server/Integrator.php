<?php

/**
 * QuickBooks Integrator base class - integrate common applications with QuickBooks
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/*
if (!defined('QUICKBOOKS_SERVER_INTEGRATOR_OFFSET'))
{
	define('QUICKBOOKS_SERVER_INTEGRATOR_OFFSET', 60 * 60 * 24);
}
*/

// 
if (!defined('QUICKBOOKS_SERVER_INTEGRATOR_RECUR'))
{
	/**
	 * How often items should re-occur in the queue
	 * 
	 * @var integer
	 */
	define('QUICKBOOKS_SERVER_INTEGRATOR_RECUR', 240);
}

/**
 * 
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_HOOK_INTEGRATEORDER', 'QuickBooks_Server_Integrator::integrateOrder');

/**
 * 
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_HOOK_INTEGRATECUSTOMER', 'QuickBooks_Server_Integrator::integrateCustomer');

/**
 * 
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_HOOK_INTEGRATEPRODUCT', 'QuickBooks_Server_Integrator::integrateProduct');

/** 
 * QuickBooks server base class
 */
QuickBooks_Loader::load('/QuickBooks/Server.php');

/**
 * API Server (OOP interface to qbXML)
 */
QuickBooks_Loader::load('/QuickBooks/Server/API.php');

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
 * Integrator server errors
 */
QuickBooks_Loader::load('/QuickBooks/Callbacks/Integrator/Errors.php');

/**
 * QuickBooks integrator base class
 */
abstract class QuickBooks_Server_Integrator extends QuickBooks_Server_API
{
	/**
	 * 
	 */
	protected $_integrator;
	
	/**
	 * 
	 */
	protected $_integrator_config;
	
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
		$integrator_onerror = array(
			'3100' => 	'QuickBooks_Callbacks_Integrator_Errors::e3100_alreadyexists',
			'3170' => 	'QuickBooks_Callbacks_Integrator_Errors::e3170_errorsaving', 
			'3180' => 	'QuickBooks_Callbacks_Integrator_Errors::e3180_errorsaving',
			'3200' => 	'QuickBooks_Callbacks_Integrator_Errors::e3200_editsequence', 
			'0x80040400' => 'QuickBooks_Callbacks_Integrator_Errors::e0x80040400_foundanerror', 			
			'3250' => 	'QuickBooks_Callbacks_Integrator_Errors::e3250_featurenotenabled', 
			'*' => 		'QuickBooks_Callbacks_Integrator_Errors::e_catchall', 
			);
		
		// Merge integration options over default options
		//	(allow overrides, they'll need to handle errors manually...)
		$integrator_onerror = $this->_merge($integrator_onerror, $onerror, false);
		
		// Merge hooks in
		$integrator_hooks = array(
			// This hook is neccessary for queueing up the appropriate actions to perform the sync 	(use login success so we know user to sync for)
			QuickBooks_Handlers::HOOK_LOGINSUCCESS => array( 'QuickBooks_Callbacks_Integrator_Callbacks::onAuthenticate' ), 
			);

		$integrator_hooks = $this->_merge($integrator_hooks, $hooks, true);
		
		// Callback options
		$integrator_callback_options = array(
			'_error_email' => $email, 
			'_error_subject' => 'QuickBooks Error on ' . $_SERVER['HTTP_HOST'], 
			'_error_from' => 'quickbooks@' . implode('.', array_slice(explode('.', $_SERVER['HTTP_HOST']), -2)), 
			);
		
		//print_r($integrator_callback_options);
		//exit;
		
		// Merge callback options 
		$integrator_callback_options = $this->_merge($integrator_callback_options, $callback_options, false);
		
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
		
		//header('Content-Type: text/plain');
		//print_r($this);
		//exit;
		
		$source_type = QuickBooks_API::SOURCE_WEB;
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
		$this->_integrator_config = $this->_integratorDefaults($integrator_options);
	}
	
	/**
	 * Merge default configuration options
	 * 
	 * @param array $config
	 * @return array
	 */
	protected function _integratorDefaults($config)
	{
		// WARNING WARNING WARNING THIS MIGHT NOT WORK!
		
		$defaults = array(
			'debug_datetime' => null, 
		
			'push_orders' => true,
			'push_payments' => true, 
			'push_customers' => true, 
			'push_products' => true, 
			'push_accounts' => true, 
			'push_shipmethods' => true, 
			'push_paymentmethods' => true, 
			
			'push_shipping' => true, 
			'push_handling' => true, 
			'push_discounts' => true, 
			'push_coupons' => true,  
			
			'pull_estimates' => false, 
			'pull_orders' => false, 
			'pull_payments' => false, 
			'pull_customers' => false, 
			'pull_products' => false,  
			'pull_shipmethods' => false, 
			'pull_paymentmethods' => false, 
			
			'lookup_orders' => false, 
			'lookup_customers' => true, 
			'lookup_products' => true, 
			'lookup_accounts' => true, 
			'lookup_shipmethods' => true, 
			'lookup_paymentmethods' => true, 
			
			/*
			'use_generic_coupons' => true, 
			'use_generic_discounts' => true, 
			'use_generic_shipping' => true, 
			*/

			'use_generic_coupons' => false, 
			'use_generic_discounts' => false, 
			'use_generic_shipping' => false, 
			
			//'order_format' => '$RefNumber ($ApplicationID)', 
			//'customer_format' => '$Name ($ApplicationID)', 
			//'item_format' => '$Name ($ApplicationID)', 
			);
			
		return array_merge($defaults, $config);
	}
	
	/**
	 * 
	 * 
	 * @param
	 * @param 
	 * @return boolean
	 */
	public function handle($return = false, $debug = false)
	{
		// Call the parent handler
		return parent::handle($return, $debug);
	}
	
	/**
	 * 
	 * 
	 * @param string $integrator_dsn_or_conn
	 * @param array $integrator_options
	 */
	abstract protected function _integratorFactory($integrator_dsn_or_conn, $integrator_options, $API);
}
