<?php

/**
 * QuickBooks API support for QuickBooks Online Edition
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * This class extends the QuickBooks_API support to QuickBooks Online Edition,
 * by providing an API source which talks directly to QuickBooks Online Edition
 * via HTTPS POST requests. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 *
 * @package QuickBooks
 * @subpackage API
 */

/**
 * Generic utility methods
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

/**
 * API source base class
 */
QuickBooks_Loader::load('/QuickBooks/API/Source.php');

/**
 * QuickBooks Online Edition API source
 * 
 * Communicates with QuickBooks Online Edition via the QBOE HTTPS POST API 
 * methods provided by the Intuit QBOE SDK gateway servers. 
 */
class QuickBooks_API_Source_OE extends QuickBooks_API_Source
{
	/**
	 * The QuickBooks back-end driver object
	 * @var QuickBooks_Driver
	 */
	protected $_driver;
	
	/**
	 * The username of the Web Connector user
	 * @var string
	 */
	protected $_user;
	
	/**
	 * Configuration variables
	 * @var array
	 */
	protected $_config;

	//protected $_connection_ticket;
	
	protected $_application_login;
	protected $_application_id;
	
	protected $_certificate;
	
	protected $_test;
	protected $_debug;
	
	protected $_live_gateway = 'https://webapps.quickbooks.com/j/AppGateway';
	protected $_test_gateway = '';
	
	protected $_ticket_session = '';
	protected $_ticket_connection = '';
	
	protected $_ticket_framework;
	
	protected $_last_request;
	protected $_last_response;	
	
	protected $_errnum;
	protected $_errmsg;
	
	protected $_qbxml_version;
	protected $_qbxml_locale;
	
	/**
	 * Whether or not to enable masking of sensitive data in logging messages (credit card numbers, etc.)
	 * @var boolean
	 */
	protected $_masking;
	
	/**
	 * 
	 * 
	 */
	public function __construct(&$driver_obj, $user, $dsn, $options = array())
	{
		$this->_driver = $driver_obj;
		$this->_user = $user;
		
		$this->_ticket_framework = '';
		
		$this->_config = $this->_defaults($options);
		
		$this->_masking = true;
		
		$this->_test = false;
		$this->_debug = false;
		
		// This particular 'source' uses the same database connection/DSN as 
		//	the driver, so there's no real reason to pull the user from 
		//	elsewhere...
		
		// @TODO Pull this information from the database
		
		if ($this->_config['connection_ticket'])
		{
			// If this info was specified in config, use it
			$this->_ticket_connection = $this->_config['connection_ticket'];

			$this->_certificate = $this->_config['certificate'];
			$this->_application_login = $this->_config['application_login'];
			$this->_application_id = $this->_config['application_id'];
		}
		else
		{
			// Otherwise, try to load it from connection table
			
			$connection = $this->_driver->connectionLoad($user);
			
			$this->_ticket_connection = $connection['connection_ticket'];
			$this->_certificate = $connection['certificate'];
			$this->_application_login = $connection['application_login'];
			$this->_application_id = $connection['application_id'];
		}
		
		// Manual overrides... 
		if ($this->_config['override_session_ticket'])
		{
			$this->_ticket_session = $this->_config['override_session_ticket'];
		} 
			
		if ($this->_config['override_connection_ticket'])
		{
			$this->_ticket_connection = $this->_config['override_connection_ticket'];
		}
				
		$this->_errnum = 0;
		$this->_errmsg = '';
		
		$this->_log('Initialized the QBOE API source...', QUICKBOOKS_LOG_DEVELOP);
		
		// Set the version and locale
		$this->_qbXMLLocale($this->_config['qbxml_locale']);
		$this->_qbXMLVersion($this->_config['qbxml_version']);
	}
	
	/**
	 * Merge configuration options with the default configuration options
	 * 
	 * @param array $options
	 * @return array
	 */
	protected function _defaults($options)
	{
		$defaults = array(
			'qbxml_version' => '6.0', 
			'qbxml_locale' => QUICKBOOKS_LOCALE_OE, 
			'qbxml_onerror' => 'stopOnError', 
			'always_use_iterator' => false, 
			'connection_ticket' => null, 
			'override_connection_ticket' => null, 
			'override_session_ticket' => null, 
			'application_login' => null, 
			'application_id' => null, 
			'certificate' => null, 
			);
		
		return array_merge($defaults, $options);
	}
	
