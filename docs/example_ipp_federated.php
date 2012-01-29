<?php

/**
 * Example (very, very simple) federated application
 * 
 * IMPORTANT: This example works in conjunction with the 
 * 	docs/example_ipp_saml.php example. It *will not work* unless you have been 
 *	forwarded to this file by the QuickBooks_IPP_Federator class (because you 
 * 	won't have the IPP ticket neccessary to connect to IPP)!
 *
 * @author Keith Palmer <keith@ConsoliBYTE.com>
 */

// Headers
header('Content-Type: text/plain');

// Error reporting
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// Require the library
require_once dirname(__FILE__) . '/../QuickBooks.php';

// Our application token
$token = 'tex3r7hwifx6cci3zk43ibmnd';

// The realm we want to get IDS data from
$realmID = 173642438;

// The dbid instance
$dbid = 'be9mh7qd5';

// Create our new IPP instance
$IPP = new QuickBooks_IPP();

// Get the context (stored in a coookie by the QuickBooks_IPP_Federator)
$ticket = null;		// By setting this to NULL we're telling the framework to try to fetch the ticket from a cookie
if ($Context = $IPP->context($ticket, $token))
{
	// Set the application
	$IPP->dbid($Context, $dbid);
	
	// Set the flavor 
	$IPP->flavor(QuickBooks_IPP_IDS::FLAVOR_DESKTOP);
	
	// Create a new Customer Service for IDS
	$CustomerService = new QuickBooks_IPP_Service_Customer();
	
	// Get a list of Customers from QuickBooks
	$list = $CustomerService->findAll($Context, $realmID);
	
	// Print them
	print_r($list);
}
else
{
	print('Oh no! We couldn\'t fetch a context!');
}