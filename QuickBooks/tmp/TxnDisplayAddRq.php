<?php

/**
 * Schema object for: TxnDisplayAddRq
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
class QuickBooks_QBXML_Schema_Object_TxnDisplayAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'TxnDisplayAddType' => 'ENUMTYPE',
  'EntityRef ListID' => 'IDTYPE',
  'EntityRef FullName' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'TxnDisplayAddType' => 0,
  'EntityRef ListID' => 0,
  'EntityRef FullName' => 209,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'TxnDisplayAddType' => false,
  'EntityRef ListID' => true,
  'EntityRef FullName' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'TxnDisplayAddType' => 999.99,
  'EntityRef ListID' => 999.99,
  'EntityRef FullName' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'TxnDisplayAddType' => false,
  'EntityRef ListID' => false,
  'EntityRef FullName' => false,
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
  0 => 'TxnDisplayAddType',
  1 => 'EntityRef ListID',
  2 => 'EntityRef FullName',
);
			
		return $paths;
	}
}

?>