	/**
	 * Get the HTTP/HTTPS gateway to use 
	 * 
	 * @return string
	 */	
	protected function _gateway()
	{
		if ($this->_test)
		{
			$this->_log('Using TEST gateway: ' . $this->_test_gateway, QUICKBOOKS_LOG_DEVELOP);
			return $this->_test_gateway;
		}
		
		$this->_log('Using LIVE gateway: ' . $this->_live_gateway, QUICKBOOKS_LOG_DEVELOP);
		return $this->_live_gateway;
	}	
	
	/**
	 * 
	 * 
	 * @param string $xml
	 * @param string $version
	 * @param string $onerror
	 * @return string
	 */
	protected function _makeValidQBXML($xml, $version = '{$version}', $locale = '{$locale}', $onerror = '{$onerror}')
	{
		$pre = '';
		$pre .= '<?xml version="1.0" ?>' . QUICKBOOKS_CRLF;
		$pre .= '<?qbxml version="6.0"?>' . QUICKBOOKS_CRLF;
		$pre .= '<QBXML>' . QUICKBOOKS_CRLF; 
		$pre .= '	<SignonMsgsRq>' . QUICKBOOKS_CRLF;
		$pre .= '		<SignonTicketRq>' . QUICKBOOKS_CRLF;
		$pre .= '			<ClientDateTime>' . date('Y-m-d') . 'T' . date('h:i:s') . '</ClientDateTime>' . QUICKBOOKS_CRLF;
		$pre .= '			<SessionTicket>' . $this->_ticket_session . '</SessionTicket>' . QUICKBOOKS_CRLF;
		$pre .= '			<Language>English</Language>' . QUICKBOOKS_CRLF;
		$pre .= '			<AppID>' . $this->_application_id . '</AppID>' . QUICKBOOKS_CRLF;
		$pre .= '			<AppVer>1</AppVer>' . QUICKBOOKS_CRLF;
		$pre .= '		</SignonTicketRq>' . QUICKBOOKS_CRLF;
		$pre .= '	</SignonMsgsRq>' . QUICKBOOKS_CRLF;
		$pre .= '	<QBXMLMsgsRq onError="' . $onerror . '">';
		
		$post = '	</QBXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$post .= '</QBXML>';
		
		// If the request they passed is a full request, then we don't need to prepend/append the extra XML
		if (false === stripos($xml, '<QBXML>'))
		{
			return $pre . $xml . $post;
		}
		
		return $xml;
	}

	/**
	 * Get (or set) the connection ticket
	 * 
	 * @param string $cticket		The new connection ticket to set (or null if you only want to get it)
	 * @return string				The connection ticket currently in use
	 */
	protected function _connectionTicket($cticket)
	{
		$current = $this->_ticket_connection;
		
		if ($cticket)
		{
			$this->_ticket_connection = $cticket;
		}
		
		return $current;
	}
	
	protected function _frameworkTicket($lticket)
	{
		$current = $this->_ticket_framework;
		
		if ($lticket)
		{
			$this->_ticket_framework = $lticket;
		}
		
		return $current;
	}
	
	/**
	 * Get (or set) the session ticket 
	 * 
	 * @param string $sticket		The new session ticket to set (or null if you only want to get it)
	 * @return string				The session ticket currently in use
	 */
	protected function _sessionTicket($sticket)
	{
		$this->_setError(QUICKBOOKS_API_ERROR_OK);
		
		$current = $this->_ticket_session;
		
		if ($sticket)
		{
			$this->_ticket_session = $sticket;
		} 
		else
		{	
			// Make sure we have a session ticket so we can actually return it... 
			if (!$this->_isSignedOn())
			{
				$this->_signOn();
				
				if ($this->errorNumber())
				{
					return false;
				}
			}
		}
		
		return $current;
	}
	
	protected function _applicationID($appid)
	{	
		$current = $this->_application_id;
		
		if ($appid)
		{
			$this->_application_id = $appid;
		}
		
		return $current;
	}
	
