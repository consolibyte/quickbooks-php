<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$BillService = new QuickBooks_IPP_Service_Bill();

$bills = $BillService->query($Context, $realm, "SELECT * FROM Bill ");

//print_r($customers);

foreach ($bills as $Bill)
{
	print('Bill # ' . $Bill->getDocNumber() . ' has a total of $' . $Bill->getTotalAmt() . "\n");
	
	$num_line = $Bill->countLine();
	for ($i = 0; $i < $num_line; $i++)
	{
		$Line = $Bill->getLine();
		print_r($Line);
	}
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