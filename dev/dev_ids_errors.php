<?php


ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

// 
$username = 'keith@consolibyte.com';
$password = 'password42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';
$realmID = 173642438;

// 
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);
$IPP->application($Context, 'be9mh7qd5');

$IPP->useIDSParser(false);

$CustomerService = new QuickBooks_IPP_Service_Customer();
$CheckService = new QuickBooks_IPP_Service_Check();
$InvoiceService = new QuickBooks_IPP_Service_Invoice();
$EstimateService = new QuickBooks_IPP_Service_Estimate();



// 4791075
// 4792532
// 4792533


$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<Del RequestId="' . md5(microtime()) . '" xmlns="http://www.intuit.com/sb/cdm/v2">
   <Object xsi:type="Check"
   xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <Id idDomain="NG">4800355</Id>
      </Object>
</Del>';

$response = $CheckService->rawQuery($Context, $realmID, $xml);
print($CheckService->lastRequest($Context));
print("\n\n");
print($response);

exit;



/*
$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<CustomerQuery xmlns="http://www.intuit.com/sb/cdm/v2">
	<SynchronizedFilter>NotSynchronized</SynchronizedFilter>
</CustomerQuery>';



$response = $CustomerService->rawQuery($Context, $realmID, $xml);
print($CustomerService->lastRequest($Context));
print("\n\n");
print($CheckService->lastResponse($Context));


print("\n\n\n\n\n");

exit;
*/



$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<CheckQuery ErroredObjectsOnly="true" xmlns="http://www.intuit.com/sb/cdm/v2">
</CheckQuery>';

$list = $CheckService->rawQuery($Context, $realmID, $xml);
print($CheckService->lastRequest($Context));
print("\n\n\n\n\n");
print($CheckService->lastResponse($Context));

exit;



/*
$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<CheckQuery xmlns="http://www.intuit.com/sb/cdm/v2">
	<SynchronizedFilter>NotSynchronized</SynchronizedFilter>
</CheckQuery>';

$response = $CheckService->rawQuery($Context, $realmID, $xml);
print($CheckService->lastRequest($Context));
print("\n\n");
//print($response);
print($CheckService->lastResponse());

exit;
*/




$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<EstimateQuery ErroredObjectsOnly="true" xmlns="http://www.intuit.com/sb/cdm/v2">
</EstimateQuery>';

$response = $EstimateService->rawQuery($Context, $realmID, $xml);
print($EstimateService->lastRequest($Context));
print("\n\n");
print($response);

exit;





$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<InvoiceQuery ErroredObjectsOnly="true" xmlns="http://www.intuit.com/sb/cdm/v2">
</InvoiceQuery>';

$response = $InvoiceService->rawQuery($Context, $realmID, $xml);
print($InvoiceService->lastRequest($Context));
print("\n\n");
print($response);

exit;


$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<CustomerQuery xmlns="http://www.intuit.com/sb/cdm/v2">
	<SynchronizedFilter>NotSynchronized</SynchronizedFilter>
</CustomerQuery>';



$response = $CustomerService->rawQuery($Context, $realmID, $xml);
print($CustomerService->lastRequest($Context));
print("\n\n");
print($response);


print("\n\n\n\n\n");


$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<CustomerQuery ErroredObjectsOnly="true" xmlns="http://www.intuit.com/sb/cdm/v2">
</CustomerQuery>';

$response = $CustomerService->rawQuery($Context, $realmID, $xml);
print($CustomerService->lastRequest($Context));
print("\n\n");
print($response);

//exit;





exit;

$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<CheckQuery ErroredObjectsOnly="true" xmlns="http://www.intuit.com/sb/cdm/v2">
</CheckQuery>';

$list = $CheckService->rawQuery($Context, $realmID, $xml);


$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<CheckQuery xmlns="http://www.intuit.com/sb/cdm/v2">
	<SynchronizedFilter>NotSynchronized</SynchronizedFilter>
</CheckQuery>';

$list = $CheckService->rawQuery($Context, $realmID, $xml);

print_r($list);