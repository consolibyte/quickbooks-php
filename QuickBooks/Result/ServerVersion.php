<?php

/**
 * QuickBooks response object for responses to the ->getServerVersion() SOAP method call
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
 * QuickBooks response object for responses to the ->getServerVersion() SOAP method call
 */
class QuickBooks_Result_ServerVersion extends QuickBooks_Result
{
	/**
	 * A string describing the server version
	 * 
	 * @var string
	 */
	public $serverVersionResult;
	
	/**
	 * Create a new result object
	 * 
	 * @param string $version
	 */
	public function __construct($version)
	{
		$this->serverVersionResult = $version;
	}
}
