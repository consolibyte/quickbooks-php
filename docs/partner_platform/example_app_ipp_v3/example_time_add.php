<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$TimeActivityService = new QuickBooks_IPP_Service_TimeActivity();

$TimeActivity = new QuickBooks_IPP_Object_TimeActivity();
$TimeActivity->setTxnDate('2013-10-10');
$TimeActivity->setNameOf('Vendor');
$TimeActivity->setVendorRef('89');
$TimeActivity->setItemRef('8');
$TimeActivity->setHourlyRate('250');
$TimeActivity->setStartTime(QuickBooks_Utilities::datetime('-5 hours'));
$TimeActivity->setEndTime(QuickBooks_Utilities::datetime('-1 hour'));
$TimeActivity->setDescription('Test entry.');

if ($resp = $TimeActivityService->add($Context, $realm, $TimeActivity))
{
	print('Our new TimeActivity ID is: [' . $resp . ']');
}
else
{
	print($TimeActivityService->lastError($Context));
}

print('<br><br><br><br>');
print("\n\n\n\n\n\n\n\n");
print('Request [' . $IPP->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $IPP->lastResponse() . ']');
print("\n\n\n\n\n\n\n\n\n");
	
?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';
