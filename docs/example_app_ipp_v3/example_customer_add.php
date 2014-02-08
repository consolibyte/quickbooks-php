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
	
	$CustomerService = new QuickBooks_IPP_Service_Customer();
	
	$Customer = new QuickBooks_IPP_Object_Customer();
	$Customer->setTitle('Ms');
	$Customer->setGivenName('Shannon');
	$Customer->setMiddleName('B');
	$Customer->setFamilyName('Palmer');
	$Customer->setDisplayName('Shannon B Palmer ' . mt_rand(0, 1000));

	// Terms (e.g. Net 30, etc.)
	$Customer->setSalesTermRef(4);
	
	// Phone #
	$PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
	$PrimaryPhone->setFreeFormNumber('860-532-0089');
	$Customer->setPrimaryPhone($PrimaryPhone);

	// Mobile #
	$Mobile = new QuickBooks_IPP_Object_Mobile();
	$Mobile->setFreeFormNumber('860-532-0089');
	$Customer->setMobile($Mobile);
    
    // Fax #
	$Fax = new QuickBooks_IPP_Object_Fax();
	$Fax->setFreeFormNumber('860-532-0089');
	$Customer->setFax($Fax);

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

	if ($resp = $CustomerService->add($Context, $realm, $Customer))
	{
		print('Our new customer ID is: [' . $resp . '] (name "' . $Customer->getDisplayName() . '")');
	}
	else
	{
		print($CustomerService->lastError($Context));
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
