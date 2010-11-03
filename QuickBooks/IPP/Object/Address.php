<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Address extends QuickBooks_IPP_Object
{
	const TAG_BILLING = 'Billing';
	const TAG_SHIPPING = 'Shipping';
	
	public function setState($state)
	{
		return $this->setCountrySubDivisionCode($state);
	}
	
	public function getState()
	{
		return $this->getCountrySubDivisionCode();
	}
	
	protected function _order()
	{
		return array(
			'Id' => true, 
			'Line1' => true, 
			'Line2' => true, 
			'Line3' => true, 
			'Line4' => true, 
			'Line5' => true, 
			'City' => true, 
			'Country' => true, 
			'CountrySubDivisionCode' => true, 
			'PostalCode' => true, 
			'PostalCodeSuffix' => true, 
			'Default' => true, 	
			'Tag' => true, 
			);
	}

}
