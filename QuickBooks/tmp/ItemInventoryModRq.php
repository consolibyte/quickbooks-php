<?php

/**
 * Schema object for: ItemInventoryModRq
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
class QuickBooks_QBXML_Schema_Object_ItemInventoryModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemInventoryMod';
		
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
  'SalesDesc' => 'STRTYPE',
  'SalesPrice' => 'PRICETYPE',
  'IncomeAccountRef ListID' => 'IDTYPE',
  'IncomeAccountRef FullName' => 'STRTYPE',
  'ApplyIncomeAccountRefToExistingTxns' => 'BOOLTYPE',
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
  'SalesDesc' => 4095,
  'SalesPrice' => 0,
  'IncomeAccountRef ListID' => 0,
  'IncomeAccountRef FullName' => 0,
  'ApplyIncomeAccountRefToExistingTxns' => 0,
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
  'SalesDesc' => true,
  'SalesPrice' => true,
  'IncomeAccountRef ListID' => false,
  'IncomeAccountRef FullName' => true,
  'ApplyIncomeAccountRefToExistingTxns' => true,
  'PurchaseDesc' => true,
  'PurchaseCost' => true,
  'PurchaseTaxCodeRef ListID' => false,
  'PurchaseTaxCodeRef FullName' => true,
  'COGSAccountRef ListID' => false,
  'COGSAccountRef FullName' => true,
  'PrefVendorRef ListID' => false,
  'PrefVendorRef FullName' => true,
  'AssetAccountRef ListID' => false,
  'AssetAccountRef FullName' => true,
  'ReorderPoint' => true,
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
  'SalesDesc' => 999.99,
  'SalesPrice' => 999.99,
  'IncomeAccountRef ListID' => 999.99,
  'IncomeAccountRef FullName' => 999.99,
  'ApplyIncomeAccountRefToExistingTxns' => 7,
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
  'SalesDesc' => false,
  'SalesPrice' => false,
  'IncomeAccountRef ListID' => false,
  'IncomeAccountRef FullName' => false,
  'ApplyIncomeAccountRefToExistingTxns' => false,
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
  13 => 'SalesDesc',
  14 => 'SalesPrice',
  15 => 'IncomeAccountRef ListID',
  16 => 'IncomeAccountRef FullName',
  17 => 'ApplyIncomeAccountRefToExistingTxns',
  18 => 'PurchaseDesc',
  19 => 'PurchaseCost',
  20 => 'PurchaseTaxCodeRef ListID',
  21 => 'PurchaseTaxCodeRef FullName',
  22 => 'COGSAccountRef ListID',
  23 => 'COGSAccountRef FullName',
  24 => 'PrefVendorRef ListID',
  25 => 'PrefVendorRef FullName',
  26 => 'AssetAccountRef ListID',
  27 => 'AssetAccountRef FullName',
  28 => 'ReorderPoint',
  29 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>