<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

// 
$username = 'keith@consolibyte.com';
$password = 'password42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';
$realmID = 173642438;
$application = 'be9mh7qd5';

// 
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);

$IPP->application($Context, $application);

$IPP->useIDSParser(false);

/*
$Service = new QuickBooks_IPP_Service_Item();

$Service->findAll($Context, $realmID);

print($Service->lastRequest() . "\n\n");
print($Service->lastResponse() . "\n\n");
*/


/*
$Service = new QuickBooks_IPP_Service_Item();

$Item = new QuickBooks_IPP_Object_Item();
$Item->setType('Service');
$Item->setName('Test Name');

$IncomeAccountRef = new QuickBooks_IPP_Object_IncomeAccountRef();
$IncomeAccountRef->setAccountName('Account That Does Not Exist');
$Item->setIncomeAccountRef($IncomeAccountRef);

//print($Item->asIDSXML());

$Service->add($Context, $realmID, $Item);

print($Service->lastRequest() . "\n\n");
print($Service->lastResponse() . "\n\n");
*/


/*
$Service = new QuickBooks_IPP_Service_Item();

$Service->findAll($Context, $realmID);

print($Service->lastRequest() . "\n\n");
print($Service->lastResponse() . "\n\n");
*/




// ErroredObjectsOnly="true"

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<ItemQuery ErroredObjectsOnly="true" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/v2"></ItemQuery>';

$Service = new QuickBooks_IPP_Service_Item();

$Service->rawQuery($Context, $realmID, $xml);

print($Service->lastRequest() . "\n\n");
print($Service->lastResponse() . "\n\n");
