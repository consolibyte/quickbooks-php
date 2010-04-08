<?php

/**
 * Example FoxyCart integration server
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

/**
 * 
 */
require_once dirname(__FILE__) . '/../QuickBooks.php';

// 
$dsn_or_conn = 'mysql://root:root@localhost/quickbooks_foxycart';

// 
$integrator_dsn_or_conn = 'mysql://root:root@localhost/quickbooks_foxycart';

//$user = 'quickbooks';
//$pass = 'password';

if (empty($_SERVER['QUERY_STRING']))
{
	die('Invalid request QUERY_STRING.');
}

$user = $_SERVER['QUERY_STRING'];

$alert = 'you@yourdomain.com';

$map = array();
$onerror = array();

$hooks = array(
	QUICKBOOKS_SERVER_INTEGRATOR_HOOK_INTEGRATEORDER => 'this_hook_gets_called_when_orders_get_sent_to_quickbooks',
	
	QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTORDER => 'this_hook_gets_called_when_orders_are_received_from_foxycart', 
	QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTCUSTOMER => 'this_hook_gets_called_when_customers_are_received_from_foxycart', 
	QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTORDERLINE => 'this_hook_gets_called_when_orderlines_are_received_from_foxycart', 
	);

function this_hook_gets_called_when_orders_get_sent_to_quickbooks($requestID, $user, $hook, &$err, $hook_data, $callback_config)
{
	$Driver = QuickBooks_Driver_Singleton::getInstance();
	$Driver->log('Got in (1): ' . print_r($hook_data, true));
	
	$SalesReceipt = $hook_data['Order'];
	
	// Let's go through the line items
	foreach ($SalesReceipt->getSalesReceiptLines() as $SalesReceiptLine)
	{
		//$Driver->log('  Line item: ' . print_r($SalesReceiptLine, true));
	}
	
	return true;
}

function this_hook_gets_called_when_orders_are_received_from_foxycart($requestID, $user, $hook, &$err, $hook_data, $callback_config)
{
	$Driver = QuickBooks_Driver_Singleton::getInstance();
	$Driver->log('Got in (2): ' . print_r($hook_data, true));	
}

function this_hook_gets_called_when_customers_are_received_from_foxycart($requestID, $user, $hook, &$err, $hook_data, $callback_config)
{
	$Driver = QuickBooks_Driver_Singleton::getInstance();
	$Driver->log('Got in (3): ' . print_r($hook_data, true));	
}

function this_hook_gets_called_when_orderlines_are_received_from_foxycart($requestID, $user, $hook, &$err, $hook_data, $callback_config)
{
	$Driver = QuickBooks_Driver_Singleton::getInstance();
	$Driver->log('Got in (4): ' . print_r($hook_data, true));	
}


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
	//'foxycart_secret_key' => 'pa#f0.Lm1@3nqQ!_zl/EwAp\$Y:kS;%gQ=Ui', 
	//'debug_datetime' => '2008-12-01 12:00:00', 		// For debugging *only*! Make sure you comment this out!
	
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
	//QuickBooks_Utilities::createUser($dsn_or_conn, $user, $pass);
}

//QuickBooks_Utilities::createUser($dsn_or_conn, 'test3.foxycart.com', 'g98nbIg3902ibnb');

// 
$Server = new QuickBooks_Server_Integrator_FoxyCart(
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
