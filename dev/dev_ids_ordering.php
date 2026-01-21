<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

$Header = new QuickBooks_IPP_Object_Header();

$Header->setTxnDate('November 1st');
$Header->setCustomerName('Test Customer');
$Header->setOther('Test');
$Header->setDocNumber('1234');

$ShipAddr = new QuickBooks_IPP_Object_ShipAddr();
$ShipAddr->setLine2('Suite D');
$ShipAddr->setCity('Willington');
$ShipAddr->setLine1('56 Cowles Road');
$ShipAddr->setState('Connecticut');

$Header->addShipAddr($ShipAddr);

$SalesReceipt = new QuickBooks_IPP_Object_SalesReceipt();

$SalesReceipt->addHeader($Header);

print($SalesReceipt->asIDSXML(null, null, QuickBooks_IPP::IDS_ADD));

print("\n\n");
print('DATE OF TRANSACTION: [' . $Header->getTxnDate('M. j, Y') . ']');
print("\n\n");

/*
$Customer = new QuickBooks_IPP_Object_Customer();
$Customer->setFamilyName('Palmer');


$Customer->setName('ConsoliBYTE & Ryke Labs');

$Customer->setShowAs('Show As');

$Customer->setActive('true');

$Email = new QuickBooks_IPP_Object_Email();
$Email->setTag('Personal');
$Email->setAddress('keith@uglyslug.com');

$Customer->addEmail($Email);

$Customer->setSomething('Else');

$Address = new QuickBooks_IPP_Object_Address();
$Address->setCity('Willington');
$Address->setLine2('Suite D');
$Address->setPostalCode('06279');
$Address->setLine1('56 Cowles Road');
$Address->setTag(QuickBooks_IPP_Object_Address::TAG_BILLING);

$Customer->addAddress($Address);

$Address2 = new QuickBooks_IPP_Object_Address();
$Address2->setCity('Storrs');
$Address2->setLine2('Suite E');
$Address2->setPostalCode('06268');
$Address2->setLine1('134 Stonemill Road');
$Address2->setTag(QuickBooks_IPP_Object_Address::TAG_SHIPPING);

$Customer->addAddress($Address2);


$Customer->setGivenName('Keith');


//print($Customer->asXML());

print($Customer->asIDSXML(null, null, QuickBooks_IPP::IDS_ADD));
*/