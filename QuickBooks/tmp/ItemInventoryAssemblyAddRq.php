<?php

/**
 * Schema object for: ItemInventoryAssemblyAddRq
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
class QuickBooks_QBXML_Schema_Object_ItemInventoryAssemblyAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyAdd Name' => 'STRTYPE',
  'ItemInventoryAssemblyAdd IsActive' => 'BOOLTYPE',
  'ItemInventoryAssemblyAdd ParentRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyAdd ParentRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyAdd IsTaxIncluded' => 'BOOLTYPE',
  'ItemInventoryAssemblyAdd SalesTaxCodeRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyAdd SalesTaxCodeRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyAdd SalesDesc' => 'STRTYPE',
  'ItemInventoryAssemblyAdd SalesPrice' => 'PRICETYPE',
  'ItemInventoryAssemblyAdd IncomeAccountRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyAdd IncomeAccountRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyAdd PurchaseDesc' => 'STRTYPE',
  'ItemInventoryAssemblyAdd PurchaseCost' => 'PRICETYPE',
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyAdd COGSAccountRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyAdd COGSAccountRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyAdd PrefVendorRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyAdd PrefVendorRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyAdd AssetAccountRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyAdd AssetAccountRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyAdd BuildPoint' => 'QUANTYPE',
  'ItemInventoryAssemblyAdd QuantityOnHand' => 'QUANTYPE',
  'ItemInventoryAssemblyAdd TotalValue' => 'AMTTYPE',
  'ItemInventoryAssemblyAdd InventoryDate' => 'DATETYPE',
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine Quantity' => 'QUANTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyAdd Name' => 31,
  'ItemInventoryAssemblyAdd IsActive' => 0,
  'ItemInventoryAssemblyAdd ParentRef ListID' => 0,
  'ItemInventoryAssemblyAdd ParentRef FullName' => 0,
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef ListID' => 0,
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef FullName' => 0,
  'ItemInventoryAssemblyAdd IsTaxIncluded' => 0,
  'ItemInventoryAssemblyAdd SalesTaxCodeRef ListID' => 0,
  'ItemInventoryAssemblyAdd SalesTaxCodeRef FullName' => 0,
  'ItemInventoryAssemblyAdd SalesDesc' => 4095,
  'ItemInventoryAssemblyAdd SalesPrice' => 0,
  'ItemInventoryAssemblyAdd IncomeAccountRef ListID' => 0,
  'ItemInventoryAssemblyAdd IncomeAccountRef FullName' => 0,
  'ItemInventoryAssemblyAdd PurchaseDesc' => 4095,
  'ItemInventoryAssemblyAdd PurchaseCost' => 0,
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef ListID' => 0,
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef FullName' => 0,
  'ItemInventoryAssemblyAdd COGSAccountRef ListID' => 0,
  'ItemInventoryAssemblyAdd COGSAccountRef FullName' => 0,
  'ItemInventoryAssemblyAdd PrefVendorRef ListID' => 0,
  'ItemInventoryAssemblyAdd PrefVendorRef FullName' => 0,
  'ItemInventoryAssemblyAdd AssetAccountRef ListID' => 0,
  'ItemInventoryAssemblyAdd AssetAccountRef FullName' => 0,
  'ItemInventoryAssemblyAdd BuildPoint' => 0,
  'ItemInventoryAssemblyAdd QuantityOnHand' => 0,
  'ItemInventoryAssemblyAdd TotalValue' => 0,
  'ItemInventoryAssemblyAdd InventoryDate' => 0,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef ListID' => 0,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef FullName' => 0,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine Quantity' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyAdd Name' => false,
  'ItemInventoryAssemblyAdd IsActive' => true,
  'ItemInventoryAssemblyAdd ParentRef ListID' => true,
  'ItemInventoryAssemblyAdd ParentRef FullName' => true,
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef ListID' => true,
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef FullName' => true,
  'ItemInventoryAssemblyAdd IsTaxIncluded' => true,
  'ItemInventoryAssemblyAdd SalesTaxCodeRef ListID' => true,
  'ItemInventoryAssemblyAdd SalesTaxCodeRef FullName' => true,
  'ItemInventoryAssemblyAdd SalesDesc' => true,
  'ItemInventoryAssemblyAdd SalesPrice' => true,
  'ItemInventoryAssemblyAdd IncomeAccountRef ListID' => true,
  'ItemInventoryAssemblyAdd IncomeAccountRef FullName' => true,
  'ItemInventoryAssemblyAdd PurchaseDesc' => true,
  'ItemInventoryAssemblyAdd PurchaseCost' => true,
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef ListID' => true,
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef FullName' => true,
  'ItemInventoryAssemblyAdd COGSAccountRef ListID' => true,
  'ItemInventoryAssemblyAdd COGSAccountRef FullName' => true,
  'ItemInventoryAssemblyAdd PrefVendorRef ListID' => true,
  'ItemInventoryAssemblyAdd PrefVendorRef FullName' => true,
  'ItemInventoryAssemblyAdd AssetAccountRef ListID' => true,
  'ItemInventoryAssemblyAdd AssetAccountRef FullName' => true,
  'ItemInventoryAssemblyAdd BuildPoint' => true,
  'ItemInventoryAssemblyAdd QuantityOnHand' => true,
  'ItemInventoryAssemblyAdd TotalValue' => true,
  'ItemInventoryAssemblyAdd InventoryDate' => true,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef ListID' => true,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef FullName' => true,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine Quantity' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyAdd Name' => 999.99,
  'ItemInventoryAssemblyAdd IsActive' => 999.99,
  'ItemInventoryAssemblyAdd ParentRef ListID' => 999.99,
  'ItemInventoryAssemblyAdd ParentRef FullName' => 999.99,
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef ListID' => 999.99,
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef FullName' => 999.99,
  'ItemInventoryAssemblyAdd IsTaxIncluded' => 6,
  'ItemInventoryAssemblyAdd SalesTaxCodeRef ListID' => 999.99,
  'ItemInventoryAssemblyAdd SalesTaxCodeRef FullName' => 999.99,
  'ItemInventoryAssemblyAdd SalesDesc' => 999.99,
  'ItemInventoryAssemblyAdd SalesPrice' => 999.99,
  'ItemInventoryAssemblyAdd IncomeAccountRef ListID' => 999.99,
  'ItemInventoryAssemblyAdd IncomeAccountRef FullName' => 999.99,
  'ItemInventoryAssemblyAdd PurchaseDesc' => 999.99,
  'ItemInventoryAssemblyAdd PurchaseCost' => 999.99,
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef ListID' => 999.99,
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef FullName' => 999.99,
  'ItemInventoryAssemblyAdd COGSAccountRef ListID' => 999.99,
  'ItemInventoryAssemblyAdd COGSAccountRef FullName' => 999.99,
  'ItemInventoryAssemblyAdd PrefVendorRef ListID' => 999.99,
  'ItemInventoryAssemblyAdd PrefVendorRef FullName' => 999.99,
  'ItemInventoryAssemblyAdd AssetAccountRef ListID' => 999.99,
  'ItemInventoryAssemblyAdd AssetAccountRef FullName' => 999.99,
  'ItemInventoryAssemblyAdd BuildPoint' => 999.99,
  'ItemInventoryAssemblyAdd QuantityOnHand' => 999.99,
  'ItemInventoryAssemblyAdd TotalValue' => 999.99,
  'ItemInventoryAssemblyAdd InventoryDate' => 999.99,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef ListID' => 999.99,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef FullName' => 999.99,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine Quantity' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyAdd Name' => false,
  'ItemInventoryAssemblyAdd IsActive' => false,
  'ItemInventoryAssemblyAdd ParentRef ListID' => false,
  'ItemInventoryAssemblyAdd ParentRef FullName' => false,
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef ListID' => false,
  'ItemInventoryAssemblyAdd UnitOfMeasureSetRef FullName' => false,
  'ItemInventoryAssemblyAdd IsTaxIncluded' => false,
  'ItemInventoryAssemblyAdd SalesTaxCodeRef ListID' => false,
  'ItemInventoryAssemblyAdd SalesTaxCodeRef FullName' => false,
  'ItemInventoryAssemblyAdd SalesDesc' => false,
  'ItemInventoryAssemblyAdd SalesPrice' => false,
  'ItemInventoryAssemblyAdd IncomeAccountRef ListID' => false,
  'ItemInventoryAssemblyAdd IncomeAccountRef FullName' => false,
  'ItemInventoryAssemblyAdd PurchaseDesc' => false,
  'ItemInventoryAssemblyAdd PurchaseCost' => false,
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef ListID' => false,
  'ItemInventoryAssemblyAdd PurchaseTaxCodeRef FullName' => false,
  'ItemInventoryAssemblyAdd COGSAccountRef ListID' => false,
  'ItemInventoryAssemblyAdd COGSAccountRef FullName' => false,
  'ItemInventoryAssemblyAdd PrefVendorRef ListID' => false,
  'ItemInventoryAssemblyAdd PrefVendorRef FullName' => false,
  'ItemInventoryAssemblyAdd AssetAccountRef ListID' => false,
  'ItemInventoryAssemblyAdd AssetAccountRef FullName' => false,
  'ItemInventoryAssemblyAdd BuildPoint' => false,
  'ItemInventoryAssemblyAdd QuantityOnHand' => false,
  'ItemInventoryAssemblyAdd TotalValue' => false,
  'ItemInventoryAssemblyAdd InventoryDate' => false,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef ListID' => false,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef FullName' => false,
  'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine Quantity' => false,
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
  0 => 'ItemInventoryAssemblyAdd Name',
  1 => 'ItemInventoryAssemblyAdd IsActive',
  2 => 'ItemInventoryAssemblyAdd ParentRef ListID',
  3 => 'ItemInventoryAssemblyAdd ParentRef FullName',
  4 => 'ItemInventoryAssemblyAdd UnitOfMeasureSetRef ListID',
  5 => 'ItemInventoryAssemblyAdd UnitOfMeasureSetRef FullName',
  6 => 'ItemInventoryAssemblyAdd IsTaxIncluded',
  7 => 'ItemInventoryAssemblyAdd SalesTaxCodeRef ListID',
  8 => 'ItemInventoryAssemblyAdd SalesTaxCodeRef FullName',
  9 => 'ItemInventoryAssemblyAdd SalesDesc',
  10 => 'ItemInventoryAssemblyAdd SalesPrice',
  11 => 'ItemInventoryAssemblyAdd IncomeAccountRef ListID',
  12 => 'ItemInventoryAssemblyAdd IncomeAccountRef FullName',
  13 => 'ItemInventoryAssemblyAdd PurchaseDesc',
  14 => 'ItemInventoryAssemblyAdd PurchaseCost',
  15 => 'ItemInventoryAssemblyAdd PurchaseTaxCodeRef ListID',
  16 => 'ItemInventoryAssemblyAdd PurchaseTaxCodeRef FullName',
  17 => 'ItemInventoryAssemblyAdd COGSAccountRef ListID',
  18 => 'ItemInventoryAssemblyAdd COGSAccountRef FullName',
  19 => 'ItemInventoryAssemblyAdd PrefVendorRef ListID',
  20 => 'ItemInventoryAssemblyAdd PrefVendorRef FullName',
  21 => 'ItemInventoryAssemblyAdd AssetAccountRef ListID',
  22 => 'ItemInventoryAssemblyAdd AssetAccountRef FullName',
  23 => 'ItemInventoryAssemblyAdd BuildPoint',
  24 => 'ItemInventoryAssemblyAdd QuantityOnHand',
  25 => 'ItemInventoryAssemblyAdd TotalValue',
  26 => 'ItemInventoryAssemblyAdd InventoryDate',
  27 => 'ItemInventoryAssemblyAdd',
  28 => 'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine',
  29 => 'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef',
  30 => 'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef ListID',
  31 => 'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine ItemInventoryRef FullName',
  32 => 'ItemInventoryAssemblyAdd ItemInventoryAssemblyLine Quantity',
  33 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>