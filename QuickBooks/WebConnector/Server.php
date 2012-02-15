<?php

/**
 * QuickBooks SOAP server for interacting with the QuickBooks Web Connector 
 * 
 * Copyright (c) 2010-04-16 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * This class provides a framework for generating and handling messages to send 
 * to and from QuickBooks via the Web Connector. For every operation you wish 
 * to perform on QuickBooks, you should be expecting to implement two functions:
 * 	- A function responsible for generating the qbXML request (telling QuickBooks what you want to do)
 * 	- A function responsible for parsing and handling the qbXML response (handling the response form QuickBooks)
 * 
 * You should see the docs/example_server.php file for detailed examples of 
 * using this! 
 * 
 * Add items to the QuickBooks queue using the {@see QuickBooks_Queue} class. 
 * The next time the QuickBooks Web Connector connects to the SOAP server, it 
 * will be instructed to perform commands based on what has been placed in the 
 * queue. So if you queued up "CustomerAdd" "1234", #1234, 
 * customer_add_request() will generate a qbXML request telling QuickBooks to 
 * add that customer, the SOAP server will send that request out, and 
 * QuickBooks will send back a qbXML response indicating whether or not that 
 * customer was added successfully. .
 * 
 * The QuickBooks Web Connector (QBWC) works like this:
 * 	- You create a SOAP server that response to a set of SOAP methods
 * 	- You install and run the QBWC alongside your existing QuickBooks installation
 * 	- You register your SOAP server with the QBWC
 * 	- The QBWC calls the ->authenticate() method via a SOAP request
 * 	- You create and assign a 'ticket' (essentially a session ID value) to the QBWC session, this ticket gets sent to your SOAP server for authentication purposes with every request thereafter
 * 	- The QBWC calls the ->sendRequestXML() method via a SOAP request, if there is work to do, you send back qbXML commands encapsulated in an object
 * 	- The QBWC passes these qbXML commands to QuickBooks, QuickBooks processes them and passes them back
 * 	- The QBWC passes back the response from QuickBooks to your SOAP server via a SOAP call to ->receiveResponseXML()
 * 	- If you return an integer between 0 and 99 (inclusive) from ->receiveResponseXML(), the QBWC will call ->sendRequestXML() again, to get the next qbXML command
 * 	- Once you return a 100 from ->receiveResponseXML(), the QBWC calls ->closeConnection() and closes the socket connection shortly thereafter
 * 
 * Troubleshooting:
 * 	- Errors which QuickBooks reports will be logged (check the quickbooks_queue and quickbooks_log tables in your database)
 * 	- If actions get stuck in the queue and never seem to be pulled out, it is most likely that you're generating badly-formed XML for that request. Check the XML document you're creating for well-formedness, *and especially* character set issues
 * 	- The quickbooks_log database table shows everything that is happening 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * Hook which gets called when a request is received
 * @var string
 */
define('QUICKBOOKS_SERVER_HOOK_PREHANDLE', 'QuickBooks_Server::handle (pre)');

/**
 * Hook which gets called after a request gets handled
 * @var string
 */
define('QUICKBOOKS_SERVER_HOOK_POSTHANDLE', 'QuickBooks_Server::handle (post)');

/**
 * Base handlers for each of the methods required by the QuickBooks Web Connector
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Handlers.php');

/**
 * QuickBooks SOAP Server
 */
class QuickBooks_WebConnector_Server
{
	/**
	 * WSDL location
	 * @var string
	 */
	protected $_wsdl;
	
	/**
	 * The logging level
	 * @var integer
	 */
	protected $_loglevel;
	
	/**
	 * Driver instance object
	 * @var object
	 */
	protected $_driver;
	
	/**
	 * Server instance object
	 * @var object
	 */
	protected $_server;
	
	/**
	 * Registered hook functions for the server
	 * @var array 
	 */
	protected $_hooks;
	
	/**
	 * An array of data to pass to every callback function
	 * @var array
	 */
	protected $_callback_config;
	
	/**
	 * The raw input to the script
	 * @var string
	 */
	protected $_input;
	
