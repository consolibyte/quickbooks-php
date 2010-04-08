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
 * 
 */
class QuickBooks_Server_Integrator_Magento extends QuickBooks_Server_Integrator
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
	 * Create and return an instance of the iterator
	 * 
	 * @param string $integrator_dsn_or_conn
	 * @param array $integrator_options
	 * @return QuickBooks_Integrator_*
	 */
	protected function _integratorFactory($integrator_dsn_or_conn, $integrator_options, $API)
	{
		// 
		$parse = QuickBooks_Utilities::parseDSN($integrator_dsn_or_conn);
		
		// 
		$Driver = new SoapClient($integrator_dsn_or_conn);
		
		// Log in to Magento
		$soap_session = $Driver->login($parse['user'], $parse['pass']);

		// @TODO Error checking in case login fails
		
		$init = array(
			'_soap_user' => $parse['user'],
			'_soap_pass' => $parse['pass'],			
			'_soap_session' => $soap_session, 
			);
		
		return new QuickBooks_Integrator_Magento($Driver, $integrator_options, $API, $init);
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
	public function handle($return = false, $debug = false)
	{
		return parent::handle($return, $debug);
	}
}
