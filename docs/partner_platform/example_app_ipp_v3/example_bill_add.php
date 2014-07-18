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
	
	$BillService = new QuickBooks_IPP_Service_Bill();
	
	$Bill = new QuickBooks_IPP_Object_Bill();

	$Bill->setDocNumber('abc123');
	$Bill->setTxnDate('2014-07-12');
	$Bill->setVendorRef('{-9}');

	$Line = new QuickBooks_IPP_Object_Line();
	$Line->setAmount(650);
	$Line->setDetailType('AccountBasedExpenseLineDetail');

	$AccountBasedExpenseLineDetail = new QuickBooks_IPP_Object_AccountBasedExpenseLineDetail();
	$AccountBasedExpenseLineDetail->setAccountRef('{-17}');

	$Line->setAccountBasedExpenseLineDetail($AccountBasedExpenseLineDetail);

	$Bill->addLine($Line);

	if ($id = $BillService->add($Context, $realm, $Bill))
	{
		print('New bill id is: ' . $id);
	}
	else
	{
		print('Bill add failed...? ' . $BillService->lastError());
	}

	/*
	print("\n\n\n\n");
	print('Request [' . $IPP->lastRequest() . ']');
	print("\n\n\n\n");
	print('Response [' . $IPP->lastResponse() . ']');
	print("\n\n\n\n");
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

?>