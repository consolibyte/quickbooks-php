<?php

/**
 * Example of reading/writing data to/from Intuit Data Services
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */
 
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', true);

// Output format
header('Content-Type: text/plain');

// Include the library
require_once '../QuickBooks.php';

// AppCenter username/password
// 
// IMPORTANT NOTE:
//	Normally, you'd never collect your end-users username/password. You'll 
//	never get through Intuit's tech review with code that does this. However, 
//	it makes testing a lot easier when you're initially developing stuff. 
$username = 'support@consolibyte.com';
$password = '';

// This is your AppCenter application security token
$token = '';

// This is your QuickBooks realm ID (a unique identifier for your .QBW file)
$realmID = 214137760;

// This is your QuickBooks DBID (a unique identifier for your subscription)
$dbid = '';

// IPP instance
$IPP = new QuickBooks_IPP();

// Set the QuickBooks flavor
$IPP->flavor(QuickBooks_IPP_IDS::FLAVOR_DESKTOP);

if ($Context = $IPP->authenticate($username, $password, $token))
{
	// Set the DBID passed to you by OAuth/SAML
	$IPP->dbid($Context, $dbid);
	
	// Create a new Customer Service for IDS
	$CustomerService = new QuickBooks_IPP_Service_Customer();
	
	// Here's the ID of the customer we want to fetch
	$ID = '{NG-2762403}';
	
	// In case you want XML back...
	//$IPP->useIDSParser(false);
	
	// Get the customer
	if ($Customer = $CustomerService->findById($Context, $realmID, $ID))
	{
		print_r($Customer);
	}
	else
	{
		print('Could not fetch list of customers... [' . $IPP->lastRequest() . "\n\n\n\n" . $IPP->lastResponse() . ']');
	}
}
else
{
	print('Could not auth to AppCenter... [' . $IPP->lastRequest() . ']' . "\n\n\n" . '[' . $IPP->lastResponse() . ']');
}	

