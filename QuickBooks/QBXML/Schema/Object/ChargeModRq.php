<?php

/**
 * Schema object for: ChargeModRq
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
class QuickBooks_QBXML_Schema_Object_ChargeModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ChargeMod TxnID' => 'IDTYPE',
  'ChargeMod EditSequence' => 'STRTYPE',
  'ChargeMod CustomerRef ListID' => 'IDTYPE',
  'ChargeMod CustomerRef FullName' => 'STRTYPE',
  'ChargeMod TxnDate' => 'DATETYPE',
  'ChargeMod RefNumber' => 'STRTYPE',
  'ChargeMod ItemRef ListID' => 'IDTYPE',
  'ChargeMod ItemRef FullName' => 'STRTYPE',
  'ChargeMod Quantity' => 'QUANTYPE',
  'ChargeMod UnitOfMeasure' => 'STRTYPE',
  'ChargeMod OverrideUOMSetRef ListID' => 'IDTYPE',
  'ChargeMod OverrideUOMSetRef FullName' => 'STRTYPE',
  'ChargeMod Rate' => 'PRICETYPE',
  'ChargeMod Amount' => 'AMTTYPE',
  'ChargeMod Desc' => 'STRTYPE',
  'ChargeMod ARAccountRef ListID' => 'IDTYPE',
  'ChargeMod ARAccountRef FullName' => 'STRTYPE',
  'ChargeMod ClassRef ListID' => 'IDTYPE',
  'ChargeMod ClassRef FullName' => 'STRTYPE',
  'ChargeMod BilledDate' => 'DATETYPE',
  'ChargeMod DueDate' => 'DATETYPE',
  'ChargeMod OverrideItemAccountRef ListID' => 'IDTYPE',
  'ChargeMod OverrideItemAccountRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ChargeMod TxnID' => 0,
  'ChargeMod EditSequence' => 16,
  'ChargeMod CustomerRef ListID' => 0,
  'ChargeMod CustomerRef FullName' => 209,
  'ChargeMod TxnDate' => 0,
  'ChargeMod RefNumber' => 11,
  'ChargeMod ItemRef ListID' => 0,
  'ChargeMod ItemRef FullName' => 209,
  'ChargeMod Quantity' => 0,
  'ChargeMod UnitOfMeasure' => 31,
  'ChargeMod OverrideUOMSetRef ListID' => 0,
  'ChargeMod OverrideUOMSetRef FullName' => 209,
  'ChargeMod Rate' => 0,
  'ChargeMod Amount' => 0,
  'ChargeMod Desc' => 4095,
  'ChargeMod ARAccountRef ListID' => 0,
  'ChargeMod ARAccountRef FullName' => 209,
  'ChargeMod ClassRef ListID' => 0,
  'ChargeMod ClassRef FullName' => 209,
  'ChargeMod BilledDate' => 0,
  'ChargeMod DueDate' => 0,
  'ChargeMod OverrideItemAccountRef ListID' => 0,
  'ChargeMod OverrideItemAccountRef FullName' => 209,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ChargeMod TxnID' => false,
  'ChargeMod EditSequence' => false,
  'ChargeMod CustomerRef ListID' => true,
  'ChargeMod CustomerRef FullName' => true,
  'ChargeMod TxnDate' => true,
  'ChargeMod RefNumber' => true,
  'ChargeMod ItemRef ListID' => true,
  'ChargeMod ItemRef FullName' => true,
  'ChargeMod Quantity' => true,
  'ChargeMod UnitOfMeasure' => true,
  'ChargeMod OverrideUOMSetRef ListID' => true,
  'ChargeMod OverrideUOMSetRef FullName' => true,
  'ChargeMod Rate' => true,
  'ChargeMod Amount' => true,
  'ChargeMod Desc' => true,
  'ChargeMod ARAccountRef ListID' => true,
  'ChargeMod ARAccountRef FullName' => true,
  'ChargeMod ClassRef ListID' => true,
  'ChargeMod ClassRef FullName' => true,
  'ChargeMod BilledDate' => true,
  'ChargeMod DueDate' => true,
  'ChargeMod OverrideItemAccountRef ListID' => true,
  'ChargeMod OverrideItemAccountRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ChargeMod TxnID' => 999.99,
  'ChargeMod EditSequence' => 999.99,
  'ChargeMod CustomerRef ListID' => 999.99,
  'ChargeMod CustomerRef FullName' => 999.99,
  'ChargeMod TxnDate' => 999.99,
  'ChargeMod RefNumber' => 999.99,
  'ChargeMod ItemRef ListID' => 999.99,
  'ChargeMod ItemRef FullName' => 999.99,
  'ChargeMod Quantity' => 999.99,
  'ChargeMod UnitOfMeasure' => 7,
  'ChargeMod OverrideUOMSetRef ListID' => 999.99,
  'ChargeMod OverrideUOMSetRef FullName' => 999.99,
  'ChargeMod Rate' => 999.99,
  'ChargeMod Amount' => 999.99,
  'ChargeMod Desc' => 999.99,
  'ChargeMod ARAccountRef ListID' => 999.99,
  'ChargeMod ARAccountRef FullName' => 999.99,
  'ChargeMod ClassRef ListID' => 999.99,
  'ChargeMod ClassRef FullName' => 999.99,
  'ChargeMod BilledDate' => 999.99,
  'ChargeMod DueDate' => 999.99,
  'ChargeMod OverrideItemAccountRef ListID' => 999.99,
  'ChargeMod OverrideItemAccountRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ChargeMod TxnID' => false,
  'ChargeMod EditSequence' => false,
  'ChargeMod CustomerRef ListID' => false,
  'ChargeMod CustomerRef FullName' => false,
  'ChargeMod TxnDate' => false,
  'ChargeMod RefNumber' => false,
  'ChargeMod ItemRef ListID' => false,
  'ChargeMod ItemRef FullName' => false,
  'ChargeMod Quantity' => false,
  'ChargeMod UnitOfMeasure' => false,
  'ChargeMod OverrideUOMSetRef ListID' => false,
  'ChargeMod OverrideUOMSetRef FullName' => false,
  'ChargeMod Rate' => false,
  'ChargeMod Amount' => false,
  'ChargeMod Desc' => false,
  'ChargeMod ARAccountRef ListID' => false,
  'ChargeMod ARAccountRef FullName' => false,
  'ChargeMod ClassRef ListID' => false,
  'ChargeMod ClassRef FullName' => false,
  'ChargeMod BilledDate' => false,
  'ChargeMod DueDate' => false,
  'ChargeMod OverrideItemAccountRef ListID' => false,
  'ChargeMod OverrideItemAccountRef FullName' => false,
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
  0 => 'ChargeMod TxnID',
  1 => 'ChargeMod EditSequence',
  2 => 'ChargeMod CustomerRef ListID',
  3 => 'ChargeMod CustomerRef FullName',
  4 => 'ChargeMod TxnDate',
  5 => 'ChargeMod RefNumber',
  6 => 'ChargeMod ItemRef ListID',
  7 => 'ChargeMod ItemRef FullName',
  8 => 'ChargeMod Quantity',
  9 => 'ChargeMod UnitOfMeasure',
  10 => 'ChargeMod OverrideUOMSetRef ListID',
  11 => 'ChargeMod OverrideUOMSetRef FullName',
  12 => 'ChargeMod Rate',
  13 => 'ChargeMod Amount',
  14 => 'ChargeMod Desc',
  15 => 'ChargeMod ARAccountRef ListID',
  16 => 'ChargeMod ARAccountRef FullName',
  17 => 'ChargeMod ClassRef ListID',
  18 => 'ChargeMod ClassRef FullName',
  19 => 'ChargeMod BilledDate',
  20 => 'ChargeMod DueDate',
  21 => 'ChargeMod OverrideItemAccountRef ListID',
  22 => 'ChargeMod OverrideItemAccountRef FullName',
  23 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>