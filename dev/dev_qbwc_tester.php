<?php


$url = '';
$username = 'keithtest';
$password = 'password';

if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

global $DATA;
$DATA = '';

header('Content-type: text/plain');

print(date('Y-m-d H:i:s: ') . 'URL: ' . $url . "\n");
print(date('Y-m-d H:i:s: ') . 'User: ' . $username . "\n");
print(date('Y-m-d H:i:s: ') . 'Pass: ' . $password . "\n");

//print($return);

//exit;

$return = tester($url, $username, $password, 'authenticate');

print(date('Y-m-d H:i:s: ') . 'RESPONSE: {{' . $return . '}}');

//$pos = strpos($return, '<string>');
$pos = strpos($return, '<ns1:string>');
//$pos = strpos($return, '<s0:string xsi:type="xs:string">');
//$ticket = substr($return, $pos + 12, 32);		// FOR MD5 HASH TICKETS
$ticket = substr($return, $pos + 12, 36);		// FOR UUID TICKETS

//$ticket = 'eda2daf8-6482-11e0-aea8-0030487fb92c';

print("\n\n" . date('Y-m-d H:i:s: ') . 'TICKET IS: [[' . $ticket . ']]' . "\n\n");



//exit;


$max = 1;
for ($i = 0; $i < $max; $i++)
{
	//print(date('Y-m-d H:i:s: ') . tester($url, $ticket, null, 'sendRequestXML'));
	
	$resp = tester($url, $ticket, null, 'sendRequestXML');
	
	$pos = strpos($resp, 'requestID=&quot;');
	
	print('got back [' . $resp . ']');
	
	//sleep(10);
}

exit;

$requestID = substr($resp, $pos + 16, 1);

print('REUQEST ID IS [' . $requestID . ']' . "\n");

//exit;

$response = '<?xml version="1.0" encoding="utf-8"?>
	<?qbposxml version="3.0"?>
	<QBPOSXML>
	  <QBPOSXMLMsgsRs>
	        <ItemInventoryQueryRs requestID="' . $requestID . '">

		     <ItemInventoryRet> <!-- optional, may repeat -->
