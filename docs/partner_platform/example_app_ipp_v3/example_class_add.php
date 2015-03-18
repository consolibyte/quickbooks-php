<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$ClassService = new QuickBooks_IPP_Service_Class();

$Class = new QuickBooks_IPP_Object_Class();

$Class->setName('My Class');

if ($resp = $ClassService->add($Context, $realm, $Class))
{
	print('Our new class ID is: [' . $resp . ']');
}
else
{
	print($ClassService->lastError());
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