	/**
	 * Create a new QuickBooks SOAP server
	 * 
	 * @param mixed $dsn_or_conn		Either a DSN-style connection string *or* a database resource (if reusing an existing connection)
	 * @param array $map				An associative array mapping queued commands to function/method calls
	 * @param array $onerror			An associative array mapping error codes to function/method calls
	 * @param arary $hooks				An associative array mapping events to hook function/method calls
	 * @param string $wsdl				The path to the WSDL file to use for the SOAP server methods
	 * @param array $soap_options		Options to pass to the SOAP server (these mirror the default PHP SOAP server options)
	 * @param array $handler_options	Options to pass to the handler class
	 * @param array $driver_options		Options to pass to the driver class (i.e.: MySQL, etc.)
	 */
	public function __construct($dsn_or_conn, $map, $onerror = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_BUILTIN, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array())
	{
		$soap_options = $this->_defaults($soap_options);
		
		// If safe mode is turned on, this causes a NOTICE/WARNING to be issued... 
		if (!ini_get('safe_mode'))
		{
			set_time_limit($soap_options['time_limit']);
		}
		
		/*
		if ($soap_options['error_handler'])
		{
			set_error_handler($soap_options['error_handler']);
		}
		else if ($soap_options['use_builtin_error_handler'])
		{
			set_error_handler( array( 'QuickBooks_ErrorHandler', 'handle' ) );
		}
		
		if ($soap_options['log_to_syslog'])
		{
			
		}
		
		if ($soap_options['log_to_file'])
		{
			
		}
		*/		

		// WSDL location
		$this->_wsdl = $wsdl;
		
		// Logging level
		$this->_loglevel = $log_level;
		
		if ($this->_loglevel >= QUICKBOOKS_LOG_DEVELOP)
		{
			$this->_driver = QuickBooks_Utilities::driverFactory($dsn_or_conn, $driver_options, $hooks, $log_level);
		}
		
		// SOAP server adapter class
		$this->_server = $this->_adapterFactory($soap, $wsdl, $soap_options, $log_level);
		
		/*
		$this->_hooks = array();
		foreach ($hooks as $hook => $funcs)
		{
			if (!is_array($funcs))
			{
				$funcs = array( $funcs );
			}
			
			$hooks[$hook] = $funcs;			// Do this so that when we pass it to the handlers, the hooks are already in lists
			$this->_hooks[$hook] = $funcs;
		}
		*/
		
		// Assign hooks
		$this->_hooks = $hooks;
		
		// Assign callback configuration info
		$this->_callback_config = $callback_options;
		
		// Raw input
		$input = '';
		if (isset($HTTP_RAW_POST_DATA) and strlen($HTTP_RAW_POST_DATA))
		{
			$input = $HTTP_RAW_POST_DATA;	
		}
		else
		{
			$input = file_get_contents('php://input');
		}
		
		$this->_input = $input;
				
		// Base handlers
		// $dsn_or_conn, $map, $onerror, $hooks, $log_level, $input, $handler_config = array(), $driver_config = array()
		$this->_server->setClass('QuickBooks_WebConnector_Handlers', $dsn_or_conn, $map, $onerror, $hooks, $log_level, $input, $handler_options, $driver_options, $callback_options);
	}
	
	/**
	 * Get an adapter class instance
	 * 
	 * @param string $adapter
	 * @param string $wsdl
	 * @param array $soap_options
	 * @param integer $loglevel
	 * @return boolean
	 */
	protected function _adapterFactory($adapter, $wsdl, $soap_options, $loglevel)
	{
		$adapter = ucfirst(strtolower($adapter));
		
		$file = '/QuickBooks/Adapter/Server/' . $adapter . '.php';
		$class = 'QuickBooks_Adapter_Server_' . $adapter;
		
		QuickBooks_Loader::load($file);
		
		if (class_exists($class))
		{
			return new $class($wsdl, $soap_options);
		}
		
		return null;
	}
	
	/**
	 * Merge configurations with the defaults
	 * 
	 * @param array $arr
	 * @return array 
	 */
	final protected function _defaults($arr)
	{
		$defaults = array(
			'error_handler' => '', 
			'use_builtin_error_handler' => false, 
			'time_limit' => 0, 
			'log_to_file' => null, 
			'log_to_syslog' => null, 
			'masking' => true, 
			);
		
		$arr = array_merge($defaults, $arr);
		
		return $arr;
	}

