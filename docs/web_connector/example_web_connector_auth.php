<?php

/**
 * Example QuickBooks Web Connector web service with custom authentication
 * 
 * This example shows how to use a custom authentication function to 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// I always program in E_STRICT error mode... 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// We need to make sure the correct timezone is set, or some PHP installations will complain
if (function_exists('date_default_timezone_set'))
{
	// List of valid timezones is here: http://us3.php.net/manual/en/timezones.php
	date_default_timezone_set('America/New_York');
}

// Require the framework
//require_once '../QuickBooks.php';
require_once '/Users/kpalmer/Projects/QuickBooks/QuickBooks.php';

// A username and password you'll use in: 
//	a) Your .QWC file
//	b) The Web Connector
//	c) The QuickBooks framework
$user = 'quickbooks';
$pass = 'password';

// Map QuickBooks actions to handler functions
$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( '_quickbooks_customer_add_request', '_quickbooks_customer_add_response' ),
	// ... more action handlers here ...
	);

// This is entirely optional, use it to trigger actions when an error is returned by QuickBooks
$errmap = array();

// An array of callback hooks
$hooks = array();

// Logging level
$log_level = QUICKBOOKS_LOG_DEVELOP;		// Use this level until you're sure everything works!!!

// SOAP backend
$soap = QUICKBOOKS_SOAPSERVER_BUILTIN;

// SOAP options
$soap_options = array();

// * MAKE SURE YOU CHANGE THE DATABASE CONNECTION STRING BELOW TO A VALID MYSQL USERNAME/PASSWORD/HOSTNAME *
$dsn = 'mysql://root:root@localhost/quickbooks_auth';

// Handler options
$handler_options = array(
	'authenticate' => '_quickbooks_custom_auth', 
	//'authenticate' => '_QuickBooksClass::theStaticMethod',
	'deny_concurrent_logins' => false, 
	);

if (!QuickBooks_Utilities::initialized($dsn))
{
	// Initialize creates the neccessary database schema for queueing up requests and logging
	QuickBooks_Utilities::initialize($dsn);
	
	// This creates a username and password which is used by the Web Connector to authenticate
	QuickBooks_Utilities::createUser($dsn, $user, $pass);
	
	// Queueing up a test request
	$primary_key_of_your_customer = 5;
	$Queue = new QuickBooks_WebConnector_Queue($dsn);
	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $primary_key_of_your_customer);
}

// Create a new server and tell it to handle the requests
// __construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array()
$Server = new QuickBooks_WebConnector_Server($dsn, $map, $errmap, $hooks, $log_level, $soap, QUICKBOOKS_WSDL, $soap_options, $handler_options);
$response = $Server->handle(true, true);

/**
 * Authenticate a Web Connector session
 */
function _quickbooks_custom_auth($username, $password, &$qb_company_file)
{
	if ($username == 'keith' and 
		$password == 'rocks')
	{
		// Use this company file and auth successfully
		$qb_company_file = 'C:\path\to\the\file-function.QBW';
		
		return true;
	}
	
	// Login failure
	return false;
}

/**
 * Authenticate a Web Connector session
 */
/*
class _QuickBooksClass
{
	static public function theStaticMethod($username, $password, &$qb_company_file)
	{
		//print('username [' . $username . '] [' . $password . ']');
		
		if ($username == 'keith' and 
			$password == 'rocks')
		{
			// Use this company file and auth successfully
			$qb_company_file = 'C:\path\to\the\file-staticmethod.QBW';
			
			//print('returning true...');
			
			return true;
		}
		
		// Login failure
		return false;
	}
}
*/

/**
 * Generate a qbXML response to add a particular customer to QuickBooks
 */
function _quickbooks_customer_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// We're just testing, so we'll just use a static test request:
	 
	$xml = '<?xml version="1.0" encoding="utf-8"?>
		<?qbxml version="2.0"?>
		<QBXML>
			<QBXMLMsgsRq onError="stopOnError">
				<CustomerAddRq requestID="' . $requestID . '">
					<CustomerAdd>
						<Name>ConsoliBYTE, LLC (' . mt_rand() . ')</Name>
						<CompanyName>ConsoliBYTE, LLC</CompanyName>
						<FirstName>Keith</FirstName>
						<LastName>Palmer</LastName>
						<BillAddress>
							<Addr1>ConsoliBYTE, LLC</Addr1>
							<Addr2>134 Stonemill Road</Addr2>
							<City>Mansfield</City>
							<State>CT</State>
							<PostalCode>06268</PostalCode>
							<Country>United States</Country>
						</BillAddress>
						<Phone>860-634-1602</Phone>
						<AltPhone>860-429-0021</AltPhone>
						<Fax>860-429-5183</Fax>
						<Email>Keith@ConsoliBYTE.com</Email>
						<Contact>Keith Palmer</Contact>
					</CustomerAdd>
				</CustomerAddRq>
			</QBXMLMsgsRq>
		</QBXML>';
	
	return $xml;
}

/**
 * Receive a response from QuickBooks 
 */
function _quickbooks_customer_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{
	return;	
}
