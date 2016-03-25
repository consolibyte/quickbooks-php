<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<br>
<br>
<br>
<br>

<h1>
	DUE TO AN INTUIT BUG, THIS DOES NOT WORK WITH SANDBOX COMPANIES! 
</h1>

<br>
<br>
<br>
<br>
<br>

<pre>

<?php

$EntitlementsService = new QuickBooks_IPP_Service_Entitlements();

// This gets the entitlements/features of a QBO install 
$es = $EntitlementsService->entitlements($Context, $realm);

if ($es)
{
	foreach ($es as $e)
	{
		print($e->getEntitlementId() . '.: ' . $e->getName() . ' => ' . print_r($e->isOn(), true) . '  (' . $e->getTerm() . ')' . "\n");
	}

	print("\n\n\n\n");

	// This gets a bit more information about the QBO install (trial days, plan type, etc.)
	$is = $EntitlementsService->info($Context, $realm);

	print_r($is);
}
else
{
	//print_r($es);
	//print_r($is);

	print($EntitlementsService->lastRequest($Context));
	print($EntitlementsService->lastResponse($Context));

	print('ERROR: ');
	print($EntitlementsService->lastError($Context));
}

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>