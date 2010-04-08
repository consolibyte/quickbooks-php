<?php

/**
 * 
 * 
 * 
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
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function getNumber($mask = false)
	{
		if ($mask)
		{
			return str_repeat('x', strlen($this->_number) - 4) . substr($this->_number, -4, 4);
		}
		
		return $this->_number;
	}
	
	public function getExpirationYear()
	{
		return $this->_expyear;
	}
	
	public function getExpirationMonth()
	{
		return $this->_expmonth;
	}
	
	public function getAddress()
	{
		return $this->_address;
	}
	
	public function getPostalCode()
	{
		return $this->_postalcode;
	}
	
	public function getCVVCode()
	{
		return $this->_cvv;
	}
}
