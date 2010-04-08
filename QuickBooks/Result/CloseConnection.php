<?php

/**
 * Result container object for the SOAP ->connectionError() method call
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * Result interface
 */
QuickBooks_Loader::load('/QuickBooks/Result.php');

/**
 * Result class for ->closeConnection() SOAP method
 */
class QuickBooks_Result_CloseConnection extends QuickBooks_Result
{
	/**
	 * A message indicating the connection has been closed/update was successful
	 * 
	 * @var string
	 */
	public $closeConnectionResult;
	
	/**
	 * Create a new result object
	 * 
	 * @param string $resp		A message indicating the connection has been closed
	 */
	public function __construct($result)
	{
		$this->closeConnectionResult = $result;
	}
}

