<?php

/**
 * Bank account class
 * 
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
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
class QuickBooks_Payments_BankAccount
{
	protected $_data;

	const TYPE_PERSONAL_CHECKING = 'PERSONAL_CHECKING';
	const TYPE_PERSONAL_SAVINGS = 'PERSONAL_SAVINGS';

	public function __construct($name, $number, $routing, $type, $phone)
	{
		$this->_data = array(
			'name' => $name, 
			'routingNumber' => $routing, 
			'accountNumber' => $number, 
			'accountType' => $type, 
			'phone' => trim(str_replace(array('-', ' ', '(', ')'), '', $phone))
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

	static public function fromArray($data)
	{
		return new QuickBooks_Payments_BankAccount($data['name'], $data['accountNumber'], $data['routingNumber'], $data['accountType'], $data['phone']);
	}
}
