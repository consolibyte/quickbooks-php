<?php

/**
 * Example of how to send something to the framework via a bridge
 * 
 * This shows an example of how to send a qbXML request to the framework via 
 * a "bridge". The bridge used here and in the other docs/example_bridge_* 
 * examples show how to use the HTTP bridge, which allows you to HTTP POST 
 * qbXML / data to a URL to have that qbXML request queued up to be sent to 
 * QuickBooks by the framework. 
 * 
 * This allows access to QuickBooks using this PHP framework by remote 
 * machines, or by other programming languages. A .NET script could POST data 
 * to the URL to have it queued up, etc. 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */



// We want to "enqueue" customer #10, and here's the qbXML request... 
$tmp = array(
	'method' => 'enqueue', 
	'ident' => 10, 
	'qbxml' => '<?xml version="1.0" encoding="utf-8"?>
<?qbxml version="2.0"?>
<QBXML>
	<QBXMLMsgsRq onError="stopOnError">
		<CustomerAddRq>
			<CustomerAdd>
				<Name>20706 - Eastern XYZ University</Name>
				<CompanyName>Eastern XYZ University</CompanyName>
				<FirstName>Keith</FirstName>
				<LastName>Palmer</LastName>
				<BillAddress>
					<Addr1>Eastern XYZ University</Addr1>
					<Addr2>College of Engineering</Addr2>
					<Addr3>123 XYZ Road</Addr3>
					<City>Storrs-Mansfield</City>
					<State>CT</State>
					<PostalCode>06268</PostalCode>
					<Country>United States</Country>
				</BillAddress>
				<Phone>860-634-1602</Phone>
				<AltPhone>860-429-0021</AltPhone>
				<Fax>860-429-5183</Fax>
				<Email>keith@consolibyte.com</Email>
				<Contact>Keith Palmer</Contact>
			</CustomerAdd>
		</CustomerAddRq>
	</QBXMLMsgsRq>
</QBXML>', 		// from: http://wiki.consolibyte.com/wiki/doku.php/quickbooks_qbxml_customeradd
	);

$data = '';
foreach ($tmp as $key => $value)
{
	$data .= $key . '=' . urlencode($value) . '&';
}

// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, 'http://localhost/~kpalmer/QuickBooks%20Bridge/example_bridge_server.php');
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// grab URL and pass it to the browser
$resp = curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);

print($resp);

?>