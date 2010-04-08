<?php

/**
 * Schema object for: InventoryAdjustmentAddRq
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
class QuickBooks_QBXML_Schema_Object_InventoryAdjustmentAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'InventoryAdjustmentAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'AccountRef ListID' => 'IDTYPE',
  'AccountRef FullName' => 'STRTYPE',
  'TxnDate' => 'DATETYPE',
  'RefNumber' => 'STRTYPE',
  'CustomerRef ListID' => 'IDTYPE',
  'CustomerRef FullName' => 'STRTYPE',
  'ClassRef ListID' => 'IDTYPE',
  'ClassRef FullName' => 'STRTYPE',
  'Memo' => 'STRTYPE',
  'InventoryAdjustmentLineAdd ItemRef ListID' => 'IDTYPE',
  'InventoryAdjustmentLineAdd ItemRef FullName' => 'STRTYPE',
  'InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => 'QUANTYPE',
  'InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => 'QUANTYPE',
  'InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => 'QUANTYPE',
  'InventoryAdjustmentLineAdd ValueAdjustment NewValue' => 'AMTTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'AccountRef ListID' => 0,
  'AccountRef FullName' => 159,
  'TxnDate' => 0,
  'RefNumber' => 11,
  'CustomerRef ListID' => 0,
  'CustomerRef FullName' => 159,
  'ClassRef ListID' => 0,
  'ClassRef FullName' => 159,
  'Memo' => 4095,
  'InventoryAdjustmentLineAdd ItemRef ListID' => 0,
  'InventoryAdjustmentLineAdd ItemRef FullName' => 159,
  'InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => 0,
  'InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => 0,
  'InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => 0,
  'InventoryAdjustmentLineAdd ValueAdjustment NewValue' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'AccountRef ListID' => true,
  'AccountRef FullName' => true,
  'TxnDate' => true,
  'RefNumber' => true,
  'CustomerRef ListID' => true,
  'CustomerRef FullName' => true,
  'ClassRef ListID' => true,
  'ClassRef FullName' => true,
  'Memo' => true,
  'InventoryAdjustmentLineAdd ItemRef ListID' => true,
  'InventoryAdjustmentLineAdd ItemRef FullName' => true,
  'InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => false,
  'InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => false,
  'InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => false,
  'InventoryAdjustmentLineAdd ValueAdjustment NewValue' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'AccountRef ListID' => 999.99,
  'AccountRef FullName' => 999.99,
  'TxnDate' => 999.99,
  'RefNumber' => 999.99,
  'CustomerRef ListID' => 999.99,
  'CustomerRef FullName' => 999.99,
  'ClassRef ListID' => 999.99,
  'ClassRef FullName' => 999.99,
  'Memo' => 999.99,
  'InventoryAdjustmentLineAdd ItemRef ListID' => 999.99,
  'InventoryAdjustmentLineAdd ItemRef FullName' => 999.99,
  'InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => 999.99,
  'InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => 999.99,
  'InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => 999.99,
  'InventoryAdjustmentLineAdd ValueAdjustment NewValue' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'AccountRef ListID' => false,
  'AccountRef FullName' => false,
  'TxnDate' => false,
  'RefNumber' => false,
  'CustomerRef ListID' => false,
  'CustomerRef FullName' => false,
  'ClassRef ListID' => false,
  'ClassRef FullName' => false,
  'Memo' => false,
  'InventoryAdjustmentLineAdd ItemRef ListID' => false,
  'InventoryAdjustmentLineAdd ItemRef FullName' => false,
  'InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => false,
  'InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => false,
  'InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => false,
  'InventoryAdjustmentLineAdd ValueAdjustment NewValue' => false,
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
  0 => 'InventoryAdjustmentAdd',
  1 => 'AccountRef',
  2 => 'AccountRef ListID',
  3 => 'AccountRef FullName',
  4 => 'TxnDate',
  5 => 'RefNumber',
  6 => 'CustomerRef ListID',
  7 => 'CustomerRef FullName',
  8 => 'ClassRef ListID',
  9 => 'ClassRef FullName',
  10 => 'Memo',
  11 => 'InventoryAdjustmentAdd',
  12 => 'InventoryAdjustmentLineAdd',
  13 => 'InventoryAdjustmentLineAdd ItemRef',
  14 => 'InventoryAdjustmentLineAdd ItemRef ListID',
  15 => 'InventoryAdjustmentLineAdd ItemRef FullName',
  16 => 'InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity',
  17 => 'InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference',
  18 => 'InventoryAdjustmentLineAdd ValueAdjustment NewQuantity',
  19 => 'InventoryAdjustmentLineAdd ValueAdjustment NewValue',
  20 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>
