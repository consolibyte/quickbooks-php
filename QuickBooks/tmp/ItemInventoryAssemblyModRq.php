<?php

/**
 * Schema object for: ItemInventoryAssemblyModRq
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
class QuickBooks_QBXML_Schema_Object_ItemInventoryAssemblyModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyMod ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod EditSequence' => 'STRTYPE',
  'ItemInventoryAssemblyMod Name' => 'STRTYPE',
  'ItemInventoryAssemblyMod IsActive' => 'BOOLTYPE',
  'ItemInventoryAssemblyMod ParentRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod ParentRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyMod ForceUOMChange' => 'BOOLTYPE',
  'ItemInventoryAssemblyMod IsTaxIncluded' => 'BOOLTYPE',
  'ItemInventoryAssemblyMod SalesTaxCodeRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod SalesTaxCodeRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyMod SalesDesc' => 'STRTYPE',
  'ItemInventoryAssemblyMod SalesPrice' => 'PRICETYPE',
  'ItemInventoryAssemblyMod IncomeAccountRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod IncomeAccountRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyMod ApplyIncomeAccountRefToExistingTxns' => 'BOOLTYPE',
  'ItemInventoryAssemblyMod PurchaseDesc' => 'STRTYPE',
  'ItemInventoryAssemblyMod PurchaseCost' => 'PRICETYPE',
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyMod COGSAccountRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod COGSAccountRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyMod PrefVendorRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod PrefVendorRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyMod AssetAccountRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod AssetAccountRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyMod BuildPoint' => 'QUANTYPE',
  'ItemInventoryAssemblyMod ClearItemsInGroup' => 'BOOLTYPE',
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine Quantity' => 'QUANTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyMod ListID' => 0,
  'ItemInventoryAssemblyMod EditSequence' => 16,
  'ItemInventoryAssemblyMod Name' => 31,
  'ItemInventoryAssemblyMod IsActive' => 0,
  'ItemInventoryAssemblyMod ParentRef ListID' => 0,
  'ItemInventoryAssemblyMod ParentRef FullName' => 0,
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef ListID' => 0,
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef FullName' => 0,
  'ItemInventoryAssemblyMod ForceUOMChange' => 0,
  'ItemInventoryAssemblyMod IsTaxIncluded' => 0,
  'ItemInventoryAssemblyMod SalesTaxCodeRef ListID' => 0,
  'ItemInventoryAssemblyMod SalesTaxCodeRef FullName' => 0,
  'ItemInventoryAssemblyMod SalesDesc' => 4095,
  'ItemInventoryAssemblyMod SalesPrice' => 0,
  'ItemInventoryAssemblyMod IncomeAccountRef ListID' => 0,
  'ItemInventoryAssemblyMod IncomeAccountRef FullName' => 0,
  'ItemInventoryAssemblyMod ApplyIncomeAccountRefToExistingTxns' => 0,
  'ItemInventoryAssemblyMod PurchaseDesc' => 4095,
  'ItemInventoryAssemblyMod PurchaseCost' => 0,
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef ListID' => 0,
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef FullName' => 0,
  'ItemInventoryAssemblyMod COGSAccountRef ListID' => 0,
  'ItemInventoryAssemblyMod COGSAccountRef FullName' => 0,
  'ItemInventoryAssemblyMod PrefVendorRef ListID' => 0,
  'ItemInventoryAssemblyMod PrefVendorRef FullName' => 0,
  'ItemInventoryAssemblyMod AssetAccountRef ListID' => 0,
  'ItemInventoryAssemblyMod AssetAccountRef FullName' => 0,
  'ItemInventoryAssemblyMod BuildPoint' => 0,
  'ItemInventoryAssemblyMod ClearItemsInGroup' => 0,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef ListID' => 0,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef FullName' => 0,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine Quantity' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyMod ListID' => false,
  'ItemInventoryAssemblyMod EditSequence' => false,
  'ItemInventoryAssemblyMod Name' => true,
  'ItemInventoryAssemblyMod IsActive' => true,
  'ItemInventoryAssemblyMod ParentRef ListID' => false,
  'ItemInventoryAssemblyMod ParentRef FullName' => true,
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef ListID' => false,
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef FullName' => true,
  'ItemInventoryAssemblyMod ForceUOMChange' => true,
  'ItemInventoryAssemblyMod IsTaxIncluded' => true,
  'ItemInventoryAssemblyMod SalesTaxCodeRef ListID' => false,
  'ItemInventoryAssemblyMod SalesTaxCodeRef FullName' => true,
  'ItemInventoryAssemblyMod SalesDesc' => true,
  'ItemInventoryAssemblyMod SalesPrice' => true,
  'ItemInventoryAssemblyMod IncomeAccountRef ListID' => false,
  'ItemInventoryAssemblyMod IncomeAccountRef FullName' => true,
  'ItemInventoryAssemblyMod ApplyIncomeAccountRefToExistingTxns' => true,
  'ItemInventoryAssemblyMod PurchaseDesc' => true,
  'ItemInventoryAssemblyMod PurchaseCost' => true,
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef ListID' => false,
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef FullName' => true,
  'ItemInventoryAssemblyMod COGSAccountRef ListID' => false,
  'ItemInventoryAssemblyMod COGSAccountRef FullName' => true,
  'ItemInventoryAssemblyMod PrefVendorRef ListID' => false,
  'ItemInventoryAssemblyMod PrefVendorRef FullName' => true,
  'ItemInventoryAssemblyMod AssetAccountRef ListID' => false,
  'ItemInventoryAssemblyMod AssetAccountRef FullName' => true,
  'ItemInventoryAssemblyMod BuildPoint' => true,
  'ItemInventoryAssemblyMod ClearItemsInGroup' => false,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef ListID' => false,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef FullName' => true,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine Quantity' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyMod ListID' => 999.99,
  'ItemInventoryAssemblyMod EditSequence' => 999.99,
  'ItemInventoryAssemblyMod Name' => 999.99,
  'ItemInventoryAssemblyMod IsActive' => 999.99,
  'ItemInventoryAssemblyMod ParentRef ListID' => 999.99,
  'ItemInventoryAssemblyMod ParentRef FullName' => 999.99,
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef ListID' => 999.99,
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef FullName' => 999.99,
  'ItemInventoryAssemblyMod ForceUOMChange' => 7,
  'ItemInventoryAssemblyMod IsTaxIncluded' => 6,
  'ItemInventoryAssemblyMod SalesTaxCodeRef ListID' => 999.99,
  'ItemInventoryAssemblyMod SalesTaxCodeRef FullName' => 999.99,
  'ItemInventoryAssemblyMod SalesDesc' => 999.99,
  'ItemInventoryAssemblyMod SalesPrice' => 999.99,
  'ItemInventoryAssemblyMod IncomeAccountRef ListID' => 999.99,
  'ItemInventoryAssemblyMod IncomeAccountRef FullName' => 999.99,
  'ItemInventoryAssemblyMod ApplyIncomeAccountRefToExistingTxns' => 7,
  'ItemInventoryAssemblyMod PurchaseDesc' => 999.99,
  'ItemInventoryAssemblyMod PurchaseCost' => 999.99,
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef ListID' => 999.99,
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef FullName' => 999.99,
  'ItemInventoryAssemblyMod COGSAccountRef ListID' => 999.99,
  'ItemInventoryAssemblyMod COGSAccountRef FullName' => 999.99,
  'ItemInventoryAssemblyMod PrefVendorRef ListID' => 999.99,
  'ItemInventoryAssemblyMod PrefVendorRef FullName' => 999.99,
  'ItemInventoryAssemblyMod AssetAccountRef ListID' => 999.99,
  'ItemInventoryAssemblyMod AssetAccountRef FullName' => 999.99,
  'ItemInventoryAssemblyMod BuildPoint' => 999.99,
  'ItemInventoryAssemblyMod ClearItemsInGroup' => 999.99,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef ListID' => 999.99,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef FullName' => 999.99,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine Quantity' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyMod ListID' => false,
  'ItemInventoryAssemblyMod EditSequence' => false,
  'ItemInventoryAssemblyMod Name' => false,
  'ItemInventoryAssemblyMod IsActive' => false,
  'ItemInventoryAssemblyMod ParentRef ListID' => false,
  'ItemInventoryAssemblyMod ParentRef FullName' => false,
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef ListID' => false,
  'ItemInventoryAssemblyMod UnitOfMeasureSetRef FullName' => false,
  'ItemInventoryAssemblyMod ForceUOMChange' => false,
  'ItemInventoryAssemblyMod IsTaxIncluded' => false,
  'ItemInventoryAssemblyMod SalesTaxCodeRef ListID' => false,
  'ItemInventoryAssemblyMod SalesTaxCodeRef FullName' => false,
  'ItemInventoryAssemblyMod SalesDesc' => false,
  'ItemInventoryAssemblyMod SalesPrice' => false,
  'ItemInventoryAssemblyMod IncomeAccountRef ListID' => false,
  'ItemInventoryAssemblyMod IncomeAccountRef FullName' => false,
  'ItemInventoryAssemblyMod ApplyIncomeAccountRefToExistingTxns' => false,
  'ItemInventoryAssemblyMod PurchaseDesc' => false,
  'ItemInventoryAssemblyMod PurchaseCost' => false,
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef ListID' => false,
  'ItemInventoryAssemblyMod PurchaseTaxCodeRef FullName' => false,
  'ItemInventoryAssemblyMod COGSAccountRef ListID' => false,
  'ItemInventoryAssemblyMod COGSAccountRef FullName' => false,
  'ItemInventoryAssemblyMod PrefVendorRef ListID' => false,
  'ItemInventoryAssemblyMod PrefVendorRef FullName' => false,
  'ItemInventoryAssemblyMod AssetAccountRef ListID' => false,
  'ItemInventoryAssemblyMod AssetAccountRef FullName' => false,
  'ItemInventoryAssemblyMod BuildPoint' => false,
  'ItemInventoryAssemblyMod ClearItemsInGroup' => false,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef ListID' => false,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef FullName' => false,
  'ItemInventoryAssemblyMod ItemInventoryAssemblyLine Quantity' => false,
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
  0 => 'ItemInventoryAssemblyMod ListID',
  1 => 'ItemInventoryAssemblyMod EditSequence',
  2 => 'ItemInventoryAssemblyMod Name',
  3 => 'ItemInventoryAssemblyMod IsActive',
  4 => 'ItemInventoryAssemblyMod ParentRef ListID',
  5 => 'ItemInventoryAssemblyMod ParentRef FullName',
  6 => 'ItemInventoryAssemblyMod UnitOfMeasureSetRef ListID',
  7 => 'ItemInventoryAssemblyMod UnitOfMeasureSetRef FullName',
  8 => 'ItemInventoryAssemblyMod ForceUOMChange',
  9 => 'ItemInventoryAssemblyMod IsTaxIncluded',
  10 => 'ItemInventoryAssemblyMod SalesTaxCodeRef ListID',
  11 => 'ItemInventoryAssemblyMod SalesTaxCodeRef FullName',
  12 => 'ItemInventoryAssemblyMod SalesDesc',
  13 => 'ItemInventoryAssemblyMod SalesPrice',
  14 => 'ItemInventoryAssemblyMod IncomeAccountRef ListID',
  15 => 'ItemInventoryAssemblyMod IncomeAccountRef FullName',
  16 => 'ItemInventoryAssemblyMod ApplyIncomeAccountRefToExistingTxns',
  17 => 'ItemInventoryAssemblyMod PurchaseDesc',
  18 => 'ItemInventoryAssemblyMod PurchaseCost',
  19 => 'ItemInventoryAssemblyMod PurchaseTaxCodeRef ListID',
  20 => 'ItemInventoryAssemblyMod PurchaseTaxCodeRef FullName',
  21 => 'ItemInventoryAssemblyMod COGSAccountRef ListID',
  22 => 'ItemInventoryAssemblyMod COGSAccountRef FullName',
  23 => 'ItemInventoryAssemblyMod PrefVendorRef ListID',
  24 => 'ItemInventoryAssemblyMod PrefVendorRef FullName',
  25 => 'ItemInventoryAssemblyMod AssetAccountRef ListID',
  26 => 'ItemInventoryAssemblyMod AssetAccountRef FullName',
  27 => 'ItemInventoryAssemblyMod BuildPoint',
  28 => 'ItemInventoryAssemblyMod ClearItemsInGroup',
  29 => 'ItemInventoryAssemblyMod',
  30 => 'ItemInventoryAssemblyMod ItemInventoryAssemblyLine',
  31 => 'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef',
  32 => 'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef ListID',
  33 => 'ItemInventoryAssemblyMod ItemInventoryAssemblyLine ItemInventoryRef FullName',
  34 => 'ItemInventoryAssemblyMod ItemInventoryAssemblyLine Quantity',
  35 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>