<?php

/**
 * Intuit Partner Platform configuration variables
 * 
 * See the scripts that use these variables for more details. 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Your OAuth token (Intuit will give you this when you register an Intuit Anywhere app)
$token = 'a19ded85b43f6b4168b94fcb63a519376019';

// Your OAuth consumer key and secret (Intuit will give you both of these when you register an Intuit app)
// 
// IMPORTANT:
//	To pass your tech review with Intuit, you'll have to AES encrypt these and 
//	store them somewhere safe. 
// 
// The OAuth request/access tokens will be encrypted and stored for you by the 
//	PHP DevKit IntuitAnywhere classes automatically. 
$oauth_consumer_key = 'qyprdbbHtE5gH7XXiwRXHqSmRfaeXY';
$oauth_consumer_secret = 'jSNY9vWNUQyu3vB4L4EvENWIAgMdgBizCukW9LdP';

// This is the URL of your OAuth auth handler page
$this_url = 'http://localhost:8888/intuitanywheretest/oauth.php';

// This is the URL to forward the user to after they have connected to IPP/IDS via OAuth
$that_url = 'http://localhost:8888/intuitanywheretest/data.php';

// This is a database connection string that will be used to store the OAuth credentials 
// $dsn = 'pgsql://username:password@hostname/database';
// $dsn = 'mysql://username:password@hostname/database';
$dsn = 'mysql://root:root@localhost/quickbooks';		

// You should set this to an encryption key specific to your app
$encryption_key = 'abcd1234';

// The user that's logged in
$the_username = 'your_app_username_here';

// The tenant that user is accessing within your own app
$the_tenant = 12345;

// Initialize the database tables for storing OAuth information
if (!QuickBooks_Utilities::initialized($dsn))
{
	// Initialize creates the neccessary database schema for queueing up requests and logging
	QuickBooks_Utilities::initialize($dsn);
}	
