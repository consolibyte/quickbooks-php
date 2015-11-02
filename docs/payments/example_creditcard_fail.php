<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

// THIS IS NOT A VALID CREDIT CARD NUMBER, SO IT SHOULD FAIL!
$number = '4111 1234 1234 1234';    
// 

$name = 'Keith Palmer';
$expyear = 2020;
$expmonth = 10;
$street = '72 E Blue Grass Road';
$city = 'Mt Pleasant';
$region = 'MI';
$postalcode = '48858';

$amount = 50;
$currency = 'USD';

$Payments = new QuickBooks_Payments($oauth_consumer_key, $oauth_consumer_secret, $sandbox);

$CreditCard = new QuickBooks_Payments_CreditCard($name, $number, $expyear, $expmonth, $street, $city, $region, $postalcode);

if ($Transaction = $Payments->charge($Context, $CreditCard, $amount, $currency))
{
	//print_r($Transaction);

	print('Id: ' . $Transaction->getId() . '<br>');
	print('Auth Code: ' . $Transaction->getAuthCode() . '<br>');
	print('Status: ' . $Transaction->getStatus() . '<br>');
}
else
{
	print('Error while charging credit card: ' . $Payments->lastError());
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
