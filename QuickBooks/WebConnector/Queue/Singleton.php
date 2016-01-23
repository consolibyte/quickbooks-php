<?php

/**
 * QuickBooks singleton class for the queueing class
 *
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 *
 * Web Connector applications will often use the queueing class within many
 * different functions within the applications. It is desireable then to always
 * use a single instance of the queueing class to avoid unneccessary database
 * connections and code cruft. This singleton class provides a way to use a
 * single instance of the queueing class without resorting to the use of
 * globals.
 *
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 *
 * @package QuickBooks
 * @subpackage Queue
 */

/**
 * QuickBooks singleton class for the QuickBooks_Queue class
 */
class QuickBooks_WebConnector_Queue_Singleton
{
	/**
	 * Initialize the queueing object
	 *
	 * @param string $dsn
	 * @param string $user
	 * @param array  $config
	 * @param bool   $return_boolean
	 * @return QuickBooks_WebConnector_Queue
	 */
	static public function initialize($dsn = null, $user = null, $config = array(), $return_boolean = true)
	{
		static $instance;
		if (empty($instance))
		{
			if (empty($dsn))
			{
				return false;
			}

			$instance = new QuickBooks_WebConnector_Queue($dsn, $user, $config);
		}

		if ($return_boolean and $instance)
		{
			return true;
		}

		return $instance;
	}

	/**
	 * ???
	 */
	static protected function _hash($dsn, $config)
	{
		return md5(serialize($dsn) . serialize($config));
	}

	/**
	 * Get the instance of the queueing class
	 *
	 * @return QuickBooks_WebConnector_Queue
	 */
	static public function getInstance()
	{
		return QuickBooks_WebConnector_Queue_Singleton::initialize(null, null, null, false);
	}
}
