<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$PaymentService = new QuickBooks_IPP_Service_Payment();

$Id = 76;

// Let's look at this payment first 
$payments = $PaymentService->query($Context, $realm, "SELECT * FROM Payment WHERE Id = '76' ");
print_r($payments[0]);

// Now let's VOID it  
if ($resp = $PaymentService->void($Context, $realm, $Id))
{
	print('We voided the payment.');
}
else
{
	print($PaymentService->lastError());
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
