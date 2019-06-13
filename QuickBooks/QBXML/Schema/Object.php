<?php

/**
 * 
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
define('QUICKBOOKS_QBXML_SCHEMA_TYPE_STRTYPE', 'STRTYPE');

/**
 * 
 */
define('QUICKBOOKS_QBXML_SCHEMA_TYPE_IDTYPE', 'IDTYPE');

/**
 * 
 */
define('QUICKBOOKS_QBXML_SCHEMA_TYPE_BOOLTYPE', 'BOOLTYPE');

define('QUICKBOOKS_QBXML_SCHEMA_TYPE_AMTTYPE', 'AMTTYPE');

/**
 * 
 */
abstract class QuickBooks_QBXML_Schema_Object
{
	abstract protected function &_qbxmlWrapper();
	
	public function qbxmlWrapper()
	{
		return $this->_qbxmlWrapper();
	}
	
	abstract protected function &_dataTypePaths();
	
	/**
	 * 
	 * 
	 * @param string $match
	 * @return array
	 */
	public function paths($match = null)
	{
		$paths = $this->_dataTypePaths();
		
		return array_keys($paths);
	}
	
	/** 
	 * 
	 * 
	 * @param string $path
	 * @param boolean $case_doesnt_matter
	 * @return string
	 */
	public function dataType($path, $case_doesnt_matter = true)
	{
		/*
		static $paths = array(
			'Name' => 'STRTYPE', 
			);
		*/
		
		$paths = $this->_dataTypePaths();
		
		if (isset($paths[$path]))
		{
			return $paths[$path];
		}
		else if ($case_doesnt_matter)
		{
			foreach ($paths as $dtpath => $datatype)
			{
				if (strtolower($dtpath) == strtolower($path))
				{
					return $datatype;
				}
			}
		}
		
		return null;
	}
	
	abstract protected function &_maxLengthPaths();
	
	/**
	 * 
	 * 
	 * @param string $path
	 * @param boolean $case_doesnt_matter
	 * @param string $locale
	 * @return integer
	 */
	public function maxLength($path, $case_doesnt_matter = true, $locale = null)
	{
		/*
		static $paths = array(
			'Name' => 40, 
			'FirstName' => 41, 
			);
		*/
		
		$paths = $this->_maxLengthPaths();
			
		if (isset($paths[$path]))
		{
			return $paths[$path];
		}
		else if ($case_doesnt_matter)
		{
			foreach ($paths as $mlpath => $maxlength)
			{
				if (strtolower($mlpath) == strtolower($path))
				{
					return $paths[$mlpath];
				}
			}
		}
		
		return 0;
	}
	
	abstract protected function &_isOptionalPaths();
	
	public function isOptional($path)
	{
		/*
		static $paths = array(
			'Name' => false, 
			'FirstName' => true, 
			'LastName' => true, 
			);
		*/
		
		$paths = $this->_isOptionalPaths();
		
		if (isset($paths[$path]))
		{
			return $paths[$path];
		}
		
		return true;
	}
	
	abstract protected function &_sinceVersionPaths();
	
	public function sinceVersion($path)
	{
		/*
		static $paths = array(
			'FirstName' => '0.0', 
			'LastName' => '0.0', 
			);
		*/
		
		$paths = $this->_sinceVersionPaths();
			
		if (isset($paths[$path]))
		{
			return $paths[$path];
		}
		
		return '999.99';
	}
	
	abstract protected function &_isRepeatablePaths();
	
	/**
	 * Tell whether or not a specific element is repeatable 
	 * 
	 * @param string $path
	 * @return boolean
	 */
	public function isRepeatable($path)
	{
		/*
		static $paths = array(
			'FirstName' => false, 
			'LastName' => false, 
			);
		*/
		
		$paths = $this->_isRepeatablePaths();
		
		if (isset($paths[$path]))
		{
			return $paths[$path];
		}
		
		return false;
	}
	
