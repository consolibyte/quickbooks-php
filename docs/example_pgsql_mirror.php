<?php

/**
 * An example of how to mirror parts (or all of) the QuickBooks database to a PostgreSQL database
 * 
 * The SQL mirror functionality makes it easy to extract information from 
 * QuickBooks into an SQL database, and, if so desired, write changes to the 
 * SQL records back to QuickBooks automatically. 
 * 
 * You should look at my wiki for more information about mirroring QuickBooks 
 * data into SQL databases:
 * 	http://wiki.consolibyte.com/wiki/doku.php/quickbooks_integration_php_consolibyte_sqlmirror
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// I always program in E_STRICT error mode with error reporting turned on... 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// Set the include path
require_once '../QuickBooks.php';

// You should make sure this matches the time-zone QuickBooks is running in
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

// The username and password the Web Connector will use to connect with
$username = 'quickbooks';
$password = 'password';

// Database connection string
//
// You *MUST* start with a fresh database! If the database you use has any 
//	quickbooks_* or qb_* related tables in it, then the schema *WILL NOT* build 
//	correctly! 
// 	
// 	Currently, only MySQL and PostgreSQL are supported/tested. 
//$dsn = 'pgsql://postgres:password@localhost/quickbooks';
//$dsn = 'pgsql://postgres:password@localhost/quickbooks.diffschema';		// Example of using a different schema than the default schema
$dsn = 'pgsql://postgres:password@localhost/quickbooks.qb';

// If the database has not been initialized, we need to initialize it (create 
//	schema and set up the username/password, etc.)
if (!QuickBooks_Utilities::initialized($dsn))
{
	header('Content-Type: text/plain');
	
	// It takes a really long time to build the schema... 
	set_time_limit(0);
	
	$driver_options = array(
		);
		
	$init_options = array(
		'quickbooks_sql_enabled' => true, 
		);
		
	QuickBooks_Utilities::initialize($dsn, $driver_options, $init_options);
	QuickBooks_Utilities::createUser($dsn, $username, $password);
	
	exit;
}

// What mode do we want to run the mirror in? 
//$mode = QUICKBOOKS_SERVER_SQL_MODE_READONLY;		// Read from QuickBooks only (no data will be pushed back to QuickBooks)
//$mode = QUICKBOOKS_SERVER_SQL_MODE_WRITEONLY;		// Write to QuickBooks only (no data will be copied into the SQL database)
$mode = QuickBooks_WebConnector_Server_SQL::MODE_READWRITE;		// Keep both QuickBooks and the database in sync, reading and writing changes back and forth)

// What should we do if a conflict is found? (a record has been changed by another user or process that we're trying to update)
$conflicts = QuickBooks_WebConnector_Server_SQL::CONFLICT_LOG;

// What should we do with records deleted from QuickBooks? 
$delete = QuickBooks_WebConnector_Server_SQL::DELETE_REMOVE;		// Delete the record from the database too
//$delete = QUICKBOOKS_SERVER_SQL_DELETE_FLAG; 		// Just flag it as deleted

$hooks = array(

	// Register a hook which occurs when we perform an INSERT into the SQL database for a record from QuickBooks
	// QUICKBOOKS_SQL_HOOK_SQL_INSERT => 'my_function_name_for_inserts', 
	//QUICKBOOKS_SQL_HOOK_SQL_INSERT => 'MyHookClass::myMethod',
	
	// Register a hook which occurs when we perform an UPDATE on the SQL database for a record from QuickBooks
	// QUICKBOOKS_SQL_HOOK_SQL_UPDATE => 'my_function_name_for_updates',

	// Example of registering multiple hooks for one hook type 
	/*
	QUICKBOOKS_SERVER_HOOK_PREHANDLE => array(
		'my_prehandle_function',
		array( $hook_obj, 'myMethod' ),
		),
	*/
	
	// Example of using the hook factory to use a pre-defined hook
	//QUICKBOOKS_SQL_HOOK_SQL_INSERT => QuickBooks_Hook_Factory::create(
	//	'Relay_POST', 								// Relay the hook data to a remote URL via a HTTP POST
	//	'http://localhost:8888/your_script.php'),
	);

// 
$soap_options = array();

// 
$handler_options = array();

// 
$driver_options = array();

// 
$sql_options = array(
	'only_import' => array( 
		//QUICKBOOKS_OBJECT_ESTIMATE, 
		QUICKBOOKS_OBJECT_INVOICE, 
		QUICKBOOKS_OBJECT_CUSTOMER, 
		//QUICKBOOKS_OBJECT_VENDOR, 
		//QUICKBOOKS_OBJECT_SERVICEITEM, 
		//QUICKBOOKS_OBJECT_PURCHASEORDER, 
		//QUICKBOOKS_OBJECT_SHIPMETHOD, 
		//QUICKBOOKS_OBJECT_RECEIVEPAYMENT,
		QUICKBOOKS_OBJECT_CREDITMEMO, 
	),
	'only_add' => array( 
		//QUICKBOOKS_OBJECT_ESTIMATE, 
		QUICKBOOKS_OBJECT_INVOICE, 
		QUICKBOOKS_OBJECT_CUSTOMER, 
		//QUICKBOOKS_OBJECT_VENDOR, 
		//QUICKBOOKS_OBJECT_SERVICEITEM, 
		//QUICKBOOKS_OBJECT_PURCHASEORDER, 
		//QUICKBOOKS_OBJECT_SHIPMETHOD, 
		//QUICKBOOKS_OBJECT_RECEIVEPAYMENT,
		QUICKBOOKS_OBJECT_CREDITMEMO, 
	),
	'only_modify' => array( 
		//QUICKBOOKS_OBJECT_ESTIMATE, 
		QUICKBOOKS_OBJECT_INVOICE, 
		QUICKBOOKS_OBJECT_CUSTOMER, 
		//QUICKBOOKS_OBJECT_VENDOR, 
		//QUICKBOOKS_OBJECT_SERVICEITEM, 
		//QUICKBOOKS_OBJECT_PURCHASEORDER, 
		//QUICKBOOKS_OBJECT_SHIPMETHOD, 
		//QUICKBOOKS_OBJECT_RECEIVEPAYMENT,
		QUICKBOOKS_OBJECT_CREDITMEMO, 
	), 
);

// 
$callback_options = array();

// $dsn_or_conn, $how_often, $mode, $conflicts, $users = null, 
//	$map = array(), $onerror = array(), $hooks = array(), $log_level, $soap = QUICKBOOKS_SOAPSERVER_BUILTIN, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array()
$Server = new QuickBooks_WebConnector_Server_SQL(
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
$Server->handle(true, true);