	protected function _applicationLogin($login)
	{
		$current = $this->_application_login;
		
		if ($login)
		{
			$this->_application_login = $login;
		}
		
		return $current;
	}
	
	protected function _qbXMLVersion($version = null)
	{
		$current = $this->_qbxml_version;
		
		if ($version)
		{
			$this->_qbxml_version = $version;
		}
		
		return $current;
	}
	
	protected function _qbXMLLocale($locale = null)
	{
		$current = $this->_qbxml_locale;
		
		if ($locale)
		{
			$this->_qbxml_locale = $locale;
		}
		
		return $current;
	}
	
	/**
	 * 
	 *
	 * @return boolean
	 */
	protected function _signOn()
	{
		$this->_setError(QUICKBOOKS_API_ERROR_OK);
		
		$xml = '';
		$xml .= '<?xml version="1.0" ?>' . QUICKBOOKS_CRLF;
		$xml .= '<?qbxml version="6.0"?> ' . QUICKBOOKS_CRLF;
		$xml .= '<QBXML>' . QUICKBOOKS_CRLF;
		$xml .= '	<SignonMsgsRq>' . QUICKBOOKS_CRLF;
		
		if ($this->_certificate)
		{
			$this->_log('Signing on as a HOSTED QBOE application.', QUICKBOOKS_LOG_DEBUG);
			
			$xml .= '		<SignonAppCertRq>' . QUICKBOOKS_CRLF;
			$xml .= '			<ClientDateTime>' . date('Y-m-d') . 'T' . date('h:i:s') . '</ClientDateTime> ' . QUICKBOOKS_CRLF;
			$xml .= '			<ApplicationLogin>' . $this->_application_login . '</ApplicationLogin> ' . QUICKBOOKS_CRLF;
			$xml .= '			<ConnectionTicket>' . $this->_ticket_connection . '</ConnectionTicket> ' . QUICKBOOKS_CRLF;
			$xml .= '			<Language>English</Language> ' . QUICKBOOKS_CRLF;
			$xml .= '			<AppID>' . $this->_application_id . '</AppID> ' . QUICKBOOKS_CRLF;
			$xml .= '			<AppVer>1</AppVer> ' . QUICKBOOKS_CRLF;
			$xml .= '		</SignonAppCertRq> ' . QUICKBOOKS_CRLF;
		}
		else
		{
			$this->_log('Signing on as a DESKTOP QBOE application.', QUICKBOOKS_LOG_DEBUG);
			
			$xml .= '		<SignonDesktopRq>' . QUICKBOOKS_CRLF;
			$xml .= '			<ClientDateTime>' . date('Y-m-d') . 'T' . date('h:i:s') . '</ClientDateTime> ' . QUICKBOOKS_CRLF;
			$xml .= '			<ApplicationLogin>' . $this->_application_login . '</ApplicationLogin> ' . QUICKBOOKS_CRLF;
			$xml .= '			<ConnectionTicket>' . $this->_ticket_connection . '</ConnectionTicket> ' . QUICKBOOKS_CRLF;
			$xml .= '			<Language>English</Language> ' . QUICKBOOKS_CRLF;
			$xml .= '			<AppID>' . $this->_application_id . '</AppID> ' . QUICKBOOKS_CRLF;
			$xml .= '			<AppVer>1</AppVer> ' . QUICKBOOKS_CRLF;
			$xml .= '		</SignonDesktopRq> ' . QUICKBOOKS_CRLF;			
		}
		
		$xml .= '	</SignonMsgsRq> ' . QUICKBOOKS_CRLF;
		$xml .= '</QBXML>';
		
		$errnum = QUICKBOOKS_API_ERROR_OK;
		$errmsg = '';
		
		$response = $this->_request($xml, $errnum, $errmsg);
		
		// If we didn't get a response back, something is seriously wrong... 
		if (strlen($response) == 0)
		{
			$this->_setError(QUICKBOOKS_API_ERROR_INTERNAL, 'Received an empty response from source...?');
			return false;
		}
		
		if ($errnum)
		{
			$this->_setError(QUICKBOOKS_API_ERROR_SOCKET, $errnum . ': ' . $errmsg);
			return false;
		}
		
		$code = $this->_extractAttribute('statusCode', $response);
		$message = $this->_extractAttribute('statusMessage', $response);
		
		if ($code != QUICKBOOKS_API_ERROR_OK)
		{
			$this->_setError($code, $message);
			return false;
		}
		
		if ($ticket = $this->_extractTagContents('SessionTicket', $response))
		{
			$this->_ticket_session = $ticket;
			
			if ($this->_driver)
			{
				$company_file = null;
				$wait_before_next_update = null;
				$min_run_every_n_seconds = null;
				
				// This forces the login even if there's no user in the quickbooks_user table
				//	We want to do this so we can do further queue and log operations 
				//	for logging purposes. 
				$override = true;
				
				$fticket = $this->_driver->authLogin(
					$this->_user, 
					'', 
					$company_file, 
					$wait_before_next_update, 
					$min_run_every_n_seconds, 
					$override); 		// Force it to login successfully and create us a ticket
					
				// Use that as the logging ticket	
				$this->frameworkTicket($fticket);
			}
			
			return true;
		}
		
		$this->_setError(QUICKBOOKS_API_ERROR_INTERNAL, 'Could not locate SessionTicket in response.');
		
		return false;
	}
	
