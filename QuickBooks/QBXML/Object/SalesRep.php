<?php
/**
 * QuickBooks SalesRep object container
 *
 * @author Adam Heinz <amh@metricwise.net>
 * @license LICENSE.txt
 *
 * @package QuickBooks
 * @subpackage Object
 */

/**
 * Base object class
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object.php');

/**
 * QuickBooks Customer object class
 */
class QuickBooks_QBXML_Object_SalesRep extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_SalesRep object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	/**
	 * Set the initials of this sales rep
	 *
	 * @param string $value
	 * @return boolean
	 */
	public function setInitial($value)
	{
		return $this->set('Initial', $value);
	}

	/**
	 * Get the initials of this sales rep
	 *
	 * @return string
	 */
	public function getInitial()
	{
		return $this->get('Initial');
	}

	/**
	 * Set this sales rep active or not
	 *
	 * @param boolean $value
	 * @return boolean
	 */
	public function setIsActive($value)
	{
		return $this->set('IsActive', (boolean) $value);
	}

	/**
	 * Get whether or not this sales rep is active
	 *
	 * @return boolean
	 */
	public function getIsActive()
	{
		return $this->getBooleanType('IsActive');
	}

	/**
	 * @param string $lid
	 * @return boolean
	 */
	public function setSalesRepEntityListID($lid)
	{
		return $this->set('SalesRepEntityRef ListID', $lid);
	}

	/**
	 * @param string $name
	 * @return boolean
	 */
	public function setSalesRepEntityName($name)
	{
		return $this->set('SalesRepEntityRef FullName', $name);
	}

	/**
	 * Tell what type of object this is
	 *
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_SALESREP;
	}
}
