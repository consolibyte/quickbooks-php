<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$SalesReceiptService = new QuickBooks_IPP_Service_SalesReceipt();

$salesreceipts = $SalesReceiptService->query($Context, $realm, "SELECT * FROM SalesReceipt STARTPOSITION 1 MAXRESULTS 10");

//print_r($salesreceipts);

foreach ($salesreceipts as $SalesReceipt)
{
	print('Receipt # ' . $SalesReceipt->getDocNumber() . ' has a total of $' . $SalesReceipt->getTotalAmt() . "\n");
	
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