<?php

/**
 * Schema object for: OtherNameAddRq
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
class QuickBooks_QBXML_Schema_Object_OtherNameAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'OtherNameAdd Name' => 'STRTYPE',
  'OtherNameAdd IsActive' => 'BOOLTYPE',
  'OtherNameAdd CompanyName' => 'STRTYPE',
  'OtherNameAdd Salutation' => 'STRTYPE',
  'OtherNameAdd FirstName' => 'STRTYPE',
  'OtherNameAdd MiddleName' => 'STRTYPE',
  'OtherNameAdd LastName' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress Addr1' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress Addr2' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress Addr3' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress Addr4' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress Addr5' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress City' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress State' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress PostalCode' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress Country' => 'STRTYPE',
  'OtherNameAdd OtherNameAddress Note' => 'STRTYPE',
  'OtherNameAdd Phone' => 'STRTYPE',
  'OtherNameAdd AltPhone' => 'STRTYPE',
  'OtherNameAdd Fax' => 'STRTYPE',
  'OtherNameAdd Email' => 'STRTYPE',
  'OtherNameAdd Contact' => 'STRTYPE',
  'OtherNameAdd AltContact' => 'STRTYPE',
  'OtherNameAdd AccountNumber' => 'STRTYPE',
  'OtherNameAdd Notes' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'OtherNameAdd Name' => 41,
  'OtherNameAdd IsActive' => 0,
  'OtherNameAdd CompanyName' => 41,
  'OtherNameAdd Salutation' => 15,
  'OtherNameAdd FirstName' => 25,
  'OtherNameAdd MiddleName' => 5,
  'OtherNameAdd LastName' => 25,
  'OtherNameAdd OtherNameAddress Addr1' => 41,
  'OtherNameAdd OtherNameAddress Addr2' => 41,
  'OtherNameAdd OtherNameAddress Addr3' => 41,
  'OtherNameAdd OtherNameAddress Addr4' => 41,
  'OtherNameAdd OtherNameAddress Addr5' => 41,
  'OtherNameAdd OtherNameAddress City' => 31,
  'OtherNameAdd OtherNameAddress State' => 21,
  'OtherNameAdd OtherNameAddress PostalCode' => 13,
  'OtherNameAdd OtherNameAddress Country' => 31,
  'OtherNameAdd OtherNameAddress Note' => 41,
  'OtherNameAdd Phone' => 21,
  'OtherNameAdd AltPhone' => 21,
  'OtherNameAdd Fax' => 21,
  'OtherNameAdd Email' => 1023,
  'OtherNameAdd Contact' => 41,
  'OtherNameAdd AltContact' => 41,
  'OtherNameAdd AccountNumber' => 99,
  'OtherNameAdd Notes' => 4095,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'OtherNameAdd Name' => false,
  'OtherNameAdd IsActive' => true,
  'OtherNameAdd CompanyName' => true,
  'OtherNameAdd Salutation' => true,
  'OtherNameAdd FirstName' => true,
  'OtherNameAdd MiddleName' => true,
  'OtherNameAdd LastName' => true,
  'OtherNameAdd OtherNameAddress Addr1' => true,
  'OtherNameAdd OtherNameAddress Addr2' => true,
  'OtherNameAdd OtherNameAddress Addr3' => true,
  'OtherNameAdd OtherNameAddress Addr4' => true,
  'OtherNameAdd OtherNameAddress Addr5' => true,
  'OtherNameAdd OtherNameAddress City' => true,
  'OtherNameAdd OtherNameAddress State' => true,
  'OtherNameAdd OtherNameAddress PostalCode' => true,
  'OtherNameAdd OtherNameAddress Country' => true,
  'OtherNameAdd OtherNameAddress Note' => true,
  'OtherNameAdd Phone' => true,
  'OtherNameAdd AltPhone' => true,
  'OtherNameAdd Fax' => true,
  'OtherNameAdd Email' => true,
  'OtherNameAdd Contact' => true,
  'OtherNameAdd AltContact' => true,
  'OtherNameAdd AccountNumber' => true,
  'OtherNameAdd Notes' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'OtherNameAdd Name' => 999.99,
  'OtherNameAdd IsActive' => 999.99,
  'OtherNameAdd CompanyName' => 999.99,
  'OtherNameAdd Salutation' => 999.99,
  'OtherNameAdd FirstName' => 999.99,
  'OtherNameAdd MiddleName' => 999.99,
  'OtherNameAdd LastName' => 999.99,
  'OtherNameAdd OtherNameAddress Addr1' => 999.99,
  'OtherNameAdd OtherNameAddress Addr2' => 999.99,
  'OtherNameAdd OtherNameAddress Addr3' => 999.99,
  'OtherNameAdd OtherNameAddress Addr4' => 2,
  'OtherNameAdd OtherNameAddress Addr5' => 6,
  'OtherNameAdd OtherNameAddress City' => 999.99,
  'OtherNameAdd OtherNameAddress State' => 999.99,
  'OtherNameAdd OtherNameAddress PostalCode' => 999.99,
  'OtherNameAdd OtherNameAddress Country' => 999.99,
  'OtherNameAdd OtherNameAddress Note' => 6,
  'OtherNameAdd Phone' => 999.99,
  'OtherNameAdd AltPhone' => 999.99,
  'OtherNameAdd Fax' => 999.99,
  'OtherNameAdd Email' => 999.99,
  'OtherNameAdd Contact' => 999.99,
  'OtherNameAdd AltContact' => 999.99,
  'OtherNameAdd AccountNumber' => 999.99,
  'OtherNameAdd Notes' => 3,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'OtherNameAdd Name' => false,
  'OtherNameAdd IsActive' => false,
  'OtherNameAdd CompanyName' => false,
  'OtherNameAdd Salutation' => false,
  'OtherNameAdd FirstName' => false,
  'OtherNameAdd MiddleName' => false,
  'OtherNameAdd LastName' => false,
  'OtherNameAdd OtherNameAddress Addr1' => false,
  'OtherNameAdd OtherNameAddress Addr2' => false,
  'OtherNameAdd OtherNameAddress Addr3' => false,
  'OtherNameAdd OtherNameAddress Addr4' => false,
  'OtherNameAdd OtherNameAddress Addr5' => false,
  'OtherNameAdd OtherNameAddress City' => false,
  'OtherNameAdd OtherNameAddress State' => false,
  'OtherNameAdd OtherNameAddress PostalCode' => false,
  'OtherNameAdd OtherNameAddress Country' => false,
  'OtherNameAdd OtherNameAddress Note' => false,
  'OtherNameAdd Phone' => false,
  'OtherNameAdd AltPhone' => false,
  'OtherNameAdd Fax' => false,
  'OtherNameAdd Email' => false,
  'OtherNameAdd Contact' => false,
  'OtherNameAdd AltContact' => false,
  'OtherNameAdd AccountNumber' => false,
  'OtherNameAdd Notes' => false,
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
  0 => 'OtherNameAdd Name',
  1 => 'OtherNameAdd IsActive',
  2 => 'OtherNameAdd CompanyName',
  3 => 'OtherNameAdd Salutation',
  4 => 'OtherNameAdd FirstName',
  5 => 'OtherNameAdd MiddleName',
  6 => 'OtherNameAdd LastName',
  7 => 'OtherNameAdd OtherNameAddress Addr1',
  8 => 'OtherNameAdd OtherNameAddress Addr2',
  9 => 'OtherNameAdd OtherNameAddress Addr3',
  10 => 'OtherNameAdd OtherNameAddress Addr4',
  11 => 'OtherNameAdd OtherNameAddress Addr5',
  12 => 'OtherNameAdd OtherNameAddress City',
  13 => 'OtherNameAdd OtherNameAddress State',
  14 => 'OtherNameAdd OtherNameAddress PostalCode',
  15 => 'OtherNameAdd OtherNameAddress Country',
  16 => 'OtherNameAdd OtherNameAddress Note',
  17 => 'OtherNameAdd Phone',
  18 => 'OtherNameAdd AltPhone',
  19 => 'OtherNameAdd Fax',
  20 => 'OtherNameAdd Email',
  21 => 'OtherNameAdd Contact',
  22 => 'OtherNameAdd AltContact',
  23 => 'OtherNameAdd AccountNumber',
  24 => 'OtherNameAdd Notes',
  25 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>