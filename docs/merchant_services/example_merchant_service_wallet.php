<?php

/**
 * Example of using QuickBooks Merchant Services 'Payment Wallet' support
 * 
 * Make sure you look at docs/example_merchant_service.php first!
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Plain text output
header('Content-Type: text/plain');

// I always program in E_STRICT error mode... 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Include the QuickBooks files
require_once '../QuickBooks.php';

$dsn = null;
// $dsn = 'mysql://root:@localhost/quickbooks_merchantservice';

$path_to_private_key_and_certificate = null;
//$path_to_private_key_and_certificate = '/Users/keithpalmerjr/Projects/QuickBooks/QuickBooks/dev/test_qbms.pem';

$application_login = 'test.foxycart.com';
//$application_login = 'test.www.academickeys.com';

$connection_ticket = 'TGT-145-niiEL2kCFoOTYHvkwBarmg';
//$connection_ticket = 'TGT-152-LWGj1YQUufTAlSW8DK1c6A';

// Create an instance of the MerchantService object 
$MS = new QuickBooks_MerchantService(
	$dsn, 
	$path_to_private_key_and_certificate, 
	$application_login,
	$connection_ticket);

// If you're using a Intuit QBMS development account, you must set this to true! 
$MS->useTestEnvironment(true);

// If you want to see the full XML input/output, you can turn on debug mode
//$MS->useDebugMode(true);

// Now, let's create a credit card object, and authorize an amount agains the card
$name = 'Keith Palmer';
$number = '5105105105105100';
$expyear = date('Y');
$expmonth = date('m');
$address = '56 Cowles Road';
$postalcode = '06279';
$cvv = '349';

// Create the CreditCard object
$Card = new QuickBooks_MerchantService_CreditCard($name, $number, $expyear, $expmonth, $address, $postalcode, $cvv);

// Our customer #
$customerID = '1234ABCD';

// Add this credit card to the wallet
if ($walletID = $MS->addWallet($customerID, $Card))
{
	print('New wallet ID created: ' . $walletID . "\n");
}
else
{
	print('An error occurred: [' . $MS->errorNumber() . ': ' . $MS->errorMessage() . ']' . "\n");
}

exit;

// Now, let's update it
$Card->setName('Keith R. Palmer Jr.');

if ($MS->updateWallet($customerID, $walletID, $Card))
{
	print('Wallet updated!' . "\n");
}
else
{
	print('An error occurred: [' . $MS->errorNumber() . ': ' . $MS->errorMessage() . ']' . "\n");
}

// Fetch it
if ($CreditCard = $MS->getWallet($customerID, $walletID))
{
	print_r($CreditCard);
}
else
{
	print('An error occurred: [' . $MS->errorNumber() . ': ' . $MS->errorMessage() . ']' . "\n");
}

// Now, let's delete it
if ($MS->deleteWallet($customerID, $walletID))
{
	print('Wallet deleted!' . "\n");
}
else
{
	print('An error occurred: [' . $MS->errorNumber() . ': ' . $MS->errorMessage() . ']' . "\n");
}

// Now, re-add it so we can charge/authorize against it
if ($walletID = $MS->addWallet($customerID, $Card))
{
	print('New wallet ID created: ' . $walletID . "\n");
}
else
{
	print('An error occurred: [' . $MS->errorNumber() . ': ' . $MS->errorMessage() . ']' . "\n");
}

// Authorize funds against the wallet
$amount = 1.06;
$salestax = 0.06;				// Optional
$comment = 'Test Comment';		// Optional
$cvv = '349';					// Optional

if ($Transaction = $MS->authorizeWallet($customerID, $walletID, $amount, $salestax, $comment, $cvv))
{
	print('Wallet authorized!' . "\n");
	print_r($Transaction);
}
else
{
	print('An error occurred: [' . $MS->errorNumber() . ': ' . $MS->errorMessage() . ']' . "\n");
}

// Charge funds against the wallet
$amount = 1.06;
$salestax = 0.06;				// Optional
$comment = 'Test Comment';		// Optional
$cvv = '349';					// Optional

if ($Transaction = $MS->chargeWallet($customerID, $walletID, $amount, $salestax, $comment, $cvv))
{
	print('Wallet charged!' . "\n");
	print_r($Transaction);
}
else
{
	print('An error occurred: [' . $MS->errorNumber() . ': ' . $MS->errorMessage() . ']' . "\n");
}

// 
