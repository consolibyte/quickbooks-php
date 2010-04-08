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
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'InventoryAdjustmentAdd AccountRef ListID' => 'IDTYPE',
  'InventoryAdjustmentAdd AccountRef FullName' => 'STRTYPE',
  'InventoryAdjustmentAdd TxnDate' => 'DATETYPE',
  'InventoryAdjustmentAdd RefNumber' => 'STRTYPE',
  'InventoryAdjustmentAdd CustomerRef ListID' => 'IDTYPE',
  'InventoryAdjustmentAdd CustomerRef FullName' => 'STRTYPE',
  'InventoryAdjustmentAdd ClassRef ListID' => 'IDTYPE',
  'InventoryAdjustmentAdd ClassRef FullName' => 'STRTYPE',
  'InventoryAdjustmentAdd Memo' => 'STRTYPE',
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef ListID' => 'IDTYPE',
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef FullName' => 'STRTYPE',
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => 'QUANTYPE',
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => 'QUANTYPE',
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => 'QUANTYPE',
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewValue' => 'AMTTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'InventoryAdjustmentAdd AccountRef ListID' => 0,
  'InventoryAdjustmentAdd AccountRef FullName' => 159,
  'InventoryAdjustmentAdd TxnDate' => 0,
  'InventoryAdjustmentAdd RefNumber' => 11,
  'InventoryAdjustmentAdd CustomerRef ListID' => 0,
  'InventoryAdjustmentAdd CustomerRef FullName' => 159,
  'InventoryAdjustmentAdd ClassRef ListID' => 0,
  'InventoryAdjustmentAdd ClassRef FullName' => 159,
  'InventoryAdjustmentAdd Memo' => 4095,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef ListID' => 0,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef FullName' => 159,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => 0,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => 0,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => 0,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewValue' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'InventoryAdjustmentAdd AccountRef ListID' => true,
  'InventoryAdjustmentAdd AccountRef FullName' => true,
  'InventoryAdjustmentAdd TxnDate' => true,
  'InventoryAdjustmentAdd RefNumber' => true,
  'InventoryAdjustmentAdd CustomerRef ListID' => true,
  'InventoryAdjustmentAdd CustomerRef FullName' => true,
  'InventoryAdjustmentAdd ClassRef ListID' => true,
  'InventoryAdjustmentAdd ClassRef FullName' => true,
  'InventoryAdjustmentAdd Memo' => true,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef ListID' => true,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef FullName' => true,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => false,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => false,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => false,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewValue' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'InventoryAdjustmentAdd AccountRef ListID' => 999.99,
  'InventoryAdjustmentAdd AccountRef FullName' => 999.99,
  'InventoryAdjustmentAdd TxnDate' => 999.99,
  'InventoryAdjustmentAdd RefNumber' => 999.99,
  'InventoryAdjustmentAdd CustomerRef ListID' => 999.99,
  'InventoryAdjustmentAdd CustomerRef FullName' => 999.99,
  'InventoryAdjustmentAdd ClassRef ListID' => 999.99,
  'InventoryAdjustmentAdd ClassRef FullName' => 999.99,
  'InventoryAdjustmentAdd Memo' => 999.99,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef ListID' => 999.99,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef FullName' => 999.99,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => 999.99,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => 999.99,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => 999.99,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewValue' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'InventoryAdjustmentAdd AccountRef ListID' => false,
  'InventoryAdjustmentAdd AccountRef FullName' => false,
  'InventoryAdjustmentAdd TxnDate' => false,
  'InventoryAdjustmentAdd RefNumber' => false,
  'InventoryAdjustmentAdd CustomerRef ListID' => false,
  'InventoryAdjustmentAdd CustomerRef FullName' => false,
  'InventoryAdjustmentAdd ClassRef ListID' => false,
  'InventoryAdjustmentAdd ClassRef FullName' => false,
  'InventoryAdjustmentAdd Memo' => false,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef ListID' => false,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef FullName' => false,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity' => false,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference' => false,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewQuantity' => false,
  'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewValue' => false,
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
  1 => 'InventoryAdjustmentAdd AccountRef',
  2 => 'InventoryAdjustmentAdd AccountRef ListID',
  3 => 'InventoryAdjustmentAdd AccountRef FullName',
  4 => 'InventoryAdjustmentAdd TxnDate',
  5 => 'InventoryAdjustmentAdd RefNumber',
  6 => 'InventoryAdjustmentAdd CustomerRef ListID',
  7 => 'InventoryAdjustmentAdd CustomerRef FullName',
  8 => 'InventoryAdjustmentAdd ClassRef ListID',
  9 => 'InventoryAdjustmentAdd ClassRef FullName',
  10 => 'InventoryAdjustmentAdd Memo',
  11 => 'InventoryAdjustmentAdd',
  12 => 'InventoryAdjustmentAdd InventoryAdjustmentLineAdd',
  13 => 'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef',
  14 => 'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef ListID',
  15 => 'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ItemRef FullName',
  16 => 'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment NewQuantity',
  17 => 'InventoryAdjustmentAdd InventoryAdjustmentLineAdd QuantityAdjustment QuantityDifference',
  18 => 'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewQuantity',
  19 => 'InventoryAdjustmentAdd InventoryAdjustmentLineAdd ValueAdjustment NewValue',
  20 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>