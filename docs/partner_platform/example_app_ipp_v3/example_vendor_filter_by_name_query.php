<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$VendorService = new QuickBooks_IPP_Service_Vendor();

$vendors = $VendorService->query($Context, $realm, "SELECT * FROM Vendor WHERE DisplayName = 'Shannon Palmer' ");

//print_r($terms);

foreach ($vendors as $Vendor)
{
	//print_r($Term);

	print('Vendor Id=' . $Vendor->getId() . ' is named: ' . $Vendor->getDisplayName() . '<br>');
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