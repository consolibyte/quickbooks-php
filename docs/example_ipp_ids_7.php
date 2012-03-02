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
	
	$InvoiceService = new QuickBooks_IPP_Service_Invoice();
	
	// Unfortunately, QuickBooks Online and QuickBooks desktop don't use the 
	//	same query syntax (in this case, filtering invoices by a specific 
	//	customer)
	if ($creds['qb_flavor'] == QuickBooks_IPP_IDS::FLAVOR_ONLINE)
	{
		$query = array( 'Filter' => 'CustomerId :EQUALS: 1' );
	}
	else
	{
		$query = '
			<ContactIdSet>
				<Id>44617999</Id>
			</ContactIdSet>';		
	}
	
	$page = 1;
	$limit = 25;
	$list = $InvoiceService->findAll($Context, $realm, $query, $page, $limit);
	
	foreach ($list as $Invoice)
	{
		print($Invoice->getXPath('Header/CustomerId') . ' (customer id) => # ' . $Invoice->getXPath('Header/DocNumber') . "\n");
	}
	
	//print_r($list);
	
	/*
	print("\n\n");
	print($InvoiceService->lastRequest());
	print("\n\n");
	print($InvoiceService->lastResponse());
	print("\n\n");
	*/
}
else
{
	die('Unable to load a context...?');
}

