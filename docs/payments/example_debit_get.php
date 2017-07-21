<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

/*
{
  "id": "aiztnxsv",
  "authCode": "839-426",
  "created": "2016-09-11T14:08:41Z",
  "status": "DECLINED",
  "amount": "4655.00",
  "bankAccount": {
    "name": "JOHN DOE",
    "routingNumber": "xxxxx0417",
    "accountNumber": "xxxxx6399",
    "accountType": "PERSONAL_CHECKING",
    "phone": "8606568824",
    "inputType": "KEYED"
  },
  "paymentMode": "WEB"
}
 */

$id = 'aiztnxsv';

$Payments = new QuickBooks_Payments($oauth_consumer_key, $oauth_consumer_secret, $sandbox);

if ($Transaction = $Payments->getDebit($Context, $id))
{
	print('Id: ' . $Transaction->getId() . '<br>');
	print('Auth Code: ' . $Transaction->getAuthCode() . '<br>');
	print('Status: ' . $Transaction->getStatus() . '<br>');
}
else
{
	print('Error while getting eCheck/debit: ' . $Payments->lastResponse());
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
