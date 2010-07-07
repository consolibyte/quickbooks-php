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


$Service = new QuickBooks_IPP_Service_Employee(); 

$list = $Service->findAll($Context, $realmID);

//print($Service->lastResponse($Context));

foreach ($list as $Employee)
{
	print('Employee: ' . $Employee->getId() . ', ' . $Employee->getName() . "\n\n");
	$Id = $Employee->getId();
	break;
}


//$IPP->useIDSParser(false);
$Employee = $Service->findById($Context, $realmID, $Id);

//print("\n\n");
//print($Service->lastRequest($Context) . "\n\n");
//print($Service->lastResponse($Context));
//print("\n\n");

print_r($Employee);

