<?php

require_once dirname(__FILE__) . '/config_oauthv2.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php
	
$JournalEntryService = new QuickBooks_IPP_Service_JournalEntry();

$list = $JournalEntryService->query($Context, $realm, "SELECT * FROM JournalEntry STARTPOSITION 1 MAXRESULTS 10");

//print_r($salesreceipts);

foreach ($list as $JournalEntry)
{
	print_r($JournalEntry);
}

/*
print($IPP->lastError($Context));

print("\n\n\n\n");
print('Request [' . $IPP->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $IPP->lastResponse() . ']');
print("\n\n\n\n");
*/

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>