<ListID>IDTYPE</ListID> <!-- optional -->
<TimeCreated>DATETIMETYPE</TimeCreated> <!-- optional -->
<TimeModified>DATETIMETYPE</TimeModified> <!-- optional -->
<ALU>STRTYPE</ALU> <!-- optional -->
<Attribute>STRTYPE</Attribute> <!-- optional -->
<COGSAccount>STRTYPE</COGSAccount> <!-- optional -->
<Cost>AMTTYPE</Cost> <!-- optional -->
<DepartmentCode>STRTYPE</DepartmentCode> <!-- optional -->
<DepartmentListID>IDTYPE</DepartmentListID> <!-- optional -->
<Desc1>STRTYPE</Desc1> <!-- optional -->
<Desc2>STRTYPE</Desc2> <!-- optional -->
<IncomeAccount>STRTYPE</IncomeAccount> <!-- optional -->
<IsBelowReorder>BOOLTYPE</IsBelowReorder> <!-- optional -->
<IsEligibleForCommission>BOOLTYPE</IsEligibleForCommission> <!-- optional -->
<IsPrintingTags>BOOLTYPE</IsPrintingTags> <!-- optional -->
<IsUnorderable>BOOLTYPE</IsUnorderable> <!-- optional -->
<HasPictures>BOOLTYPE</HasPictures> <!-- optional -->
<IsEligibleForRewards>BOOLTYPE</IsEligibleForRewards> <!-- optional -->
<IsWebItem>BOOLTYPE</IsWebItem> <!-- optional -->
<ItemNumber>INTTYPE</ItemNumber> <!-- optional -->
<!-- ItemType may have one of the following values: Inventory, NonInventory, Service, Assembly, Group, SpecialOrder -->
<ItemType>ENUMTYPE</ItemType> <!-- optional -->
<LastReceived>DATETYPE</LastReceived> <!-- optional -->
<MarginPercent>INTTYPE</MarginPercent> <!-- optional -->
<MarkupPercent>INTTYPE</MarkupPercent> <!-- optional -->
<MSRP>AMTTYPE</MSRP> <!-- optional -->
<OnHandStore01>QUANTYPE</OnHandStore01> <!-- optional -->
<OnHandStore02>QUANTYPE</OnHandStore02> <!-- optional -->
<OnHandStore03>QUANTYPE</OnHandStore03> <!-- optional -->
<OnHandStore04>QUANTYPE</OnHandStore04> <!-- optional -->
<OnHandStore05>QUANTYPE</OnHandStore05> <!-- optional -->
<OnHandStore06>QUANTYPE</OnHandStore06> <!-- optional -->
<OnHandStore07>QUANTYPE</OnHandStore07> <!-- optional -->
<OnHandStore08>QUANTYPE</OnHandStore08> <!-- optional -->
<OnHandStore09>QUANTYPE</OnHandStore09> <!-- optional -->
<OnHandStore10>QUANTYPE</OnHandStore10> <!-- optional -->
<OnHandStore11>QUANTYPE</OnHandStore11> <!-- optional -->
<OnHandStore12>QUANTYPE</OnHandStore12> <!-- optional -->
<OnHandStore13>QUANTYPE</OnHandStore13> <!-- optional -->
<OnHandStore14>QUANTYPE</OnHandStore14> <!-- optional -->
<OnHandStore15>QUANTYPE</OnHandStore15> <!-- optional -->
<OnHandStore16>QUANTYPE</OnHandStore16> <!-- optional -->
<OnHandStore17>QUANTYPE</OnHandStore17> <!-- optional -->
<OnHandStore18>QUANTYPE</OnHandStore18> <!-- optional -->
<OnHandStore19>QUANTYPE</OnHandStore19> <!-- optional -->
<OnHandStore20>QUANTYPE</OnHandStore20> <!-- optional -->
<ReorderPointStore01>QUANTYPE</ReorderPointStore01> <!-- optional -->
<ReorderPointStore02>QUANTYPE</ReorderPointStore02> <!-- optional -->
<ReorderPointStore03>QUANTYPE</ReorderPointStore03> <!-- optional -->
<ReorderPointStore04>QUANTYPE</ReorderPointStore04> <!-- optional -->
<ReorderPointStore05>QUANTYPE</ReorderPointStore05> <!-- optional -->
<ReorderPointStore06>QUANTYPE</ReorderPointStore06> <!-- optional -->
<ReorderPointStore07>QUANTYPE</ReorderPointStore07> <!-- optional -->
<ReorderPointStore08>QUANTYPE</ReorderPointStore08> <!-- optional -->
<ReorderPointStore09>QUANTYPE</ReorderPointStore09> <!-- optional -->
<ReorderPointStore10>QUANTYPE</ReorderPointStore10> <!-- optional -->
<ReorderPointStore11>QUANTYPE</ReorderPointStore11> <!-- optional -->
<ReorderPointStore12>QUANTYPE</ReorderPointStore12> <!-- optional -->
<ReorderPointStore13>QUANTYPE</ReorderPointStore13> <!-- optional -->
<ReorderPointStore14>QUANTYPE</ReorderPointStore14> <!-- optional -->
<ReorderPointStore15>QUANTYPE</ReorderPointStore15> <!-- optional -->
<ReorderPointStore16>QUANTYPE</ReorderPointStore16> <!-- optional -->
<ReorderPointStore17>QUANTYPE</ReorderPointStore17> <!-- optional -->
<ReorderPointStore18>QUANTYPE</ReorderPointStore18> <!-- optional -->
<ReorderPointStore19>QUANTYPE</ReorderPointStore19> <!-- optional -->
<ReorderPointStore20>QUANTYPE</ReorderPointStore20> <!-- optional -->
<OrderByUnit>STRTYPE</OrderByUnit> <!-- optional -->
<OrderCost>AMTTYPE</OrderCost> <!-- optional -->
<Price1>AMTTYPE</Price1> <!-- optional -->
<Price2>AMTTYPE</Price2> <!-- optional -->
<Price3>AMTTYPE</Price3> <!-- optional -->
<Price4>AMTTYPE</Price4> <!-- optional -->
<Price5>AMTTYPE</Price5> <!-- optional -->
<QuantityOnCustomerOrder>QUANTYPE</QuantityOnCustomerOrder> <!-- optional -->
<QuantityOnHand>QUANTYPE</QuantityOnHand> <!-- optional -->
<QuantityOnOrder>QUANTYPE</QuantityOnOrder> <!-- optional -->
<QuantityOnPendingOrder>QUANTYPE</QuantityOnPendingOrder> <!-- optional -->
<AvailableQty> <!-- must occur 0 - 10 times -->
<StoreNumber>INTTYPE</StoreNumber> <!-- optional -->
<QuantityOnOrder>QUANTYPE</QuantityOnOrder> <!-- optional -->
<QuantityOnCustomerOrder>QUANTYPE</QuantityOnCustomerOrder> <!-- optional -->
<QuantityOnPendingOrder>QUANTYPE</QuantityOnPendingOrder> <!-- optional -->
</AvailableQty>
<ReorderPoint>QUANTYPE</ReorderPoint> <!-- optional -->
<SellByUnit>STRTYPE</SellByUnit> <!-- optional -->
<!-- SerialFlag may have one of the following values: Optional, Prompt -->
<SerialFlag>ENUMTYPE</SerialFlag> <!-- optional -->
<Size>STRTYPE</Size> <!-- optional -->
<!-- StoreExchangeStatus may have one of the following values: Modified, Sent, Acknowledged -->
<StoreExchangeStatus>ENUMTYPE</StoreExchangeStatus> <!-- optional -->
<TaxCode>STRTYPE</TaxCode> <!-- optional -->
<UnitOfMeasure>STRTYPE</UnitOfMeasure> <!-- optional -->
<UPC>STRTYPE</UPC> <!-- optional -->
<VendorCode>STRTYPE</VendorCode> <!-- optional -->
<VendorListID>IDTYPE</VendorListID> <!-- optional -->
<WebDesc>STRTYPE</WebDesc> <!-- optional -->
<WebPrice>AMTTYPE</WebPrice> <!-- optional -->
<Manufacturer>STRTYPE</Manufacturer> <!-- optional -->
<Weight>FLOATTYPE</Weight> <!-- optional -->
<WebSKU>STRTYPE</WebSKU> <!-- optional -->
<Keywords>STRTYPE</Keywords> <!-- optional -->
<WebCategories>STRTYPE</WebCategories> <!-- optional -->
<UnitOfMeasure1> <!-- optional -->
<ALU>STRTYPE</ALU> <!-- optional -->
<MSRP>AMTTYPE</MSRP> <!-- optional -->
<NumberOfBaseUnits>QUANTYPE</NumberOfBaseUnits> <!-- optional -->
<Price1>AMTTYPE</Price1> <!-- optional -->
<Price2>AMTTYPE</Price2> <!-- optional -->
<Price3>AMTTYPE</Price3> <!-- optional -->
<Price4>AMTTYPE</Price4> <!-- optional -->
<Price5>AMTTYPE</Price5> <!-- optional -->
<UnitOfMeasure>STRTYPE</UnitOfMeasure> <!-- optional -->
<UPC>STRTYPE</UPC> <!-- optional -->
</UnitOfMeasure1>
<UnitOfMeasure2> <!-- optional -->
<ALU>STRTYPE</ALU> <!-- optional -->
<MSRP>AMTTYPE</MSRP> <!-- optional -->
<NumberOfBaseUnits>QUANTYPE</NumberOfBaseUnits> <!-- optional -->
<Price1>AMTTYPE</Price1> <!-- optional -->
<Price2>AMTTYPE</Price2> <!-- optional -->
<Price3>AMTTYPE</Price3> <!-- optional -->
<Price4>AMTTYPE</Price4> <!-- optional -->
<Price5>AMTTYPE</Price5> <!-- optional -->
<UnitOfMeasure>STRTYPE</UnitOfMeasure> <!-- optional -->
<UPC>STRTYPE</UPC> <!-- optional -->
</UnitOfMeasure2>
<UnitOfMeasure3> <!-- optional -->
<ALU>STRTYPE</ALU> <!-- optional -->
<MSRP>AMTTYPE</MSRP> <!-- optional -->
<NumberOfBaseUnits>QUANTYPE</NumberOfBaseUnits> <!-- optional -->
<Price1>AMTTYPE</Price1> <!-- optional -->
<Price2>AMTTYPE</Price2> <!-- optional -->
<Price3>AMTTYPE</Price3> <!-- optional -->
<Price4>AMTTYPE</Price4> <!-- optional -->
<Price5>AMTTYPE</Price5> <!-- optional -->
<UnitOfMeasure>STRTYPE</UnitOfMeasure> <!-- optional -->
<UPC>STRTYPE</UPC> <!-- optional -->
</UnitOfMeasure3>
<VendorInfo2> <!-- optional -->
<ALU>STRTYPE</ALU> <!-- optional -->
<OrderCost>AMTTYPE</OrderCost> <!-- optional -->
<UPC>STRTYPE</UPC> <!-- optional -->
<VendorListID useMacro="MACROTYPE">IDTYPE</VendorListID> <!-- required -->
</VendorInfo2>
<VendorInfo3> <!-- optional -->
<ALU>STRTYPE</ALU> <!-- optional -->
<OrderCost>AMTTYPE</OrderCost> <!-- optional -->
<UPC>STRTYPE</UPC> <!-- optional -->
<VendorListID useMacro="MACROTYPE">IDTYPE</VendorListID> <!-- required -->
</VendorInfo3>
<VendorInfo4> <!-- optional -->
<ALU>STRTYPE</ALU> <!-- optional -->
<OrderCost>AMTTYPE</OrderCost> <!-- optional -->
<UPC>STRTYPE</UPC> <!-- optional -->
<VendorListID useMacro="MACROTYPE">IDTYPE</VendorListID> <!-- required -->
</VendorInfo4>
<VendorInfo5> <!-- optional -->
<ALU>STRTYPE</ALU> <!-- optional -->
<OrderCost>AMTTYPE</OrderCost> <!-- optional -->
<UPC>STRTYPE</UPC> <!-- optional -->
<VendorListID useMacro="MACROTYPE">IDTYPE</VendorListID> <!-- required -->
</VendorInfo5>
<DataExtRet> <!-- optional, may repeat -->
<OwnerID>GUIDTYPE</OwnerID> <!-- required -->
<DataExtName>STRTYPE</DataExtName> <!-- required -->
<!-- DataExtType may have one of the following values: INTTYPE, AMTTYPE, PRICETYPE, QUANTYPE, PERCENTTYPE, DATETIMETYPE, STR255TYPE, STR1024TYPE -->
<DataExtType>ENUMTYPE</DataExtType> <!-- required -->
<DataExtValue>STRTYPE</DataExtValue> <!-- required -->
</DataExtRet>
</ItemInventoryRet>

	        </ItemInventoryQueryRs>
		</QBPOSXMLMsgsRs>
	</QBPOSXML>';

