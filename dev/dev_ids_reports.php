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

$Service = new QuickBooks_IPP_Service_Report_ProfitAndLoss();
$Report = $Service->report($Context, $realmID);

//print_r($Report->getData());
//print_r($Report->getData()->getDataRow(0));

for ($i = 0; $i < 3; $i++)
{
	print($Report->getData()->getDataRow($i)->getColData(0) . '   ' . $Report->getData()->getDataRow($i)->getColData(1) . "\n");
}

