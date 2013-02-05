<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

// 
$username = 'support@consolibyte.com';
$password = '$up3rW0rmy42';
$token = 'bf8cp2mihs6vsdibgqsybinugvj';
$realmID = 182938192;
$application = 'bfrccpnge';

// 
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);
$IPP->application($Context, $application);

//$IPP->useIDSParser(false);


$Service = new QuickBooks_IPP_Service_Employee(); 


$Employee = $Service->findById($Context, $realmID, '{NG-124029}');

//print_r($Employee);

print($Service->lastRequest($Context));
print("\n\n\n\n\n");
print($Service->lastResponse($Context));
print("\n\n\n\n\n");

exit;



$Employee = new QuickBooks_IPP_Object_Employee();


$Email = new QuickBooks_IPP_Object_Email();
$Email->setAddress('kurt@test.com');
$Email->setTag('Business');

$Employee->setEmail($Email);


$Phone = new QuickBooks_IPP_Object_Phone();
$Phone->setDeviceType('Mobile');
$Phone->setFreeFormNumber('860-634-1602');
$Phone->setTag('Mobile');

$Employee->setPhone($Phone);


//$Employee->setGivenName('Karli M');
//$Employee->setFamilyName('Palmer');



$Address = new 	QuickBooks_IPP_Object_Address();
$Address->setLine1('56 Cowles Road');
$Address->setCity('Willington');
$Address->setState('CT');
$Address->setTag('Billing');


$Employee->addAddress($Address);

$Employee->setName('Tom Anderson ' . mt_rand(0, 100));


if ($Id = $Service->add($Context, $realmID, $Employee))
{
	print('NEW EMPLOYEE: #' . $Id);
}
else
{
	print('An error occurred {' . $Service->errorNumber() . ': ' . $Service->errorMessage() . '}' . "\n");
}


exit;

print($Service->lastRequest($Context));
print("\n\n\n\n\n");
print($Service->lastResponse($Context));
print("\n\n\n\n\n");
print('---------------------------------');
print("\n\n\n\n\n");

exit;

$list = $Service->findAll($Context, $realmID);

print($Service->lastRequest($Context));
print("\n\n\n\n\n");
print($Service->lastResponse($Context));

foreach ($list as $Employee)
{
	print('Employee: ' . $Employee->getId() . ', ' . $Employee->getName() . "\n\n");
	$Id = $Employee->getId();
	break;
}


/*
//$IPP->useIDSParser(false);
$Employee = $Service->findById($Context, $realmID, $Id);

//print("\n\n");
//print($Service->lastRequest($Context) . "\n\n");
//print($Service->lastResponse($Context));
//print("\n\n");

print_r($Employee);
*/
