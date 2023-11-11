<?php

/**
 * SOAP response container for ->getInteractiveURL() call
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
 * @subpackage Server
 */

/**
 * Result interface
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result.php');

/**
 * 
 */
class QuickBooks_WebConnector_Result_GetInteractiveURL extends QuickBooks_WebConnector_Result
{
	
	public function __construct($url)
	{
		
	}
}
