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
	
	// Jobs are really just Customers, so we can use the CustomerService and Customer query methods to do this 
	$CustomerService = new QuickBooks_IPP_Service_Customer();
	
	// Get all jobs that have a parent customer "Derrick Huckleberry"
	$jobs = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE FullyQualifiedName LIKE 'Derrick Huckleberry:%' ");

	//print_r($customers);
	
	foreach ($jobs as $Job)
	{
		print('Job Id=' . $Job->getId() . ' is named: ' . $Job->getFullyQualifiedName() . '<br>');
	}

	/*
	print("\n\n\n\n");
	print('Request [' . $CustomerService->lastRequest() . ']');
	print("\n\n\n\n");
	print('Response [' . $CustomerService->lastResponse() . ']');
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