<?php

/**
 * Credit card class
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
class QuickBooks_MerchantService_CreditCard 
{
	protected $_name;
	protected $_number;
	protected $_expyear;
	protected $_expmonth;
	protected $_address;
	protected $_postalcode;
	protected $_cvv;
	
	protected $_lodging;
	
	protected $_restaurant;
	
	/**
	 * Create a new credit card object
	 * 
	 * @param string $name		The name on the credit card
	 * @param string $number	The credit card number
	 * @param 
	 */
	public function __construct($name, $number, $expyear, $expmonth, $address = null, $postalcode = null, $cvv = null)
	{
		$this->_name = $name;
		$this->_number = str_replace(array('.', '-', ' '), '', $number);
		$this->_expyear = (int) $expyear;
		$this->_expmonth = (int) $expmonth;
		$this->_address = $address;
		$this->_postalcode = str_replace(array('.', '-', ' '), '', $postalcode);
		$this->_cvv = $cvv;
		
		$decode = array(
			'&amp;' => '&', 
			'&quot;' => '"', 
			'&gt;' => '>', 
			'&lt;' => '<', 
			);
		
		// Maximum field length of 30 for address and name
		if (strlen(htmlspecialchars($this->_name)) > 30)
		{
			$this->_name = str_replace(array_keys($decode), array_values($decode), substr(htmlspecialchars($this->_name), 0, 30));
		}
		
		if (strlen(htmlspecialchars($this->_address)) > 30)
		{
			$this->_address = str_replace(array_keys($decode), array_values($decode), substr(htmlspecialchars($this->_address), 0, 30));
		}
	}
	
	public function addLodgingData()
	{
		
	}
	
	public function addRestaurantData()
	{
		
	}
	
	public function setName($name)
	{
		$this->_name = $name;
	}
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function setNumber($number)
	{
		$this->_number = $number;
	}
	
	public function getNumber($mask = false)
	{
		if ($mask)
		{
			return str_repeat('x', min(strlen($this->_number), 12)) . substr($this->_number, 12);
		}
		
		return $this->_number;
	}
	
	public function setExpirationYear($year)
	{
		$this->_expyear = $year;
	}
	
	public function getExpirationYear()
	{
		return $this->_expyear;
	}
	
	public function setExpirationMonth($month)
	{
		$this->_expmonth = $month;
	}
	
	public function getExpirationMonth()
	{
		return $this->_expmonth;
	}
	
	public function setAddress($addr)
	{
		$this->_address = $addr;
	}
	
	public function getAddress()
	{
		return $this->_address;
	}
	
	public function setPostalCode($postalcode)
	{
		$this->_postalcode = $postalcode;
	}
	
	public function getPostalCode()
	{
		return $this->_postalcode;
	}
	
	public function setCVVCode($cvv)
	{
		$this->_cvv = $cvv;
	}
	
	public function getCVVCode()
	{
		return $this->_cvv;
	}
}
