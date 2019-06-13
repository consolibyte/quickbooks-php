<?php

/**
 * Schema object for: ItemServiceAddRq
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
class QuickBooks_QBXML_Schema_Object_ItemServiceAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemServiceAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'ParentRef ListID' => 'IDTYPE',
  'ParentRef FullName' => 'STRTYPE',
  'UnitOfMeasureSetRef ListID' => 'IDTYPE',
  'UnitOfMeasureSetRef FullName' => 'STRTYPE',
  'IsTaxIncluded' => 'BOOLTYPE',
  'SalesTaxCodeRef ListID' => 'IDTYPE',
  'SalesTaxCodeRef FullName' => 'STRTYPE',
  'SalesOrPurchase Desc' => 'STRTYPE',
  'SalesOrPurchase Price' => 'PRICETYPE',
  'SalesOrPurchase PricePercent' => 'PERCENTTYPE',
  'SalesOrPurchase AccountRef ListID' => 'IDTYPE',
  'SalesOrPurchase AccountRef FullName' => 'STRTYPE',
  'SalesAndPurchase SalesDesc' => 'STRTYPE',
  'SalesAndPurchase SalesPrice' => 'PRICETYPE',
  'SalesAndPurchase IncomeAccountRef ListID' => 'IDTYPE',
  'SalesAndPurchase IncomeAccountRef FullName' => 'STRTYPE',
  'SalesAndPurchase PurchaseDesc' => 'STRTYPE',
  'SalesAndPurchase PurchaseCost' => 'PRICETYPE',
  'SalesAndPurchase PurchaseTaxCodeRef ListID' => 'IDTYPE',
  'SalesAndPurchase PurchaseTaxCodeRef FullName' => 'STRTYPE',
  'SalesAndPurchase ExpenseAccountRef ListID' => 'IDTYPE',
  'SalesAndPurchase ExpenseAccountRef FullName' => 'STRTYPE',
  'SalesAndPurchase PrefVendorRef ListID' => 'IDTYPE',
  'SalesAndPurchase PrefVendorRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'Name' => 31,
  'IsActive' => 0,
  'ParentRef ListID' => 0,
  'ParentRef FullName' => 0,
  'UnitOfMeasureSetRef ListID' => 0,
  'UnitOfMeasureSetRef FullName' => 0,
  'IsTaxIncluded' => 0,
  'SalesTaxCodeRef ListID' => 0,
  'SalesTaxCodeRef FullName' => 0,
  'SalesOrPurchase Desc' => 4095,
  'SalesOrPurchase Price' => 0,
  'SalesOrPurchase PricePercent' => 0,
  'SalesOrPurchase AccountRef ListID' => 0,
  'SalesOrPurchase AccountRef FullName' => 0,
  'SalesAndPurchase SalesDesc' => 4095,
  'SalesAndPurchase SalesPrice' => 0,
  'SalesAndPurchase IncomeAccountRef ListID' => 0,
  'SalesAndPurchase IncomeAccountRef FullName' => 0,
  'SalesAndPurchase PurchaseDesc' => 4095,
  'SalesAndPurchase PurchaseCost' => 0,
  'SalesAndPurchase PurchaseTaxCodeRef ListID' => 0,
  'SalesAndPurchase PurchaseTaxCodeRef FullName' => 0,
  'SalesAndPurchase ExpenseAccountRef ListID' => 0,
  'SalesAndPurchase ExpenseAccountRef FullName' => 0,
  'SalesAndPurchase PrefVendorRef ListID' => 0,
  'SalesAndPurchase PrefVendorRef FullName' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => true,
  'ParentRef ListID' => true,
  'ParentRef FullName' => true,
  'UnitOfMeasureSetRef ListID' => true,
  'UnitOfMeasureSetRef FullName' => true,
  'IsTaxIncluded' => true,
  'SalesTaxCodeRef ListID' => true,
  'SalesTaxCodeRef FullName' => true,
  'SalesOrPurchase Desc' => true,
  'SalesOrPurchase Price' => false,
  'SalesOrPurchase PricePercent' => false,
  'SalesOrPurchase AccountRef ListID' => true,
  'SalesOrPurchase AccountRef FullName' => true,
  'SalesAndPurchase SalesDesc' => true,
  'SalesAndPurchase SalesPrice' => true,
  'SalesAndPurchase IncomeAccountRef ListID' => true,
  'SalesAndPurchase IncomeAccountRef FullName' => true,
  'SalesAndPurchase PurchaseDesc' => true,
  'SalesAndPurchase PurchaseCost' => true,
  'SalesAndPurchase PurchaseTaxCodeRef ListID' => true,
  'SalesAndPurchase PurchaseTaxCodeRef FullName' => true,
  'SalesAndPurchase ExpenseAccountRef ListID' => true,
  'SalesAndPurchase ExpenseAccountRef FullName' => true,
  'SalesAndPurchase PrefVendorRef ListID' => true,
  'SalesAndPurchase PrefVendorRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'Name' => 999.99,
  'IsActive' => 999.99,
  'ParentRef ListID' => 999.99,
  'ParentRef FullName' => 999.99,
  'UnitOfMeasureSetRef ListID' => 999.99,
  'UnitOfMeasureSetRef FullName' => 999.99,
  'IsTaxIncluded' => 6,
  'SalesTaxCodeRef ListID' => 999.99,
  'SalesTaxCodeRef FullName' => 999.99,
  'SalesOrPurchase Desc' => 999.99,
  'SalesOrPurchase Price' => 999.99,
  'SalesOrPurchase PricePercent' => 999.99,
  'SalesOrPurchase AccountRef ListID' => 999.99,
  'SalesOrPurchase AccountRef FullName' => 999.99,
  'SalesAndPurchase SalesDesc' => 999.99,
  'SalesAndPurchase SalesPrice' => 999.99,
  'SalesAndPurchase IncomeAccountRef ListID' => 999.99,
  'SalesAndPurchase IncomeAccountRef FullName' => 999.99,
  'SalesAndPurchase PurchaseDesc' => 999.99,
  'SalesAndPurchase PurchaseCost' => 999.99,
  'SalesAndPurchase PurchaseTaxCodeRef ListID' => 999.99,
  'SalesAndPurchase PurchaseTaxCodeRef FullName' => 999.99,
  'SalesAndPurchase ExpenseAccountRef ListID' => 999.99,
  'SalesAndPurchase ExpenseAccountRef FullName' => 999.99,
  'SalesAndPurchase PrefVendorRef ListID' => 999.99,
  'SalesAndPurchase PrefVendorRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => false,
  'ParentRef ListID' => false,
  'ParentRef FullName' => false,
  'UnitOfMeasureSetRef ListID' => false,
  'UnitOfMeasureSetRef FullName' => false,
  'IsTaxIncluded' => false,
  'SalesTaxCodeRef ListID' => false,
  'SalesTaxCodeRef FullName' => false,
  'SalesOrPurchase Desc' => false,
  'SalesOrPurchase Price' => false,
  'SalesOrPurchase PricePercent' => false,
  'SalesOrPurchase AccountRef ListID' => false,
  'SalesOrPurchase AccountRef FullName' => false,
  'SalesAndPurchase SalesDesc' => false,
  'SalesAndPurchase SalesPrice' => false,
  'SalesAndPurchase IncomeAccountRef ListID' => false,
  'SalesAndPurchase IncomeAccountRef FullName' => false,
  'SalesAndPurchase PurchaseDesc' => false,
  'SalesAndPurchase PurchaseCost' => false,
  'SalesAndPurchase PurchaseTaxCodeRef ListID' => false,
  'SalesAndPurchase PurchaseTaxCodeRef FullName' => false,
  'SalesAndPurchase ExpenseAccountRef ListID' => false,
  'SalesAndPurchase ExpenseAccountRef FullName' => false,
  'SalesAndPurchase PrefVendorRef ListID' => false,
  'SalesAndPurchase PrefVendorRef FullName' => false,
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
  0 => 'Name',
  1 => 'IsActive',
  2 => 'ParentRef ListID',
  3 => 'ParentRef FullName',
  4 => 'UnitOfMeasureSetRef ListID',
  5 => 'UnitOfMeasureSetRef FullName',
  6 => 'IsTaxIncluded',
  7 => 'SalesTaxCodeRef ListID',
  8 => 'SalesTaxCodeRef FullName',
  9 => 'SalesOrPurchase Desc',
  10 => 'SalesOrPurchase Price',
  11 => 'SalesOrPurchase PricePercent',
  12 => 'SalesOrPurchase AccountRef ListID',
  13 => 'SalesOrPurchase AccountRef FullName',
  14 => 'SalesAndPurchase SalesDesc',
  15 => 'SalesAndPurchase SalesPrice',
  16 => 'SalesAndPurchase IncomeAccountRef ListID',
  17 => 'SalesAndPurchase IncomeAccountRef FullName',
  18 => 'SalesAndPurchase PurchaseDesc',
  19 => 'SalesAndPurchase PurchaseCost',
  20 => 'SalesAndPurchase PurchaseTaxCodeRef ListID',
  21 => 'SalesAndPurchase PurchaseTaxCodeRef FullName',
  22 => 'SalesAndPurchase ExpenseAccountRef ListID',
  23 => 'SalesAndPurchase ExpenseAccountRef FullName',
  24 => 'SalesAndPurchase PrefVendorRef ListID',
  25 => 'SalesAndPurchase PrefVendorRef FullName',
  26 => 'IncludeRetElement',
);
			
		return $paths;
	}
}
