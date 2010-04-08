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
QuickBooks_Loader::load('/QuickBooks/Server/Integrator.php');

/**
 * 
 */
class QuickBooks_Server_Integrator_Zencart extends QuickBooks_Server_Integrator
{
	/**
	 * Get the IMSCart integrator object for the IMSCart integrator server
	 * 
	 * @param string $integrator_dsn_or_conn
	 * @param array $integrator_options
	 * @return QuickBooks_Integrator
	 */
	protected function _integratorFactory($integrator_dsn_or_conn, $integrator_options, $API)
	{
		$driver = QuickBooks_Utilities::driverFactory($integrator_dsn_or_conn);
		return new QuickBooks_Integrator_Zencart($driver, $integrator_options);
	}
}
