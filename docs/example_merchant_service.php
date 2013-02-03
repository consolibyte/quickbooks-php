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
$MS->useDebugMode(true);

/*
There are several methods available in the QuickBooks_MerchantService class. 
The most common methods are described below: 

 - authorize() 
    This authorizes a given amount against the a credit card. It is important 
    to note that this *does not* actually charge the credit card, it just 
    "reserves" the amount on the credit card and guarentees that if you do a 
    capture() on the same credit card within X days, the funds will be 
    available. 
    
    Authorizations are used in situations where you want to ensure the money 
    will be availble, but not actually charge the card yet. For instance, if 
    you have an online shopping cart, you should authorize() the credit card 
    when the customer checks out. However, because you might not have the item 
    in stock, or there might be other problems with the order, you don't want 
    to actually charge the card yet. Once the order is all ready to ship and 
    you've made sure there's no problems with it, you should issue a capture() 
   	using the returned transaction information from the authorize() to actually 
   	charge the credit card. 
    
 - capture()   
    
 - charge()
 
 - void()
 
 - refund()
 
 - voidOrRefund() 
 
 - openBatch()
 
 - closeBatch()

*/

/**
 * There are a number of test credit card numbers you can use while testing
 * 
 * Master Card 			5105105105105100
 * Master Card 			5555555555554444
 * VISA 				4222222222222
 * VISA 				4111111111111111
 * VISA 				4012888888881881
 * American Express 	378282246310005
 * American Express		371449635398431
 * Amex Corporate 		378734493671000
 * Diners Club 			38520000023237
 * Diners Club 			30569309025904
 * Discover 			6011111111111117
 * Discover 			6011000990139424
 */

// Now, let's create a credit card object, and authorize an amount agains the card
$name = 'Keith Palmer';
$number = '5105105105105100';
$expyear = date('Y');
$expmonth = date('m');
$address = '56 Cowles Road';
$postalcode = '06279';
$cvv = null;

/**
 * There are also some test configurations you can use to simulate certain 
 * errors occuring. You pass these test configuration constants in as the $name 
 * parameter to the credit card to trigger various errors/warnings. 
 */
// $name = QuickBooks_MerchantService::TEST_AVSZIPCVVFAIL;		// Simulate a sucessful transaction that failed all AVS and CVV checks, but was still processed (i.e. your gateway is set up to accept everything)
// $name = QuickBooks_MerchantService::TEST_COMMUNICATIONERROR;	// Simulate a general communication error

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
	
	// ... maybe you'd rather convert it to an array? 
	$arr = $Transaction->toArray();
	print('Array transaction: '); 
	print_r($arr);
	print("\n\n");
	
	// ... and back again?
	$Transaction = QuickBooks_MerchantService_Transaction::fromArray($arr);
	
	// ... or an XML document?
	$xml = $Transaction->toXML();
	print('XML transaction: ' . $xml . "\n\n");
	
	// ... and back again? 
	$Transaction = QuickBooks_MerchantService_Transaction::fromXML($xml);
	
	// How about XML that can be used in a qbXML SalesReceiptAdd request?
	$qbxml = $Transaction->toQBXML();
	print('qbXML transaction info: ' . $qbxml . "\n\n");
	
	// Now that that card has been authorized, let's actually capture the funds. 
	// 
	// You can just pass in the transaction if you want to capture for the same 
	// amount as the authorization. Alternatively, you can pass in a different 
	// amount *less than* the authorization amount to only capture a portion of 
	// the authorization. 
	// 	
	// If you want to capture more than the authorization was for, use charge(). 
	
	// Only capture $50.00
	// $amount = 50.0;
	
	if ($Transaction = $MS->capture($Transaction, $amount))
	{
		print('Card captured!' . "\n");
		print_r($Transaction);	
		
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

exit;



// If you didn't want to 
if ($Transaction = $MS->charge($Card, $amount))
{
	print('Card charged!' . "\n");
	print_r($Transaction);
	
	print('Transaction array: ' . "\n");
	print_r($Transaction->toArray());
	
	print("\n");
}
else
{
	print('An error occured during charge: ' . $MS->errorNumber() . ': ' . $MS->errorMessage() . "\n");
}



// We can issue refunds too... 
if ($Transaction = $MS->refund($Card, $amount))
{
	print('Card refunded $' . $amount . ' dollars!' . "\n");
	print_r($Transaction);
}
else
{
	print('An error occured during refund: ' . $MS->errorNumber() . ': ' . $MS->errorMessage() . "\n");
}

/*
Let's trigger an error, just so we can see how to handle it. We can trigger 

*/

