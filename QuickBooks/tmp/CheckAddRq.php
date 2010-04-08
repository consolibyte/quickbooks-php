<?php

/**
 * Schema object for: CheckAddRq
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
class QuickBooks_QBXML_Schema_Object_CheckAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'CheckAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'AccountRef ListID' => 'IDTYPE',
  'AccountRef FullName' => 'STRTYPE',
  'PayeeEntityRef ListID' => 'IDTYPE',
  'PayeeEntityRef FullName' => 'STRTYPE',
  'RefNumber' => 'STRTYPE',
  'TxnDate' => 'DATETYPE',
  'Memo' => 'STRTYPE',
  'Address Addr1' => 'STRTYPE',
  'Address Addr2' => 'STRTYPE',
  'Address Addr3' => 'STRTYPE',
  'Address Addr4' => 'STRTYPE',
  'Address Addr5' => 'STRTYPE',
  'Address City' => 'STRTYPE',
  'Address State' => 'STRTYPE',
  'Address PostalCode' => 'STRTYPE',
  'Address Country' => 'STRTYPE',
  'Address Note' => 'STRTYPE',
  'IsToBePrinted' => 'BOOLTYPE',
  'IsTaxIncluded' => 'BOOLTYPE',
  'SalesTaxCodeRef ListID' => 'IDTYPE',
  'SalesTaxCodeRef FullName' => 'STRTYPE',
  'ApplyCheckToTxnAdd TxnID' => 'IDTYPE',
  'ApplyCheckToTxnAdd Amount' => 'AMTTYPE',
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
  'AccountRef ListID' => 0,
  'AccountRef FullName' => 159,
  'PayeeEntityRef ListID' => 0,
  'PayeeEntityRef FullName' => 159,
  'RefNumber' => 11,
  'TxnDate' => 0,
  'Memo' => 4095,
  'Address Addr1' => 41,
  'Address Addr2' => 41,
  'Address Addr3' => 41,
  'Address Addr4' => 41,
  'Address Addr5' => 41,
  'Address City' => 31,
  'Address State' => 21,
  'Address PostalCode' => 13,
  'Address Country' => 31,
  'Address Note' => 41,
  'IsToBePrinted' => 0,
  'IsTaxIncluded' => 0,
  'SalesTaxCodeRef ListID' => 0,
  'SalesTaxCodeRef FullName' => 159,
  'ApplyCheckToTxnAdd TxnID' => 0,
  'ApplyCheckToTxnAdd Amount' => 0,
  'ExpenseLineAdd AccountRef ListID' => 0,
  'ExpenseLineAdd AccountRef FullName' => 159,
  'ExpenseLineAdd Amount' => 0,
  'ExpenseLineAdd TaxAmount' => 0,
  'ExpenseLineAdd Memo' => 4095,
  'ExpenseLineAdd CustomerRef ListID' => 0,
  'ExpenseLineAdd CustomerRef FullName' => 159,
  'ExpenseLineAdd ClassRef ListID' => 0,
  'ExpenseLineAdd ClassRef FullName' => 159,
  'ExpenseLineAdd SalesTaxCodeRef ListID' => 0,
  'ExpenseLineAdd SalesTaxCodeRef FullName' => 159,
  'ExpenseLineAdd BillableStatus' => 0,
  'ItemLineAdd ItemRef ListID' => 0,
  'ItemLineAdd ItemRef FullName' => 159,
  'ItemLineAdd Desc' => 4095,
  'ItemLineAdd Quantity' => 0,
  'ItemLineAdd UnitOfMeasure' => 31,
  'ItemLineAdd Cost' => 0,
  'ItemLineAdd Amount' => 0,
  'ItemLineAdd TaxAmount' => 0,
  'ItemLineAdd CustomerRef ListID' => 0,
  'ItemLineAdd CustomerRef FullName' => 159,
  'ItemLineAdd ClassRef ListID' => 0,
  'ItemLineAdd ClassRef FullName' => 159,
  'ItemLineAdd SalesTaxCodeRef ListID' => 0,
  'ItemLineAdd SalesTaxCodeRef FullName' => 159,
  'ItemLineAdd BillableStatus' => 0,
  'ItemLineAdd OverrideItemAccountRef ListID' => 0,
  'ItemLineAdd OverrideItemAccountRef FullName' => 159,
  'ItemLineAdd LinkToTxn TxnID' => 0,
  'ItemLineAdd LinkToTxn TxnLineID' => 0,
  'ItemGroupLineAdd ItemGroupRef ListID' => 0,
  'ItemGroupLineAdd ItemGroupRef FullName' => 159,
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
  'AccountRef ListID' => true,
  'AccountRef FullName' => true,
  'PayeeEntityRef ListID' => true,
  'PayeeEntityRef FullName' => true,
  'RefNumber' => true,
  'TxnDate' => true,
  'Memo' => true,
  'Address Addr1' => true,
  'Address Addr2' => true,
  'Address Addr3' => true,
  'Address Addr4' => true,
  'Address Addr5' => true,
  'Address City' => true,
  'Address State' => true,
  'Address PostalCode' => true,
  'Address Country' => true,
  'Address Note' => true,
  'IsToBePrinted' => true,
  'IsTaxIncluded' => true,
  'SalesTaxCodeRef ListID' => true,
  'SalesTaxCodeRef FullName' => true,
  'ApplyCheckToTxnAdd TxnID' => false,
  'ApplyCheckToTxnAdd Amount' => true,
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
  'AccountRef ListID' => 999.99,
  'AccountRef FullName' => 999.99,
  'PayeeEntityRef ListID' => 999.99,
  'PayeeEntityRef FullName' => 999.99,
  'RefNumber' => 999.99,
  'TxnDate' => 999.99,
  'Memo' => 999.99,
  'Address Addr1' => 999.99,
  'Address Addr2' => 999.99,
  'Address Addr3' => 999.99,
  'Address Addr4' => 2,
  'Address Addr5' => 6,
  'Address City' => 999.99,
  'Address State' => 999.99,
  'Address PostalCode' => 999.99,
  'Address Country' => 999.99,
  'Address Note' => 6,
  'IsToBePrinted' => 999.99,
  'IsTaxIncluded' => 6,
  'SalesTaxCodeRef ListID' => 999.99,
  'SalesTaxCodeRef FullName' => 999.99,
  'ApplyCheckToTxnAdd TxnID' => 0,
  'ApplyCheckToTxnAdd Amount' => 999.99,
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
  'ItemLineAdd LinkToTxn TxnID' => 0,
  'ItemLineAdd LinkToTxn TxnLineID' => 999.99,
  'ItemGroupLineAdd ItemGroupRef ListID' => 999.99,
  'ItemGroupLineAdd ItemGroupRef FullName' => 999.99,
  'ItemGroupLineAdd Desc' => 999.99,
  'ItemGroupLineAdd Quantity' => 999.99,
  'ItemGroupLineAdd UnitOfMeasure' => 7,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'AccountRef ListID' => false,
  'AccountRef FullName' => false,
  'PayeeEntityRef ListID' => false,
  'PayeeEntityRef FullName' => false,
  'RefNumber' => false,
  'TxnDate' => false,
  'Memo' => false,
  'Address Addr1' => false,
  'Address Addr2' => false,
  'Address Addr3' => false,
  'Address Addr4' => false,
  'Address Addr5' => false,
  'Address City' => false,
  'Address State' => false,
  'Address PostalCode' => false,
  'Address Country' => false,
  'Address Note' => false,
  'IsToBePrinted' => false,
  'IsTaxIncluded' => false,
  'SalesTaxCodeRef ListID' => false,
  'SalesTaxCodeRef FullName' => false,
  'ApplyCheckToTxnAdd TxnID' => false,
  'ApplyCheckToTxnAdd Amount' => false,
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
  0 => 'AccountRef ListID',
  1 => 'AccountRef FullName',
  2 => 'PayeeEntityRef ListID',
  3 => 'PayeeEntityRef FullName',
  4 => 'RefNumber',
  5 => 'TxnDate',
  6 => 'Memo',
  7 => 'Address Addr1',
  8 => 'Address Addr2',
  9 => 'Address Addr3',
  10 => 'Address Addr4',
  11 => 'Address Addr5',
  12 => 'Address City',
  13 => 'Address State',
  14 => 'Address PostalCode',
  15 => 'Address Country',
  16 => 'Address Note',
  17 => 'IsToBePrinted',
  18 => 'IsTaxIncluded',
  19 => 'SalesTaxCodeRef ListID',
  20 => 'SalesTaxCodeRef FullName',
  21 => 'ApplyCheckToTxnAdd TxnID',
  22 => 'ApplyCheckToTxnAdd Amount',
  23 => 'ExpenseLineAdd AccountRef ListID',
  24 => 'ExpenseLineAdd AccountRef FullName',
  25 => 'ExpenseLineAdd Amount',
  26 => 'ExpenseLineAdd TaxAmount',
  27 => 'ExpenseLineAdd Memo',
  28 => 'ExpenseLineAdd CustomerRef ListID',
  29 => 'ExpenseLineAdd CustomerRef FullName',
  30 => 'ExpenseLineAdd ClassRef ListID',
  31 => 'ExpenseLineAdd ClassRef FullName',
  32 => 'ExpenseLineAdd SalesTaxCodeRef ListID',
  33 => 'ExpenseLineAdd SalesTaxCodeRef FullName',
  34 => 'ExpenseLineAdd BillableStatus',
  35 => 'ItemLineAdd ItemRef ListID',
  36 => 'ItemLineAdd ItemRef FullName',
  37 => 'ItemLineAdd Desc',
  38 => 'ItemLineAdd Quantity',
  39 => 'ItemLineAdd UnitOfMeasure',
  40 => 'ItemLineAdd Cost',
  41 => 'ItemLineAdd Amount',
  42 => 'ItemLineAdd TaxAmount',
  43 => 'ItemLineAdd CustomerRef ListID',
  44 => 'ItemLineAdd CustomerRef FullName',
  45 => 'ItemLineAdd ClassRef ListID',
  46 => 'ItemLineAdd ClassRef FullName',
  47 => 'ItemLineAdd SalesTaxCodeRef ListID',
  48 => 'ItemLineAdd SalesTaxCodeRef FullName',
  49 => 'ItemLineAdd BillableStatus',
  50 => 'ItemLineAdd OverrideItemAccountRef ListID',
  51 => 'ItemLineAdd OverrideItemAccountRef FullName',
  52 => 'ItemLineAdd LinkToTxn TxnID',
  53 => 'ItemLineAdd LinkToTxn TxnLineID',
  54 => 'ItemGroupLineAdd ItemGroupRef ListID',
  55 => 'ItemGroupLineAdd ItemGroupRef FullName',
  56 => 'ItemGroupLineAdd Desc',
  57 => 'ItemGroupLineAdd Quantity',
  58 => 'ItemGroupLineAdd UnitOfMeasure',
  59 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>