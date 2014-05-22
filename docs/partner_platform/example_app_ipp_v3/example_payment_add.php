<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

// Set up the IPP instance
$IPP = new QuickBooks_IPP($dsn);

// Get our OAuth credentials from the database
$creds = $IntuitAnywhere->load($the_username, $the_tenant);

// Tell the framework to load some data from the OAuth store
$IPP->authMode(
	QuickBooks_IPP::AUTHMODE_OAUTH, 
	$the_username, 
	$creds);

// Print the credentials we're using
//print_r($creds);

// This is our current realm
$realm = $creds['qb_realm'];

// Load the OAuth information from the database
if ($Context = $IPP->context())
{
	// Set the IPP version to v3 
	$IPP->version(QuickBooks_IPP_IDS::VERSION_3);
	
	$PaymentService = new QuickBooks_IPP_Service_Payment();
	
	// Create payment object
	$Payment = new QuickBooks_IPP_Object_Payment();
	
	$Payment->setPaymentRefNum('WEB123');
	$Payment->setTxnDate('2014-02-11');
	$Payment->setTotalAmt(10);
	
	// Create line for payment (this details what it's applied to)
	$Line = new QuickBooks_IPP_Object_Line();
	$Line->setAmount(10);
	
	// The line has a LinkedTxn node which links to the actual invoice
	$LinkedTxn = new QuickBooks_IPP_Object_LinkedTxn();
	$LinkedTxn->setTxnId('{-84}');
	$LinkedTxn->setTxnType('Invoice');

	$Line->setLinkedTxn($LinkedTxn);

	$Payment->addLine($Line);

	$Payment->setCustomerRef('{-67}');

	// Send payment to QBO 
	if ($resp = $PaymentService->add($Context, $realm, $Payment))
	{
		print('Our new Payment ID is: [' . $resp . ']');
	}
	else
	{
		print($PaymentService->lastError());
	}

	/*
	print('<br><br><br><br>');
	print("\n\n\n\n\n\n\n\n");
	print('Request [' . $IPP->lastRequest() . ']');
	print("\n\n\n\n");
	print('Response [' . $IPP->lastResponse() . ']');
	print("\n\n\n\n\n\n\n\n\n");
	*/	
}
else
{
	die('Unable to load a context...?');
}


?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';
