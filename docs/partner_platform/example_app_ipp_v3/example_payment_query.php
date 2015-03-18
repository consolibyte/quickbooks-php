<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$PaymentService = new QuickBooks_IPP_Service_Payment();

$list = $PaymentService->query($Context, $realm, "SELECT * FROM Payment STARTPOSITION 1 MAXRESULTS 10");

//print_r($salesreceipts);

foreach ($list as $Payment)
{
	print('Payment # ' . $Payment->getPaymentRefNum() . ' has a total of $' . $Payment->getTotalAmt() . "\n");
	print('   Internal Id: ' . $Payment->getId() . "\n");
	print("\n");
}

/*
print($IPP->lastError());

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