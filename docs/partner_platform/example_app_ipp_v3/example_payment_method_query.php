<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$PaymentMethodService = new QuickBooks_IPP_Service_PaymentMethod();

$paymentmethods = $PaymentMethodService->query($Context, $realm, "SELECT * FROM PaymentMethod");

//print_r($terms);

foreach ($paymentmethods as $PaymentMethod)
{
	//print_r($Term);

	print('PaymentMethod Id=' . $PaymentMethod->getId() . ' is named: ' . $PaymentMethod->getName() . '<br>');
}

/*
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