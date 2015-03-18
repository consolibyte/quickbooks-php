<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$PaymentService = new QuickBooks_IPP_Service_Payment();

$the_payment_to_delete = '{-12}';

$retr = $PaymentService->delete($Context, $realm, $the_payment_to_delete);
if ($retr)
{
	print('The payment was deleted!');
}
else
{
	print('Could not delete payment: ' . $PaymentService->lastError());
}

/*
// For debugging 

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