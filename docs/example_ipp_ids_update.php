<?php

// Turn on some error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');

/**
 * Require the QuickBooks library
 */
require_once dirname(__FILE__) . '/../QuickBooks.php';

/**
 * Require some IPP/OAuth configuration data
 */
require_once dirname(__FILE__) . '/example_ipp_config.php';


// Set up the IPP instance
$IPP = new QuickBooks_IPP($dsn);

// Set up our IntuitAnywhere instance
$IntuitAnywhere = new QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret);

// Get our OAuth credentials from the database
$creds = $IntuitAnywhere->load($the_username, $the_tenant);

// Tell the framework to load some data from the OAuth store
$IPP->authMode(
	QuickBooks_IPP::AUTHMODE_OAUTH, 
	$the_username, 
	$creds);

// Print the credentials we're using
print_r($creds);

// This is our current realm
$realm = $creds['qb_realm'];

// Load the OAuth information from the database
if ($Context = $IPP->context())
{
	// Set the DBID (this doesn't matter for Intuit Anywhere applications)
	$IPP->dbid($Context, 'something');
	
	// Set the IPP flavor
	$IPP->flavor($creds['qb_flavor']);
	
	// Get the base URL if it's QBO
	if ($creds['qb_flavor'] == QuickBooks_IPP_IDS::FLAVOR_ONLINE)
	{
		$IPP->baseURL($IPP->getBaseURL($Context, $realm));
	}
	
	print('Base URL is [' . $IPP->baseURL() . ']' . "\n\n");
	
	$CustomerService = new QuickBooks_IPP_Service_Customer();
	
	$query = null;
	$page = 1;
	$limit = 25;
	$list = $CustomerService->findAll($Context, $realm, $query, $page, $limit);
	
	//die($CustomerService->lastResponse());
	
	foreach ($list as $Customer)
	{
		//print_r($Customer);
		print_r('#' . $Customer->getId() . ' "' . $Customer->getName() . '" with Phone [' . $Customer->getXPath('Phone/FreeFormNumber') . ']' . "\n\n");
		
		// Update the name
		$Customer->setName('Keith Palmer ' . mt_rand(0, 100));
		
		// Update the phone number
		$Phone = new QuickBooks_IPP_Object_Phone();
		$Phone->setFreeFormNumber('203-687-' . mt_rand(1000, 9999));
		$Customer->setPhone($Phone);
		
		// QuickBooks Online doesn't support custom fields right now, so we have to remove those
		$Customer->remove('CustomField');
		
		// Update the object
		if ($CustomerService->update($Context, $realm, $Customer->getId(), $Customer))
		{
			
			
			print('Updated successfully!');
		}
		else
		{
			print('Error [' . $CustomerService->errorCode() . '] [' . $CustomerService->errorText() . '] [' . $CustomerService->errorDetail() . ']');
			
			print("\n\n\n");
			print($CustomerService->lastRequest());			
			print("\n\n\n");
			print($CustomerService->lastResponse());
			exit;
		}
		
		// Only update one customer... 
		break;
	}
	
	//print_r($list);
	
	/*
	print("\n\n");
	print($CustomerService->lastRequest());
	print("\n\n");
	print($CustomerService->lastResponse());
	print("\n\n");
	*/
}
else
{
	die('Unable to load a context...?');
}

