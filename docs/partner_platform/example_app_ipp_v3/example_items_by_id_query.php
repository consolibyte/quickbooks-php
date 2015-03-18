<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$ItemService = new QuickBooks_IPP_Service_Term();

$items = $ItemService->query($Context, $realm, "SELECT * FROM Item WHERE Id = '3' ");

foreach ($items as $Item)
{
	//print_r($Item);

	print('Item Id=' . $Item->getId() . ' is named: ' . $Item->getName() . '<br>');
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