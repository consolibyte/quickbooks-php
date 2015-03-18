<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$CustomerService = new QuickBooks_IPP_Service_Customer();

// Get the existing customer first (you need the latest SyncToken value)
$customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE Id = '34' ");
$Customer = $customers[0];

// Change something
$Customer->setDisplayName('Updated ' . date('Y-m-d H-i-s'));

// Update their email address too
$PrimaryEmailAddr = $Customer->getPrimaryEmailAddr();
$PrimaryEmailAddr->setAddress('support@consolibyte.com');

// What are we doing?
print('Updating the customer name to: ' . $Customer->getDisplayName() . '<br>');

if ($CustomerService->update($Context, $realm, $Customer->getId(), $Customer))
{
	print('&nbsp; Updated!<br>');
}
else
{
	print('&nbsp; Error: ' . $CustomerService->lastError($Context));
}

/*
print('<br><br><br><br>');
print("\n\n\n\n\n\n\n\n");
print('Request [' . $IPP->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $IPP->lastResponse() . ']');
print("\n\n\n\n\n\n\n\n\n");
*/

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';
