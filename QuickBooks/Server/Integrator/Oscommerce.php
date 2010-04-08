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
 */
//define('QUICKBOOKS_SERVER_INTEGRATOR_MODULE_FOXYCART', 'foxycart');

/**
 * 
 *
 */
QuickBooks_Loader::load('/QuickBooks/Server/Integrator.php');

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Encryption/Factory.php');

/**
 * 
 * 
 */
class QuickBooks_Server_Integrator_OSCommerce extends QuickBooks_Server_Integrator
{
	/**
	 * 
	 */
	protected $_api;
	
	/**
	 * 
	 */
	protected $_integrator;
	
	/** 
	 * 
	 */
	protected $_oscommerce_options;
	
	/**
	 * Create and return an instance of the iterator
	 * 
	 * @param string $integrator_dsn_or_conn
	 * @param array $integrator_options
	 * @return QuickBooks_Integrator_*
	 */
	protected function _integratorFactory($integrator_dsn_or_conn, $integrator_options, $API)
	{
		$Driver = QuickBooks_Driver_Factory::create($integrator_dsn_or_conn, $integrator_options);
		return new QuickBooks_Integrator_OSCommerce($Driver, $integrator_options, $API);
	}
	
	/**
	 * Handle a SOAP request *or* a FoxyCart Datafeed message
	 * 
	 * If this method detects a SOAP request, it will act as a FoxyCart web 
	 * service integration using the Web Connector. If it detects a FoxyCart 
	 * data feed, it will process the data feed and store it in database tables 
	 * for sending to QuickBooks later. 
	 * 
	 * @param boolean $return
	 * @param boolean $debug
	 * @return mixed
	 */
	/*
	public function handle($return = false, $debug = false)
	{
		if (isset($_POST['FoxyData']))
		{
			return $this->_foxycart($this->_api, $this->_integrator, $this->_integrator_config, $_POST['FoxyData']);
		}
		else
		{
			return parent::handle($return, $debug);
		}
	}
	*/
}
