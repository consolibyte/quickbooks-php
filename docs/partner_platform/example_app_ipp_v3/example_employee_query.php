<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$EmployeeService = new QuickBooks_IPP_Service_Employee();

$employees = $EmployeeService->query($Context, $realm, "SELECT * FROM Employee ");

//print_r($customers);

foreach ($employees as $Employee)
{
	print('Employee id=' . $Employee->getId() . ' has a name of ' . $Employee->getGivenName() . ' ' . $Employee->getFamilyName() . "\n");
	
}


print("\n\n\n\n");
print('Request [' . $IPP->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $IPP->lastResponse() . ']');
print("\n\n\n\n");

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>