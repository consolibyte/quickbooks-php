<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php
	
$ClassService = new QuickBooks_IPP_Service_Class();

$classes = $ClassService->query($Context, $realm, "SELECT * FROM Class");

print_r($classes);

foreach ($classes as $Class)
{
	print('Class Id=' . $Class->getId() . ' is named: ' . $Class->getName() . '<br>');
}


print("\n\n\n\n");
print('Request [' . $ClassService->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $ClassService->lastResponse() . ']');
print("\n\n\n\n");
	
?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>