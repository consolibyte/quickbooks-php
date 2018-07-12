<?php

/**
 * QuickBooks ShipMethod object container
 *
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 *
 * @package QuickBooks
 * @subpackage Object
 */

/**
 *
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object.php');

/**
 *
 */
class QuickBooks_QBXML_Object_PaymentMethod extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_PaymentMethod object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	/**
	 * Set the ListID
	 *
	 * @param string $ListID
	 * @return boolean
	 */
	public function setListID($ListID)
	{
		return $this->set('ListID', $ListID);
	}

	/**
	 * Get the ListID
	 *
	 * @return string
	 */
	public function getListID()
	{
		return $this->get('ListID');
	}

	/**
	 * Set the name
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function setName($name)
	{
		return $this->set('Name', $name);
	}

	/**
	 * Get the name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->get('Name');
	}

	/**
	 * Set this as active or not
	 *
	 * @param boolean $value
	 * @return boolean
	 */
	public function setIsActive($value)
	{
		return $this->setBooleanType('IsActive', $value);
	}

	/**
	 * Tell whether or not this is active
	 *
	 * @return boolean
	 */
	public function getIsActive()
	{
		return $this->getBooleanType('IsActive');
	}

	public function getPaymentMethodType()
	{
		return $this->get('PaymentMethodType');
	}

	/**
	 * Tell what type of object this is
	 *
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_PAYMENTMETHOD;
	}
}

?>
