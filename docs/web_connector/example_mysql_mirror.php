<?php

/**
 * An example of how to mirror parts (or all of) the QuickBooks database to a MySQL database
 * 
 * 
 * *REALLY FREAKING IMPORTANT* WARNING WARNING WARNING WARNING
 * 
 * THE SQL MIRROR CODE IS BETA CODE, AND IS KNOWN TO HAVE BUGS!
 * 
 * With that said:
 * - If you're planning on using it in a production environment, you better be ready to do a lot of testing and debugging.
 * - Use a nightly build. There are known problems with the mirror code in the v1.5.2 or v1.5.3 releases of the code.
 * - There is absolutely no way I can troubleshoot problems for you without you posting your code. Dumps of the quickbooks_queue and quickbooks_log tables and/or phpMyAdmin access to your MySQL database is helpful also.
 * 
 * Nightly builds are available here:
 * https://code.intuit.com/sf/frs/do/viewRelease/projects.php_devkit/frs.php_devkit.latest_sources
 * 
 * IN ALL LIKELIHOOD, YOU SHOULD *NOT* BE USING THIS CODE. YOU SHOULD INSTEAD 
 * LOOK AT THE FOLLOWING SCRIPTS AND IMPLEMENT YOUR REQUEST/RESPONSE HANDLERS 
 * YOURSELF:
 * 	docs/example_web_connector.php
 * 	docs/example_web_connector_import.php
 * 
 * *REALLY FREAKING IMPORTANT* WARNING WARNING WARNING WARNING
 *
 *  
 * The SQL mirror functionality makes it easy to extract information from 
 * QuickBooks into an SQL database, and, if so desired, write changes to the 
 * SQL records back to QuickBooks automatically. 
 * 
 * You should look at my wiki for more information about mirroring QuickBooks 
 * data into SQL databases:
 * 	http://wiki.consolibyte.com/wiki/doku.php/quickbooks_integration_php_consolibyte_sqlmirror
 * 
 * You should also read this forum post before even thinking about using this:
 * 	http://consolibyte.com/forum/viewtopic.php?id=20
 * 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// I always program in E_STRICT error mode with error reporting turned on... 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// Set the include path
require_once dirname(__FILE__) . '/../QuickBooks.php';

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
// 	Currently, only MySQL is supported/tested. 
$dsn = 'mysql://root:root@localhost/quickbooks_sql';

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
//$mode = QuickBooks_WebConnector_Server_SQL::MODE_READONLY;		// Read from QuickBooks only (no data will be pushed back to QuickBooks)
//$mode = QuickBooks_WebConnector_Server_SQL::MODE_WRITEONLY;		// Write to QuickBooks only (no data will be copied into the SQL database)
$mode = QuickBooks_WebConnector_Server_SQL::MODE_READWRITE;		// Keep both QuickBooks and the database in sync, reading and writing changes back and forth)

// What should we do if a conflict is found? (a record has been changed by another user or process that we're trying to update)
$conflicts = QuickBooks_WebConnector_Server_SQL::CONFLICT_LOG;

// What should we do with records deleted from QuickBooks? 
//$delete = QuickBooks_WebConnector_Server_SQL::DELETE_REMOVE;		// Delete the record from the database too
$delete = QuickBooks_WebConnector_Server_SQL::DELETE_FLAG; 		// Just flag it as deleted

// Hooks (optional stuff)
$hooks = array();

/*
// Hooks (optional stuff)
$hook_obj = new MyHookClass2('Keith Palmer');

$hooks = array(

	// Register a hook which occurs when we perform an INSERT into the SQL database for a record from QuickBooks
	// QuickBooks_SQL::HOOK_SQL_INSERT => 'my_function_name_for_inserts', 
	// QuickBooks_SQL::HOOK_SQL_INSERT => 'MyHookClass::myMethod',
	
	// Register a hook which occurs when we perform an UPDATE on the SQL database for a record from QuickBooks
	// QuickBooks_SQL::HOOK_SQL_UPDATE => 'my_function_name_for_updates',

	// Example of registering multiple hooks for one hook type 
	// QuickBooks_SQL::HOOK_PREHANDLE => array(
	//	'my_prehandle_function',
	//	array( $hook_obj, 'myMethod' ),
	//	),
	
	// Example of using the hook factory to use a pre-defined hook
	// QuickBooks_SQL::HOOK_SQL_INSERT => QuickBooks_Hook_Factory::create(
	//	'Relay_POST', 								// Relay the hook data to a remote URL via a HTTP POST
	//	'http://localhost:8888/your_script.php'),
	
	QuickBooks_SQL::SQL_INSERT => array(
		QuickBooks_Hook_Factory::create(
			'Relay_POST', 
			'http://localhost:8888/your_script.php', 
			array( '_secret' => 'J03lsN3at@pplication' ) ), 
		), 
	);

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
$handler_options = array(
	'deny_concurrent_logins' => false,
	);

// 
$driver_options = array();

$ops = array(
	QUICKBOOKS_OBJECT_SALESTAXITEM, 
	QUICKBOOKS_OBJECT_SALESTAXCODE, 
	QUICKBOOKS_OBJECT_CUSTOMER, 
	QUICKBOOKS_OBJECT_VENDOR, 
	
	QUICKBOOKS_OBJECT_INVENTORYITEM, 
	
	QUICKBOOKS_OBJECT_TEMPLATE, 
	
	QUICKBOOKS_OBJECT_CUSTOMERTYPE, 
	QUICKBOOKS_OBJECT_VENDORTYPE, 
	QUICKBOOKS_OBJECT_ESTIMATE, 
	QUICKBOOKS_OBJECT_INVOICE, 
	QUICKBOOKS_OBJECT_CLASS, 
	
	QUICKBOOKS_OBJECT_INVOICE, 
	
	/*
	QUICKBOOKS_OBJECT_INVENTORYITEM, 
	QUICKBOOKS_OBJECT_NONINVENTORYITEM, 
	QUICKBOOKS_OBJECT_SERVICEITEM, 
	QUICKBOOKS_OBJECT_SHIPMETHOD, 
	QUICKBOOKS_OBJECT_PAYMENTMETHOD, 
	QUICKBOOKS_OBJECT_TERMS, 
	QUICKBOOKS_OBJECT_PRICELEVEL, 
	QUICKBOOKS_OBJECT_ITEM, 
	*/
	
	QUICKBOOKS_OBJECT_PAYMENTMETHOD, 
	
	QUICKBOOKS_OBJECT_COMPANY, 
	QUICKBOOKS_OBJECT_HOST, 
	QUICKBOOKS_OBJECT_PREFERENCES,
	);

$ops_misc = array(		// For fetching inventory levels, deleted transactions, etc. 
	QUICKBOOKS_DERIVE_INVENTORYLEVELS,
	QUICKBOOKS_QUERY_DELETEDLISTS,
	QUICKBOOKS_QUERY_DELETEDTRANSACTIONS,
	// 'nothing', 
	);

// 
$sql_options = array(
	'only_import' => $ops,
	'only_add' => $ops, 
	'only_modify' => $ops, 
	'only_misc' => $ops_misc, 
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

