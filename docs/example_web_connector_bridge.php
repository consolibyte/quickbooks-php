<?php

/**
 * Example QuickBooks SOAP Server
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

// Include path for the QuickBooks library
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks/');

// Require the framework
require_once 'QuickBooks.php';

// A username and password you'll use in: 
//	a) Your .QWC file
//	b) The Web Connector
//	c) The QuickBooks framework
//
// 	NOTE: This has *no relationship* with QuickBooks usernames, Windows usernames, etc. 
// 		It is *only* used for the Web Connector and SOAP server! 
$user = 'quickbooks';
$pass = 'password';

// The next three parameters, $map, $errmap, and $hooks, are callbacks which 
//	will be called when certain actions/events/requests/responses occur within 
//	the framework. The examples below show how to register callback 
//	*functions*, but you can actually register any of the following, using 
//	these formats:

/*
// Callback functions

$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( 'my_function_name_for_requests', 'my_function_name_for_responses' ), 
	);

$errmap = array(
	500 => 'my_function_name_for_handling_500_errors', 
	);

$hooks = array(
	QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS => 'my_function_name_for_when_a_login_succeeds', 
	);

function my_function_name_for_requests() { ... }
function my_function_name_for_handling_500_errors() { ... }
function my_function_name_for_when_a_login_succeeds() { ... }
*/

/*
// Callback static methods
//	Remember that your methods *must be static methods* and thus can't use 
//	$this->... or other non-static methods.

$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( 'My_Class_Name::my_method_name_for_requests', 'My_ClassName::my_method_name_for_responses' ), 
	);

$errmap = array(
	500 => 'My_Class_Name::my_method_name_for_handling_500_errors', 
	);
	
$hooks = array(
	QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS => 'My_Class_Name::my_method_name_for_when_a_login_succeeds', 
	);
	
class My_Class_Name
{
	static public function my_method_name_for_requests() { ... }
	static public function my_method_name_for_responses() { ... }
	static public function my_method_name_for_handling_500_errors() { ... }
	static public function my_method_name_for_when_a_login_succeeds() { ... }
}
*/

/*
// Callback object instance methods
//  Important! If you're using this method, remember that QuickBooks requests 
//	and responses happen during *different* HTTP connections! So, you won't be 
//	able to preserve instance variables from a request handler to a response 
//	handler without writing it to a database or file or something. 
//	
//	example:
//		HTTP connect
//			ask for request
//			framework calls request handler, sends qbXML request
//		HTTP disconnect
//
//		HTTP connect
//			send the response
//			framework calls response handler, calls any error handlers
//			framework sends back a percentage done
//		HTTP disconnect

$obj = new My_Class_Name();

$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( array( $obj, 'my_method_name_for_requests' ), array( $obj, 'my_method_name_for_responses' ) ), 
	);

$errmap = array(
	500 => array( $obj, 'my_method_name_for_handling_500_errors' ), 
	);

$hooks = array(
	QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS => array( $obj, 'my_method_name_for_when_a_login_succeeds' ), 
	);
	
class My_Class_Name
{
	public function __construct(...)
	{
		... 
	}
	
	public function my_method_name_for_requests() { ... }
	public function my_method_name_for_responses() { ... }
	public function my_method_name_for_handling_500_errors() { ... }
	public function my_method_name_for_when_a_login_succeeds() { ... }
}
*/

// Map QuickBooks actions to handler functions 
$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( '_quickbooks_customer_add_request', '_quickbooks_customer_add_response' ),
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
$log_level = QUICKBOOKS_LOG_DEBUG;				// Use this level until you're sure everything works!!!
//$log_level = QUICKBOOKS_LOG_DEVELOP;

// What SOAP server you're using 
//$soapserver = QUICKBOOKS_SOAPSERVER_PHP;			// The PHP SOAP extension, see: www.php.net/soap
$soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;		// A pure-PHP SOAP server (no PHP ext/soap extension required, also makes debugging easier)

$soap_options = array(		// See http://www.php.net/soap
	);

