<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

    <pre>

<?php
$DepositService = new \QuickBooks_IPP_Service_Deposit();

// Create deposit object
$Deposit = new \QuickBooks_IPP_Object_Deposit();

// Create line for deposit (this details what it's applied to)
$Line = new \QuickBooks_IPP_Object_Line();
$Line->setAmount(100);
$Line->setDetailType('DepositLineDetail');
$DepositLineDetail = new \QuickBooks_IPP_Object_DepositLineDetail();
$DepositLineDetail->setEntity(10);
$DepositLineDetail->setAccountRef(87);
$Line->setDepositLineDetail($DepositLineDetail);

$Deposit->addLine($Line);
$Deposit->setGlobalTaxCalculation('NotApplicable');
$Deposit->setDepositToAccountRef('{-87}');


// Send payment to QBO

if ($resp = $DepositService->add($Context, $realm, $Deposit))
{
    print('Our new Deposit ID is: [' . $resp . ']');
}
else
{
    print($DepositService->lastError());
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
