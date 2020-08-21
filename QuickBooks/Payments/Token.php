<?php

/**
 * Token class
 * 
 * Copyright (c) {2015-11-01} {Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 *
 * @author Keith Palmer Jr. <keith@ConsoliBYTE.com>
 *
 * @package QuickBooks
 * @subpackage MerchantService 
 */

/**
 * 
 * 
 */
class QuickBooks_Payments_Token
{
	protected $_data;

	public function __construct($token)
	{
		$this->_data = array(
			'value' => $token
			);
	}

	public function toJSON()
	{
		return json_encode($this->_data);
	}

	public function toArray()
	{
		return $this->_data;
	}
}
