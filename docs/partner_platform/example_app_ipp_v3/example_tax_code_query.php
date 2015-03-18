<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$TaxCodeService = new QuickBooks_IPP_Service_TaxCode();

$taxcodes = $TaxCodeService->query($Context, $realm, "SELECT * FROM TaxCode");

foreach ($taxcodes as $TaxCode)
{
	//print_r($Item);

	print('TaxCode Id=' . $TaxCode->getId() . ' is named: ' . $TaxCode->getName() . '<br>');
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