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

// This is your AppCenter application security token
$token = 'tex3r7hwifx6cci3zk43ibmnd';

// This is your QuickBooks realm ID (a unique identifier for your .QBW file)
$realmID = 133828393;

// This is your QuickBooks DBID (a unique identifier for your subscription)
$dbid = 'be9mh7qd5';

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
	
	// Get a list of Customers from QuickBooks
	$list = $CustomerService->findAll($Context, $realmID);
	
	if ($list)
	{
		// Print them out
		foreach ($list as $Customer)
		{
			$line = '';
			$city = '';
			$state = '';
			if ($Address = $Customer->getAddress(0))
			{
				$line = $Address->getLine1();
				$city = $Address->getCity();
				$state = $Address->getCountrySubDivisionCode();
			}
			
			print('Customer name is: ' . $Customer->getName() . ' has an address of: ' . $line . ' ' . $city . ' ' . $state . "\n");
		}
	}
	else
	{
		print('Could not fetch list of customers... [' . $IPP->lastRequest() . "\n\n\n\n" . $IPP->lastResponse() . ']');
	}
}
else
{
	print('Could not auth to AppCenter... [' . $IPP->lastResponse() . ']');
}	

