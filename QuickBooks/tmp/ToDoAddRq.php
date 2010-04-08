<?php

/**
 * Schema object for: ToDoAddRq
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
class QuickBooks_QBXML_Schema_Object_ToDoAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ToDoAdd Notes' => 'STRTYPE',
  'ToDoAdd IsActive' => 'BOOLTYPE',
  'ToDoAdd IsDone' => 'BOOLTYPE',
  'ToDoAdd ReminderDate' => 'DATETYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ToDoAdd Notes' => 4095,
  'ToDoAdd IsActive' => 0,
  'ToDoAdd IsDone' => 0,
  'ToDoAdd ReminderDate' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ToDoAdd Notes' => false,
  'ToDoAdd IsActive' => true,
  'ToDoAdd IsDone' => true,
  'ToDoAdd ReminderDate' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ToDoAdd Notes' => 999.99,
  'ToDoAdd IsActive' => 999.99,
  'ToDoAdd IsDone' => 999.99,
  'ToDoAdd ReminderDate' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ToDoAdd Notes' => false,
  'ToDoAdd IsActive' => false,
  'ToDoAdd IsDone' => false,
  'ToDoAdd ReminderDate' => false,
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
  0 => 'ToDoAdd Notes',
  1 => 'ToDoAdd IsActive',
  2 => 'ToDoAdd IsDone',
  3 => 'ToDoAdd ReminderDate',
  4 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>