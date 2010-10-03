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

/*
print("\n\n");
print($IPP->lastRequest());
print("\n\n");
print($IPP->lastResponse());
print("\n\n");
*/

//exit;

$IPP->application($Context, 'be9mh7qd5');

//$IPP->useIDSParser(false);

$Service = new QuickBooks_IPP_Service_Customer();

$list = $Service->rawQuery($Context, $realmID, '<?xml version="1.0" encoding="UTF-16"?>
<CustomerQuery xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://www.intuit.com/sb/cdm/v2">
	<FirstLastInside>Break Stuff</FirstLastInside>
</CustomerQuery>');

print_r($list);

exit;

$list = $Service->findAll($Context, $realmID);

foreach ($list as $Customer)
{
	print_r($Customer);
	exit;
}

exit;



$name = 'LETS BREAK STUFF! #' . mt_rand(0, 1000);

$Service = new QuickBooks_IPP_Service_Customer(); 
$Customer = new QuickBooks_IPP_Object_Customer();
$Customer->setName($name);
$Customer->setGivenName('Keith');
$Customer->setFamilyName('Palmer');
if ($ID = $Service->add($Context, $realmID, $Customer))
{
	//print($Service->lastRequest($Context));
	//print("\n\n\n\n\n");
	//print($Service->lastResponse($Context));
	//print("\n\n\n\n\n");
	
	print('Customer added with Name: ' . $name . ', ID: ' . $ID . "\n");
}
else
{
	print('An error occurred {' . $Service->errorNumber() . ': ' . $Service->errorMessage() . '}' . "\n");
}

// Let's see if we can retrieve them by ID

//$IPP->useIDSParser(false);

//$ID = '{NG-23}';

$Customer = $Service->findById($Context, $realmID, $ID);

//print('----' . "\n");
//print($Service->lastRequest() . "\n\n\n");
//print('----' . "\n");
//print($Service->lastResponse() . "\n\n\n");
//print('----' . "\n");

print('Retrieved customer: ' . $Customer->getName() . "\n");

exit;












$ID = 4792537;
$Invoice = $Service->findById($Context, $realmID, $ID);

print_r($Invoice);

/*
print("\n\n");
print("\n\n");
print("\n\n");
print("\n\n");
print("\n\n");
print($Service->lastRequest($Context));
print("\n\n");
print($Service->lastResponse($Context));
print("\n\n");
*/

exit;

/*
$list = $Service->findAll($Context, $realmID);
print_r($list[0]);
exit;
*/

//$Service = new QuickBooks_IPP_Service_Check();

/*
$list = $Service->findAll($Context, $realmID);
print_r($list[0]);
exit;
*/

/*
$Check = new QuickBooks_IPP_Object_Check();

$Header = new QuickBooks_IPP_Object_Header();
$Header->setDocNumber('TEST-' . mt_rand(0, 100));
$Header->setTxnDate('2010-03-05');
$Header->setStatus('Payable');
$Header->setBankAccountName('Liberty Bank');
$Header->setEntityName('Test Vendor 1, LLC');
$Header->setEntityType('Vendor');

$Check->addHeader($Header);

$Line = new QuickBooks_IPP_Object_Line();
$Line->setDesc('Test line');
$Line->setAmount(50);
$Line->setAccountName('Rent Expense');

$Check->addLine($Line);

if ($ID = $Service->add($Context, $realmID, $Check))
{
	print('Check added with ID #' . $ID . "\n");
}
else
{
	print('An error occurred {' . $Service->errorNumber() . ': ' . $Service->errorMessage() . '}' . "\n");
}*/
/*

 */


$Invoice = new QuickBooks_IPP_Object_Estimate();

$Header = new QuickBooks_IPP_Object_Header();
$Header->setDocNumber('TEST-' . mt_rand(0, 100));
$Header->setTxnDate('2010-03-05');
$Header->setCustomerName('ConsoliBYTE, LLC');

$Invoice->addHeader($Header);

$Line = new QuickBooks_IPP_Object_Line();

//$Line->setTxnLineId(1);

$Line->setDesc('Test desc goes here.');
$Line->setItemName('Test Item 2');
$Line->setItemType('Service');
//$Line->setDesc('Test desc');
$Line->setUnitPrice(10.95);
$Line->setQty(2);
$Line->setSalesTaxCodeName('NON');



$Invoice->addLine($Line);

print_r($Invoice);

if ($ID = $Service->add($Context, $realmID, $Invoice))
{
	print('Invoice added with ID #' . $ID . "\n");
}
else
{
	print('An error occurred {' . $Service->errorNumber() . ': ' . $Service->errorMessage() . '}' . "\n");
}

print("\n\n");
print("\n\n");
print("\n\n");
print("\n\n");
print("\n\n");
print($Service->lastRequest($Context));
print("\n\n");
print($Service->lastResponse($Context));
print("\n\n");

// svn commit --message "Support for adding invoices. Partial support for adding checks."







$Service = new QuickBooks_IPP_Service_Customer(); 
 
$Customer = new QuickBooks_IPP_Object_Customer();

//$Customer->setTypeOf('Person');
//$Customer->setTypeOf('Something Else');

$Customer->setName('Does it work #' . mt_rand(0, 100));
$Customer->setGivenName('Keith');
$Customer->setFamilyName('Palmer');



if ($ID = $Service->add($Context, $realmID, $Customer))
{
	print('Customer added with ID #' . $ID . "\n");
}
else
{
	print('An error occurred {' . $Service->errorNumber() . ': ' . $Service->errorMessage() . '}' . "\n");
}


/*
$Service = new QuickBooks_IPP_Service_Vendor();

$Vendor = new QuickBooks_IPP_Object_Vendor();

$Vendor->setName('Brand New Vendor #' . mt_rand(0, 100) . '');
$Vendor->setGivenName('Keith');
$Vendor->setFamilyName('Palmer');

if ($ID = $Service->add($Context, $realmID, $Vendor))
{
	print('Vendor added with ID #' . $ID . "\n");
}
else
{
	print('An error occurred {' . $Service->errorNumber() . ': ' . $Service->errorMessage() . '}' . "\n");
}
*/


/*
print("\n\n");
print("\n\n");
print("\n\n");
print("\n\n");
print("\n\n");
print($Service->lastRequest($Context));
print("\n\n");
print($Service->lastResponse($Context));
print("\n\n");

*/
