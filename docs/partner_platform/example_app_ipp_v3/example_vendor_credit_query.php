<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$VendorCreditService = new QuickBooks_IPP_Service_VendorCredit();

$vcs = $VendorCreditService->query($Context, $realm, "SELECT * FROM VendorCredit");

//print_r($terms);

foreach ($vcs as $Vc)
{
	print_r($Vc);
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