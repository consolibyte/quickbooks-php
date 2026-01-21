<?php

/**
 * Schema object for: DataExtDefAddRq
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
class QuickBooks_QBXML_Schema_Object_DataExtDefAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'DataExtDefAdd OwnerID' => 'GUIDTYPE',
  'DataExtDefAdd DataExtName' => 'STRTYPE',
  'DataExtDefAdd DataExtType' => 'ENUMTYPE',
  'DataExtDefAdd AssignToObject' => 'ENUMTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'DataExtDefAdd OwnerID' => 0,
  'DataExtDefAdd DataExtName' => 31,
  'DataExtDefAdd DataExtType' => 0,
  'DataExtDefAdd AssignToObject' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'DataExtDefAdd OwnerID' => false,
  'DataExtDefAdd DataExtName' => false,
  'DataExtDefAdd DataExtType' => false,
  'DataExtDefAdd AssignToObject' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'DataExtDefAdd OwnerID' => 999.99,
  'DataExtDefAdd DataExtName' => 999.99,
  'DataExtDefAdd DataExtType' => 999.99,
  'DataExtDefAdd AssignToObject' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'DataExtDefAdd OwnerID' => false,
  'DataExtDefAdd DataExtName' => false,
  'DataExtDefAdd DataExtType' => false,
  'DataExtDefAdd AssignToObject' => true,
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
  0 => 'DataExtDefAdd OwnerID',
  1 => 'DataExtDefAdd DataExtName',
  2 => 'DataExtDefAdd DataExtType',
  3 => 'DataExtDefAdd AssignToObject',
  4 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>