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
	
	$InvoiceService = new QuickBooks_IPP_Service_Invoice();
	
	$Invoice = new QuickBooks_IPP_Object_Invoice();
	
	$Invoice->setDocNumber('WEB' . mt_rand(0, 10000));
	$Invoice->setTxnDate('2013-10-11');
	
	$Line = new QuickBooks_IPP_Object_Line();
	$Line->setDetailType('SalesItemLineDetail');
	$Line->setAmount(12.95 * 2);
	$Line->setDescription('Test description goes here.');

	$SalesItemLineDetail = new QuickBooks_IPP_Object_SalesItemLineDetail();
	$SalesItemLineDetail->setItemRef('8');
	$SalesItemLineDetail->setUnitPrice(12.95);
	$SalesItemLineDetail->setQty(2);

	$Line->addSalesItemLineDetail($SalesItemLineDetail);

	$Invoice->addLine($Line);

	$Invoice->setCustomerRef('67');
	

	if ($resp = $InvoiceService->add($Context, $realm, $Invoice))
	{
		print('Our new Invoice ID is: [' . $resp . ']');
	}
	else
	{
		print($InvoiceService->lastError());
	}

	print('<br><br><br><br>');
	print("\n\n\n\n\n\n\n\n");
	print('Request [' . $IPP->lastRequest() . ']');
	print("\n\n\n\n");
	print('Response [' . $IPP->lastResponse() . ']');
	print("\n\n\n\n\n\n\n\n\n");
	
}
else
{
	die('Unable to load a context...?');
}


?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';