	protected function _extractTagContents($tag, $data)
	{
		return QuickBooks_XML::extractTagContents($tag, $data);
	}
	
	protected function _extractAttribute($attr, $data, $which = 0)
	{
		return QuickBooks_XML::extractTagAttribute($attr, $data, $which);
	}
	
	/**
	 * Tell whether or not the user is signed on (has a valid session ticket)
	 * 
	 * @return boolean
	 */
	protected function _isSignedOn()
	{
		return strlen($this->_ticket_session) > 0;
	}
	
	/**
	 * Set whether or not to use the test environment
	 * 
	 * @param boolean $yes_or_no		TRUE to use the test environment, FALSE to use the live one
	 * @return void
	 */
	public function useTestEnvironment($yes_or_no)
	{
		$this->_test = (boolean) $yes_or_no;
	}
	
	/**
	 * Set whether or not to use the live environment
	 * 
	 * @param boolean $yes_or_no
	 * @return void
	 */
	public function useLiveEnvironment($yes_or_no)
	{
		$this->_test = ! (boolean) $yes_or_no;
	}
	
	/**
	 * Turn debugging mode on or off
	 * 
	 * Turning debugging mode on will result in a large amount of output being 
	 * printed directly to stdout (the web browser or the console)
	 * 
	 * @param boolean $yes_or_no
	 * @return void
	 */
	public function useDebugMode($yes_or_no)
	{
		$this->_debug = (boolean) $yes_or_no;
	}	
	
	/**
	 * Handle an object (the Online Edition driver *does not* handle objects! This always returns FALSE!)
	 * 
	 * @return boolean
	 */
	public function handleObject($method, $action, $type, $object, $callbacks, $webapp_ID, $priority, &$err, $recur = null)
	{
		return false;
	}
	
	/**
	 * Handle an array (the Online Edition driver *does not* handle arrays! This always returns FALSE!)
	 * 
	 * @return boolean
	 */
	public function handleArray($method, $action, $type, $array, $callbacks, $webapp_ID, $priority, &$err, $recur = null)
	{
		return false;
	}
	
