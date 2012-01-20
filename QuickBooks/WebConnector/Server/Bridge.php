<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 *
 */
QuickBooks_Loader::load('/QuickBooks/Transport.php');

/**
 *
 */
QuickBooks_Loader::load('/QuickBooks/Transport/Factory.php');

/** 
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Server/Bridge/Callbacks.php');

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Server/Bridge/Errors.php');

/**
 * 
 */
define('QUICKBOOKS_SERVER_BRIDGE_ACTION', 'Bridge');

/**
 * 
 * 
 */
class QuickBooks_Server_Bridge extends QuickBooks_Server
{
	protected $_bridge_user;
	
	protected $_bridge_options;
	
	protected $_transport_in;
	
	protected $_transport_out;
	
	/**
	 * 
	 * 
	 * 
	 */
	public function __construct(
		$dsn_or_conn, 
		$transport_in_dsn, 
		$transport_out_dsn, 
		$user, 
		$map = array(), 
		$onerror = array(), 
		$hooks = array(), 
		$log_level = QUICKBOOKS_LOG_NORMAL, 
		$soap = QUICKBOOKS_SOAPSERVER_BUILTIN, 
		$wsdl = QUICKBOOKS_WSDL, 
		$soap_options = array(), 
		$handler_options = array(), 
		$driver_options = array(), 
		$bridge_options = array(), 
		$transport_in_options = array(), 
		$transport_out_options = array(),
		$callback_options = array())
	{
		// $dsn_or_conn, $map, $onerror = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_BUILTIN, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array()
		
		// Map of callback handlers 		
		$bridge_map = array(
			QUICKBOOKS_SERVER_BRIDGE_ACTION => array( 'QuickBooks_Server_Bridge_Callbacks::prebuiltBridgeRequest', 'QuickBooks_Server_Bridge_Callbacks::prebuiltBridgeResponse' ), 
			);
		
		// Default error handlers
		$bridge_onerror = array(
			'*' => 'QuickBooks_Server_Bridge_Errors::catchall', 
			);
		
		$bridge_onerror = $this->_merge($bridge_onerror, $onerror, false);
		
		// Default hooks
		$bridge_hooks = array(
			// This hook is neccessary for queueing up the appropriate actions to perform the sync 	(use login success so we know user to sync for)
			//QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS => array( 'QuickBooks_Server_SQL_Callbacks::onAuthenticate' ), 
			);
		
		// Create the intput/output transports
		$TransportIn = QuickBooks_Transport_Factory::create($transport_in_dsn, QUICKBOOKS_TRANSPORT_MODE_INPUT, $user, QUICKBOOKS_SERVER_BRIDGE_ACTION, $transport_in_options);
		$TransportOut = QuickBooks_Transport_Factory::create($transport_out_dsn, QUICKBOOKS_TRANSPORT_MODE_OUTPUT, $user, QUICKBOOKS_SERVER_BRIDGE_ACTION, $transport_out_options);
		
		$this->_transport_in = $TransportIn;
		$this->_transport_out = $TransportOut;
		
		// Merge with user-defined hooks
		$bridge_hooks = $this->_merge($hooks, $bridge_hooks, true);
		
		$bridge_callback_options = array(
			'__hooks' => $bridge_hooks, 
			'__map' => $bridge_map, 
			'__transport_input' => $TransportIn, 
			'__transport_output' => $TransportOut, 
			);
		
		// Merge default values with passed in values
		//	(in this case, we are *required* to have these values present, so 
		//	we make sure that the SQL options override any user-defined options
		$bridge_callback_options = $this->_merge($callback_options, $bridge_callback_options, false);
		
		// Initialize the Driver singleton
		$Driver = QuickBooks_Driver_Singleton::getInstance($dsn_or_conn, $driver_options, $bridge_hooks, $log_level);		
		
		$this->_bridge_user = $user;
		$this->_bridge_options = $this->_bridgeDefaults($bridge_options);
		
		// $dsn_or_conn, $map, $onerror = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_BUILTIN, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array()
		parent::__construct($dsn_or_conn, $bridge_map, $bridge_onerror, $bridge_hooks, $log_level, $soap, $wsdl, $soap_options, $handler_options, $driver_options, $bridge_callback_options);
	}
	
