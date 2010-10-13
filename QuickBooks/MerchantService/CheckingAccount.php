<?php

/**
 * Checking account object
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
class QuickBooks_MerchantService_CheckingAccount
{
	const INFO_PERSONAL = 'personal';
	const INFO_BUSINESS = 'business';
	
	const TYPE_CHECKING = 'Checking';
	const TYPE_SAVINGS = 'Savings';
	
	protected $_routing;
	protected $_account;
	
	protected $_info;
	protected $_type;
	protected $_first_name;
	protected $_last_name;
	protected $_phone;
	
	/**
	 * Create a new checking account object
	 * 
	 * @param 
	 */
	public function __construct($routing, $account, $info, $type, $first_name, $last_name, $phone)
	{
		$this->_routing = $routing;
		$this->_account = $account;
		
		$this->_info = $info;
		$this->_type = $type;
		
		$this->_first_name = $first_name;
		$this->_last_name = $last_name;
		
		$phone = trim(str_replace(array('(', ')', '+', ' ', '.', '-'), '', $phone));
		if (strlen($phone) == 11 and 
			$phone{0} == '1')
		{
			$phone = substr($phone, 1);
		}
		
		$this->_phone = $phone; 
	}
	
	public function getRoutingNumber()
	{
		return $this->_routing;
	}
	
	public function getAccountNumber()
	{
		return $this->_account;
	}
	
	public function getInfo()
	{
		return $this->_info;
	}
	
	public function getType()
	{
		return $this->_type;
	}
	
	public function getFirstName()
	{
		return $this->_first_name;
	}
	
	public function getLastName()
	{
		return $this->_last_name;
	}
	
	public function getPhone()
	{
		return $this->_phone;
	}
}
