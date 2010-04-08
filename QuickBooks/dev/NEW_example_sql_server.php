<?php
set_time_limit(0);
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks');

require_once 'QuickBooks.php';

if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

$username = 'quickbooks';
$password = 'password';

error_reporting(E_ALL);
ini_set('display_errors', 1);

//rint(wtaf');

$dsn = 'mysql://root:s4p3rs3c4r3@localhost/quickbooksWIP2';

if (!QuickBooks_Utilities::initialized($dsn))
{
	header('Content-Type: text/plain');
	
	$driver_options = array(
		);
		
	$init_options = array(
		'quickbooks_sql_enabled' => true, 
		);
		
	QuickBooks_Utilities::initialize($dsn, $driver_options, $init_options);
	
	QuickBooks_Utilities::createUser($dsn, $username, $password);
	
	exit;
}

$mode = QUICKBOOKS_SERVER_SQL_MODE_READONLY;
//$mode = QUICKBOOKS_SERVER_SQL_MODE_WRITEONLY;
//$mode = QUICKBOOKS_SERVER_SQL_MODE_READWRITE;


//Delete Modes -- Remove or Flag?
//$deleteMode = QUICKBOOKS_SERVER_SQL_ON_DELETE_FLAG;
$deleteMode = QUICKBOOKS_SERVER_SQL_ON_DELETE_REMOVE;



// $dsn_or_conn, $how_often, $mode, $conflicts, $users = null, 
//	$map = array(), $onerror = array(), $hooks = array(), $log_level, $soap = QUICKBOOKS_SOAPSERVER_BUILTIN, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array()
$server = new QuickBooks_Server_SQL(
	$dsn, 
	'1 minute', 
	$mode, 
	$deleteMode,
	QUICKBOOKS_SERVER_SQL_CONFLICT_NEWER, 
	$username, 
	array(), 
	array(), 
	array(), 
	QUICKBOOKS_LOG_DEVELOP, 
	QUICKBOOKS_SOAPSERVER_PHP, 
	QUICKBOOKS_WSDL);
$server->handle(true, true);


?>
