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

$Service = new QuickBooks_IPP_Service_Account();

$list = $Service->findAll($Context, $realmID);
print_r($list[0]);

print("\n\n\n");
print($Service->lastRequest());
print("\n\n\n");
print($Service->lastResponse());
print("\n\n\n");

exit;
