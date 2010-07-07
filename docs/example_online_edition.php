<?php

/**
 * Example showing how to connect PHP to QuickBooks Online Edition
 * 
 * * IMPORTANT * 
 * Before using this file, you must go through the Intuit application 
 * registration process. This is documented here: 
 * 	http://wiki.consolibyte.com/wiki/doku.php/quickbooks_online_edition
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// 
header('Content-Type: text/plain');

// 
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/keithpalmerjr/Projects/QuickBooks/');
error_reporting(E_ALL | E_STRICT);

/**
 * Require the QuickBooks base classes
 */
require_once 'QuickBooks.php';

// Tell the framework what username to use to keep track of your requests
//	(You can just make these up at the moment, they don't do anything...)
$username = 'api';
$password = 'password';

// Tell the QuickBooks_API class you'll be connecting to QuickBooks Online Edition
$source_type = QuickBooks_API::SOURCE_ONLINE_EDITION;

// If you want to log requests/responses to a database, you can provide a DSN-
//	style connection string to the database here. 
$api_driver_dsn = null;
// $api_driver_dsn = 'mysql://root:@localhost/quickbooks_api';
// $api_driver_dsn = 'pgsql://pgsql@localhost/quickbooks_onlineedition';

// This is not applicable to QBOE
$source_dsn = null;

// Various API options
$api_options = array();

// Options for QBOE
$source_options = array(
	// There are two models of communication for QuickBooks Online Edition. One 
	//	is the 'Hosted' model, the other is the 'Desktop' model. You can use 
	//	either if you're developing a web application. 
	// 
	// If you're using the 'Desktop' model of communication with QuickBooks OE, 
	//	then you can safely ignore the 'certificate' parameter. The 'Desktop' 
	//	model of communication with QBOE is easier to set up, at the expense of 
	//	being a little less secure. 
	// 
	// If you're using the 'Hosted' model of communication with QuickBooks OE, 
	//	then you'll be generating a private key and a CSR, and Intuit will sign 
	//	sign your CSR and send it back to you. You must provide a full path to 
	//	the concatenation of the private key file and the signed CSR. So, the 
	//	file should look something like:
	// 
	//	-----BEGIN RSA PRIVATE KEY-----
	//	... bla bla bla lots of stuff here ...
	//	-----END RSA PRIVATE KEY-----
	//	-----BEGIN CERTIFICATE-----
	//	... bla bla bla lots of stuff here ...
	//	-----END CERTIFICATE-----
	//	
	//	You'll then save that someplace safe with a .pem extension, and point 
	//	this file path to that file. 
	//'certificate' => '/Users/keithpalmerjr/Projects/QuickBooks/QuickBooks/dev/test_qboe.pem', 
	
	// These next 3 configuration options are *required* 
	//	You should have been supplied with all 3 of these values when you went 
	//	through the Application Registration process on the Intuit Developer 
	//	website. 
	//	
	//	connection_ticket - QuickBooks Online Edition does an HTTP POST to your callback URL to send you this
	//	application_login - Provided by the application registration page
	//	application_id - Provided by the application registration page 	
	'connection_ticket' => 'TGT-47-1sRm2nXMVfm$n8hb2MZfVQ', 
	'application_login' => 'test.www.academickeys.com', 
	'application_id' => '134476472', 
	
	// This is just for debugging/testing, and you should comment this out... 
	//'override_session_ticket' => 'V1-184-uVBpWbpD17931L2hMNMw$A:134864687', 	// Comment this line out unless you know what you're doing!
	);

// Driver options
$driver_options = array();

// If you want to log requests/responses to a database, initialize the database
if ($api_driver_dsn and !QuickBooks_Utilities::initialized($api_driver_dsn))
{
	QuickBooks_Utilities::initialize($api_driver_dsn);
	QuickBooks_Utilities::createUser($api_driver_dsn, $username, $password);
}

// Create the API instance
$API = new QuickBooks_API($api_driver_dsn, $username, $source_type, $source_dsn, $api_options, $source_options, $driver_options);

// Turn on debugging mode
$API->useDebugMode(true);

// With QuickBooks Online Edition, the API can return values to you rather than 
//	using callback functions to return values. Remember that is you use this, 
//	your code will be less portable to systems using non-real-time connections
//	(i.e. the QuickBooks Web Connector). 
//$API->enableRealtime(true);


// The "raw" approach to accessing QuickBooks Online Edition is to build and 
//	parse the qbXML requests/responses send to/from QuickBooks yourself. Here 
//	is an example of querying for a customer by building a raw qbXML request. 
//	The qbXML response is passed back to you in the _raw_qbxml_callback() 
//	function as the $qbxml parameter. 
$return = $API->qbxml('
		<CustomerQueryRq>
			<FullName>Keith Palmer Jr.</FullName>
		</CustomerQueryRq>', '_raw_qbxml_callback_1');

// This function gets called when QuickBooks Online Edition sends a response back
function _raw_qbxml_callback_1($method, $action, $ID, &$err, $qbxml, $Iterator, $qbres)
{
	print('We got back this Customer qbXML from QuickBooks Online Edition: ' . $qbxml . ', iterator: ' . print_r($Iterator, true));
}

