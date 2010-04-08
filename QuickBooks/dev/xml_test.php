<?php

require_once '../../QuickBooks.php';

/*
	$xml = '<InvoiceAdd>
		<CustomerRef>
			<APIApplicationID>TEST</APIApplicationID>
		</CustomerRef>
		<RefNumber>125</RefNumber>
		<Memo>test of a memo</Memo>
		<Other>test of other</Other>
		<InvoiceLineAdd>
			<ItemRef>
				<APIApplicationID>12</APIApplicationID>
			</ItemRef>
			<Quantity>3</Quantity>
			<Amount>300</Amount>
		</InvoiceLineAdd>
		<InvoiceLineAdd>
			<ItemRef>
				<APIApplicationID>11</APIApplicationID>
			</ItemRef>
			<Quantity>5</Quantity>
			<Amount>225</Amount>
		</InvoiceLineAdd>
	</InvoiceAdd>';
*/

$xml = '<?xml version="1.0" ?>
<QBXML>
<QBXMLMsgsRs>
<CustomerModRs requestID="Q3VzdG9tZXJNb2R8MTExMTIxMjE=" statusCode="0" statusSeverity="Info" statusMessage="Status OK">
<CustomerRet>
<ListID>800027C0-1225311905</ListID>
<TimeCreated>2008-10-29T16:25:05-05:00</TimeCreated>
<TimeModified>2008-11-10T15:04:20-05:00</TimeModified>
<EditSequence>1226347460</EditSequence>
<Name>Example, Sample</Name>
<FullName>Example, Sample</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<FirstName>Sample</FirstName>
<LastName>Example</LastName>
<BillAddress>
<Addr1>7992 Travelers Tree Dr</Addr1>
<City>Boca Raton</City>
<State>FL</State>
<PostalCode>33433</PostalCode>
<Country>USA</Country>
</BillAddress>
<BillAddressBlock>
<Addr1>7992 Travelers Tree Dr</Addr1>
<Addr2>Boca Raton, Fl 33433</Addr2>
<Addr3>USA</Addr3>
</BillAddressBlock>
<Phone>480-246-9722</Phone>
<AltPhone>480-246-9722</AltPhone>
<Email>student@smucayman.com;tmiller@stmatthews.edu</Email>
<Contact>Sample Example</Contact>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
<JobStatus>None</JobStatus>
</CustomerRet>
</CustomerModRs>
<DataExtModRs statusCode="0" statusSeverity="Info" statusMessage="Status OK">
<DataExtRet>
<OwnerID>0</OwnerID>
<DataExtName>StudentNumber</DataExtName>
<DataExtType>STR255TYPE</DataExtType>
<DataExtValue>11112121</DataExtValue>
</DataExtRet>
</DataExtModRs>
<DataExtModRs statusCode="0" statusSeverity="Info" statusMessage="Status OK">
<DataExtRet>
<OwnerID>0</OwnerID>
<DataExtName>SSN</DataExtName>
<DataExtType>STR255TYPE</DataExtType>
<DataExtValue>999-99-9999</DataExtValue>
</DataExtRet>
</DataExtModRs>
<DataExtModRs statusCode="0" statusSeverity="Info" statusMessage="Status OK">
<DataExtRet>
<OwnerID>0</OwnerID>
<DataExtName>Date of Birth</DataExtName>
<DataExtType>STR255TYPE</DataExtType>
<DataExtValue>1974-03-28</DataExtValue>
</DataExtRet>
</DataExtModRs>
<DataExtModRs statusCode="0" statusSeverity="Info" statusMessage="Status OK">
<DataExtRet>
<OwnerID>0</OwnerID>
<DataExtName>Alternate Email</DataExtName>
<DataExtType>STR255TYPE</DataExtType>
<DataExtValue>helpdesk@stmatthews.edu</DataExtValue>
</DataExtRet>
</DataExtModRs>
<DataExtModRs statusCode="0" statusSeverity="Info" statusMessage="Status OK">
<DataExtRet>
<OwnerID>0</OwnerID>
<DataExtName>Location</DataExtName>
<DataExtType>STR255TYPE</DataExtType>
<DataExtValue>Cayman</DataExtValue>
</DataExtRet>
</DataExtModRs>
</QBXMLMsgsRs>
</QBXML>';

$Parser = new QuickBooks_XML($xml);

$err = '';
$err2 = '';
$Doc = $Parser->parse($err, $err2);

$Root = $Doc->getRoot();

print_r($Root);
exit;

$children1 = $Doc->children();
foreach ($children1 as $child)
{
	print_r($child->asXML());
}

print("\n\n\n");

$children2 = $Doc->children('InvoiceLineAdd');
foreach ($children2 as $child)
{
	print_r($child->asXML());
}


?>