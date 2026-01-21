<?php

/**
 * Schema object for: ChargeAddRq
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
class QuickBooks_QBXML_Schema_Object_ChargeAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ChargeAdd CustomerRef ListID' => 'IDTYPE',
  'ChargeAdd CustomerRef FullName' => 'STRTYPE',
  'ChargeAdd TxnDate' => 'DATETYPE',
  'ChargeAdd RefNumber' => 'STRTYPE',
  'ChargeAdd ItemRef ListID' => 'IDTYPE',
  'ChargeAdd ItemRef FullName' => 'STRTYPE',
  'ChargeAdd Quantity' => 'QUANTYPE',
  'ChargeAdd UnitOfMeasure' => 'STRTYPE',
  'ChargeAdd Rate' => 'PRICETYPE',
  'ChargeAdd Amount' => 'AMTTYPE',
  'ChargeAdd Desc' => 'STRTYPE',
  'ChargeAdd ARAccountRef ListID' => 'IDTYPE',
  'ChargeAdd ARAccountRef FullName' => 'STRTYPE',
  'ChargeAdd ClassRef ListID' => 'IDTYPE',
  'ChargeAdd ClassRef FullName' => 'STRTYPE',
  'ChargeAdd BilledDate' => 'DATETYPE',
  'ChargeAdd DueDate' => 'DATETYPE',
  'ChargeAdd OverrideItemAccountRef ListID' => 'IDTYPE',
  'ChargeAdd OverrideItemAccountRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ChargeAdd CustomerRef ListID' => 0,
  'ChargeAdd CustomerRef FullName' => 209,
  'ChargeAdd TxnDate' => 0,
  'ChargeAdd RefNumber' => 11,
  'ChargeAdd ItemRef ListID' => 0,
  'ChargeAdd ItemRef FullName' => 209,
  'ChargeAdd Quantity' => 0,
  'ChargeAdd UnitOfMeasure' => 31,
  'ChargeAdd Rate' => 0,
  'ChargeAdd Amount' => 0,
  'ChargeAdd Desc' => 4095,
  'ChargeAdd ARAccountRef ListID' => 0,
  'ChargeAdd ARAccountRef FullName' => 209,
  'ChargeAdd ClassRef ListID' => 0,
  'ChargeAdd ClassRef FullName' => 209,
  'ChargeAdd BilledDate' => 0,
  'ChargeAdd DueDate' => 0,
  'ChargeAdd OverrideItemAccountRef ListID' => 0,
  'ChargeAdd OverrideItemAccountRef FullName' => 209,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ChargeAdd CustomerRef ListID' => true,
  'ChargeAdd CustomerRef FullName' => true,
  'ChargeAdd TxnDate' => true,
  'ChargeAdd RefNumber' => true,
  'ChargeAdd ItemRef ListID' => true,
  'ChargeAdd ItemRef FullName' => true,
  'ChargeAdd Quantity' => true,
  'ChargeAdd UnitOfMeasure' => true,
  'ChargeAdd Rate' => true,
  'ChargeAdd Amount' => true,
  'ChargeAdd Desc' => true,
  'ChargeAdd ARAccountRef ListID' => true,
  'ChargeAdd ARAccountRef FullName' => true,
  'ChargeAdd ClassRef ListID' => true,
  'ChargeAdd ClassRef FullName' => true,
  'ChargeAdd BilledDate' => true,
  'ChargeAdd DueDate' => true,
  'ChargeAdd OverrideItemAccountRef ListID' => true,
  'ChargeAdd OverrideItemAccountRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ChargeAdd CustomerRef ListID' => 999.99,
  'ChargeAdd CustomerRef FullName' => 999.99,
  'ChargeAdd TxnDate' => 999.99,
  'ChargeAdd RefNumber' => 999.99,
  'ChargeAdd ItemRef ListID' => 999.99,
  'ChargeAdd ItemRef FullName' => 999.99,
  'ChargeAdd Quantity' => 999.99,
  'ChargeAdd UnitOfMeasure' => 7,
  'ChargeAdd Rate' => 999.99,
  'ChargeAdd Amount' => 999.99,
  'ChargeAdd Desc' => 999.99,
  'ChargeAdd ARAccountRef ListID' => 999.99,
  'ChargeAdd ARAccountRef FullName' => 999.99,
  'ChargeAdd ClassRef ListID' => 999.99,
  'ChargeAdd ClassRef FullName' => 999.99,
  'ChargeAdd BilledDate' => 999.99,
  'ChargeAdd DueDate' => 999.99,
  'ChargeAdd OverrideItemAccountRef ListID' => 999.99,
  'ChargeAdd OverrideItemAccountRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ChargeAdd CustomerRef ListID' => false,
  'ChargeAdd CustomerRef FullName' => false,
  'ChargeAdd TxnDate' => false,
  'ChargeAdd RefNumber' => false,
  'ChargeAdd ItemRef ListID' => false,
  'ChargeAdd ItemRef FullName' => false,
  'ChargeAdd Quantity' => false,
  'ChargeAdd UnitOfMeasure' => false,
  'ChargeAdd Rate' => false,
  'ChargeAdd Amount' => false,
  'ChargeAdd Desc' => false,
  'ChargeAdd ARAccountRef ListID' => false,
  'ChargeAdd ARAccountRef FullName' => false,
  'ChargeAdd ClassRef ListID' => false,
  'ChargeAdd ClassRef FullName' => false,
  'ChargeAdd BilledDate' => false,
  'ChargeAdd DueDate' => false,
  'ChargeAdd OverrideItemAccountRef ListID' => false,
  'ChargeAdd OverrideItemAccountRef FullName' => false,
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
  0 => 'ChargeAdd',
  1 => 'ChargeAdd CustomerRef',
  2 => 'ChargeAdd CustomerRef ListID',
  3 => 'ChargeAdd CustomerRef FullName',
  4 => 'ChargeAdd TxnDate',
  5 => 'ChargeAdd RefNumber',
  6 => 'ChargeAdd ItemRef ListID',
  7 => 'ChargeAdd ItemRef FullName',
  8 => 'ChargeAdd Quantity',
  9 => 'ChargeAdd UnitOfMeasure',
  10 => 'ChargeAdd Rate',
  11 => 'ChargeAdd Amount',
  12 => 'ChargeAdd Desc',
  13 => 'ChargeAdd ARAccountRef ListID',
  14 => 'ChargeAdd ARAccountRef FullName',
  15 => 'ChargeAdd ClassRef ListID',
  16 => 'ChargeAdd ClassRef FullName',
  17 => 'ChargeAdd BilledDate',
  18 => 'ChargeAdd DueDate',
  19 => 'ChargeAdd OverrideItemAccountRef ListID',
  20 => 'ChargeAdd OverrideItemAccountRef FullName',
  21 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>