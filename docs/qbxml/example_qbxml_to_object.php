<?php

/**
 * Examples of converting qbXML to QuickBooks_Object_* classes, and vice-versa
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Plain test
header('Content-Type: text/plain');

// include path
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/keithpalmerjr/Projects/QuickBooks/');

// error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

/**  
 * Require the QuickBooks framework code
 */
require_once '../QuickBooks.php';

/*
// Our qbXML string
$qbxml = '
	<SalesReceiptRet>
		<TxnID>141CA5-1231522949</TxnID>
		<TimeCreated>2009-01-09T12:42:29-05:00</TimeCreated>
		<TimeModified>2009-01-09T12:42:29-05:00</TimeModified>
		<EditSequence>1231522949</EditSequence>
		<TxnNumber>64951</TxnNumber>
		<CustomerRef>
			<ListID>80003579-1231522938</ListID>
			<FullName>Test, Tom</FullName>
		</CustomerRef>
		<TemplateRef>
			<ListID>E0000-1129903256</ListID>
			<FullName>Custom Sales Receipt</FullName>
		</TemplateRef>
		<TxnDate>2009-01-09</TxnDate>
		<RefNumber>16466</RefNumber>
		<BillAddress>
			<Addr1>Tom Test</Addr1>
			<Addr2>123 Test St</Addr2>
			<City>Concord</City>
			<State>MA</State>
			<PostalCode>01742</PostalCode>
			<Country>USA</Country>
		</BillAddress>
		<BillAddressBlock>
			<Addr1>Tom Test</Addr1>
			<Addr3>123 Test St</Addr3>
			<Addr4>Concord, Massachusetts 01742</Addr4>
			<Addr5>United States</Addr5>
		</BillAddressBlock>
		<IsPending>true</IsPending>
		<DueDate>2009-01-09</DueDate>
		<ShipDate>2009-01-09</ShipDate>
		<Subtotal>150.00</Subtotal>
		<ItemSalesTaxRef>
			<ListID>20C0000-1129494968</ListID>
			<FullName>MA State Tax</FullName>
		</ItemSalesTaxRef>
		<SalesTaxPercentage>5.00</SalesTaxPercentage>
		<SalesTaxTotal>0.00</SalesTaxTotal>
		<TotalAmount>150.00</TotalAmount>
		<IsToBePrinted>true</IsToBePrinted>
		<IsToBeEmailed>false</IsToBeEmailed>
		<CustomerSalesTaxCodeRef>
			<ListID>10000-1128983215</ListID>
			<FullName>Tax</FullName>
		</CustomerSalesTaxCodeRef>
		<DepositToAccountRef>
			<ListID>960000-1129903123</ListID>
			<FullName>*Undeposited Funds</FullName>
		</DepositToAccountRef>
		<SalesReceiptLineRet>
			<TxnLineID>141CA7-1231522949</TxnLineID>
			<ItemRef>
				<ListID>200001-1143815300</ListID>
				<FullName>gift certificate</FullName>
			</ItemRef>
			<Desc>$150.00 gift certificate</Desc>
			<Quantity>1</Quantity>
			<Rate>150.00</Rate>
			<Amount>150.00</Amount>
			<SalesTaxCodeRef>
				<ListID>20000-1128983215</ListID>
				<FullName>Non</FullName>
			</SalesTaxCodeRef>
		</SalesReceiptLineRet>
		<SalesReceiptLineRet>
			<TxnLineID>141CA9-1231522949</TxnLineID>
			<ItemRef>
				<ListID>80000857-1231503074</ListID>
				<FullName>Handling Item - QuickBooks Inte</FullName>
			</ItemRef>
			<Desc>Handling Charge</Desc>
			<Rate>0.00</Rate>
			<Amount>0.00</Amount>
			<SalesTaxCodeRef>
				<ListID>20000-1128983215</ListID>
				<FullName>Non</FullName>
			</SalesTaxCodeRef>
		</SalesReceiptLineRet>
	</SalesReceiptRet>';

// Convert the qbXML string to an object
$Object = QuickBooks_Object::fromQBXML($qbxml);

// Print the object
print_r($Object);

// Now, convert it back to qbXML, as an ADD
print($Object->asQBXML(QUICKBOOKS_ADD_SALESRECEIPT));

// If you already have it as an XML document, you can convert that too
$errnum = null;
$errmsg = null;
$Parser = new QuickBooks_XML_Parser($qbxml);
if ($Doc = $Parser->parse($errnum, $errmsg))
{
	$Root = $Doc->getRoot();
	
	$Object = QuickBooks_Object::fromXML($Root);
	
	// Print it out
	print_r($Object);
}

// Another test... 
$qbxml = '
	<CustomerRet>
		<ListID>10006-1211236622</ListID>
		<TimeCreated>2008-05-19T18:37:02-05:00</TimeCreated>
		<TimeModified>2008-06-10T23:35:56-05:00</TimeModified>
		<EditSequence>1213155356</EditSequence>
		<Name>Keith Palmer</Name>
		<FullName>Keith Palmer</FullName>
		<IsActive>true</IsActive>
		<Sublevel>0</Sublevel>
		<FirstName>Keith</FirstName>
		<LastName>Palmer</LastName>
		<BillAddress>
			<Addr1>134 Stonemill Road</Addr1>
			<Addr2>Suite D</Addr2>
			<City>Storrs</City>
			<State>CT</State>
			<PostalCode>06268</PostalCode>
			<Country>USA</Country>
		</BillAddress>
		<ShipAddress>
			<Addr1>134 Stonemill Road</Addr1>
			<Addr2>Suite D</Addr2>
			<City>Storrs</City>
			<State>CT</State>
			<PostalCode>06268</PostalCode>
			<Country>USA</Country>
		</ShipAddress>
		<Phone>(860) 634-1602</Phone>
		<Fax>(860) 429-5182</Fax>
		<Email>keith@uglyslug.com</Email>
		<Balance>250.00</Balance>
		<TotalBalance>250.00</TotalBalance>
		<SalesTaxCodeRef>
			<ListID>20000-1211065841</ListID>
			<FullName>Non</FullName>
		</SalesTaxCodeRef>
		<ItemSalesTaxRef>
			<ListID>10000-1211066051</ListID>
			<FullName>Out of State</FullName>
		</ItemSalesTaxRef>
		<JobStatus>None</JobStatus>
	</CustomerRet>';

// Create the customer
$Object = QuickBooks_Object::fromQBXML($qbxml);

// Print it out
print_r($Object);

// Does it work for qbXML ADD requests too? 
$qbxml = '
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
	</CustomerAdd>';

// Create it...
$Object = QuickBooks_Object::fromQBXML($qbxml);

// Print it...
print_r($Object);

// How about with vendors from QuickBooks Online Edition?
$qbxml = '<VendorRet>
		<ListID>146</ListID>
		<TimeCreated>2009-10-24T00:34:07</TimeCreated>
		<TimeModified>2009-11-05T03:13:46</TimeModified>
		<EditSequence>19</EditSequence>
		<Name>Automotive Core Supply</Name>
		<CompanyName>Automotive Core Supply</CompanyName>
		<FirstName>Automotive</FirstName>
		<LastName>Core Supply</LastName>
		<VendorAddress>
			<City>Worcester</City>
			<State>MA</State>
			<PostalCode>03546</PostalCode>
			<Country>US</Country>
		</VendorAddress>
		<Phone>9884040132</Phone>
		<Fax>9884040132</Fax>
		<Email>baburaj@securenext.net</Email>
		<NameOnCheck>Automotive Core Supply</NameOnCheck>
		<AccountNumber>0014000000OvgNBAAZ</AccountNumber>
		<IsVendorEligibleFor1099>false</IsVendorEligibleFor1099>
		<Balance>0.00</Balance>
	</VendorRet>';

// Create the object from the qbXML
$Object = QuickBooks_Object::fromQBXML($qbxml);

// Print it
print_r($Object);

print($Object->asQBXML(QUICKBOOKS_ADD_VENDOR));
*/

