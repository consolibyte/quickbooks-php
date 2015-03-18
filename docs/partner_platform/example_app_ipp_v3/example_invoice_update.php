<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$InvoiceService = new QuickBooks_IPP_Service_Invoice();

// Get the existing invoice first (you need the latest SyncToken value)
$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice WHERE Id = '34' ");
$Invoice = $invoices[0];

$Line = $Invoice->getLine(0);
$Line->setDescription('Update of my description on ' . date('r'));

print_r($Invoice);

$Invoice->setTxnDate(date('Y-m-d'));  // Update the invoice date to today's date 

if ($resp = $InvoiceService->update($Context, $realm, $Invoice->getId(), $Invoice))
{
	print('&nbsp; Updated!<br>');
}
else
{
	print('&nbsp; ' . $InvoiceService->lastError() . '<br>');
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
