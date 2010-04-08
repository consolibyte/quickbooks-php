<?php

require_once '/home/library_php/QuickBooks.php';

require_once 'QuickBooks/Server/API/Callbacks.php';

/*
$xml = '<?xml version="1.0" ?>
<QBXML>
	<QBXMLMsgsRs>
		<CustomerAddRs requestID="Q3VzdG9tZXJBZGR8MTU=" statusCode="0" statusSeverity="Info" statusMessage="Status OK">
			<CustomerRet>
				<ListID>90000-1214366034</ListID>
				<TimeCreated>2008-06-24T23:53:54-05:00</TimeCreated>
				<TimeModified>2008-06-24T23:53:54-05:00</TimeModified>
				<EditSequence>1214366034</EditSequence>
				<Name>ShannonAPI APIDaniels</Name>
				<FullName>ShannonAPI APIDaniels</FullName>
				<IsActive>true</IsActive>
				<Sublevel>0</Sublevel>
				<Salutation>Mr.</Salutation>
				<FirstName>ShannonAPI</FirstName>
				<MiddleName>R</MiddleName>
				<LastName>APIDaniels</LastName>
				<ShipAddress>
					<Addr1>56 Cowles Road</Addr1>
					<City>Willington</City>
					<State>CT</State>
				</ShipAddress>
				<Phone>1.860.634.1602</Phone>
				<Balance>0.00</Balance>
				<TotalBalance>0.00</TotalBalance>
				<SalesTaxCodeRef>
					<ListID>10000-1211065841</ListID>
					<FullName>Tax</FullName>
				</SalesTaxCodeRef>
				<ItemSalesTaxRef>
					<ListID>10000-1211066051</ListID>
					<FullName>Out of State</FullName>
				</ItemSalesTaxRef>
				<JobStatus>None</JobStatus>
			</CustomerRet>
		</CustomerAddRs>
	</QBXMLMsgsRs>
</QBXML>';

$requestID = 'Q3VzdG9tZXJBZGR8MTU=';
$user = 'api';
$action = QUICKBOOKS_ADD_CUSTOMER;
$ID = 15;
$extra = unserialize('a:4:{s:3:"api";b:1;s:5:"qbxml";s:525:"<?xml version="1.0" encoding="utf-8"?>
			<?qbxml version="{$version}"?>
			<QBXML>
				<QBXMLMsgsRq onError="{$onerror}"><CustomerAddRq>
	<CustomerAdd>
		<Name>ShannonAPI APIDaniels</Name>
		<Salutation>Mr.</Salutation>
		<FirstName>ShannonAPI</FirstName>
		<MiddleName>R</MiddleName>
		<LastName>APIDaniels</LastName>
		<ShipAddress>
			<Addr1>56 Cowles Road</Addr1>
			<City>Willington</City>
			<State>CT</State>
		</ShipAddress>
		<Phone>1.860.634.1602</Phone>
	</CustomerAdd>
</CustomerAddRq>
</QBXMLMsgsRq>
			</QBXML>";s:8:"uniqueid";i:15;s:9:"callbacks";a:1:{i:0;s:20:"my_customer_callback";}}');
$err = '';
$last_action_time = time();
$last_actionident_time = time();
$idents = array();

QuickBooks_Server_API_Callbacks::CustomerAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

function my_customer_callback($method, $action, $ID, $err, $qbxml, $qbobject, $qbres)
{
	print('Customer name was: ' . $qbobject->getName() . "\n");
	return true;
}

print('error was: ' . $err . "\n");
*/

$xml = '<?xml version="1.0" ?>
<QBXML>
<QBXMLMsgsRs>
<CustomerQueryRs requestID="Q3VzdG9tZXJRdWVyeXwwNjc1ZTk4MGFiYTg1MDNhNDRhYjM5ZWVhNjNiMGJkYw==" statusCode="0" statusSeverity="Info" statusMessage="Status OK">
<CustomerRet>
<ListID>90000-1214366034</ListID>
<TimeCreated>2008-06-24T23:53:54-05:00</TimeCreated>
<TimeModified>2008-06-24T23:53:54-05:00</TimeModified>
<EditSequence>1214366034</EditSequence>
<Name>ShannonAPI APIDaniels</Name>
<FullName>ShannonAPI APIDaniels</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<Salutation>Mr.</Salutation>
<FirstName>ShannonAPI</FirstName>
<MiddleName>R</MiddleName>
<LastName>APIDaniels</LastName>
<ShipAddress>
<Addr1>56 Cowles Road</Addr1>
<City>Willington</City>
<State>CT</State>
</ShipAddress>
<Phone>1.860.634.1602</Phone>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
<SalesTaxCodeRef>
<ListID>10000-1211065841</ListID>
<FullName>Tax</FullName>
</SalesTaxCodeRef>
<ItemSalesTaxRef>
<ListID>10000-1211066051</ListID>
<FullName>Out of State</FullName>
</ItemSalesTaxRef>
<JobStatus>None</JobStatus>
</CustomerRet>
</CustomerQueryRs>
</QBXMLMsgsRs>
</QBXML>';

$requestID = 'Q3VzdG9tZXJRdWVyeXwwNjc1ZTk4MGFiYTg1MDNhNDRhYjM5ZWVhNjNiMGJkYw==';
$user = 'api';
$action = QUICKBOOKS_QUERY_CUSTOMER;
$ID = '0675e980aba8503a44ab39eea63b0bdc';
$extra = unserialize('a:7:{s:6:"method";s:35:"QuickBooks_API::getCustomerByListID";s:6:"action";s:13:"CustomerQuery";s:4:"type";s:8:"Customer";s:3:"api";b:1;s:5:"qbxml";s:220:"<?xml version="1.0" encoding="utf-8"?>
			<?qbxml version="{$version}"?>
			<QBXML>
				<QBXMLMsgsRq onError="{$onerror}"><CustomerQueryRq>
	<ListID>90000-1214366034</ListID>
</CustomerQueryRq>
</QBXMLMsgsRq>
			</QBXML>";s:8:"uniqueid";s:32:"0675e980aba8503a44ab39eea63b0bdc";s:9:"callbacks";a:1:{i:0;s:34:"my_get_customer_by_listid_callback";}}');
$err = '';
$last_action_time = time();
$last_actionident_time = time();
$idents = array();

QuickBooks_Server_API_Callbacks::CustomerQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

function my_get_customer_by_listid_callback($method, $action, $ID, $err, $qbxml, $qbiterator, $qbres)
{
	while ($qbobject = $qbiterator->next())
	{
		print('Customer name was: ' . $qbobject->getName() . "\n");
		print('	Ship to: ' . $qbobject->getShipAddress('Addr1') . "\n");
		print('		' . $qbobject->getShipAddress('City') . "\n");
	}
	
	return true;
}

print('error was: ' . $err . "\n");

?>