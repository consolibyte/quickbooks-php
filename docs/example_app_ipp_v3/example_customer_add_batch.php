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
	
	// Get the Batch request service instance
	$IntuitBatchRequestService = new QuickBooks_IPP_Service_IntuitBatchRequest();
	
	// Get the Batch request object instance
	$IntuitBatchRequest = new QuickBooks_IPP_Object_IntuitBatchRequest();

	// Batch item 1
	// Get the Batch Item Request object instance
	$BatchItemRequest = new QuickBooks_IPP_Object_BatchItemRequest();
	// This one should be unique for each item request
	$BatchItemRequest->setBatchId("00001");
//	$BatchItemRequest->setBatchOperation("Delete");
	
	$Customer = new QuickBooks_IPP_Object_Customer();
	$Customer->setTitle('Mr');
	$Customer->setGivenName('Muhammad Waseem');
	$Customer->setFamilyName('Riaz');
	$Customer->setDisplayName('Muhammad Waseem Riaz ' . mt_rand(0, 1000));
	
	// Bill address
	$BillAddr = new QuickBooks_IPP_Object_BillAddr();
	$BillAddr->setLine1('72 E Blue Grass Road');
	$BillAddr->setLine2('Suite D');
	$BillAddr->setCity('Mt Pleasant');
	$BillAddr->setCountrySubDivisionCode('MI');
	$BillAddr->setPostalCode('48858');
	$Customer->setBillAddr($BillAddr);
	
	// Email
	$PrimaryEmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
	$PrimaryEmailAddr->setAddress('support@consolibyte.com');
	$Customer->setPrimaryEmailAddr($PrimaryEmailAddr);
	// Add customer to batch item
	$BatchItemRequest->addCustomer($Customer);
	// Add batch item to batch request
	$IntuitBatchRequest->addBatchItemRequest($BatchItemRequest);

	// Batch item 2
	// Get the Batch Item Request object instance
	$BatchItemRequest = new QuickBooks_IPP_Object_BatchItemRequest();
	// This one should be unique for each item request
	$BatchItemRequest->setBatchId("00002");
	
	$Customer = new QuickBooks_IPP_Object_Customer();
	$Customer->setTitle('Mr');
	$Customer->setGivenName('Muhammad Waseem');
	$Customer->setFamilyName('Riaz');
	$Customer->setDisplayName('Muhammad Waseem Riaz ' . mt_rand(0, 1000));
	
	// Bill address
	$BillAddr = new QuickBooks_IPP_Object_BillAddr();
	$BillAddr->setLine1('72 E Blue Grass Road');
	$BillAddr->setLine2('Suite D');
	$BillAddr->setCity('Mt Pleasant');
	$BillAddr->setCountrySubDivisionCode('MI');
	$BillAddr->setPostalCode('48858');
	$Customer->setBillAddr($BillAddr);
	
	// Email
	$PrimaryEmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
	$PrimaryEmailAddr->setAddress('support@consolibyte.com');
	$Customer->setPrimaryEmailAddr($PrimaryEmailAddr);
	// Add customer to batch item
	$BatchItemRequest->addCustomer($Customer);
	// Add batch item to batch request
	$IntuitBatchRequest->addBatchItemRequest($BatchItemRequest);

	// more can be added upto a maximum of 25 items.

	if ($resp = $IntuitBatchRequestService->sendRequest($Context, $realm, $IntuitBatchRequest))
	{
		print_r($resp);
	}
	else
	{
		print($CustomerService->lastError($Context));
	}

/*	
	print('<br /><br /><br /><br /><br />');
	print('<hr />');
	print('Request');
	print('<hr />');
	print('[' . $IPP->lastRequest() . ']');
	print('<hr />');
	print('<br /><br /><br /><br /><br />');
	print('Response');
	print('<hr />');
	print('[' . $IPP->lastResponse() . ']');
	print('<hr />');
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
