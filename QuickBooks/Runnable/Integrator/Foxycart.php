<?php

/**
 * Foxycart Server Integrator for the QuickBooks Web Connector
 * 
 * 
 * 
 * @package QuickBooks
 * @subpackage Runnable
 */

/**
 * QuickBooks server integrator base class
 */
QuickBooks_Loader::load('/QuickBooks/Runnable/Integrator.php');

/**
 * 
 */
class QuickBooks_Runnable_Integrator_FoxyCart extends QuickBooks_Runnable_Integrator
{
	/**
	 * 
	 * @var object
	 */
	protected $_api;
	
	/**
	 * 
	 * @var object
	 */
	protected $_integrator;
	
	/** 
	 * 
	 * @var array
	 */
	protected $_foxycart_options;
	
	/**
	 * 
	 * 
	 */
	protected $_foxycart_server;
	
	
	public function __construct($dsn_or_conn, 
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
		parent::__construct($dsn_or_conn, 
			$integrator_dsn_or_conn, 
			$email, 
			$user, 
			$map, 
			$onerror, 
			$hooks, 
			$log_level, 
			$soap, 
			$wsdl, 
			$soap_options, 
			$handler_options, 
			$driver_options, 
			$api_options, 
			$source_options, 
			$integrator_options, 
			$callback_options);
		
		$alert = null;
		
		if (isset($_POST['FoxyData']))
		{
			$Server = new QuickBooks_Server_Integrator_FoxyCart(
					$dsn_or_conn, 
					$integrator_dsn_or_conn, 
					$alert, 
					$user, 
					$map,
					$onerror, 
					$hooks, 
					$log_level, 
					$soap,
					$wsdl, 
					$soap_options, 
					$handler_options, 
					$driver_options, 
					$api_options, 
					$source_options, 
					$integrator_options, 
					$callback_options);
			
			$this->_foxycart_server = $Server;
		}
	}
	
	
	/**
	 * Create and return an instance of the iterator
	 * 
	 * FoxyCart uses a database instance class to cache data received from the 
	 * FoxyCart data feeds, so we also create a database instance class and 
	 * send that to the iterator. 
	 * 
	 * @param string $integrator_dsn_or_conn
	 * @param array $integrator_options
	 * @return QuickBooks_Integrator_*
	 */
	protected function _integratorFactory($integrator_dsn_or_conn, $integrator_options, $API)
	{
		$Driver = QuickBooks_Driver_Factory::create($integrator_dsn_or_conn, $integrator_options);
		return new QuickBooks_Integrator_Foxycart($Driver, $integrator_options, $API);
	}
	
	/**
	 * 
	 * 
	 * @param boolean $return
	 * @param boolean $debug
	 * @return mixed
	 */
	public function run()
	{
		if (isset($_POST['FoxyData']))
		{
			// Make sure a closed connection doesn't kill the script
			ignore_user_abort(true);
			set_time_limit(0);			
			
			// This is so that we make sure it runs the very first time before
			//	we actually handle any orders
			parent::run();
			sleep(1);
			
			$Server = $this->_foxycart_server;
			
			$die_after_processing = false;
			$Server->handle(false, false, $die_after_processing);
			
			// Oy vey... 
			if (function_exists('apache_setenv'))
			{
				@apache_setenv('no-gzip', 1);
			}
			
			@ini_set('zlib.output_compression', 0);
			@ini_set('implicit_flush', 1);			
			
			print(str_repeat(' ', 1025));
			
			// Check that buffer is actually set before flushing
			if (ob_get_length())
			{
				@ob_flush();
				@flush();
				@ob_end_flush();
			}
			
			// 
			sleep(1);
		}
		
		return parent::run();
	}
}
