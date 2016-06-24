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
	protected $_data;

	public function __construct($data)
	{
		$this->_data = $data;

		if (isset($data['card']))
		{
			$this->_card = QuickBooks_Payments_CreditCard::fromArray($data['card']);
		}
	}

	public function toJSON()
	{
		return json_encode($this->_data);
	}

	public function getStatus()
	{
		return $this->_data['status'];
	}

	public function getAmount()
	{
		return $this->_data['amount'];
	}

	public function getCurrency()
	{
		return $this->_data['currency'];
	}

	public function getAVSStreet()
	{
		return $this->_data['avsStreet'];
	}

	public function getAVSZip()
	{
		return $this->_data['avsZip'];
	}

	public function getCardSecurityCodeMatch()
	{
		return $this->_data['cardSecurityCodeMatch'];
	}

	public function getId()
	{
		return $this->_data['id'];
	}

	public function getAuthCode()
	{
		return $this->_data['authCode'];
	}
}
