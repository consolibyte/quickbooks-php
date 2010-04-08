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
$api_driver_dsn = 'mysql://root:@localhost/quickbooks';
//$api_driver_dsn = 'pgsql://pgsql@localhost/quickbooks';
$source_dsn = 'http://quickbooks:test@localhost/path/to/server.php';
$source_options = array();
$driver_options = array();

if (!QuickBooks_Utilities::initialized($api_driver_dsn))
{
	QuickBooks_Utilities::initialize($api_driver_dsn);
	QuickBooks_Utilities::createUser($api_driver_dsn, 'api', 'password');
}


$API = new QuickBooks_API($api_driver_dsn, $user, $source_type, $source_dsn, $api_options = array(), $source_options = array(), $driver_options = array());

$fname = 'Shannon ' . mt_rand(1, 1000);
$lname = 'Daniels';

$Customer = new QuickBooks_Object_Customer();

$Customer->setParentApplicationID(15);

$Customer->setFirstName($fname);
$Customer->setLastName($lname);

$Customer->setShipAddress('56 Cowles Road', '', '', '', '', 'Willington', 'CT');
$Customer->setMiddleName('R');
$Customer->setSalutation('Mr.');

$Customer->setPhone('1.860.634.1602');

$API->addCustomer($Customer, '_quickbooks_customer_add_callback', 15);


$Invoice = new QuickBooks_Object_Invoice();
$Invoice->setOther('test of other');
$Invoice->setMemo('test of a memo');
$Invoice->setCustomerApplicationID(15);
$Invoice->setRefNumber(125);

$InvoiceLine1 = new QuickBooks_Object_Invoice_InvoiceLine();
$InvoiceLine1->setItemApplicationID(12);
$InvoiceLine1->setAmount(300.00);
$InvoiceLine1->setQuantity(3);

$InvoiceLine2 = new QuickBooks_Object_Invoice_InvoiceLine();
$InvoiceLine2->setItemApplicationID(11);
$InvoiceLine2->setAmount(225.00);
$InvoiceLine2->setQuantity(5);

$Invoice->addInvoiceLine($InvoiceLine1);
$Invoice->addInvoiceLine($InvoiceLine2);

//print_r($Invoice);
//exit;
//print($Invoice->asQBXML());

print('trying to add invoice...');

$API->addInvoice($Invoice, 'my_invoice_callback', 20);

exit;

/*
$API->getCustomerByName($fname . ' ' . $lname, '_quickbooks_customer_get_callback');


$API->getCustomer('1234', 'my_get_customer_callback');


$API->getCustomerByName('Keith Palmer', 'my_get_customer_byname_callback');
*/

/*
$API->searchInvoices(array(), 'my_search_invoices_callback');

$API->searchClasses(array(), 'my_search_classes_callback');

$API->searchAccounts(array(), 'my_search_accounts_callback');

$ServiceItem = new QuickBooks_Object_ServiceItem();
$ServiceItem->isSalesOrPurchase(true);

$ServiceItem->setName('My Test Item');
$ServiceItem->setPrice(250);
$ServiceItem->setDescription('My Test Item Description');

$API->addServiceItem($ServiceItem, 'my_service_item_add_callback');

$InventoryItem = new QuickBooks_Object_InventoryItem();
$InventoryItem->setName('Test Inventory Item ' . mt_rand());
$InventoryItem->setSalesPrice(25.25);

$API->addInventoryItem($InventoryItem, 'my_inventory_item_add_callback');

$NonInventoryItem = new QuickBooks_Object_NonInventoryItem();
$NonInventoryItem->setName('Test NonInventory Item ' . mt_rand());
$NonInventoryItem->setPrice(25.25);

$API->addNonInventoryItem($NonInventoryItem, 'my_noninventory_item_add_callback');

$Account = new QuickBooks_Object_Account();
$Account->setName('My Test Account ' . mt_rand());
$Account->setAccountType(QUICKBOOKS_ACCOUNT_ACCOUNTTYPE_BANK);
$Account->setAccountNumber('1234fgc');

$API->addAccount($Account, 'callback', 25);
*/

$Class = new QuickBooks_Object_Class();
$Class->setName('My Test Class ' . mt_rand());

//print_r($Class);

//print($Class->asQBXML(QUICKBOOKS_ADD_CLASS . 'Rq'));

$API->addClass($Class, 'callback', 15);

//$API->getServiceItemByName('Test Name', 'callback');
//$API->getInventoryItemByName('Test Name', 'callback');
//$API->getNonInventoryItemByName('Test Name', 'callback');

/*
$SalesReceipt = new QuickBooks_Object_SalesReceipt();

$Invoice = new QuickBooks_Object_Invoice();
$Invoice->setOther('test of other');
$Invoice->setMemo('test of a memo');
$Invoice->setCustomerApplicationID(15);
$Invoice->setRefNumber(125);

$InvoiceLine1 = new QuickBooks_Object_Invoice_InvoiceLine();
$InvoiceLine1->setItemApplicationID(12);
$InvoiceLine1->setAmount(300.00);
$InvoiceLine1->setQuantity(3);

$InvoiceLine2 = new QuickBooks_Object_Invoice_InvoiceLine();
$InvoiceLine2->setItemApplicationID(11);
$InvoiceLine2->setAmount(225.00);
$InvoiceLine2->setQuantity(5);

$Invoice->addInvoiceLine($InvoiceLine1);
$Invoice->addInvoiceLine($InvoiceLine2);

//print_r($Invoice);
//exit;
//print($Invoice->asQBXML());

print('trying to add invoice...');

$API->addInvoice($Invoice, 'my_invoice_callback', 20);
*/

function my_customer_callback()
{
	
}

function my_invoice_callback()
{
	
}

?>