	/**
	 * 
	 * 
	 * @param string $method
	 * @param string $action
	 * @param string $type
	 * @param string $qbxml
	 * @param array $callbacks
	 * @param mixed $uniqueid
	 * @param integer $priority
	 * @param string $err
	 * @param integer $recur
	 * @return boolean
	 */
	public function handleQBXML($method, $action, $type, $qbxml, $callbacks, $uniqueid, $priority, &$err, $recur = null)
	{
		$this->_setError(QUICKBOOKS_API_ERROR_OK);
		
		// Make sure we have a session ticket 
		if (!$this->_isSignedOn())
		{
			$this->_signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}
		
		// @TODO Determine $action if it's not set
		
		// If a unique ID wasn't provided, we'll make one up
		if (strlen($uniqueid) == 0)
		{
			$uniqueid = md5(time() . $this->_user . mt_rand());
		}
		
		// The qbXML requests that get passed to this function are without the 
		//	typical qbXML wrapper info, so we need to modify them to make them 
		// 	into complete, valid requests. 
		//$qbxml = $this->_makeValidQBXML($qbxml, $this->_config['qbxml_version'], $this->_config['qbxml_onerror']);
		$qbxml = $this->_makeValidQBXML($qbxml, $this->_qbXMLVersion(), $this->_qbXMLLocale(), $this->_config['qbxml_onerror']);
		
		// Map any application identifiers
		$qbxml = QuickBooks_Callbacks_API_Callbacks::mappings($qbxml, $this->_user);
		
		//$requestID = null;
		$extra = array(
			'callbacks' => $callbacks, 
			);
		$last_action_time = null;
		$last_actionident_time = null;
		$qb_identifiers = array();
		
		if ($this->_driver)
		{
			// Stuff this into the queue (just for good record-keeping)...
			$this->_driver->queueEnqueue($this->_user, $action, $uniqueid, true, $priority, $extra, $qbxml);
			
			// ... and mark it as being processed
			$this->_driver->queueStatus(
				$this->frameworkTicket(), 
				$action, 
				$uniqueid, 
				QUICKBOOKS_STATUS_PROCESSING);
		}
		
		// Send the request to QuickBooks Online Edition
		$response = $this->_request($qbxml);
		
		// Try to map the response to QuickBooks objects
		$map = array(
			QUICKBOOKS_QUERY_ACCOUNT => array( '', 'QuickBooks_Callbacks_API_Callbacks::AccountQueryResponse' ), 
			
			QUICKBOOKS_ADD_CUSTOMER => array( '', 'QuickBooks_Callbacks_API_Callbacks::CustomerAddResponse' ), 
			QUICKBOOKS_MOD_CUSTOMER => array( '', 'QuickBooks_Callbacks_API_Callbacks::CustomerModResponse' ), 
			QUICKBOOKS_QUERY_CUSTOMER => array( '', 'QuickBooks_Callbacks_API_Callbacks::CustomerQueryResponse' ),

			QUICKBOOKS_QUERY_CLASS => array( '', 'QuickBooks_Callbacks_API_Callbacks::ClassQueryResponse' ), 

			QUICKBOOKS_QUERY_CUSTOMERTYPE => array( '', 'QuickBooks_Callbacks_API_Callbacks::CustomerTypeQueryResponse' ), 

			QUICKBOOKS_QUERY_ITEM => array( '', 'QuickBooks_Callbacks_API_Callbacks::ItemQueryResponse' ), 
			
			QUICKBOOKS_QUERY_PAYMENTMETHOD => array( '', 'QuickBooks_Callbacks_API_Callbacks::PaymentMethodQueryResponse' ), 
			
			QUICKBOOKS_QUERY_SALESTAXCODE => array( '', 'QuickBooks_Callbacks_API_Callbacks::SalesTaxCodeQueryResponse' ), 
			
			QUICKBOOKS_QUERY_SALESTAXITEM => array( '', 'QuickBooks_Callbacks_API_Callbacks::ItemSalesTaxQueryResponse' ), 
			
			QUICKBOOKS_QUERY_SHIPMETHOD => array( '', 'QuickBooks_Callbacks_API_Callbacks::ShipMethodQueryResponse' ), 
			
			QUICKBOOKS_QUERY_UNITOFMEASURESET => array( '', 'QuickBooks_Callbacks_API_Callbacks::UnitOfMeasureSetQueryResponse' ), 
			
			'*' => array( '', 'QuickBooks_Callbacks_API_Callbacks::RawQBXMLResponse' ), 
			);
		
		// Parse the response and check for errors so we can update the queue
		
		// First, check for protocol level errors (bad login, bad session ticket, etc.)
		$code = $this->_extractAttribute('statusCode', $response, 0);
		$message = $this->_extractAttribute('statusMessage', $response, 0);
		
		if ($code != QUICKBOOKS_API_ERROR_OK)
		{
			if ($this->_driver)
			{
				$this->_driver->queueStatus(
					$this->frameworkTicket(), 
					$action, 
					$uniqueid, 
					QUICKBOOKS_STATUS_ERROR, 
					$code . ': ' . $message);
			}
			
			$this->_setError($code, $message);
			
			// @todo Error handlers for the API classes
			return false;
		}
		
		// Now, check for other errors (customer already exists, you forgot some tag, etc.)		
		// First, check for protocol level errors (bad login, bad session ticket, etc.)
		$code = $this->_extractAttribute('statusCode', $response, 1);
		$message = $this->_extractAttribute('statusMessage', $response);		// This is left at 0 because if we got this far, then there was no statusMessage for the previous check
		
		if ($code == QUICKBOOKS_API_ERROR_OK)
		{
			if ($this->_driver)
			{
				$this->_driver->queueStatus(
					$this->frameworkTicket(), 
					$action, 
					$uniqueid, 
					QUICKBOOKS_STATUS_SUCCESS);
			}			
		}
		else
		{
			if ($this->_driver)
			{
				$this->_driver->queueStatus(
					$this->frameworkTicket(), 
					$action, 
					$uniqueid, 
					QUICKBOOKS_STATUS_ERROR, 
					$code . ': ' . $message);
			}
			
			$this->_setError($code, $message);
			
			// @todo Error handlers for the API classes
			//return false;
		}
		
		//print('calling: '); print_r($map[$action]);
		
		// Call the response handler  
		// @todo What if an error occurs? Are we still calling the handler?
		return QuickBooks_Callbacks::callResponseHandler($this->_driver, $map, $action, $this->_user, $action, $uniqueid, $extra, $err, $last_action_time, $last_actionident_time, $response, $qb_identifiers);
	}
	
