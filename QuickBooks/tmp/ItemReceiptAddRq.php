<?php

/**
 * Schema object for: ItemReceiptAddRq
 * 
 * @author "Keith Palmer Jr." <Keith@ConsoliByte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage QBXML
 */

/**
 * 
 */
require_once 'QuickBooks.php';

/**
 * 
 */
require_once 'QuickBooks/QBXML/Schema/Object.php';

/**
 * 
 */
class QuickBooks_QBXML_Schema_Object_ItemReceiptAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ItemReceiptAdd VendorRef ListID' => 'IDTYPE',
  'ItemReceiptAdd VendorRef FullName' => 'STRTYPE',
  'ItemReceiptAdd APAccountRef ListID' => 'IDTYPE',
  'ItemReceiptAdd APAccountRef FullName' => 'STRTYPE',
  'ItemReceiptAdd TxnDate' => 'DATETYPE',
  'ItemReceiptAdd RefNumber' => 'STRTYPE',
  'ItemReceiptAdd Memo' => 'STRTYPE',
  'ItemReceiptAdd LinkToTxnID' => 'IDTYPE',
  'ItemReceiptAdd ExpenseLineAdd AccountRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ExpenseLineAdd AccountRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ExpenseLineAdd Amount' => 'AMTTYPE',
  'ItemReceiptAdd ExpenseLineAdd TaxAmount' => 'AMTTYPE',
  'ItemReceiptAdd ExpenseLineAdd Memo' => 'STRTYPE',
  'ItemReceiptAdd ExpenseLineAdd CustomerRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ExpenseLineAdd CustomerRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ExpenseLineAdd ClassRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ExpenseLineAdd ClassRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ExpenseLineAdd BillableStatus' => 'ENUMTYPE',
  'ItemReceiptAdd ItemLineAdd ItemRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ItemLineAdd ItemRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ItemLineAdd Desc' => 'STRTYPE',
  'ItemReceiptAdd ItemLineAdd Quantity' => 'QUANTYPE',
  'ItemReceiptAdd ItemLineAdd UnitOfMeasure' => 'STRTYPE',
  'ItemReceiptAdd ItemLineAdd Cost' => 'PRICETYPE',
  'ItemReceiptAdd ItemLineAdd Amount' => 'AMTTYPE',
  'ItemReceiptAdd ItemLineAdd TaxAmount' => 'AMTTYPE',
  'ItemReceiptAdd ItemLineAdd CustomerRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ItemLineAdd CustomerRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ItemLineAdd ClassRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ItemLineAdd ClassRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ItemLineAdd BillableStatus' => 'ENUMTYPE',
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnID' => 'IDTYPE',
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnLineID' => 'IDTYPE',
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef ListID' => 'IDTYPE',
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef FullName' => 'STRTYPE',
  'ItemReceiptAdd ItemGroupLineAdd Desc' => 'STRTYPE',
  'ItemReceiptAdd ItemGroupLineAdd Quantity' => 'QUANTYPE',
  'ItemReceiptAdd ItemGroupLineAdd UnitOfMeasure' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ItemReceiptAdd VendorRef ListID' => 0,
  'ItemReceiptAdd VendorRef FullName' => 41,
  'ItemReceiptAdd APAccountRef ListID' => 0,
  'ItemReceiptAdd APAccountRef FullName' => 41,
  'ItemReceiptAdd TxnDate' => 0,
  'ItemReceiptAdd RefNumber' => 20,
  'ItemReceiptAdd Memo' => 4095,
  'ItemReceiptAdd LinkToTxnID' => 0,
  'ItemReceiptAdd ExpenseLineAdd AccountRef ListID' => 0,
  'ItemReceiptAdd ExpenseLineAdd AccountRef FullName' => 41,
  'ItemReceiptAdd ExpenseLineAdd Amount' => 0,
  'ItemReceiptAdd ExpenseLineAdd TaxAmount' => 0,
  'ItemReceiptAdd ExpenseLineAdd Memo' => 4095,
  'ItemReceiptAdd ExpenseLineAdd CustomerRef ListID' => 0,
  'ItemReceiptAdd ExpenseLineAdd CustomerRef FullName' => 41,
  'ItemReceiptAdd ExpenseLineAdd ClassRef ListID' => 0,
  'ItemReceiptAdd ExpenseLineAdd ClassRef FullName' => 41,
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 0,
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 41,
  'ItemReceiptAdd ExpenseLineAdd BillableStatus' => 0,
  'ItemReceiptAdd ItemLineAdd ItemRef ListID' => 0,
  'ItemReceiptAdd ItemLineAdd ItemRef FullName' => 41,
  'ItemReceiptAdd ItemLineAdd Desc' => 4095,
  'ItemReceiptAdd ItemLineAdd Quantity' => 0,
  'ItemReceiptAdd ItemLineAdd UnitOfMeasure' => 31,
  'ItemReceiptAdd ItemLineAdd Cost' => 0,
  'ItemReceiptAdd ItemLineAdd Amount' => 0,
  'ItemReceiptAdd ItemLineAdd TaxAmount' => 0,
  'ItemReceiptAdd ItemLineAdd CustomerRef ListID' => 0,
  'ItemReceiptAdd ItemLineAdd CustomerRef FullName' => 41,
  'ItemReceiptAdd ItemLineAdd ClassRef ListID' => 0,
  'ItemReceiptAdd ItemLineAdd ClassRef FullName' => 41,
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef ListID' => 0,
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef FullName' => 41,
  'ItemReceiptAdd ItemLineAdd BillableStatus' => 0,
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef ListID' => 0,
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef FullName' => 41,
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnID' => 0,
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnLineID' => 0,
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef ListID' => 0,
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef FullName' => 41,
  'ItemReceiptAdd ItemGroupLineAdd Desc' => 4095,
  'ItemReceiptAdd ItemGroupLineAdd Quantity' => 0,
  'ItemReceiptAdd ItemGroupLineAdd UnitOfMeasure' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ItemReceiptAdd VendorRef ListID' => true,
  'ItemReceiptAdd VendorRef FullName' => true,
  'ItemReceiptAdd APAccountRef ListID' => true,
  'ItemReceiptAdd APAccountRef FullName' => true,
  'ItemReceiptAdd TxnDate' => true,
  'ItemReceiptAdd RefNumber' => true,
  'ItemReceiptAdd Memo' => true,
  'ItemReceiptAdd LinkToTxnID' => true,
  'ItemReceiptAdd ExpenseLineAdd AccountRef ListID' => true,
  'ItemReceiptAdd ExpenseLineAdd AccountRef FullName' => true,
  'ItemReceiptAdd ExpenseLineAdd Amount' => true,
  'ItemReceiptAdd ExpenseLineAdd TaxAmount' => true,
  'ItemReceiptAdd ExpenseLineAdd Memo' => true,
  'ItemReceiptAdd ExpenseLineAdd CustomerRef ListID' => true,
  'ItemReceiptAdd ExpenseLineAdd CustomerRef FullName' => true,
  'ItemReceiptAdd ExpenseLineAdd ClassRef ListID' => true,
  'ItemReceiptAdd ExpenseLineAdd ClassRef FullName' => true,
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef ListID' => true,
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef FullName' => true,
  'ItemReceiptAdd ExpenseLineAdd BillableStatus' => true,
  'ItemReceiptAdd ItemLineAdd ItemRef ListID' => true,
  'ItemReceiptAdd ItemLineAdd ItemRef FullName' => true,
  'ItemReceiptAdd ItemLineAdd Desc' => true,
  'ItemReceiptAdd ItemLineAdd Quantity' => true,
  'ItemReceiptAdd ItemLineAdd UnitOfMeasure' => true,
  'ItemReceiptAdd ItemLineAdd Cost' => true,
  'ItemReceiptAdd ItemLineAdd Amount' => true,
  'ItemReceiptAdd ItemLineAdd TaxAmount' => true,
  'ItemReceiptAdd ItemLineAdd CustomerRef ListID' => true,
  'ItemReceiptAdd ItemLineAdd CustomerRef FullName' => true,
  'ItemReceiptAdd ItemLineAdd ClassRef ListID' => true,
  'ItemReceiptAdd ItemLineAdd ClassRef FullName' => true,
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef ListID' => true,
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef FullName' => true,
  'ItemReceiptAdd ItemLineAdd BillableStatus' => true,
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef ListID' => true,
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef FullName' => true,
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnID' => false,
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnLineID' => false,
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef ListID' => true,
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef FullName' => true,
  'ItemReceiptAdd ItemGroupLineAdd Desc' => true,
  'ItemReceiptAdd ItemGroupLineAdd Quantity' => true,
  'ItemReceiptAdd ItemGroupLineAdd UnitOfMeasure' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ItemReceiptAdd VendorRef ListID' => 999.99,
  'ItemReceiptAdd VendorRef FullName' => 999.99,
  'ItemReceiptAdd APAccountRef ListID' => 999.99,
  'ItemReceiptAdd APAccountRef FullName' => 999.99,
  'ItemReceiptAdd TxnDate' => 999.99,
  'ItemReceiptAdd RefNumber' => 999.99,
  'ItemReceiptAdd Memo' => 999.99,
  'ItemReceiptAdd LinkToTxnID' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd AccountRef ListID' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd AccountRef FullName' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd Amount' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd TaxAmount' => 6.1,
  'ItemReceiptAdd ExpenseLineAdd Memo' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd CustomerRef ListID' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd CustomerRef FullName' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd ClassRef ListID' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd ClassRef FullName' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 999.99,
  'ItemReceiptAdd ExpenseLineAdd BillableStatus' => 2,
  'ItemReceiptAdd ItemLineAdd ItemRef ListID' => 999.99,
  'ItemReceiptAdd ItemLineAdd ItemRef FullName' => 999.99,
  'ItemReceiptAdd ItemLineAdd Desc' => 999.99,
  'ItemReceiptAdd ItemLineAdd Quantity' => 999.99,
  'ItemReceiptAdd ItemLineAdd UnitOfMeasure' => 7,
  'ItemReceiptAdd ItemLineAdd Cost' => 999.99,
  'ItemReceiptAdd ItemLineAdd Amount' => 999.99,
  'ItemReceiptAdd ItemLineAdd TaxAmount' => 6.1,
  'ItemReceiptAdd ItemLineAdd CustomerRef ListID' => 999.99,
  'ItemReceiptAdd ItemLineAdd CustomerRef FullName' => 999.99,
  'ItemReceiptAdd ItemLineAdd ClassRef ListID' => 999.99,
  'ItemReceiptAdd ItemLineAdd ClassRef FullName' => 999.99,
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef ListID' => 999.99,
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef FullName' => 999.99,
  'ItemReceiptAdd ItemLineAdd BillableStatus' => 2,
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef ListID' => 999.99,
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef FullName' => 999.99,
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnID' => 999.99,
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnLineID' => 999.99,
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef ListID' => 999.99,
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef FullName' => 999.99,
  'ItemReceiptAdd ItemGroupLineAdd Desc' => 999.99,
  'ItemReceiptAdd ItemGroupLineAdd Quantity' => 999.99,
  'ItemReceiptAdd ItemGroupLineAdd UnitOfMeasure' => 7,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ItemReceiptAdd VendorRef ListID' => false,
  'ItemReceiptAdd VendorRef FullName' => false,
  'ItemReceiptAdd APAccountRef ListID' => false,
  'ItemReceiptAdd APAccountRef FullName' => false,
  'ItemReceiptAdd TxnDate' => false,
  'ItemReceiptAdd RefNumber' => false,
  'ItemReceiptAdd Memo' => false,
  'ItemReceiptAdd LinkToTxnID' => true,
  'ItemReceiptAdd ExpenseLineAdd AccountRef ListID' => false,
  'ItemReceiptAdd ExpenseLineAdd AccountRef FullName' => false,
  'ItemReceiptAdd ExpenseLineAdd Amount' => false,
  'ItemReceiptAdd ExpenseLineAdd TaxAmount' => false,
  'ItemReceiptAdd ExpenseLineAdd Memo' => false,
  'ItemReceiptAdd ExpenseLineAdd CustomerRef ListID' => false,
  'ItemReceiptAdd ExpenseLineAdd CustomerRef FullName' => false,
  'ItemReceiptAdd ExpenseLineAdd ClassRef ListID' => false,
  'ItemReceiptAdd ExpenseLineAdd ClassRef FullName' => false,
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef ListID' => false,
  'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef FullName' => false,
  'ItemReceiptAdd ExpenseLineAdd BillableStatus' => false,
  'ItemReceiptAdd ItemLineAdd ItemRef ListID' => false,
  'ItemReceiptAdd ItemLineAdd ItemRef FullName' => false,
  'ItemReceiptAdd ItemLineAdd Desc' => false,
  'ItemReceiptAdd ItemLineAdd Quantity' => false,
  'ItemReceiptAdd ItemLineAdd UnitOfMeasure' => false,
  'ItemReceiptAdd ItemLineAdd Cost' => false,
  'ItemReceiptAdd ItemLineAdd Amount' => false,
  'ItemReceiptAdd ItemLineAdd TaxAmount' => false,
  'ItemReceiptAdd ItemLineAdd CustomerRef ListID' => false,
  'ItemReceiptAdd ItemLineAdd CustomerRef FullName' => false,
  'ItemReceiptAdd ItemLineAdd ClassRef ListID' => false,
  'ItemReceiptAdd ItemLineAdd ClassRef FullName' => false,
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef ListID' => false,
  'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef FullName' => false,
  'ItemReceiptAdd ItemLineAdd BillableStatus' => false,
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef ListID' => false,
  'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef FullName' => false,
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnID' => false,
  'ItemReceiptAdd ItemLineAdd LinkToTxn TxnLineID' => false,
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef ListID' => false,
  'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef FullName' => false,
  'ItemReceiptAdd ItemGroupLineAdd Desc' => false,
  'ItemReceiptAdd ItemGroupLineAdd Quantity' => false,
  'ItemReceiptAdd ItemGroupLineAdd UnitOfMeasure' => false,
  'IncludeRetElement' => true,
);
			
		return $paths;
	}
	
	/*
	abstract protected function &_inLocalePaths()
	{
		static $paths = array(
			'FirstName' => array( 'QBD', 'QBCA', 'QBUK', 'QBAU' ), 
			'LastName' => array( 'QBD', 'QBCA', 'QBUK', 'QBAU' ),
			);
		
		return $paths;
	}
	*/
	
	protected function &_reorderPathsPaths()
	{
		static $paths = array (
  0 => 'ItemReceiptAdd',
  1 => 'ItemReceiptAdd VendorRef',
  2 => 'ItemReceiptAdd VendorRef ListID',
  3 => 'ItemReceiptAdd VendorRef FullName',
  4 => 'ItemReceiptAdd APAccountRef ListID',
  5 => 'ItemReceiptAdd APAccountRef FullName',
  6 => 'ItemReceiptAdd TxnDate',
  7 => 'ItemReceiptAdd RefNumber',
  8 => 'ItemReceiptAdd Memo',
  9 => 'ItemReceiptAdd LinkToTxnID',
  10 => 'ItemReceiptAdd',
  11 => 'ItemReceiptAdd ExpenseLineAdd',
  12 => 'ItemReceiptAdd ExpenseLineAdd AccountRef',
  13 => 'ItemReceiptAdd ExpenseLineAdd AccountRef ListID',
  14 => 'ItemReceiptAdd ExpenseLineAdd AccountRef FullName',
  15 => 'ItemReceiptAdd ExpenseLineAdd Amount',
  16 => 'ItemReceiptAdd ExpenseLineAdd TaxAmount',
  17 => 'ItemReceiptAdd ExpenseLineAdd Memo',
  18 => 'ItemReceiptAdd ExpenseLineAdd CustomerRef ListID',
  19 => 'ItemReceiptAdd ExpenseLineAdd CustomerRef FullName',
  20 => 'ItemReceiptAdd ExpenseLineAdd ClassRef ListID',
  21 => 'ItemReceiptAdd ExpenseLineAdd ClassRef FullName',
  22 => 'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef ListID',
  23 => 'ItemReceiptAdd ExpenseLineAdd SalesTaxCodeRef FullName',
  24 => 'ItemReceiptAdd ExpenseLineAdd BillableStatus',
  25 => 'ItemReceiptAdd ItemLineAdd ItemRef ListID',
  26 => 'ItemReceiptAdd ItemLineAdd ItemRef FullName',
  27 => 'ItemReceiptAdd ItemLineAdd Desc',
  28 => 'ItemReceiptAdd ItemLineAdd Quantity',
  29 => 'ItemReceiptAdd ItemLineAdd UnitOfMeasure',
  30 => 'ItemReceiptAdd ItemLineAdd Cost',
  31 => 'ItemReceiptAdd ItemLineAdd Amount',
  32 => 'ItemReceiptAdd ItemLineAdd TaxAmount',
  33 => 'ItemReceiptAdd ItemLineAdd CustomerRef ListID',
  34 => 'ItemReceiptAdd ItemLineAdd CustomerRef FullName',
  35 => 'ItemReceiptAdd ItemLineAdd ClassRef ListID',
  36 => 'ItemReceiptAdd ItemLineAdd ClassRef FullName',
  37 => 'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef ListID',
  38 => 'ItemReceiptAdd ItemLineAdd SalesTaxCodeRef FullName',
  39 => 'ItemReceiptAdd ItemLineAdd BillableStatus',
  40 => 'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef ListID',
  41 => 'ItemReceiptAdd ItemLineAdd OverrideItemAccountRef FullName',
  42 => 'ItemReceiptAdd ItemLineAdd LinkToTxn TxnID',
  43 => 'ItemReceiptAdd ItemLineAdd LinkToTxn TxnLineID',
  44 => 'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef ListID',
  45 => 'ItemReceiptAdd ItemGroupLineAdd ItemGroupRef FullName',
  46 => 'ItemReceiptAdd ItemGroupLineAdd Desc',
  47 => 'ItemReceiptAdd ItemGroupLineAdd Quantity',
  48 => 'ItemReceiptAdd ItemGroupLineAdd UnitOfMeasure',
  49 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>