<?php

/**
 * Example CodeIgniter QuickBooks Web Connector integration
 * 
 * This file servers as a controller which servers up .QWC configuration files, 
 * also also acts as the Web Connector SOAP endpoint. Download your .QWC file 
 * by visiting:
 * 	http://path/to/ci/quickbooks/config
 * 
 * The Web Connector will get pointed to this endpoint:
 * 	http://path/to/ci/quickbooks/qbwc
 * 
 * This particular example adds dummy customers to QuickBooks, but you could 
 * easily extend it to perform other operations on QuickBooks too. The final 
 * piece of this is just throwing things into the queue to be processed - for 
 * an example of that, see: 
 * 	docs/example_web_connector_queueing.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

/**
 * Example CodeIgniter controller for QuickBooks Web Connector integrations
 */
class QuickBooks extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		// QuickBooks config
		$this->load->config('quickbooks');
		
		// Load your other models here... 
		//$this->load->model('yourmodel1');
		//$this->load->model('yourmodel2');
		//$this->load->model('yourmodel3');
	}
	
	/**
	 * Generate and return a .QWC Web Connector configuration file
	 */
	public function config()
	{
		$name = 'CodeIgniter QuickBooks Demo';			// A name for your server (make it whatever you want)
		$descrip = 'CodeIgniter QuickBooks Demo';		// A description of your server 

		$appurl = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/qbwc';		// This *must* be httpS:// (path to your QuickBooks SOAP server)
		$appsupport = $appurl; 		// This *must* be httpS:// and the domain name must match the domain name above

		$username = $this->config->item('quickbooks_user');		// This is the username you stored in the 'quickbooks_user' table by using QuickBooks_Utilities::createUser()

		$fileid = QuickBooks_WebConnector_QWC::fileID();		// Just make this up, but make sure it keeps that format
		$ownerid = QuickBooks_WebConnector_QWC::ownerID();		// Just make this up, but make sure it keeps that format

		$qbtype = QUICKBOOKS_TYPE_QBFS;	// You can leave this as-is unless you're using QuickBooks POS

		$readonly = false; // No, we want to write data to QuickBooks

		$run_every_n_seconds = 600; // Run every 600 seconds (10 minutes)

		// Generate the XML file
		$QWC = new QuickBooks_WebConnector_QWC($name, $descrip, $appurl, $appsupport, $username, $fileid, $ownerid, $qbtype, $readonly, $run_every_n_seconds);
		$xml = $QWC->generate();

		// Send as a file download
		header('Content-type: text/xml');
		//header('Content-Disposition: attachment; filename="my-quickbooks-wc-file.qwc"');
		print($xml);
		exit;

	}
	
	/**
	 * SOAP endpoint for the Web Connector to connect to
	 */
	public function qbwc()
	{
		$user = $this->config->item('quickbooks_user');
		$pass = $this->config->item('quickbooks_pass');
		
		// Memory limit
		ini_set('memory_limit', $this->config->item('quickbooks_memorylimit'));
		
		// We need to make sure the correct timezone is set, or some PHP installations will complain
		if (function_exists('date_default_timezone_set'))
		{
			// * MAKE SURE YOU SET THIS TO THE CORRECT TIMEZONE! *
			// List of valid timezones is here: http://us3.php.net/manual/en/timezones.php
			date_default_timezone_set($this->config->item('quickbooks_tz'));
		}
				
		// Map QuickBooks actions to handler functions
		$map = array(
			QUICKBOOKS_ADD_CUSTOMER => array( array( $this, '_addCustomerRequest' ), array( $this, '_addCustomerResponse' ) ),
			);
		
		// Catch all errors that QuickBooks throws with this function 
		$errmap = array(
			'*' => array( $this, '_catchallErrors' ),
			);
		
		// Call this method whenever the Web Connector connects
		$hooks = array(
			//QuickBooks_WebConnector_Handlers::HOOK_LOGINSUCCESS => array( array( $this, '_loginSuccess' ) ), 	// Run this function whenever a successful login occurs
			);
		
		// An array of callback options
		$callback_options = array();
		
		// Logging level
		$log_level = $this->config->item('quickbooks_loglevel');
		
		// What SOAP server you're using 
		//$soapserver = QUICKBOOKS_SOAPSERVER_PHP;			// The PHP SOAP extension, see: www.php.net/soap
		$soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;		// A pure-PHP SOAP server (no PHP ext/soap extension required, also makes debugging easier)
		
		$soap_options = array(		// See http://www.php.net/soap
			);
		
		$handler_options = array(
			'deny_concurrent_logins' => false, 
			);		// See the comments in the QuickBooks/Server/Handlers.php file
		
		$driver_options = array(		// See the comments in the QuickBooks/Driver/<YOUR DRIVER HERE>.php file ( i.e. 'Mysql.php', etc. )
			'max_log_history' => 32000,	// Limit the number of quickbooks_log entries to 1024
			'max_queue_history' => 1024, 	// Limit the number of *successfully processed* quickbooks_queue entries to 64
			);
		
		// Build the database connection string
		$dsn = 'mysql://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/' . $this->db->database;
		
		// Check to make sure our database is set up 
		if (!QuickBooks_Utilities::initialized($dsn))
		{
			// Initialize creates the neccessary database schema for queueing up requests and logging
			QuickBooks_Utilities::initialize($dsn);
			
			// This creates a username and password which is used by the Web Connector to authenticate
			QuickBooks_Utilities::createUser($dsn, $user, $pass);
		}
		
		// Set up our queue singleton
		QuickBooks_WebConnector_Queue_Singleton::initialize($dsn);
		
		// Create a new server and tell it to handle the requests
		// __construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array()
		$Server = new QuickBooks_WebConnector_Server($dsn, $map, $errmap, $hooks, $log_level, $soapserver, QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
		$response = $Server->handle(true, true);
	}
	
	/**
	 * Issue a request to QuickBooks to add a customer
	 */
	public function _addCustomerRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
	{
		// Do something here to load data using your model
		//$data = $this->yourmodel->getCustomerData($ID);
		
		// Build the qbXML request from $data
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
	 * Handle a response from QuickBooks indicating a new customer has been added
	 */	
	public function _addCustomerResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		// Do something here to record that the data was added to QuickBooks successfully 
		
		return true; 
	}
	
	/**
	 * Catch and handle errors from QuickBooks
	 */		
	public function _catchallErrors($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
	{
		return false;
	}
	
	/**
	 * Whenever the Web Connector connects, do something (e.g. queue some stuff up if you want to)
	 */
	public function _loginSuccess($requestID, $user, $hook, &$err, $hook_data, $callback_config)
	{
		return true;
	}
}
	