	/**
	 * Tell whether or not an element exists
	 * 
	 * @param string $path
	 * @return boolean
	 */
	public function exists($path, $case_doesnt_matter = true, $is_end_element = false)
	{
		$ordered_paths = $this->_reorderPathsPaths();
		
		if (in_array($path, $ordered_paths))
		{
			return true;
		}
		else if ($case_doesnt_matter)
		{
			foreach ($ordered_paths as $ordered_path)
			{
				if (strtolower($path) == strtolower($ordered_path))
				{
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * 
	 */
	public function unfold($path)
	{
		static $paths = null;
		
		if (is_null($paths))
		{
			$paths = $this->_reorderPathsPaths();
			$paths = array_change_key_case(array_combine(array_values($paths), array_values($paths)), CASE_LOWER);
		}
		
		//print('unfolding: {' . $path . '}' . "\n");
		
		if (isset($paths[strtolower($path)]))
		{
			return $paths[strtolower($path)];
		}
		
		return null;
	}
	
	/**
	 * 
	 * @note WARNING! These are lists of UNSUPPORTED locales, NOT lists of supported ones!
	 * 
	 */	
	protected function &_inLocalePaths()
	{
		$arr = array();
		return $arr;
	}
	
	/**
	 * 
	 * @note WARNING! These are lists of UNSUPPORTED locales, NOT lists of supported ones!
	 * 
	 */
	public function localePaths()
	{
		return $this->_inLocalePaths();
	}
	
	/*
	public function inLocale($path, $locale)
	{
		//static $paths = array(
		//	'FirstName' => array( 'QBD', 'QBCA', 'QBUK', 'QBAU' ), 
		//	'LastName' => array( 'QBD', 'QBCA', 'QBUK', 'QBAU' ),
		//	);
		
		$paths = $this->_inLocalePaths();
		
		if (isset($paths[$path]))
		{
			return in_array($locale, $paths[$path]);
		}
		
		return false;
	}
	*/
	
	/**
	 * Return a list of paths in a specific schema order
	 * 
	 * @return array
	 */
	abstract protected function &_reorderPathsPaths();
	
	/**
	 * Re-order an array to match the schema order
	 * 
	 * @param array $unordered_paths
	 * @param boolean $allow_application_id
	 * @return array
	 */
	public function reorderPaths($unordered_paths, $allow_application_id = true, $allow_application_editsequence = true)
	{
		/*
		static $ordered_paths = array(
			0 => 'Name', 
			1 => 'FirstName', 
			2 => 'LastName',
			);
		*/
		
		$ordered_paths = $this->_reorderPathsPaths();
		
		$tmp = array();
		
		foreach ($ordered_paths as $key => $path)
		{
			if (in_array($path, $unordered_paths))
			{
				$tmp[$key] = $path;
			}
			/*else if (substr($path, -6) == 'ListID' and $allow_application_id)
			{
				// Modify and add:  (so that application IDs are supported and in the correct place)
				//	CustomerRef ListID tags 
				// modified to:
				//	CustomerRef APIApplicationID tags
				
				$parent = trim(substr($path, 0, -7));
				
				$apppath = trim($parent . ' ' . QUICKBOOKS_API_APPLICATIONID);
				
				if (in_array($apppath, $unordered_paths))
				{
					$tmp[$key] = $apppath;
				}
			}
			else if (substr($path, -5) == 'TxnID' and $allow_application_id)
			{
				$parent = trim(substr($path, 0, -6));
				
				$apppath = $parent . ' ' . QUICKBOOKS_API_APPLICATIONID;
				
				if (in_array($apppath, $unordered_paths))
				{
					$tmp[$key] = $apppath;
				}
			}
			else if ($path == 'EditSequence' and $allow_application_editsequence)
			{
				$apppath = QUICKBOOKS_API_APPLICATIONEDITSEQUENCE;
				
				if (in_array($apppath, $unordered_paths))
				{
					$tmp[$key] = $apppath;
				}
			}*/
			
			/*else if ($path == QUICKBOOKS_API_APPLICATIONID)
			{
				print('HERE!');
			}*/
		}
		
		return array_merge($tmp);
	}
}

