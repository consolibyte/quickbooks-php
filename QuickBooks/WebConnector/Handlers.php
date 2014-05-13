<?php

/**
 * Handlers for each of the QBWC SOAP server required methods
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * The QuickBooks Web Connector requires that your SOAP server be able to 
 * handle six basic methods. Each of the six methods are implemented in this 
 * class and called by the QuickBooks_Server class instance. 
 * 
 * These methods in turn will call the action handlers you register with the 
 * SOAP server, and also log quite a bit of debugging information to the 
 * database so that you can see what's happening during the QBWC exchange with 
 * your SOAP server. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * Various QuickBooks related utilities methods
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

/**
 * Functions for calling callbacks (functions, static methods, object methods, etc.)
 */
QuickBooks_Loader::load('/QuickBooks/Callbacks.php');

/**
 * Response container for calls to ->authenticate()
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result/Authenticate.php');

/**
 * Response container for calls to ->closeConnection()
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result/CloseConnection.php');

/**
 * Response container for calls to ->connectionError()
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result/ConnectionError.php');

/**
 * Response container for calls to ->getLastError()
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result/GetLastError.php');

/**
 * Response container for calls to ->receiveResponseXML()
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result/ReceiveResponseXML.php');

/**
 * Response container for calls to ->sendRequestXML()
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result/SendRequestXML.php');

/**
 * Response container for calls to ->getServerVersion()
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result/ServerVersion.php');

/**
 * Response container for calls to ->clientVersion()
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result/ClientVersion.php');

/**
 * Hook which gets called when the ->authenticate() method gets called
 * @param string
 */
define('QUICKBOOKS_HANDLERS_HOOK_AUTHENTICATE', 'QuickBooks_Handlers::authenticate');

/**
 * Hook which gets called when the ->clientVersion() method gets called
 * @var string
 */
define('QUICKBOOKS_HANDLERS_HOOK_CLIENTVERSION', 'QuickBooks_Handlers::clientVersion');

/**
 * Hook which gets called when the ->closeConnection() method gets called
 * @var string
 */
define('QUICKBOOKS_HANDLERS_HOOK_CLOSECONNECTION', 'QuickBooks_Handlers::closeConnection');

/**
 * Hook which gets called when the ->connectionError() method gets called
 * @var string
 */
define('QUICKBOOKS_HANDLERS_HOOK_CONNECTIONERROR', 'QuickBooks_Handlers::connectionError');

/**
 * 
 */
define('QUICKBOOKS_HANDLERS_HOOK_GETINTERACTIVEURL', 'QuickBooks_Handlers::getInteractiveURL');

/**
 * 
 */
define('QUICKBOOKS_HANDLERS_HOOK_GETLASTERROR', 'QuickBooks_Handlers::getLastError');

/**
 * 
 * 
 */
define('QUICKBOOKS_HANDLERS_HOOK_INTERACTIVEDONE', 'QuickBooks_Handlers::interactiveDone');

/**
 * 
 * 
 */
define('QUICKBOOKS_HANDLERS_HOOK_INTERACTIVEREJECTED', 'QuickBooks_Handlers::interactiveRejected');

/**
 * 
 * 
 */
define('QUICKBOOKS_HANDLERS_HOOK_RECEIVERESPONSEXML', 'QuickBooks_HandlersS::receiveResponseXML');

/**
 * 
 */
define('QUICKBOOKS_HANDLERS_HOOK_SENDREQUESTXML', 'QuickBooks_Handlers::sendRequestXML');

/**
 * 
 */
define('QUICKBOOKS_HANDLERS_HOOK_SERVERVERSION', 'QuickBooks_Handlers::serverVersion');

/**
 * 
 */
define('QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS', 'QuickBooks_Handlers::login-success');

/**
 * Hook which is called when a login fails
 * @var string
 */
define('QUICKBOOKS_HANDLERS_HOOK_LOGINFAILURE', 'QuickBooks_Handlers::login-fail');

/**
 * Alias of {@link QUICKBOOKS_HANDLERS_HOOK_LOGINFAILURE}
 * @var string
 */
define('QUICKBOOKS_HANDLERS_HOOK_LOGINFAIL', QUICKBOOKS_HANDLERS_HOOK_LOGINFAILURE);

/**
 * Hook which is called when recurring events are registered
 * @var string
 */
define('QUICKBOOKS_HANDLERS_HOOK_RECURRING', 'QuickBooks_Handlers::recurring');

/**
 * Hook which is called to report a percentage don
 * @var string
 */
define('QUICKBOOKS_HANDLERS_HOOK_PERCENT', 'QuickBooks_Handlers::percent');

/**
 * Handlers for each of the QBWC SOAP server required methods
 */
class QuickBooks_WebConnector_Handlers
{
	const HOOK_AUTHENTICATE = QUICKBOOKS_HANDLERS_HOOK_AUTHENTICATE;
	const HOOK_LOGINSUCCESS = QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS;
	
	/**
	 * Driver object instance for backend of SOAP server
	 * @var QuickBooks_Driver
	 */
	protected $_driver;
	
	/**
	 * Raw XML input
	 * @var string
	 */
	protected $_input;
	
	/**
	 * Map of queued actions to function handlers
	 * @var array 
	 */
	protected $_map;
	
	/**
	 * 
	 * 
	 */
	protected $_instance_map;
	
	/**
	 * Map of error codes to function handler
	 * @var array 
	 */
	protected $_onerror;
	
	/**
	 * 
	 * 
	 */
	protected $_instance_onerror;
	
	/**
	 * Map of hook names to function handlers
	 * @var array 
	 */
	protected $_hooks;
	
	/**
	 * 
	 * 
	 */
	protected $_instance_hooks;	
	
	/**
	 * Configuration parameters
	 * @var array
	 */
	protected $_config;
	
	/**
	 * Callback configuration parameters
	 * @var array
	 */
	protected $_callback_config;
	
	/**
	 * Create the server handler instance
	 * 
	 * Optional configuration items should be passed as an associative array with any of these keys:
	 * 	- qb_company_file				The full filesystem path to a specific QuickBooks company file (by default, it will use the currently open company file)
	 * 	- qbwc_min_version				Minimum version of the Web Connector that must be used to connect (by default, any version may connect)
	 * 	- qbwc_wait_before_next_update 	Tell the Web Connector to wait this number of seconds before doign another update
	 * 	- qbwc_min_run_every_n_seconds	Tell the Web Connector to run every n seconds (overrides whatever was in the .QWC web connector configuration file)
	 * 	- qbwc_interactive_url			The URL to use for Interactive QuickBooks Web Connector sessions
	 * 	- server_version				Server version string
	 * 	- authenticate_handler			If you want to use some custom authentication method, put the function name of your custom authentication function here
	 * 	- autoadd_missing_requestid		This defaults to TRUE, if TRUE and you forget to embed a requestID="..." attribute, it will try to automatically add that attribute for you
	 * 
	 * @param mixed $dsn_or_conn		DSN connection string for QuickBooks queue
	 * @param array $map				A map of QuickBooks API calls to callback functions/methods
	 * @param array $onerror			A map of QuickBooks error codes to callback functions/methods
	 * @param array $hooks				A map of hook names to callback functions/methods
	 * @param string $input				Raw XML input from QuickBooks API call
	 * @param array $handler_config		An array of configuration options
	 * @param array $driver_config		An array of driver configuration options
	 */
	public function __construct($dsn_or_conn, $map, $onerror, $hooks, $log_level, $input, $handler_config = array(), $driver_config = array(), $callback_config = array())
	{
		$this->_driver = QuickBooks_Utilities::driverFactory($dsn_or_conn, $driver_config, $hooks, $log_level);
		$this->_input = $input;
		$this->_map = $map;
		$this->_onerror = $onerror;
		
		$this->_hooks = array();
		foreach ($hooks as $hook => $funcs)
		{
			if (!is_array($funcs))
			{
				$funcs = array( $funcs );
			}
			
			$this->_hooks[$hook] = $funcs;
		}
		
		$this->_config = $this->_defaults($handler_config);
		
		$this->_callback_config = $callback_config;
		
		//$this->_driver->log('Handler is starting up...: ' . var_export($this->_config, true), '', QUICKBOOKS_LOG_DEBUG);
		$this->_log('Handler is starting up...: ' . var_export($this->_config, true), '', QUICKBOOKS_LOG_DEBUG);
	}
	
