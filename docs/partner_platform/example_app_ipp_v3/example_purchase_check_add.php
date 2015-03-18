<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$PurchaseService = new QuickBooks_IPP_Service_Purchase();

// Create our Purchase
$Purchase = new QuickBooks_IPP_Object_Purchase();

$Line = new QuickBooks_IPP_Object_Line();
$Line->setDescription('Test description');
$Line->setAmount(29.95);
$Line->setDetailType('AccountBasedExpenseLineDetail');

$AccountBasedExpenseLineDetail = new QuickBooks_IPP_Object_AccountBasedExpenseLineDetail();
$AccountBasedExpenseLineDetail->setAccountRef('{-9}');
$AccountBasedExpenseLineDetail->setBillableStatus('NotBillable');

$Line->setAccountBasedExpenseLineDetail($AccountBasedExpenseLineDetail);

$Purchase->addLine($Line);

$Purchase->setAccountRef('{-58}');
$Purchase->setEntityRef('{-137}');
$Purchase->setPaymentType('Check');

/*
  <Line>
    <Id>1</Id>
    <Description>this is line 1</Description>
    <Amount>10.00</Amount>
    <DetailType>AccountBasedExpenseLineDetail</DetailType>
    <AccountBasedExpenseLineDetail>
      <AccountRef name="Cash Over and Short">65</AccountRef>
      <BillableStatus>NotBillable</BillableStatus>
      <TaxCodeRef>3</TaxCodeRef>
    </AccountBasedExpenseLineDetail>
  </Line>
  <AccountRef name="Test Purchase Bank Account">61</AccountRef>
  <PaymentType>Cash</PaymentType>
  <EntityRef name="Mr V3 Service Customer Jr2">1</EntityRef>
  <TotalAmt>11.00</TotalAmt>
  <GlobalTaxCalculation>TaxInclusive</GlobalTaxCalculation>
*/

if ($id = $PurchaseService->add($Context, $realm, $Purchase))
{
	print('New purchase check id is: ' . $id);
}
else
{
	print('Error creating check: ' . $IPP->lastError($Context) . '');
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