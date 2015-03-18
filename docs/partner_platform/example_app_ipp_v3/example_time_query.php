<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php
	
$TimeActivityService = new QuickBooks_IPP_Service_TimeActivity();

$time = $TimeActivityService->query($Context, $realm, "SELECT * FROM TimeActivity  ");

print_r($time);

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';