	/**
	 * Massage any optional configuration flags
	 * 
	 * @param array $config
	 * @return array 
	 */
	protected function _defaults($config)
	{
		$url = '?';
		if (isset($_SERVER['REQUEST_URI']))
		{
			$url = $_SERVER['REQUEST_URI'];
		}
		
		$defaults = array(
			'qb_company_file' => null,					// To force a specific company file to be used		
			'qbwc_min_version' => null, 				// Minimum version of the QBWC that must be used to connect
			'qbwc_wait_before_next_update' => null, 	// Tell the QBWC to wait this number of seconds before doing another update
			'qbwc_min_run_every_n_seconds' => null,		// Tell the QBWC to run every n seconds (overrides whatever was in the .QWC web connector configuration file)
			'qbwc_version_warning_message' => null,		// Not implemented... 
			'qbwc_version_error_message' => null,  		// Not implemented...
			'qbwc_interactive_url' => null, 			// Provide the URL for an interactive session to the QuickBooks Web Connector
			'autoadd_missing_requestid' => true,  
			'check_valid_requestid' => true, 
			'server_version' => 'PHP QuickBooks SOAP Server v' . QUICKBOOKS_PACKAGE_VERSION . ' at ' . $url,	// Server version string
			'authenticate' => null, 					// If you want to use some custom authentication scheme (and not the quickbooks_user MySQL table) you can specify your own function here
			'authenticate_dsn' => null, 				//		(backward compat. for 'authenticate')
			'map_application_identifiers' => true, 		// Try to map web application IDs to QuickBooks ListIDs/TxnIDs
			'allow_remote_addr' => array(), 
			'deny_remote_addr' => array(), 
			'convert_unix_newlines' => true, 
			
			'deny_concurrent_logins' => true, 
			'deny_concurrent_timeout' => 60, 
			
			'deny_reallyfast_logins' => true, 
			'deny_reallyfast_timeout' => 600, 
			
			'masking' => true, 
			);
			
		$config = array_merge($defaults, $config);
		
		// Make sure this is an *array* of addresses to allow
		if (!is_array($config['allow_remote_addr']))
		{
			$config['allow_remote_addr'] = array( $config['allow_remote_addr'] );
		}
		
		// Make sure this is an *array* of addresses to deny
		if (!is_array($config['deny_remote_addr']))
		{
			$config['deny_remote_addr'] = array( $config['deny_remote_addr'] );
		}
		
		$config['autoadd_missing_requestid'] = (boolean) $config['autoadd_missing_requestid'];
		$config['check_valid_requestid'] = (boolean) $config['check_valid_requestid'];
		$config['map_application_identifiers'] = (boolean) $config['map_application_identifiers'];
		$config['convert_unix_newlines'] = (boolean) $config['convert_unix_newlines'];
		
		$config['deny_concurrent_logins'] = (boolean) $config['deny_concurrent_logins'];
		$config['deny_concurrent_timeout'] = (int) max(1, $config['deny_concurrent_timeout']);
		
		$config['deny_reallyfast_logins'] = (boolean) $config['deny_reallyfast_logins'];
		$config['deny_reallyfast_timeout'] = (int) max(1, $config['deny_reallyfast_timeout']);
		
		return $config;
	}
		
	/**
	 * Check if a given remote address (IP address) is allowed based on allow and deny arrays
	 * 
	 * @param string $remoteaddr
	 * @param array $allow
	 * @param array $deny
	 * @return boolean
	 */
	protected function _checkRemote($remoteaddr, $arr_allow, $arr_deny)
	{
		return QuickBooks_Utilities::checkRemoteAddress($remoteaddr, $arr_allow, $arr_deny);
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
		
		if ($this->_config['masking'])
		{
			$msg = QuickBooks_Utilities::mask($msg);
		}
		
		if ($Driver)
		{
			return $Driver->log($msg, $ticket, $level);
		}
		
		return false;
	}
	
	/**
	 * Queue up recurring events that are overdue to be run
	 * 
	 * @param string $ticket
	 * @return boolean 
	 */
	protected function _handleRecurringEvents($ticket)
	{
		if ($user = $this->_driver->authResolve($ticket))
		{
			while ($next = $this->_driver->recurDequeue($user, true))
			{
				//$this->_driver->log('Dequeued a recurring event, enqueuing!', $ticket, QUICKBOOKS_LOG_VERBOSE);
				$this->_log('Dequeued a recurring event, enqueuing!', $ticket, QUICKBOOKS_LOG_VERBOSE);
				
				$extra = null;
				if ($next['extra'])
				{
					$extra = unserialize($next['extra']);
				}
				
				//print_r($next);
				
				$hookerr = '';
				$this->_callHook($ticket, 
					QUICKBOOKS_HANDLERS_HOOK_RECURRING, 
					null, 					//$this->_constructRequestID($next['qb_action'], $next['ident']), 
					$next['qb_action'], 
					$next['ident'], 
					$extra, 
					$hookerr);
				// $ticket, $hook, $requestID, $action, $ident, $extra, &$err, $xml = '', $qb_identifiers = array()
				
				//print_r($next);
				//exit;
				
				// (boolean) $next['replace']
				// 							$user, $action, $ident, $replace = true, $priority = 0, $extra = null, $qbxml = null
				$this->_driver->queueEnqueue($user, $next['qb_action'], $next['ident'], true, (int) $next['priority'], $extra, $next['qbxml']);
			}
			
			return true;
		}
		
		return false;		
	}
	
