<?php

/**
 * Result container object for the SOAP ->authenticate() method call
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
QuickBooks_Loader::load('/QuickBooks/Result.php');

/**
 * Result container object for the SOAP ->authenticate() method call
 */
class QuickBooks_Result_Debug extends QuickBooks_Result
{
	/**
	 * A two element array indicating the result of the call to ->authenticate()
	 * 
	 * @var array
	 */
	public $debug;
	
	/**
	 * Create a new result object
	 * 
	 * @param string $ticket	The ticket of the new login session
	 * @param string $status	The status of the new login session (blank, a company file path, or "nvu" for an invalid login)
	 */
	public function __construct($debug)
	{
		$this->debug = $debug;
	}
}

