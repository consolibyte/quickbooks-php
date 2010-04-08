<?php

/**
 * Example WHMCS integration server
 * 
 * @package docs
 * @subpackage integrator
 */

// 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// 
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

if (empty($_SERVER['QUERY_STRING']))
{
	die('Invalid ?query QUERY_STRING!');
}

/**
 * 
 */
require_once dirname(__FILE__) . '/../QuickBooks.php';

// 
$dsn_or_conn = 'mysql://root:root@localhost/quickbooks_whmcs';

// 
$integrator_dsn_or_conn = $dsn_or_conn;

//$user = 'quickbooks';

$user = $_SERVER['QUERY_STRING'];
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
$source_options = array();

// 
$integrator_options = array(
	'product_defaults' => array(
		'SalesOrPurchase_AccountName' => 'Other Income', 
		), 
	'push_orders_as' => QUICKBOOKS_OBJECT_SALESRECEIPT, 
	);

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
$Server = new QuickBooks_Server_Integrator_Whmcs(
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
$Server->handle(true, true);
