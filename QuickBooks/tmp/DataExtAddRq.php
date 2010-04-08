<?php

/**
 * Schema object for: DataExtAddRq
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
class QuickBooks_QBXML_Schema_Object_DataExtAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'DataExtAdd OwnerID' => 'GUIDTYPE',
  'DataExtAdd DataExtName' => 'STRTYPE',
  'DataExtAdd ListDataExtType' => 'ENUMTYPE',
  'DataExtAdd ListObjRef ListID' => 'IDTYPE',
  'DataExtAdd ListObjRef FullName' => 'STRTYPE',
  'DataExtAdd TxnDataExtType' => 'ENUMTYPE',
  'DataExtAdd TxnID' => 'IDTYPE',
  'DataExtAdd TxnLineID' => 'IDTYPE',
  'DataExtAdd OtherDataExtType' => 'ENUMTYPE',
  'DataExtAdd DataExtValue' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'DataExtAdd OwnerID' => 0,
  'DataExtAdd DataExtName' => 31,
  'DataExtAdd ListDataExtType' => 0,
  'DataExtAdd ListObjRef ListID' => 0,
  'DataExtAdd ListObjRef FullName' => 159,
  'DataExtAdd TxnDataExtType' => 0,
  'DataExtAdd TxnID' => 0,
  'DataExtAdd TxnLineID' => 0,
  'DataExtAdd OtherDataExtType' => 0,
  'DataExtAdd DataExtValue' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'DataExtAdd OwnerID' => false,
  'DataExtAdd DataExtName' => false,
  'DataExtAdd ListDataExtType' => false,
  'DataExtAdd ListObjRef ListID' => true,
  'DataExtAdd ListObjRef FullName' => true,
  'DataExtAdd TxnDataExtType' => false,
  'DataExtAdd TxnID' => false,
  'DataExtAdd TxnLineID' => true,
  'DataExtAdd OtherDataExtType' => false,
  'DataExtAdd DataExtValue' => false,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'DataExtAdd OwnerID' => 999.99,
  'DataExtAdd DataExtName' => 999.99,
  'DataExtAdd ListDataExtType' => 999.99,
  'DataExtAdd ListObjRef ListID' => 999.99,
  'DataExtAdd ListObjRef FullName' => 999.99,
  'DataExtAdd TxnDataExtType' => 999.99,
  'DataExtAdd TxnID' => 0,
  'DataExtAdd TxnLineID' => 3,
  'DataExtAdd OtherDataExtType' => 999.99,
  'DataExtAdd DataExtValue' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'DataExtAdd OwnerID' => false,
  'DataExtAdd DataExtName' => false,
  'DataExtAdd ListDataExtType' => false,
  'DataExtAdd ListObjRef ListID' => false,
  'DataExtAdd ListObjRef FullName' => false,
  'DataExtAdd TxnDataExtType' => false,
  'DataExtAdd TxnID' => false,
  'DataExtAdd TxnLineID' => false,
  'DataExtAdd OtherDataExtType' => false,
  'DataExtAdd DataExtValue' => false,
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
  0 => 'DataExtAdd OwnerID',
  1 => 'DataExtAdd DataExtName',
  2 => 'DataExtAdd ListDataExtType',
  3 => 'DataExtAdd ListObjRef ListID',
  4 => 'DataExtAdd ListObjRef FullName',
  5 => 'DataExtAdd TxnDataExtType',
  6 => 'DataExtAdd TxnID',
  7 => 'DataExtAdd TxnLineID',
  8 => 'DataExtAdd OtherDataExtType',
  9 => 'DataExtAdd DataExtValue',
);
			
		return $paths;
	}
}

?>