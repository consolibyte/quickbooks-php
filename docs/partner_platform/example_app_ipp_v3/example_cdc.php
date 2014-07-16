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
	
	$CDCService = new QuickBooks_IPP_Service_ChangeDataCapture();
	
	// What types of objects do you want to get? 
	$objects = array( 
		'Customer', 
		'Invoice', 
		);

	// The date they should have been updated after 
	$timestamp = QuickBooks_Utilities::datetime('-5 years');

	$cdc = $CDCService->cdc($Context, $realm, 
		$objects,
		$timestamp);

	print('<h2>Here are the ' . implode(', ', $objects) . ' that have changed since ' . $timestamp . '</h2>');

	foreach ($cdc as $object_type => $list)
	{
		print('<h3>Now showing ' . $object_type . 's</h3>');

		foreach ($list as $Object)
		{
			switch ($object_type)
			{
				case 'Customer':
					print(' &nbsp; ' . $Object->getFullyQualifiedName() . '<br>');
					break;
				case 'Invoice':
					print(' &nbsp; ' . $Object->getDocNumber() . '<br>');
					break;
				default:
					print(' &nbsp; ' . $Object->getId() . '<br>');
					break;
			}
		}
	}

	
	print("\n\n\n\n");
	print('Request [' . $IPP->lastRequest() . ']');
	print("\n\n\n\n");
	print('Response [' . $IPP->lastResponse() . ']');
	print("\n\n\n\n");
	
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