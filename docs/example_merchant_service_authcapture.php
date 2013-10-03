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

// Show errors
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Plain text output
header('Content-Type: text/plain');

// Include the QuickBooks files
require_once '../QuickBooks.php';

// If you want to log requests/responses to a database, you can provide a 
//	database DSN-style connection string here
$dsn = null;
// $dsn = 'mysql://root:@localhost/quickbooks_merchantservice';

// There are two methods of attaching an application to QuickBooks Merchant 
//	Services. Intuit provides a 'Hosted' model, and a 'Desktop' model. The 
//	'Hosted' model provides additional security benefits and is designed for 
//	web applications, while the 'Desktop' model is easier to set up and 
//	designed for desktop applications. 
// 
// Either the 'Hosted' or the 'Desktop' model can be used if you're developing 
//	a web application. 
// 
// If you're using the 'Hosted' model, you'll need to provide the full path to 
//	the key/certificate you/Intuit generates here. Otherwise, you can pass a 
//	null. This file should have the private key you generated concatenated to 
//	the beginning of the file. So the file contents should look something like: 
//  
//	-----BEGIN RSA PRIVATE KEY-----
//	... bla bla bla lots of stuff here ...
//	-----END RSA PRIVATE KEY-----
//	-----BEGIN CERTIFICATE-----
//	... bla bla bla lots of stuff here ...
//	-----END CERTIFICATE-----
// 
// If you're using the 'Hosted' model, you should see the additional 
//	documentation about how to set up your certificate here: 
//		http://wiki.consolibyte.com/wiki/doku.php/quickbooks_qbms_integration
//$path_to_private_key_and_certificate = '/Users/keithpalmerjr/Projects/QuickBooks/QuickBooks/dev/test_qbms.pem';
//$path_to_private_key_and_certificate = '/path/doesnt/exist.pem'; 		// This should trigger an error
//$path_to_private_key_and_certificate = null;							// If you're using the DESKTOP model
$path_to_private_key_and_certificate = null;

// This is your login ID that Intuit assignes you during the application 
//	registration process.
//$application_login = 'test.www.academickeys.com';
$application_login = 'test.foxycart.com';
$application_login = 'qbms.consolibyte.com';

// This is the connection ticket assigned to you during the application 
//	registration process. To conform to Intuit security practices, you are 
//	*required* to store this key *encrypted* and not in plain-text. 
//	
//	The ticket below is provided as an example, you should *not* store your 
//	connection ticket in plain text as shown below. You should store it in your 
//	database or in a separate file, outside of the web server document root, 
//	encrypted with a crypto library such as {@link http://www.php.net/mcrypt}.
//$connection_ticket = 'TGT-152-LWGj1YQUufTAlSW8DK1c6A';
$connection_ticket = 'TGT-145-niiEL2kCFoOTYHvkwBarmg';
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
//$MS->useDebugMode(true);

// Now, let's create a credit card object, and authorize an amount agains the card
$name = 'Keith Palmer';
$number = '5105105105105100';
$expyear = date('Y');
$expmonth = date('m');
$address = '56 Cowles Road';
$postalcode = '06279';
$cvv = null;

// Create the CreditCard object
$Card = new QuickBooks_MerchantService_CreditCard($name, $number, $expyear, $expmonth, $address, $postalcode, $cvv);

// We're going to authorize $295.00
$amount = 295.0;

if ($Transaction = $MS->authorize($Card, $amount))
{
	print('Card authorized!' . "\n");
	print_r($Transaction);	
	
	// 	Every time the MerchantService class returns a $Transaction object to you, 
	// 	you should store the returned $Transaction. You'll need the returned 
	// 	$Transaction object (or at the very least the data contained therein) in 
	// 	order to push these transactions to QuickBooks, to actually capture the 
	// 	funds, to issue a refund, or to issue a void. 
	// 	
	// 	There are several convienence methods to convert the $Transaction object to 
	// 	more storage-friendly formats if you would prefer to use these: 
	
	// Get the transaction as a string which can later be turned back into a transaction object
	$str = $Transaction->serialize(); 
	print('Serialized transaction: ' . $str . "\n\n");
	
	// Now convert it back to a transaction object
	$Transaction = QuickBooks_MerchantService_Transaction::unserialize($str);
	
	if ($Transaction = $MS->capture($Transaction, $amount))
	{
		/*
		print("\n\n");
		print("\n\n");
		print("\n\n");
		print("\n\n");
		print($MS->lastRequest());
		print("\n\n");
		print($MS->lastResponse());
		print("\n\n");
		exit;
		*/

		print('Card captured!' . "\n");
		print_r($Transaction);	
		print("\n\n");
		
		// Let's print that qbXML bit again because it'll have more data now
		$qbxml = $Transaction->toQBXML();
		print('qbXML transaction info: ' . $qbxml . "\n\n");		
	}
	else
	{
		print('An error occured during capture: ' . $MS->errorNumber() . ': ' . $MS->errorMessage() . "\n");
	}
}
else
{
	print('An error occured during authorization: ' . $MS->errorNumber() . ': ' . $MS->errorMessage() . "\n");
}