	/**
	 * Merge two arrays, allowing $arr2 to be merged over matching keys in $arr1
	 * 
	 * If $arr1 or $arr2 are arrays of arrays, and $array_of_arrays is set to 
	 * true, then the arrays of arrays will be merged, allowing $arr2 to 
	 * override $arr1 entries. If the arrays of arrays are numerically indexed, 
	 * $arr2 entries will be appended to $arr1 entries. 
	 * 
	 * @param array $arr1
	 * @param array $arr2
	 * @param boolean $array_of_arrays
	 * @return array
	 */
	protected function _merge($arr1, $arr2, $array_of_arrays = false)
	{
		if ($array_of_arrays)
		{
			foreach ($arr2 as $key => $funcs)
			{
				if (!is_array($funcs))
				{
					$funcs = array( $funcs );
				}
				
				if (isset($arr1[$key]))
				{
					if (!is_array($arr1[$key]))
					{
						$arr1[$key] = array( $arr1[$key] );
					}
					
					$arr1[$key] = array_merge($arr1[$key], $funcs);
				}
				else
				{
					$arr1[$key] = $funcs;
				}
			}
			
			return $arr1;
		}
		else
		{
			// *DO NOT* use array_merge() here, it screws things up!!!
			//return array_merge($arr1, $arr2);
			
			foreach ($arr2 as $key => $value)
			{
				$arr1[$key] = $value;
			}
			
			return $arr1;
		}
	}
	
