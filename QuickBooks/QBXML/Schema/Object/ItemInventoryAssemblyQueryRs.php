<?php

/**
 * Schema object for: ItemInventoryAssemblyQueryRs
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
class QuickBooks_QBXML_Schema_Object_ItemInventoryAssemblyQueryRs extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';

		return $wrapper;
	}

	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRet ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRet TimeCreated' => 'DATETIMETYPE',
  'ItemInventoryAssemblyRet TimeModified' => 'DATETIMETYPE',
  'ItemInventoryAssemblyRet EditSequence' => 'STRTYPE',
  'ItemInventoryAssemblyRet Name' => 'STRTYPE',
  'ItemInventoryAssemblyRet FullName' => 'STRTYPE',
  'ItemInventoryAssemblyRet IsActive' => 'BOOLTYPE',
  'ItemInventoryAssemblyRet ParentRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRet ParentRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyRet Sublevel' => 'INTTYPE',
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyRet SalesTaxCodeRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRet SalesTaxCodeRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyRet SalesDesc' => 'STRTYPE',
  'ItemInventoryAssemblyRet SalesPrice' => 'PRICETYPE',
  'ItemInventoryAssemblyRet IncomeAccountRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRet IncomeAccountRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyRet PurchaseDesc' => 'STRTYPE',
  'ItemInventoryAssemblyRet PurchaseCost' => 'PRICETYPE',
  'ItemInventoryAssemblyRet COGSAccountRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRet COGSAccountRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyRet PrefVendorRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRet PrefVendorRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyRet AssetAccountRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRet AssetAccountRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyRet BuildPoint' => 'QUANTYPE',
  'ItemInventoryAssemblyRet QuantityOnHand' => 'QUANTYPE',
  'ItemInventoryAssemblyRet AverageCost' => 'PRICETYPE',
  'ItemInventoryAssemblyRet QuantityOnOrder' => 'QUANTYPE',
  'ItemInventoryAssemblyRet QuantityOnSalesOrder' => 'QUANTYPE',
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef FullName' => 'STRTYPE',
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine Quantity' => 'QUANTYPE',
  'ItemInventoryAssemblyRet DataExtRet OwnerID' => 'GUIDTYPE',
  'ItemInventoryAssemblyRet DataExtRet DataExtName' => 'STRTYPE',
  'ItemInventoryAssemblyRet DataExtRet DataExtType' => 'ENUMTYPE',
  'ItemInventoryAssemblyRet DataExtRet DataExtValue' => 'STRTYPE',
);

		return $paths;
	}

	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRet ListID' => 0,
  'ItemInventoryAssemblyRet TimeCreated' => 0,
  'ItemInventoryAssemblyRet TimeModified' => 0,
  'ItemInventoryAssemblyRet EditSequence' => 0,
  'ItemInventoryAssemblyRet Name' => 0,
  'ItemInventoryAssemblyRet FullName' => 0,
  'ItemInventoryAssemblyRet IsActive' => 0,
  'ItemInventoryAssemblyRet ParentRef ListID' => 0,
  'ItemInventoryAssemblyRet ParentRef FullName' => 0,
  'ItemInventoryAssemblyRet Sublevel' => 0,
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef ListID' => 0,
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef FullName' => 0,
  'ItemInventoryAssemblyRet SalesTaxCodeRef ListID' => 0,
  'ItemInventoryAssemblyRet SalesTaxCodeRef FullName' => 0,
  'ItemInventoryAssemblyRet SalesDesc' => 0,
  'ItemInventoryAssemblyRet SalesPrice' => 0,
  'ItemInventoryAssemblyRet IncomeAccountRef ListID' => 0,
  'ItemInventoryAssemblyRet IncomeAccountRef FullName' => 0,
  'ItemInventoryAssemblyRet PurchaseDesc' => 0,
  'ItemInventoryAssemblyRet PurchaseCost' => 0,
  'ItemInventoryAssemblyRet COGSAccountRef ListID' => 0,
  'ItemInventoryAssemblyRet COGSAccountRef FullName' => 0,
  'ItemInventoryAssemblyRet PrefVendorRef ListID' => 0,
  'ItemInventoryAssemblyRet PrefVendorRef FullName' => 0,
  'ItemInventoryAssemblyRet AssetAccountRef ListID' => 0,
  'ItemInventoryAssemblyRet AssetAccountRef FullName' => 0,
  'ItemInventoryAssemblyRet BuildPoint' => 0,
  'ItemInventoryAssemblyRet QuantityOnHand' => 0,
  'ItemInventoryAssemblyRet AverageCost' => 0,
  'ItemInventoryAssemblyRet QuantityOnOrder' => 0,
  'ItemInventoryAssemblyRet QuantityOnSalesOrder' => 0,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef ListID' => 0,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef FullName' => 0,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine Quantity' => 0,
  'ItemInventoryAssemblyRet DataExtRet OwnerID' => 0,
  'ItemInventoryAssemblyRet DataExtRet DataExtName' => 0,
  'ItemInventoryAssemblyRet DataExtRet DataExtType' => 0,
  'ItemInventoryAssemblyRet DataExtRet DataExtValue' => 0,
);

		return $paths;
	}

	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRet ListID' => false,
  'ItemInventoryAssemblyRet TimeCreated' => false,
  'ItemInventoryAssemblyRet TimeModified' => false,
  'ItemInventoryAssemblyRet EditSequence' => false,
  'ItemInventoryAssemblyRet Name' => false,
  'ItemInventoryAssemblyRet FullName' => false,
  'ItemInventoryAssemblyRet IsActive' => true,
  'ItemInventoryAssemblyRet ParentRef ListID' => false,
  'ItemInventoryAssemblyRet ParentRef FullName' => false,
  'ItemInventoryAssemblyRet Sublevel' => false,
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef ListID' => false,
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef FullName' => false,
  'ItemInventoryAssemblyRet SalesTaxCodeRef ListID' => false,
  'ItemInventoryAssemblyRet SalesTaxCodeRef FullName' => false,
  'ItemInventoryAssemblyRet SalesDesc' => true,
  'ItemInventoryAssemblyRet SalesPrice' => true,
  'ItemInventoryAssemblyRet IncomeAccountRef ListID' => false,
  'ItemInventoryAssemblyRet IncomeAccountRef FullName' => false,
  'ItemInventoryAssemblyRet PurchaseDesc' => true,
  'ItemInventoryAssemblyRet PurchaseCost' => true,
  'ItemInventoryAssemblyRet COGSAccountRef ListID' => false,
  'ItemInventoryAssemblyRet COGSAccountRef FullName' => false,
  'ItemInventoryAssemblyRet PrefVendorRef ListID' => false,
  'ItemInventoryAssemblyRet PrefVendorRef FullName' => false,
  'ItemInventoryAssemblyRet AssetAccountRef ListID' => false,
  'ItemInventoryAssemblyRet AssetAccountRef FullName' => false,
  'ItemInventoryAssemblyRet BuildPoint' => true,
  'ItemInventoryAssemblyRet QuantityOnHand' => true,
  'ItemInventoryAssemblyRet AverageCost' => true,
  'ItemInventoryAssemblyRet QuantityOnOrder' => true,
  'ItemInventoryAssemblyRet QuantityOnSalesOrder' => true,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef ListID' => false,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef FullName' => false,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine Quantity' => true,
  'ItemInventoryAssemblyRet DataExtRet OwnerID' => true,
  'ItemInventoryAssemblyRet DataExtRet DataExtName' => false,
  'ItemInventoryAssemblyRet DataExtRet DataExtType' => false,
  'ItemInventoryAssemblyRet DataExtRet DataExtValue' => false,
);
	}

	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRet ListID' => 999.99,
  'ItemInventoryAssemblyRet TimeCreated' => 999.99,
  'ItemInventoryAssemblyRet TimeModified' => 999.99,
  'ItemInventoryAssemblyRet EditSequence' => 999.99,
  'ItemInventoryAssemblyRet Name' => 999.99,
  'ItemInventoryAssemblyRet FullName' => 999.99,
  'ItemInventoryAssemblyRet IsActive' => 999.99,
  'ItemInventoryAssemblyRet ParentRef ListID' => 999.99,
  'ItemInventoryAssemblyRet ParentRef FullName' => 999.99,
  'ItemInventoryAssemblyRet Sublevel' => 999.99,
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef ListID' => 999.99,
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef FullName' => 999.99,
  'ItemInventoryAssemblyRet SalesTaxCodeRef ListID' => 999.99,
  'ItemInventoryAssemblyRet SalesTaxCodeRef FullName' => 999.99,
  'ItemInventoryAssemblyRet SalesDesc' => 999.99,
  'ItemInventoryAssemblyRet SalesPrice' => 999.99,
  'ItemInventoryAssemblyRet IncomeAccountRef ListID' => 999.99,
  'ItemInventoryAssemblyRet IncomeAccountRef FullName' => 999.99,
  'ItemInventoryAssemblyRet PurchaseDesc' => 999.99,
  'ItemInventoryAssemblyRet PurchaseCost' => 999.99,
  'ItemInventoryAssemblyRet COGSAccountRef ListID' => 999.99,
  'ItemInventoryAssemblyRet COGSAccountRef FullName' => 999.99,
  'ItemInventoryAssemblyRet PrefVendorRef ListID' => 999.99,
  'ItemInventoryAssemblyRet PrefVendorRef FullName' => 999.99,
  'ItemInventoryAssemblyRet AssetAccountRef ListID' => 999.99,
  'ItemInventoryAssemblyRet AssetAccountRef FullName' => 999.99,
  'ItemInventoryAssemblyRet BuildPoint' => 999.99,
  'ItemInventoryAssemblyRet QuantityOnHand' => 999.99,
  'ItemInventoryAssemblyRet AverageCost' => 999.99,
  'ItemInventoryAssemblyRet QuantityOnOrder' => 999.99,
  'ItemInventoryAssemblyRet QuantityOnSalesOrder' => 999.99,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef ListID' => 999.99,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef FullName' => 999.99,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine Quantity' => 999.99,
  'ItemInventoryAssemblyRet DataExtRet OwnerID' => 999.99,
  'ItemInventoryAssemblyRet DataExtRet DataExtName' => 999.99,
  'ItemInventoryAssemblyRet DataExtRet DataExtType' => 999.99,
  'ItemInventoryAssemblyRet DataExtRet DataExtValue' => 999.99,
);

		return $paths;
	}

	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRet ListID' => false,
  'ItemInventoryAssemblyRet TimeCreated' => false,
  'ItemInventoryAssemblyRet TimeModified' => false,
  'ItemInventoryAssemblyRet EditSequence' => false,
  'ItemInventoryAssemblyRet Name' => false,
  'ItemInventoryAssemblyRet FullName' => false,
  'ItemInventoryAssemblyRet IsActive' => false,
  'ItemInventoryAssemblyRet ParentRef ListID' => false,
  'ItemInventoryAssemblyRet ParentRef FullName' => false,
  'ItemInventoryAssemblyRet Sublevel' => false,
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef ListID' => false,
  'ItemInventoryAssemblyRet UnitOfMeasureSetRef FullName' => false,
  'ItemInventoryAssemblyRet SalesTaxCodeRef ListID' => false,
  'ItemInventoryAssemblyRet SalesTaxCodeRef FullName' => false,
  'ItemInventoryAssemblyRet SalesDesc' => false,
  'ItemInventoryAssemblyRet SalesPrice' => false,
  'ItemInventoryAssemblyRet IncomeAccountRef ListID' => false,
  'ItemInventoryAssemblyRet IncomeAccountRef FullName' => false,
  'ItemInventoryAssemblyRet PurchaseDesc' => false,
  'ItemInventoryAssemblyRet PurchaseCost' => false,
  'ItemInventoryAssemblyRet COGSAccountRef ListID' => false,
  'ItemInventoryAssemblyRet COGSAccountRef FullName' => false,
  'ItemInventoryAssemblyRet PrefVendorRef ListID' => false,
  'ItemInventoryAssemblyRet PrefVendorRef FullName' => false,
  'ItemInventoryAssemblyRet AssetAccountRef ListID' => false,
  'ItemInventoryAssemblyRet AssetAccountRef FullName' => false,
  'ItemInventoryAssemblyRet BuildPoint' => false,
  'ItemInventoryAssemblyRet QuantityOnHand' => false,
  'ItemInventoryAssemblyRet AverageCost' => false,
  'ItemInventoryAssemblyRet QuantityOnOrder' => false,
  'ItemInventoryAssemblyRet QuantityOnSalesOrder' => false,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef ListID' => false,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef FullName' => false,
  'ItemInventoryAssemblyRet ItemInventoryAssemblyLine Quantity' => false,
  'ItemInventoryAssemblyRet DataExtRet OwnerID' => false,
  'ItemInventoryAssemblyRet DataExtRet DataExtName' => false,
  'ItemInventoryAssemblyRet DataExtRet DataExtType' => false,
  'ItemInventoryAssemblyRet DataExtRet DataExtValue' => false,
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
  0 => 'ItemInventoryAssemblyRet ListID',
  1 => 'ItemInventoryAssemblyRet TimeCreated',
  2 => 'ItemInventoryAssemblyRet TimeModified',
  3 => 'ItemInventoryAssemblyRet EditSequence',
  4 => 'ItemInventoryAssemblyRet Name',
  5 => 'ItemInventoryAssemblyRet FullName',
  6 => 'ItemInventoryAssemblyRet IsActive',
  7 => 'ItemInventoryAssemblyRet ParentRef ListID',
  8 => 'ItemInventoryAssemblyRet ParentRef FullName',
  9 => 'ItemInventoryAssemblyRet Sublevel',
  10 => 'ItemInventoryAssemblyRet UnitOfMeasureSetRef ListID',
  11 => 'ItemInventoryAssemblyRet UnitOfMeasureSetRef FullName',
  12 => 'ItemInventoryAssemblyRet SalesTaxCodeRef ListID',
  13 => 'ItemInventoryAssemblyRet SalesTaxCodeRef FullName',
  14 => 'ItemInventoryAssemblyRet SalesDesc',
  15 => 'ItemInventoryAssemblyRet SalesPrice',
  16 => 'ItemInventoryAssemblyRet IncomeAccountRef ListID',
  17 => 'ItemInventoryAssemblyRet IncomeAccountRef FullName',
  18 => 'ItemInventoryAssemblyRet PurchaseDesc',
  19 => 'ItemInventoryAssemblyRet PurchaseCost',
  20 => 'ItemInventoryAssemblyRet COGSAccountRef ListID',
  21 => 'ItemInventoryAssemblyRet COGSAccountRef FullName',
  22 => 'ItemInventoryAssemblyRet PrefVendorRef ListID',
  23 => 'ItemInventoryAssemblyRet PrefVendorRef FullName',
  24 => 'ItemInventoryAssemblyRet AssetAccountRef ListID',
  25 => 'ItemInventoryAssemblyRet AssetAccountRef FullName',
  26 => 'ItemInventoryAssemblyRet BuildPoint',
  27 => 'ItemInventoryAssemblyRet QuantityOnHand',
  28 => 'ItemInventoryAssemblyRet AverageCost',
  29 => 'ItemInventoryAssemblyRet QuantityOnOrder',
  30 => 'ItemInventoryAssemblyRet QuantityOnSalesOrder',
  31 => 'ItemInventoryAssemblyRet',
  32 => 'ItemInventoryAssemblyRet ItemInventoryAssemblyLine',
  33 => 'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef',
  34 => 'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef ListID',
  35 => 'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef FullName',
  36 => 'ItemInventoryAssemblyRet ItemInventoryAssemblyLine Quantity',
  37 => 'ItemInventoryAssemblyRet DataExtRet OwnerID',
  38 => 'ItemInventoryAssemblyRet DataExtRet DataExtName',
  39 => 'ItemInventoryAssemblyRet DataExtRet DataExtType',
  40 => 'ItemInventoryAssemblyRet DataExtRet DataExtValue',
);

		return $paths;
	}
}