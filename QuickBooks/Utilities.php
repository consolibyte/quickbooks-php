<?php

/**
 * Various QuickBooks related utility methods
 * 
 * Copyright (c) 2010-04-16 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 */

/**
 * QuickBooks driver factory, used to fetch driver instances
 */
QuickBooks_Loader::load('/QuickBooks/Driver/Factory.php');

/**
 * Various QuickBooks related utilities
 * 
 * All methods are static
 */
class QuickBooks_Utilities
{
	/**
	 * Parse a DSN style connection string 
	 * 
	 * @param string $dsn		The DSN connection string
	 * @param string $part		If you want just a specific part of the string, choose which part here: scheme, host, port, user, pass, query, fragment
	 * @return mixed 			An array or a string, depending on if you wanted the whole thing parsed or just a piece of it 
	 */
	static public function parseDSN($dsn, $defaults = array(), $part = null)
	{
		// Some DSN strings look like this:		filesystem:///path/to/file
		//	parse_url() will not parse this *unless* we provide some sort of hostname (in this case, null)
		$dsn = str_replace(':///', '://null/', $dsn);
			
		$defaults = array_merge(array(
			'scheme' => '', 
			'host' => '', 
			'port' => 0, 
			'user' => '', 
			'pass' => '',
			'path' => '', 
			'query' => '',
			'fragment' => '',   
			), $defaults);
			
		$parse = array_merge($defaults, parse_url($dsn));
		
		$parse['user'] = urldecode($parse['user']);
		$parse['pass'] = urldecode($parse['pass']);
		
		if (is_null($part))
		{
			return $parse;
		}
		else if (isset($parse[$part]))
		{
			return $parse[$part];
		}
			
		return null;
	}
	
	/**
	 * Mask certain sensitive data from occuring in output/logs 
	 * 
	 * @param string $message
	 * @returns string
	 */
	static public function mask($message)
	{
		$masks = array(
			'<SessionTicket>', 
			'<ConnectionTicket>', 
			'<CreditCardNumber>', 
			'<CardSecurityCode>', 
			'<AppID>', 
			'<strPassword>', 
			);
		
		foreach ($masks as $key)
		{
			if ($key{0} == '<')
			{
				// It's an XML tag
				$contents = QuickBooks_Utilities::_extractTagContents(trim($key, '<> '), $message);
				
				$masked = str_repeat('x', min(strlen($contents), 12)) . substr($contents, 12);
				
				$message = str_replace($key . $contents . '</' . trim($key, '<> ') . '>', $key . $masked . '</' . trim($key, '<> ') . '>', $message);
			}
		}
		
		return $message;
	}
	
	/**
	 * @deprecated		Use QuickBooks_XML::extractTagContents() instead
	 */
	static protected function _extractTagContents($tag, $data)
	{
		$tmp = QuickBooks_XML::extractTagContents($tag, $data);
		return $tmp;
	}
	
	/**
	 * Write a message to the log (via the back-end driver) 
	 * 
	 * @param string $dsn		The DSN connection string to the logger
	 * @param string $msg		The message to log
	 * @param integer $lvl		The message log level
	 * @return boolean			Whether or not the message was logged
	 */
	static public function log($dsn, $msg, $lvl = QUICKBOOKS_LOG_NORMAL)
	{
		$Driver = QuickBooks_Utilities::driverFactory($dsn);
		
		// Mask important data
		$msg = QuickBooks_Utilities::mask($msg);
		
		return $Driver->log($msg, null, $lvl);
	}
	
	/**
	 * 
	 *                1        2       3
	 *               -3       -2      -1
	 * domainParts('tools.consolibyte.com');
	 *                0        1       2
	 * 
	 */
	/*static public function domainParts($domain, $part = null)
	{
		$tmp = explode('.', $domain);
		
		$part = (int) $part;
		if ($part > 0 and 
			isset($tmp[$part - 1]))
		{
			return $tmp[$part - 1];
		}
		else if ($part < 0 and 
			isset($tmp[count($tmp) + $part]))
		{
			return $tmp[count($tmp) + $part];
		}
		
		return $tmp;
	}*/

	/**
	 * Extract the requestID attribute from an XML stream
	 * 
	 * @param string $xml	The XML stream to look for a requestID attribute in
	 * @return mixed		The request ID
	 */
	static public function extractRequestID($xml)
	{
		$look = array(
			
			);
		
		if (false !== ($start = strpos($xml, ' requestID="')) and 
			false !== ($end = strpos($xml, '"', $start + 12)))
		{
			return substr($xml, $start + 12, $end - $start - 12);
		}
		
		return false;
	}
	
	/**
	 * Create a requestID string from action and ident parts
	 * 
	 * @param string $action
	 * @param mixed $ident
	 * @return string
	 */
	static public function constructRequestID($action, $ident)
	{
		return base64_encode($action . '|' . $ident);
	}
	
	/**
	 * Parse a requestID string into it's action and ident parts
	 * 
	 * @param string $requestID
	 * @param string $action
	 * @param mixed $ident
	 * @return boolean
	 */
	static public function parseRequestID($requestID, &$action, &$ident)
	{
		$tmp = explode('|', base64_decode($requestID));
		
		if (count($tmp) == 2)
		{
			$action = $tmp[0];
			$ident = $tmp[1];
			
			return true;
		}
		
		$action = null;
		$ident = null;
		
		return false;
	}
	
	/**
	 * Create an instance of a driver class from a DSN connection string *or* a connection resource
	 * 
	 * You can actually pass in *either* a DSN-style connection string OR an already connected database resource
	 * 	- mysql://user:pass@localhost:port/database
	 * 	- $var (Resource ID #XYZ, valid MySQL connection resource)
	 * 
	 * @param mixed $dsn_or_conn	A DSN-style connection string or a PHP resource
	 * @param array $config			An array of configuration options for the driver
	 * @param array $hooks			An array mapping hooks to user-defined hook functions to call
	 * @param integer $log_level	
	 * @return object				A class instance, a child class of QuickBooks_Driver
	 */	
	static public function driverFactory($dsn_or_conn, $config = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL)
	{
		return QuickBooks_Driver_Factory::create($dsn_or_conn, $config, $hooks, $log_level);
	}

