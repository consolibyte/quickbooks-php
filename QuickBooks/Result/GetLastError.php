<?php

/**
 * Result container object for the SOAP ->getLastError() method call
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * Result base class
 */
QuickBooks_Loader::load('/QuickBooks/Result.php');

/**
 * Result container object for the SOAP ->getLastError() method call
 */
class QuickBooks_Result_GetLastError extends QuickBooks_Result
{
	/**
	 * An error message
	 * 
	 * @param string $resp
	 */
	public $getLastErrorResult;
	
	/**
	 * Create a new result object
	 * 
	 * @param string $resp 		A message describing the last error that occured
	 */
	public function __construct($result)
	{
		$this->getLastErrorResult = $result;
	}
}
