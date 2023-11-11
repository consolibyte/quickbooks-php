<?php

/**
 * Intuit Partner Platform configuration variables
 * 
 * See the scripts that use these variables for more details. 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Turn on some error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require the library code
require_once dirname(__FILE__) . '/../../QuickBooks.php';

// Your application token (Intuit will give you this when you register an Intuit Anywhere app)
$token = '0bd99664b015ab48e9ba89bb54cadecac6c7';

// Your OAuth consumer key and secret (Intuit will give you both of these when you register an Intuit app)
// 
// IMPORTANT:
//	To pass your tech review with Intuit, you'll have to AES encrypt these and 
//	store them somewhere safe. 
// 
// The OAuth request/access tokens will be encrypted and stored for you by the 
//	PHP DevKit IntuitAnywhere classes automatically. 
$oauth_consumer_key = 'qyprdeoRkQRkBz0lSU0fKEY4LOISsw';
$oauth_consumer_secret = 'qIphqEn5s0nOGw8ekFshD6aa16dTVL6YgjFVO8mF';

// If you're using DEVELOPMENT TOKENS, you MUST USE SANDBOX MODE!!!  If you're in PRODUCTION, then DO NOT use sandbox.
$sandbox = true;     // When you're using development tokens
//$sandbox = false;    // When you're using production tokens

// This is the URL of your OAuth auth handler page
$quickbooks_oauth_url = 'http://quickbooks.v3.com:8888/quickbooks-php/docs/payments/oauth.php';

// This is the URL to forward the user to after they have connected to IPP/IDS via OAuth
$quickbooks_success_url = 'http://quickbooks.v3.com:8888/quickbooks-php/docs/payments/success.php';

// This is the menu URL script 
$quickbooks_menu_url = 'http://quickbooks.v3.com:8888/quickbooks-php/docs/payments/menu.php';

// This is a database connection string that will be used to store the OAuth credentials 
// $dsn = 'pgsql://username:password@hostname/database';
// $dsn = 'mysql://username:password@hostname/database';
$dsn = 'mysqli://root:root@localhost/example_app_ipp_v3';		

// You should set this to an encryption key specific to your app
$encryption_key = 'bcde1234';

// Do not change this unless you really know what you're doing!!!  99% of apps will not require a change to this.
$the_username = 'DO_NOT_CHANGE_ME';

// The tenant that user is accessing within your own app
$the_tenant = 12345;

// Initialize the database tables for storing OAuth information
if (!QuickBooks_Utilities::initialized($dsn))
{
	// Initialize creates the neccessary database schema for queueing up requests and logging
	QuickBooks_Utilities::initialize($dsn);
}

// Instantiate our Intuit Anywhere auth handler 
// 
// The parameters passed to the constructor are:
//	$dsn					
//	$oauth_consumer_key		Intuit will give this to you when you create a new Intuit Anywhere application at AppCenter.Intuit.com
//	$oauth_consumer_secret	Intuit will give this to you too
//	$this_url				This is the full URL (e.g. http://path/to/this/file.php) of THIS SCRIPT
//	$that_url				After the user authenticates, they will be forwarded to this URL
// 
$IntuitAnywhere = new QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret, $quickbooks_oauth_url, $quickbooks_success_url);

// Are they connected to QuickBooks right now? 
if ($IntuitAnywhere->check($the_username, $the_tenant) and 
	$IntuitAnywhere->test($the_username, $the_tenant))
{
	// Yes, they are 
	$quickbooks_is_connected = true;

	// Set up the IPP instance
	$IPP = new QuickBooks_IPP($dsn);

	// Get our OAuth credentials from the database
	$creds = $IntuitAnywhere->load($the_username, $the_tenant);

	// Tell the framework to load some data from the OAuth store
	$IPP->authMode(
		QuickBooks_IPP::AUTHMODE_OAUTH, 
		$the_username, 
		$creds);

	if ($sandbox)
	{
		// Turn on sandbox mode/URLs 
		$IPP->sandbox(true);
	}

	// Print the credentials we're using
	//print_r($creds);

	// This is our current realm
	$realm = $creds['qb_realm'];

	// Load the OAuth information from the database
	$Context = $IPP->context();

	// Get some company info
	$CompanyInfoService = new QuickBooks_IPP_Service_CompanyInfo();
	$quickbooks_CompanyInfo = $CompanyInfoService->get($Context, $realm);
}
else
{
	// No, they are not
	$quickbooks_is_connected = false;
}