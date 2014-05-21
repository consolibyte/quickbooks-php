<?php

/**
 * Example QuickBooks SOAP Server / Web Service
 * 
 * This script imports all QuickBooks customers, along with any custom fields 
 * that the customer has. It also demonstrates fetching only certain elements 
 * to help speed up data transfers by limiting the amount of data returned from 
 * QuickBooks.
 *
 * On each run, ALL customer records in QB are retrieved. All records are 
 * grabbed each time because there is no way to determine the subset of the 
 * customers who have a modified custom field since a previous run.
 *
 * QuickBooks *does* support a ModifiedDate filter to let you grab customer 
 * records that have changed since a given date/time, *however* this will not 
 * work if you're dealing with custom fields. The customer record *will not* 
 * be modified if you *only* update a custom field (i.e. only the *custom field* 
 * record gets modified, not the actual customer record), so if you need 
 * up-to-date custom field data, you can't rely on the TimeModified value of the 
 * customer record. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @author Larry Kluger <larry@masteragenda.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// This makes debugging a bit easier...
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// We need to make sure the correct timezone is set, or some PHP installations will complain
if (function_exists('date_default_timezone_set'))
{
	// * MAKE SURE YOU SET THIS TO THE CORRECT TIMEZONE! * See http://us3.php.net/manual/en/timezones.php
	date_default_timezone_set('America/New_York');
}

// Require the framework
require_once '../QuickBooks.php'; 

// Web Connector username/password
$user = 'user';
$pass = 'pass';
$dsn = 'mysql://root:root@localhost/quickbooks';
 
// How many customer records should be grabbed per chunk (we have to chunk up 
//	the result set, or the Web Connector will barf if there's too much data)
define('QB_QUICKBOOKS_MAX_RETURNED', 30); 

// What date/time to start grabbing QuickBooks data from
define('QB_QUICKBOOKS_BEGINNING_OF_TIME', '1970-01-01T00:00:00');

// Map QuickBooks actions to handler functions
$map = array(
	QUICKBOOKS_IMPORT_CUSTOMER => array( '_quickbooks_customer_import_request', '_quickbooks_customer_import_response' ), 
	);

// Error handlers
$errmap = array(
	500 => '_quickbooks_error_e500_notfound', 			// Catch errors caused by searching for things not present in QuickBooks
	1 => '_quickbooks_error_e500_notfound', 
	'*' => '_quickbooks_error_catchall', 				// Catch any other errors that might occur
	);

// An array of callback hooks
$hooks = array(
	QuickBooks_WebConnector_Handlers::HOOK_LOGINSUCCESS => '_quickbooks_hook_loginsuccess', 	// call this for a successful login
	);

// Logging level

$log_level = QUICKBOOKS_LOG_DEVELOP;

// What SOAP server you're using 
$soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;		// A pure-PHP SOAP server (no extensions required)

// Some other options
$soap_options = array();
$handler_options = array();		
$driver_options = array();
$callback_options = array();

// If we haven't done our one-time initialization yet, do it now!
if (!QuickBooks_Utilities::initialized($dsn))
{ 
	// Initialize creates the neccessary database schema for queueing up requests and logging
	QuickBooks_Utilities::initialize($dsn);
	
	// This creates a username and password which is used by the Web Connector to authenticate
	QuickBooks_Utilities::createUser($dsn, $user, $pass);	
}

// Initialize the queue
QuickBooks_WebConnector_Queue_Singleton::initialize($dsn);

// Create a new server and tell it to handle the requests
$Server = new QuickBooks_WebConnector_Server($dsn, $map, $errmap, $hooks, $log_level, $soapserver, QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
$response = $Server->handle(true, true);

/**
 * Login success hook - perform an action when a user logs in via the Web Connector
 * 
 * Every time the Web Connector logs in, we're going to queue up a request to 
 * import all of the customers from QuickBooks. 
 */
function _quickbooks_hook_loginsuccess($requestID, $user, $hook, &$err, $hook_data, $callback_config)
{
	// Fetch the queue instance
	$Queue = QuickBooks_WebConnector_Queue_Singleton::getInstance();
		
	// Queue request
	$Queue->enqueue(QUICKBOOKS_IMPORT_CUSTOMER, 1);
}

/**
 * Build a request to import customers already in QuickBooks into our application
 */