	/**
	 * Send an XML request to QuickBooks Online Edition
	 * 
	 * @todo Documentation
	 * 
	 * This function will auto-detect if CURL is enabled, and if so, use CURL. 
	 * Otherwise, it will fall back to using fsockopen(). 
	 * 
	 * @param string $qbxml
	 * @return string
	 */
	protected function _request($qbxml)
	{
		$HTTP = new QuickBooks_HTTP($this->_gateway());
		
		$headers = array(
			'Content-Type' => 'application/x-qbxml',
			);
		$HTTP->setHeaders($headers);
		
		// Turn on debugging for the HTTP object if it's been enabled in the payment processor
		$HTTP->useDebugMode($this->_debug);
		
		// 
		$HTTP->setRawBody($qbxml);
		
		$this->_last_request = $qbxml;
		
		$HTTP->verifyHost(false);
		$HTTP->verifyPeer(false);
		
		if ($this->_certificate)
		{
			$HTTP->setCertificate($this->_certificate);
		}
		
		$return = $HTTP->POST();
		
		$this->_last_response = $return;
		
		// 
		$this->_log($HTTP->getLog(), QUICKBOOKS_LOG_DEBUG);
		
		$errnum = $HTTP->errorNumber();
		$errmsg = $HTTP->errorMessage();
		
		if ($errnum)
		{
			// An error occurred!
			$this->_setError(QUICKBOOKS_API_ERROR_HTTP, $errnum . ': ' . $errmsg);
			return false;
		}
		
		// Everything is good, return the data!
		$this->_setError(QUICKBOOKS_API_ERROR_OK, '');
		return $return;
		
	}
	
	/**
	 * 
	 * 
	 */
	public function  handleSQL($method, $action, $type, $sql, $callbacks, $webapp_ID, $priority, &$err, $recur = null)
	{
		return false;
	}
	
