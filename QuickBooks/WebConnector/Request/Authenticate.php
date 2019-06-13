<?php

/**
 * 
 * 
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Client
 */

/**
 * QuickBooks request base class
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Request.php');

/**
 * 
 */
class QuickBooks_WebConnector_Request_Authenticate extends QuickBooks_WebConnector_Request
{
	public $strUserName;
	
	public $strPassword;
	
	public function __construct($username = null, $password = null)
	{
		$this->strUserName = $username;
		$this->strPassword = $password;
	}
}

