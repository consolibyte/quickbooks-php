<?php

/**
 * Schema object for: ItemInventoryAssemblyAddRq
 *
 * @author Keith Palmer <keith@consolibyte.com>
 * @author Jay Williams <jay@myd3.com>
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
		static $wrapper = 'ItemInventoryAssemblyAdd';

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
  'SalesTaxCodeRef ListID' => 'IDTYPE',
  'SalesTaxCodeRef FullName' => 'STRTYPE',
  'SalesDesc' => 'STRTYPE',
  'SalesPrice' => 'PRICETYPE',
  'IncomeAccountRef ListID' => 'IDTYPE',
  'IncomeAccountRef FullName' => 'STRTYPE',
  'PurchaseDesc' => 'STRTYPE',
  'PurchaseCost' => 'PRICETYPE',
  'COGSAccountRef ListID' => 'IDTYPE',
  'COGSAccountRef FullName' => 'STRTYPE',
  'PrefVendorRef ListID' => 'IDTYPE',
  'PrefVendorRef FullName' => 'STRTYPE',
  'AssetAccountRef ListID' => 'IDTYPE',
  'AssetAccountRef FullName' => 'STRTYPE',
  'BuildPoint' => 'QUANTYPE',
  'QuantityOnHand' => 'QUANTYPE',
  'TotalValue' => 'AMTTYPE',
  'InventoryDate' => 'DATETYPE',
  'ItemInventoryAssemblyLine ItemInventoryRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyLine ItemInventoryRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyLine Quantity' => 'QUANTYPE',
  'IncludeRetElement' => 'STRTYPE',
);

		return $paths;
	}

	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'Name' => 0,
  'IsActive' => 0,
  'ParentRef ListID' => 0,
  'ParentRef FullName' => 0,
  'UnitOfMeasureSetRef ListID' => 0,
  'UnitOfMeasureSetRef FullName' => 0,
  'SalesTaxCodeRef ListID' => 0,
  'SalesTaxCodeRef FullName' => 0,
  'SalesDesc' => 0,
  'SalesPrice' => 0,
  'IncomeAccountRef ListID' => 0,
  'IncomeAccountRef FullName' => 0,
  'PurchaseDesc' => 0,
  'PurchaseCost' => 0,
  'COGSAccountRef ListID' => 0,
  'COGSAccountRef FullName' => 0,
  'PrefVendorRef ListID' => 0,
  'PrefVendorRef FullName' => 0,
  'AssetAccountRef ListID' => 0,
  'AssetAccountRef FullName' => 0,
  'BuildPoint' => 0,
  'QuantityOnHand' => 0,
  'TotalValue' => 0,
  'InventoryDate' => 0,
  'ItemInventoryAssemblyLine ItemInventoryRef ListID' => 0,
  'ItemInventoryAssemblyLine ItemInventoryRef FullName' => 0,
  'ItemInventoryAssemblyLine Quantity' => 0,
  'IncludeRetElement' => 0,
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
  'SalesTaxCodeRef ListID' => true,
  'SalesTaxCodeRef FullName' => true,
  'SalesDesc' => true,
  'SalesPrice' => true,
  'IncomeAccountRef ListID' => true,
  'IncomeAccountRef FullName' => true,
  'PurchaseDesc' => true,
  'PurchaseCost' => true,
  'COGSAccountRef ListID' => true,
  'COGSAccountRef FullName' => true,
  'PrefVendorRef ListID' => true,
  'PrefVendorRef FullName' => true,
  'AssetAccountRef ListID' => true,
  'AssetAccountRef FullName' => true,
  'BuildPoint' => true,
  'QuantityOnHand' => true,
  'TotalValue' => true,
  'InventoryDate' => true,
  'ItemInventoryAssemblyLine ItemInventoryRef ListID' => true,
  'ItemInventoryAssemblyLine ItemInventoryRef FullName' => true,
  'ItemInventoryAssemblyLine Quantity' => true,
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
  'SalesTaxCodeRef ListID' => 999.99,
  'SalesTaxCodeRef FullName' => 999.99,
  'SalesDesc' => 999.99,
  'SalesPrice' => 999.99,
  'IncomeAccountRef ListID' => 999.99,
  'IncomeAccountRef FullName' => 999.99,
  'PurchaseDesc' => 999.99,
  'PurchaseCost' => 999.99,
  'COGSAccountRef ListID' => 999.99,
  'COGSAccountRef FullName' => 999.99,
  'PrefVendorRef ListID' => 999.99,
  'PrefVendorRef FullName' => 999.99,
  'AssetAccountRef ListID' => 999.99,
  'AssetAccountRef FullName' => 999.99,
  'BuildPoint' => 999.99,
  'QuantityOnHand' => 999.99,
  'TotalValue' => 999.99,
  'InventoryDate' => 999.99,
  'ItemInventoryAssemblyLine ItemInventoryRef ListID' => 999.99,
  'ItemInventoryAssemblyLine ItemInventoryRef FullName' => 999.99,
  'ItemInventoryAssemblyLine Quantity' => 999.99,
  'IncludeRetElement' => 999.99,
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
  'SalesTaxCodeRef ListID' => false,
  'SalesTaxCodeRef FullName' => false,
  'SalesDesc' => false,
  'SalesPrice' => false,
  'IncomeAccountRef ListID' => false,
  'IncomeAccountRef FullName' => false,
  'PurchaseDesc' => false,
  'PurchaseCost' => false,
  'COGSAccountRef ListID' => false,
  'COGSAccountRef FullName' => false,
  'PrefVendorRef ListID' => false,
  'PrefVendorRef FullName' => false,
  'AssetAccountRef ListID' => false,
  'AssetAccountRef FullName' => false,
  'BuildPoint' => false,
  'QuantityOnHand' => false,
  'TotalValue' => false,
  'InventoryDate' => false,
  'ItemInventoryAssemblyLine ItemInventoryRef ListID' => false,
  'ItemInventoryAssemblyLine ItemInventoryRef FullName' => false,
  'ItemInventoryAssemblyLine Quantity' => false,
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
  6 => 'SalesTaxCodeRef ListID',
  7 => 'SalesTaxCodeRef FullName',
  8 => 'SalesDesc',
  9 => 'SalesPrice',
  10 => 'IncomeAccountRef ListID',
  11 => 'IncomeAccountRef FullName',
  12 => 'PurchaseDesc',
  13 => 'PurchaseCost',
  14 => 'COGSAccountRef ListID',
  15 => 'COGSAccountRef FullName',
  16 => 'PrefVendorRef ListID',
  17 => 'PrefVendorRef FullName',
  18 => 'AssetAccountRef ListID',
  19 => 'AssetAccountRef FullName',
  20 => 'BuildPoint',
  21 => 'QuantityOnHand',
  22 => 'TotalValue',
  23 => 'InventoryDate',
  24 => 'ItemInventoryAssemblyLine',
  25 => 'ItemInventoryAssemblyLine ItemInventoryRef',
  26 => 'ItemInventoryAssemblyLine ItemInventoryRef ListID',
  27 => 'ItemInventoryAssemblyLine ItemInventoryRef FullName',
  28 => 'ItemInventoryAssemblyLine Quantity',
  29 => 'IncludeRetElement',
);

		return $paths;
	}
}