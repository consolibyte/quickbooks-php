<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', true);

// Output
header('Content-Type: text/plain');

// Include the library
require_once '../QuickBooks.php';

// AppCenter username/password
$username = 'keith@consolibyte.com';
$password = 'password42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';
$realmID = 173642438;

// IPP instance
$IPP = new QuickBooks_IPP();

// Set the QuickBooks flavor
$IPP->flavor(QuickBooks_IPP_IDS::FLAVOR_DESKTOP);

if ($Context = $IPP->authenticate($username, $password, $token))
{
	// Set the DBID passed to you by OAuth/SAML
	$IPP->dbid($Context, 'be9mh7qd5');
	
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
		print('Could not fetch list of customers... [' . $IPP->lastResponse() . ']');
	}
}
else
{
	print('Could not auth to AppCenter... [' . $IPP->lastResponse() . ']');
}	

