<?php

/**
 * QuickBooks request base class
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Client
 */

/**
 * QuickBooks result base class
 */
abstract class QuickBooks_Request
{
	/**
	 * Placeholder constructor method
	 */
	abstract public function __construct($var);
	
	/**
	 * 
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function set($key, $value)
	{
		$this->$key = $value;
	}
}

