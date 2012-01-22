<?php

/**
 * Example QuickBooks SOAP Server / Web Service for QuickBooks Point of Sale
 * 
 * This is an example Web Service which adds test dummy customers to QuickBooks 
 * Point of Sale via the Web Connector. 
 * 
 * You should probably also look through docs/example_web_connector.php for 
 * some additional documentation about what things do.  
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// We need to make sure the correct timezone is set, or some PHP installations will complain
if (function_exists('date_default_timezone_set'))
{
	// * MAKE SURE YOU SET THIS TO THE CORRECT TIMEZONE! *
	// List of valid timezones is here: http://us3.php.net/manual/en/timezones.php
	date_default_timezone_set('America/New_York');
}

// Error reporting for easier debugging
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Require the framework
require_once '../QuickBooks.php';

// A username and password you'll use in: 
//	a) Your .QWC file
//	b) The Web Connector
//	c) The QuickBooks framework
$user = 'quickbooks';
$pass = 'password';

// Map QuickBooks actions to handler functions
$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( '_quickbooks_pos_customer_add_request', '_quickbooks_pos_customer_add_response' ),
	// ... more action handlers here ...
	);

// This is entirely optional, use it to trigger actions when an error is returned by QuickBooks
$errmap = array(
	);

// An array of callback hooks
$hooks = array(
	);

// Logging level
//$log_level = QUICKBOOKS_LOG_NORMAL;
//$log_level = QUICKBOOKS_LOG_VERBOSE;
//$log_level = QUICKBOOKS_LOG_DEBUG;				
$log_level = QUICKBOOKS_LOG_DEVELOP;		// Use this level until you're sure everything works!!!

// What SOAP server you're using 
//$soapserver = QUICKBOOKS_SOAPSERVER_PHP;			// The PHP SOAP extension, see: www.php.net/soap
$soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;		// A pure-PHP SOAP server (no PHP ext/soap extension required, also makes debugging easier)

$soap_options = array(		// See http://www.php.net/soap
	);

$handler_options = array(
	'deny_concurrent_logins' => false, 
	);		// See the comments in the QuickBooks/Server/Handlers.php file

$driver_options = array(		// See the comments in the QuickBooks/Driver/<YOUR DRIVER HERE>.php file ( i.e. 'Mysql.php', etc. )
	);

$callback_options = array(
	);

// * MAKE SURE YOU CHANGE THE DATABASE CONNECTION STRING BELOW TO A VALID MYSQL USERNAME/PASSWORD/HOSTNAME *
$dsn = 'mysql://root:root@localhost/quickbooks_pos_server';

if (!QuickBooks_Utilities::initialized($dsn))
{
	// Initialize creates the neccessary database schema for queueing up requests and logging
	QuickBooks_Utilities::initialize($dsn);
	
	// This creates a username and password which is used by the Web Connector to authenticate
	QuickBooks_Utilities::createUser($dsn, $user, $pass);
	
	// We're going to queue up a request to add a customer, just as a test...
	$primary_key_of_your_customer = 5;

	$Queue = new QuickBooks_WebConnector_Queue($dsn);
	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $primary_key_of_your_customer);
}

// Create a new server and tell it to handle the requests
// __construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array()
$Server = new QuickBooks_WebConnector_Server($dsn, $map, $errmap, $hooks, $log_level, $soapserver, QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
$response = $Server->handle(true, true);

/**
 * Generate a qbXML request for QuickBooks Point of Sale
 */
function _quickbooks_pos_customer_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// We're just testing, so we'll just use a static test request:
	$xml = '
		<?xml version="1.0" encoding="utf-8"?>
		<?qbposxml version="3.0"?>
		<QBPOSXML>
			<QBPOSXMLMsgsRq onError="stopOnError">
				<CustomerAddRq>
					<CustomerAdd>
						<CompanyName>ConsoliBYTE, LLC</CompanyName>
						<EMail>support@ConsoliBYTE.com</EMail>
						<FirstName>Keith</FirstName>
						<LastName>Palmer Jr.</LastName>
						<Phone>860-341-1464</Phone>
						<Salutation>Mr.</Salutation>
						<BillAddress>
							<City>Willington</City>
							<Country>USA</Country>
							<PostalCode>06279</PostalCode>
							<State>CT</State>
							<Street>56 Cowles Road</Street>
						</BillAddress>
						<ShipAddress>
							<City>Willington</City>
							<Country>USA</Country>
							<PostalCode>06279</PostalCode>
							<State>CT</State>
							<Street>56 Cowles Road</Street>
						</ShipAddress>
					</CustomerAdd>
				</CustomerAddRq>
			</QBPOSXMLMsgsRq>
		</QBPOSXML>';
	
	return $xml;
}

/**
 * Receive a response from QuickBooks 
 */
function _quickbooks_pos_customer_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
	// Great, customer $ID has been added to QuickBooks with a QuickBooks 
	//	ListID value of: $idents['ListID']
	// 
	// We probably want to store that ListID in our database, so we can use it 
	//	later. (You'll need to refer to the customer by either ListID or Name 
	//	in other requests, say, to update the customer or to add an invoice for 
	//	the customer. 
	
	/*
	mysql_query("UPDATE your_customer_table SET quickbooks_listid = '" . mysql_escape_string($idents['ListID']) . "' WHERE your_customer_ID_field = " . (int) $ID);
	*/
}

