<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$CustomerService = new QuickBooks_IPP_Service_Customer();

$customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer ");

foreach ($customers as $Customer)
{
	//print_r($Customer);

	print('Customer #' . $Customer->getXPath('//Customer/Id') . "\n");
	print('  Phone: ' . $Customer->getXPath('//Customer/PrimaryPhone/FreeFormNumber') . "\n");
	print('  Email: ' . $Customer->getXPath('//Customer/PrimaryEmailAddr/Address') . "\n\n");
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