	/**
	 * 
	 * 
	 * @return array
	 */
	public function supported()
	{
		return array(
			QUICKBOOKS_ADD_CLASS, 
			QUICKBOOKS_QUERY_CLASS, 
			
			QUICKBOOKS_ADD_ACCOUNT, 
			QUICKBOOKS_MOD_ACCOUNT, 
			QUICKBOOKS_QUERY_ACCOUNT, 
			
			QUICKBOOKS_ADD_CUSTOMER,
			QUICKBOOKS_MOD_CUSTOMER,  
			QUICKBOOKS_QUERY_CUSTOMER,
			
			QUICKBOOKS_ADD_CUSTOMERTYPE, 
			QUICKBOOKS_QUERY_CUSTOMERTYPE, 
			
			QUICKBOOKS_ADD_DEPOSIT, 
			QUICKBOOKS_MOD_DEPOSIT, 
			QUICKBOOKS_QUERY_DEPOSIT, 
			
			QUICKBOOKS_ADD_DATAEXT, 
			QUICKBOOKS_MOD_DATAEXT, 
			QUICKBOOKS_DEL_DATAEXT, 
			
			QUICKBOOKS_ADD_INVOICE, 
			QUICKBOOKS_MOD_INVOICE, 
			QUICKBOOKS_QUERY_INVOICE, 
						
			QUICKBOOKS_ADD_EMPLOYEE, 
			QUICKBOOKS_MOD_EMPLOYEE, 
			QUICKBOOKS_QUERY_EMPLOYEE, 
			
			QUICKBOOKS_ADD_ESTIMATE, 
			QUICKBOOKS_MOD_ESTIMATE, 
			QUICKBOOKS_QUERY_ESTIMATE, 
			
			QUICKBOOKS_ADD_PAYMENTMETHOD, 
			QUICKBOOKS_QUERY_PAYMENTMETHOD, 
			
			QUICKBOOKS_ADD_RECEIVEPAYMENT, 
			QUICKBOOKS_MOD_RECEIVEPAYMENT,
			QUICKBOOKS_QUERY_RECEIVEPAYMENT,  
			
			QUICKBOOKS_QUERY_ITEM,
			
			QUICKBOOKS_ADD_DISCOUNTITEM, 
			QUICKBOOKS_MOD_DISCOUNTITEM, 
			QUICKBOOKS_QUERY_DISCOUNTITEM, 
			
			QUICKBOOKS_ADD_FIXEDASSETITEM, 
			QUICKBOOKS_MOD_FIXEDASSETITEM, 
			QUICKBOOKS_QUERY_FIXEDASSETITEM, 
			
			QUICKBOOKS_ADD_SERVICEITEM,
			QUICKBOOKS_MOD_SERVICEITEM, 
			QUICKBOOKS_QUERY_SERVICEITEM,  
			
			QUICKBOOKS_ADD_INVENTORYITEM, 
			QUICKBOOKS_MOD_INVENTORYITEM, 
			QUICKBOOKS_QUERY_INVENTORYITEM,
			 
			QUICKBOOKS_ADD_NONINVENTORYITEM,
			QUICKBOOKS_MOD_NONINVENTORYITEM, 
			QUICKBOOKS_QUERY_NONINVENTORYITEM,
			  
			QUICKBOOKS_ADD_OTHERCHARGEITEM, 
			QUICKBOOKS_MOD_OTHERCHARGEITEM, 
			QUICKBOOKS_QUERY_OTHERCHARGEITEM, 
			  
			QUICKBOOKS_ADD_SALESTAXCODE, 
			//QUICKBOOKS_MOD_SALESTAXCODE, 
			QUICKBOOKS_QUERY_SALESTAXCODE, 
			
			QUICKBOOKS_ADD_SALESTAXITEM, 
			QUICKBOOKS_MOD_SALESTAXITEM, 
			QUICKBOOKS_QUERY_SALESTAXITEM,
			
			QUICKBOOKS_ADD_SALESRECEIPT, 
			QUICKBOOKS_MOD_SALESRECEIPT, 
			QUICKBOOKS_QUERY_SALESRECEIPT, 
			
			QUICKBOOKS_ADD_SHIPMETHOD, 
			QUICKBOOKS_QUERY_SHIPMETHOD, 						
			
			//QUICKBOOKS_ADD_UNITOFMEASURESET, 
			//QUICKBOOKS_MOD_UNITOFMEASURESET, 
			//QUICKBOOKS_QUERY_UNITOFMEASURESET,
			
			QUICKBOOKS_ADD_VENDOR, 
			QUICKBOOKS_MOD_VENDOR, 
			QUICKBOOKS_QUERY_VENDOR,  
			);
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsApplicationIDs()
	{
		return true;
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsAdding()
	{
		return true;
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsDeleting()
	{
		return true;
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsModifying()
	{
		return true;
	}
	
	public function supportsQuerying()
	{
		return true;
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsRealtime()
	{
		return true;
	}
	
	public function supportsRecurring()
	{
		return false;
	}
	
	public function understandsSQL()
	{
		return false;
	}
	
	public function understandsQBXML()
	{
		return true;
	}
	
	public function understandsArrays()
	{
		return false;
	}
	
	public function understandsObjects()
	{
		return false;
	}
}
