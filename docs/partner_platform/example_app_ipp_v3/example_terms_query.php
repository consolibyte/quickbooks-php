<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$TermService = new QuickBooks_IPP_Service_Term();

$terms = $TermService->query($Context, $realm, "SELECT * FROM Term");

//print_r($terms);

foreach ($terms as $Term)
{
	//print_r($Term);

	print('Term Id=' . $Term->getId() . ' is named: ' . $Term->getName() . '<br>');
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