<?php

/**
 * QuickBooks driver singleton
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Driver
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Driver.php');

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Driver/Factory.php');

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

/**
 * 
 */
class QuickBooks_Driver_Singleton
{
	/**
	 * 
	 * 
	 * @param string $dsn_or_conn
	 * @param array $options
	 * @return QuickBooks_Driver
	 */
	public static function getInstance($dsn_or_conn = null, $options = array(), $hooks = array(), $log_level = null)
	{
		static $instance = null;
		if (is_null($instance))
		{
			//$instance = QuickBooks_Utilities::driverFactory($dsn_or_conn, $options, $hooks, $log_level);
			$instance = QuickBooks_Driver_Factory::create($dsn_or_conn, $options, $hooks, $log_level);
		}
		
		return $instance;
	}
	
	/**
	 * 
	 * 
	 */
	public static function initialize($dsn_or_conn, $options = array(), $hooks = array(), $log_level = null)
	{
		if ($obj = QuickBooks_Driver_Singleton::getInstance($dsn_or_conn, $options, $hooks, $log_level))
		{
			return true;
		}
		
		return false;
	}
}
