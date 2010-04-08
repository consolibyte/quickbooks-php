<?php

/**
 * Example QuickBooks SOAP Server / Web Service
 * 
 * This is an example Web Service which adds customers to QuickBooks desktop 
 * editions via the QuickBooks Web Connector. 
 * 
 * This is additional documentation in the docs/example_server.php file. This 
 * particular example is an extension of the docs/example_server.php example 
 * which illustrates using an instantiated object in $map and $onerr. 
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

// I always program in E_STRICT error mode... 
error_reporting(E_ALL | E_STRICT);

// There are some constants you can define to override some default... 
//define('QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX', 'myqb_');
//define('QUICKBOOKS_DRIVER_SQL_MYSQLI_PREFIX', 'myqb_');

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
//	the framework. 

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

$my_example_var1 = null;
$my_example_var2 = null;

$obj = new My_Class_Name($my_example_var1, $my_example_var2);

// Map QuickBooks actions to handler functions
$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( array( $obj, 'addCustomerRequest' ), array( $obj, 'addCustomerResponse' ) ), 
	);

// This is entirely optional, use it to trigger actions when an error is returned by QuickBooks
$errmap = array(
	500 => array( $obj, 'handleError500' ), 
	);

// An array of callback hooks
$hooks = array(
	QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS => array( array( $obj, 'hookLoginSuccess' ) ), 
	);

/**
 * Our QuickBooks request/response handler class 	
 * 
 * NOTE: Remember that the Web Connector processes requests using separate HTTP 
 * connections for the request, the response, error handling, authentication, 
 * etc.  Thus, you can use $this-> class variables, but you can't set the 
 * variable in a request method and then use that value in the response method,
 * because the setting occurs in a totally separate HTTP connection from the 
 * getting. 
 */
class My_Class_Name
{
	/**
	 * DSN-style connection string
	 */
	protected $_dsn;
	
	/**
	 * Class constructor
	 */
	public function __construct($my_example_var1, $my_example_var2)
	{
		
	}
	
	/**
	 * Set our DSN-style connection string
	 * 
	 * This is just a custom helper method shown as an example of implementing 
	 * other methods in the request/response handler class. 
	 * 
	 * @param string $dsn
	 * @return void
	 */
	public function setDSN($dsn)
	{
		$this->_dsn = $dsn;
	}
	
	/**
	 * Generate a qbXML response to add a particular customer to QuickBooks
	 * 
	 * So, you've queued up a QUICKBOOKS_ADD_CUSTOMER request with the 
	 * QuickBooks_Queue class like this: 
	 * 	$Queue = new QuickBooks_Queue('mysql://user:pass@host/database');
	 * 	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $primary_key_of_your_customer);
	 * 
	 * This function will generate a qbXML CustomerAddRq which tells QuickBooks 
	 * to add a customer. 
	 * 
	 * Our response function will in turn receive a qbXML response from 
	 * QuickBooks which contains all of the data stored for that customer 
	 * within QuickBooks. 
	 * 
	 * @param string $requestID					You should include this in your qbXML request (it helps with debugging later)
	 * @param string $action					The QuickBooks action being performed (CustomerAdd in this case)
	 * @param mixed $ID							The unique identifier for the record (maybe a customer ID number in your database or something)
	 * @param array $extra						Any extra data you included with the queued item when you queued it up
	 * @param string $err						An error message, assign a value to $err if you want to report an error
	 * @param integer $last_action_time			A unix timestamp (seconds) indicating when the last action of this type was dequeued (i.e.: for CustomerAdd, the last time a customer was added, for CustomerQuery, the last time a CustomerQuery ran, etc.)
	 * @param integer $last_actionident_time	A unix timestamp (seconds) indicating when the combination of this action and ident was dequeued (i.e.: when the last time a CustomerQuery with ident of get-new-customers was dequeued)
	 * @param float $version					The max qbXML version your QuickBooks version supports
	 * @param string $locale					
	 * @return string							A valid qbXML request
	 */
	public function addCustomerRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
	{
		// You'd probably do some database access here to pull the record with 
		//	ID = $ID from your database and build a request to add that particular 
		//	customer to QuickBooks. 
		
		// But we're just testing, so we'll just use a static test request:
		 
		$xml = '<?xml version="1.0" encoding="utf-8"?>
			<?qbxml version="2.0"?>
			<QBXML>
				<QBXMLMsgsRq onError="stopOnError">
					<CustomerAddRq>
						<CustomerAdd>
							<Name>ConsoliBYTE Solutions (' . mt_rand() . ')</Name>
							<CompanyName>ConsoliBYTE Solutions</CompanyName>
							<FirstName>Keith</FirstName>
							<LastName>Palmer</LastName>
							<BillAddress>
								<Addr1>ConsoliBYTE Solutions</Addr1>
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
	 * 
	 * @param string $requestID					The requestID you passed to QuickBooks previously
	 * @param string $action					The action that was performed (CustomerAdd in this case)
	 * @param mixed $ID							The unique identifier of the record
	 * @param array $extra			
	 * @param string $err						An error message, assign a valid to $err if you want to report an error
	 * @param integer $last_action_time			A unix timestamp (seconds) indicating when the last action of this type was dequeued (i.e.: for CustomerAdd, the last time a customer was added, for CustomerQuery, the last time a CustomerQuery ran, etc.)
	 * @param integer $last_actionident_time	A unix timestamp (seconds) indicating when the combination of this action and ident was dequeued (i.e.: when the last time a CustomerQuery with ident of get-new-customers was dequeued)
	 * @param string $xml						The complete qbXML response
	 * @param array $idents						An array of identifiers that are contained in the qbXML response
	 * @return void
	 */
	public function addCustomerResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
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
	
	/**
	 * Catch and handle a 500 error from QuickBooks
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
	public function handleError500($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
	{
		mail('your-email@your-domain.com', 
			'QuickBooks error occured!', 
			'The following error occured: ' . $errnum . ': ' . $errmsg);
		
		// return true;			// If you return TRUE, it will continue to process requests
		return false;			// If you return FALSE, it will stop processing requests
	}
	
	/** 
	 * Example of a login success hook implemented as an object method 
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $hook
	 * @param string $err
	 * @param array $hook_data
	 * @param array $callback_config
	 * @return boolean
	 */
	public function hookLoginSuccess($requestID, $user, $hook, &$err, $hook_data, $callback_config)
	{
		if ($this->_dsn)
		{
			QuickBooks_Utilities::log($this->_dsn, 'This user logged in and the user login hook was called: ' . $user . ', params: ' . print_r($hook_data, true));
			return true;
		}
		
		return false;
	}
}

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
	//'authenticate_dsn' => ' *** YOU DO NOT NEED TO PROVIDE THIS CONFIGURATION VARIABLE TO USE THE DEFAULT AUTHENTICATION METHOD FOR THE DRIVER YOU'RE USING (I.E.: MYSQL) *** '
	//'authenticate_dsn' => 'ldapv3://ldap.example.com:389/ou=People,dc=example,dc=com',
	//'authenticate_dsn' => 'mysql://user:pass@localhost/database?quickbooks_user',  
	//'authenticate_dsn' => 'postgresql://user:pass@localhost/database?quickbooks_user', 
	//'authenticate_dsn' => 'function://your_function_name_here', 
	);		// See the comments in the QuickBooks/Server/Handlers.php file

