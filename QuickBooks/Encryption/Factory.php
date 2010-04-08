<?php

/**
 * QuickBooks encryption library factory method
 * 
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 *  
 * @package QuickBooks
 * @subpackage Encryption
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Encryption.php');

/**
 * 
 * 
 * 
 */
class QuickBooks_Encryption_Factory
{
	// , $iv = null, $mode = null
	static public function create($encrypt)
	{
		$class = 'QuickBooks_Encryption_' . ucfirst(strtolower($encrypt));
		$file = '/QuickBooks/Encryption/' . ucfirst(strtolower($encrypt)) . '.php';
		
		QuickBooks_Loader::load($file);
		
		return new $class();
	}
	
	/**
	 * 
	 * 
	 * @param string $encrypted
	 * @return string
	 */
	static public function determine(&$encrypted)
	{
		if ($encrypted[0] == '{' and 
			false !== ($end = strpos($encrypted, ':')))
		{
			$number = substr($encrypted, 1, $end);
			
			$method = substr($encrypted, 1 + strlen($number), $number);
			$encrypted = substr($encrypted, $number + 4);
			return $method;
		}
		
		return null;
	}
}