	/**
	 * Authenticate method for the QuickBooks Web Connector SOAP service
	 * 
	 * The authenticate method is called when the Web Connector establishes a 
	 * connection with the SOAP server in order to ensure that there is work to 
	 * do and that the Web Connector is allowed to connect/that it actually is 
	 * the Web Connector that is connecting and sending us messages.
	 * 
	 * The stdClass object that is received as a parameter will have two 
	 * members:
	 * 	- strUserName	The username provided in the QWC file to the Web Connector
	 * 	- strPassword 	The password the end-user enters into the QuickBooks Web Connector application
	 * 
	 * The return object should be an array with two elements. The first 
	 * element is a generated login ticket (or an empty string if the login 
	 * failed) and the second string is either "none" (for successful log-ins 
	 * with nothing to do in the queue) or "nvu" if the login failed. 
	 * 
	 * The following user-defined hooks are invoked:
	 * 	- QUICKBOOKS_HANDLERS_HOOK_AUTHENTICATE
	 * 	- QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS
	 * 	- QUICKBOOKS_HANDLERS_HOOK_LOGINFAILURE
	 * 
	 * @param stdClass $obj						The SOAP object that gets sent by the Web Connector
	 * @return QuickBooks_Result_Authenticate	A container object to send back to the Web Connector
	 */
	public function authenticate($obj)
	{
		//$this->_driver->log('authenticate()', '', QUICKBOOKS_LOG_VERBOSE);
		$this->_log('authenticate()', '', QUICKBOOKS_LOG_VERBOSE);
		
		$ticket = '';
		$status = '';
		
		// Authenticate login hook
		$hookdata = array(
			'username' => $obj->strUserName, 
			'password' => $obj->strPassword,
			);
		$hookerr = '';
		$this->_callHook($ticket, QUICKBOOKS_HANDLERS_HOOK_AUTHENTICATE, null, null, null, null, $hookerr, null, array(), $hookdata);
		
		// Remote address allow/deny
		if (false == $this->_checkRemote($_SERVER['REMOTE_ADDR'], $this->_config['allow_remote_addr'], $this->_config['deny_remote_addr']))
		{
			//$this->_driver->log('Connection from remote address rejected: ' . $_SERVER['REMOTE_ADDR'], null, QUICKBOOKS_LOG_VERBOSE);
			$this->_log('Connection from remote address rejected: ' . $_SERVER['REMOTE_ADDR'], null, QUICKBOOKS_LOG_VERBOSE);
			
			return new QuickBooks_WebConnector_Result_Authenticate('', 'nvu', null, null);
		}
		
		// If we do either concurrent login checks, or rate-limiting, we need to grab the date/time 
		//	of the last connection.
		$authLast = null;
		if ($this->_config['deny_concurrent_logins'] or $this->_config['deny_reallyfast_logins'])
		{
			$authlast = $this->_driver->authLast($obj->strUserName);
		}
		
		// Check for concurrent logins
		if ($this->_config['deny_concurrent_logins'])
		{
			if ($authlast and 
				time() - strtotime($authlast[1]) < $this->_config['deny_concurrent_timeout'])
			{
				$this->_log('Denied concurrent login from: ' . $obj->strUserName, null, QUICKBOOKS_LOG_VERBOSE);
			
				return new QuickBooks_WebConnector_Result_Authenticate('CONC1234', 'none', null, null);
			}
		}
		
		// Rate-limiting
		if ($this->_config['deny_reallyfast_logins'])
		{
			if ($authlast and 
				time() - strtotime($authlast[1]) < $this->_config['deny_reallyfast_timeout'])
			{
				$this->_log('Denied really fast login from: ' . $obj->strUserName . ' (last login: ' . $authlast[1] . ')', null, QUICKBOOKS_LOG_VERBOSE);
			
				return new QuickBooks_WebConnector_Result_Authenticate('FAST1234', 'none', null, null);
			}
		}
		
		// Custom authentication backends
		$override_dsn = $this->_config['authenticate'];
		
		if (!empty($this->_config['authenticate_dsn']))
		{
			// Backwards compat.
			$override_dsn = $this->_config['authenticate_dsn'];
		}
		
		$auth = null;
		
		/*
		if (strlen($override_dsn))
		{
			$override_dsn = str_replace('function://', '', $override_dsn);
		}
		*/
		
		$company_file = null;
		$wait_before_next_update = null;
		$min_run_every_n_seconds = null;
		
		$customauth_company_file = null;
		$customauth_wait_before_next_update = null;
		$customauth_min_run_every_n_seconds = null;
		
		if (is_array($override_dsn) or strlen($override_dsn)) 	// Custom autj
		{
			//if ($auth->authenticate($obj->strUserName, $obj->strPassword, $customauth_company_file, $customauth_wait_before_next_update, $customauth_min_run_every_n_seconds) and 
			
			//if ($override_dsn($obj->strUserName, $obj->strPassword, $customauth_company_file, $customauth_wait_before_next_update, $customauth_min_run_every_n_seconds) and 
			
			if (QuickBooks_Callbacks::callAuthenticate($this->_driver, $override_dsn, $obj->strUserName, $obj->strPassword, $customauth_company_file, $customauth_wait_before_next_update, $customauth_min_run_every_n_seconds) and 
				$ticket = $this->_driver->authLogin($obj->strUserName, $obj->strPassword, $company_file, $wait_before_next_update, $min_run_every_n_seconds, true))
			{
				//$this->_driver->log('Login (' . $parse['scheme'] . '): ' . $obj->strUserName, $ticket, QUICKBOOKS_LOG_DEBUG);
				$this->_log('Login via ' . print_r($override_dsn, true) . ': ' . $obj->strUserName, $ticket, QUICKBOOKS_LOG_DEBUG);
				
				if ($customauth_company_file)
				{
					$status = $customauth_company_file;
				}
				else if ($company_file)
				{
					$status = $company_file;
				}
				else if ($this->_config['qb_company_file'])
				{
					$status = $this->_config['qb_company_file'];
				}
				
				if ((int) $customauth_wait_before_next_update)
				{
					$wait_before_next_update = (int) $customauth_wait_before_next_update;
				}
				else if ((int) $wait_before_next_update)
				{
					;
				}
				else if ((int) $this->_config['qbwc_wait_before_next_update'])
				{
					$wait_before_next_update = (int) $this->_config['qbwc_wait_before_next_update'];
				}
				
				if ((int) $customauth_min_run_every_n_seconds)
				{
					$min_run_every_n_seconds = (int) $customauth_min_run_every_n_seconds;
				}
				else if ((int) $min_run_every_n_seconds)
				{
					; 
				}
				else if ((int) $this->_config['qbwc_min_run_every_n_seconds'])
				{
					$min_run_every_n_seconds = (int) $this->_config['qbwc_min_run_every_n_seconds'];
				}
				
				// Call login hook
				$hookdata = array(
					'authenticate_dsn' => $override_dsn,  
					'username' => $obj->strUserName, 
					'password' => $obj->strPassword, 
					'ticket' => $ticket, 
					'qb_company_file' => $status, 
					'qbwc_wait_before_next_update' => $wait_before_next_update, 
					'qbwc_min_run_every_n_seconds' => $min_run_every_n_seconds, 
					);
				$hookerr = '';
				$this->_callHook($ticket, QuickBooks_WebConnector_Handlers::HOOK_LOGINSUCCESS, null, null, null, null, $hookerr, null, array(), $hookdata);
				
				// Move any recurring events that are due to the queue table
				$this->_handleRecurringEvents($ticket);
				
				if (!$this->_driver->queueDequeue($obj->strUserName))
				{
					$status = 'none';
				}
				
				// Login success (with a custom login handler)!
			}
			else
			{
				//$this->_driver->log('Login failed (' . $parse['scheme'] . '): ' . $obj->strUserName, '', QUICKBOOKS_LOG_DEBUG);
				$this->_log('Login failed: ' . $obj->strUserName, '', QUICKBOOKS_LOG_DEBUG);
				
				$hookdata = array(
					'authenticate_dsn' => $override_dsn, 
					'username' => $obj->strUserName, 
					'password' => $obj->strPassword, 
					);
				$hookerr = '';
				$this->_callHook(null, QUICKBOOKS_HANDLERS_HOOK_LOGINFAILURE, null, null, null, null, $hookerr, null, array(), $hookdata);
				
				$ticket = '';
				$status = 'nvu'; // Invalid username/password
			}
			
			return new QuickBooks_WebConnector_Result_Authenticate($ticket, $status, $wait_before_next_update, $min_run_every_n_seconds);
		} 
		else	// Standard authentication
		{
			if ($ticket = $this->_driver->authLogin($obj->strUserName, $obj->strPassword, $company_file, $wait_before_next_update, $min_run_every_n_seconds))
			{
				//$this->_driver->log('Login: ' . $obj->strUserName, $ticket, QUICKBOOKS_LOG_DEBUG);
				$this->_log('Login: ' . $obj->strUserName, $ticket, QUICKBOOKS_LOG_DEBUG);
				
				if (!strlen($company_file) and $this->_config['qb_company_file'])
				{
					$status = $this->_config['qb_company_file'];
				}
				else if (strlen($company_file))
				{
					$status = $company_file;
				}
				
				if (! (int) $wait_before_next_update and (int) $this->_config['qbwc_wait_before_next_update'])
				{
					$wait_before_next_update = (int) $this->_config['qbwc_wait_before_next_update'];
				}
				
				if (! (int) $min_run_every_n_seconds and (int) $this->_config['qbwc_min_run_every_n_seconds'])
				{
					$min_run_every_n_seconds = (int) $this->_config['qbwc_min_run_every_n_seconds'];
				}
				
				$hookdata = array(
					'username' => $obj->strUserName, 
					'password' => $obj->strPassword, 
					'ticket' => $ticket, 
					'qb_company_file' => $status, 
					'qbwc_wait_before_next_update' => $wait_before_next_update, 
					'qbwc_min_run_every_n_seconds' => $min_run_every_n_seconds, 
					);
				$hookerr = '';
				$this->_callHook($ticket, QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS, null, null, null, null, $hookerr, null, array(), $hookdata);
				
				$this->_handleRecurringEvents($ticket);
				
				if (!$this->_driver->queueDequeue($obj->strUserName))
				{
					$status = 'none'; // Good login, but there isn't anything in the queue
				}
				
				// Login success!
			}
			else
			{
				//$this->_driver->log('Login failed: ' . $obj->strUserName, '', QUICKBOOKS_LOG_DEBUG);
				$this->_log('Login failed: ' . $obj->strUserName, '', QUICKBOOKS_LOG_DEBUG);
				
				$hookdata = array(
					'username' => $obj->strUserName, 
					'password' => $obj->strPassword, 
					);
				$hookerr = '';
				$this->_callHook(null, QUICKBOOKS_HANDLERS_HOOK_LOGINFAILURE, null, null, null, null, $hookerr, null, array(), $hookdata);
				
				$ticket = '';
				$status = 'nvu'; // Invalid username/password
			}
			
			return new QuickBooks_WebConnector_Result_Authenticate($ticket, $status, $wait_before_next_update, $min_run_every_n_seconds);
		}
	}
	
