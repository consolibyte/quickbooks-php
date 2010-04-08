<?php

require_once '../QuickBooks.php';


$ReceivePayment = new QuickBooks_Object_ReceivePayment();

$ReceivePayment->setTotalAmount(65);

print($ReceivePayment->asQBXML(QUICKBOOKS_ADD_RECEIVEPAYMENT));



$ReceivePayment2 = new QuickBooks_Object_ReceivePayment();
$ReceivePayment2->setTotalAmount('35.00');

$AppliedToTxn = new QuickBooks_Object_ReceivePayment_AppliedToTxn();
$AppliedToTxn->setPaymentAmount(50);
$AppliedToTxn->setDiscountAmount(25);
$ReceivePayment2->addAppliedToTxn($AppliedToTxn);


print($ReceivePayment2->asQBXML(QUICKBOOKS_ADD_RECEIVEPAYMENT));