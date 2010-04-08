<?php

require_once '../../QuickBooks.php';

$out = QuickBooks_Utilities::actionToObject('VendorCreditAdd');

print("\n\n" . $out . "\n\n");

//$out = QuickBooks_Utilities::actionToObject('VendorAdd');

//print("\n\n" . $out . "\n\n");

$list = QuickBooks_Utilities::listObjects(null, true);
foreach ($list as $key => $value)
{
	print($value . ' => ' . str_pad(constant($value), 32, ' ', STR_PAD_LEFT) . "\n");
}

$out = QuickBooks_Utilities::actionToObject('ItemServiceAdd');

print("\n\n" . $out . "\n\n");



$xml = '<ItemServiceRet><ListID>1234</ListID><Name>Keith Palmer</Name></ItemServiceRet>';

$Customer = QuickBooks_Object::fromQBXML($xml);

print_r($Customer);