	/**
	 * SendRequestXML method for the QuickBooks Web Connector SOAP server - Generate and send a request to QuickBooks
	 * 
	 * The QuickBooks Web Connector calls this method to ask for things to do. 
	 * So, calling this method is the Web Connectors way of saying: "Please 
	 * send me a command so that I can pass that command on to QuickBooks." 
	 * After it passes the command to QuickBooks, it will pass the response 
	 * back via a call to receiveResponseXML(). 
	 * 
	 * The stdClass object passed as a parameter should contain these members: 
	 * 	- ticket				The login session ticket
	 *  - strHCPResponse		
	 * 	- strCompanyFileName	
	 * 	- qbXMLCountry			The country code for whatever version of QuickBooks is sitting behind the Web Connector
	 * 	- qbXMLMajorVers		The major version code of the QuickBooks web connector
	 * 	- qbXMLMinorVers 		The minor version code of the QuickBooks web connector
	 * 
	 * You should return either an empty string "" to signal an error state, or 
	 * a valid qbXML or qbposXML request. 
	 * 
	 * The following user-defined hooks are invoked by this method:
	 * 	- QUICKBOOKS_HANDLERS_HOOK_SENDREQUESTXML
	 * 
	 * @param stdClass $obj
	 * @return QuickBooks_Result_SendRequestXML
	 */
	public function sendRequestXML($obj)
	{
		//$this->_driver->log('sendRequestXML()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		$this->_log('sendRequestXML()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		
		if ($this->_driver->authCheck($obj->ticket)) 
		{
			$user = $this->_driver->authResolve($obj->ticket);
			
			$hookdata = array(
				'username' => 			$user, 
				'ticket' => 			$obj->ticket, 
				'strHCPResponse' => 	$obj->strHCPResponse, 
				'strCompanyFileName' => $obj->strCompanyFileName,
				'qbXMLCountry' => 		$obj->qbXMLCountry, 
				'qbXMLMajorVers' => 	$obj->qbXMLMajorVers, 
				'qbXMLMinorVers' => 	$obj->qbXMLMinorVers, 
				);
			$hookerr = '';
			$this->_callHook($obj->ticket, QUICKBOOKS_HANDLERS_HOOK_SENDREQUESTXML, null, null, null, null, $hookerr, null, array(), $hookdata);
			// _callHook($ticket, $hook, $requestID, $action, $ident, $extra, &$err, $xml = '', $qb_identifiers = array(), $hook_data = array())
			
			// Move recurring events which are due to run to the queue table
			// 	We *CAN'T* re-register recurring events here, otherwise, we run 
			//	the risk of re-adding an event which has occured, *before* the 
			//	entire session has finishing running. Thus, we'd create an 
			//	infinite loop of web connector that would never end. 
			//$this->_handleRecurringEvents($obj->ticket);
			
			if ($next = $this->_driver->queueDequeue($user, true)) // Fetch the next action/command from the queue
			{
				//$this->_driver->log('Dequeued: ( ' . $next['qb_action'] . ', ' . $next['ident'] . ' ) ', $obj->ticket, QUICKBOOKS_LOG_DEBUG);
				$this->_log('Dequeued: ( ' . $next['qb_action'] . ', ' . $next['ident'] . ' ) ', $obj->ticket, QUICKBOOKS_LOG_DEBUG);
				//$this->_driver->queueStatus($obj->ticket, $next['qb_action'], $next['ident'], QUICKBOOKS_STATUS_PROCESSING);
				$this->_driver->queueStatus($obj->ticket, $next['quickbooks_queue_id'], QUICKBOOKS_STATUS_PROCESSING);
				
				/*
				// Here's a strange case, interactive mode handler
				if ($next['qb_action'] == QUICKBOOKS_INTERACTIVE_MODE)
				{
					// Set the error to "Interactive mode"
					$this->_driver->errorLog($obj->ticket, QUICKBOOKS_ERROR_OK, QUICKBOOKS_INTERACTIVE_MODE);
					
					// This will cause ->getLastError() to be called, and ->getLastError() will then return the string "Interactive mode" which will cause QuickBooks to call ->getInteractiveURL() and start an interactive session... I think...?
					return new QuickBooks_Result_SendRequestXML('');
				}
				*/
				
				$extra = '';
				if ($next['extra'])
				{
					$extra = unserialize($next['extra']);
				}
				
				$err = '';
				$xml = '';
				
				//$last_action_time = $this->_driver->queueActionLast($user, $next['qb_action']);
				//$last_actionident_time = $this->_driver->queueActionIdentLast($user, $next['qb_action'], $next['ident']);
				$last_action_time = null;
				$last_actionident_time = null;
				
				// Call the mapped function that should generate an appropriate qbXML request
				$xml = $this->_callMappedFunction(0, $user, $next['quickbooks_queue_id'], $next['qb_action'], $next['ident'], $extra, $err, $last_action_time, $last_actionident_time, $obj->qbXMLMajorVers . '.' . $obj->qbXMLMinorVers, $obj->qbXMLCountry, $next['qbxml']);
				
				// Make sure there's no whitespace around it
				$xml = trim($xml);
				
				// NoOp can be returned to skip this current operation. This will cause getLastError
				//	to be called, at which point NoOp should be returned to tell the Web
				//	Connector to then pause for 5 seconds before asking for another request. 
				if ($xml == QUICKBOOKS_NOOP)
				{
					$this->_driver->errorLog($obj->ticket, 0, QUICKBOOKS_NOOP);
					
					// Mark it as a NoOp to remove it from the queue
					//$this->_driver->queueStatus($obj->ticket, $next['qb_action'], $next['ident'], QUICKBOOKS_STATUS_NOOP, 'Handler function returned: ' . QUICKBOOKS_NOOP);
					$this->_driver->queueStatus($obj->ticket, $next['quickbooks_queue_id'], QUICKBOOKS_STATUS_NOOP, 'Handler function returned: ' . QUICKBOOKS_NOOP);
					
					return new QuickBooks_WebConnector_Result_SendRequestXML('');
				}
				
				// If the requestID="..." attribute was not specified, we can try to automatically add it to the request
				$requestID = null;
				if (!($requestID = $this->_extractRequestID($xml)) and 
					$this->_config['autoadd_missing_requestid'])
				{
					// Find the <DoSomethingRq tag
					
					foreach (QuickBooks_Utilities::listActions() as $action)
					{
						$request = QuickBooks_Utilities::actionToRequest($action);
						if (false !== strpos($xml, '<' . $request . ' '))
						{
							//$xml = str_replace('<' . $request . ' ', '<' . $request . ' requestID="' . $this->_constructRequestID($next['qb_action'], $next['ident']) . '" ', $xml);
							$xml = str_replace('<' . $request . ' ', '<' . $request . ' requestID="' . $next['quickbooks_queue_id'] . '" ', $xml);
							break;
						}
						else if (false !== strpos($xml, '<' . $request . '>'))
						{
							//$xml = str_replace('<' . $request . '>', '<' . $request . ' requestID="' . $this->_constructRequestID($next['qb_action'], $next['ident']) . '">', $xml);
							$xml = str_replace('<' . $request . '>', '<' . $request . ' requestID="' . $next['quickbooks_queue_id'] . '">', $xml);
							break;
						}
					}
				}
				else if ($this->_config['check_valid_requestid'])
				{
					// They embedded a requestID="..." attribute, let's make sure it's valid
					
					//$embedded_action = null;
					//$embedded_ident = null;
					//$this->_parseRequestID($requestID, $embedded_action, $embedded_ident);
					
					//if ($embedded_action != $next['qb_action'] or $embedded_ident != $next['ident'])
					if ($next['quickbooks_queue_id'] != $requestID)
					{
						// They are sending this request with an INVALID requestID! Error this out and warn them!
						
						$err = 'This request contains an invalid embedded requestID="..." attribute; either embed the $requestID parameter, or leave out the requestID="..." attribute entirely, found [' . $requestID . ' => ' . $embedded_action . ', ' . $embedded_ident . ']!';
					}
				}
				
				/*
				if ($this->_config['convert_unix_newlines'] and 
					false === strpos($xml, "\r") and 				// there are currently no Windows newlines...
					false !== strpos($xml, "\n"))					// ... but there *are* Unix newlines!
				{
					; // (this is currently broken/unimplemented)
				}
				*/
				
				if ($err) // The function encountered an error when generating the qbXML request
				{
					//$this->_driver->errorLog($obj->ticket, QUICKBOOKS_ERROR_HANDLER, $err);
					//$this->_driver->log('ERROR: ' . $err, $obj->ticket, QUICKBOOKS_LOG_NORMAL);
					//$this->_driver->queueStatus($obj->ticket, $next['qb_action'], $next['ident'], QUICKBOOKS_STATUS_ERROR, 'Registered handler returned error: ' . $err);
					
					$errerr = '';
					//$this->_handleError($obj->ticket, QUICKBOOKS_ERROR_HANDLER, $err, $this->_constructRequestID($next['qb_action'], $next['ident']), $next['qb_action'], $next['ident'], $extra, $errerr, $xml);
					$this->_handleError($obj->ticket, QUICKBOOKS_ERROR_HANDLER, $err, $next['quickbooks_queue_id'], $next['qb_action'], $next['ident'], $extra, $errerr, $xml);
					
					return new QuickBooks_WebConnector_Result_SendRequestXML('');
				}
				else
				{
					//$this->_driver->log('Outgoing XML request: ' . $xml, $obj->ticket, QUICKBOOKS_LOG_DEBUG);
					$this->_log('Outgoing XML request: ' . $xml, $obj->ticket, QUICKBOOKS_LOG_DEBUG);
					
					if (strlen($xml) and  // Returned XML AND 
						!$this->_extractRequestID($xml)) // Does not have a requestID in the request
					{
						// Mark it as successful right now
						//$this->_driver->queueStatus($obj->ticket, $next['qb_action'], $next['ident'], QUICKBOOKS_STATUS_SUCCESS, 'Unverified... no requestID attribute in XML stream.');
						$this->_driver->queueStatus($obj->ticket, $next['quickbooks_queue_id'], QUICKBOOKS_STATUS_SUCCESS, 'Unverified... no requestID attribute in XML stream.');
					}
					
					return new QuickBooks_WebConnector_Result_SendRequestXML($xml);
				}
			}
		}
		
		// Reporting an error, this will cause the QBWC to call ->getLastError()
		return new QuickBooks_WebConnector_Result_SendRequestXML('');
	}
	