print('Sending response...' . "\n");

print(tester($url, $ticket, null, 'receiveResponseXML', $response));

print('Done!' . "\n");

$fp = fopen('./out.txt', 'w+');
fwrite($fp, $DATA);
fclose($fp);

exit;


exit;

function tester($url, $username_or_ticket, $password, $method, $data = null)
{
	print(date('Y-m-d H:i:s: ') . 'Sending request method: ' . $method . "\n");
	
	global $DATA;
	$DATA .= date('Y-m-d H:i:s: ') . 'Sending request method: ' . $method . "\r\n";
	
	switch ($method)
	{
		case 'fetchVersion':
						$soap = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
 xmlns:xsd="http://www.w3.org/2001/XMLSchema"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
 xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
 SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
 xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
	<SOAP-ENV:Body>
		<fetchVersion xmlns="http://developer.intuit.com/">
		</fetchVersion>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
			break;
		case 'authenticate':
			$soap = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
 xmlns:xsd="http://www.w3.org/2001/XMLSchema"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
 xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
 SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
 xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
	<SOAP-ENV:Body>
		<authenticate xmlns="http://developer.intuit.com/">
			<strUserName xsi:type="xsd:string">' . $username_or_ticket . '</strUserName>
			<strPassword xsi:type="xsd:string">' . $password . '</strPassword>
		</authenticate>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
			break;
		case 'sendRequestXML':
			$soap = '<?xml version="1.0" encoding="UTF-8"?>
	<SOAP-ENV:Envelope 
	 xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
	 xmlns:ns1="http://developer.intuit.com/">
		<SOAP-ENV:Body>
			<ns1:sendRequestXML>
				<ns1:ticket>' . $username_or_ticket . '</ns1:ticket>
				<ns1:strHCPResponse></ns1:strHCPResponse>
				<ns1:strCompanyFileName></ns1:strCompanyFileName>
				<ns1:qbXMLCountry>US</ns1:qbXMLCountry>
				<ns1:qbXMLMajorVers>6</ns1:qbXMLMajorVers>
				<ns1:qbXMLMinorVers>0</ns1:qbXMLMinorVers>
			</ns1:sendRequestXML>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>';
			break;
		case 'receiveResponseXML':
			$soap = '<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
				<soap:Body>
					<receiveResponseXML xmlns="http://developer.intuit.com/">
						<ticket>' . $username_or_ticket . '</ticket>
						<response>' . htmlspecialchars($data, ENT_QUOTES) . '</response>
						<hresult />
						<message />
					</receiveResponseXML>
				</soap:Body>
			</soap:Envelope>';
			break;
	}
	
	$headers = array(
		'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; MS Web Services Client Protocol 2.0.50727.1433)', 
		'Content-Type: text/xml; charset=utf-8',
		'Soapaction: "http://developer.intuit.com/' . $method . '"',
		);

	if (function_exists('curl_init'))
	{
		$curl = curl_init($url); 
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		
		
		curl_setopt($curl, CURLOPT_POSTFIELDS, $soap);
		
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
		//curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		//curl_setopt($curl, CURLOPT_MAXCONNECTS, 1);
		
		//curl_setopt($curl, CURLOPT_USERPWD, 'milo:foofoo');
		
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		//print_r(curl_getinfo($curl));
		
		$return = curl_exec($curl);
	}
	else
	{
		$parse = parse_url($url);
		if (empty($parse['port']))
		{
			$parse['port'] = 80;
		}
		
		if ($parse['scheme'] == 'https')
		{
			die('sorry, you need curl to test https (for now at least)');
		}
		
		if ($fp = fsockopen($parse['host'], $parse['port']))
		{
			$request = '';
			$request .= 'POST ' . $parse['path'] . '?' . $parse['query'] . ' HTTP/1.0' . "\r\n";
			$request .= 'Host: ' . $parse['host'] . "\r\n";
			
			foreach ($headers as $key => $value)
			{
				//$request .= $key . ': ' . $value . "\r\n";
				$request .= $value . "\r\n";
			}
			
			$request .= 'Content-Length: ' . strlen($soap) ."\r\n"; 
			$request .= 'Connection: close' . "\r\n";
			$request .= "\r\n"; 
			$request .= $soap; 
			
			print(str_repeat('-', 20) . ' REQUEST ' . str_repeat('-', 20) . "\n");
			print($request . "\n");
			print(str_repeat('-', 48) . "\n");
			
			fputs($fp, $request);
				
			$bytes = 0;
			$resp = '';
			while (!feof($fp) and $bytes < 10000) 
			{ 
				$tmp = fgets($fp, 128);
				$bytes += strlen($tmp);
				
				$resp .= $tmp; 
			}
			
			print(str_repeat('-', 19) . ' RESPONSE ' . str_repeat('-', 19) . "\n");	
			print($resp . "\n");
			print(str_repeat('-', 48) . "\n");
			print("\n\n");
				
			fclose($fp);	
		}
		else
		{
			die('Connection failed!');
		}
			
		$return = $resp;
	}
	
	$DATA .= $return . "\r\n";
	return $return;
}
