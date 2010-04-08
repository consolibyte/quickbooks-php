<?php

/**
 * Example osCommerce integration server
 * 
 * @package docs
 * @subpackage integrator
 */

// 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// 
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/keithpalmerjr/Projects/QuickBooks/');

// 
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

/**
 * 
 */
require_once 'QuickBooks.php';

// 
$dsn_or_conn = 'mysql://root:root@localhost/quickbooks_oscommerce';

// 
$integrator_dsn_or_conn = 'mysql://root:root@localhost/quickbooks_oscommerce';

$user = 'oscommerce';
$pass = 'password';

$alert = 'keith@ConsoliBYTE.com';

$map = array();
$onerror = array();
$hooks = array();
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
	//'debug_datetime' => '2008-12-01 12:00:00', 		// For debugging *only*! Make sure you comment this out!
	
	'product_defaults' => array(
		'SalesOrPurchase_AccountName' => 'Other Income', 
		), 
		
	'push_orders_as' => QUICKBOOKS_OBJECT_SALESRECEIPT, 
	);

$callback_options = array();

if (!QuickBooks_Utilities::initialized($dsn_or_conn))
{
	QuickBooks_Utilities::initialize($dsn_or_conn);
	QuickBooks_Utilities::createUser($dsn_or_conn, $user, $pass);
}

//QuickBooks_Utilities::createUser($dsn_or_conn, $user, $pass);

// 
$Server = new QuickBooks_Server_Integrator_OSCommerce(
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
