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

//$IPP->useDebugMode(true);
$Context = $IPP->authenticate($username, $password, $token);

$IPP->application($Context, 'be9mh7qd5');



//print_r($Context);

//exit;

//$IPP->useIDSParser(false);

//$Service = new QuickBooks_IPP_Service_Customer();
//$list = $Service->findAll($Context, $realmID);

//print_r($list);

//exit;


$Service = new QuickBooks_IPP_Service_Report_ProfitAndLoss();
//$Service = new QuickBooks_IPP_Service_Report_TopCustomersBySales();
$Service = new QuickBooks_IPP_Service_Report_BalanceSheet();
//$Service = new QuickBooks_IPP_Service_Report_BalanceSheetStd();

$Report = $Service->report($Context, $realmID);


print("\n\n");
print('report has [' . $Report->getColumnCount() . '] columns and [' . $Report->getRowCount() . '] rows' . "\n\n");

// Print the columns
for ($i = 0; $i < $Report->getColumnCount(); $i++)
{
	print(str_pad($Report->getColDesc($i)->getColTitle(), 25));
}

print("\n");
	
for ($i = 0; $i < $Report->getRowCount(); $i++)
{
	for ($j = 0; $j < $Report->getColumnCount(); $j++)
	{
		print(str_pad($Report->getData()->getDataRow($i)->getColumnData($j), 25));
	}
	
	print("\r\n");
}


print("\n\n\n");

print($Service->lastResponse());

