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
	// Set the DBID
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
	
	$Customer = new QuickBooks_IPP_Object_Customer();
	$Customer->setName('Willy Wonka #' . mt_rand(0, 1000));
	$Customer->setGivenName('Willy');
	$Customer->setFamilyName('Wonka');
	
	$resp = $CustomerService->add($Context, $realm, $Customer);
	
	print('New customer is [' . $resp . ']' . "\n\n");
	
	print("\n\n\n\n");
	print('Request [' . $IPP->lastRequest() . ']');
	print("\n\n\n\n");
	print('Response [' . $IPP->lastResponse() . ']');
	print("\n\n\n\n");
}
else
{
	die('Unable to load a context...?');
}

