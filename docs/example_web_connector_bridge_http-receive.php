<?php

/**
 * Example of how to receive a response for something from the framework via a bridge
 * 
 * This shows how to receive a response from the HTTP bridge. See the other 
 * docs/example_bridge_* scripts for more documentation. Data is HTTP POSTed to 
 * this script by the framework. 
 * 
 * 
 * * * * IF YOU ACTUALLY USE THIS EXAMPLE, MAKE SURE THAT YOUR WEB SERVER HAS WRITE PERMISSION TO http-receive.txt!!! * * * 
 * 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */


$data = print_r($_POST, true);

$fp = fopen('./http-receive.txt', 'w+');
fwrite($fp, $data);
fclose($fp);

/*
// You get back something like this: 

Array
(
    [method] => enqueue
    [action] => Bridge
    [ident] => 10
    [replace] => 1
    [priority] => 0
    [extra] => 
    [qbxml] => <?xml version="1.0" ?>
<QBXML>
	<QBXMLMsgsRs>
		<CustomerAddRs requestID="QnJpZGdlfDEw" statusCode="0" statusSeverity="Info" statusMessage="Status OK">
			<CustomerRet>
				<ListID>F540000-1197683154</ListID>
				<TimeCreated>2007-12-14T20:45:54-05:00</TimeCreated>
				<TimeModified>2007-12-14T20:45:54-05:00</TimeModified>
				<EditSequence>1197683154</EditSequence>
				<Name>20706 - Eastern XYZ University</Name>
				<FullName>20706 - Eastern XYZ University</FullName>
				<IsActive>true</IsActive>
				<Sublevel>0</Sublevel>
				<CompanyName>Eastern XYZ University</CompanyName>
				<FirstName>Keith</FirstName>
				<LastName>Palmer</LastName>
				<BillAddress>
					<Addr1>Eastern XYZ University</Addr1>
					<Addr2>College of Engineering</Addr2>
					<Addr3>123 XYZ Road</Addr3>
					<City>Storrs-Mansfield</City>
					<State>CT</State>
					<PostalCode>88130</PostalCode>
					<Country>USA</Country>
				</BillAddress>
				<Phone>860-634-1602</Phone>
				<AltPhone>860-429-0021</AltPhone>
				<Fax>860-429-5183</Fax>
				<Email>keith@consolibyte.com</Email>
				<Contact>Keith Palmer</Contact>
				<Balance>0.00</Balance>
				<TotalBalance>0.00</TotalBalance>
				<JobStatus>None</JobStatus>
			</CustomerRet>
		</CustomerAddRs>
	</QBXMLMsgsRs>
</QBXML>
    [id] => {1d5b01d5-6d3a-6af4-6906-bd6a7501529c}
)
*/

?>