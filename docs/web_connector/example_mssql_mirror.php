<?php

/**
 * Example of mirroring QuickBooks data to a Microsoft SQL Server database
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package Documentation
 */

// 
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks');

/**
 * QuickBooks framework
 */
require_once 'QuickBooks.php';

if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

$username = 'quickbooks';
$password = 'password';

// I always program in E_STRICT error mode... 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// The DSN-style connection string to the Microsoft SQL Server
$dsn = 'mssql://kpalmer:password@192.168.18.128/test';

// If the database has not yet been initialized, we need to initialize it 
if (!QuickBooks_Utilities::initialized($dsn))
{
	header('Content-Type: text/plain');
	
	// It takes a really long time to build the schema... 
	set_time_limit(0);
	
	$driver_options = array(
		);
		
	$init_options = array(
		'quickbooks_sql_enabled' => true, 
		//'quickbooks_sql_debug' => true, 
		);
		
	QuickBooks_Utilities::initialize($dsn, $driver_options, $init_options);
	QuickBooks_Utilities::createUser($dsn, $username, $password);
	
	exit;
}

// What mode do we want to run the mirror in? 
$mode = QUICKBOOKS_SERVER_SQL_MODE_READONLY;		// Read from QuickBooks only (no data will be pushed back to QuickBooks)
//$mode = QUICKBOOKS_SERVER_SQL_MODE_WRITEONLY;		// Write to QuickBooks only (no data will be copied into the SQL database)
//$mode = QUICKBOOKS_SERVER_SQL_MODE_READWRITE;		// Keep both QuickBooks and the database in sync, reading and writing changes back and forth)

// What should we do if a conflict is found? (a record has been changed by another user or process that we're trying to update)
$conflicts = QUICKBOOKS_SERVER_SQL_CONFLICT_LOG;

// What should we do with records deleted from QuickBooks? 
$delete = QUICKBOOKS_SERVER_SQL_DELETE_REMOVE;		// Delete the record from the database too
//$delete = QUICKBOOKS_SERVER_SQL_DELETE_FLAG; 		// Just flag it as deleted

// Hooks (optional stuff)
//$hook_obj = new MyHookClass2('Keith Palmer');

$hooks = array(
	// QUICKBOOKS_SQL_HOOK_SQL_INSERT => 'my_function_name_for_inserts', 
	//QUICKBOOKS_SQL_HOOK_SQL_INSERT => 'MyHookClass::myMethod',
	// QUICKBOOKS_SQL_HOOK_SQL_UPDATE => 'my_function_name_for_updates',
	/*
	QUICKBOOKS_SERVER_HOOK_PREHANDLE => array(
		'my_prehandle_function',
		array( $hook_obj, 'myMethod' ),
		),
	*/
	);

/*
class MyHookClass
{
	static public function myMethod($requestID, $user, $hook, &$err, $hook_data, $callback_config)
	{
		// do something here...
		return true;
	}
}

function my_prehandle_function($requestID, $user, $hook, &$err, $hook_data, $callback_config)
{
	//print('here we are!');
	return true;
}

class MyHookClass2
{
	protected $_var;
	
	public function __construct($var)
	{
		$this->_var = $var;
	}
	
	public function myMethod($requestID, $user, $hook, &$err, $hook_data, $callback_config)
	{
		//print('variable equals: ' . $this->_var);
		return true;
	}
}
*/

// 
$soap_options = array();

// 
$handler_options = array();

// 
$driver_options = array();

// 
$sql_options = array(
	'only_query' => array( 
		QUICKBOOKS_OBJECT_INVOICE, 
		QUICKBOOKS_OBJECT_CUSTOMER, 
		QUICKBOOKS_OBJECT_RECEIVEPAYMENT, 
		QUICKBOOKS_OBJECT_EMPLOYEE, 
		QUICKBOOKS_OBJECT_PAYROLLITEMWAGE, 
		QUICKBOOKS_OBJECT_PAYROLLITEMNONWAGE, 
		),
	//'only_add' => array( QUICKBOOKS_OBJECT_BILL ),
	//'only_modify' => array( QUICKBOOKS_OBJECT_BILL ), 
	);

// 
$callback_options = array();

// $dsn_or_conn, $how_often, $mode, $conflicts, $users = null, 
//	$map = array(), $onerror = array(), $hooks = array(), $log_level, $soap = QUICKBOOKS_SOAPSERVER_BUILTIN, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array()
$server = new QuickBooks_Server_SQL(
	$dsn, 
	'1 minute', 
	$mode, 
	$conflicts, 
	$delete,
	$username, 
	array(), 
	array(), 
	$hooks, 
	QUICKBOOKS_LOG_DEVELOP, 
	QUICKBOOKS_SOAPSERVER_BUILTIN, 
	QUICKBOOKS_WSDL,
	$soap_options, 
	$handler_options, 
	$driver_options,
	$sql_options, 
	$callback_options);
$server->handle(true, true);

