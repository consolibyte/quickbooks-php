<?php

/**
 * Example of connecting PHP to the QuickBooks Merchant Service
 * 
 * * IMPORTANT * 
 * In order to use this example, you'll need to go through the Intuit 
 * application registration process first! This is documented here: 
 * 	http://wiki.consolibyte.com/wiki/doku.php/quickbooks_qbms_integration
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Plain text output
header('Content-Type: text/plain');

// Show some errors... 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Include the QuickBooks files
require_once '../QuickBooks.php';

// $dsn = 'mysql://root:@localhost/quickbooks_merchantservice';
$dsn = null;

//$path_to_private_key_and_certificate = null;							// If you're using the DESKTOP model
$path_to_private_key_and_certificate = null;

//$application_login = 'test.www.academickeys.com';
$application_login = 'qbms.consolibyte.com';

//$connection_ticket = 'TGT-152-LWGj1YQUufTAlSW8DK1c6A';
$connection_ticket = 'TGT-157-p3PyZPoH3DtieLSh4ykp6Q';

// Create an instance of the MerchantService object 
$MS = new QuickBooks_MerchantService(
	$dsn, 
	$path_to_private_key_and_certificate, 
	$application_login,
	$connection_ticket);

// If you're using a Intuit QBMS development account, you must set this to true! 
$MS->useTestEnvironment(true);

// If you want to see the full XML input/output, you can turn on debug mode
$MS->useDebugMode(true);

$routing = '211170282';
$account = '414074882';

$info = QuickBooks_MerchantService_CheckingAccount::INFO_PERSONAL;
$type = QuickBooks_MerchantService_CheckingAccount::TYPE_CHECKING;

$first_name = 'Keith';
$last_name = 'Palmer';

$phone = '+1 (860) 634-1602';

$Check = new QuickBooks_MerchantService_CheckingAccount(
	$routing, 
	$account, 
	$info, 
	$type, 
	$first_name, 
	$last_name, 
	$phone);

// We're going to transfer $295 out of their checking account
$amount = 295.0;

if ($Transaction = $MS->debitCheck($Check, $amount, QuickBooks_MerchantService::MODE_INTERNET))
{
	
	print_r($Transaction);
}
else
{
	print('An error occured during refund: ' . $MS->errorNumber() . ': ' . $MS->errorMessage() . "\n");
}


