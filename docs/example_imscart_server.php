<?php

// 

/**
 * Example IMSCart integration server
 * 
 * @package docs
 * @subpackage integrator
 */

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks/');

// 
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

define('QUICKBOOKS_SERVER_INTEGRATOR_OFFSET', 60 * 60 * 24 * 130);

/**
 * 
 */
require_once 'QuickBooks.php';

// 
//$dsn_or_conn = 'mysql://username:password@hostname/database';
$dsn = 'mysql://root:@localhost/imscart';

// 
//$integrator_dsn_or_conn = 'mysql://username:password@hostname/database';
$integrator_dsn = 'mysql://root:@localhost/imscart';

$user = 'imscart';
$pass = 'password';

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
	'currency' => 'USD', 
	'tax_agency' => 'IRS', 
	);

$callback_options = array();

if (!QuickBooks_Utilities::initialized($dsn))
{
	QuickBooks_Utilities::initialize($dsn);
	QuickBooks_Utilities::createUser($dsn, $user, $pass);
}

// 
$Server = new QuickBooks_Server_Integrator_Imscart(
		$dsn, 
		$integrator_dsn, 
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
$Server->handle();

?>