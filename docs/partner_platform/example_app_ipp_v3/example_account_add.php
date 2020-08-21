<?php

require_once dirname(__FILE__) . '/config_oauthv2.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$AccountService = new QuickBooks_IPP_Service_Account();

$Account = new QuickBooks_IPP_Object_Account();

$Account->setName('My Test Name');
$Account->setDescription('Here is my description');
$Account->setAccountType('Income');

if ($resp = $AccountService->add($Context, $realm, $Account))
{
	print('Our new Account ID is: [' . $resp . ']');
}
else
{
	print($AccountService->lastError());
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
