<?php

require_once '../QuickBooks.php';

$JE = new QuickBooks_Object_JournalEntry();

$JE->setTxnDate('2011-01-01');
$JE->setMemo('test memo');

$CreditLine = new QuickBooks_Object_JournalEntry_JournalCreditLine();
$CreditLine->setAccountName('test');

$JE->addCreditLine($CreditLine);

print($JE->asQBXML(QUICKBOOKS_ADD_JOURNALENTRY));