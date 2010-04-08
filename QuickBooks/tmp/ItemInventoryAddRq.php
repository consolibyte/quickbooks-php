<?php

/**
 * Schema object for: ItemInventoryAddRq
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
class QuickBooks_QBXML_Schema_Object_ItemInventoryAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemInventoryAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'ParentRef ListID' => 'IDTYPE',
  'ParentRef FullName' => 'STRTYPE',
  'ManufacturerPartNumber' => 'STRTYPE',
  'UnitOfMeasureSetRef ListID' => 'IDTYPE',
  'UnitOfMeasureSetRef FullName' => 'STRTYPE',
  'IsTaxIncluded' => 'BOOLTYPE',
  'SalesTaxCodeRef ListID' => 'IDTYPE',
  'SalesTaxCodeRef FullName' => 'STRTYPE',
  'SalesDesc' => 'STRTYPE',
  'SalesPrice' => 'PRICETYPE',
  'IncomeAccountRef ListID' => 'IDTYPE',
  'IncomeAccountRef FullName' => 'STRTYPE',
  'PurchaseDesc' => 'STRTYPE',
  'PurchaseCost' => 'PRICETYPE',
  'PurchaseTaxCodeRef ListID' => 'IDTYPE',
  'PurchaseTaxCodeRef FullName' => 'STRTYPE',
  'COGSAccountRef ListID' => 'IDTYPE',
  'COGSAccountRef FullName' => 'STRTYPE',
  'PrefVendorRef ListID' => 'IDTYPE',
  'PrefVendorRef FullName' => 'STRTYPE',
  'AssetAccountRef ListID' => 'IDTYPE',
  'AssetAccountRef FullName' => 'STRTYPE',
  'ReorderPoint' => 'QUANTYPE',
  'QuantityOnHand' => 'QUANTYPE',
  'TotalValue' => 'AMTTYPE',
  'InventoryDate' => 'DATETYPE',
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
  'ManufacturerPartNumber' => 31,
  'UnitOfMeasureSetRef ListID' => 0,
  'UnitOfMeasureSetRef FullName' => 0,
  'IsTaxIncluded' => 0,
  'SalesTaxCodeRef ListID' => 0,
  'SalesTaxCodeRef FullName' => 0,
  'SalesDesc' => 4095,
  'SalesPrice' => 0,
  'IncomeAccountRef ListID' => 0,
  'IncomeAccountRef FullName' => 0,
  'PurchaseDesc' => 4095,
  'PurchaseCost' => 0,
  'PurchaseTaxCodeRef ListID' => 0,
  'PurchaseTaxCodeRef FullName' => 0,
  'COGSAccountRef ListID' => 0,
  'COGSAccountRef FullName' => 0,
  'PrefVendorRef ListID' => 0,
  'PrefVendorRef FullName' => 0,
  'AssetAccountRef ListID' => 0,
  'AssetAccountRef FullName' => 0,
  'ReorderPoint' => 0,
  'QuantityOnHand' => 0,
  'TotalValue' => 0,
  'InventoryDate' => 0,
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
  'ManufacturerPartNumber' => true,
  'UnitOfMeasureSetRef ListID' => true,
  'UnitOfMeasureSetRef FullName' => true,
  'IsTaxIncluded' => true,
  'SalesTaxCodeRef ListID' => true,
  'SalesTaxCodeRef FullName' => true,
  'SalesDesc' => true,
  'SalesPrice' => true,
  'IncomeAccountRef ListID' => true,
  'IncomeAccountRef FullName' => true,
  'PurchaseDesc' => true,
  'PurchaseCost' => true,
  'PurchaseTaxCodeRef ListID' => true,
  'PurchaseTaxCodeRef FullName' => true,
  'COGSAccountRef ListID' => true,
  'COGSAccountRef FullName' => true,
  'PrefVendorRef ListID' => true,
  'PrefVendorRef FullName' => true,
  'AssetAccountRef ListID' => true,
  'AssetAccountRef FullName' => true,
  'ReorderPoint' => true,
  'QuantityOnHand' => true,
  'TotalValue' => true,
  'InventoryDate' => true,
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
  'ManufacturerPartNumber' => 7,
  'UnitOfMeasureSetRef ListID' => 999.99,
  'UnitOfMeasureSetRef FullName' => 999.99,
  'IsTaxIncluded' => 6,
  'SalesTaxCodeRef ListID' => 999.99,
  'SalesTaxCodeRef FullName' => 999.99,
  'SalesDesc' => 999.99,
  'SalesPrice' => 999.99,
  'IncomeAccountRef ListID' => 999.99,
  'IncomeAccountRef FullName' => 999.99,
  'PurchaseDesc' => 999.99,
  'PurchaseCost' => 999.99,
  'PurchaseTaxCodeRef ListID' => 999.99,
  'PurchaseTaxCodeRef FullName' => 999.99,
  'COGSAccountRef ListID' => 999.99,
  'COGSAccountRef FullName' => 999.99,
  'PrefVendorRef ListID' => 999.99,
  'PrefVendorRef FullName' => 999.99,
  'AssetAccountRef ListID' => 999.99,
  'AssetAccountRef FullName' => 999.99,
  'ReorderPoint' => 999.99,
  'QuantityOnHand' => 999.99,
  'TotalValue' => 999.99,
  'InventoryDate' => 999.99,
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
  'ManufacturerPartNumber' => false,
  'UnitOfMeasureSetRef ListID' => false,
  'UnitOfMeasureSetRef FullName' => false,
  'IsTaxIncluded' => false,
  'SalesTaxCodeRef ListID' => false,
  'SalesTaxCodeRef FullName' => false,
  'SalesDesc' => false,
  'SalesPrice' => false,
  'IncomeAccountRef ListID' => false,
  'IncomeAccountRef FullName' => false,
  'PurchaseDesc' => false,
  'PurchaseCost' => false,
  'PurchaseTaxCodeRef ListID' => false,
  'PurchaseTaxCodeRef FullName' => false,
  'COGSAccountRef ListID' => false,
  'COGSAccountRef FullName' => false,
  'PrefVendorRef ListID' => false,
  'PrefVendorRef FullName' => false,
  'AssetAccountRef ListID' => false,
  'AssetAccountRef FullName' => false,
  'ReorderPoint' => false,
  'QuantityOnHand' => false,
  'TotalValue' => false,
  'InventoryDate' => false,
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
  4 => 'ManufacturerPartNumber',
  5 => 'UnitOfMeasureSetRef ListID',
  6 => 'UnitOfMeasureSetRef FullName',
  7 => 'IsTaxIncluded',
  8 => 'SalesTaxCodeRef ListID',
  9 => 'SalesTaxCodeRef FullName',
  10 => 'SalesDesc',
  11 => 'SalesPrice',
  12 => 'IncomeAccountRef ListID',
  13 => 'IncomeAccountRef FullName',
  14 => 'PurchaseDesc',
  15 => 'PurchaseCost',
  16 => 'PurchaseTaxCodeRef ListID',
  17 => 'PurchaseTaxCodeRef FullName',
  18 => 'COGSAccountRef ListID',
  19 => 'COGSAccountRef FullName',
  20 => 'PrefVendorRef ListID',
  21 => 'PrefVendorRef FullName',
  22 => 'AssetAccountRef ListID',
  23 => 'AssetAccountRef FullName',
  24 => 'ReorderPoint',
  25 => 'QuantityOnHand',
  26 => 'TotalValue',
  27 => 'InventoryDate',
  28 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>