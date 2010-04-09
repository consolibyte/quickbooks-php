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

// Create a new Service for IDS access
$Service = new QuickBooks_IPP_Service_SalesReceipt();

$list = $Service->findAll($Context, $realmID);

//print($Service->lastRequest($Context));

//print($Service->lastResponse($Context));


$Service = new QuickBooks_IPP_Service_Job();

$list = $Service->findAll($Context, $realmID);


print_r($list);