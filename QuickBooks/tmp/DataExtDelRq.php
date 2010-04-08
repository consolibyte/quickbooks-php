<?php

/**
 * Schema object for: DataExtDelRq
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
class QuickBooks_QBXML_Schema_Object_DataExtDelRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'DataExtDel OwnerID' => 'GUIDTYPE',
  'DataExtDel DataExtName' => 'STRTYPE',
  'DataExtDel ListDataExtType' => 'ENUMTYPE',
  'DataExtDel ListObjRef ListID' => 'IDTYPE',
  'DataExtDel ListObjRef FullName' => 'STRTYPE',
  'DataExtDel TxnDataExtType' => 'ENUMTYPE',
  'DataExtDel TxnID' => 'IDTYPE',
  'DataExtDel TxnLineID' => 'IDTYPE',
  'DataExtDel OtherDataExtType' => 'ENUMTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'DataExtDel OwnerID' => 0,
  'DataExtDel DataExtName' => 31,
  'DataExtDel ListDataExtType' => 0,
  'DataExtDel ListObjRef ListID' => 0,
  'DataExtDel ListObjRef FullName' => 159,
  'DataExtDel TxnDataExtType' => 0,
  'DataExtDel TxnID' => 0,
  'DataExtDel TxnLineID' => 0,
  'DataExtDel OtherDataExtType' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'DataExtDel OwnerID' => false,
  'DataExtDel DataExtName' => false,
  'DataExtDel ListDataExtType' => false,
  'DataExtDel ListObjRef ListID' => true,
  'DataExtDel ListObjRef FullName' => true,
  'DataExtDel TxnDataExtType' => false,
  'DataExtDel TxnID' => false,
  'DataExtDel TxnLineID' => true,
  'DataExtDel OtherDataExtType' => false,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'DataExtDel OwnerID' => 999.99,
  'DataExtDel DataExtName' => 999.99,
  'DataExtDel ListDataExtType' => 999.99,
  'DataExtDel ListObjRef ListID' => 999.99,
  'DataExtDel ListObjRef FullName' => 999.99,
  'DataExtDel TxnDataExtType' => 999.99,
  'DataExtDel TxnID' => 999.99,
  'DataExtDel TxnLineID' => 3,
  'DataExtDel OtherDataExtType' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'DataExtDel OwnerID' => false,
  'DataExtDel DataExtName' => false,
  'DataExtDel ListDataExtType' => false,
  'DataExtDel ListObjRef ListID' => false,
  'DataExtDel ListObjRef FullName' => false,
  'DataExtDel TxnDataExtType' => false,
  'DataExtDel TxnID' => false,
  'DataExtDel TxnLineID' => false,
  'DataExtDel OtherDataExtType' => false,
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
  0 => 'DataExtDel OwnerID',
  1 => 'DataExtDel DataExtName',
  2 => 'DataExtDel ListDataExtType',
  3 => 'DataExtDel ListObjRef ListID',
  4 => 'DataExtDel ListObjRef FullName',
  5 => 'DataExtDel TxnDataExtType',
  6 => 'DataExtDel TxnID',
  7 => 'DataExtDel TxnLineID',
  8 => 'DataExtDel OtherDataExtType',
);
			
		return $paths;
	}
}

?>