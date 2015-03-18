<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$AccountService = new QuickBooks_IPP_Service_Account();

$accounts = $AccountService->query($Context, $realm, "SELECT * FROM Account");

//print_r($customers);

foreach ($accounts as $Account)
{
	print('Account Id=' . $Account->getId() . ' is named: ' . $Account->getFullyQualifiedName() . '<br>');
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