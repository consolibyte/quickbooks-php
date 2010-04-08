<?php

print("\n\n");

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks');
require_once 'QuickBooks.php';


$SalesReceipt = new QuickBooks_Object_SalesReceipt();

	$SalesReceiptShippingLine = new QuickBooks_Object_SalesReceipt_ShippingLine();		
	$SalesReceiptShippingLine->setAmount(25);
	$SalesReceipt->addShippingLine($SalesReceiptShippingLine);



	$SalesReceiptSalesTaxLine = new QuickBooks_Object_SalesReceipt_SalesTaxLine();		
	$SalesReceiptSalesTaxLine->setAmount(25);
	$SalesReceipt->addSalesTaxLine($SalesReceiptSalesTaxLine);


	$SalesReceiptDiscountLine = new QuickBooks_Object_SalesReceipt_DiscountLine();		
	$SalesReceiptDiscountLine->setAmount(25);
	$SalesReceipt->addDiscountLine($SalesReceiptDiscountLine);


$Line = new QuickBooks_Object_SalesReceipt_SalesReceiptLine();
$Line->setAmount(25);
$Line->setQuantity(5);
$Line->setItemName('Keiths Item');

$SalesReceipt->addSalesReceiptLine($Line);

print_r($SalesReceipt);

print($SalesReceipt->asQBXML(QUICKBOOKS_ADD_SALESRECEIPT));

exit;


$JournalEntry = new QuickBooks_Object_JournalEntry();

$JournalEntry->setTransactionDate('2009-02-02');

$DebitLine = new QuickBooks_Object_JournalEntry_JournalDebitLine();
$DebitLine->setAmount(45.0);
$DebitLine->setAccountName('Test');
$JournalEntry->addDebitLine($DebitLine);


$CreditLine1 = new QuickBooks_Object_JournalEntry_JournalCreditLine();
$CreditLine1->setAmount(25.0);
$CreditLine1->setAccountName('Services');
$JournalEntry->addCreditLine($CreditLine1);

$CreditLine2 = new QuickBooks_Object_JournalEntry_JournalCreditLine();
$CreditLine2->setAmount(20.0);
$CreditLine2->setAccountName('Sales');
$JournalEntry->addCreditLine($CreditLine2);

//print_r($JournalEntry);


print($JournalEntry->asQBXML(QUICKBOOKS_ADD_JOURNALENTRY));

exit;

$Customer = new QuickBooks_Object_Customer();
$Customer->setFirstName('Keith');
$Customer->set('LastName', 'Palmer');

$Customer->set('ShipAddress Addr1', '56 Cowles Road');

$Customer->setShipAddress('56 Cowles Road', '', '', '', '', 'Willington', 'CT');

$defaults = array(
	'ShipAddress Addr2' => 'bla', 
	'ShipAddress Country' => 'United States', 
	);

//print_r($Customer->getShipAddress(null, $defaults));

//print($Customer->asXML(QUICKBOOKS_OBJECT_XML_DROP, "\t", 'CustomerAdd'));

print("\n\n");

$arr = array(
	'ModifiedDateRangeFilter' => array(
		'FromModifiedDate' => 'test', 
		), 
	'ModifiedDateRangeFilter ToModifiedDate' => 'test', 
	);

$Invoice = new QuickBooks_Object_Invoice($arr);

$qbxml = $Invoice->asQBXML('InvoiceQueryRq');
print($qbxml);

print("\n\n");

/*
$xml = '
<XML>
<Customer>
<FirstName>Keith</FirstName>
</Customer>
</XML>
';

$Parser = new QuickBooks_XML($xml);
$errnum = 0;
$errmsg = '';
$Doc = $Parser->parse($errnum, $errmsg);

$Doc->addChildAt('XML Customer Deeper AndDeeper', new QuickBooks_XML_Node('LastName'), true);

$Doc->addChildAt('XML Customer', new QuickBooks_XML_Node('LastName'));
$Doc->setChildDataAt('XML Customer LastName', 'data goes here');

//print_r($Doc);

print($Doc->asXML());

print('First name: ' . $Doc->getChildDataAt('XML Customer FirstName'));

print("\n\n");
*/

?>