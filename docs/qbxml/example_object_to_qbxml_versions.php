<?php

/**
 * Example of building qbXML for specific versions of QuickBooks using the QuickBooks_Object_* classes
 * 
 * Certain versions of QuickBooks may or may not support certain different 
 * features of the qbXML specification. For instance, Online Edition may not 
 * support the 'Customer Type' field. The use of locale constants allows us to 
 * build qbXML requests from objects, tailoring those requests to the specific 
 * qbXML version and locale we want to send the request to. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 *
 * @package QuickBooks
 * @subpackage Documentation
 */ 

// Plain text output
header('Content-Type: text/plain');

// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

// Require the QuickBooks libraries
require_once '../QuickBooks.php';

/*
// Create a new SalesReceipt object
$SalesReceipt = new Quickbooks_Object_SalesReceipt();

// Set some fields
$SalesReceipt->setCustomerFullName('ConsoliBYTE:Keith Palmer');

// This is for US editions
$SalesReceipt->setItemSalesTaxFullName('CT Sales Tax');

// This is for Online Edition
$SalesTaxLine = new QuickBooks_Object_SalesReceipt_SalesTaxLine();
$SalesTaxLine->setAmount(7.50);
$SalesReceipt->addSalesTaxLine($SalesTaxLine);

// Add a line items
$Line1 = new QuickBooks_Object_SalesReceipt_SalesReceiptLine();
$Line1->setItemFullName('QuickBooks Integration:PHP Integration');
$Line1->setQuantity(1);
$Line1->setRate(125.0);
$Line1->setSalesTaxCodeFullName('TAX');

$SalesReceipt->addSalesReceiptLine($Line1);

print('qbXML SalesReceipt for QuickBooks qbXML US editions: ' . "\r\n");
print($SalesReceipt->asQBXML(QUICKBOOKS_ADD_SALESRECEIPT, null, QUICKBOOKS_LOCALE_UNITED_STATES));

print("\r\n\r\n");

print('qbXML SalesReceipt for QuickBooks qbXML Online Edition: ' . "\r\n");
print($SalesReceipt->asQBXML(QUICKBOOKS_ADD_SALESRECEIPT, null, QUICKBOOKS_LOCALE_ONLINE_EDITION));


exit;
*/

// Create a new Customer object
$Customer = new QuickBooks_QBXML_Object_Customer();

// Set some fields
$Customer->setFullName('Contractors:ConsoliBYTE, LLC:Keith Palmer');
$Customer->setCustomerTypeFullName('Web:Direct');
$Customer->setNotes('Test notes go here.');

print('qbXML Customer for QuickBooks qbXML (latest version the framework supports): ' . "\r\n");
print($Customer->asQBXML(QUICKBOOKS_ADD_CUSTOMER));

print("\r\n\r\n");

print('qbXML Customer for QuickBooks qbXML US editions: ' . "\r\n");
print($Customer->asQBXML(QUICKBOOKS_ADD_CUSTOMER, null, QuickBooks_QBXML::LOCALE_UNITED_STATES));

print("\r\n\r\n");

print('qbXML Customer for QuickBooks qbXML Online Edition: ' . "\r\n");
print($Customer->asQBXML(QUICKBOOKS_ADD_CUSTOMER, null, QuickBooks_QBXML::LOCALE_ONLINE_EDITION));

print("\r\n\r\n");

$Customer->setListID('1234');
$Customer->setEditSequence('5678');

print('qbXML Customer (modification) for QuickBooks qbXML Online Edition: ' . "\r\n");
print($Customer->asQBXML(QUICKBOOKS_MOD_CUSTOMER, null, QuickBooks_QBXML::LOCALE_ONLINE_EDITION));
