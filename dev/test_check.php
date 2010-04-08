<?php

require_once '../QuickBooks.php';


$Check = new QuickBooks_Object_Check();

$Check->setRefNumber(1234);
$Check->setPayeeEntityFullName('test vendor');
$Check->setTxnDate(time());

//$Check->setIsToBePrinted(true);
$Check->setIsToBePrinted(false);

$ExpenseLine = new QuickBooks_Object_Check_ExpenseLine();
$ExpenseLine->setMemo('test memo');
$ExpenseLine->setCustomerFullName('Michael Baxter');
$ExpenseLine->setAmount(40.0);

$ItemLine1 = new QuickBooks_Object_Check_ItemLine();
$ItemLine1->setItemFullName('test');
$ItemLine1->setQuantity(2);
$ItemLine1->setCost(15.50);

$ItemLine2 = new QuickBooks_Object_Check_ItemLine();
$ItemLine2->setItemFullName('test');
$ItemLine2->setQuantity(3);
$ItemLine2->setCost(5.50);


$Check->addExpenseLine($ExpenseLine);
$Check->addItemLine($ItemLine1);
$Check->addItemLine($ItemLine2);

//print_r($Check);

print($Check->asQBXML(QUICKBOOKS_ADD_CHECK));