<?php

//require_once '/home/library_php/QuickBooks.php';
//require_once '/Users/keithpalmerjr/Desktop/QuickBooks LATEST/QuickBooks.php';

//ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/home/library_php');
//ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/keithpalmerjr/Sites/QuickBooks_2008-07-05');

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . realpath('../../'));

require_once 'QuickBooks.php';

//require_once 'QuickBooks/Object/Invoice/InvoiceLine.php';

$user = 'api';
$source_type = QUICKBOOKS_API_SOURCE_WEB;
$api_driver_dsn = 'mysql://root:Odnotnev9@localhost/quickbooks';
//$api_driver_dsn = 'pgsql://pgsql@localhost/quickbooks';
$source_dsn = 'http://quickbooks:test@localhost/path/to/server.php';
$source_options = array();
$driver_options = array();

if (!QuickBooks_Utilities::initialized($api_driver_dsn))
{
	QuickBooks_Utilities::initialize($api_driver_dsn);
	QuickBooks_Utilities::createUser($api_driver_dsn, 'api', 'password');
}

$api_options = array(
	'qbxml_version' => 'CA3.0', 
	);

$source_options = array(
	);
	
$driver_options = array(
	);

$API = new QuickBooks_API($api_driver_dsn, $user, $source_type, $source_dsn, $api_options, $source_options, $driver_options);

$fname = 'Shannon ' . mt_rand(1, 1000);
$lname = 'Daniels';

$Customer = new QuickBooks_Object_Customer();

$Customer->setFirstName($fname);
$Customer->setLastName($lname);

$Customer->setShipAddress('56 Cowles Road', '', '', '', '', 'Willington', '', 'Quebec', 'Canada');
$Customer->setMiddleName('R');
$Customer->setSalutation('Mr.');

$Customer->setPhone('1.860.634.1602');

$API->addCustomer($Customer, '_quickbooks_customer_add_callback', 15);



$Class = new QuickBooks_Object_Class();
$Class->setName('My Test Class ' . mt_rand());

$API->addClass($Class, 'callback', 15);


function my_customer_callback()
{
	
}

function my_invoice_callback()
{
	
}

?>