$driver_options = array(		// See the comments in the QuickBooks/Driver/<YOUR DRIVER HERE>.php file ( i.e. 'Mysql.php', etc. )
	//'max_log_history' => 1024,	// Limit the number of quickbooks_log entries to 1024
	//'max_queue_history' => 64, 	// Limit the number of *successfully processed* quickbooks_queue entries to 64
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
$dsn = 'mysql://root:@localhost/quickbooks';
//$dsn = 'mysql://root:password@localhost/your_database';				// Connect to a MySQL database with user 'root' and password 'password'
//$dsn = 'mysqli://root:@localhost/quickbooks_mysqli';					// Connect to a MySQL database using the PHP MySQLi extension
$dsn = 'mssql://kpalmer:password@192.168.18.128/test4';					// Connect to MS SQL Server database
//$dsn = 'pgsql://pgsql:password@localhost/your_database';				// Connect to a PostgreSQL database 
//$dsn = 'pearmdb2.mysql://root:password@localhost/your_database';		// Connect to MySQL using the PEAR MDB2 database abstraction library
//$dsn = 'sqlite://filename';											// Connect to an SQLite database

if (!QuickBooks_Utilities::initialized($dsn))
{
	// Initialize creates the neccessary database schema for queueing up requests and logging
	QuickBooks_Utilities::initialize($dsn);
	
	// This creates a username and password which is used by the Web Connector to authenticate
	QuickBooks_Utilities::createUser($dsn, $user, $pass);
	
	// Queueing up a test request
	// 
	// You can instantiate and use the QuickBooks_Queue class to queue up 
	//	actions whenever you want to queue something up to be sent to 
	//	QuickBooks. So, for instance, a new customer is created in your 
	//	database, and you want to add them to QuickBooks: 
	//	
	//	Queue up a request to add a new customer to QuickBooks
	//	$Queue = new QuickBooks_Queue($dsn);
	//	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $primary_key_of_new_customer);
	//	
	// We're going to queue up a request to add a customer, just as a demo...
	// 	NOTE: You would *never* want to do this in this file *unless* it's for testing. See example_integration.php for more details!
	
	$primary_key_of_your_customer = 5;

	$Queue = new QuickBooks_Queue($dsn);
	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $primary_key_of_your_customer);
	
	// Also note the that ->enqueue() method supports some other parameters: 
	// 	string $action				The type of action to queue up
	//	mixed $ident = null			Pass in the unique primary key of your record here, so you can pull the data from your application to build a qbXML request in your request handler
	//	$priority = 0				You can assign priorities to requests, higher priorities get run first
	//	$extra = null				Any extra data you want to pass to the request/response handler
	//	$user = null				If you're using multiple usernames, you can pass the username of the user to queue this up for here
	//	$qbxml = null				
	//	$replace = true				
}

// Set the DSN string because some of our callbacks will use it
$obj->setDSN($dsn);

// Create a new server and tell it to handle the requests
// __construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array()
$Server = new QuickBooks_Server($dsn, $map, $errmap, $hooks, $log_level, $soapserver, QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
$response = $Server->handle(true, true);

/*
// If you wanted, you could do something with $response here for debugging

$fp = fopen('/path/to/file.log', 'a+');
fwrite($fp, $response);
fclose($fp);
*/
