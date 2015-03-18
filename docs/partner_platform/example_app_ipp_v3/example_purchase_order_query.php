<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$PurchaseOrderService = new QuickBooks_IPP_Service_PurchaseOrder();

$pos = $PurchaseOrderService->query($Context, $realm, "SELECT * FROM PurchaseOrder");

//print_r($terms);

foreach ($pos as $PurchaseOrder)
{
	//print_r($Term);

	print('PurchaseOrder Id=' . $PurchaseOrder->getId() . ' is named: ' . $PurchaseOrder->getDocNumber() . '<br>');
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