function _quickbooks_customer_import_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// Iterator support (break the result set into small chunks)
	$attr_iteratorID = '';
	$attr_iterator = ' iterator="Start" ';
	if (!empty($extra['iteratorID']))
	{
		// This is a continuation of a batch
		$attr_iteratorID = ' iteratorID="' . $extra['iteratorID'] . '" ';
		$attr_iterator = ' iterator="Continue" ';
	}
	
	// Build the request
	$xml = '<?xml version="1.0" encoding="utf-8"?>
		<?qbxml version="' . $version . '"?>
		<QBXML>
			<QBXMLMsgsRq onError="stopOnError">
				<CustomerQueryRq ' . $attr_iterator . ' ' . $attr_iteratorID . '>
					<MaxReturned>' . QB_QUICKBOOKS_MAX_RETURNED . '</MaxReturned>
					<FromModifiedDate>' . QB_QUICKBOOKS_BEGINNING_OF_TIME . '</FromModifiedDate>
					
					<!-- You can use the <IncludeRetElement> tag to limit the 
					        data you get back from QuickBooks. This is often 
					        helpful to improve performance by reducing the 
					        amount of data transferred over the wire. 
					        
					        Be careful! These are case sensitive, so make sure 
					        that you use the correct tag names! -->
					        
					<IncludeRetElement>ListID</IncludeRetElement>
					<IncludeRetElement>EditSequence</IncludeRetElement>
					<IncludeRetElement>FullName</IncludeRetElement>
					<IncludeRetElement>FirstName</IncludeRetElement>
					<IncludeRetElement>LastName</IncludeRetElement>
					
					<!-- Note that you can NOT specify child nodes here. i.e 
					        You can\'t indicate that you just want the City tag. 
					        You\'d have to indicate that you want the ShipAddress 
					        tag and then parse the City tag out of that in the 
					        response. For example: -->
					        
					<!-- This is WRONG, there is no root level City tag! -->
					<!-- <IncludeRetElement>City</IncludeRetElement> -->
					
					<!-- This is RIGHT, you\'ll get back the entire ShipAddress, 
					        and you can then grab the City tag within that. -->
					<IncludeRetElement>ShipAddress</IncludeRetElement>
					        
					<!-- This is the tag that contains the custom fields. -->
					<IncludeRetElement>DataExtRet</IncludeRetElement>
					
					<!-- Make sure you set OwnerID to 0 (zero) in the query!
					        If you don\'t, you won\'t get back any custom fields! -->
					<OwnerID>0</OwnerID>
					
				</CustomerQueryRq>	
			</QBXMLMsgsRq>
		</QBXML>';
	
	return $xml;
}   
 
/** 
 * Handle a response from QuickBooks 
 */
function _quickbooks_customer_import_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
	if (!empty($idents['iteratorRemainingCount']))
	{
		// Queue up another request	
		$Queue = QuickBooks_WebConnector_Queue_Singleton::getInstance();
		$Queue->enqueue(QUICKBOOKS_IMPORT_CUSTOMER, null, 0, array( 'iteratorID' => $idents['iteratorID'] ));
	}
	
	// This piece of the response from QuickBooks is now stored in $xml. You 
	//	can process the qbXML response in $xml in any way you like. Save it to 
	//	a file, stuff it in a database, parse it and stuff the records in a 
	//	database, etc. etc. etc. 
	//	
	// The following example shows how to use the built-in XML parser to parse 
	//	the response and stuff it into a database. 
	
	// Import all of the records
	$errnum = 0;
	$errmsg = '';
	$Parser = new QuickBooks_XML_Parser($xml);
	if ($Doc = $Parser->parse($errnum, $errmsg))
	{
		$Root = $Doc->getRoot();
		$List = $Root->getChildAt('QBXML/QBXMLMsgsRs/CustomerQueryRs');
		
		foreach ($List->children() as $Customer)
		{
			$values = array(
				'ListID' => $Customer->getChildDataAt('CustomerRet ListID'),
				'FullName' => $Customer->getChildDataAt('CustomerRet FullName'),
				'FirstName' => $Customer->getChildDataAt('CustomerRet FirstName'),
				'LastName' => $Customer->getChildDataAt('CustomerRet LastName'),
				);
				
			foreach ($Customer->children() as $Node)
			{
				// Be careful! Custom field names are case sensitive! 
				if ($Node->name() === 'DataExtRet' and 
					$Node->getChildDataAt('DataExtRet DataExtName') == 'Your Custom Field Name Goes Here')
				{
					$values['Your Custom Field Names Goes Here'] = $Node->getChildDataAt('DataExtRet DataExtValue');
				}
			}
			
			// Do something with that data... 
			// mysql_query("INSERT INTO ... ");		  
		}
	}
	
	return true;
}


/**
 * Handle a 500 not found error from QuickBooks
 * 
 * Instead of returning empty result sets for queries that don't find any 
 * records, QuickBooks returns an error message. This handles those error 
 * messages, and acts on them by adding the missing item to QuickBooks. 
 */
function _quickbooks_error_e500_notfound($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	if ($action == QUICKBOOKS_IMPORT_CUSTOMER)
	{
		return true;
	}
	
	return false;
}


/**
 * Catch any errors that occur
 * 
 * @param string $requestID			
 * @param string $action
 * @param mixed $ID
 * @param mixed $extra
 * @param string $err
 * @param string $xml
 * @param mixed $errnum
 * @param string $errmsg
 * @return void
 */
function _quickbooks_error_catchall($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	$message = '';
	$message .= 'Request ID: ' . $requestID . "\r\n";
	$message .= 'User: ' . $user . "\r\n";
	$message .= 'Action: ' . $action . "\r\n";
	$message .= 'ID: ' . $ID . "\r\n";
	$message .= 'Extra: ' . print_r($extra, true) . "\r\n";
	//$message .= 'Error: ' . $err . "\r\n";
	$message .= 'Error number: ' . $errnum . "\r\n";
	$message .= 'Error message: ' . $errmsg . "\r\n";
	
	// Do something to handle the error
	// mail( ... );
}
