<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

// 
$username = 'keith@consolibyte.com';
$password = 'password42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';
$realmID = 173642438;

$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);
$IPP->application('be9mh7qd5');



$IPP->getAvailableCompanies($Context);

print($IPP->lastRequest());
print("\n\n");
print($IPP->lastResponse());
print("\n\n");
exit;






$realm = $IPP->getIDSRealm($Context);

print('realm is: {' . $realm . '}');

print("\n\n");

if ($IPP->detachIDSRealm($Context, $realm))
{
	print('Detached ' . $realm . '!');
}
else
{
	print('Failed to detach: ' . $IPP->errorNumber() . ': ' . $IPP->errorMessage());
}

//print($IPP->lastRequest());
//print($IPP->lastResponse());

print("\n\n");

$realm = $IPP->getIDSRealm($Context);

print('realm is: {' . $realm . '}');

print("\n\n");


if ($IPP->attachIDSRealm($Context, $realmID))
{
	print('Attached ' . $realmID . '!');
}
else
{
	print('Failed to attach: ' . $IPP->errorNumber() . ': ' . $IPP->errorMessage());
}

//print($IPP->lastRequest());
//print($IPP->lastResponse());

print("\n\n");

$realm = $IPP->getIDSRealm($Context);

print('realm is: {' . $realm . '}');

print("\n\n");

