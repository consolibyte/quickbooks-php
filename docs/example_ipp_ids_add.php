<?php

/**
 * Example of adding new objects to QuickBooks via IPP/IDS
 * 
 * @author Keith Palmer <keith@ConsoliBYTE.com>
 * 
 * @package QuickBooks
 * @subpackage docs
 */

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

// Credentials
$username = 'keith@consolibyte.com';
$password = 'password42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';
$realmID = 173642438;

// Create our IPP class
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);
$IPP->application($Context, 'be9mh7qd5');

// If you set this to TRUE, it will make the ->add() method return raw XML responses
//$IPP->useIDSParser(false);

// We use our Customer service to operate on customers within IDS/QuickBooks
$Service = new QuickBooks_IPP_Service_Customer(); 
 
// Create our customer object
$Customer = new QuickBooks_IPP_Object_Customer();

// Set the name of the customer (a UNIQUE PRIMARY KEY in QuickBooks)
$Customer->setName('Brand New Customer #' . mt_rand(0, 100));

// Set the first name
$Customer->setGivenName('Keith');

// Set the last name
$Customer->setFamilyName('Palmer');

// Now, let's add the customer to QuickBooks
if ($ID = $Service->add($Context, $realmID, $Customer))
{
	// Yeah, we added it!
	print('Customer added with ID #' . $ID . "\n");
}
else
{
	// Oh no, something went wrong!
	print('An error occurred {' . $Service->errorNumber() . ': ' . $Service->errorMessage() . '}' . "\n");
}