	/**
	 * Send the correct HTTP headers for this request
	 * 
	 * @return boolean
	 */
	protected function _headers()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			header('Content-Type: text/xml');
		}
		else if (isset($_GET['wsdl']) or isset($_GET['WSDL']))
		{
			header('Content-Type: text/xml');
		}
		else
		{
			header('Content-Type: text/plain');
		}
		
		return true;
	}
	
	/**
	 * Log a message to the error/debug log
	 *
	 * @param string $msg
	 * @param string $ticket
	 * @param integer $level
	 * @return boolean
	 */
	protected function _log($msg, $ticket, $level = QUICKBOOKS_LOG_NORMAL)
	{
		$Driver = $this->_driver;
		
		$msg = QuickBooks_Utilities::mask($msg);
		
		if ($Driver)
		{
			return $Driver->log($msg, $ticket, $level);
		}
		
		return false;
	}
	
	/**
	 * Handle the SOAP request
	 * 
	 * @param boolean $return
	 * @param boolean $debug
	 * @return void
	 */
	public function handle($return = false, $debug = false)
	{
		// Get the raw input
		$input = $this->_input;
		
		// 
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->_headers();
			
			$output_buffering = false;
			
			/*
			if (isset($this->_hooks[QUICKBOOKS_SERVER_HOOK_PREHANDLE]))
			{
				foreach ($this->_hooks[QUICKBOOKS_SERVER_HOOK_PREHANDLE] as $func)
				{
					$func($input, $this->_callback_config);
				}
			}
			*/
			
			$hook_data = array(
				'input' => $input, 			   
				);
			
			$err = '';
			$this->_callHooks(QUICKBOOKS_SERVER_HOOK_PREHANDLE, null, null, null, $err, $hook_data);
			//QuickBooks_Callbacks::callHook($this->_driver, $this->_hooks, QUICKBOOKS_SERVER_HOOK_PREHANDLE, null, null, null, $err, $hook_data, $this->_callback_config, __FILE__, __LINE__);
			
			if ($this->_loglevel >= QUICKBOOKS_LOG_DEVELOP)
			{
				if (function_exists('apache_request_headers'))
				{
					$headers = '';
					foreach (apache_request_headers() as $header => $value)
					{
						$headers .= $header . ': ' . $value . "\n"; 
					}
					
					//$this->_driver->log('Incoming HTTP Headers: ' . $headers, null, QUICKBOOKS_LOG_DEVELOP);
					$this->_log('Incoming HTTP Headers: ' . $headers, null, QUICKBOOKS_LOG_DEVELOP);
				}
				
				//$this->_driver->log('Incoming SOAP Request: ' . $input, null, QUICKBOOKS_LOG_DEVELOP);
				$this->_log('Incoming SOAP Request: ' . $input, null, QUICKBOOKS_LOG_DEVELOP);
			}
			
			if ($return or isset($this->_hooks[QUICKBOOKS_SERVER_HOOK_POSTHANDLE]))
			{
				$output_buffering = true;
				ob_start();
			}
			
			$this->_server->handle($input);
			
			if ($return or 
				isset($this->_hooks[QUICKBOOKS_SERVER_HOOK_POSTHANDLE]) or 
				$this->_loglevel >= QUICKBOOKS_LOG_DEVELOP)
			{
				$output = '';
				if ($output_buffering)
				{
					$output = ob_get_contents();
					ob_end_flush();
				}
				
				/*
				if (isset($this->_hooks[QUICKBOOKS_SERVER_HOOK_POSTHANDLE]))
				{
					foreach ($this->_hooks[QUICKBOOKS_SERVER_HOOK_POSTHANDLE] as $func)
					{
						$func($output, $this->_callback_config);
					}
				}
				*/
				
				$hook_data = array(
					'input' => $input,
					'output' => $output, 
					);
				
				$err = '';
				$this->_callHooks(QUICKBOOKS_SERVER_HOOK_POSTHANDLE, null, null, null, $err, $hook_data);
				//QuickBooks_Callbacks::callHook($this->_driver, $this->_hooks, QUICKBOOKS_SERVER_HOOK_POSTHANDLE, null, null, null, $err, $hook_data, $this->_callback_config);
				
				if ($this->_loglevel >= QUICKBOOKS_LOG_DEVELOP)
				{
					//$this->_driver->log('Outgoing SOAP Response: ' . $output, null, QUICKBOOKS_LOG_DEVELOP);
					$this->_log('Outgoing SOAP Response: ' . $output, null, QUICKBOOKS_LOG_DEVELOP);
				}
				
				if ($return)
				{
					return $output;
				}
			}
			
			return;
		}
		else if (isset($_GET['WSDL']) or isset($_GET['wsdl']))
		{
			if ($contents = file_get_contents($this->_wsdl))
			{
				$this->_headers();
				print($contents);
				exit;
			}
		}
		else
		{
			$this->_headers();

			print(QUICKBOOKS_PACKAGE_NAME . ' Server v' . QUICKBOOKS_PACKAGE_VERSION . ' at ' . $_SERVER['REQUEST_URI'] . "\n");
			print('   (c) ' . QUICKBOOKS_PACKAGE_AUTHOR . ' ' . "\n");
			print('   Visit us at: ' . QUICKBOOKS_PACKAGE_WEBSITE . ' ' . "\n");
			print("\n");
			print('Use the QuickBooks Web Connector to access this SOAP server.' . "\n");
			print("\n");
			
			if ($debug)
			{
				print(get_class($this) . str_replace(__CLASS__, '', __METHOD__) . '() parameters: ' . "\n");
				print(' - $return = ' . $return . "\n");
				print(' - $debug  = ' . $debug . "\n");
				print("\n");
				print('Misc. information: ' . "\n");
				print(' - Logging: ' . $this->_loglevel . "\n");
				
				if (function_exists('date_default_timezone_get'))
				{
					print(' - Timezone: ' . date_default_timezone_get() . ' (Auto-set: ');
					
					if (QUICKBOOKS_TIMEZONE_AUTOSET)
					{
						print('Yes');
					}
					
					print(')' . "\n");
				}
				print(' - Current Date/Time: ' . date('Y-m-d H:i:s') . "\n");
				print(' - Error Reporting: ' . error_reporting() . "\n");
				
				print("\n");
				print('SOAP adapter: ' . "\n");
				print(' - ' . get_class($this->_server) . "\n");
				print("\n");
				print('Registered handler functions: ' . "\n");
				print_r($this->_server->getFunctions());
				
				/*
				print("\n");
				print('Registered hooks: ' . "\n");
				//print_r($this->_hooks);		// This is bad because it prints passwords
				foreach ($this->_hooks as $hook => $arr)
				{
					if (!is_array($arr))
					{
						continue;
					}
					
					print(' - ' . $hook . QUICKBOOKS_CRLF);
					foreach ($arr as $x)
					{
						$y = current(explode("\n", print_r($x, true)));
						
						print('    ' . $y . QUICKBOOKS_CRLF);
					}
				}
				*/
				
				print("\n");
				print('Detected input: ' . "\n");
				print($input);
				print("\n");
				print("\n");
				print('Timestamp: ' . "\n");
				print(' - ' . date('Y-m-d H:i:s') . ' -- process ' . round(microtime(true) - QUICKBOOKS_TIMESTAMP, 5) . "\n");
			}
			
			return;
		}
	}
	
	/**
	 * 
	 * 
	 * @param string $hook
	 * @param string $requestID
	 * @param string $user
	 * @param string $ticket
	 * @param string $err
	 * @param array $hook_data
	 * @return boolean
	 */
	protected function _callHooks($hook, $requestID, $user, $ticket, &$err, $hook_data)
	{
		$err = '';
		return QuickBooks_Callbacks::callHook(
			$this->_driver, 
			$this->_hooks, 
			$hook, 
			$requestID, 
			$user, 
			$ticket, 
			$err, 
			$hook_data, 
			$this->_callback_config);		
	}
	
	/**
	 * Get debugging information from the SOAP server
	 * 
	 * @return array 
	 */
	public function debug()
	{
		return var_export($this, true);
	}
}
