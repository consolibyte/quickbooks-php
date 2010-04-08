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
class QuickBooks_Server_Integrator_Opencart extends QuickBooks_Server_Integrator
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
		$Driver = QuickBooks_Driver_Factory::create($integrator_dsn_or_conn, $integrator_options);
		return new QuickBooks_Integrator_Opencart($Driver, $integrator_options, $API);
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
		return parent::handle($return, $debug);
	}
}
