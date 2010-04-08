<?php

/**
 * Schema object for: DataExtDefModRq
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
class QuickBooks_QBXML_Schema_Object_DataExtDefModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'DataExtDefMod OwnerID' => 'GUIDTYPE',
  'DataExtDefMod DataExtName' => 'STRTYPE',
  'DataExtDefMod DataExtNewName' => 'STRTYPE',
  'DataExtDefMod AssignToObject' => 'ENUMTYPE',
  'DataExtDefMod RemoveFromObject' => 'ENUMTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'DataExtDefMod OwnerID' => 0,
  'DataExtDefMod DataExtName' => 31,
  'DataExtDefMod DataExtNewName' => 31,
  'DataExtDefMod AssignToObject' => 0,
  'DataExtDefMod RemoveFromObject' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'DataExtDefMod OwnerID' => false,
  'DataExtDefMod DataExtName' => false,
  'DataExtDefMod DataExtNewName' => true,
  'DataExtDefMod AssignToObject' => true,
  'DataExtDefMod RemoveFromObject' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'DataExtDefMod OwnerID' => 999.99,
  'DataExtDefMod DataExtName' => 999.99,
  'DataExtDefMod DataExtNewName' => 999.99,
  'DataExtDefMod AssignToObject' => 999.99,
  'DataExtDefMod RemoveFromObject' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'DataExtDefMod OwnerID' => false,
  'DataExtDefMod DataExtName' => false,
  'DataExtDefMod DataExtNewName' => false,
  'DataExtDefMod AssignToObject' => true,
  'DataExtDefMod RemoveFromObject' => true,
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
  0 => 'DataExtDefMod OwnerID',
  1 => 'DataExtDefMod DataExtName',
  2 => 'DataExtDefMod DataExtNewName',
  3 => 'DataExtDefMod AssignToObject',
  4 => 'DataExtDefMod RemoveFromObject',
  5 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>