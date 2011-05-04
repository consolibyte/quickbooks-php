<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';


// 
$username = 'support@consolibyte.com';
$password = '$up3rW0rmy42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';
$realmID = 173642438;

// 
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);
$IPP->application($Context, 'be9mh7qd5');


/*
<?xml version="1.0"?>
<Add xmlns="http://www.intuit.com/sb/cdm/v2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" RequestId="369c25d94c664b8e801164a6fe87698d">
	<ExternalRealmId>179017358</ExternalRealmId>
	<Object xsi:type="Invoice">
		<Header>
			<DocNumber>DF110108JM</DocNumber>
			<TxnDate>2011-01-14</TxnDate>
			<CustomerId>2</CustomerId>
			<SubTotalAmt>1000</SubTotalAmt>
			<TaxAmount>0</TaxAmount>
			<DueDate>2011-02-13</DueDate>
			<Balance>1000</Balance>
			<Memo></Memo>
		</Header>
		<Line>
			<Desc>Hope, Bob (Normal Hours) 12/26/2010</Desc>
			<Taxable>true</Taxable>
			<Item>Normal</Item>
			<UnitPrice>1000</UnitPrice>
			<Qty>1</Qty>
		</Line>
		<Line>
			<Desc>Hope, Bob (Normal Hours) 01/02/2011</Desc>
			<Taxable>true</Taxable>
			<Item>Normal</Item>
			<UnitPrice>1000</UnitPrice>
			<Qty>1</Qty>
		</Line>
	</Object>
</Add>
*/

$Invoice = new QuickBooks_IPP_Object_Invoice();

$Header = new QuickBooks_IPP_Object_Header();
//$Header->setDocNumber('DF110108JM');
$Header->setTxnDate('2011-01-14');
$Header->setCustomerId('2');

$BillAddr = new QuickBooks_IPP_Object_BillAddr();
$BillAddr->setLine1('56 Cowles Road');
$BillAddr->setCity('Willington');
$BillAddr->setCountrySubDivisionCode('Connecticut');

$Header->addBillAddr($BillAddr);

$Invoice->addHeader($Header);

$Line = new QuickBooks_IPP_Object_Line();
$Line->setDesc('Hope, Bob (Normal Hours) 12/26/2010');
$Line->setTaxable('true');
$Line->setItem('Normal');
$Line->setUnitPrice(1000);
$Line->setQty(1);

$Invoice->addLine($Line);

$Service = new QuickBooks_IPP_Service_Invoice();
$Service->add($Context, $realmID, $Invoice);


print($Service->lastResponse());

//print($Invoice->asIDSXML(null, null, QuickBooks_IPP_IDS::OPTYPE_ADD));

//exit;



// Create a new Service for IDS access
$Service = new QuickBooks_IPP_Service_Invoice();

$list = $Service->findAll($Context, $realmID);

//print_r($list);
//exit;

foreach ($list as $key => $Invoice)
{
	print($key . ': Invoice #' . $Invoice->getHeader()->getDocNumber() . ', balance: $' . $Invoice->getHeader()->getBalance() . "\n");
}

//print_r($list[11]);
