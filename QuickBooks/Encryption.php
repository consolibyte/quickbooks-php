<?php

/**
 * QuickBooks encryption library base class
 * 
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 *  
 * @package QuickBooks
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Encryption/Factory.php');

/**
 * 
 * 
 */
abstract class QuickBooks_Encryption
{
	/**
	 * 
	 * 
	 * 
	 */
	public function prefix($str)
	{
		return '{' . strlen(get_class($this)) . ':' . strtolower(get_class($this)) . '}' . $str;
	}
}

