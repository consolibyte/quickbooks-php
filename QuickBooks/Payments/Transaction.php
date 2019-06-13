<?php

/**
 * QuickBooks Merchant Service transaction class
 * 
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * This class represents a transaction returned by the QuickBooks Merchant 
 * Service web gateway. 
 * 
 * @package QuickBooks
 * @subpackage MerchantService
 */

/**
 * QuickBooks MerchantService transaction processor
 */
QuickBooks_Loader::load('/QuickBooks/Payments.php');

/**
 * QuickBooks Merchant Service transaction class
 */
class QuickBooks_Payments_Transaction
{
	protected $_card;
	protected $_bank;
	protected $_data;

	public function __construct($data)
	{
		$this->_data = $data;

		$this->_card = null;
		$this->_bank = null;

		if (isset($data['card']))
		{
			$this->_card = QuickBooks_Payments_CreditCard::fromArray($data['card']);
		}
		else if (isset($data['bankAccount']))
		{
			$this->_bank = QuickBooks_Payments_BankAccount::fromArray($data['bankAccount']);
		}
	}

	public function getCreditCard()
	{
		return $this->_card;
	}

	public function getBankAccount()
	{
		return $this->_bank;
	}

	public function toJSON()
	{
		return json_encode($this->_data);
	}

	public function getStatus()
	{
		return $this->_get('status');
	}

	public function getAmount()
	{
		return $this->_get('amount');
	}

	public function getCurrency()
	{
		return $this->_get('currency');
	}

	public function getAVSStreet()
	{
		return $this->_get('avsStreet');
	}

	public function getAVSZip()
	{
		return $this->_get('avsZip');
	}

	public function getCardSecurityCodeMatch()
	{
		return $this->_get('cardSecurityCodeMatch');
	}

	public function getId()
	{
		return $this->_get('id');
	}

	public function getAuthCode()
	{
		return $this->_get('authCode');
	}

	public function getType()
	{
		return $this->_get('type');
	}

	protected function _get($key)
	{
		if (isset($this->_data[$key]))
		{
			return $this->_data[$key];
		}

		return null;
	}

	public function toArray()
	{
		return $this->_data;
	}
}
