<?php

/**
 * Schema object for: CreditCardCreditAddRq
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
class QuickBooks_QBXML_Schema_Object_CreditCardCreditAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'CreditCardCreditAdd AccountRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd AccountRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd PayeeEntityRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd PayeeEntityRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd TxnDate' => 'DATETYPE',
  'CreditCardCreditAdd RefNumber' => 'STRTYPE',
  'CreditCardCreditAdd Memo' => 'STRTYPE',
  'CreditCardCreditAdd ExpenseLineAdd AccountRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ExpenseLineAdd AccountRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ExpenseLineAdd Amount' => 'AMTTYPE',
  'CreditCardCreditAdd ExpenseLineAdd TaxAmount' => 'AMTTYPE',
  'CreditCardCreditAdd ExpenseLineAdd Memo' => 'STRTYPE',
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ExpenseLineAdd ClassRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ExpenseLineAdd ClassRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ExpenseLineAdd BillableStatus' => 'ENUMTYPE',
  'CreditCardCreditAdd ItemLineAdd ItemRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ItemLineAdd ItemRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ItemLineAdd Desc' => 'STRTYPE',
  'CreditCardCreditAdd ItemLineAdd Quantity' => 'QUANTYPE',
  'CreditCardCreditAdd ItemLineAdd UnitOfMeasure' => 'STRTYPE',
  'CreditCardCreditAdd ItemLineAdd Cost' => 'PRICETYPE',
  'CreditCardCreditAdd ItemLineAdd Amount' => 'AMTTYPE',
  'CreditCardCreditAdd ItemLineAdd TaxAmount' => 'AMTTYPE',
  'CreditCardCreditAdd ItemLineAdd CustomerRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ItemLineAdd CustomerRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ItemLineAdd ClassRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ItemLineAdd ClassRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ItemLineAdd BillableStatus' => 'ENUMTYPE',
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnID' => 'IDTYPE',
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnLineID' => 'IDTYPE',
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => 'IDTYPE',
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => 'STRTYPE',
  'CreditCardCreditAdd ItemGroupLineAdd Desc' => 'STRTYPE',
  'CreditCardCreditAdd ItemGroupLineAdd Quantity' => 'QUANTYPE',
  'CreditCardCreditAdd ItemGroupLineAdd UnitOfMeasure' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'CreditCardCreditAdd AccountRef ListID' => 0,
  'CreditCardCreditAdd AccountRef FullName' => 159,
  'CreditCardCreditAdd PayeeEntityRef ListID' => 0,
  'CreditCardCreditAdd PayeeEntityRef FullName' => 159,
  'CreditCardCreditAdd TxnDate' => 0,
  'CreditCardCreditAdd RefNumber' => 11,
  'CreditCardCreditAdd Memo' => 4095,
  'CreditCardCreditAdd ExpenseLineAdd AccountRef ListID' => 0,
  'CreditCardCreditAdd ExpenseLineAdd AccountRef FullName' => 159,
  'CreditCardCreditAdd ExpenseLineAdd Amount' => 0,
  'CreditCardCreditAdd ExpenseLineAdd TaxAmount' => 0,
  'CreditCardCreditAdd ExpenseLineAdd Memo' => 4095,
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef ListID' => 0,
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef FullName' => 159,
  'CreditCardCreditAdd ExpenseLineAdd ClassRef ListID' => 0,
  'CreditCardCreditAdd ExpenseLineAdd ClassRef FullName' => 159,
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 0,
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 159,
  'CreditCardCreditAdd ExpenseLineAdd BillableStatus' => 0,
  'CreditCardCreditAdd ItemLineAdd ItemRef ListID' => 0,
  'CreditCardCreditAdd ItemLineAdd ItemRef FullName' => 159,
  'CreditCardCreditAdd ItemLineAdd Desc' => 4095,
  'CreditCardCreditAdd ItemLineAdd Quantity' => 0,
  'CreditCardCreditAdd ItemLineAdd UnitOfMeasure' => 31,
  'CreditCardCreditAdd ItemLineAdd Cost' => 0,
  'CreditCardCreditAdd ItemLineAdd Amount' => 0,
  'CreditCardCreditAdd ItemLineAdd TaxAmount' => 0,
  'CreditCardCreditAdd ItemLineAdd CustomerRef ListID' => 0,
  'CreditCardCreditAdd ItemLineAdd CustomerRef FullName' => 159,
  'CreditCardCreditAdd ItemLineAdd ClassRef ListID' => 0,
  'CreditCardCreditAdd ItemLineAdd ClassRef FullName' => 159,
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => 0,
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => 159,
  'CreditCardCreditAdd ItemLineAdd BillableStatus' => 0,
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => 0,
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => 159,
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnID' => 0,
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnLineID' => 0,
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => 0,
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => 159,
  'CreditCardCreditAdd ItemGroupLineAdd Desc' => 4095,
  'CreditCardCreditAdd ItemGroupLineAdd Quantity' => 0,
  'CreditCardCreditAdd ItemGroupLineAdd UnitOfMeasure' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'CreditCardCreditAdd AccountRef ListID' => true,
  'CreditCardCreditAdd AccountRef FullName' => true,
  'CreditCardCreditAdd PayeeEntityRef ListID' => true,
  'CreditCardCreditAdd PayeeEntityRef FullName' => true,
  'CreditCardCreditAdd TxnDate' => true,
  'CreditCardCreditAdd RefNumber' => true,
  'CreditCardCreditAdd Memo' => true,
  'CreditCardCreditAdd ExpenseLineAdd AccountRef ListID' => true,
  'CreditCardCreditAdd ExpenseLineAdd AccountRef FullName' => true,
  'CreditCardCreditAdd ExpenseLineAdd Amount' => true,
  'CreditCardCreditAdd ExpenseLineAdd TaxAmount' => true,
  'CreditCardCreditAdd ExpenseLineAdd Memo' => true,
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef ListID' => true,
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef FullName' => true,
  'CreditCardCreditAdd ExpenseLineAdd ClassRef ListID' => true,
  'CreditCardCreditAdd ExpenseLineAdd ClassRef FullName' => true,
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => true,
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => true,
  'CreditCardCreditAdd ExpenseLineAdd BillableStatus' => true,
  'CreditCardCreditAdd ItemLineAdd ItemRef ListID' => true,
  'CreditCardCreditAdd ItemLineAdd ItemRef FullName' => true,
  'CreditCardCreditAdd ItemLineAdd Desc' => true,
  'CreditCardCreditAdd ItemLineAdd Quantity' => true,
  'CreditCardCreditAdd ItemLineAdd UnitOfMeasure' => true,
  'CreditCardCreditAdd ItemLineAdd Cost' => true,
  'CreditCardCreditAdd ItemLineAdd Amount' => true,
  'CreditCardCreditAdd ItemLineAdd TaxAmount' => true,
  'CreditCardCreditAdd ItemLineAdd CustomerRef ListID' => true,
  'CreditCardCreditAdd ItemLineAdd CustomerRef FullName' => true,
  'CreditCardCreditAdd ItemLineAdd ClassRef ListID' => true,
  'CreditCardCreditAdd ItemLineAdd ClassRef FullName' => true,
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => true,
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => true,
  'CreditCardCreditAdd ItemLineAdd BillableStatus' => true,
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => true,
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => true,
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnID' => false,
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnLineID' => false,
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => true,
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => true,
  'CreditCardCreditAdd ItemGroupLineAdd Desc' => true,
  'CreditCardCreditAdd ItemGroupLineAdd Quantity' => true,
  'CreditCardCreditAdd ItemGroupLineAdd UnitOfMeasure' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'CreditCardCreditAdd AccountRef ListID' => 999.99,
  'CreditCardCreditAdd AccountRef FullName' => 999.99,
  'CreditCardCreditAdd PayeeEntityRef ListID' => 999.99,
  'CreditCardCreditAdd PayeeEntityRef FullName' => 999.99,
  'CreditCardCreditAdd TxnDate' => 999.99,
  'CreditCardCreditAdd RefNumber' => 999.99,
  'CreditCardCreditAdd Memo' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd AccountRef ListID' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd AccountRef FullName' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd Amount' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd TaxAmount' => 6.1,
  'CreditCardCreditAdd ExpenseLineAdd Memo' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef ListID' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef FullName' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd ClassRef ListID' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd ClassRef FullName' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => 999.99,
  'CreditCardCreditAdd ExpenseLineAdd BillableStatus' => 2,
  'CreditCardCreditAdd ItemLineAdd ItemRef ListID' => 999.99,
  'CreditCardCreditAdd ItemLineAdd ItemRef FullName' => 999.99,
  'CreditCardCreditAdd ItemLineAdd Desc' => 999.99,
  'CreditCardCreditAdd ItemLineAdd Quantity' => 999.99,
  'CreditCardCreditAdd ItemLineAdd UnitOfMeasure' => 7,
  'CreditCardCreditAdd ItemLineAdd Cost' => 999.99,
  'CreditCardCreditAdd ItemLineAdd Amount' => 999.99,
  'CreditCardCreditAdd ItemLineAdd TaxAmount' => 6.1,
  'CreditCardCreditAdd ItemLineAdd CustomerRef ListID' => 999.99,
  'CreditCardCreditAdd ItemLineAdd CustomerRef FullName' => 999.99,
  'CreditCardCreditAdd ItemLineAdd ClassRef ListID' => 999.99,
  'CreditCardCreditAdd ItemLineAdd ClassRef FullName' => 999.99,
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => 999.99,
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => 999.99,
  'CreditCardCreditAdd ItemLineAdd BillableStatus' => 2,
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => 999.99,
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => 999.99,
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnID' => 999.99,
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnLineID' => 999.99,
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => 999.99,
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => 999.99,
  'CreditCardCreditAdd ItemGroupLineAdd Desc' => 999.99,
  'CreditCardCreditAdd ItemGroupLineAdd Quantity' => 999.99,
  'CreditCardCreditAdd ItemGroupLineAdd UnitOfMeasure' => 7,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'CreditCardCreditAdd AccountRef ListID' => false,
  'CreditCardCreditAdd AccountRef FullName' => false,
  'CreditCardCreditAdd PayeeEntityRef ListID' => false,
  'CreditCardCreditAdd PayeeEntityRef FullName' => false,
  'CreditCardCreditAdd TxnDate' => false,
  'CreditCardCreditAdd RefNumber' => false,
  'CreditCardCreditAdd Memo' => false,
  'CreditCardCreditAdd ExpenseLineAdd AccountRef ListID' => false,
  'CreditCardCreditAdd ExpenseLineAdd AccountRef FullName' => false,
  'CreditCardCreditAdd ExpenseLineAdd Amount' => false,
  'CreditCardCreditAdd ExpenseLineAdd TaxAmount' => false,
  'CreditCardCreditAdd ExpenseLineAdd Memo' => false,
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef ListID' => false,
  'CreditCardCreditAdd ExpenseLineAdd CustomerRef FullName' => false,
  'CreditCardCreditAdd ExpenseLineAdd ClassRef ListID' => false,
  'CreditCardCreditAdd ExpenseLineAdd ClassRef FullName' => false,
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID' => false,
  'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName' => false,
  'CreditCardCreditAdd ExpenseLineAdd BillableStatus' => false,
  'CreditCardCreditAdd ItemLineAdd ItemRef ListID' => false,
  'CreditCardCreditAdd ItemLineAdd ItemRef FullName' => false,
  'CreditCardCreditAdd ItemLineAdd Desc' => false,
  'CreditCardCreditAdd ItemLineAdd Quantity' => false,
  'CreditCardCreditAdd ItemLineAdd UnitOfMeasure' => false,
  'CreditCardCreditAdd ItemLineAdd Cost' => false,
  'CreditCardCreditAdd ItemLineAdd Amount' => false,
  'CreditCardCreditAdd ItemLineAdd TaxAmount' => false,
  'CreditCardCreditAdd ItemLineAdd CustomerRef ListID' => false,
  'CreditCardCreditAdd ItemLineAdd CustomerRef FullName' => false,
  'CreditCardCreditAdd ItemLineAdd ClassRef ListID' => false,
  'CreditCardCreditAdd ItemLineAdd ClassRef FullName' => false,
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef ListID' => false,
  'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef FullName' => false,
  'CreditCardCreditAdd ItemLineAdd BillableStatus' => false,
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef ListID' => false,
  'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef FullName' => false,
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnID' => false,
  'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnLineID' => false,
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef ListID' => false,
  'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef FullName' => false,
  'CreditCardCreditAdd ItemGroupLineAdd Desc' => false,
  'CreditCardCreditAdd ItemGroupLineAdd Quantity' => false,
  'CreditCardCreditAdd ItemGroupLineAdd UnitOfMeasure' => false,
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
  0 => 'CreditCardCreditAdd',
  1 => 'CreditCardCreditAdd AccountRef',
  2 => 'CreditCardCreditAdd AccountRef ListID',
  3 => 'CreditCardCreditAdd AccountRef FullName',
  4 => 'CreditCardCreditAdd PayeeEntityRef ListID',
  5 => 'CreditCardCreditAdd PayeeEntityRef FullName',
  6 => 'CreditCardCreditAdd TxnDate',
  7 => 'CreditCardCreditAdd RefNumber',
  8 => 'CreditCardCreditAdd Memo',
  9 => 'CreditCardCreditAdd',
  10 => 'CreditCardCreditAdd ExpenseLineAdd',
  11 => 'CreditCardCreditAdd ExpenseLineAdd AccountRef',
  12 => 'CreditCardCreditAdd ExpenseLineAdd AccountRef ListID',
  13 => 'CreditCardCreditAdd ExpenseLineAdd AccountRef FullName',
  14 => 'CreditCardCreditAdd ExpenseLineAdd Amount',
  15 => 'CreditCardCreditAdd ExpenseLineAdd TaxAmount',
  16 => 'CreditCardCreditAdd ExpenseLineAdd Memo',
  17 => 'CreditCardCreditAdd ExpenseLineAdd CustomerRef ListID',
  18 => 'CreditCardCreditAdd ExpenseLineAdd CustomerRef FullName',
  19 => 'CreditCardCreditAdd ExpenseLineAdd ClassRef ListID',
  20 => 'CreditCardCreditAdd ExpenseLineAdd ClassRef FullName',
  21 => 'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef ListID',
  22 => 'CreditCardCreditAdd ExpenseLineAdd SalesTaxCodeRef FullName',
  23 => 'CreditCardCreditAdd ExpenseLineAdd BillableStatus',
  24 => 'CreditCardCreditAdd ItemLineAdd ItemRef ListID',
  25 => 'CreditCardCreditAdd ItemLineAdd ItemRef FullName',
  26 => 'CreditCardCreditAdd ItemLineAdd Desc',
  27 => 'CreditCardCreditAdd ItemLineAdd Quantity',
  28 => 'CreditCardCreditAdd ItemLineAdd UnitOfMeasure',
  29 => 'CreditCardCreditAdd ItemLineAdd Cost',
  30 => 'CreditCardCreditAdd ItemLineAdd Amount',
  31 => 'CreditCardCreditAdd ItemLineAdd TaxAmount',
  32 => 'CreditCardCreditAdd ItemLineAdd CustomerRef ListID',
  33 => 'CreditCardCreditAdd ItemLineAdd CustomerRef FullName',
  34 => 'CreditCardCreditAdd ItemLineAdd ClassRef ListID',
  35 => 'CreditCardCreditAdd ItemLineAdd ClassRef FullName',
  36 => 'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef ListID',
  37 => 'CreditCardCreditAdd ItemLineAdd SalesTaxCodeRef FullName',
  38 => 'CreditCardCreditAdd ItemLineAdd BillableStatus',
  39 => 'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef ListID',
  40 => 'CreditCardCreditAdd ItemLineAdd OverrideItemAccountRef FullName',
  41 => 'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnID',
  42 => 'CreditCardCreditAdd ItemLineAdd LinkToTxn TxnLineID',
  43 => 'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef ListID',
  44 => 'CreditCardCreditAdd ItemGroupLineAdd ItemGroupRef FullName',
  45 => 'CreditCardCreditAdd ItemGroupLineAdd Desc',
  46 => 'CreditCardCreditAdd ItemGroupLineAdd Quantity',
  47 => 'CreditCardCreditAdd ItemGroupLineAdd UnitOfMeasure',
  48 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>