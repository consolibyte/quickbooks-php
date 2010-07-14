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

/*
// Create a new Service for IDS access
$Service = new QuickBooks_IPP_Service_Invoice();

$list = $Service->findAll($Context, $realmID);

foreach ($list as $key => $Invoice)
{
	print($key . ': Invoice #' . $Invoice->getHeader()->getDocNumber() . ', balance: $' . $Invoice->getHeader()->getBalance() . "\n");
}

print_r($list[11]);
*/



$Service = new QuickBooks_IPP_Service_Payment();

$list = $Service->findAll($Context, $realmID);

print_r($list);