<?php

require_once '../QuickBooks.php';

$username = 'keith@consolibyte.com';
$password = 'password42';
$token = '';

$application = 'abcd1234';

$IPP = new QuickBooks_IPP();

if ($Context = $IPP->authenticate($username, $password, $token))
{
	$IPP->application($application);

	// Debug mode
	//$IPP->useDebugMode(true);
	
	/*
	// Returns an array with two elements:
	//	0 => an associative array of metadata
	//	1 => a list of QuickBooks_IPP_Entitlement objects
	$retr = $IPP->getEntitlementValues($Context);
	print_r($retr);
	*/
	
	// Returns an array with three elements:
	//	0 => an associative array of metadata
	//	1 => a list of QuickBooks_IPP_Entitlement objects
	//	2 => a list of QuickBooks_IPP_Role objects
	$retr = $IPP->getEntitlementValuesAndUserRole($Context);
	print_r($retr);
	
	/*
	print("\n\n\n\n\n");
	print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
	print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
	*/
}
else
{
	print('auth failed!');
}