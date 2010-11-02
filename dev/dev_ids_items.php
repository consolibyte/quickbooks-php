<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

// 
$username = '';
$password = '';
$token = '';
$realmID = 0;

// 
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);

/*
print("\n\n");
print($IPP->lastRequest());
print("\n\n");
print($IPP->lastResponse());
print("\n\n");
*/

//exit;

$IPP->application($Context, '');

$IPP->useIDSParser(false);

$Service = new QuickBooks_IPP_Service_ItemConsolidated();

$list = $Service->rawQuery($Context, $realmID, '<?xml version="1.0" encoding="UTF-16"?>
<ItemConsolidatedQuery xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://www.intuit.com/sb/cdm/v2">
	<NameContains>ish</NameContains>
</ItemConsolidatedQuery>');

print("\n\n");
print($IPP->lastRequest());
print("\n\n");
print($IPP->lastResponse());
print("\n\n");

print("\n\n\n\n");

$Service = new QuickBooks_IPP_Service_Item();

$list = $Service->rawQuery($Context, $realmID, '<?xml version="1.0" encoding="UTF-16"?>
<ItemQuery xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://www.intuit.com/sb/cdm/v2">
</ItemQuery>');

print("\n\n");
print($IPP->lastRequest());
print("\n\n");
print($IPP->lastResponse());
print("\n\n");

print("\n\n\n\n");
