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
$username = 'keith@consolibyte.com';
$password = 'abcd1234';

// Application security token
$token = 'tex3r7hwifx6cci3zk43ibmnd';

// Your realm ID 
$realmID = 133828393;

// Your DBID
$dbid = 'be9mh7qd5';

// IPP instance
$IPP = new QuickBooks_IPP();

if ($Context = $IPP->authenticate($username, $password, $token))
{
	// DBID
	$IPP->dbid($Context, $dbid);
	
	// Flavor
	$IPP->flavor(QuickBooks_IPP_IDS::FLAVOR_DESKTOP);
	
	// Create a new Vendor Service for IDS access
	$VendorService = new QuickBooks_IPP_Service_Vendor();
	
	// Get a list of Customers from QuickBooks
	$vendor_list = $VendorService->findAll($Context, $realmID);
	
	// Print the vendors 
	print_r($vendor_list);
}
	
