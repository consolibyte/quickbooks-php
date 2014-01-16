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
	$ItemService = new QuickBooks_IPP_Service_Item();
	
	$invoices = $InvoiceService->query($Context, $realm, "SELECT *, Line.* FROM Invoice STARTPOSITION 1 MAXRESULTS 5");

	//print_r($customers);
	
	foreach ($invoices as $Invoice)
	{
		$num_lines = $Invoice->countLine(); 		// How many line items are there?
		for ($i = 0; $i < $num_lines; $i++)
		{
			$Line = $Invoice->getLine(0);
			
			// Let's find out what item this uses
			if ($Line->getDetailType() == 'SalesItemLineDetail')
			{
				$Detail = $Line->getSalesItemLineDetail();

				$item_id = $Detail->getItemRef();

				print('Item id is: ' . $item_id . "\n");

				$items = $ItemService->query($Context, $realm, "SELECT * FROM Item WHERE Id = '" . QuickBooks_IPP_IDS::usableIDType($item_id) . "' ");
				print('   That item is named: ' . $items[0]->getName() . "\n");
			}
		}

		print("\n\n\n");
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