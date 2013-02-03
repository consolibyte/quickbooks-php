<?php

/**
 * Example of OAuth testing to see if a specific set of OAuth credentials are still valid (e.g. the QuickBooks company file is still connected)
 * 
 * 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Turn on some error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Require the QuickBooks library
 */
require_once dirname(__FILE__) . '/../QuickBooks.php';

/**
 * Require some IPP/OAuth configuration data
 */
require_once dirname(__FILE__) . '/example_ipp_config.php';

// Instantiate our Intuit Anywhere auth handler 
// 
// The parameters passed to the constructor are:
//	$dsn					
//	$oauth_consumer_key		Intuit will give this to you when you create a new Intuit Anywhere application at AppCenter.Intuit.com
//	$oauth_consumer_secret	Intuit will give this to you too
//	$this_url				This is the full URL (e.g. http://path/to/this/file.php) of THIS SCRIPT
//	$that_url				After the user authenticates, they will be forwarded to this URL
// 
$IntuitAnywhere = new QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret, $this_url, $that_url);

// Test if the OAuth tokens we have on file are still valid
if ($IntuitAnywhere->test($the_username, $the_tenant))
{
	print('Connected with valid OAuth tokens!');
}
else
{
	print('These tokens (if they exist) don\'t seem to work...');
}