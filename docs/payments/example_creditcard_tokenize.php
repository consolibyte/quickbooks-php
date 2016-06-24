<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$number = '4111 1111 1111 1111';
$name = 'Keith Palmer';
$expyear = 2020;
$expmonth = 10;
$street = '72 E Blue Grass Road';
$city = 'Mt Pleasant';
$region = 'MI';

$Payments = new QuickBooks_Payments($oauth_consumer_key, $oauth_consumer_secret, $sandbox);

$CreditCard = new QuickBooks_Payments_CreditCard($name, $number, $expyear, $expmonth, $street, $city, $region);

if ($Token = $Payments->tokenize($Context, $CreditCard))
{
	print_r($Token);
}
else
{
	print('Error while tokenizing payment: ' . $Payments->lastResponse());
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
