<?php

header('Content-Type: text/plain');

require_once '../QuickBooks.php';

// Build an invoice 
$Invoice = new QuickBooks_IPP_Object_Invoice();

$Header = new QuickBooks_IPP_Object_Header();

$Header->setTaxAmt(100);
$Header->setDiscountAmt(50);

$Header->setTxnDate('2011-01-14');
$Header->setCustomerId('{QBO-2}');

$Header->setBillEmail('support@consolibyte.com');
$Header->setTotalAmt(250);

$Header->setTaxRate(5.15);

$BillAddr = new QuickBooks_IPP_Object_BillAddr();
$BillAddr->setLine1('56 Cowles Road');
$BillAddr->setCity('Willington');
$BillAddr->setCountrySubDivisionCode('Connecticut');

$Header->addBillAddr($BillAddr);

$Invoice->addHeader($Header);

$Line = new QuickBooks_IPP_Object_Line();
$Line->setDesc('Hope, Bob (Normal Hours) 12/26/2010');
$Line->setTaxable('true');
$Line->setItemId('{QBO-2}');
$Line->setAmount(1000);
$Line->setUnitPrice(1000);
$Line->setQty(1);
$Line->setSalesTaxCodeId('{QBO-1}');

$Invoice->addLine($Line);


print("\n\n\n");
print($Invoice->asIDSXML());