	/**
	 * Extract the requestID attribute from an XML stream
	 * 
	 * @param string $xml	The XML stream to look for a requestID attribute in
	 * @return mixed		The request ID
	 */
	protected function _extractRequestID($xml)
	{
		return QuickBooks_Utilities::extractRequestID($xml);
	}
	
	/**
	 * Create a requestID string from action and ident parts
	 * 
	 * @param string $action
	 * @param mixed $ident
	 * @return string
	 */
	/*
	protected function _constructRequestID($action, $ident)
	{
		return QuickBooks_Utilities::constructRequestID($action, $ident);
	}
	*/
	
	/**
	 * Parse a requestID string into it's action and ident parts
	 * 
	 * @param string $requestID
	 * @param string $action
	 * @param mixed $ident
	 * @return void
	 */
	/*
	protected function _parseRequestID($requestID, &$action, &$ident)
	{
		return QuickBooks_Utilities::parseRequestID($requestID, $action, $ident);
	}
	*/
	
	/**
	 * Extract a unique record identifier from an XML response
	 * 
	 * Some (most?) records within QuickBooks have unique identifiers which are 
	 * returned with the qbXML responses. This method will try to extract all  
	 * identifiers it can find from a qbXML response and return them in an 
	 * associative array. 
	 * 
	 * For example, Customers have unique ListIDs, Invoices have unique TxnIDs, 
	 * etc. For an AddCustomer request, you'll get an array that looks like 
	 * this:
	 * <code>
	 * array(
	 * 	'ListID' => '2C0000-1039887390'
	 * )
	 * </code>
	 * 
	 * Other transactions might have more than one identifier. For instance, a 
	 * call to AddInvoice returns both a ListID and a TxnID:
	 * <code>
	 * array(
	 * 	'ListID' => '200000-1036881887', // This is actually part of the 'CustomerRef' entity in the Invoice XML response 
	 * 	'TxnID' => '11C26-1196256987', // This is the actual transaction ID for the Invoice XML response
	 * )
	 * </code>
	 * 
	 * *** IMPORTANT *** If there are duplicate fields (i.e.: 3 different 
	 * ListIDs returned) then only the first value encountered will appear in 
	 * the associative array.  
	 * 
	 * The following elements/attributes are supported:
	 * 	- ListID
	 * 	- TxnID
	 * 	- iteratorID
	 * 	- OwnerID
	 * 	- TxnLineID
	 * 
	 * @param string $xml	The XML stream to look for an identifier in
	 * @return array		An associative array mapping identifier fields to identifier values
	 */
	protected function _extractIdentifiers($xml)
	{
		$fetch_tagdata = array(
			'ListID', 
			'TxnID', 
			'OwnerID', 
			'TxnLineID', 
			'EditSequence',
			'FullName', 
			'Name', 
			'RefNumber', 
			);
		
		$fetch_attributes = array(
			'requestID',			
			'iteratorID',
			'iteratorRemainingCount',
			'metaData', 
			'retCount', 
			'statusCode', 
			'statusSeverity', 
			'statusMessage', 
			'newMessageSetID', 
			'messageSetStatusCode', 
			);
		
		$list = array();
		
		foreach ($fetch_tagdata as $tag)
		{
			if (false !== ($start = strpos($xml, '<' . $tag . '>')) and 
				false !== ($end = strpos($xml, '</' . $tag . '>')))
			{
				$list[$tag] = substr($xml, $start + 2 + strlen($tag), $end - $start - 2 - strlen($tag));
			}
		}
		
		foreach ($fetch_attributes as $attribute)
		{
			if (false !== ($start = strpos($xml, ' ' . $attribute . '="')) and 
				false !== ($end = strpos($xml, '"', $start + strlen($attribute) + 3)))
			{
				$list[$attribute] = substr($xml, $start + strlen($attribute) + 3, $end - $start - strlen($attribute) - 3);
			}
		}
		
		return $list;
	}
	
	/**
	 * Extract the status code from an XML response
	 * 
	 * Each qbXML response should return a status code and a status message 
	 * indicating whether or not an error occured. 
	 * 
	 * @param string $xml	The XML stream to look for a response status code in
	 * @return integer		The response status code (0 if OK, another positive integer if an error occured)
	 */
	protected function _extractStatusCode($xml)
	{
		if (false !== ($start = strpos($xml, ' statusCode="')) and 
			false !== ($end = strpos($xml, '"', $start + 13)))
		{
			return substr($xml, $start + 13, $end - $start - 13);
		}
		
		return QUICKBOOKS_ERROR_OK;
	}
	
	/**
	 * Extract the status message from an XML response
	 * 
	 * Each qbXML response should return a status code and a status message 
	 * indicating whether or not an error occured. 
	 * 
	 * @param string $xml	The XML stream to look for a response status message in
	 * @return string		The response status message
	 */
	protected function _extractStatusMessage($xml)
	{
		if (false !== ($start = strpos($xml, ' statusMessage="')) and 
			false !== ($end = strpos($xml, '"', $start + 16)))
		{
			return substr($xml, $start + 16, $end - $start - 16);
		}
		
		return '';
	}
	
	/**
	 * Call the mapped function for a given action 
	 * 
	 * @param integer $which			Whether or call the request action handler (pass a 0) or the response action handler (pass a 1)
	 * @param string $user				QuickBooks username of the user the request/response is for
	 * @param string $action			
	 * @param mixed $ident				
	 * @param mixed $extra
	 * @param string $err				If the function returns an error message, the error message will be stored here
	 * @param integer $last_action_time
	 * @param integer $last_actionident_time
	 * @param string $xml				A qbXML response (if you're calling the response handler)
	 * @param array $qb_identifier		
	 * @return string
	 */
	protected function _callMappedFunction($which, $user, $requestID, $action, $ident, $extra, &$err, $last_action_time, $last_actionident_time, $xml_or_version = '', $qb_identifier_or_locale = array(), $qbxml = null)
	{
		if ($which == 0)
		{
			return QuickBooks_Callbacks::callRequestHandler($this->_driver, $this->_map, $requestID, $action, $user, $action, $ident, $extra, $err, $last_action_time, $last_actionident_time, $xml_or_version, $qb_identifier_or_locale, $this->_callback_config, $qbxml);
		}
		else if ($which == 1)
		{
			return QuickBooks_Callbacks::callResponseHandler($this->_driver, $this->_map, $requestID, $action, $user, $action, $ident, $extra, $err, $last_action_time, $last_actionident_time, $xml_or_version, $qb_identifier_or_locale, $this->_callback_config, $qbxml);
		}
		
		$err = 'Request for a mapped function could not be fulfilled, invalid $which parameter.';
		return false;
	}
	
	/**
	 * Call a user-defined hook 
	 * 
	 * @param string $ticket
	 * @param string $hook
	 * @param string $requestID
	 * @param string $action
	 * @param mixed $ident
	 * @param mixed $extra
	 * @param string $err
	 * @param string $xml
	 * @param array $qb_identifiers
	 * @param array $hook_data
	 * @return boolean
	 */
	protected function _callHook($ticket, $hook, $requestID, $action, $ident, $extra, &$err, $xml = '', $qb_identifiers = array(), $hook_data = array())
	{
		$user = '';
		if ($ticket)
		{
			$user = $this->_driver->authResolve($ticket);
		}
		
		// Call the hook 
		$ret = QuickBooks_Callbacks::callHook($this->_driver, $this->_hooks, $hook, $requestID, $user, $ticket, $err, $hook_data, $this->_callback_config, __FILE__, __LINE__);
		
		// If the hook reported an error, log the error
		if ($err)
		{
			$errerr = '';
			$this->_handleError($ticket, QUICKBOOKS_ERROR_HOOK, $err, $requestID, $action, $ident, $extra, $errerr, $xml, $qb_identifiers);
		}
		
		return true;
	}
	
