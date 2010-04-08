<?php

/**
 * QuickBooks driver singleton
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/API.php');

/**
 * 
 */
class QuickBooks_API_Singleton
{
	/**
	 * 
	 * 
	 * @param string $dsn_or_conn
	 * @param array $options
	 * @return QuickBooks_Driver
	 */
	public static function getInstance($api_driver_dsn = null, $user = null, $source_type = null, $source_dsn = null, $api_options = array(), $source_options = array(), $driver_options = array(), $callback_options = array())
	{
		static $instance = null;
		if (is_null($instance))
		{
			$instance = new QuickBooks_API($api_driver_dsn, $user, $source_type, $source_dsn, $api_options, $source_options, $driver_options, $callback_options);
		}
		
		return $instance;
	}
}
