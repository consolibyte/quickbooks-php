<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$name = 'Keith Palmer';
$number = '856666';
$routing = '072403004';
$type = QuickBooks_Payments_BankAccount::TYPE_PERSONAL_CHECKING;
$phone = '860-634-1602';

$amount = 50;
$currency = 'USD';

$Payments = new QuickBooks_Payments($oauth_consumer_key, $oauth_consumer_secret, $sandbox);

$BankAccount = new QuickBooks_Payments_BankAccount($name, $number, $routing, $type, $phone);

if ($Transaction = $Payments->debit($Context, $BankAccount, $amount, $currency))
{
	//print_r($Transaction);

	print_r($Transaction);
}
else
{
	print('Error while debiting a bank account: ' . $Payments->lastError());
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
