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


$name = 'my new name ' . mt_rand();

if ($IPP->renameApp($Context, $name))
{
	print('Renamed the app! ');
}
else
{
	print('Rename failed: ' . $IPP->errorNumber() . ': ' . $IPP->errorMessage());
}

print("\n\n");
print($IPP->lastRequest()); 
print("\n\n");
print($IPP->lastResponse());
print("\n\n");
