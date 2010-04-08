<?php

/**
 * Example FoxyCart integration with QuickBooks Online Edition
 * 
 * @package docs
 * @subpackage integrator
 */

// 
header('Content-Type: text/plain');

// 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// 
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

/**
 * 
 */
require_once dirname(__FILE__) . '/../QuickBooks.php';

// 
$dsn_or_conn = 'mysql://root:root@localhost/quickbooks_foxycart_onlineedition';

// 
$integrator_dsn_or_conn = 'mysql://root:root@localhost/quickbooks_foxycart_onlineedition';

$user = 'test.consolibyte.com';
$pass = 'password';

$alert = 'you@yourdomain.com';

$map = array();
$onerror = array();

$hooks = array(
	);

$log_level = QUICKBOOKS_LOG_DEVELOP;
$soap = QUICKBOOKS_SOAPSERVER_BUILTIN;
$wsdl = QUICKBOOKS_WSDL;
$soap_options = array();
$handler_options = array(); 
$driver_options = array();
$api_options = array();

/*
$source_options = array(
	
	'connection_ticket' => 'TGT-47-1sRm2nXMVfm$n8hb2MZfVQ', 
	'application_login' => 'test.www.academickeys.com', 
	'application_id' => '134476472', 
	
	'override_session_ticket' => 'V1-184-WvkfDlWiNT9HPJGNznMNvA:134864687', 
	);
*/

// 
$source_options = array(
	'override_session_ticket' => 'V1-184-jr9BhCz4oUuwaStKfRUR_w:134864687', 
	);

// 
$integrator_options = array();

$callback_options = array();

if (!QuickBooks_Utilities::initialized($dsn_or_conn))
{
	$driver_options = array(
		);
	
	// This turns on the 'integrator' portions of the framework	
	$init_options = array(
		'quickbooks_integrator_enabled' => true, 
		);
	
	QuickBooks_Utilities::initialize($dsn_or_conn, $driver_options, $init_options);
	QuickBooks_Utilities::createUser($dsn_or_conn, $user, $pass);
}

// 
$Runnable = new QuickBooks_Runnable_Integrator_FoxyCart(
		$dsn_or_conn, 
		$integrator_dsn_or_conn, 
		$alert, 
		$user, 
		$map,
		$onerror, 
		$hooks, 
		$log_level, 
		$soap,
		$wsdl, 
		$soap_options, 
		$handler_options, 
		$driver_options, 
		$api_options, 
		$source_options, 
		$integrator_options, 
		$callback_options);
		
//$Runnable->useDebugMode(true);		
		
$Runnable->run();

