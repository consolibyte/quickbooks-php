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


// For OAuth2 (all new application, and what you should be migrating to)
require_once dirname(__FILE__) . '/config_oauthv2.php';

// For old/legacy applications
//require_once dirname(__FILE__) . '/config_oauthv1.php';

// You can define your own OAuth state if you want
//   (useful for associating the initial OAuth request with the response you get back)
$oauth_state = md5(microtime(true));

// Try to handle the OAuth request
if ($IntuitAnywhere->handle($the_tenant, $oauth_state))
{
	; // The user has been connected, and will be redirected to $that_url automatically.
}
else
{
	// If this happens, something went wrong with the OAuth handshake
	die('Oh no, something bad happened: ' . $IntuitAnywhere->errorNumber() . ': ' . $IntuitAnywhere->errorMessage());
}