	/**
	 * Call an error-handler function and update the status of a request to ERROR
	 * 
	 * @param string $ticket
	 * @param integer $errnum		The error number from QuickBooks (see the QuickBooks SDK/IDN for a list of error codes)
	 * @param string $errmsg		The error message from QuickBooks
	 * @param string $requestID
	 * @param string $action
	 * @param mixed $ident
	 * @param array $extra
	 * @param string $err
	 * @param string $xml
	 * @param array $qb_identifiers
	 */
	protected function _handleError($ticket, $errnum, $errmsg, $requestID, $action, $ident, $extra, &$err, $xml = '', $qb_identifiers = array())
	{
		// , $requestID, $user, $action, $ident, $extra, &$err, $xml, $qb_identifier
		// Call the error handler (if one is set)
		
		$errmsg = html_entity_decode($errmsg);

		// First, set the status of the item to error
		/*
		if ($action and $ident)
		{
			$this->_driver->queueStatus($ticket, $action, $ident, QUICKBOOKS_STATUS_ERROR, $errnum . ': ' . $errmsg);
		}
		*/
		if ($requestID)
		{
			$this->_driver->queueStatus($ticket, $requestID, QUICKBOOKS_STATUS_ERROR, $errnum . ': ' . $errmsg);
		}
		
		// Log the last error (for the ticket)
		$this->_driver->errorLog($ticket, $errnum, $errmsg);
		//$this->_driver->log('Attempting to handle error: ' . $errnum . ', ' . $errmsg);
		$this->_log('Attempting to handle error: ' . $errnum . ', ' . $errmsg, $ticket, QUICKBOOKS_LOG_NORMAL);
		
		// By default, we don't want to continue if the error is not handled
		$continue = false;
		
		// Get username of user which experienced the error
		$user = $this->_driver->authResolve($ticket);
		
		// CALL THE ERROR HANDLER 
		$err = '';
		$continue = QuickBooks_Callbacks::callErrorHandler($this->_driver, $this->_onerror, $errnum, $errmsg, $user, $requestID, $action, $ident, $extra, $err, $xml, $this->_callback_config);
		//													$Driver, $errmap, $errnum, $errmsg, $user, $action, $ident, $extra, &$errerr, $xml, $callback_config
		
		if ($err)
		{
			// Log error messages returned by the error handler 
			//$this->_driver->log('An error occured while handling error: ' . $errnum . ': ' . $errmsg . ': ' . $err, $ticket, QUICKBOOKS_LOG_NORMAL);
			$this->_log('An error occured while handling error: ' . $errnum . ': ' . $errmsg . ': ' . $err, $ticket, QUICKBOOKS_LOG_NORMAL);
			$this->_driver->errorLog($ticket, QUICKBOOKS_ERROR_HANDLER, $err);
		}
		
		// Log the last error (for the log)
		//$this->_driver->log('Handled error: ' . $errnum . ': ' . $errmsg . ' (handler returned: ' . $continue . ')', $ticket, QUICKBOOKS_LOG_NORMAL);
		$this->_log('Handled error: ' . $errnum . ': ' . $errmsg . ' (handler returned: ' . $continue . ')', $ticket, QUICKBOOKS_LOG_NORMAL);
		
		// Update the queue status
		//if ($action and $ident)
		if ($requestID and 
			$continue)
		{
			//$this->_driver->queueStatus($ticket, $action, $ident, QUICKBOOKS_STATUS_HANDLED, $errnum . ': ' . $errmsg);
			$this->_driver->queueStatus($ticket, $requestID, QUICKBOOKS_STATUS_HANDLED, $errnum . ': ' . $errmsg);
		}
		
		return $continue;
	}
	
	/**
	 * Calculate the current progress (what percentage done are we with this session?)
	 * 
	 * @param string $ticket
	 * @return integer
	 */
	protected function _calculateProgress($ticket)
	{
		if ($this->_driver->authCheck($ticket)) // Check the ticket
		{
			$user = $this->_driver->authResolve($ticket);
			
			$current = $this->_driver->queueLeft($user);				// Number of items currently in the queue
			$processed = $this->_driver->queueProcessed($ticket);	// Number of items we've processed during this session
			
			$percentage = 100;
			if ($current)
			{
				$percentage = min(99, floor(100 * ($processed / ($processed + $current))));
			}
			
			// Call the percentage done hook
			$hookerr = null;
			$hookdata = array(
				'user' => $user, 
				'percentage' => $percentage, 
				'items_left' => $current, 
				'items_processed' => $processed, 
				);
			$this->_callHook($ticket, QUICKBOOKS_HANDLERS_HOOK_PERCENT, null, null, null, null, $hookerr, null, array(), $hookdata);
			
			if ($current)
			{
				return $percentage;
			}
			else
			{
				return 100;
			}
		}
		
		return -1;		
	}
	
