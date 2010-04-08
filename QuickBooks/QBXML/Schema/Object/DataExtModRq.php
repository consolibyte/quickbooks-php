<?php

/**
 * Schema object for: DataExtModRq
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
class QuickBooks_QBXML_Schema_Object_DataExtModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'DataExtMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'OwnerID' => 'GUIDTYPE',
  'DataExtName' => 'STRTYPE',
  'ListDataExtType' => 'ENUMTYPE',
  'ListObjRef ListID' => 'IDTYPE',
  'ListObjRef FullName' => 'STRTYPE',
  'TxnDataExtType' => 'ENUMTYPE',
  'TxnID' => 'IDTYPE',
  'TxnLineID' => 'IDTYPE',
  'OtherDataExtType' => 'ENUMTYPE',
  'DataExtValue' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'OwnerID' => 0,
  'DataExtName' => 31,
  'ListDataExtType' => 0,
  'ListObjRef ListID' => 0,
  'ListObjRef FullName' => 159,
  'TxnDataExtType' => 0,
  'TxnID' => 0,
  'TxnLineID' => 0,
  'OtherDataExtType' => 0,
  'DataExtValue' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'OwnerID' => false,
  'DataExtName' => false,
  'ListDataExtType' => false,
  'ListObjRef ListID' => true,
  'ListObjRef FullName' => true,
  'TxnDataExtType' => false,
  'TxnID' => false,
  'TxnLineID' => true,
  'OtherDataExtType' => false,
  'DataExtValue' => false,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'OwnerID' => 999.99,
  'DataExtName' => 999.99,
  'ListDataExtType' => 999.99,
  'ListObjRef ListID' => 999.99,
  'ListObjRef FullName' => 999.99,
  'TxnDataExtType' => 999.99,
  'TxnID' => 999.99,
  'TxnLineID' => 3,
  'OtherDataExtType' => 999.99,
  'DataExtValue' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'OwnerID' => false,
  'DataExtName' => false,
  'ListDataExtType' => false,
  'ListObjRef ListID' => false,
  'ListObjRef FullName' => false,
  'TxnDataExtType' => false,
  'TxnID' => false,
  'TxnLineID' => false,
  'OtherDataExtType' => false,
  'DataExtValue' => false,
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
  0 => 'OwnerID',
  1 => 'DataExtName',
  2 => 'ListDataExtType',
  3 => 'ListObjRef ListID',
  4 => 'ListObjRef FullName',
  5 => 'TxnDataExtType',
  6 => 'TxnID',
  7 => 'TxnLineID',
  8 => 'OtherDataExtType',
  9 => 'DataExtValue',
);
			
		return $paths;
	}
}

?>