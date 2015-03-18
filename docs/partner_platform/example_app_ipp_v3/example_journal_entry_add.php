<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$JournalEntryService = new QuickBooks_IPP_Service_JournalEntry();

// Main journal entry object
$JournalEntry = new QuickBooks_IPP_Object_JournalEntry();
$JournalEntry->setDocNumber('1234');
$JournalEntry->setTxnDate(date('Y-m-d'));

// Debit line
$Line1 = new QuickBooks_IPP_Object_Line();
$Line1->setDescription('Line 1 description');
$Line1->setAmount(100);
$Line1->setDetailType('JournalEntryLineDetail');

$Detail1 = new QuickBooks_IPP_Object_JournalEntryLineDetail();
$Detail1->setPostingType('Debit');
$Detail1->setAccountRef(3);

$Line1->addJournalEntryLineDetail($Detail1);
$JournalEntry->addLine($Line1);

// Credit line
$Line2 = new QuickBooks_IPP_Object_Line();
$Line2->setDescription('Line 2 description');
$Line2->setAmount(100);
$Line2->setDetailType('JournalEntryLineDetail');

$Detail2 = new QuickBooks_IPP_Object_JournalEntryLineDetail();
$Detail2->setPostingType('Credit');
$Detail2->setAccountRef(56);

$Line2->addJournalEntryLineDetail($Detail2);
$JournalEntry->addLine($Line2);

if ($resp = $JournalEntryService->add($Context, $realm, $JournalEntry))
{
	print('Our new journal entry ID is: [' . $resp . ']');
}
else
{
	print($JournalEntryService->lastError($Context));
}

/*
print('<br><br><br><br>');
print("\n\n\n\n\n\n\n\n");
print('Request [' . $IPP->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $IPP->lastResponse() . ']');
print("\n\n\n\n\n\n\n\n\n");
*/

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';
