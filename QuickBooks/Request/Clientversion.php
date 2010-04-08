<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Client
 */

/**
 * 
 */
class QuickBooks_Request_ClientVersion extends QuickBooks_Request
{
	public $strVersion;
	
	public function __construct($version = null)
	{
		$this->strVersion = $version;
	}
}

