<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$ItemService = new QuickBooks_IPP_Service_Item();

// Get the existing item 
$items = $ItemService->query($Context, $realm, "SELECT * FROM Item WHERE Id = '2' ");
$Item = $items[0];

// Update the name of the item
$Item->setName($Item->getName() . ' ' . mt_rand(0, 1000));

if ($resp = $ItemService->update($Context, $realm, $Item->getId(), $Item))
{
	print('Updated the item name to ' . $Item->getName());
}
else
{
	print('ERROR!');
	print($ItemService->lastError($Context));
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
