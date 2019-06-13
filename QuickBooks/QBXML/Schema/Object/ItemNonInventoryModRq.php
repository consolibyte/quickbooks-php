<?php

/**
 * Schema object for: ItemNonInventoryModRq
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
class QuickBooks_QBXML_Schema_Object_ItemNonInventoryModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemNonInventoryMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ListID' => 'IDTYPE',
  'EditSequence' => 'STRTYPE',
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'ParentRef ListID' => 'IDTYPE',
  'ParentRef FullName' => 'STRTYPE',
  'ManufacturerPartNumber' => 'STRTYPE',
  'UnitOfMeasureSetRef ListID' => 'IDTYPE',
  'UnitOfMeasureSetRef FullName' => 'STRTYPE',
  'ForceUOMChange' => 'BOOLTYPE',
  'IsTaxIncluded' => 'BOOLTYPE',
  'SalesTaxCodeRef ListID' => 'IDTYPE',
  'SalesTaxCodeRef FullName' => 'STRTYPE',
  'SalesOrPurchaseMod Desc' => 'STRTYPE',
  'SalesOrPurchaseMod Price' => 'PRICETYPE',
  'SalesOrPurchaseMod PricePercent' => 'PERCENTTYPE',
  'SalesOrPurchaseMod AccountRef ListID' => 'IDTYPE',
  'SalesOrPurchaseMod AccountRef FullName' => 'STRTYPE',
  'SalesOrPurchaseMod ApplyAccountRefToExistingTxns' => 'BOOLTYPE',
  'SalesAndPurchaseMod SalesDesc' => 'STRTYPE',
  'SalesAndPurchaseMod SalesPrice' => 'PRICETYPE',
  'SalesAndPurchaseMod IncomeAccountRef ListID' => 'IDTYPE',
  'SalesAndPurchaseMod IncomeAccountRef FullName' => 'STRTYPE',
  'SalesAndPurchaseMod ApplyIncomeAccountRefToExistingTxns' => 'BOOLTYPE',
  'SalesAndPurchaseMod PurchaseDesc' => 'STRTYPE',
  'SalesAndPurchaseMod PurchaseCost' => 'PRICETYPE',
  'SalesAndPurchaseMod PurchaseTaxCodeRef ListID' => 'IDTYPE',
  'SalesAndPurchaseMod PurchaseTaxCodeRef FullName' => 'STRTYPE',
  'SalesAndPurchaseMod ExpenseAccountRef ListID' => 'IDTYPE',
  'SalesAndPurchaseMod ExpenseAccountRef FullName' => 'STRTYPE',
  'SalesAndPurchaseMod ApplyExpenseAccountRefToExistingTxns' => 'BOOLTYPE',
  'SalesAndPurchaseMod PrefVendorRef ListID' => 'IDTYPE',
  'SalesAndPurchaseMod PrefVendorRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ListID' => 0,
  'EditSequence' => 16,
  'Name' => 31,
  'IsActive' => 0,
  'ParentRef ListID' => 0,
  'ParentRef FullName' => 0,
  'ManufacturerPartNumber' => 31,
  'UnitOfMeasureSetRef ListID' => 0,
  'UnitOfMeasureSetRef FullName' => 0,
  'ForceUOMChange' => 0,
  'IsTaxIncluded' => 0,
  'SalesTaxCodeRef ListID' => 0,
  'SalesTaxCodeRef FullName' => 0,
  'SalesOrPurchaseMod Desc' => 4095,
  'SalesOrPurchaseMod Price' => 0,
  'SalesOrPurchaseMod PricePercent' => 0,
  'SalesOrPurchaseMod AccountRef ListID' => 0,
  'SalesOrPurchaseMod AccountRef FullName' => 0,
  'SalesOrPurchaseMod ApplyAccountRefToExistingTxns' => 0,
  'SalesAndPurchaseMod SalesDesc' => 4095,
  'SalesAndPurchaseMod SalesPrice' => 0,
  'SalesAndPurchaseMod IncomeAccountRef ListID' => 0,
  'SalesAndPurchaseMod IncomeAccountRef FullName' => 0,
  'SalesAndPurchaseMod ApplyIncomeAccountRefToExistingTxns' => 0,
  'SalesAndPurchaseMod PurchaseDesc' => 4095,
  'SalesAndPurchaseMod PurchaseCost' => 0,
  'SalesAndPurchaseMod PurchaseTaxCodeRef ListID' => 0,
  'SalesAndPurchaseMod PurchaseTaxCodeRef FullName' => 0,
  'SalesAndPurchaseMod ExpenseAccountRef ListID' => 0,
  'SalesAndPurchaseMod ExpenseAccountRef FullName' => 0,
  'SalesAndPurchaseMod ApplyExpenseAccountRefToExistingTxns' => 0,
  'SalesAndPurchaseMod PrefVendorRef ListID' => 0,
  'SalesAndPurchaseMod PrefVendorRef FullName' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ListID' => false,
  'EditSequence' => false,
  'Name' => true,
  'IsActive' => true,
  'ParentRef ListID' => false,
  'ParentRef FullName' => true,
  'ManufacturerPartNumber' => true,
  'UnitOfMeasureSetRef ListID' => false,
  'UnitOfMeasureSetRef FullName' => true,
  'ForceUOMChange' => true,
  'IsTaxIncluded' => true,
  'SalesTaxCodeRef ListID' => false,
  'SalesTaxCodeRef FullName' => true,
  'SalesOrPurchaseMod Desc' => true,
  'SalesOrPurchaseMod Price' => false,
  'SalesOrPurchaseMod PricePercent' => false,
  'SalesOrPurchaseMod AccountRef ListID' => false,
  'SalesOrPurchaseMod AccountRef FullName' => true,
  'SalesOrPurchaseMod ApplyAccountRefToExistingTxns' => true,
  'SalesAndPurchaseMod SalesDesc' => true,
  'SalesAndPurchaseMod SalesPrice' => true,
  'SalesAndPurchaseMod IncomeAccountRef ListID' => false,
  'SalesAndPurchaseMod IncomeAccountRef FullName' => true,
  'SalesAndPurchaseMod ApplyIncomeAccountRefToExistingTxns' => true,
  'SalesAndPurchaseMod PurchaseDesc' => true,
  'SalesAndPurchaseMod PurchaseCost' => true,
  'SalesAndPurchaseMod PurchaseTaxCodeRef ListID' => false,
  'SalesAndPurchaseMod PurchaseTaxCodeRef FullName' => true,
  'SalesAndPurchaseMod ExpenseAccountRef ListID' => false,
  'SalesAndPurchaseMod ExpenseAccountRef FullName' => true,
  'SalesAndPurchaseMod ApplyExpenseAccountRefToExistingTxns' => true,
  'SalesAndPurchaseMod PrefVendorRef ListID' => false,
  'SalesAndPurchaseMod PrefVendorRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ListID' => 999.99,
  'EditSequence' => 999.99,
  'Name' => 999.99,
  'IsActive' => 999.99,
  'ParentRef ListID' => 999.99,
  'ParentRef FullName' => 999.99,
  'ManufacturerPartNumber' => 7,
  'UnitOfMeasureSetRef ListID' => 999.99,
  'UnitOfMeasureSetRef FullName' => 999.99,
  'ForceUOMChange' => 7,
  'IsTaxIncluded' => 6,
  'SalesTaxCodeRef ListID' => 999.99,
  'SalesTaxCodeRef FullName' => 999.99,
  'SalesOrPurchaseMod Desc' => 999.99,
  'SalesOrPurchaseMod Price' => 999.99,
  'SalesOrPurchaseMod PricePercent' => 999.99,
  'SalesOrPurchaseMod AccountRef ListID' => 999.99,
  'SalesOrPurchaseMod AccountRef FullName' => 999.99,
  'SalesOrPurchaseMod ApplyAccountRefToExistingTxns' => 7,
  'SalesAndPurchaseMod SalesDesc' => 999.99,
  'SalesAndPurchaseMod SalesPrice' => 999.99,
  'SalesAndPurchaseMod IncomeAccountRef ListID' => 999.99,
  'SalesAndPurchaseMod IncomeAccountRef FullName' => 999.99,
  'SalesAndPurchaseMod ApplyIncomeAccountRefToExistingTxns' => 7,
  'SalesAndPurchaseMod PurchaseDesc' => 999.99,
  'SalesAndPurchaseMod PurchaseCost' => 999.99,
  'SalesAndPurchaseMod PurchaseTaxCodeRef ListID' => 999.99,
  'SalesAndPurchaseMod PurchaseTaxCodeRef FullName' => 999.99,
  'SalesAndPurchaseMod ExpenseAccountRef ListID' => 999.99,
  'SalesAndPurchaseMod ExpenseAccountRef FullName' => 999.99,
  'SalesAndPurchaseMod ApplyExpenseAccountRefToExistingTxns' => 7,
  'SalesAndPurchaseMod PrefVendorRef ListID' => 999.99,
  'SalesAndPurchaseMod PrefVendorRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ListID' => false,
  'EditSequence' => false,
  'Name' => false,
  'IsActive' => false,
  'ParentRef ListID' => false,
  'ParentRef FullName' => false,
  'ManufacturerPartNumber' => false,
  'UnitOfMeasureSetRef ListID' => false,
  'UnitOfMeasureSetRef FullName' => false,
  'ForceUOMChange' => false,
  'IsTaxIncluded' => false,
  'SalesTaxCodeRef ListID' => false,
  'SalesTaxCodeRef FullName' => false,
  'SalesOrPurchaseMod Desc' => false,
  'SalesOrPurchaseMod Price' => false,
  'SalesOrPurchaseMod PricePercent' => false,
  'SalesOrPurchaseMod AccountRef ListID' => false,
  'SalesOrPurchaseMod AccountRef FullName' => false,
  'SalesOrPurchaseMod ApplyAccountRefToExistingTxns' => false,
  'SalesAndPurchaseMod SalesDesc' => false,
  'SalesAndPurchaseMod SalesPrice' => false,
  'SalesAndPurchaseMod IncomeAccountRef ListID' => false,
  'SalesAndPurchaseMod IncomeAccountRef FullName' => false,
  'SalesAndPurchaseMod ApplyIncomeAccountRefToExistingTxns' => false,
  'SalesAndPurchaseMod PurchaseDesc' => false,
  'SalesAndPurchaseMod PurchaseCost' => false,
  'SalesAndPurchaseMod PurchaseTaxCodeRef ListID' => false,
  'SalesAndPurchaseMod PurchaseTaxCodeRef FullName' => false,
  'SalesAndPurchaseMod ExpenseAccountRef ListID' => false,
  'SalesAndPurchaseMod ExpenseAccountRef FullName' => false,
  'SalesAndPurchaseMod ApplyExpenseAccountRefToExistingTxns' => false,
  'SalesAndPurchaseMod PrefVendorRef ListID' => false,
  'SalesAndPurchaseMod PrefVendorRef FullName' => false,
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
  0 => 'ListID',
  1 => 'EditSequence',
  2 => 'Name',
  3 => 'IsActive',
  4 => 'ParentRef ListID',
  5 => 'ParentRef FullName',
  6 => 'ManufacturerPartNumber',
  7 => 'UnitOfMeasureSetRef ListID',
  8 => 'UnitOfMeasureSetRef FullName',
  9 => 'ForceUOMChange',
  10 => 'IsTaxIncluded',
  11 => 'SalesTaxCodeRef ListID',
  12 => 'SalesTaxCodeRef FullName',
  13 => 'SalesOrPurchaseMod Desc',
  14 => 'SalesOrPurchaseMod Price',
  15 => 'SalesOrPurchaseMod PricePercent',
  16 => 'SalesOrPurchaseMod AccountRef ListID',
  17 => 'SalesOrPurchaseMod AccountRef FullName',
  18 => 'SalesOrPurchaseMod ApplyAccountRefToExistingTxns',
  19 => 'SalesAndPurchaseMod SalesDesc',
  20 => 'SalesAndPurchaseMod SalesPrice',
  21 => 'SalesAndPurchaseMod IncomeAccountRef ListID',
  22 => 'SalesAndPurchaseMod IncomeAccountRef FullName',
  23 => 'SalesAndPurchaseMod ApplyIncomeAccountRefToExistingTxns',
  24 => 'SalesAndPurchaseMod PurchaseDesc',
  25 => 'SalesAndPurchaseMod PurchaseCost',
  26 => 'SalesAndPurchaseMod PurchaseTaxCodeRef ListID',
  27 => 'SalesAndPurchaseMod PurchaseTaxCodeRef FullName',
  28 => 'SalesAndPurchaseMod ExpenseAccountRef ListID',
  29 => 'SalesAndPurchaseMod ExpenseAccountRef FullName',
  30 => 'SalesAndPurchaseMod ApplyExpenseAccountRefToExistingTxns',
  31 => 'SalesAndPurchaseMod PrefVendorRef ListID',
  32 => 'SalesAndPurchaseMod PrefVendorRef FullName',
  33 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>