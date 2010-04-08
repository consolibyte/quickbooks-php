<?php

/**
 * QuickBooks result base class
 * 
 * Result subclasses are returned by the SOAP server handler methods to pass 
 * data back to the QuickBooks web connector. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * QuickBooks result base class
 */
abstract class QuickBooks_Result
{
	/**
	 * Placeholder constructor method
	 */
	abstract public function __construct($var);
}
