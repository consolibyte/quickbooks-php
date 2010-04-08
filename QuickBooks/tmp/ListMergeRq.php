<?php

/**
 * Schema object for: ListMergeRq
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
class QuickBooks_QBXML_Schema_Object_ListMergeRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ListMergeType' => 'ENUMTYPE',
  'MergeFrom ListID' => 'IDTYPE',
  'MergeFrom EditSequence' => 'STRTYPE',
  'MergeTo ListID' => 'IDTYPE',
  'MergeTo EditSequence' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ListMergeType' => 0,
  'MergeFrom ListID' => 0,
  'MergeFrom EditSequence' => 16,
  'MergeTo ListID' => 0,
  'MergeTo EditSequence' => 16,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ListMergeType' => false,
  'MergeFrom ListID' => false,
  'MergeFrom EditSequence' => false,
  'MergeTo ListID' => false,
  'MergeTo EditSequence' => false,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ListMergeType' => 999.99,
  'MergeFrom ListID' => 999.99,
  'MergeFrom EditSequence' => 999.99,
  'MergeTo ListID' => 999.99,
  'MergeTo EditSequence' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ListMergeType' => false,
  'MergeFrom ListID' => false,
  'MergeFrom EditSequence' => false,
  'MergeTo ListID' => false,
  'MergeTo EditSequence' => false,
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
  0 => 'ListMergeType',
  1 => 'MergeFrom ListID',
  2 => 'MergeFrom EditSequence',
  3 => 'MergeTo ListID',
  4 => 'MergeTo EditSequence',
);
			
		return $paths;
	}
}

?>