$handler_options = array(
	//'authenticate_handler' => ' *** YOU DO NOT NEED TO PROVIDE THIS CONFIGURATION VARIABLE TO USE THE DEFAULT AUTHENTICATION METHOD FOR THE DRIVER YOU'RE USING (I.E.: MYSQL) *** '
	//'authenticate_handler' => 'ldapv3://ldap.example.com:389/ou=People,dc=example,dc=com',
	//'authenticate_handler' => 'mysql://user:pass@localhost/database?quickbooks_user',  
	//'authenticate_handler' => 'postgresql://user:pass@localhost/database?quickbooks_user', 
	);		// See the comments in the QuickBooks/Server/Handlers.php file

$driver_options = array(		// See the comments in the QuickBooks/Driver/<YOUR DRIVER HERE>.php file ( i.e. 'Mysql.php', etc. )
	);

$bridge_options = array(
	//'allow_remote_addr' => array( '127.0.0.1', '192.168.0.0/24' ), 
	);

$callback_options = array(
	);

// * MAKE SURE YOU CHANGE THE DATABASE CONNECTION STRING BELOW TO A VALID MYSQL USERNAME/PASSWORD/HOSTNAME *
// 
// This assumes that:
//	- You are connecting to MySQL with the username 'root'
//	- You are connecting to MySQL with an empty password
//	- Your MySQL server is located on the same machine as the script ( i.e.: 'localhost', if it were on another machine, you might use 'other-machines-hostname.com', or '192.168.1.5', or ... etc. )
//	- Your MySQL database name containing the QuickBooks tables is named 'quickbooks' (if the tables don't exist, they'll be created for you) 
$dsn = 'mysql://root:@localhost/quickbooks_bridge';
//$dsn = 'mysql://root:password@localhost/your_database';				// Connect to a MySQL database with user 'root' and password 'password'
//$dsn = 'pgsql://pgsql:password@localhost/your_database';				// Connect to a PostgreSQL database 
//$dsn = 'pearmdb2.mysql://root:password@localhost/your_database';		// Connect to MySQL using the PEAR MDB2 database abstraction library
//$dsn = 'sqlite://filename';											// Connect to an SQLite database

// This is a DSN-style connection string that indicates where incoming bridged 
//	qbXML requests should be received from. In this case, we're tellling the 
//	framework that someone is going to send us HTTP requests which we'll parse 
//	and use to queue up actions to be sent to QuickBooks.
// 
// You'll have to look at the documentation for each QuickBooks_Transport_* 
//	class for more details about how the transport expects qbXML requests and 
//	data to be sent to it. For the HTTP transport, it expects us to POST HTTP 
//	requests to it. You can look at docs/example_bridge_sendhttp.php to see an 
//	example of POSTing the request to this bridge. 
$transport_in = 'http://localhost/~kpalmer/QuickBooks%20Bridge/example_bridge_http-send.php';
//$transport_in = 'pop3://user:pass@localhost';

// This is a DSN-style connection string that indicates where outgoing bridged 
//	qbXML responses from QuickBooks should be directed. In this case, we're 
//	telling the framework to send the responses via HTTP to the following URL. 
// 
// You'll have to look at the documentation for each QuickBooks_Transport_* 
//	class for more details about how the transport sends back the qbXML 
//	responses to whereever. For the HTTP transport, the bridge will do a HTTP 
//	POST for each qbXML response. You can look at 
//	docs/example_bridge_receivehttp.php to see an example of receiving the 
//	incoming qbXML response. 
//$transport_out = 'http://localhost/~kpalmer/QuickBooks%20Bridge/example_bridge_http-receive.php';
$transport_out = 'http://localhost/~kpalmer/QuickBooks%20Bridge/example_bridge_http-receive.php';
//$transport_out = 'smtp://user:pass@localhost';

if (!QuickBooks_Utilities::initialized($dsn))
{
	QuickBooks_Utilities::initialize($dsn);
	QuickBooks_Utilities::createUser($dsn, $user, $pass);
}

// Create a new server and tell it to handle the requests
// __construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array()
$Server = new QuickBooks_Server_Bridge(
	$dsn, 
	$transport_in, 
	$transport_out, 
	$user, 
	$map, 
	$errmap, 
	$hooks, 
	$log_level, 
	$soapserver, 
	QUICKBOOKS_WSDL, 
	$soap_options, 
	$handler_options, 
	$driver_options, 
	$bridge_options, 
	$callback_options);
$response = $Server->handle(true, true);

/*
// If you wanted, you could do something with $response here for debugging

$fp = fopen('/path/to/file.log', 'a+');
fwrite($fp, $response);
fclose($fp);
*/

?>
