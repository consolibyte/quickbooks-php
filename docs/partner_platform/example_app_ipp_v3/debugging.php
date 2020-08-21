<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php
	
$BillService = new QuickBooks_IPP_Service_Bill();

$Bill = new QuickBooks_IPP_Object_Bill();

$Bill->setDocNumber('abc123');
$Bill->setTxnDate('2014-07-12');
$Bill->setVendorRef('{-9}');

if ($id = $BillService->add($Context, $realm, $Bill))
{
	print('This will never happen... (this script is DESIGNED TO TRIGGER ERRORS to teach you how to troubleshoot!');
}
else
{
	// The below lines are helpful for debugging and troubleshooting.
	//  They will show you the raw XML request that was sent to Intuit, and the 
	//  raw XML response that Intuit returned. 
	//  
	// IF YOU ASK FOR HELP ONLINE, PLEASE PROVIDE THE OUTPUT FROM THESE LINES.
	// WE WILL NOT BE ABLE TO ASSIST YOU WITHOUT THIS INFORMATION!!!

	print('The bill add failed, and here is why:');

	print('ERROR: ' . $BillService->lastError());
	print('<br><br>');
	print('REQUEST: <code>' . htmlspecialchars($BillService->lastRequest()) . '</code><br><br><br>');
	print('RESPONSE: <code>' . htmlspecialchars($BillService->lastResponse()) . '</code><br><br><br>');
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