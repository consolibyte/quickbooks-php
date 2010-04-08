<?php

require_once '../QuickBooks.php';


$BillPaymentCheck = new QuickBooks_Object_BillPaymentCheck();

$BillPaymentCheck->setRefNumber(1234);
$BillPaymentCheck->setPayeeEntityFullName('Test Vendor');
$BillPaymentCheck->setBankAccountFullName('Liberty Bank');
$BillPaymentCheck->setMemo('Test memo');
$BillPaymentCheck->setIsToBePrinted();

$AppliedToTxn = new QuickBooks_Object_BillPaymentCheck_AppliedToTxn();
$AppliedToTxn->setPaymentAmount(50.0);
$AppliedToTxn->setDiscountAmount(5.0);
$AppliedToTxn->setTransactionID('1234-ABCD');

$BillPaymentCheck->addAppliedToTxn($AppliedToTxn);

print_r($BillPaymentCheck);

print($BillPaymentCheck->asQBXML(QUICKBOOKS_ADD_BILLPAYMENTCHECK));