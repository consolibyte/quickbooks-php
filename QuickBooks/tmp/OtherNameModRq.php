<?php

/**
 * Schema object for: OtherNameModRq
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
class QuickBooks_QBXML_Schema_Object_OtherNameModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'OtherNameMod ListID' => 'IDTYPE',
  'OtherNameMod EditSequence' => 'STRTYPE',
  'OtherNameMod Name' => 'STRTYPE',
  'OtherNameMod IsActive' => 'BOOLTYPE',
  'OtherNameMod CompanyName' => 'STRTYPE',
  'OtherNameMod Salutation' => 'STRTYPE',
  'OtherNameMod FirstName' => 'STRTYPE',
  'OtherNameMod MiddleName' => 'STRTYPE',
  'OtherNameMod LastName' => 'STRTYPE',
  'OtherNameMod OtherNameAddress Addr1' => 'STRTYPE',
  'OtherNameMod OtherNameAddress Addr2' => 'STRTYPE',
  'OtherNameMod OtherNameAddress Addr3' => 'STRTYPE',
  'OtherNameMod OtherNameAddress Addr4' => 'STRTYPE',
  'OtherNameMod OtherNameAddress Addr5' => 'STRTYPE',
  'OtherNameMod OtherNameAddress City' => 'STRTYPE',
  'OtherNameMod OtherNameAddress State' => 'STRTYPE',
  'OtherNameMod OtherNameAddress PostalCode' => 'STRTYPE',
  'OtherNameMod OtherNameAddress Country' => 'STRTYPE',
  'OtherNameMod OtherNameAddress Note' => 'STRTYPE',
  'OtherNameMod Phone' => 'STRTYPE',
  'OtherNameMod AltPhone' => 'STRTYPE',
  'OtherNameMod Fax' => 'STRTYPE',
  'OtherNameMod Email' => 'STRTYPE',
  'OtherNameMod Contact' => 'STRTYPE',
  'OtherNameMod AltContact' => 'STRTYPE',
  'OtherNameMod AccountNumber' => 'STRTYPE',
  'OtherNameMod Notes' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'OtherNameMod ListID' => 0,
  'OtherNameMod EditSequence' => 16,
  'OtherNameMod Name' => 41,
  'OtherNameMod IsActive' => 0,
  'OtherNameMod CompanyName' => 41,
  'OtherNameMod Salutation' => 15,
  'OtherNameMod FirstName' => 25,
  'OtherNameMod MiddleName' => 5,
  'OtherNameMod LastName' => 25,
  'OtherNameMod OtherNameAddress Addr1' => 41,
  'OtherNameMod OtherNameAddress Addr2' => 41,
  'OtherNameMod OtherNameAddress Addr3' => 41,
  'OtherNameMod OtherNameAddress Addr4' => 41,
  'OtherNameMod OtherNameAddress Addr5' => 41,
  'OtherNameMod OtherNameAddress City' => 31,
  'OtherNameMod OtherNameAddress State' => 21,
  'OtherNameMod OtherNameAddress PostalCode' => 13,
  'OtherNameMod OtherNameAddress Country' => 31,
  'OtherNameMod OtherNameAddress Note' => 41,
  'OtherNameMod Phone' => 21,
  'OtherNameMod AltPhone' => 21,
  'OtherNameMod Fax' => 21,
  'OtherNameMod Email' => 1023,
  'OtherNameMod Contact' => 41,
  'OtherNameMod AltContact' => 41,
  'OtherNameMod AccountNumber' => 99,
  'OtherNameMod Notes' => 4095,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'OtherNameMod ListID' => false,
  'OtherNameMod EditSequence' => false,
  'OtherNameMod Name' => true,
  'OtherNameMod IsActive' => true,
  'OtherNameMod CompanyName' => true,
  'OtherNameMod Salutation' => true,
  'OtherNameMod FirstName' => true,
  'OtherNameMod MiddleName' => true,
  'OtherNameMod LastName' => true,
  'OtherNameMod OtherNameAddress Addr1' => true,
  'OtherNameMod OtherNameAddress Addr2' => true,
  'OtherNameMod OtherNameAddress Addr3' => true,
  'OtherNameMod OtherNameAddress Addr4' => true,
  'OtherNameMod OtherNameAddress Addr5' => true,
  'OtherNameMod OtherNameAddress City' => true,
  'OtherNameMod OtherNameAddress State' => true,
  'OtherNameMod OtherNameAddress PostalCode' => true,
  'OtherNameMod OtherNameAddress Country' => true,
  'OtherNameMod OtherNameAddress Note' => true,
  'OtherNameMod Phone' => true,
  'OtherNameMod AltPhone' => true,
  'OtherNameMod Fax' => true,
  'OtherNameMod Email' => true,
  'OtherNameMod Contact' => true,
  'OtherNameMod AltContact' => true,
  'OtherNameMod AccountNumber' => true,
  'OtherNameMod Notes' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'OtherNameMod ListID' => 999.99,
  'OtherNameMod EditSequence' => 999.99,
  'OtherNameMod Name' => 999.99,
  'OtherNameMod IsActive' => 999.99,
  'OtherNameMod CompanyName' => 999.99,
  'OtherNameMod Salutation' => 999.99,
  'OtherNameMod FirstName' => 999.99,
  'OtherNameMod MiddleName' => 999.99,
  'OtherNameMod LastName' => 999.99,
  'OtherNameMod OtherNameAddress Addr1' => 999.99,
  'OtherNameMod OtherNameAddress Addr2' => 999.99,
  'OtherNameMod OtherNameAddress Addr3' => 999.99,
  'OtherNameMod OtherNameAddress Addr4' => 2,
  'OtherNameMod OtherNameAddress Addr5' => 6,
  'OtherNameMod OtherNameAddress City' => 999.99,
  'OtherNameMod OtherNameAddress State' => 999.99,
  'OtherNameMod OtherNameAddress PostalCode' => 999.99,
  'OtherNameMod OtherNameAddress Country' => 999.99,
  'OtherNameMod OtherNameAddress Note' => 6,
  'OtherNameMod Phone' => 999.99,
  'OtherNameMod AltPhone' => 999.99,
  'OtherNameMod Fax' => 999.99,
  'OtherNameMod Email' => 999.99,
  'OtherNameMod Contact' => 999.99,
  'OtherNameMod AltContact' => 999.99,
  'OtherNameMod AccountNumber' => 999.99,
  'OtherNameMod Notes' => 3,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'OtherNameMod ListID' => false,
  'OtherNameMod EditSequence' => false,
  'OtherNameMod Name' => false,
  'OtherNameMod IsActive' => false,
  'OtherNameMod CompanyName' => false,
  'OtherNameMod Salutation' => false,
  'OtherNameMod FirstName' => false,
  'OtherNameMod MiddleName' => false,
  'OtherNameMod LastName' => false,
  'OtherNameMod OtherNameAddress Addr1' => false,
  'OtherNameMod OtherNameAddress Addr2' => false,
  'OtherNameMod OtherNameAddress Addr3' => false,
  'OtherNameMod OtherNameAddress Addr4' => false,
  'OtherNameMod OtherNameAddress Addr5' => false,
  'OtherNameMod OtherNameAddress City' => false,
  'OtherNameMod OtherNameAddress State' => false,
  'OtherNameMod OtherNameAddress PostalCode' => false,
  'OtherNameMod OtherNameAddress Country' => false,
  'OtherNameMod OtherNameAddress Note' => false,
  'OtherNameMod Phone' => false,
  'OtherNameMod AltPhone' => false,
  'OtherNameMod Fax' => false,
  'OtherNameMod Email' => false,
  'OtherNameMod Contact' => false,
  'OtherNameMod AltContact' => false,
  'OtherNameMod AccountNumber' => false,
  'OtherNameMod Notes' => false,
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
  0 => 'OtherNameMod ListID',
  1 => 'OtherNameMod EditSequence',
  2 => 'OtherNameMod Name',
  3 => 'OtherNameMod IsActive',
  4 => 'OtherNameMod CompanyName',
  5 => 'OtherNameMod Salutation',
  6 => 'OtherNameMod FirstName',
  7 => 'OtherNameMod MiddleName',
  8 => 'OtherNameMod LastName',
  9 => 'OtherNameMod OtherNameAddress Addr1',
  10 => 'OtherNameMod OtherNameAddress Addr2',
  11 => 'OtherNameMod OtherNameAddress Addr3',
  12 => 'OtherNameMod OtherNameAddress Addr4',
  13 => 'OtherNameMod OtherNameAddress Addr5',
  14 => 'OtherNameMod OtherNameAddress City',
  15 => 'OtherNameMod OtherNameAddress State',
  16 => 'OtherNameMod OtherNameAddress PostalCode',
  17 => 'OtherNameMod OtherNameAddress Country',
  18 => 'OtherNameMod OtherNameAddress Note',
  19 => 'OtherNameMod Phone',
  20 => 'OtherNameMod AltPhone',
  21 => 'OtherNameMod Fax',
  22 => 'OtherNameMod Email',
  23 => 'OtherNameMod Contact',
  24 => 'OtherNameMod AltContact',
  25 => 'OtherNameMod AccountNumber',
  26 => 'OtherNameMod Notes',
  27 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>