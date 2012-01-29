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
$token = 'tex3r7hwifx6cci3zk43ibmnd';

// DBID
$dbid = 'be9mh7qd5';

// IPP instance
$IPP = new QuickBooks_IPP();

if ($IPP->authenticate($username, $password, $token))
{
	$IPP->dbid($Context, $dbid);

	//$IPP->useDebugMode(true);

	print_r($IPP->cookies());

	//print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
	//print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
	
	
	//$IPP->createTable('test_table_name', 'Testers');
	
	//print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
	//print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
	
	//exit;
	
	/*
	$realm = $IPP->getIDSRealm();
	
	print('Last request: [' . $IPP->lastRequest() . ']');
	
	print("\n\n\n");
	
	print('Last response: [' . $IPP->lastResponse() . ']');
	*/
	
	/*
	$companies = $IPP->getAvailableCompanies();
	
	print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
	print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
	
	
	print($companies);
	*/
	
	/*
	$IPP->attachIDSRealm(173642438);
	
	print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
	print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
	
	
	$IPP->getIDSRealm();
	
	print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
	print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
	*/
	
	
	$IPP->test(1);
	
	print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
	print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
	
	
	$IPP->provisionUser('keith@uglyslug.com', 'Keith', 'Palmer');
	print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
	print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
}
