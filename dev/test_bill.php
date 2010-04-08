<?php

require_once '../QuickBooks.php';


$Bill = new QuickBooks_Object_Bill();

$Bill->setRefNumber(1234);
$Bill->setVendorFullName('test vendor');

$ExpenseLine = new QuickBooks_Object_Bill_ExpenseLine();
$ExpenseLine->setMemo('test memo');
$ExpenseLine->setCustomerFullName('Michael Baxter');
$ExpenseLine->setAmount(40.0);

$ItemLine1 = new QuickBooks_Object_Bill_ItemLine();
$ItemLine1->setItemFullName('test');
$ItemLine1->setQuantity(2);
$ItemLine1->setCost(15.50);

$ItemLine2 = new QuickBooks_Object_Bill_ItemLine();
$ItemLine2->setItemFullName('test');
$ItemLine2->setQuantity(3);
$ItemLine2->setCost(5.50);


$Bill->addExpenseLine($ExpenseLine);
$Bill->addItemLine($ItemLine1);
$Bill->addItemLine($ItemLine2);

//print_r($Bill);

print($Bill->asQBXML(QUICKBOOKS_ADD_BILL));