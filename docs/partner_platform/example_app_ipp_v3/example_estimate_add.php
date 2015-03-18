<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$EstimateService = new QuickBooks_IPP_Service_Estimate();

$Estimate = new QuickBooks_IPP_Object_Estimate();

$Estimate->setDocNumber('WEB123');
$Estimate->setTxnDate('2013-10-11');

$Line = new QuickBooks_IPP_Object_Line();
$Line->setDetailType('SalesItemLineDetail');
$Line->setAmount(12.95 * 2);

$SalesItemLineDetail = new QuickBooks_IPP_Object_SalesItemLineDetail();
$SalesItemLineDetail->setItemRef('8');
$SalesItemLineDetail->setUnitPrice(12.95);
$SalesItemLineDetail->setQty(2);

$Line->addSalesItemLineDetail($SalesItemLineDetail);

$Estimate->addLine($Line);

$Estimate->setCustomerRef('67');


if ($resp = $EstimateService->add($Context, $realm, $Estimate))
{
	print('Our new Estimate ID is: [' . $resp . ']');
}
else
{
	print($EstimateService->lastError());
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
