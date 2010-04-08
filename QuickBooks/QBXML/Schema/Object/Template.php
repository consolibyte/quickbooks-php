<?php

/**
 * Schema object for: Template
 * 
 * @author Keith Palmer <keith@consolibyte.com>
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
class QuickBooks_QBXML_Schema_Object_Template extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '_qbxmlWrapper';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = '_dataTypePaths';
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = '_maxLengthPaths';
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = '_isOptionalPaths';
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = '_sinceVersionPaths';
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = '_isRepeatablePaths';
			
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
		static $paths = '_reorderPaths';
			
		return $paths;
	}
}

?>