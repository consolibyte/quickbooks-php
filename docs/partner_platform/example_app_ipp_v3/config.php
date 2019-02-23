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
require_once dirname(__FILE__) . '/../../../QuickBooks.php';

// Your application token (Intuit will give you this when you register an Intuit Anywhere app)
$token = '95555248baf11b43fbb944ab97de9134ad85';

// Your OAuth consumer key and secret (Intuit will give you both of these when you register an Intuit app)
// 
// IMPORTANT:
//	To pass your tech review with Intuit, you'll have to AES encrypt these and 
//	store them somewhere safe. 
// 
// The OAuth request/access tokens will be encrypted and stored for you by the 
//	PHP DevKit IntuitAnywhere classes automatically.
// NOTE: OAuth1 is deprecated method. Applications registered after 17th July 2017 should use OAuth2
$oauth_consumer_key = 'qyprdfkqo3bikN2vLrLu4FWHv6GbQp';
$oauth_consumer_secret = 'WDH56afDb1jr0ismQZAwdPuq4oDqpTmrKXc0oORz';

// OAuth2 is method for all applications registered after 17th July 2017.
// You may want to change those Ids
$oauth2_client_id = 'Q0yebRJgPF0R5DqdZVzOpeAe4B1pFgdmBSaFcD0eVLHDMDH7r9';
$oauth2_client_secret = 'OInt0KjDeruNFAnah0kPzkwzmtElo36FvhBUSUv2';

// If you're using DEVELOPMENT TOKENS, you MUST USE SANDBOX MODE!!!  If you're in PRODUCTION, then DO NOT use sandbox.
$sandbox = true;     // When you're using development tokens
//$sandbox = false;    // When you're using production tokens

// This is the URL of your OAuth auth handler page
$quickbooks_oauth_url = 'http://quickbooks.v3.com:8888/quickbooks-php/docs/partner_platform/example_app_ipp_v3/oauth.php';

// This is the URL to forward the user to after they have connected to IPP/IDS via OAuth
$quickbooks_success_url = 'http://quickbooks.v3.com:8888/quickbooks-php/docs/partner_platform/example_app_ipp_v3/success.php';

// This is the menu URL script 
$quickbooks_menu_url = 'http://quickbooks.v3.com:8888/quickbooks-php/docs/partner_platform/example_app_ipp_v3/menu.php';

// This is a database connection string that will be used to store the OAuth credentials 
// $dsn = 'pgsql://username:password@hostname/database';
// $dsn = 'mysql://username:password@hostname/database';
$dsn = 'mysqli://quickbooks:password@localhost/quickbooks_php';

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
$oauth_version = QuickBooks_IPP::AUTHMODE_OAUTH;
if (empty($oauth2_client_id))
{
    $IntuitAnywhere = new QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret, $quickbooks_oauth_url, $quickbooks_success_url);
}
else
{
    $oauth_version = QuickBooks_IPP::AUTHMODE_OAUTH2;

    $token = new QuickBooks_IPP_OAuth2($oauth2_client_id, $oauth2_client_secret);
    $helper = new QuickBooks_IPP_OAuth2Helper($token);

    $IntuitAnywhere = new QuickBooks_IPP_IntuitAnywhereOAuth2($dsn, $encryption_key, $oauth2_client_id, $oauth2_client_secret, $quickbooks_oauth_url, $quickbooks_success_url);
    // Refresh token if expired
    $IntuitAnywhere->refresh_expired_token($the_username, $the_tenant);

    if ($IntuitAnywhere->errorNumber())
    {
        echo 'Unable to refresh access token: ' . $IntuitAnywhere->errorMessage();
    }

    $quickbooks_oauth_url = $helper->getAuthorizationURL($quickbooks_oauth_url);
}

$quickbooks_is_connected = false;

// Are they connected to QuickBooks right now? 
if ($IntuitAnywhere->check($the_username, $the_tenant))
{
	// Set up the IPP instance
	$IPP = new QuickBooks_IPP($dsn);

	// Get our OAuth credentials from the database
	$creds = $IntuitAnywhere->load($the_username, $the_tenant);

	// Tell the framework to load some data from the OAuth store
	$IPP->authMode(
        $oauth_version,
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

	if (!empty($quickbooks_CompanyInfo))
    {
        // Yes, they are
        $quickbooks_is_connected = true;
    }
}