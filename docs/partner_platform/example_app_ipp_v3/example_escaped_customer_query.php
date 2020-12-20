<?php

require_once dirname(__FILE__) . '/config_oauthv2.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php
	
$CustomerService = new QuickBooks_IPP_Service_Customer();

$customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE FullyQualifiedName LIKE '%Keith O\'Mally%' ");

//print_r($customers);

foreach ($customers as $Customer)
{
	print('Customer Id=' . $Customer->getId() . ' is named: ' . $Customer->getFullyQualifiedName() . '<br>');
}

print("\n\n\n\n");
print('Request [' . $CustomerService->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $CustomerService->lastResponse() . ']');
print("\n\n\n\n");
	
?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>