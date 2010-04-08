<?php

/**
 * Schema object for: VendorCreditAddRq
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
class QuickBooks_QBXML_Schema_Object_VendorCreditAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'VendorCreditAdd VendorRef ListID' => 'IDTYPE',
  'VendorCreditAdd VendorRef FullName' => 'STRTYPE',
  'VendorCreditAdd APAccountRef ListID' => 'IDTYPE',
  'VendorCreditAdd APAccountRef FullName' => 'STRTYPE',
  'VendorCreditAdd TxnDate' => 'DATETYPE',
  'VendorCreditAdd RefNumber' => 'STRTYPE',
  'VendorCreditAdd Memo' => 'STRTYPE',
  'VendorCreditAdd ExpenseLineAdd AccountRef ListID' => 'IDTYPE',
  'VendorCreditAdd ExpenseLineAdd AccountRef FullName' => 'STRTYPE',
  'VendorCreditAdd ExpenseLineAdd Amount' => 'AMTTYPE',
  'VendorCreditAdd ExpenseLineAdd TaxAmount' => 'AMTTYPE',
  'VendorCreditAdd ExpenseLineAdd Memo' => 'STRTYPE',
  'VendorCreditAdd ExpenseLineAdd CustomerRef ListID' => 'IDTYPE',
  'VendorCreditAdd ExpenseLineAdd CustomerRef FullName' => 'STRTYPE',
  'VendorCreditAdd ExpenseLineAdd ClassRef ListID' => 'IDTYPE',
  'VendorCreditAdd ExpenseLineAdd ClassRef FullName' => 'STRTYPE',
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'VendorCreditAdd ExpenseLineAdd BillableStatus' => 'ENUMTYPE',
  'VendorCreditAdd ItemLineAdd ItemRef ListID' => 'IDTYPE',
  'VendorCreditAdd ItemLineAdd ItemRef FullName' => 'STRTYPE',
  'VendorCreditAdd ItemLineAdd Desc' => 'STRTYPE',
  'VendorCreditAdd ItemLineAdd Quantity' => 'QUANTYPE',
  'VendorCreditAdd ItemLineAdd UnitOfMeasure' => 'STRTYPE',
  'VendorCreditAdd ItemLineAdd Cost' => 'PRICETYPE',
  'VendorCreditAdd ItemLineAdd Amount' => 'AMTTYPE',
  'VendorCreditAdd ItemLineAdd TaxAmount' => 'AMTTYPE',
  'VendorCreditAdd ItemLineAdd CustomerRef ListID' => 'IDTYPE',
  'VendorCreditAdd ItemLineAdd CustomerRef FullName' => 'STRTYPE',
  'VendorCreditAdd ItemLineAdd ClassRef ListID' => 'IDTYPE',
  'VendorCreditAdd ItemLineAdd ClassRef FullName' => 'STRTYPE',
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'VendorCreditAdd ItemLineAdd BillableStatus' => 'ENUMTYPE',
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => 'IDTYPE',
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => 'STRTYPE',
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnID' => 'IDTYPE',
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnLineID' => 'IDTYPE',
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => 'IDTYPE',
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => 'STRTYPE',
  'VendorCreditAdd ItemGroupLineAdd Desc' => 'STRTYPE',
  'VendorCreditAdd ItemGroupLineAdd Quantity' => 'QUANTYPE',
  'VendorCreditAdd ItemGroupLineAdd UnitOfMeasure' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'VendorCreditAdd VendorRef ListID' => 0,
  'VendorCreditAdd VendorRef FullName' => 41,
  'VendorCreditAdd APAccountRef ListID' => 0,
  'VendorCreditAdd APAccountRef FullName' => 41,
  'VendorCreditAdd TxnDate' => 0,
  'VendorCreditAdd RefNumber' => 20,
  'VendorCreditAdd Memo' => 4095,
  'VendorCreditAdd ExpenseLineAdd AccountRef ListID' => 0,
  'VendorCreditAdd ExpenseLineAdd AccountRef FullName' => 41,
  'VendorCreditAdd ExpenseLineAdd Amount' => 0,
  'VendorCreditAdd ExpenseLineAdd TaxAmount' => 0,
  'VendorCreditAdd ExpenseLineAdd Memo' => 4095,
  'VendorCreditAdd ExpenseLineAdd CustomerRef ListID' => 0,
  'VendorCreditAdd ExpenseLineAdd CustomerRef FullName' => 41,
  'VendorCreditAdd ExpenseLineAdd ClassRef ListID' => 0,
  'VendorCreditAdd ExpenseLineAdd ClassRef FullName' => 41,
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 0,
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 41,
  'VendorCreditAdd ExpenseLineAdd BillableStatus' => 0,
  'VendorCreditAdd ItemLineAdd ItemRef ListID' => 0,
  'VendorCreditAdd ItemLineAdd ItemRef FullName' => 41,
  'VendorCreditAdd ItemLineAdd Desc' => 4095,
  'VendorCreditAdd ItemLineAdd Quantity' => 0,
  'VendorCreditAdd ItemLineAdd UnitOfMeasure' => 31,
  'VendorCreditAdd ItemLineAdd Cost' => 0,
  'VendorCreditAdd ItemLineAdd Amount' => 0,
  'VendorCreditAdd ItemLineAdd TaxAmount' => 0,
  'VendorCreditAdd ItemLineAdd CustomerRef ListID' => 0,
  'VendorCreditAdd ItemLineAdd CustomerRef FullName' => 41,
  'VendorCreditAdd ItemLineAdd ClassRef ListID' => 0,
  'VendorCreditAdd ItemLineAdd ClassRef FullName' => 41,
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => 0,
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => 41,
  'VendorCreditAdd ItemLineAdd BillableStatus' => 0,
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => 0,
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => 41,
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnID' => 0,
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnLineID' => 0,
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => 0,
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => 41,
  'VendorCreditAdd ItemGroupLineAdd Desc' => 4095,
  'VendorCreditAdd ItemGroupLineAdd Quantity' => 0,
  'VendorCreditAdd ItemGroupLineAdd UnitOfMeasure' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'VendorCreditAdd VendorRef ListID' => true,
  'VendorCreditAdd VendorRef FullName' => true,
  'VendorCreditAdd APAccountRef ListID' => true,
  'VendorCreditAdd APAccountRef FullName' => true,
  'VendorCreditAdd TxnDate' => true,
  'VendorCreditAdd RefNumber' => true,
  'VendorCreditAdd Memo' => true,
  'VendorCreditAdd ExpenseLineAdd AccountRef ListID' => true,
  'VendorCreditAdd ExpenseLineAdd AccountRef FullName' => true,
  'VendorCreditAdd ExpenseLineAdd Amount' => true,
  'VendorCreditAdd ExpenseLineAdd TaxAmount' => true,
  'VendorCreditAdd ExpenseLineAdd Memo' => true,
  'VendorCreditAdd ExpenseLineAdd CustomerRef ListID' => true,
  'VendorCreditAdd ExpenseLineAdd CustomerRef FullName' => true,
  'VendorCreditAdd ExpenseLineAdd ClassRef ListID' => true,
  'VendorCreditAdd ExpenseLineAdd ClassRef FullName' => true,
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => true,
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => true,
  'VendorCreditAdd ExpenseLineAdd BillableStatus' => true,
  'VendorCreditAdd ItemLineAdd ItemRef ListID' => true,
  'VendorCreditAdd ItemLineAdd ItemRef FullName' => true,
  'VendorCreditAdd ItemLineAdd Desc' => true,
  'VendorCreditAdd ItemLineAdd Quantity' => true,
  'VendorCreditAdd ItemLineAdd UnitOfMeasure' => true,
  'VendorCreditAdd ItemLineAdd Cost' => true,
  'VendorCreditAdd ItemLineAdd Amount' => true,
  'VendorCreditAdd ItemLineAdd TaxAmount' => true,
  'VendorCreditAdd ItemLineAdd CustomerRef ListID' => true,
  'VendorCreditAdd ItemLineAdd CustomerRef FullName' => true,
  'VendorCreditAdd ItemLineAdd ClassRef ListID' => true,
  'VendorCreditAdd ItemLineAdd ClassRef FullName' => true,
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => true,
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => true,
  'VendorCreditAdd ItemLineAdd BillableStatus' => true,
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => true,
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => true,
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnID' => false,
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnLineID' => false,
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => true,
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => true,
  'VendorCreditAdd ItemGroupLineAdd Desc' => true,
  'VendorCreditAdd ItemGroupLineAdd Quantity' => true,
  'VendorCreditAdd ItemGroupLineAdd UnitOfMeasure' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'VendorCreditAdd VendorRef ListID' => 999.99,
  'VendorCreditAdd VendorRef FullName' => 999.99,
  'VendorCreditAdd APAccountRef ListID' => 999.99,
  'VendorCreditAdd APAccountRef FullName' => 999.99,
  'VendorCreditAdd TxnDate' => 999.99,
  'VendorCreditAdd RefNumber' => 999.99,
  'VendorCreditAdd Memo' => 999.99,
  'VendorCreditAdd ExpenseLineAdd AccountRef ListID' => 999.99,
  'VendorCreditAdd ExpenseLineAdd AccountRef FullName' => 999.99,
  'VendorCreditAdd ExpenseLineAdd Amount' => 999.99,
  'VendorCreditAdd ExpenseLineAdd TaxAmount' => 6.1,
  'VendorCreditAdd ExpenseLineAdd Memo' => 999.99,
  'VendorCreditAdd ExpenseLineAdd CustomerRef ListID' => 999.99,
  'VendorCreditAdd ExpenseLineAdd CustomerRef FullName' => 999.99,
  'VendorCreditAdd ExpenseLineAdd ClassRef ListID' => 999.99,
  'VendorCreditAdd ExpenseLineAdd ClassRef FullName' => 999.99,
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 999.99,
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 999.99,
  'VendorCreditAdd ExpenseLineAdd BillableStatus' => 2,
  'VendorCreditAdd ItemLineAdd ItemRef ListID' => 999.99,
  'VendorCreditAdd ItemLineAdd ItemRef FullName' => 999.99,
  'VendorCreditAdd ItemLineAdd Desc' => 999.99,
  'VendorCreditAdd ItemLineAdd Quantity' => 999.99,
  'VendorCreditAdd ItemLineAdd UnitOfMeasure' => 7,
  'VendorCreditAdd ItemLineAdd Cost' => 999.99,
  'VendorCreditAdd ItemLineAdd Amount' => 999.99,
  'VendorCreditAdd ItemLineAdd TaxAmount' => 6.1,
  'VendorCreditAdd ItemLineAdd CustomerRef ListID' => 999.99,
  'VendorCreditAdd ItemLineAdd CustomerRef FullName' => 999.99,
  'VendorCreditAdd ItemLineAdd ClassRef ListID' => 999.99,
  'VendorCreditAdd ItemLineAdd ClassRef FullName' => 999.99,
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => 999.99,
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => 999.99,
  'VendorCreditAdd ItemLineAdd BillableStatus' => 2,
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => 999.99,
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => 999.99,
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnID' => 999.99,
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnLineID' => 999.99,
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => 999.99,
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => 999.99,
  'VendorCreditAdd ItemGroupLineAdd Desc' => 999.99,
  'VendorCreditAdd ItemGroupLineAdd Quantity' => 999.99,
  'VendorCreditAdd ItemGroupLineAdd UnitOfMeasure' => 7,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'VendorCreditAdd VendorRef ListID' => false,
  'VendorCreditAdd VendorRef FullName' => false,
  'VendorCreditAdd APAccountRef ListID' => false,
  'VendorCreditAdd APAccountRef FullName' => false,
  'VendorCreditAdd TxnDate' => false,
  'VendorCreditAdd RefNumber' => false,
  'VendorCreditAdd Memo' => false,
  'VendorCreditAdd ExpenseLineAdd AccountRef ListID' => false,
  'VendorCreditAdd ExpenseLineAdd AccountRef FullName' => false,
  'VendorCreditAdd ExpenseLineAdd Amount' => false,
  'VendorCreditAdd ExpenseLineAdd TaxAmount' => false,
  'VendorCreditAdd ExpenseLineAdd Memo' => false,
  'VendorCreditAdd ExpenseLineAdd CustomerRef ListID' => false,
  'VendorCreditAdd ExpenseLineAdd CustomerRef FullName' => false,
  'VendorCreditAdd ExpenseLineAdd ClassRef ListID' => false,
  'VendorCreditAdd ExpenseLineAdd ClassRef FullName' => false,
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => false,
  'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => false,
  'VendorCreditAdd ExpenseLineAdd BillableStatus' => false,
  'VendorCreditAdd ItemLineAdd ItemRef ListID' => false,
  'VendorCreditAdd ItemLineAdd ItemRef FullName' => false,
  'VendorCreditAdd ItemLineAdd Desc' => false,
  'VendorCreditAdd ItemLineAdd Quantity' => false,
  'VendorCreditAdd ItemLineAdd UnitOfMeasure' => false,
  'VendorCreditAdd ItemLineAdd Cost' => false,
  'VendorCreditAdd ItemLineAdd Amount' => false,
  'VendorCreditAdd ItemLineAdd TaxAmount' => false,
  'VendorCreditAdd ItemLineAdd CustomerRef ListID' => false,
  'VendorCreditAdd ItemLineAdd CustomerRef FullName' => false,
  'VendorCreditAdd ItemLineAdd ClassRef ListID' => false,
  'VendorCreditAdd ItemLineAdd ClassRef FullName' => false,
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => false,
  'VendorCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => false,
  'VendorCreditAdd ItemLineAdd BillableStatus' => false,
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => false,
  'VendorCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => false,
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnID' => false,
  'VendorCreditAdd ItemLineAdd LinkToTxn TxnLineID' => false,
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => false,
  'VendorCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => false,
  'VendorCreditAdd ItemGroupLineAdd Desc' => false,
  'VendorCreditAdd ItemGroupLineAdd Quantity' => false,
  'VendorCreditAdd ItemGroupLineAdd UnitOfMeasure' => false,
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
  0 => 'VendorCreditAdd',
  1 => 'VendorCreditAdd VendorRef',
  2 => 'VendorCreditAdd VendorRef ListID',
  3 => 'VendorCreditAdd VendorRef FullName',
  4 => 'VendorCreditAdd APAccountRef ListID',
  5 => 'VendorCreditAdd APAccountRef FullName',
  6 => 'VendorCreditAdd TxnDate',
  7 => 'VendorCreditAdd RefNumber',
  8 => 'VendorCreditAdd Memo',
  9 => 'VendorCreditAdd',
  10 => 'VendorCreditAdd ExpenseLineAdd',
  11 => 'VendorCreditAdd ExpenseLineAdd AccountRef',
  12 => 'VendorCreditAdd ExpenseLineAdd AccountRef ListID',
  13 => 'VendorCreditAdd ExpenseLineAdd AccountRef FullName',
  14 => 'VendorCreditAdd ExpenseLineAdd Amount',
  15 => 'VendorCreditAdd ExpenseLineAdd TaxAmount',
  16 => 'VendorCreditAdd ExpenseLineAdd Memo',
  17 => 'VendorCreditAdd ExpenseLineAdd CustomerRef ListID',
  18 => 'VendorCreditAdd ExpenseLineAdd CustomerRef FullName',
  19 => 'VendorCreditAdd ExpenseLineAdd ClassRef ListID',
  20 => 'VendorCreditAdd ExpenseLineAdd ClassRef FullName',
  21 => 'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID',
  22 => 'VendorCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName',
  23 => 'VendorCreditAdd ExpenseLineAdd BillableStatus',
  24 => 'VendorCreditAdd ItemLineAdd ItemRef ListID',
  25 => 'VendorCreditAdd ItemLineAdd ItemRef FullName',
  26 => 'VendorCreditAdd ItemLineAdd Desc',
  27 => 'VendorCreditAdd ItemLineAdd Quantity',
  28 => 'VendorCreditAdd ItemLineAdd UnitOfMeasure',
  29 => 'VendorCreditAdd ItemLineAdd Cost',
  30 => 'VendorCreditAdd ItemLineAdd Amount',
  31 => 'VendorCreditAdd ItemLineAdd TaxAmount',
  32 => 'VendorCreditAdd ItemLineAdd CustomerRef ListID',
  33 => 'VendorCreditAdd ItemLineAdd CustomerRef FullName',
  34 => 'VendorCreditAdd ItemLineAdd ClassRef ListID',
  35 => 'VendorCreditAdd ItemLineAdd ClassRef FullName',
  36 => 'VendorCreditAdd ItemLineAdd SalesTaxCodeRef ListID',
  37 => 'VendorCreditAdd ItemLineAdd SalesTaxCodeRef FullName',
  38 => 'VendorCreditAdd ItemLineAdd BillableStatus',
  39 => 'VendorCreditAdd ItemLineAdd OverrideItemAccountRef ListID',
  40 => 'VendorCreditAdd ItemLineAdd OverrideItemAccountRef FullName',
  41 => 'VendorCreditAdd ItemLineAdd LinkToTxn TxnID',
  42 => 'VendorCreditAdd ItemLineAdd LinkToTxn TxnLineID',
  43 => 'VendorCreditAdd ItemGroupLineAdd ItemGroupRef ListID',
  44 => 'VendorCreditAdd ItemGroupLineAdd ItemGroupRef FullName',
  45 => 'VendorCreditAdd ItemGroupLineAdd Desc',
  46 => 'VendorCreditAdd ItemGroupLineAdd Quantity',
  47 => 'VendorCreditAdd ItemGroupLineAdd UnitOfMeasure',
  48 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>