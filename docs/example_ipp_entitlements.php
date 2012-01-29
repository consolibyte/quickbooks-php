<?php

/**
 * Example of adding new objects to QuickBooks via IPP/IDS
 * 
 * @author Keith Palmer <keith@ConsoliBYTE.com>
 * 
 * @package QuickBooks
 * @subpackage docs
 */

// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

// QuickBooks library
require_once '../QuickBooks.php';

// Credentials
$username = 'keith@consolibyte.com';
$password = 'abcd1234';

// Application token
$token = '';

// Application
$dbid = 'abcd1234';

// IPP instance
$IPP = new QuickBooks_IPP();

if ($Context = $IPP->authenticate($username, $password, $token))
{
	// DBID
	$IPP->dbid($dbid);

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
	print('Auth failed!');
}