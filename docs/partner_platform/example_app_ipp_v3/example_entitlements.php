<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$EntitlementsService = new QuickBooks_IPP_Service_Entitlements();

$es = $EntitlementsService->entitlements($Context, $realm);

print_r($es);

print($EntitlementsService->lastRequest($Context));
print($EntitlementsService->lastResponse($Context));

print('ERROR: ');
print($EntitlementsService->lastError($Context));

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>