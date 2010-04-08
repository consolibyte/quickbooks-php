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
class QuickBooks_Request_Authenticate extends QuickBooks_Request
{
	public $strUserName;
	
	public $strPassword;
	
	public function __construct($username = null, $password = null)
	{
		$this->strUserName = $username;
		$this->strPassword = $password;
	}
}

