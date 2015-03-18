<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

// Jobs are really just Customers, so we can use the CustomerService and Customer query methods to do this 
$CustomerService = new QuickBooks_IPP_Service_Customer();

// Get all jobs that have a parent customer "Derrick Huckleberry"
$jobs = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE FullyQualifiedName LIKE 'Derrick Huckleberry:%' ");

//print_r($customers);

foreach ($jobs as $Job)
{
	print('Job Id=' . $Job->getId() . ' is named: ' . $Job->getFullyQualifiedName() . '<br>');
}

/*
print("\n\n\n\n");
print('Request [' . $CustomerService->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $CustomerService->lastResponse() . ']');
print("\n\n\n\n");
*/

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>