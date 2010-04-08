<?php

/**
 * QuickBooks integrator singleton
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Integrator
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Integrator.php');

/**
 * 
 */
class QuickBooks_Integrator_Singleton
{
	/**
	 * 
	 * 
	 * @param string $dsn_or_conn
	 * @param array $options
	 * @return QuickBooks_Driver
	 */
	public static function getInstance($obj = null)
	{
		static $instance = null;
		if (is_null($instance))
		{
			$instance = $obj;
		}
		
		return $instance;
	}
}
