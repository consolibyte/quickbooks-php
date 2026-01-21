<?php

/**
 * Schema object for: BuildAssemblyAddRq
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
class QuickBooks_QBXML_Schema_Object_BuildAssemblyAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'BuildAssemblyAdd ItemInventoryAssemblyRef ListID' => 'IDTYPE',
  'BuildAssemblyAdd ItemInventoryAssemblyRef FullName' => 'STRTYPE',
  'BuildAssemblyAdd TxnDate' => 'DATETYPE',
  'BuildAssemblyAdd RefNumber' => 'STRTYPE',
  'BuildAssemblyAdd Memo' => 'STRTYPE',
  'BuildAssemblyAdd QuantityToBuild' => 'QUANTYPE',
  'BuildAssemblyAdd MarkPendingIfRequired' => 'BOOLTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'BuildAssemblyAdd ItemInventoryAssemblyRef ListID' => 0,
  'BuildAssemblyAdd ItemInventoryAssemblyRef FullName' => 159,
  'BuildAssemblyAdd TxnDate' => 0,
  'BuildAssemblyAdd RefNumber' => 11,
  'BuildAssemblyAdd Memo' => 4095,
  'BuildAssemblyAdd QuantityToBuild' => 0,
  'BuildAssemblyAdd MarkPendingIfRequired' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'BuildAssemblyAdd ItemInventoryAssemblyRef ListID' => true,
  'BuildAssemblyAdd ItemInventoryAssemblyRef FullName' => true,
  'BuildAssemblyAdd TxnDate' => true,
  'BuildAssemblyAdd RefNumber' => true,
  'BuildAssemblyAdd Memo' => true,
  'BuildAssemblyAdd QuantityToBuild' => false,
  'BuildAssemblyAdd MarkPendingIfRequired' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'BuildAssemblyAdd ItemInventoryAssemblyRef ListID' => 999.99,
  'BuildAssemblyAdd ItemInventoryAssemblyRef FullName' => 999.99,
  'BuildAssemblyAdd TxnDate' => 999.99,
  'BuildAssemblyAdd RefNumber' => 999.99,
  'BuildAssemblyAdd Memo' => 999.99,
  'BuildAssemblyAdd QuantityToBuild' => 999.99,
  'BuildAssemblyAdd MarkPendingIfRequired' => 7,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'BuildAssemblyAdd ItemInventoryAssemblyRef ListID' => false,
  'BuildAssemblyAdd ItemInventoryAssemblyRef FullName' => false,
  'BuildAssemblyAdd TxnDate' => false,
  'BuildAssemblyAdd RefNumber' => false,
  'BuildAssemblyAdd Memo' => false,
  'BuildAssemblyAdd QuantityToBuild' => false,
  'BuildAssemblyAdd MarkPendingIfRequired' => false,
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
  0 => 'BuildAssemblyAdd',
  1 => 'BuildAssemblyAdd ItemInventoryAssemblyRef',
  2 => 'BuildAssemblyAdd ItemInventoryAssemblyRef ListID',
  3 => 'BuildAssemblyAdd ItemInventoryAssemblyRef FullName',
  4 => 'BuildAssemblyAdd TxnDate',
  5 => 'BuildAssemblyAdd RefNumber',
  6 => 'BuildAssemblyAdd Memo',
  7 => 'BuildAssemblyAdd QuantityToBuild',
  8 => 'BuildAssemblyAdd MarkPendingIfRequired',
  9 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>