	/**
	 * 
	 * 
	 *
	 */
	public function handle($return = false, $debug = false)
	{
		if ($this->_transport_in->ready())
		{
			$this->_bridge();
		}
		else
		{
			parent::handle($return, $debug);
		}
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected function _bridgeDefaults($options)
	{
		$defaults = array(
			'allow_remote_addr' => array(), 
			'deny_remote_addr' => array(), 
			);
		
		$options = array_merge($defaults, $options);
		
		if (!is_array($options['allow_remote_addr']))
		{
			$options['allow_remote_addr'] = array( $options['allow_remote_addr'] );
		}
		
		if (!is_array($options['deny_remote_addr']))
		{
			$options['deny_remote_addr'] = array( $options['deny_remote_addr'] );
		}
		
		return $options;
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected function _bridge()
	{
		$Driver = QuickBooks_Driver_Singleton::getInstance();
		
		$count = 0;
		while ($this->_transport_in->ready())
		{
			if ($this->_transport_in->input($Driver))
			{
				$count++;
			}
		}
		
		return $count;
	}	
}

/*
Sounds nice! I've attached something along the lines of what I'm thinking. (it's just a very rough mock-up right now)

I'll include a file like the one I attached for a few different languages that could utilize the "Bridge" between the language (ASP, Python, etc.) and the PHP framework. 

So there'd be a python.py, and an asp.asp, etc. 

So in your ASP application, you'd include asp.asp, then you could instantiate the QuickBooks_ASP_Bridge and use that to send qbXML requests and receive responses:

<%

# here is my ASP code (I don't know ASP well so the synta xis probably wrong :-P)
dim my_asp_script_bridge
my_asp_script_bridge = new QuickBooks_Bridge_ASP('http://path/to/bridge_server.php')

my_asp_script_bridge.send('<qbxml><InvoiceAdd>...</InvoiceAdd></qbxml>

%>

and then either in a separate ASP script you'd have the code to handle responses:

<%

dim bridge
bridge = new QuickBooks_ASP_Bridge()
bridge->handle('my_function_handler')

Sub asp_function(requestID, action, ident, qbxml_resonse)
 # bla bla bla do soemthing with the repsonse
End Sub

%>

And then on the PHP side, you'd just have a script that looked like this:

<?php
// File: http://path/to/bridge_server.php 

require_once 'QuickBooks.php';

// The QuickBooks_Server_Bridge class essentially just hides what 
// you've been doing, receives POST data from the ASP script and 
// then POSTs qbXML responses back to the ASP bridge script.  
$bridge = new QuickBooks_Server_Bridge('mysql://...');
$bridge->handle();

?>


On Fri, May 23, 2008 2:33 pm, Mike Satkevich wrote:
> In the case of a CustomerQuery, I use the same technique in the PHP
> response handler:
> 
> // Send the response data to ASP
> $URL =
> 'http://www.myaspserver.com/qbwc/server.asp?message=CustomerQueryRs&xml=
> ' . urlencode($xml);
> $qbxml = file_get_contents($URL);
> 
> 
> 
>> From the ASP script, I simply return "OK" if all went well with parsing
>> 
> and saving the data.
> 
> Rather than send the XML encoded on the querystring, I was also thinking
> about storing the XML response in a MySQL table, and just passing back the
> record ID to ASP.
> 
> Then the ASP response handler would in turn request the XML data from
> PHP.
> 
> 
> What do you think?
> 
> 
> Mike
> 
> 
> 
> 
> -----Original Message-----
> From: keith@uglyslug.com [mailto:keith@uglyslug.com]
> Sent: Friday, May 23, 2008 1:01 PM
> To: Mike Satkevich
> Subject: RE: ASP / PHP bridge
> 
> 
> 
> That's great! Very cool! That's *very* similar to what I had in mind,
> I'll
> probably come up with a standard way of doing this for release in the next 
> version, but it'll probably be more or less just a wrapper around what 
> you've already done.
> 
> Very cool, so glad to hear it works!
> 
> 
> Keep me updated with your progress on it/if you deploy it, that's super
> awesome! If you have an Intuit forum account you should post and let people
> know what you're doing, it's a great idea.
> 
> - Keith
> 
> 
> 
> On Fri, May 23, 2008 1:10 pm, Mike Satkevich wrote:
> 
>> I put those two lines of code in your request handler function in
>> "example_server.php".
>> 
>> 
>> 
>> A user of my ASP web app will click a button to add an invoice to QB.
>> This will post the request to your "example_integration.php" page.  I
>> queue the request there, then redirect back to the ASP site.
>> 
>> Then, the WebConnector runs, and the request handler for InvoiceAdd,
>> instead of reading the MySQL database to construct the XML request,
> will go
>> out and get it from ASP using the two lines of code I wrote.
>> 
>> The ASP code reads the invoice data from SQL Server or Access, etc.
>> 
> and
>> formats the qbXML which is returned to your request handler.
>> 
>> I just tried it, and it works perfectly.
>> 
>> 
>> 
>> Mike
>> 
>> 
>> 
>> -----Original Message-----
>> From: keith@uglyslug.com [mailto:keith@uglyslug.com]
>> Sent: Friday, May 23, 2008 12:46 PM
>> To: Mike Satkevich
>> Subject: Re: ASP / PHP bridge
>> 
>> 
>> 
>> 
>> Hahaha, thats great!
>> 
>> 
>> 
>> I think I'll add to something along those lines a bit and add it to
>> 
> the
>> package. I want to be able to have the ASP application queue up
> something
>> too, instead of just having the PHP request function poll the ASP
> server
>> for new data all the time.
>> 
>> Actually... how are you handling the requests? Are you having the ASP
>> function drop a record in the quickbooks_queue table so that the
> request
>> function gets called (and thus file_get_contents() the ASP script?)
>> 
>> Thats super awesome! Quick and clever, I like it!
>> 
>> 
>> 
>> - Keith
>> 
>> 
>> 
>> 
>> 
>> 
>> On Fri, May 23, 2008 12:49 pm, Mike Satkevich wrote:
>> 
>> 
>>> It works with only 2 lines of code!  These go in your request
>>> 
>>> 
>> function.
>>> 
>>> 
>>> 
>>> 
>>> $URL =
>>> 
>>> 
>>> 
>> 
> "http://www.myaspserver.com/qbwc/server.asp?request=InvoiceAdd&requestID
> 
>> 
>>> =$requestID";
>>> 
>>> 
>>> 
>>> 
>>> $qbxml = file_get_contents($URL);
>>> 
>>> 
>>> 
>>> 
>>> 
>>> 
>>> Pretty cool, huh?
>>> 
>>> 
>>> 
>>> 
>>> 
>>> 
>>> Mike
>>> 
>>> 
>>> 
>>> 
>>> 
>> 
> 
*/
