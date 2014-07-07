<?php

/**
 * Example of OAuth authentication for an Intuit Anywhere application
 * 
 * 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

/**
 * Require the QuickBooks library
 */
require_once dirname(__FILE__) . '/../../../QuickBooks.php';

/**
 * Require some IPP/OAuth configuration data
 */
require_once dirname(__FILE__) . '/config.php';

// Try to handle the OAuth request 
if ($IntuitAnywhere->handle($the_username, $the_tenant))
{
	; // The user has been connected, and will be redirected to $that_url automatically. 
}
else
{
	// If this happens, something went wrong with the OAuth handshake
	die('Oh no, something bad happened: ' . $IntuitAnywhere->errorNumber() . ': ' . $IntuitAnywhere->errorMessage());
}


