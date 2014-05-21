<?php defined('SYSPATH') or die('No direct script access.');

/**
 * QuickBooks Kohana Integration Example
 *
 * This is a sample to get you started using Kohana with the QB framework
 * you may consider moving some methods into objects to help keep the code
 * from growing too large, as it can get very bulky in the framework!
 * 
 * See model folder for example of how to move methods out of this
 * 
 * @author Jayson Lindsley <jay.lindsley@gmail.com>
 * 
 */

//set this to the framework directory
require_once 'framework/QuickBooks.php';

class Controller_Qbapi_Quickbooks extends Controller {

	/**
	 * Prep the page for the web connector
	 * @author Jayson Lindsley <Jayson@nerds4u.net>
	 */
	public function before() {
		// Security checking goes in here

		//Turn on error reporting
		error_reporting(E_ALL | E_STRICT);
		//set the content type
	 	$this->response->headers('Content-Type', 'text/xml');
	 	//set the timezone	
		if (function_exists('date_default_timezone_set'))
			date_default_timezone_set('America/Los_Angeles');
	}

	/**
	 * Houses the instance of the soap server and creates the mappings for errors, function callbacks
	 * @author Jayson Lindsley <jay.lindsley@gmail.com>
	 */
	public function action_index()	{
		//Username and password used for the web connector, QWC file, and the QB Framework
		$user = 'QBAPI Username';
		$pass = 'QBAPI Password';

		//Configure the logging level
		$log_level = QUICKBOOKS_LOG_DEVELOP;

		//Pure-PHP SOAP server
		$soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;

		//we can turn this off 
		$handler_options = array(
			'deny_concurrent_logins' => false, 
			'deny_reallyfast_logins' => false, 
		);

		// The next three params $map, $errmap, and $hooks are callbacks which
		// will be called when certain actions/events/requests/responses occur within
		// the framework

		// Maps inbound requests to functions 
		$map = array(
			QUICKBOOKS_ADD_CUSTOMER => array( array($this, '_quickbooks_customer_add_request'), array($this,'_quickbooks_customer_add_response' )),
			QUICKBOOKS_MOD_CUSTOMER => array( array($this, '_quickbooks_customer_mod_request'), array($this, '_quickbooks_customer_mod_response')),
		);
		
		//Map error handling to functions
		$errmap = array(
			3070 => array($this, '_quickbooks_error_stringtoolong'),
			3140	=> array($this, '_quickbooks_reference_error'),
			'*'	=>	array($this, '_quickbooks_error_handler'),
		);

		//Login success callback
		$hooks = array(
			QuickBooks_WebConnector_Handlers::HOOK_LOGINSUCCESS => array(array($this,'_quickbooks_hook_loginsuccess')),
			);

		//MySQL database name containing the QuickBooks tables is named 'quickbooks' (if the tables don't exist, they'll be created for you) 
		$dsn = 'mysql://username:password@host/databasename';

		QuickBooks_WebConnector_Queue_Singleton::initialize($dsn);

		if (!QuickBooks_Utilities::initialized($dsn)) {
			// Initialize creates the neccessary database schema for queueing up requests and logging
			QuickBooks_Utilities::initialize($dsn);

			// This creates a username and password which is used by the Web Connector to authenticate
			QuickBooks_Utilities::createUser($dsn, $user, $pass);
		
			// Initial test case customer
			$primary_key_of_new_customer = 512;
		
			// Fire up the Queue
			$Queue = new QuickBooks_WebConnector_Queue($dsn);
		
			// Drop the directive and the customer into the queue
			$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $primary_key_of_new_customer);
	
			// Also note the that ->enqueue() method supports some other parameters: 
			// 	string $action				The type of action to queue up
			//	mixed $ident = null			Pass in the unique primary key of your record here, so you can pull the data from your application to build a qbXML request in your request handler
			//	$priority = 0				You can assign priorities to requests, higher priorities get run first
			//	$extra = null				Any extra data you want to pass to the request/response handler
			//	$user = null				If you're using multiple usernames, you can pass the username of the user to queue this up for here
			//	$qbxml = null				
			//	$replace = true			
		}
		//To be used with singleton queue
		$driver_options = array();	
	
		//Callback options, not needed at the moment
		$callback_options = array();

		//nothing needed here at the moment
		$soap_options = array();	
		
		//construct a new instance of the web connector server
		$Server = new QuickBooks_WebConnector_Server($dsn, $map, $errmap, $hooks, $log_level, $soapserver, QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
		
		//instruct server to handle responses
		$response = $Server->handle(true, true);
	}


	function _quickbooks_hook_loginsuccess($requestID, $user, $hook, &$err, $hook_data, $callback_config)
	{
		Kohana::$log->add(Log::NOTICE, "Quickbooks Successfully Logged In");

	} 

	function _quickbooks_customer_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
	{
		//Fetch the customer using ORM with the unique ID 
		$mycustomer = ORM::factory('customer', $ID);
		//Fetch all your customer details using the ID passed back up to this function
		$firstname = $mycustomer->firstname;
		$lastname = $mycustomer->lastname;
		$fullname = $firstname . ' ' . $lastname;
		//Generate a QBXML object
		$Customer = new QuickBooks_QBXML_Object_Customer();
		$Customer->setFullName($fullname);
		$Customer->setFirstName($firstname);
		$Customer->setLastName($lastname);
		$Customer->setCompanyName($companyname);

		//Format the proper QBXML to return to the web connector
		$qbxml = $Customer->asQBXML('CustomerAddRq');
		$qbxml = $this->formatForOutput($qbxml);

		//Log that the customer has been generated
		Kohana::$log->add(Log::NOTICE, "\nCustomer QBXML:\n" . $qbxml);
		//send down to web connector
		return $qbxml;
	}

	function _quickbooks_customer_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		Kohana::$log->add(Log::NOTICE, "Add Customer Response: " . $xml); 

		Kohana::$log->add(Log::NOTICE, "Applying QB_LISTID to customer: " . $ID . ', listid: ' . $idents['ListID']);
		
		//fetch the customer
		$mycustomer = ORM::factory('customer', $ID);
		//Save the list id
		$customerdata->listid = $idents['ListID'];
		//save an edit sequence
		$customerdata->editsequence = $idents['EditSequence'];
		//mark the customer as success
		$customerdata->status = 0;
		//save using ORM
		$customerdata->save();
	}

	/* Customer Modification Request Block */
	function _quickbooks_customer_mod_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
	{
		Kohana::$log->add(Log::NOTICE, "\nCustomer Modification QBXML:\n" . $qbxml);
	}

	function _quickbooks_customer_mod_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		Kohana::$log->add(Log::NOTICE, "Mod Customer Response: " . $xml);
	}

	private function formatForOutput($string)
	{
		$return = '<?xml version="1.0" encoding="utf-8"?>
			<?qbxml version="2.0"?>
			<QBXML>
				<QBXMLMsgsRq onError="continueOnError">
				' . $string . '
				</QBXMLMsgsRq>
				</QBXML>';
		return $return;
	}

	 function _quickbooks_error_stringtoolong($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
	{

	}

	function _quickbooks_reference_error($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
	{
		//log the error
		Kohana::$log->add(Log::ERROR, "Reference Error : " . $errmsg);
	}

	function _quickbooks_error_handler($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
	{
		Kohana::$log->add(Log::ERROR, "New Error: " . $requestID . ", action: " . $action . ", ID: " . $ID . "\nmessage:\n" .$errmsg . " - number: " . $errnum); 
	}
}
