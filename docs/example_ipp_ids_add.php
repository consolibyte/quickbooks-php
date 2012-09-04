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
$password = 'password42';

// Application token 
$token = 'tex3r7hwifx6cci3zk43ibmnd';

// Realm ID
$realmID = 13338393;

// DBID
$dbid = 'be9mh7qd5';

// Create our IPP class
$IPP = new QuickBooks_IPP();

if ($Context = $IPP->authenticate($username, $password, $token))
{
	// DBID
	$IPP->dbid($Context, $dbid);
	
	// Flavor
	$IPP->flavor(QuickBooks_IPP_IDS::FLAVOR_DESKTOP);
	
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
	
	// Create the address
	$Address = new QuickBooks_IPP_Object_Address();
	$Address->setLine1('56 Cowles Road');
	$Address->setCity('Willington');
	$Address->setCountrySubDivisionCode('CT');
	$Address->setPostalCode('06279');
	$Address->setTag('Billing');
	
	// Add the address to the customer
	$Customer->addAddress($Address);
	
	/*
	print_r($Customer->asIDSXML());
	exit;
	*/
	
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
}
