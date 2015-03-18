<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php
	
$BillService = new QuickBooks_IPP_Service_Bill();

$Bill = new QuickBooks_IPP_Object_Bill();

$Bill->setDocNumber('abc123');
$Bill->setTxnDate('2014-07-12');
$Bill->setVendorRef('{-9}');

$Line = new QuickBooks_IPP_Object_Line();
$Line->setAmount(650);
$Line->setDetailType('AccountBasedExpenseLineDetail');

$AccountBasedExpenseLineDetail = new QuickBooks_IPP_Object_AccountBasedExpenseLineDetail();
$AccountBasedExpenseLineDetail->setAccountRef('{-17}');

$Line->setAccountBasedExpenseLineDetail($AccountBasedExpenseLineDetail);

$Bill->addLine($Line);

if ($id = $BillService->add($Context, $realm, $Bill))
{
	print('New bill id is: ' . $id);
}
else
{
	print('Bill add failed...? ' . $BillService->lastError());
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