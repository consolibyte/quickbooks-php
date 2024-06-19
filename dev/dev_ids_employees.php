<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once __DIR__ . '/../QuickBooks.php';

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