	/**
	 * ReceiveResponseXML() method for the QuickBooks Web Connector - Receive and handle a resonse form QuickBooks 
	 * 
	 * The stdClass object passed as a parameter will have the following members: 
	 * 	- ->ticket 		The QuickBooks Web Connector ticket
	 * 	- ->response	An XML response message
	 * 	- ->hresult		Error code
	 * 	- ->message		Error message
	 * 
	 * The sole data member of the returned object should be an integer. 
	 * 	- The data member should be -1 if an error occured and QBWC should call ->getLastError()
	 * 	- Should be an integer 0 <= x < 100 to indicate success *and* that the application should continue to call ->sendRequestXML() at least one more time (more queued items still in the queue, the integer represents the percentage complete the total batch job is)
	 * 	- Should be 100 to indicate success *and* that the queue has been exhausted
	 * 
	 * The following user-defined hooks are invoked:
	 * 	- QUICKBOOKS_HANDLERS_HOOK_RECEIVERESPONSEXML
	 * 
	 * @param stdClass $obj
	 * @return QuickBooks_Result_ReceiveResponseXML
	 */
	public function receiveResponseXML($obj)
	{
		//$this->_driver->log('receiveResponseXML()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		$this->_log('receiveResponseXML()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		
		if ($this->_driver->authCheck($obj->ticket)) // Check the ticket
		{
			$user = $this->_driver->authResolve($obj->ticket);
			
			$hookdata = array(
				'username' => $user, 
				'ticket' => $obj->ticket, 
				);
			$hookerr = '';
			$this->_callHook($obj->ticket, QUICKBOOKS_HANDLERS_HOOK_RECEIVERESPONSEXML, null, null, null, null, $hookerr, null, array(), $hookdata);
			
			//$this->_driver->log('Incoming XML response: ' . $obj->response, $obj->ticket, QUICKBOOKS_LOG_DEBUG);
			$this->_log('Incoming XML response: ' . $obj->response, $obj->ticket, QUICKBOOKS_LOG_DEBUG);
			
			// Check if we got a error message...
			if (strlen($obj->message) or 
				$this->_extractStatusCode($obj->response)) // or an error code
			{
				//$this->_log('Extracted code[' . $this->_extractStatusCode($obj->response) . ']', $obj->ticket, QUICKBOOKS_LOG_DEBUG);
				
				$action = null;
				$ident = null;
				$current = null;		// The current item we're receiving a response for
				
				$errnum = null;
				if ($requestID = $this->_extractRequestID($obj->response))
				{
					// This happens if a data validation error occurs 
					//	(string too long, vendor name already taken, etc.)
					
					$errnum = $this->_extractStatusCode($obj->response);
					
					if ($current = $this->_driver->queueGet($user, $requestID, QUICKBOOKS_STATUS_PROCESSING))
					{
						// This is the particular item that experienced an error
						$action = $current['qb_action'];
						$ident = $current['ident'];
					}
					else
					{
						$requestID = null;
					}
					
					//$action = '';
					//$ident = '';
					//$this->_parseRequestID($requestID, $action, $ident);
				}
				else
				{
					// This happens if a protocol error occurs
					//	Poorly formed XML documents, missing XML node, missing line items, etc.)
					
					$errnum = $obj->hresult;
					
					// Try to guess at the request that caused an error (the last request that went out)
					if ($current = $this->_driver->queueProcessing($user))
					{
						$requestID = $current['quickbooks_queue_id'];
						$action = $current['qb_action'];
						$ident = $current['ident'];
					}
				}
				
				//if ($user and $action and $ident)
				if ($current)
				{
					// Fetch the request that was processed and EXPERIENCED AN ERROR! 
					$extra = null;
					/*
					if ($current = $this->_driver->queueFetch($user, $action, $ident, QUICKBOOKS_STATUS_PROCESSING))
					{
						if ($current['extra'])
						{
							$extra = unserialize($current['extra']);
						}
					}
					*/
					
					if ($current['extra'])
					{
						$extra = unserialize($current['extra']);
					}
					
					$errmsg = null;
					if ($obj->message)
					{
						$errmsg = $obj->message;
					}
					else if ($status = $this->_extractStatusMessage($obj->response))
					{
						$errmsg = $status;
					}
					
					$errerr = '';
					$continue = $this->_handleError($obj->ticket, $errnum, $errmsg, $requestID, $action, $ident, $extra, $errerr, $obj->response, array());
					//					$errnum, $errmsg, $requestID, $action, $ident, $extra, &$err, $xml, $qb_identifiers = array()
					
					if ($errerr)
					{
						// The error handler returned an error too...
						//$this->_driver->log('An error occured while handling quickbooks error ' . $errnum . ': ' . $errmsg . ': ' . $errerr, $obj->ticket, QUICKBOOKS_LOG_NORMAL);
						$this->_log('An error occured while handling quickbooks error ' . $errnum . ': ' . $errmsg . ': ' . $errerr, $obj->ticket, QUICKBOOKS_LOG_NORMAL);
					}
				}
				else	// Generic error (poorly encoded XML, XML syntax error, etc.)
				{
					$errerr = '';
					$continue = $this->_handleError($obj->ticket, $obj->hresult, $obj->message, null, null, null, null, $errerr, $obj->response, array()); 
					
					if ($errerr)
					{
						// The error handler returned an error too...
						//$this->_driver->log('An error occured while handling generic error ' . $obj->hresult . ': ' . $obj->message . ': ' . $errerr, $obj->ticket, QUICKBOOKS_LOG_NORMAL);
						$this->_log('An error occured while handling generic error ' . $obj->hresult . ': ' . $obj->message . ': ' . $errerr, $obj->ticket, QUICKBOOKS_LOG_NORMAL);
					}
				}
				
				// Calculate the percentage done
				$progress = $this->_calculateProgress($obj->ticket);
				
				if (!$continue)
				{
					$progress = -1;
				}
				
				//$this->_driver->log('Transaction error at ' . $progress . '% complete... ', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
				$this->_log('Transaction error at ' . $progress . '% complete... ', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
				
				return new QuickBooks_WebConnector_Result_ReceiveResponseXML($progress);
			}
			
			$extra = null;
			$action = null;
			$ident = null;
			
			$requestID = null;
			if ($requestID = $this->_extractRequestID($obj->response) and 
				$current = $this->_driver->queueGet($user, $requestID, QUICKBOOKS_STATUS_PROCESSING))
			{
				//$action = current(explode('|', $requestID));
				//$ident = end(explode('|', $requestID));
				/*
				$action = '';
				$ident = '';
				$this->_parseRequestID($requestID, $action, $ident);
				*/
				
				$action = $current['qb_action'];
				$ident = $current['ident'];
				
				// Fetch the request that's being processed
				$extra = null;
				/*
				if ($current = $this->_driver->queueFetch($user, $action, $ident, QUICKBOOKS_STATUS_PROCESSING))
				{
					if ($current['extra'])
					{
						$extra = unserialize($current['extra']);
					}
				}
				*/
				
				if ($current['extra'])
				{
					$extra = unserialize($current['extra']);
				}
				
				// Update the status to success (no error occured)
				//$this->_driver->queueStatus($obj->ticket, $action, $ident, QUICKBOOKS_STATUS_SUCCESS);
				$this->_driver->queueStatus($obj->ticket, $requestID, QUICKBOOKS_STATUS_SUCCESS);
			}
			else
			{
				// It's a good response... but we couldn't fetch the requestID for some reason?
				$this->_log('This appears to be a correct response, but the requestID could not be validated... ', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
				
				$progress = -1;
				
				return new QuickBooks_WebConnector_Result_ReceiveResponseXML($progress);
			}
			
			// Extract ListID, TxnID, etc. from the response
			$identifiers = $this->_extractIdentifiers($obj->response);
			
			//$this->_driver->log(var_export($identifiers, true), $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
			
			// Auto-map $ident unique identifier from web application to the QuickBooks ListID or TxnID 
			/*
			if ($this->_config['map_application_identifiers'])
			{
				$adds = QuickBooks_Utilities::listActions('*Add*');
				$mods = QuickBooks_Utilities::listActions('*Mod*');
				$qbkey = QuickBooks_Utilities::keyForAction($action);
				$type = QuickBooks_Utilities::actionToObject($action);
				
				$EditSequence = '';
				if (isset($identifiers['EditSequence']))
				{
					$EditSequence = $identifiers['EditSequence'];
				}
				
				if (in_array($action, $adds) and isset($identifiers[$qbkey]) and $type)
				{
					// Try to map the $ident to the QuickBooks identifier
					$this->_driver->identMap($user, $type, $ident, $identifiers[$qbkey], $EditSequence);
				}
				else if (in_array($action, $mods) and isset($identifiers[$qbkey]) and $type)
				{
					// Try to map the $ident to the QuickBooks identifier
					$this->_driver->identMap($user, $type, $ident, $identifiers[$qbkey], $EditSequence);					
				}
			}
			*/
			
			$err = null;
			//$last_action_time = $this->_driver->queueActionLast($user, $action);
			//$last_actionident_time = $this->_driver->queueActionIdentLast($user, $action, $ident);
			$last_action_time = null;
			$last_actionident_time = null;
				
			//if ($ident) // If they didn't pass a requestID, $ident will not be set, and we can't call this reliably 
			if ($requestID)
			{
				$this->_callMappedFunction(1, $user, $requestID, $action, $ident, $extra, $err, $last_action_time, $last_actionident_time, $obj->response, $identifiers);
			}
			
			// Calculate the percentage done
			$progress = $this->_calculateProgress($obj->ticket);
			
			if ($err)
			{
				$errerr = '';
				$continue = $this->_handleError($obj->ticket, QUICKBOOKS_ERROR_HANDLER, $err, $requestID, $action, $ident, $extra, $errerr, $obj->response, $identifiers);
				
				if (!$continue)
				{
					$progress = -1;
				}
			}
			
			//$this->_driver->log($progress . '% complete... ', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
			$this->_log($progress . '% complete... ', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
			
			return new QuickBooks_WebConnector_Result_ReceiveResponseXML($progress);
		}
		
		return new QuickBooks_WebConnector_Result_ReceiveResponseXML(-1);
	}

	/**
	 * QuickBooks Web Connector ->connectionError() SOAP method
	 * 
	 * The stdClass object passed in as a parameter has these members:
	 * 	- ->ticket 		The ticket string
	 * 	- ->hresult		An error code
	 * 	- ->message 	An error message from QuickBooks/QBWC
	 * 
	 * The following user-defined hooks are invoked:
	 * 	- QUICKBOOKS_HANDLERS_HOOK_CONNECTIONERROR
	 * 
	 * @param stdClass $obj
	 * @return QuickBooks_Result_ConnectionError
	 */
	public function connectionError($obj)
	{
		//$this->_driver->log('connectionErrorXML()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		$this->_log('connectionErrorXML()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		
		if ($this->_driver->authCheck($obj->ticket))
		{
			$user = $this->_driver->authResolve($obj->ticket);
			
			$hookdata = array(
				'username' => $user, 
				'ticket' => $obj->ticket, 
				'hresult' => $obj->hresult, 
				'message' => $obj->message, 
				);
			$hookerr = '';
			$this->_callHook($obj->ticket, QUICKBOOKS_HANDLERS_HOOK_CONNECTIONERROR, null, null, null, null, $hookerr, null, array(), $hookdata);
			
			$err = '';
			$this->_handleError($obj->ticket, $obj->hresult, $obj->message, null, null, null, null, $err, null);
			
			return new QuickBooks_WebConnector_Result_ConnectionError('done');
		}
		
		return new QuickBooks_WebConnector_Result_ConnectionError('done');
	}

	/**
	 * QuickBooks Web Connector ->getLastError() SOAP method
	 * 
	 * The stdClass object passed in as a parameter has these members:
	 * 	- ->ticket		The ticket string
	 * 
	 * The returned object should have just one member, an error message 
	 * describing the last error that occured.
	 * 
	 * The following user-defined hooks are invoked:
	 * 	- QUICKBOOKS_HANDLERS_HOOK_GETLASTERROR
	 * 
	 * @return QuickBooks_Result_GetLastError
	 */
	public function getLastError($obj)
	{
		//$this->_driver->log('getLastError()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		$this->_log('getLastError()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		
		if ($this->_driver->authCheck($obj->ticket))
		{
			$user = $this->_driver->authResolve($obj->ticket);
			
			$hookdata = array(
				'username' => $user, 
				'ticket' => $obj->ticket, 
				);
			$hookerr = '';
			$this->_callHook($obj->ticket, QUICKBOOKS_HANDLERS_HOOK_GETLASTERROR, null, null, null, null, $hookerr, null, array(), $hookdata);
			
			$lasterr = $this->_driver->errorLast($obj->ticket);
			
			return new QuickBooks_WebConnector_Result_GetLastError($lasterr);
		}
	
		return new QuickBooks_WebConnector_Result_GetLastError('Bad ticket.');
	}
	
	/**
	 * QuickBooks Web Connector ->closeConnection() SOAP method
	 * 
	 * The stdClass object passed in as a parameter has these members:
	 * 	- ->ticket 		The ticket string
	 * 
	 * The sole member of the returned object should be a string describing the reason for closing the connection
	 * 
	 * @todo The "Complete!" message should probably be based on a configuration variable, user configurable
	 * 
	 * The following user-defined hooks are invoked:
	 * 	- QUICKBOOKS_HANDLERS_HOOK_CLOSECONNECTION
	 * 
	 * @return QuickBooks_Result_CloseConnection
	 */
	public function closeConnection($obj)
	{
		//$this->_driver->log('closeConnection()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		$this->_log('closeConnection()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		
		if ($this->_driver->authCheck($obj->ticket))
		{
			$user = $this->_driver->authResolve($obj->ticket);
			
			$hookdata = array(
				'username' => $user, 
				'ticket' => $obj->ticket, 
				);
			$hookerr = '';
			$this->_callHook($obj->ticket, QUICKBOOKS_HANDLERS_HOOK_CLOSECONNECTION, null, null, null, null, $hookerr, null, array(), $hookdata);
			
			// 
			return new QuickBooks_WebConnector_Result_CloseConnection('Complete!');
		}
		
		// Bad ticket
		return new QuickBooks_WebConnector_Result_CloseConnection('Bad ticket.');
	}
	
	/**
	 * QuickBooks Web Connector ->getServerVersion() SOAP method
	 * 
	 * The following user-defined hooks are invoked:
	 * 	- QUICKBOOKS_HANDLERS_HOOK_SERVERVERSION
	 * 
	 * @param stdClass $obj
	 * @return QuickBooks_Result_GetServerVersion
	 */
	public function serverVersion($obj)
	{
		//$this->_driver->log('serverVersion()', '', QUICKBOOKS_LOG_VERBOSE);
		$this->_log('serverVersion()', '', QUICKBOOKS_LOG_VERBOSE);
		
		$hookdata = array(  );
		$hookerr = '';
		$this->_callHook(null, QUICKBOOKS_HANDLERS_HOOK_SERVERVERSION, null, null, null, null, $hookerr, null, array(), $hookdata);
		
		return new QuickBooks_WebConnector_Result_ServerVersion($this->_config['server_version']);
	}
	
	/**
	 * QuickBooks Web Connector ->clientVersion() SOAP method - Receive the QuickBooks Web Connector client version (and, if neccessary, act on it)
	 * 
	 * This is an *optional* method, and not all versions of the QuickBooks Web 
	 * Connector will support this method. It doesn't really even *need* to be 
	 * implemented, but PHP will dump notices in our error log if we don't 
	 * implement it and then the web connector tries to call it. 
	 * 
	 * The stdClass object passed as a parameter will have the following members:
	 * 	- strVersion	A string version code indicating the version of the QuickBooks Web Connector that's being used
	 * 
	 * The one member of the returned object should be:
	 * 	- The empty string to tell the web connector to continue with the update
	 * 	- A string that begins with "W:" to display a warning message to the end-user, specify the warning message after the "W:"
	 * 	- A string that begins with "E:" to display an error message to the end-user, specify the error message after the "E:"
	 * 	- A string that begins with "O:" (as in OKAY) to tell the end-user that the server expects a newer version of the web connector, specify the minimum required version after the "O:"
	 * 
	 * The following user-defined hooks are invovked:
	 * 	- QUICKBOOKS_HANDLERS_HOOK_CLIENTVERSION
	 * 
	 * @param stdClass $obj
	 * @return QuickBooks_Result_ClientVersion
	 */
	public function clientVersion($obj)
	{
		//$this->_driver->log('clientVersion()', '', QUICKBOOKS_LOG_VERBOSE);
		$this->_log('clientVersion()', '', QUICKBOOKS_LOG_VERBOSE);
		
		$hookdata = array();
		$hookerr = '';
		$this->_callHook(null, QUICKBOOKS_HANDLERS_HOOK_CLIENTVERSION, null, null, null, null, $hookerr, null, array(), $hookdata);
		
		if (!is_null($this->_config['qbwc_min_version']))
		{
			if (version_compare($obj->strVersion, $this->_config['qbwc_min_version'], '<'))
			{
				//$this->_driver->log('Version Requirement, current: ' . $obj->strVersion . ', required: ' . $this->_config['qbwc_min_version'], '', QUICKBOOKS_LOG_NORMAL);
				$this->_log('Version Requirement, current: ' . $obj->strVersion . ', required: ' . $this->_config['qbwc_min_version'], '', QUICKBOOKS_LOG_NORMAL);
				
				return new QuickBooks_WebConnector_Result_ClientVersion('O:' . $this->_config['qbwc_min_version']);
			}
		}

		return new QuickBooks_WebConnector_Result_ClientVersion('');
	}
	
	/**
	 * QuickBooks Web Connector ->getInteractiveURL() SOAP method - Get the URL to use for an interactive session
	 * 
	 * The stdClass object passed as a parameter will have the following members:
	 * 	- ticket		The ticket string
	 * 	- sessionID		??? (undocumented in QBWC documentation...?)
	 * 
	 * The following user-defined hooks are invoked:
	 * 	- QUICKBOOKS_HANDLERS_HOOK_GETINTERACTIVEURL
	 * 
	 * @param stdClass $obj
	 * @return QuickBooks_Result_GetInteractiveURL
	 */
	/*
	public function getInteractiveURL($obj)
	{
		//$this->_driver->log('getInteractiveURL()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		$this->_log('getInteractiveURL()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		
		if ($this->_driver->authCheck($obj->ticket))
		{
			$user = $this->_driver->authResolve($obj->ticket);
			
			$hookdata = array(
				'username' => $user, 
				'ticket' => $obj->ticket, 
				);
			$hookerr = '';
			$this->_callHook($obj->ticket, QUICKBOOKS_HANDLERS_HOOK_GETINTERACTIVEURL, null, null, null, null, $hookerr, null, array(), $hookdata);
			
			return new QuickBooks_Result_GetInteractiveURL($this->_config['qbwc_interactive_url']);
		}
		
		return new QuickBooks_Result_GetInteractiveURL('');
	}
	*/
	
	/**
	 * 
	 * @todo Implement this... returned object is null!
	 * 
	 * @param stdClass $obj
	 * @return void
	 */
	/*
	public function interactiveRejected($obj)
	{
		//$this->_driver->log('interactiveRejected()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		$this->_log('interactiveRejected()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		
		if ($this->_driver->authCheck($obj->ticket))
		{
			$user = $this->_driver->authResolve($obj->ticket);
			
			$hookdata = array(
				'username' => $user, 
				'ticket' => $obj->ticket, 
				);
			$hookerr = '';
			$this->_callHook($obj->ticket, QUICKBOOKS_HANDLERS_HOOK_GETINTERACTIVEURL, null, null, null, null, $hookerr, null, array(), $hookdata);
			
			return null;
		}
		
		return null;
	}
	*/
	
	/**
	 * 
	 * 
	 * The stdClass object passed as a parameter will have the following members:
	 * 	- ticket
	 * 
	 * @param stdClass $obj
	 * @return QuickBooks_Result_InteractiveDone
	 */
	/*
	public function interactiveDone($obj)
	{
		//$this->_driver->log('interactiveDone()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		$this->_log('interactiveDone()', $obj->ticket, QUICKBOOKS_LOG_VERBOSE);
		
		if ($this->_driver->authCheck($obj->ticket))
		{
			$user = $this->_driver->authResolve($obj->ticket);
			
			$hookdata = array(
				'username' => $user, 
				'ticket' => $obj->ticket, 
				);
			$hookerr = '';
			$this->_callHook($obj->ticket, QUICKBOOKS_HANDLERS_HOOK_INTERACTIVEDONE, null, null, null, null, $hookerr, null, array(), $hookdata);
			
			return new QuickBooks_Result_InteractiveDone('Done');
		}
		
		return new QuickBooks_Result_InteractiveDone('');
	}
	*/
}
