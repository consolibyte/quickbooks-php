<?php

/**
 * 
 * 
 * @package QuickBooks
 */

if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

/**
 * 
 */
require_once 'QuickBooks.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
 * What can the front-end do? 
 * 	X Create Web Connector users and modify passwords
 * 	X Query a QuickBooks SQL mirrored database
 * 	X Create the required QuickBooks package SQL schema
 * 	X View/update/add/delete items in the queue
 * 	X Run unit tests on each component of the QuickBooks package
 * 	X Test the SOAP server
 * 	X Parse XML requests/responses
 * 	X Test authentication methods
 * 
 */

// 
$dsn = 'mysql://root:password@localhost/quickbooks';

// 
$frontend = new QuickBooks_Frontend($dsn);
$frontend->handle();


?>