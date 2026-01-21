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
		static $wrapper = 'ItemReceiptAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'VendorRef ListID' => 'IDTYPE',
  'VendorRef FullName' => 'STRTYPE',
  'APAccountRef ListID' => 'IDTYPE',
  'APAccountRef FullName' => 'STRTYPE',
  'TxnDate' => 'DATETYPE',
  'RefNumber' => 'STRTYPE',
  'Memo' => 'STRTYPE',
  'LinkToTxnID' => 'IDTYPE',
  'ExpenseLineAdd AccountRef ListID' => 'IDTYPE',
  'ExpenseLineAdd AccountRef FullName' => 'STRTYPE',
  'ExpenseLineAdd Amount' => 'AMTTYPE',
  'ExpenseLineAdd TaxAmount' => 'AMTTYPE',
  'ExpenseLineAdd Memo' => 'STRTYPE',
  'ExpenseLineAdd CustomerRef ListID' => 'IDTYPE',
  'ExpenseLineAdd CustomerRef FullName' => 'STRTYPE',
  'ExpenseLineAdd ClassRef ListID' => 'IDTYPE',
  'ExpenseLineAdd ClassRef FullName' => 'STRTYPE',
  'ExpenseLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'ExpenseLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'ExpenseLineAdd BillableStatus' => 'ENUMTYPE',
  'ItemLineAdd ItemRef ListID' => 'IDTYPE',
  'ItemLineAdd ItemRef FullName' => 'STRTYPE',
  'ItemLineAdd Desc' => 'STRTYPE',
  'ItemLineAdd Quantity' => 'QUANTYPE',
  'ItemLineAdd UnitOfMeasure' => 'STRTYPE',
  'ItemLineAdd Cost' => 'PRICETYPE',
  'ItemLineAdd Amount' => 'AMTTYPE',
  'ItemLineAdd TaxAmount' => 'AMTTYPE',
  'ItemLineAdd CustomerRef ListID' => 'IDTYPE',
  'ItemLineAdd CustomerRef FullName' => 'STRTYPE',
  'ItemLineAdd ClassRef ListID' => 'IDTYPE',
  'ItemLineAdd ClassRef FullName' => 'STRTYPE',
  'ItemLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'ItemLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'ItemLineAdd BillableStatus' => 'ENUMTYPE',
  'ItemLineAdd OverrideItemAccountRef ListID' => 'IDTYPE',
  'ItemLineAdd OverrideItemAccountRef FullName' => 'STRTYPE',
  'ItemLineAdd LinkToTxn TxnID' => 'IDTYPE',
  'ItemLineAdd LinkToTxn TxnLineID' => 'IDTYPE',
  'ItemGroupLineAdd ItemGroupRef ListID' => 'IDTYPE',
  'ItemGroupLineAdd ItemGroupRef FullName' => 'STRTYPE',
  'ItemGroupLineAdd Desc' => 'STRTYPE',
  'ItemGroupLineAdd Quantity' => 'QUANTYPE',
  'ItemGroupLineAdd UnitOfMeasure' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'VendorRef ListID' => 0,
  'VendorRef FullName' => 41,
  'APAccountRef ListID' => 0,
  'APAccountRef FullName' => 41,
  'TxnDate' => 0,
  'RefNumber' => 20,
  'Memo' => 4095,
  'LinkToTxnID' => 0,
  'ExpenseLineAdd AccountRef ListID' => 0,
  'ExpenseLineAdd AccountRef FullName' => 41,
  'ExpenseLineAdd Amount' => 0,
  'ExpenseLineAdd TaxAmount' => 0,
  'ExpenseLineAdd Memo' => 4095,
  'ExpenseLineAdd CustomerRef ListID' => 0,
  'ExpenseLineAdd CustomerRef FullName' => 41,
  'ExpenseLineAdd ClassRef ListID' => 0,
  'ExpenseLineAdd ClassRef FullName' => 41,
  'ExpenseLineAdd SalesTaxCodeRef ListID' => 0,
  'ExpenseLineAdd SalesTaxCodeRef FullName' => 41,
  'ExpenseLineAdd BillableStatus' => 0,
  'ItemLineAdd ItemRef ListID' => 0,
  'ItemLineAdd ItemRef FullName' => 41,
  'ItemLineAdd Desc' => 4095,
  'ItemLineAdd Quantity' => 0,
  'ItemLineAdd UnitOfMeasure' => 31,
  'ItemLineAdd Cost' => 0,
  'ItemLineAdd Amount' => 0,
  'ItemLineAdd TaxAmount' => 0,
  'ItemLineAdd CustomerRef ListID' => 0,
  'ItemLineAdd CustomerRef FullName' => 41,
  'ItemLineAdd ClassRef ListID' => 0,
  'ItemLineAdd ClassRef FullName' => 41,
  'ItemLineAdd SalesTaxCodeRef ListID' => 0,
  'ItemLineAdd SalesTaxCodeRef FullName' => 41,
  'ItemLineAdd BillableStatus' => 0,
  'ItemLineAdd OverrideItemAccountRef ListID' => 0,
  'ItemLineAdd OverrideItemAccountRef FullName' => 41,
  'ItemLineAdd LinkToTxn TxnID' => 0,
  'ItemLineAdd LinkToTxn TxnLineID' => 0,
  'ItemGroupLineAdd ItemGroupRef ListID' => 0,
  'ItemGroupLineAdd ItemGroupRef FullName' => 41,
  'ItemGroupLineAdd Desc' => 4095,
  'ItemGroupLineAdd Quantity' => 0,
  'ItemGroupLineAdd UnitOfMeasure' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'VendorRef ListID' => true,
  'VendorRef FullName' => true,
  'APAccountRef ListID' => true,
  'APAccountRef FullName' => true,
  'TxnDate' => true,
  'RefNumber' => true,
  'Memo' => true,
  'LinkToTxnID' => true,
  'ExpenseLineAdd AccountRef ListID' => true,
  'ExpenseLineAdd AccountRef FullName' => true,
  'ExpenseLineAdd Amount' => true,
  'ExpenseLineAdd TaxAmount' => true,
  'ExpenseLineAdd Memo' => true,
  'ExpenseLineAdd CustomerRef ListID' => true,
  'ExpenseLineAdd CustomerRef FullName' => true,
  'ExpenseLineAdd ClassRef ListID' => true,
  'ExpenseLineAdd ClassRef FullName' => true,
  'ExpenseLineAdd SalesTaxCodeRef ListID' => true,
  'ExpenseLineAdd SalesTaxCodeRef FullName' => true,
  'ExpenseLineAdd BillableStatus' => true,
  'ItemLineAdd ItemRef ListID' => true,
  'ItemLineAdd ItemRef FullName' => true,
  'ItemLineAdd Desc' => true,
  'ItemLineAdd Quantity' => true,
  'ItemLineAdd UnitOfMeasure' => true,
  'ItemLineAdd Cost' => true,
  'ItemLineAdd Amount' => true,
  'ItemLineAdd TaxAmount' => true,
  'ItemLineAdd CustomerRef ListID' => true,
  'ItemLineAdd CustomerRef FullName' => true,
  'ItemLineAdd ClassRef ListID' => true,
  'ItemLineAdd ClassRef FullName' => true,
  'ItemLineAdd SalesTaxCodeRef ListID' => true,
  'ItemLineAdd SalesTaxCodeRef FullName' => true,
  'ItemLineAdd BillableStatus' => true,
  'ItemLineAdd OverrideItemAccountRef ListID' => true,
  'ItemLineAdd OverrideItemAccountRef FullName' => true,
  'ItemLineAdd LinkToTxn TxnID' => false,
  'ItemLineAdd LinkToTxn TxnLineID' => false,
  'ItemGroupLineAdd ItemGroupRef ListID' => true,
  'ItemGroupLineAdd ItemGroupRef FullName' => true,
  'ItemGroupLineAdd Desc' => true,
  'ItemGroupLineAdd Quantity' => true,
  'ItemGroupLineAdd UnitOfMeasure' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'VendorRef ListID' => 999.99,
  'VendorRef FullName' => 999.99,
  'APAccountRef ListID' => 999.99,
  'APAccountRef FullName' => 999.99,
  'TxnDate' => 999.99,
  'RefNumber' => 999.99,
  'Memo' => 999.99,
  'LinkToTxnID' => 999.99,
  'ExpenseLineAdd AccountRef ListID' => 999.99,
  'ExpenseLineAdd AccountRef FullName' => 999.99,
  'ExpenseLineAdd Amount' => 999.99,
  'ExpenseLineAdd TaxAmount' => 6.1,
  'ExpenseLineAdd Memo' => 999.99,
  'ExpenseLineAdd CustomerRef ListID' => 999.99,
  'ExpenseLineAdd CustomerRef FullName' => 999.99,
  'ExpenseLineAdd ClassRef ListID' => 999.99,
  'ExpenseLineAdd ClassRef FullName' => 999.99,
  'ExpenseLineAdd SalesTaxCodeRef ListID' => 999.99,
  'ExpenseLineAdd SalesTaxCodeRef FullName' => 999.99,
  'ExpenseLineAdd BillableStatus' => 2,
  'ItemLineAdd ItemRef ListID' => 999.99,
  'ItemLineAdd ItemRef FullName' => 999.99,
  'ItemLineAdd Desc' => 999.99,
  'ItemLineAdd Quantity' => 999.99,
  'ItemLineAdd UnitOfMeasure' => 7,
  'ItemLineAdd Cost' => 999.99,
  'ItemLineAdd Amount' => 999.99,
  'ItemLineAdd TaxAmount' => 6.1,
  'ItemLineAdd CustomerRef ListID' => 999.99,
  'ItemLineAdd CustomerRef FullName' => 999.99,
  'ItemLineAdd ClassRef ListID' => 999.99,
  'ItemLineAdd ClassRef FullName' => 999.99,
  'ItemLineAdd SalesTaxCodeRef ListID' => 999.99,
  'ItemLineAdd SalesTaxCodeRef FullName' => 999.99,
  'ItemLineAdd BillableStatus' => 2,
  'ItemLineAdd OverrideItemAccountRef ListID' => 999.99,
  'ItemLineAdd OverrideItemAccountRef FullName' => 999.99,
  'ItemLineAdd LinkToTxn TxnID' => 999.99,
  'ItemLineAdd LinkToTxn TxnLineID' => 999.99,
  'ItemGroupLineAdd ItemGroupRef ListID' => 999.99,
  'ItemGroupLineAdd ItemGroupRef FullName' => 999.99,
  'ItemGroupLineAdd Desc' => 999.99,
  'ItemGroupLineAdd Quantity' => 999.99,
  'ItemGroupLineAdd UnitOfMeasure' => 7,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'VendorRef ListID' => false,
  'VendorRef FullName' => false,
  'APAccountRef ListID' => false,
  'APAccountRef FullName' => false,
  'TxnDate' => false,
  'RefNumber' => false,
  'Memo' => false,
  'LinkToTxnID' => true,
  'ExpenseLineAdd AccountRef ListID' => false,
  'ExpenseLineAdd AccountRef FullName' => false,
  'ExpenseLineAdd Amount' => false,
  'ExpenseLineAdd TaxAmount' => false,
  'ExpenseLineAdd Memo' => false,
  'ExpenseLineAdd CustomerRef ListID' => false,
  'ExpenseLineAdd CustomerRef FullName' => false,
  'ExpenseLineAdd ClassRef ListID' => false,
  'ExpenseLineAdd ClassRef FullName' => false,
  'ExpenseLineAdd SalesTaxCodeRef ListID' => false,
  'ExpenseLineAdd SalesTaxCodeRef FullName' => false,
  'ExpenseLineAdd BillableStatus' => false,
  'ItemLineAdd ItemRef ListID' => false,
  'ItemLineAdd ItemRef FullName' => false,
  'ItemLineAdd Desc' => false,
  'ItemLineAdd Quantity' => false,
  'ItemLineAdd UnitOfMeasure' => false,
  'ItemLineAdd Cost' => false,
  'ItemLineAdd Amount' => false,
  'ItemLineAdd TaxAmount' => false,
  'ItemLineAdd CustomerRef ListID' => false,
  'ItemLineAdd CustomerRef FullName' => false,
  'ItemLineAdd ClassRef ListID' => false,
  'ItemLineAdd ClassRef FullName' => false,
  'ItemLineAdd SalesTaxCodeRef ListID' => false,
  'ItemLineAdd SalesTaxCodeRef FullName' => false,
  'ItemLineAdd BillableStatus' => false,
  'ItemLineAdd OverrideItemAccountRef ListID' => false,
  'ItemLineAdd OverrideItemAccountRef FullName' => false,
  'ItemLineAdd LinkToTxn TxnID' => false,
  'ItemLineAdd LinkToTxn TxnLineID' => false,
  'ItemGroupLineAdd ItemGroupRef ListID' => false,
  'ItemGroupLineAdd ItemGroupRef FullName' => false,
  'ItemGroupLineAdd Desc' => false,
  'ItemGroupLineAdd Quantity' => false,
  'ItemGroupLineAdd UnitOfMeasure' => false,
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
  1 => 'VendorRef',
  2 => 'VendorRef ListID',
  3 => 'VendorRef FullName',
  4 => 'APAccountRef ListID',
  5 => 'APAccountRef FullName',
  6 => 'TxnDate',
  7 => 'RefNumber',
  8 => 'Memo',
  9 => 'LinkToTxnID',
  10 => 'ItemReceiptAdd',
  11 => 'ExpenseLineAdd',
  12 => 'ExpenseLineAdd AccountRef',
  13 => 'ExpenseLineAdd AccountRef ListID',
  14 => 'ExpenseLineAdd AccountRef FullName',
  15 => 'ExpenseLineAdd Amount',
  16 => 'ExpenseLineAdd TaxAmount',
  17 => 'ExpenseLineAdd Memo',
  18 => 'ExpenseLineAdd CustomerRef ListID',
  19 => 'ExpenseLineAdd CustomerRef FullName',
  20 => 'ExpenseLineAdd ClassRef ListID',
  21 => 'ExpenseLineAdd ClassRef FullName',
  22 => 'ExpenseLineAdd SalesTaxCodeRef ListID',
  23 => 'ExpenseLineAdd SalesTaxCodeRef FullName',
  24 => 'ExpenseLineAdd BillableStatus',
  25 => 'ItemLineAdd',
  26 => 'ItemLineAdd ItemRef ListID',
  27 => 'ItemLineAdd ItemRef FullName',
  28 => 'ItemLineAdd Desc',
  29 => 'ItemLineAdd Quantity',
  30 => 'ItemLineAdd UnitOfMeasure',
  31 => 'ItemLineAdd Cost',
  32 => 'ItemLineAdd Amount',
  33 => 'ItemLineAdd TaxAmount',
  34 => 'ItemLineAdd CustomerRef ListID',
  35 => 'ItemLineAdd CustomerRef FullName',
  36 => 'ItemLineAdd ClassRef ListID',
  37 => 'ItemLineAdd ClassRef FullName',
  38 => 'ItemLineAdd SalesTaxCodeRef ListID',
  39 => 'ItemLineAdd SalesTaxCodeRef FullName',
  40 => 'ItemLineAdd BillableStatus',
  41 => 'ItemLineAdd OverrideItemAccountRef ListID',
  42 => 'ItemLineAdd OverrideItemAccountRef FullName',
  43 => 'ItemLineAdd LinkToTxn TxnID',
  44 => 'ItemLineAdd LinkToTxn TxnLineID',
  45 => 'ItemGroupLineAdd',
  46 => 'ItemGroupLineAdd ItemGroupRef ListID',
  47 => 'ItemGroupLineAdd ItemGroupRef FullName',
  48 => 'ItemGroupLineAdd Desc',
  48 => 'ItemGroupLineAdd Quantity',
  49 => 'ItemGroupLineAdd UnitOfMeasure',
  50 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

