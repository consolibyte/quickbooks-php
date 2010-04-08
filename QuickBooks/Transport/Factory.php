<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt  
 * 
 * @package QuickBooks
 * @subpackage Transport
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

/**
 * 
 * 
 * 
 */
class QuickBooks_Transport_Factory
{
	static public function create($dsn_or_conn, $mode, $user, $action, $config = array())
	{
		static $instances = array();
			
		$key = (string) $dsn_or_conn . ',' . $mode . ',' . $user . ',' . $action . ',' . serialize($config);
			
		if (!isset($instances[$key]))
		{
			if (is_resource($dsn_or_conn))
			{
				$scheme = current(explode(' ', get_resource_type($dsn_or_conn)));
			}
			else
			{
				$scheme = QuickBooks_Utilities::parseDSN($dsn_or_conn, array(), 'scheme');
			}
				
			if (false !== strpos($scheme, 'sql'))		// SQL drivers are subclassed... change class/scheme name
			{
				$scheme = 'SQL_' . $scheme;
			}
				
			$class = 'QuickBooks_Transport_' . ucfirst(strtolower($scheme));
			$file = '/QuickBooks/Transport/' . str_replace(' ', '/', ucwords(str_replace('_', ' ', strtolower($scheme)))) . '.php';
				
			QuickBooks_Loader::load($file);
				
			if (class_exists($class))
			{
				$Transport = new $class($dsn_or_conn, $mode, $user, $action, $config);
				
				$instances[$key] = $Transport;
			}
			else
			{
				$instances[$key] = null;
			}
		}
			
		return $instances[$key];
	}
}