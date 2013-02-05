<?php

header('Content-Type: text/plain');

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks/');

require_once '../QuickBooks.php';

// 
$username = '';
$password = '';
$token = '';
$realmID = 182938192;

// 
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);

$IPP->application($Context, 'bfrccpnge');

//$IPP->useIDSParser(false);

$Service = new QuickBooks_IPP_Service_ShipMethod();

$list = $Service->findAll($Context, $realmID);

//print_r($list);

$map = $Service->map($Context, $realmID);

print_r($map);
