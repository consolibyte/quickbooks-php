<?php

require_once '../QuickBooks.php';


$Deposit = new QuickBooks_Object_Deposit();

$Deposit->setTxnDate(time());
$Deposit->setDepositToAccountFullName('Liberty Bank');
$Deposit->setMemo('Test deposit');

$DepositLine = new QuickBooks_Object_Deposit_DepositLine();
$DepositLine->setPaymentTxnID('1234-ABCD');
$DepositLine->setPaymentTxnLineID('5668-EFGH');
$DepositLine->setOverrideMemo('Test override memo');
$DepositLine->setOverrideCheckNumber('1234');
$DepositLine->setMemo('test memo');
$DepositLine->setAmount(40.0);

$Deposit->addDepositLine($DepositLine);

print($Deposit->asQBXML(QUICKBOOKS_ADD_DEPOSIT));