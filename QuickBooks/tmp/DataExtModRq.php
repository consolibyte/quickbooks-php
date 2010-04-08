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
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'DataExtMod OwnerID' => 'GUIDTYPE',
  'DataExtMod DataExtName' => 'STRTYPE',
  'DataExtMod ListDataExtType' => 'ENUMTYPE',
  'DataExtMod ListObjRef ListID' => 'IDTYPE',
  'DataExtMod ListObjRef FullName' => 'STRTYPE',
  'DataExtMod TxnDataExtType' => 'ENUMTYPE',
  'DataExtMod TxnID' => 'IDTYPE',
  'DataExtMod TxnLineID' => 'IDTYPE',
  'DataExtMod OtherDataExtType' => 'ENUMTYPE',
  'DataExtMod DataExtValue' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'DataExtMod OwnerID' => 0,
  'DataExtMod DataExtName' => 31,
  'DataExtMod ListDataExtType' => 0,
  'DataExtMod ListObjRef ListID' => 0,
  'DataExtMod ListObjRef FullName' => 159,
  'DataExtMod TxnDataExtType' => 0,
  'DataExtMod TxnID' => 0,
  'DataExtMod TxnLineID' => 0,
  'DataExtMod OtherDataExtType' => 0,
  'DataExtMod DataExtValue' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'DataExtMod OwnerID' => false,
  'DataExtMod DataExtName' => false,
  'DataExtMod ListDataExtType' => false,
  'DataExtMod ListObjRef ListID' => true,
  'DataExtMod ListObjRef FullName' => true,
  'DataExtMod TxnDataExtType' => false,
  'DataExtMod TxnID' => false,
  'DataExtMod TxnLineID' => true,
  'DataExtMod OtherDataExtType' => false,
  'DataExtMod DataExtValue' => false,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'DataExtMod OwnerID' => 999.99,
  'DataExtMod DataExtName' => 999.99,
  'DataExtMod ListDataExtType' => 999.99,
  'DataExtMod ListObjRef ListID' => 999.99,
  'DataExtMod ListObjRef FullName' => 999.99,
  'DataExtMod TxnDataExtType' => 999.99,
  'DataExtMod TxnID' => 999.99,
  'DataExtMod TxnLineID' => 3,
  'DataExtMod OtherDataExtType' => 999.99,
  'DataExtMod DataExtValue' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'DataExtMod OwnerID' => false,
  'DataExtMod DataExtName' => false,
  'DataExtMod ListDataExtType' => false,
  'DataExtMod ListObjRef ListID' => false,
  'DataExtMod ListObjRef FullName' => false,
  'DataExtMod TxnDataExtType' => false,
  'DataExtMod TxnID' => false,
  'DataExtMod TxnLineID' => false,
  'DataExtMod OtherDataExtType' => false,
  'DataExtMod DataExtValue' => false,
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
  0 => 'DataExtMod OwnerID',
  1 => 'DataExtMod DataExtName',
  2 => 'DataExtMod ListDataExtType',
  3 => 'DataExtMod ListObjRef ListID',
  4 => 'DataExtMod ListObjRef FullName',
  5 => 'DataExtMod TxnDataExtType',
  6 => 'DataExtMod TxnID',
  7 => 'DataExtMod TxnLineID',
  8 => 'DataExtMod OtherDataExtType',
  9 => 'DataExtMod DataExtValue',
);
			
		return $paths;
	}
}

?>