	/**
	 * 
	 * 
	 * @param string $module
	 * @param string $key
	 * @param mixed $value
	 * @param string $type
	 * @param array $opts
	 * @return boolean
	 */
	static public function configWrite($dsn, $user, $module, $key, $value, $type = null, $opts = null)
	{
		if ($Driver = QuickBooks_Utilities::driverFactory($dsn))
		{
			return $Driver->configWrite($user, $module, $key, $value, $type, $opts);
		}
		
		return false;
	}
	
	/**
	 * 
	 * 
	 * @param string $module
	 * @param string $key
	 * @param string $type
	 * @param array $opts
	 * @return mixed
	 */
	static public function configRead($dsn, $user, $module, $key, &$type, &$opts)
	{
		if ($Driver = QuickBooks_Utilities::driverFactory($dsn))
		{
			return $Driver->configRead($user, $module, $key, $type, $opts);
		}
		
		return false;
	}
	
	/**
	 * Convert a time interval to a number of seconds (i.e.: "1 hour" => 600, "3 hours" => 1800, "2 minutes" => 120, etc.)
	 * 
	 * @param mixed $interval
	 * @return integer
	 */
	static public function intervalToSeconds($interval)
	{
		if ( (string) (int) $interval === (string) $interval)
		{
			// It's already an integer... 
		}
		else
		{
			$intervals = array(
				'second' => 1, 
				'minute' => 60, 
				'hour' => 60 * 60, 
				'day' => 60 * 60 * 24, 
				'week' => 60 * 60 * 24 * 7, 
				'month' => 60 * 60 * 24 * 30, 
				'year' => 60 * 60 * 24 * 365,
				);
				
			$interval = strtolower(trim($interval));
				
			$justletters = true;
			$count = strlen($interval);
			for ($i = 0; $i < $count; $i++)
			{
				if (ord($interval{$i}) < 97 or ord($interval{$i}) > 122)
				{
					$justletters = false;
				}
			}
				
			if ($justletters)
			{
				$interval = '1 ' . $interval;
			}
				
			foreach ($intervals as $str => $multiplier)
			{
				if (false !== strpos($interval, ' ' . $str))
				{
					$interval = ((int) $interval) * $multiplier;
				}
			}
		}
		
		// If it's not an integer yet, cast it!
		return (int) $interval;
	}
		
	/**
	 * Check if a given IP address lies within a CIDR range
	 * 
	 * @param string $remoteaddr		The remote machine's IP address (example: 192.168.1.4)
	 * @param string $CIDR				A CIDR network address (example: 192.168.0.0/24)
	 * @return boolean
	 */
	static protected function _checkCIDR($remoteaddr, $CIDR)
	{
		$remoteaddr_long = ip2long($remoteaddr);
		
		list ($net, $mask) = split('/', $CIDR);
		$ip_net = ip2long($net);
		$ip_mask = ~((1 << (32 - $mask)) - 1);
		
		$remoteaddr_net = $remoteaddr_long & $ip_mask;
		
		return $remoteaddr_net == $ip_net;
	}

	/**
	 * Check if a given remote address (IP address) is allowed based on allow and deny arrays
	 * 
	 * @param string $remoteaddr
	 * @param array $allow
	 * @param array $deny
	 * @return boolean
	 */	
	static public function checkRemoteAddress($remoteaddr, $arr_allow, $arr_deny)
	{
		$allowed = true;
		
		if (count($arr_allow))
		{
			// only allow these addresses
			$allowed = false;
			
			foreach ($arr_allow as $allow)
			{
				if (false !== strpos($allow, '/'))
				{
					// CIDR notation
					
					if (QuickBooks_Utilities::_checkCIDR($remoteaddr, $allow))
					{
						$allowed = true;
						break;
					}
				}
				else if (ereg('^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$', $allow))
				{
					// IPv4 address
					
					if ($remoteaddr == $allow)
					{
						$allowed = true;
						break;
					}
				}
			}
			
			if (!$allowed)
			{
				return false;
			}
		}
		
		if (count($arr_deny))
		{
			// do *not* allow these addresses
			foreach ($arr_deny as $deny)
			{
				if (false !== strpos($deny, '/'))
				{
					// CIDR notation
					
					if (QuickBooks_Utilities::_checkCIDR($remoteaddr, $deny))
					{
						return false;
					}
				}
				else if (ereg('^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$', $deny))
				{
					// IPv4 address
					
					if ($remoteaddr == $deny)
					{
						return false;
					}
				}
			}
		}
		
		return $allowed;
	}
	
	
	/**
	 * Create a user for the QuickBooks Web Connector SOAP server
	 * 
	 * @param string $dsn		A DSN-style connection string for the back-end driver
	 * @param string $username	The username for the new user
	 * @param string $password	The password for the new user
	 * @param string $company_file				
	 * @param string $wait_before_next_update	
	 * @param string $min_run_every_n_seconds	
	 * @return boolean 			
	 */
	static public function createUser($dsn, $username, $password, $company_file = null, $wait_before_next_update = null, $min_run_every_n_seconds = null)
	{
		$driver = QuickBooks_Utilities::driverFactory($dsn);
		
		return $driver->authCreate($username, $password, $company_file, $wait_before_next_update, $min_run_every_n_seconds);
	}
	
	/**
	 * Disable a user for the QuickBooks Web Connector SOAP server
	 * 
	 * @param string $dsn		A DSN-style connection string
	 * @param string $username	The username for the user to disable
	 * @return boolean
	 */
	static public function disableUser($dsn, $username)
	{
		$driver = QuickBooks_Utilities::driverFactory($dsn);
		
		return $driver->authDisable($username);
	}
	
	/**
	 * Generate a unique hash from a bunch of variables
	 * 
	 * @param mixed $mixed1
	 * @param mixed $mixed2
	 * @param mixed $mixed3
	 * @param mixed $mixed4
	 * @param mixed $mixed5
	 * @return string
	 */
	static public function generateUniqueHash($mixed1, $mixed2 = null, $mixed3 = null, $mixed4 = null, $mixed5 = null)
	{
		return md5(serialize($mixed1) . serialize($mixed2) . serialize($mixed3) . serialize($mixed4) . serialize($mixed5));
	}
	
