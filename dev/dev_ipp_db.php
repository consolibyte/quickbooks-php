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
$IPP->application('be9mh7qd5');

//$IPP->useDebugMode(true);

//print_r($IPP->sendInvitation($Context, 'keith@consolibyte.com'));

//print_r($IPP->getAvailableCompanies($Context));

$value = 'testvalue' . mt_rand();

$return = $IPP->setDBVar($Context, 'testvar', $value);
print('set db var to "' . $value . '": '); var_dump($return);


$return = $IPP->getDBVar($Context, 'testvar');
print('get db var: '); var_dump($return);

print('ERROR: ' . $IPP->errorCode() . ': ' . $IPP->errorText());

//exit;

$info = $IPP->getDBInfo($Context);
print_r($info);
