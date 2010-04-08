<?php

/**
 * Result container object for the SOAP ->clientVersion() method call
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
 * Result container object for the SOAP ->clientVersion() method call
 */
class QuickBooks_Result_ClientVersion extends QuickBooks_Result
{
	/**
	 * Client version response string (empty string, E:..., W:..., or O:...
	 * 
	 * @var string	The response string
	 */
	public $clientVersionResult;
	
	/**
	 * Create a new result object
	 * 
	 * @param string $response 	The response string
	 */
	public function __construct($response)
	{
		$this->clientVersionResult = $response;
	}
}