/*
// Does it work for sales tax item groups?
$qbxml = '<ItemSalesTaxGroupRet>
		<ListID>4E0000-1044396142</ListID>
		<TimeCreated>2009-11-05T03:13:13</TimeCreated>
		<TimeModified>2009-11-05T03:13:13</TimeModified>
		<EditSequence>1044396142</EditSequence>
		<Name>CO TAX</Name>
		<IsActive>true</IsActive>
		<ItemDesc>CO Combined Sales Tax</ItemDesc>
		<ItemSalesTaxRef>
			<ListID>CO Sales Tax</ListID>
			<FullName>5F0000-1044396142</FullName>
		</ItemSalesTaxRef>
		<ItemSalesTaxRef>
			<ListID>610000-1044396142</ListID>
			<FullName>RTD</FullName>
		</ItemSalesTaxRef>
	</ItemSalesTaxGroupRet>';

// Create it...
$Object = QuickBooks_Object::fromQBXML($qbxml);

// Print it...
print_r($Object);

// ... and some qbXML for good measure! 
print('[' . $Object->object() . ']: ' . $Object->asQBXML(QUICKBOOKS_ADD_SALESTAXGROUPITEM));
*/

// Does it work for service items?
$qbxml = '<ItemServiceRet>
<ListID>280001-1265079883</ListID>
<TimeCreated>2010-02-01T22:04:43-05:00</TimeCreated>
<TimeModified>2010-02-01T22:04:43-05:00</TimeModified>
<EditSequence>1265079883</EditSequence>
<Name>Crazy Horse</Name>
<FullName>Crazy Horse</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<SalesTaxCodeRef>
<ListID>10000-1211065841</ListID>
<FullName>Tax</FullName>
</SalesTaxCodeRef>
<SalesOrPurchase>
<Price>0.00</Price>
<AccountRef>
<ListID>440000-1265079854</ListID>
<FullName>Consulting Income</FullName>
</AccountRef>
</SalesOrPurchase>
</ItemServiceRet>';

$Object = QuickBooks_QBXML_Object::fromQBXML($qbxml, QUICKBOOKS_QUERY_ITEM);

print('[' . $Object->object() . ']: ' . $Object->asQBXML(QUICKBOOKS_ADD_SERVICEITEM));
