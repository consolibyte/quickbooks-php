<?php

if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/home/library_php');

require_once 'QuickBooks.php';

$dsn = 'mysql://root:Odnotnev9@localhost/quickbooks';

$map = array();
$onerror = array();
$hooks = array();
$log_level = QUICKBOOKS_LOG_DEVELOP;
$soap = QUICKBOOKS_SOAPSERVER_BUILTIN;

$Server = new QuickBooks_Server_API($dsn, $map, $onerror, $hooks, $log_level, $soap);
$Server->handle();

/**
 * 
 */
function _quickbooks_customer_add_callback($method, $action, $ID, $err, $qbxml, $qbobject, $qbres)
{
	if (is_object($qbobject))
	{
		$fp = fopen('/home/kpalmer/logs/customer_add.log', 'w+');
		fwrite($fp, var_export($qbobject, true));
		fclose($fp);
		
		return true;
	}
	
	return false;
}

function _quickbooks_customer_get_callback($method, $action, $ID, $err, $qbxml, $qbiterator, $qbres)
{
	if (is_object($qbiterator))
	{
		$fp = fopen('/home/kpalmer/logs/customer_get.log', 'w+');
		fwrite($fp, var_export($qbiterator, true));
		fclose($fp);
		
		return true;
	}
	
	return false;
}

//QuickBooks_Utilities::createUser($dsn, 'api', 'password');

?>