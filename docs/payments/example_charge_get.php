<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$id = 'EY32QCYC6RTX';

$Payments = new QuickBooks_Payments($oauth_consumer_key, $oauth_consumer_secret, $sandbox);

if ($Transaction = $Payments->getCharge($Context, $id))
{
	print('Id: ' . $Transaction->getId() . '<br>');
	print('Auth Code: ' . $Transaction->getAuthCode() . '<br>');
	print('Status: ' . $Transaction->getStatus() . '<br>');
}
else
{
	print('Error while getting charge: ' . $Payments->lastResponse());
}

print('<br><br><br><br>');
print("\n\n\n\n\n\n\n\n");
print('Request [' . $Payments->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $Payments->lastResponse() . ']');
print("\n\n\n\n\n\n\n\n\n");

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';
