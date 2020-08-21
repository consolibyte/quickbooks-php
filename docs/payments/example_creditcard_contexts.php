<?php

/**
 * Example illustrating different credit card "contexts" (mobile, e-commerce, recurring payment indicators, etc.)
 *
 * See also: https://developer.intuit.com/docs/api/payments/charges
 *
 * Specifically the section that talks about: 
 * 
 * mobile:
 * required
 * boolean, default is false 
 * Indicates whether the charge occurs on a mobile device. The card number can be keyed/swiped/dipped or tapped on the mPOS device of the merchant.
 * 
 * isEcommerce:
 * optional
 * boolean, default is false 
 * Indicates whether the charge is from an eCommerce (internet) transaction.
 * 
 * recurring:
 * optional
 * boolean, default is false 
 * This boolean value is set to true if the charge is recurring. This value ignored for capture and refund requests.
 *
 *
 * Intuit has made some security changes as of early Feb 1, 2018 which require that merchants 
 * indicate the "context" of a transaction (e.g. if it's recurring, if it's from a mobile device, etc.)
 *
 * Other helpful links:
 * 	https://stackoverflow.com/questions/4117555/simplest-way-to-detect-a-mobile-device
 * 	https://stackoverflow.com/questions/3514784/what-is-the-best-way-to-detect-a-mobile-device-in-jquery
 * 
 */

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
$postalcode = '48858';

$amount = 50;
$currency = 'USD';

$Payments = new QuickBooks_Payments($oauth_consumer_key, $oauth_consumer_secret, $sandbox);

$CreditCard = new QuickBooks_Payments_CreditCard($name, $number, $expyear, $expmonth, $street, $city, $region, $postalcode);

$context = array(

	// This indicates that it is a payment made from a MOBILE DEVICE (phone, tablet, etc.)
	'mobile' => true,       // defaults to FALSE

	// This indicates that it is a RECURRING payment
	'recurring' => true,    // defaults to FALSE

	// This indicates it's an e-commerce payment (made online)
	'isEcommerce' => true,  // defaults to FALSE 
	);

if ($Transaction = $Payments->charge($Context, $CreditCard, $amount, $currency, $context))
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
