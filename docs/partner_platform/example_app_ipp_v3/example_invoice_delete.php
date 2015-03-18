<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$InvoiceService = new QuickBooks_IPP_Service_Invoice();

$the_invoice_to_delete = '{-10}';

$retr = $InvoiceService->delete($Context, $realm, $the_invoice_to_delete);
if ($retr)
{
	print('The invoice was deleted!');
}
else
{
	print('Could not delete invoice: ' . $InvoiceService->lastError());
}

/*
// For debugging 

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