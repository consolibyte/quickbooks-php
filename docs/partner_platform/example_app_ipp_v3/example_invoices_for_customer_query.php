<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$CustomerService = new QuickBooks_IPP_Service_Customer();
$InvoiceService = new QuickBooks_IPP_Service_Invoice();

$customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE FamilyName = 'Palmer' ");

//print_r($customers);

if (count($customers))
{
	foreach ($customers as $Customer)
	{
		print('Customer Id=' . $Customer->getId() . ' is named: ' . $Customer->getFullyQualifiedName() . '<br>');

		$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice WHERE CustomerRef = '" . QuickBooks_IPP_IDS::usableIDType($Customer->getId()) . "' ");

		/*
		print("\n\n\n\n");
		print('Request [' . $IPP->lastRequest() . ']');
		print("\n\n\n\n");
		print('Response [' . $IPP->lastResponse() . ']');
		print("\n\n\n\n");
		exit;
		*/
		
		if (count($invoices))
		{
			foreach ($invoices as $Invoice)
			{
				print(' &nbsp; &nbsp; Invoice #' . $Invoice->getDocNumber() . ' on date ' . $Invoice->getTxnDate() . '<br>');
			}
		}
		else
		{
			print(' &nbsp; &nbsp; This customer has no invoices.<br>');
		}
	}
}
else
{
	print('There are no customers with a last name (family name) of "Palmer" ');
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