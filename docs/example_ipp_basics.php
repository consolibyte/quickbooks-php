<?php

require_once '../QuickBooks.php';

$username = 'keith@consolibyte.com';
$password = 'password42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';

$IPP = new QuickBooks_IPP();

$IPP->authenticate($username, $password, $token);
$IPP->application('be9mh7qd5');

//$IPP->useDebugMode(true);

print_r($IPP->cookies());

//print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
//print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");


//$IPP->createTable('test_table_name', 'Testers');

//print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
//print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");

//exit;

/*
$realm = $IPP->getIDSRealm();

print('Last request: [' . $IPP->lastRequest() . ']');

print("\n\n\n");

print('Last response: [' . $IPP->lastResponse() . ']');
*/

/*
$companies = $IPP->getAvailableCompanies();

print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");


print($companies);
*/

/*
$IPP->attachIDSRealm(173642438);

print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");


$IPP->getIDSRealm();

print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
*/


$IPP->test(1);

print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");


exit;

$IPP->provisionUser('keith@uglyslug.com', 'Keith', 'Palmer');
print('Last request: [' . $IPP->lastRequest() . ']' . "\n\n");
print('Last response: [' . $IPP->lastResponse() . ']' . "\n\n");
