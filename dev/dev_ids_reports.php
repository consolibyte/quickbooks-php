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

//$Service = new QuickBooks_IPP_Service_Report_ProfitAndLoss();
$Service = new QuickBooks_IPP_Service_Report_TopCustomersBySales();

$Report = $Service->report($Context, $realmID);

print_r($Service->lastDebug($Context));

//print_r($Report);

//print_r($Report->getData());
//print_r($Report->getData()->getDataRow(0));

print("\n\n");
print('report has [' . $Report->getColumnCount() . '] columns and [' . $Report->getRowCount() . '] rows' . "\n\n");

for ($i = 0; $i < $Report->getRowCount(); $i++)
{
	for ($j = 0; $j < $Report->getColumnCount(); $j++)
	{
		print(str_pad($Report->getData()->getDataRow($i)->getColumnData($j), 25));
	}
	
	print("\r\n");
}

