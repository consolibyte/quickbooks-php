<?php

/**
 * Schema object for: CreditCardChargeAddRq
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
class QuickBooks_QBXML_Schema_Object_CreditCardChargeAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'CreditCardChargeAdd AccountRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd AccountRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd PayeeEntityRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd PayeeEntityRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd TxnDate' => 'DATETYPE',
  'CreditCardChargeAdd RefNumber' => 'STRTYPE',
  'CreditCardChargeAdd Memo' => 'STRTYPE',
  'CreditCardChargeAdd IsTaxIncluded' => 'BOOLTYPE',
  'CreditCardChargeAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ExpenseLineAdd AccountRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ExpenseLineAdd AccountRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ExpenseLineAdd Amount' => 'AMTTYPE',
  'CreditCardChargeAdd ExpenseLineAdd TaxAmount' => 'AMTTYPE',
  'CreditCardChargeAdd ExpenseLineAdd Memo' => 'STRTYPE',
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ExpenseLineAdd ClassRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ExpenseLineAdd ClassRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ExpenseLineAdd BillableStatus' => 'ENUMTYPE',
  'CreditCardChargeAdd ItemLineAdd ItemRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ItemLineAdd ItemRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ItemLineAdd Desc' => 'STRTYPE',
  'CreditCardChargeAdd ItemLineAdd Quantity' => 'QUANTYPE',
  'CreditCardChargeAdd ItemLineAdd UnitOfMeasure' => 'STRTYPE',
  'CreditCardChargeAdd ItemLineAdd Cost' => 'PRICETYPE',
  'CreditCardChargeAdd ItemLineAdd Amount' => 'AMTTYPE',
  'CreditCardChargeAdd ItemLineAdd TaxAmount' => 'AMTTYPE',
  'CreditCardChargeAdd ItemLineAdd CustomerRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ItemLineAdd CustomerRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ItemLineAdd ClassRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ItemLineAdd ClassRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ItemLineAdd BillableStatus' => 'ENUMTYPE',
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnID' => 'IDTYPE',
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnLineID' => 'IDTYPE',
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef ListID' => 'IDTYPE',
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef FullName' => 'STRTYPE',
  'CreditCardChargeAdd ItemGroupLineAdd Desc' => 'STRTYPE',
  'CreditCardChargeAdd ItemGroupLineAdd Quantity' => 'QUANTYPE',
  'CreditCardChargeAdd ItemGroupLineAdd UnitOfMeasure' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'CreditCardChargeAdd AccountRef ListID' => 0,
  'CreditCardChargeAdd AccountRef FullName' => 159,
  'CreditCardChargeAdd PayeeEntityRef ListID' => 0,
  'CreditCardChargeAdd PayeeEntityRef FullName' => 159,
  'CreditCardChargeAdd TxnDate' => 0,
  'CreditCardChargeAdd RefNumber' => 11,
  'CreditCardChargeAdd Memo' => 4095,
  'CreditCardChargeAdd IsTaxIncluded' => 0,
  'CreditCardChargeAdd SalesTaxCodeRef ListID' => 0,
  'CreditCardChargeAdd SalesTaxCodeRef FullName' => 159,
  'CreditCardChargeAdd ExpenseLineAdd AccountRef ListID' => 0,
  'CreditCardChargeAdd ExpenseLineAdd AccountRef FullName' => 159,
  'CreditCardChargeAdd ExpenseLineAdd Amount' => 0,
  'CreditCardChargeAdd ExpenseLineAdd TaxAmount' => 0,
  'CreditCardChargeAdd ExpenseLineAdd Memo' => 4095,
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef ListID' => 0,
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef FullName' => 159,
  'CreditCardChargeAdd ExpenseLineAdd ClassRef ListID' => 0,
  'CreditCardChargeAdd ExpenseLineAdd ClassRef FullName' => 159,
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 0,
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 159,
  'CreditCardChargeAdd ExpenseLineAdd BillableStatus' => 0,
  'CreditCardChargeAdd ItemLineAdd ItemRef ListID' => 0,
  'CreditCardChargeAdd ItemLineAdd ItemRef FullName' => 159,
  'CreditCardChargeAdd ItemLineAdd Desc' => 4095,
  'CreditCardChargeAdd ItemLineAdd Quantity' => 0,
  'CreditCardChargeAdd ItemLineAdd UnitOfMeasure' => 31,
  'CreditCardChargeAdd ItemLineAdd Cost' => 0,
  'CreditCardChargeAdd ItemLineAdd Amount' => 0,
  'CreditCardChargeAdd ItemLineAdd TaxAmount' => 0,
  'CreditCardChargeAdd ItemLineAdd CustomerRef ListID' => 0,
  'CreditCardChargeAdd ItemLineAdd CustomerRef FullName' => 159,
  'CreditCardChargeAdd ItemLineAdd ClassRef ListID' => 0,
  'CreditCardChargeAdd ItemLineAdd ClassRef FullName' => 159,
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef ListID' => 0,
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef FullName' => 159,
  'CreditCardChargeAdd ItemLineAdd BillableStatus' => 0,
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef ListID' => 0,
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef FullName' => 159,
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnID' => 0,
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnLineID' => 0,
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef ListID' => 0,
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef FullName' => 159,
  'CreditCardChargeAdd ItemGroupLineAdd Desc' => 4095,
  'CreditCardChargeAdd ItemGroupLineAdd Quantity' => 0,
  'CreditCardChargeAdd ItemGroupLineAdd UnitOfMeasure' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'CreditCardChargeAdd AccountRef ListID' => true,
  'CreditCardChargeAdd AccountRef FullName' => true,
  'CreditCardChargeAdd PayeeEntityRef ListID' => true,
  'CreditCardChargeAdd PayeeEntityRef FullName' => true,
  'CreditCardChargeAdd TxnDate' => true,
  'CreditCardChargeAdd RefNumber' => true,
  'CreditCardChargeAdd Memo' => true,
  'CreditCardChargeAdd IsTaxIncluded' => true,
  'CreditCardChargeAdd SalesTaxCodeRef ListID' => true,
  'CreditCardChargeAdd SalesTaxCodeRef FullName' => true,
  'CreditCardChargeAdd ExpenseLineAdd AccountRef ListID' => true,
  'CreditCardChargeAdd ExpenseLineAdd AccountRef FullName' => true,
  'CreditCardChargeAdd ExpenseLineAdd Amount' => true,
  'CreditCardChargeAdd ExpenseLineAdd TaxAmount' => true,
  'CreditCardChargeAdd ExpenseLineAdd Memo' => true,
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef ListID' => true,
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef FullName' => true,
  'CreditCardChargeAdd ExpenseLineAdd ClassRef ListID' => true,
  'CreditCardChargeAdd ExpenseLineAdd ClassRef FullName' => true,
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef ListID' => true,
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef FullName' => true,
  'CreditCardChargeAdd ExpenseLineAdd BillableStatus' => true,
  'CreditCardChargeAdd ItemLineAdd ItemRef ListID' => true,
  'CreditCardChargeAdd ItemLineAdd ItemRef FullName' => true,
  'CreditCardChargeAdd ItemLineAdd Desc' => true,
  'CreditCardChargeAdd ItemLineAdd Quantity' => true,
  'CreditCardChargeAdd ItemLineAdd UnitOfMeasure' => true,
  'CreditCardChargeAdd ItemLineAdd Cost' => true,
  'CreditCardChargeAdd ItemLineAdd Amount' => true,
  'CreditCardChargeAdd ItemLineAdd TaxAmount' => true,
  'CreditCardChargeAdd ItemLineAdd CustomerRef ListID' => true,
  'CreditCardChargeAdd ItemLineAdd CustomerRef FullName' => true,
  'CreditCardChargeAdd ItemLineAdd ClassRef ListID' => true,
  'CreditCardChargeAdd ItemLineAdd ClassRef FullName' => true,
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef ListID' => true,
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef FullName' => true,
  'CreditCardChargeAdd ItemLineAdd BillableStatus' => true,
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef ListID' => true,
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef FullName' => true,
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnID' => false,
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnLineID' => false,
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef ListID' => true,
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef FullName' => true,
  'CreditCardChargeAdd ItemGroupLineAdd Desc' => true,
  'CreditCardChargeAdd ItemGroupLineAdd Quantity' => true,
  'CreditCardChargeAdd ItemGroupLineAdd UnitOfMeasure' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'CreditCardChargeAdd AccountRef ListID' => 999.99,
  'CreditCardChargeAdd AccountRef FullName' => 999.99,
  'CreditCardChargeAdd PayeeEntityRef ListID' => 999.99,
  'CreditCardChargeAdd PayeeEntityRef FullName' => 999.99,
  'CreditCardChargeAdd TxnDate' => 999.99,
  'CreditCardChargeAdd RefNumber' => 999.99,
  'CreditCardChargeAdd Memo' => 999.99,
  'CreditCardChargeAdd IsTaxIncluded' => 6,
  'CreditCardChargeAdd SalesTaxCodeRef ListID' => 999.99,
  'CreditCardChargeAdd SalesTaxCodeRef FullName' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd AccountRef ListID' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd AccountRef FullName' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd Amount' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd TaxAmount' => 6.1,
  'CreditCardChargeAdd ExpenseLineAdd Memo' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef ListID' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef FullName' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd ClassRef ListID' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd ClassRef FullName' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 999.99,
  'CreditCardChargeAdd ExpenseLineAdd BillableStatus' => 2,
  'CreditCardChargeAdd ItemLineAdd ItemRef ListID' => 999.99,
  'CreditCardChargeAdd ItemLineAdd ItemRef FullName' => 999.99,
  'CreditCardChargeAdd ItemLineAdd Desc' => 999.99,
  'CreditCardChargeAdd ItemLineAdd Quantity' => 999.99,
  'CreditCardChargeAdd ItemLineAdd UnitOfMeasure' => 7,
  'CreditCardChargeAdd ItemLineAdd Cost' => 999.99,
  'CreditCardChargeAdd ItemLineAdd Amount' => 999.99,
  'CreditCardChargeAdd ItemLineAdd TaxAmount' => 6.1,
  'CreditCardChargeAdd ItemLineAdd CustomerRef ListID' => 999.99,
  'CreditCardChargeAdd ItemLineAdd CustomerRef FullName' => 999.99,
  'CreditCardChargeAdd ItemLineAdd ClassRef ListID' => 999.99,
  'CreditCardChargeAdd ItemLineAdd ClassRef FullName' => 999.99,
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef ListID' => 999.99,
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef FullName' => 999.99,
  'CreditCardChargeAdd ItemLineAdd BillableStatus' => 2,
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef ListID' => 999.99,
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef FullName' => 999.99,
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnID' => 999.99,
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnLineID' => 999.99,
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef ListID' => 999.99,
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef FullName' => 999.99,
  'CreditCardChargeAdd ItemGroupLineAdd Desc' => 999.99,
  'CreditCardChargeAdd ItemGroupLineAdd Quantity' => 999.99,
  'CreditCardChargeAdd ItemGroupLineAdd UnitOfMeasure' => 7,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'CreditCardChargeAdd AccountRef ListID' => false,
  'CreditCardChargeAdd AccountRef FullName' => false,
  'CreditCardChargeAdd PayeeEntityRef ListID' => false,
  'CreditCardChargeAdd PayeeEntityRef FullName' => false,
  'CreditCardChargeAdd TxnDate' => false,
  'CreditCardChargeAdd RefNumber' => false,
  'CreditCardChargeAdd Memo' => false,
  'CreditCardChargeAdd IsTaxIncluded' => false,
  'CreditCardChargeAdd SalesTaxCodeRef ListID' => false,
  'CreditCardChargeAdd SalesTaxCodeRef FullName' => false,
  'CreditCardChargeAdd ExpenseLineAdd AccountRef ListID' => false,
  'CreditCardChargeAdd ExpenseLineAdd AccountRef FullName' => false,
  'CreditCardChargeAdd ExpenseLineAdd Amount' => false,
  'CreditCardChargeAdd ExpenseLineAdd TaxAmount' => false,
  'CreditCardChargeAdd ExpenseLineAdd Memo' => false,
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef ListID' => false,
  'CreditCardChargeAdd ExpenseLineAdd CustomerRef FullName' => false,
  'CreditCardChargeAdd ExpenseLineAdd ClassRef ListID' => false,
  'CreditCardChargeAdd ExpenseLineAdd ClassRef FullName' => false,
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef ListID' => false,
  'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef FullName' => false,
  'CreditCardChargeAdd ExpenseLineAdd BillableStatus' => false,
  'CreditCardChargeAdd ItemLineAdd ItemRef ListID' => false,
  'CreditCardChargeAdd ItemLineAdd ItemRef FullName' => false,
  'CreditCardChargeAdd ItemLineAdd Desc' => false,
  'CreditCardChargeAdd ItemLineAdd Quantity' => false,
  'CreditCardChargeAdd ItemLineAdd UnitOfMeasure' => false,
  'CreditCardChargeAdd ItemLineAdd Cost' => false,
  'CreditCardChargeAdd ItemLineAdd Amount' => false,
  'CreditCardChargeAdd ItemLineAdd TaxAmount' => false,
  'CreditCardChargeAdd ItemLineAdd CustomerRef ListID' => false,
  'CreditCardChargeAdd ItemLineAdd CustomerRef FullName' => false,
  'CreditCardChargeAdd ItemLineAdd ClassRef ListID' => false,
  'CreditCardChargeAdd ItemLineAdd ClassRef FullName' => false,
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef ListID' => false,
  'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef FullName' => false,
  'CreditCardChargeAdd ItemLineAdd BillableStatus' => false,
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef ListID' => false,
  'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef FullName' => false,
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnID' => false,
  'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnLineID' => false,
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef ListID' => false,
  'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef FullName' => false,
  'CreditCardChargeAdd ItemGroupLineAdd Desc' => false,
  'CreditCardChargeAdd ItemGroupLineAdd Quantity' => false,
  'CreditCardChargeAdd ItemGroupLineAdd UnitOfMeasure' => false,
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
  0 => 'CreditCardChargeAdd',
  1 => 'CreditCardChargeAdd AccountRef',
  2 => 'CreditCardChargeAdd AccountRef ListID',
  3 => 'CreditCardChargeAdd AccountRef FullName',
  4 => 'CreditCardChargeAdd PayeeEntityRef ListID',
  5 => 'CreditCardChargeAdd PayeeEntityRef FullName',
  6 => 'CreditCardChargeAdd TxnDate',
  7 => 'CreditCardChargeAdd RefNumber',
  8 => 'CreditCardChargeAdd Memo',
  9 => 'CreditCardChargeAdd IsTaxIncluded',
  10 => 'CreditCardChargeAdd SalesTaxCodeRef ListID',
  11 => 'CreditCardChargeAdd SalesTaxCodeRef FullName',
  12 => 'CreditCardChargeAdd ExpenseLineAdd AccountRef ListID',
  13 => 'CreditCardChargeAdd ExpenseLineAdd AccountRef FullName',
  14 => 'CreditCardChargeAdd ExpenseLineAdd Amount',
  15 => 'CreditCardChargeAdd ExpenseLineAdd TaxAmount',
  16 => 'CreditCardChargeAdd ExpenseLineAdd Memo',
  17 => 'CreditCardChargeAdd ExpenseLineAdd CustomerRef ListID',
  18 => 'CreditCardChargeAdd ExpenseLineAdd CustomerRef FullName',
  19 => 'CreditCardChargeAdd ExpenseLineAdd ClassRef ListID',
  20 => 'CreditCardChargeAdd ExpenseLineAdd ClassRef FullName',
  21 => 'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef ListID',
  22 => 'CreditCardChargeAdd ExpenseLineAdd SalesTaxCodeRef FullName',
  23 => 'CreditCardChargeAdd ExpenseLineAdd BillableStatus',
  24 => 'CreditCardChargeAdd ItemLineAdd ItemRef ListID',
  25 => 'CreditCardChargeAdd ItemLineAdd ItemRef FullName',
  26 => 'CreditCardChargeAdd ItemLineAdd Desc',
  27 => 'CreditCardChargeAdd ItemLineAdd Quantity',
  28 => 'CreditCardChargeAdd ItemLineAdd UnitOfMeasure',
  29 => 'CreditCardChargeAdd ItemLineAdd Cost',
  30 => 'CreditCardChargeAdd ItemLineAdd Amount',
  31 => 'CreditCardChargeAdd ItemLineAdd TaxAmount',
  32 => 'CreditCardChargeAdd ItemLineAdd CustomerRef ListID',
  33 => 'CreditCardChargeAdd ItemLineAdd CustomerRef FullName',
  34 => 'CreditCardChargeAdd ItemLineAdd ClassRef ListID',
  35 => 'CreditCardChargeAdd ItemLineAdd ClassRef FullName',
  36 => 'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef ListID',
  37 => 'CreditCardChargeAdd ItemLineAdd SalesTaxCodeRef FullName',
  38 => 'CreditCardChargeAdd ItemLineAdd BillableStatus',
  39 => 'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef ListID',
  40 => 'CreditCardChargeAdd ItemLineAdd OverrideItemAccountRef FullName',
  41 => 'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnID',
  42 => 'CreditCardChargeAdd ItemLineAdd LinkToTxn TxnLineID',
  43 => 'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef ListID',
  44 => 'CreditCardChargeAdd ItemGroupLineAdd ItemGroupRef FullName',
  45 => 'CreditCardChargeAdd ItemGroupLineAdd Desc',
  46 => 'CreditCardChargeAdd ItemGroupLineAdd Quantity',
  47 => 'CreditCardChargeAdd ItemGroupLineAdd UnitOfMeasure',
  48 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>