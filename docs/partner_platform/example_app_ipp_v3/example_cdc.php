<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$CDCService = new QuickBooks_IPP_Service_ChangeDataCapture();

// What types of objects do you want to get? 
$objects = array( 
	'Customer', 
	'Invoice', 
	);

// The date they should have been updated after 
$timestamp = QuickBooks_Utilities::datetime('-5 years');

$cdc = $CDCService->cdc($Context, $realm, 
	$objects,
	$timestamp);

print('<h2>Here are the ' . implode(', ', $objects) . ' that have changed since ' . $timestamp . '</h2>');

foreach ($cdc as $object_type => $list)
{
	print('<h3>Now showing ' . $object_type . 's</h3>');

	foreach ($list as $Object)
	{
		switch ($object_type)
		{
			case 'Customer':
				print(' &nbsp; ' . $Object->getFullyQualifiedName() . '<br>');
				break;
			case 'Invoice':
				print(' &nbsp; ' . $Object->getDocNumber() . '<br>');
				break;
			default:
				print(' &nbsp; ' . $Object->getId() . '<br>');
				break;
		}
	}
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