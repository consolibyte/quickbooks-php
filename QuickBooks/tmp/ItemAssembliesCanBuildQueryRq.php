<?php

/**
 * Schema object for: ItemAssembliesCanBuildQueryRq
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
class QuickBooks_QBXML_Schema_Object_ItemAssembliesCanBuildQueryRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRef ListID' => 'IDTYPE',
  'ItemInventoryAssemblyRef FullName' => 'STRTYPE',
  'TxnDate' => 'DATETYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRef ListID' => 0,
  'ItemInventoryAssemblyRef FullName' => 159,
  'TxnDate' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRef ListID' => true,
  'ItemInventoryAssemblyRef FullName' => true,
  'TxnDate' => false,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRef ListID' => 999.99,
  'ItemInventoryAssemblyRef FullName' => 999.99,
  'TxnDate' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ItemInventoryAssemblyRef ListID' => false,
  'ItemInventoryAssemblyRef FullName' => false,
  'TxnDate' => false,
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
  0 => 'ItemInventoryAssemblyRef ListID',
  1 => 'ItemInventoryAssemblyRef FullName',
  2 => 'TxnDate',
);
			
		return $paths;
	}
}

?>