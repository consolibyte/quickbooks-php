<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$VendorService = new QuickBooks_IPP_Service_Vendor();

$Vendor = new QuickBooks_IPP_Object_Vendor();
$Vendor->setTitle('Mr');
$Vendor->setGivenName('Keith');
$Vendor->setMiddleName('R');
$Vendor->setFamilyName('Palmer');
$Vendor->setDisplayName('Keith R Palmer Jr ' . mt_rand(0, 1000));

if ($resp = $VendorService->add($Context, $realm, $Vendor))
{
	print('Our new Vendor ID is: [' . $resp . ']');
}
else
{
	print($VendorService->lastError($Context));
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