	/**
	 * Create a mapping between a QuickBooks object and an object in your own database/application
	 * 
	 * @param string $dsn
	 * @param string $user
	 * @param string $object_type
	 * @param string $TxnID_or_ListID
	 * @param string $app_ID
	 * @return boolean
	 */
	public static function createMapping($dsn, $user, $object_type, $TxnID_or_ListID, $app_ID, $editsequence = '')
	{
		$Driver = QuickBooks_Utilities::driverFactory($dsn);
		
		return $Driver->identMap($user, $object_type, $app_ID, $TxnID_or_ListID, $editsequence);
	}
	
	/**
	 * 
	 * 
	 * @param string $dsn
	 * @param string $user
	 * @param string $object_type
	 * @param string $TxnID_or_ListID
	 * @return mixed
	 */
	public static function fetchApplicationID($dsn, $user, $object_type, $TxnID_or_ListID)
	{
		$Driver = QuickBooks_Utilities::driverFactory($dsn);
		
		$extra = null;
		return $Driver->identToApplication($user, $object_type, $TxnID_or_ListID, $extra);
	}
	
	/**
	 * 
	 */
	public static function hasApplicationID($dsn, $user, $object_type, $TxnID_or_ListID)
	{
		if (QuickBooks_Utilities::fetchApplicationID($dsn, $user, $object_type, $TxnID_or_ListID))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * @param string $object_type	A QuickBooks object-type constant, i.e.: QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_OBJECT_INVOICE, etc. 
	 * @param mixed $webapp_ID		The unique ID or PRIMARY KEY of the object within your application
	 * @return string				A QuickBooks TxnID or ListID
	 */
	public static function fetchQuickbooksID($dsn, $user, $object_type, $webapp_ID)
	{
		$Driver = QuickBooks_Utilities::driverFactory($dsn);
		
		$editseq = null;
		$extra = null;
		return $Driver->identToQuickBooks($user, $object_type, $webapp_ID, $editseq, $extra);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public static function fetchQuickBooksEditSequence($dsn, $user, $object_type, $webapp_ID)
	{
		$Driver = QuickBooks_Utilities::driverFactory($dsn);
		
		$editseq = null;
		$extra = null;
		$Driver->identToQuickBooks($user, $object_type, $webapp_ID, $editseq, $extra);
		return $editseq;
	}
	
	/**
	 * Fetches extra data stored along with the mapping of a QuickBooks ListID or TxnID to application primary key
	 * 
	 * @param string $dsn			The driver connection string 
	 * @param string $user			The QuickBooks username
	 * @param string $object_type	The object type (e.g. QUICKBOOKS_OBJECT_CUSTOMER, or QUICKBOOKS_OBJECT_INVOICE, etc.)
	 * @param mixed $webapp_ID		The primary key for the record 
	 * @return mixed 				Any extra data stored 
	 */
	public static function fetchQuickBooksExtra($dsn, $user, $object_type, $webapp_ID)
	{
		$Driver = QuickBooks_Utilities::driverFactory($dsn);
		
		$editseq = null;
		$extra = null;
		$Driver->identToQuickBooks($user, $object_type, $webapp_ID, $editseq, $extra);
		
		return $extra;
	}
	
	/**
	 * Alias of {@link QuickBooks_Utilities::fetchQuickBooksEditSequence()}
	 */
	public static function fetchEditSequence($dsn, $user, $object_type, $webapp_ID)
	{
		return QuickBooks_Utilities::fetchQuickBooksEditSequence($dsn, $user, $object_type, $webapp_ID);
	}
	
	/**
	 * Tell whether or not a given object has a ListID or TxnID associated with it
	 * 
	 * * Note *
	 * This function *does not* query QuickBooks, it only queries the internal 
	 * mapping of QuickBooks IDs to PRIMARY KEYS. The mappings can be created 
	 * with the {@link QuickBooks_Utilities::createMapping()} method and the API 
	 * tries to automatically create the mapping when you add or update an 
	 * object and provide a PRIMARY KEY when calling the ->add* or ->update* 
	 * method.  
	 * 
	 * @param string $object_type
	 * @param mixed $app_ID
	 * @return boolean
	 */
	public static function hasQuickBooksID($dsn, $user, $object_type, $app_ID)
	{
		if (QuickBooks_Utilities::fetchQuickBooksID($dsn, $user, $object_type, $app_ID))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Initialize the backend driver
	 * 
	 * Initialization should only be done once, and is used to take care of 
	 * things like creating the database schema, etc.
	 * 
	 * @param string $dsn				A DSN-style connection string
	 * @param array $driver_options
	 * @return boolean
	 */
	static public function initialize($dsn, $driver_options = array(), $init_options = array())
	{
		$Driver = QuickBooks_Utilities::driverFactory($dsn, $driver_options);
		
		return $Driver->initialize($init_options);
	}
	
	/**
	 * Tell whether or not a driver has been initialized
	 * 
	 * @param string $dsn
	 * @param array $driver_options
	 * @return boolean
	 */
	static public function initialized($dsn, $driver_options = array())
	{
		$Driver = QuickBooks_Utilities::driverFactory($dsn, $driver_options);
		
		return $Driver->initialized();
	}
	
	/**
	 * 
	 * 
	 */
	static public function date($date = null)
	{
		if ($date)
		{
			if (is_numeric($date) and 
				strlen($date) > 6)
			{
				return date('Y-m-d', $date);
			}
			
			return date('Y-m-d', strtotime($date));
		}
		
		return date('Y-m-d');
	}
	
	/**
	 *
	 *
	 * @return string
	 */
	static public function datetime($datetime = null)
	{
		if ($datetime)
		{
			if (is_numeric($datetime) and 
				strlen($datetime) > 6)
			{
				return date('Y-m-d', $datetime) . 'T' . date('H:i:s', $datetime);
			}
			
			return date('Y-m-d', strtotime($datetime)) . 'T' . date('H:i:s', strtotime($datetime));
		}
		
		return date('Y-m-d') . 'T' . date('H:i:s');
	}
		
	/**
	 * Tell if a pattern matches a string or not (Windows-compatible version of www.php.net/fnmatch)
	 * 
	 * @param string $pattern
	 * @param string $str
	 * @return boolean
	 */
	static public function fnmatch($pattern, $str)
	{
		if (function_exists('fnmatch'))
		{
			return fnmatch($pattern, $str, FNM_CASEFOLD);
		}
		
		$arr = array(
			'\*' => '.*', 
			'\?' => '.'
			);
		return preg_match('#^' . strtr(preg_quote($pattern, '#'), $arr) . '$#i', $str);
	}
	
	/**
	 * List all of the QuickBooks object types supported by the framework
	 * 
	 * @todo 	We might be able to optimize this a bit to not use create_function()
	 * 
	 * @param string $filter
	 * @param boolean $return_keys
	 * @param boolean $order_for_mapping
	 * @return array
	 */
	static public function listObjects($filter = null, $return_keys = false, $order_for_mapping = false)
	{
		static $cache = array();
		
		$crunch = $filter . '[' . $return_keys . '[' . $order_for_mapping;
		
		if (isset($cache[$crunch]))
		{
			return $cache[$crunch];
		}
		
		$constants = array();
			
		foreach (get_defined_constants() as $constant => $value)
		{
			if (substr($constant, 0, strlen('QUICKBOOKS_OBJECT_')) == 'QUICKBOOKS_OBJECT_' and 
				substr_count($constant, '_') == 2)
			{
				if (!$return_keys)
				{
					$constant = $value;
				}
				
				if ($filter)
				{
					if (QuickBooks_Utilities::fnmatch($filter, $constant))
					{
						$constants[] = $constant;
					}
				}
				else
				{
					$constants[] = $constant;
				}
			}
		}
			
		if ($order_for_mapping)
		{
			// Sort with the very longest values first, to the shortest values last
			
			$func = create_function('$a, $b', ' if (strlen($a) > strlen($b)) { return -1; } return 1; ');
			usort($constants, $func);
		}
		else
		{
			sort($constants);
		}
			
		$cache[$crunch] = $constants;
			
		return $constants;
	}
		
	/**
	 * Convert a QuickBooks action to a QuickBooks object type (i.e.: QUICKBOOKS_ADD_CUSTOMER gets converted to QUICKBOOKS_OBJECT_CUSTOMER)
	 * 
	 * @param string $action
	 * @return string
	 */
	static public function actionToObject($action)
	{
		static $cache = array();
		
		if (isset($cache[$action]))
		{
			//print('returning cached [' . $action . ']' . "\n");
			return $cache[$action];
		}
		
		$types = QuickBooks_Utilities::listObjects(null, false, true);
		
		foreach ($types as $type)
		{
			if (QuickBooks_Utilities::fnmatch('*' . $type . '*', $action))
			{
				$cache[$action] = $type;
				//print('returning [' . $action . '] => ' . $type . "\n");
				return $type;
			}
		}
			
		return null;
	}
		
	/**
	 * Try to guess the queueing priority for this action
	 * 
	 * @param string $action		The action you're trying to guess for
	 * @param string $dependency	If the action depends on another action (i.e. a DataExtAdd for a CustomerAdd) you can pass the dependency here
	 * @return integer				A best guess at the proper priority
	 */
	static public function priorityForAction($action, $dependency = null)
	{
		// low priorities up here (*lots* of dependencies)
		static $priorities = array(
			QUICKBOOKS_DELETE_TRANSACTION, 
			
			QUICKBOOKS_VOID_TRANSACTION, 
		
			QUICKBOOKS_DEL_DATAEXT, 
			QUICKBOOKS_MOD_DATAEXT,
			QUICKBOOKS_ADD_DATAEXT, 
		
			QUICKBOOKS_MOD_JOURNALENTRY, 
			QUICKBOOKS_ADD_JOURNALENTRY, 
		
			QUICKBOOKS_MOD_RECEIVEPAYMENT, 
			QUICKBOOKS_ADD_RECEIVEPAYMENT, 
			
			QUICKBOOKS_MOD_BILLPAYMENTCHECK, 
			QUICKBOOKS_ADD_BILLPAYMENTCHECK, 
			
			//QUICKBOOKS_MOD_BILLPAYMENTCREDITCARD, 
			QUICKBOOKS_ADD_BILLPAYMENTCREDITCARD, 
			
			QUICKBOOKS_MOD_BILL, 
			QUICKBOOKS_ADD_BILL, 
			
			QUICKBOOKS_MOD_PURCHASEORDER, 
			QUICKBOOKS_ADD_PURCHASEORDER, 
			
			QUICKBOOKS_MOD_INVOICE,
			QUICKBOOKS_ADD_INVOICE,
			
			QUICKBOOKS_MOD_SALESORDER, 
			QUICKBOOKS_ADD_SALESORDER, 
			
			QUICKBOOKS_MOD_ESTIMATE, 
			QUICKBOOKS_ADD_ESTIMATE, 
			
			QUICKBOOKS_ADD_CREDITMEMO, 
			QUICKBOOKS_MOD_CREDITMEMO, 
			
			QUICKBOOKS_ADD_INVENTORYADJUSTMENT, 

			QUICKBOOKS_ADD_ITEMRECEIPT,
			QUICKBOOKS_MOD_ITEMRECEIPT,

			QUICKBOOKS_MOD_SALESRECEIPT, 
			QUICKBOOKS_ADD_SALESRECEIPT, 

			QUICKBOOKS_ADD_SALESTAXITEM, 
			QUICKBOOKS_MOD_SALESTAXITEM, 
			
			QUICKBOOKS_ADD_DISCOUNTITEM, 
			QUICKBOOKS_MOD_DISCOUNTITEM, 
			
			QUICKBOOKS_ADD_OTHERCHARGEITEM, 
			QUICKBOOKS_MOD_OTHERCHARGEITEM, 
			
			QUICKBOOKS_MOD_NONINVENTORYITEM, 
			QUICKBOOKS_ADD_NONINVENTORYITEM,
			
			QUICKBOOKS_MOD_INVENTORYITEM,  
			QUICKBOOKS_ADD_INVENTORYITEM, 
			
			QUICKBOOKS_MOD_INVENTORYASSEMBLYITEM,
			QUICKBOOKS_ADD_INVENTORYASSEMBLYITEM,
			
			QUICKBOOKS_MOD_SERVICEITEM, 
			QUICKBOOKS_ADD_SERVICEITEM, 
			
			QUICKBOOKS_MOD_PAYMENTITEM, 
			QUICKBOOKS_ADD_PAYMENTITEM, 
			
			QUICKBOOKS_MOD_SALESREP, 
			QUICKBOOKS_ADD_SALESREP, 
			
			QUICKBOOKS_MOD_EMPLOYEE, 
			QUICKBOOKS_ADD_EMPLOYEE, 
			
			//QUICKBOOKS_MOD_SALESTAXCODE, 		// The SDK doesn't support this
			QUICKBOOKS_ADD_SALESTAXCODE, 
			
			QUICKBOOKS_MOD_VENDOR, 
			QUICKBOOKS_ADD_VENDOR, 
			
			QUICKBOOKS_MOD_CUSTOMER,
			QUICKBOOKS_ADD_CUSTOMER,
			
			QUICKBOOKS_MOD_ACCOUNT, 
			QUICKBOOKS_ADD_ACCOUNT, 
			
			//QUICKBOOKS_MOD_CLASS,		(does not exist in qbXML API) 
			QUICKBOOKS_ADD_CLASS, 
			
			QUICKBOOKS_ADD_PAYMENTMETHOD, 
			QUICKBOOKS_ADD_SHIPMETHOD, 
			
			// Queries 
			QUICKBOOKS_QUERY_PURCHASEORDER,
			QUICKBOOKS_QUERY_ITEMRECEIPT,
			QUICKBOOKS_QUERY_SALESORDER, 
			QUICKBOOKS_QUERY_SALESRECEIPT, 
			QUICKBOOKS_QUERY_INVOICE,
			QUICKBOOKS_QUERY_ESTIMATE, 
			QUICKBOOKS_QUERY_RECEIVEPAYMENT, 
			QUICKBOOKS_QUERY_CREDITMEMO, 
			
			QUICKBOOKS_QUERY_BILLPAYMENTCHECK, 
			QUICKBOOKS_QUERY_BILLPAYMENTCREDITCARD, 
			QUICKBOOKS_QUERY_BILLTOPAY, 
			QUICKBOOKS_QUERY_BILL, 
			
			QUICKBOOKS_QUERY_CREDITCARDCHARGE, 
			QUICKBOOKS_QUERY_CREDITCARDCREDIT, 
			QUICKBOOKS_QUERY_CHECK, 
			QUICKBOOKS_QUERY_CHARGE,
			
			QUICKBOOKS_QUERY_DELETEDLISTS,		// This gets all items deleted in the last 90 days
			QUICKBOOKS_QUERY_DELETEDTXNS,		// This gets all transactions deleted in the last 90 days
			
			QUICKBOOKS_QUERY_TIMETRACKING, 
			QUICKBOOKS_QUERY_VENDORCREDIT, 
			
			QUICKBOOKS_QUERY_INVENTORYADJUSTMENT, 
			
			QUICKBOOKS_QUERY_ITEM, 
			QUICKBOOKS_QUERY_DISCOUNTITEM, 
			QUICKBOOKS_QUERY_SALESTAXITEM, 
			QUICKBOOKS_QUERY_SERVICEITEM,
			QUICKBOOKS_QUERY_NONINVENTORYITEM, 
			QUICKBOOKS_QUERY_INVENTORYITEM, 

			QUICKBOOKS_QUERY_SALESREP, 

			QUICKBOOKS_QUERY_VEHICLEMILEAGE, 
			QUICKBOOKS_QUERY_VEHICLE, 

			QUICKBOOKS_QUERY_CUSTOMER,
			QUICKBOOKS_QUERY_VENDOR, 
			QUICKBOOKS_QUERY_EMPLOYEE, 

			QUICKBOOKS_QUERY_WORKERSCOMPCODE, 

			QUICKBOOKS_QUERY_UNITOFMEASURESET,
			
			QUICKBOOKS_QUERY_JOURNALENTRY, 
			QUICKBOOKS_QUERY_DEPOSIT,  

			QUICKBOOKS_QUERY_SHIPMETHOD, 
			QUICKBOOKS_QUERY_PAYMENTMETHOD, 
			QUICKBOOKS_QUERY_PRICELEVEL, 
			QUICKBOOKS_QUERY_DATEDRIVENTERMS, 
			QUICKBOOKS_QUERY_BILLINGRATE, 
			QUICKBOOKS_QUERY_CUSTOMERTYPE, 
			QUICKBOOKS_QUERY_CUSTOMERMSG, 
			QUICKBOOKS_QUERY_TERMS, 
			QUICKBOOKS_QUERY_SALESTAXCODE, 
			QUICKBOOKS_QUERY_ACCOUNT, 
			QUICKBOOKS_QUERY_CLASS, 
			QUICKBOOKS_QUERY_JOBTYPE, 
			QUICKBOOKS_QUERY_VENDORTYPE, 
			
			QUICKBOOKS_QUERY_COMPANY, 
			
			
			QUICKBOOKS_IMPORT_RECEIVEPAYMENT, 
			
			
			QUICKBOOKS_IMPORT_PURCHASEORDER,
			QUICKBOOKS_IMPORT_ITEMRECEIPT,
			QUICKBOOKS_IMPORT_SALESRECEIPT, 
			
			// The ESTIMATE, then INVOICE, then SALES ORDER order is important, 
			//	because we might have events which depend on the estimate being present 
			//	when the invoice is imported, or the sales order being present when 
			//	then invoice is imported, etc. 
			QUICKBOOKS_IMPORT_INVOICE,
			QUICKBOOKS_IMPORT_SALESORDER, 
			QUICKBOOKS_IMPORT_ESTIMATE, 
			
			QUICKBOOKS_IMPORT_BILLPAYMENTCHECK, 
			QUICKBOOKS_IMPORT_BILLPAYMENTCREDITCARD, 
			QUICKBOOKS_IMPORT_BILLTOPAY, 
			QUICKBOOKS_IMPORT_BILL, 
			
			QUICKBOOKS_IMPORT_CREDITCARDCHARGE, 
			QUICKBOOKS_IMPORT_CREDITCARDCREDIT, 
			QUICKBOOKS_IMPORT_CHECK, 
			QUICKBOOKS_IMPORT_CHARGE,
			
			QUICKBOOKS_IMPORT_DELETEDLISTS,    // This gets all items deleted in the last 90 days.
			QUICKBOOKS_IMPORT_DELETEDTXNS,    // This gets all transactions deleted in the last 90 days.
			
			QUICKBOOKS_IMPORT_TIMETRACKING, 
			QUICKBOOKS_IMPORT_VENDORCREDIT, 
			
			QUICKBOOKS_IMPORT_INVENTORYADJUSTMENT, 
			
			QUICKBOOKS_IMPORT_ITEM, 
			QUICKBOOKS_IMPORT_DISCOUNTITEM, 
			QUICKBOOKS_IMPORT_SALESTAXITEM, 
			QUICKBOOKS_IMPORT_SERVICEITEM,
			QUICKBOOKS_IMPORT_NONINVENTORYITEM, 
			QUICKBOOKS_IMPORT_INVENTORYITEM, 
			QUICKBOOKS_IMPORT_INVENTORYASSEMBLYITEM,

			QUICKBOOKS_IMPORT_SALESREP, 

			QUICKBOOKS_IMPORT_VEHICLEMILEAGE, 
			QUICKBOOKS_IMPORT_VEHICLE, 

			QUICKBOOKS_IMPORT_CUSTOMER,
			QUICKBOOKS_IMPORT_VENDOR, 
			QUICKBOOKS_IMPORT_EMPLOYEE, 

			QUICKBOOKS_IMPORT_WORKERSCOMPCODE, 

			QUICKBOOKS_IMPORT_UNITOFMEASURESET,
			
			QUICKBOOKS_IMPORT_JOURNALENTRY, 
			QUICKBOOKS_IMPORT_DEPOSIT,  

			QUICKBOOKS_IMPORT_SHIPMETHOD, 
			QUICKBOOKS_IMPORT_PAYMENTMETHOD, 
			QUICKBOOKS_IMPORT_PRICELEVEL, 
			QUICKBOOKS_IMPORT_DATEDRIVENTERMS, 
			QUICKBOOKS_IMPORT_BILLINGRATE, 
			QUICKBOOKS_IMPORT_CUSTOMERTYPE, 
			QUICKBOOKS_IMPORT_CUSTOMERMSG, 
			QUICKBOOKS_IMPORT_TERMS, 
			QUICKBOOKS_IMPORT_SALESTAXCODE, 
			QUICKBOOKS_IMPORT_ACCOUNT, 
			QUICKBOOKS_IMPORT_CLASS, 
			QUICKBOOKS_IMPORT_JOBTYPE, 
			QUICKBOOKS_IMPORT_VENDORTYPE, 
			
			QUICKBOOKS_IMPORT_COMPANY, 
		);
		// high priorities down here (no dependencies OR queries)
		
		// Now, let's space those priorities out a little bit, it gives us some 
		//	wiggle room in case we need to add things inbetween the default 
		//	priority values
		static $wiggled = false;
		$wiggle = 6;
		
		if (!$wiggled)
		{
			$count = count($priorities);
			for ($i = $count - 1; $i >= 0; $i--)
			{
				$priorities[$i * $wiggle] = $priorities[$i];
				unset($priorities[$i]);
				
				// with a wiggle multiplier of 2...
				// 	priority 25 goes to 50
				// 	priority 24 goes to 48
				// 	priority 23 goes to 46
				// 	etc. etc. etc. 
			}
			
			$wiggled = true;
			
			//print_r($priorities);
		}
		
		if ($dependency)
		{
			// 
			// This is a list of dependency modifications
			//	For instance, normally, you'd want to send just any  old DataExtAdd 
			//	with a really low priority, because whatever record it applies to 
			//	must be in QuickBooks before you send the DataExtAdd/Mod request. 
			// 
			//	However, if we pass in the $dependency of QUICKBOOKS_ADD_CUSTOMER, 
			//	then we know that this DataExt applies to a CustomerAdd, and can 
			//	therefore be sent with a priority *just barely lower than* than a 
			//	CustomerAdd request, which will ensure this gets run as soon as 
			//	possible, but not sooner than the CustomerAdd.
			// 
			//	This is important because in some cases, this data will be 
			//	automatically used by QuickBooks. For instance, a custom field that 
			//	is placed on an Invoice *must already be populated for the 
			//	Customer* before the invoice is created. 
			//
			// This is an example of a priority list without dependencies, and it's bad: 	
			//	CustomerAdd, InvoiceAdd, DataExtAdd		
			//	(the custom field for the customer doesn't get populated in the invoice)
			//
			// This is an example of a priority list with dependencies, and it's good: 
			// 	CustomerAdd, DataExtAdd, InvoiceAdd
			//	
			$dependencies = array(
				QUICKBOOKS_ADD_DATAEXT => array( 
					QUICKBOOKS_ADD_CUSTOMER => QuickBooks_Utilities::priorityForAction(QUICKBOOKS_ADD_CUSTOMER) - 1, 
					QUICKBOOKS_MOD_CUSTOMER => QuickBooks_Utilities::priorityForAction(QUICKBOOKS_MOD_CUSTOMER) - 1, 
				),
				QUICKBOOKS_MOD_DATAEXT => array(
					QUICKBOOKS_ADD_CUSTOMER => QuickBooks_Utilities::priorityForAction(QUICKBOOKS_ADD_CUSTOMER) - 1, 
					QUICKBOOKS_MOD_CUSTOMER => QuickBooks_Utilities::priorityForAction(QUICKBOOKS_MOD_CUSTOMER) - 1, 
					),
					
				// A *Bill VOID* has a slightly higher priority than a PurchaseOrderMod so that we can IsManuallyClosed POs (we'll get an error if we try to close it and a bill is dependent on it)  
				QUICKBOOKS_VOID_TRANSACTION => array(
					QUICKBOOKS_MOD_PURCHASEORDER => QuickBooks_Utilities::priorityForAction(QUICKBOOKS_MOD_PURCHASEORDER) + 1, 
					), 
				);			
		}
		
		// Check for dependency priorities
		if ($dependency and 
			isset($dependencies[$action]) and 
			isset($dependencies[$action][$dependency]))
		{			
			// Dependency modified priority
			return $dependencies[$action][$dependency];
		}
		else if ($key = array_search($action, $priorities))
		{
			// Regular priority
			return $key;
		}
		
		// Default priority
		return 999;		
	}
		
	/**
	 * List all of the QuickBooks actions the framework supports
	 * 
	 * @param string $filter
	 * @param boolean $return_keys
	 * @return array
	 */
	static public function listActions($filter = null, $return_keys = false)
	{
		$startswith = array(
			'QUICKBOOKS_IMPORT_', 
			'QUICKBOOKS_QUERY_', 
			'QUICKBOOKS_ADD_', 
			'QUICKBOOKS_MOD_', 
			'QUICKBOOKS_DEL_', 
			'QUICKBOOKS_VOID_', 
			);
			
		$constants = array();
		
		//$inter_key = 'QUICKBOOKS_INTERACTIVE_MODE';
		//$inter_val = QUICKBOOKS_INTERACTIVE_MODE;
		/*
		if (is_null($filter))
		{
			if ($return_keys)
			{
				$constants[] = $inter_key;
			}
			else
			{
				$constants[] = $inter_val;
			}
		}
		*/
		/*
		else if ($return_keys and QuickBooks_Utilities::fnmatch($filter, $inter_key))
		{
			$constants[] = $inter_key;
		}
		else if (!$return_keys and QuickBooks_Utilities::fnmatch($filter, $inter_val))
		{
			$constants[] = $inter_val;
		}
		*/
			
		foreach (get_defined_constants() as $constant => $value)
		{
			foreach ($startswith as $start)
			{
				if (substr($constant, 0, strlen($start)) == $start)
				{
					if (!$return_keys)
					{
						$constant = $value;
					}
					
					if (!is_null($filter))
					{
						if (QuickBooks_Utilities::fnmatch($filter, $constant))
						{
							$constants[] = $constant;
						}
					}
					else
					{
						$constants[] = $constant;
					}
				}
			}
		}
			
		sort($constants);
			
		return $constants;
	}
	
	/**
	 * Get the primary key within QuickBooks for this type of object (or this type of action)
	 * 
	 * <code>
	 * 	// This prints "ListID"
	 * 	print(QuickBooks_Utilities::keyForObject(QUICKBOOKS_OBJECT_CUSTOMER));
	 * 
	 * 	// This prints "TxnID"  (this method also works for actions)
	 * 	print(QuickBooks_Utilities::keyForObject(QUICKBOOKS_ADD_INVOICE));
	 * </code>
	 * 
	 * @param string $object		An object or action type
	 * @return string
	 */
	static public function keyForObject($object)
	{
		// Make sure it's an object
		$object = QuickBooks_Utilities::actionToObject($object);
		
		switch ($object)
		{
			case QUICKBOOKS_OBJECT_BILLPAYMENTCREDITCARD:
			case QUICKBOOKS_OBJECT_INVENTORYADJUSTMENT:
			case QUICKBOOKS_OBJECT_BILLPAYMENTCHECK:
			case QUICKBOOKS_OBJECT_CREDITCARDCREDIT:
			case QUICKBOOKS_OBJECT_CREDITCARDCHARGE:
			case QUICKBOOKS_OBJECT_VEHICLEMILEAGE:
			case QUICKBOOKS_OBJECT_RECEIVEPAYMENT:
			case QUICKBOOKS_OBJECT_PURCHASEORDER:
			case QUICKBOOKS_OBJECT_TIMETRACKING:
			case QUICKBOOKS_OBJECT_SALESRECEIPT:
			case QUICKBOOKS_OBJECT_VENDORCREDIT:
			case QUICKBOOKS_OBJECT_JOURNALENTRY:
			case QUICKBOOKS_OBJECT_TRANSACTION:
			case QUICKBOOKS_OBJECT_ITEMRECEIPT:
			case QUICKBOOKS_OBJECT_CREDITMEMO:
			case QUICKBOOKS_OBJECT_SALESORDER:
			case QUICKBOOKS_OBJECT_BILLTOPAY:
			case QUICKBOOKS_OBJECT_ESTIMATE:
			case QUICKBOOKS_OBJECT_DEPOSIT:
			case QUICKBOOKS_OBJECT_INVOICE:
			case QUICKBOOKS_OBJECT_CHARGE:
			case QUICKBOOKS_OBJECT_CHECK:
			case QUICKBOOKS_OBJECT_BILL:
				return 'TxnID';
			case QUICKBOOKS_OBJECT_COMPANY:
				return 'CompanyName';
			default:
				return 'ListID';
		}
	}
	
	/**
	 * Alias of QuickBooks_Utilities::keyForObject()
	 */
	static public function keyForAction($action)
	{
		return QuickBooks_Utilities::keyForObject($action);
	}
			
	/**
	 * Converts an action to a request (example: "CustomerAdd" to "CustomerAddRq")
	 * 
	 * @param string $action
	 * @return string
	 */
	static public function actionToRequest($action)
	{
		return $action . 'Rq';
	}
		
	/**
	 * Converts an action to a response (example: "CustomerAdd" to "CustomerAddRs")
	 * 
	 * @param string $action
	 * @return string
	 */
	static public function actionToResponse($action)
	{
		return $action . 'Rs';
	}
		
	/**
	 * Converts a request to an action (example: "CustomerAddRq" to "CustomerAdd")
	 * 
	 * @param string $request
	 * @return string
	 */
	static public function requestToAction($request)
	{
		return substr($request, 0, -2);
	}
		
	/**
	 * Converts an action to an XML Element (example: "CustomerAdd" to "CustomerRet")
	 * 
	 * @param string $action
	 * @return string
	 */
	static public function objectToXMLElement($object)
	{
		return $object . 'Ret';
	}
		
	/**
	 * Converts an action to an XML Element (example: "CustomerAdd" to "CustomerRet")
	 * 
	 * @param string $action
	 * @return string
	 */
	static public function actionToXMLElement($action)
	{
		return QuickBooks_Utilities::actionToObject($action) . 'Ret';
	}
		
	/**
	 * Converts an object type to the corresponding Query Action (example: "Customer" to "CustomerQuery")
	 * 
	 * @param string $type
	 * @return string
	 */
	static public function objectToQuery($type)
	{
		return QuickBooks_Utilities::actionToObject($type) . 'Query';
	}
		
	/**
	 * Converts an object type to the corresponding Mod Action
	 * Ex: Customer to CustomerMod
	 */
	static public function objectToMod($type)
	{
		return QuickBooks_Utilities::actionToObject($type) . 'Mod';
	}
		
	/**
	 * Converts an object type to the corresponding Add Action
	 * Ex: Customer to CustomerAdd
	 */
	static public function objectToAdd($type)
	{
		return QuickBooks_Utilities::actionToObject($type) . 'Add';
	}
		
		
	/**
	 * Converts an actrion to the corresponding Query Action
	 * Ex: Customer to CustomerQuery
	 */
	static public function convertActionToQuery($action)
	{
		return QuickBooks_Utilities::objectToQuery(QuickBooks_Utilities::actionToObject($action));
	}
		
	/**
	 * Converts an action to the corresponding Mod Action
	 * Ex: Customer to CustomerQuery
	 */
	static public function convertActionToMod($action)
	{
		return QuickBooks_Utilities::objectToMod(QuickBooks_Utilities::actionToObject($action));
	}
		
	/**
	 * Converts a MySQL timestamp value to the timezone of the PHP server this script is running on.
	 * 
	 * @deprecated This need to be removed and moved to a driver class!
	 * 
	 * Expects $datetime in the formation of "YYYY-MM-DD HH:MM:SS"
	 * 
	 * @TODO Double check that a lack of a Driver Instance properly returns false.
	 * @TODO Investigate possible bug if within a few hours of daylight savings change.
	 * @TODO This should *not* be in the QuickBooks_Utilties class, any database queries that arn't abstracted need to be in QuickBooks/Driver/Sql/your-sql-file-here.php
	 */
	/*static public function mysqlTZToPHPTZ($datetime)
	{
		$Driver = QuickBooks_Driver_Singleton::getInstance();
			
		$sql = " SELECT UTC_TIME() AS theUtcTime, CURTIME() AS theCurTime ";
		$res = $Driver->query($sql, $errnum, $errmsg);
			
		if (!$res)
		{
			return false;
		}
			
		if (!($arr = $Driver->fetch($res)))
		{
			return false;
		}
			
		// get the time bits: 
		$utcTime = explode(":", $arr['theUtcTime']); 
		$curTime = explode(":", $arr['theCurTime']); 
		
		// create unix timestamps for each
		// since we're calculating a relative time only: 
		$utc_t = mktime($utcTime[0], $utcTime[1], $utcTime[2]); 
		$cur_t = mktime($curTime[0], $curTime[1], $curTime[2]); 
			
		$mysqlOffset = ($cur_t - $utc_t);
			
		$phpOffset = (int) date('Z');
			
		//mail("grgisme@gmail.com","Offsets","MysqlOffset: ".($mysqlOffset)."\n\n\nPHPOffset: ".$phpOffset);
			
		$timezoneDiff = $mysqlOffset - $phpOffset;
			
		$tempTime = explode(" ", $datetime);
			
		if (count($tempTime) != 2)//Improper input
		{
			return FALSE;
		}
			
		$mysqlTime = explode(":", $tempTime[1]);
			
		$mysql_t = mktime($mysqlTime[0], $mysqlTime[1], $mysqlTime[2]);
			
		$newMysqlTime = $mysql_t - $timezoneDiff;
			
		//mail("grgisme@gmail.com","TimeZone Diff","TimeZone Diff: ".($timezoneDiff));
			
		return $tempTime[0]." ".date("H:i:s", $newMysqlTime);
		
	}*/
	
	/**
	 * Compares a time reported from QuickBooks to a mysql datetime field
	 * Ex: QB Time: 2009-01-23T08:33:56-05:00
	 *     SQL Time: 2009-01-23 08:31:11
	 * 
	 * @deprecated This needs to be moved to a driver class!
	 * 
	 * Returns -1 if QB Time is Smaller
	 * Returns 0 if Times are Equal
	 * Returns 1 if QB Time is Greater
	 * Returns FALSE on Error
	 */
	/*static public function compareQBTimeToSQLTime($QBTime, $SQLTime)
	{
		$SQLTime = QuickBooks_Utilities::mysqlTZToPHPTZ($SQLTime);
			
		$tempTime = explode(" ", $SQLTime);
		$mysqlTime = explode(":", $tempTime[1]);
		$tempTime = explode("-", $tempTime[0]);
			
		$mysql_t = mktime($mysqlTime[0], $mysqlTime[1], $mysqlTime[2], $tempTime[1], $tempTime[2], $tempTime[0], 0);
		$QBTime = strtotime($QBTime);
			
		//mail("grgisme@gmail.com","QBTime","QBTime: ".($QBTime)."\n\n\nSQLTime: ".$mysql_t."\n\n\n".$SQLTime."\n\n\nDaylight Savings?: ".date('I'));
			
		if ($QBTime < $mysql_t)
			return -1;
		elseif($QBTime > $mysql_t)
			return 1;
		else
			return 0;
	}*/
}
