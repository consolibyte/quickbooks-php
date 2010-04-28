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

//$IPP->useIDSParser(false);

/*
$Service = new QuickBooks_IPP_Service_Customer();

$list = $Service->findAll($Context, $realmID);

foreach ($list as $Customer)
{
	print_r($Customer);
	exit;
}
*/

/*
$Service = new QuickBooks_IPP_Service_Customer(); 
 
$Customer = new QuickBooks_IPP_Object_Customer();

//$Customer->setTypeOf('Person');
//$Customer->setTypeOf('Something Else');

$Customer->setName('Brand New Customer #' . mt_rand(0, 100));
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
*/


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
