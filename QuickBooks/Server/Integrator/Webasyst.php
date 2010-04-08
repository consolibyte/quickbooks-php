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
class QuickBooks_Server_Integrator_Webasyst extends QuickBooks_Server_Integrator
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
		return new QuickBooks_Integrator_Webasyst($Driver, $integrator_options, $API);
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
