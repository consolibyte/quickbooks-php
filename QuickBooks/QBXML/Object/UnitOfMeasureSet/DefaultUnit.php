<?php

/**
 * 
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
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/UnitOfMeasureSet.php');

/**
 * 
 * 
 */
class QuickBooks_QBXML_Object_UnitOfMeasureSet_DefaultUnit extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks SalesReceipt SalesReceiptLine object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	public function setUnitUsedFor($str)
	{
		return $this->setUnitUsedFor('UnitUsedFor', $str);
	}
	
	public function getUnitUsedFor()
	{
		return $this->get('UnitUsedFor');
	}
	
	public function setUnit($unit)
	{
		return $this->set('Unit', $unit);
	}
	
	public function getUnit()
	{
		return $this->get('Unit');
	}
		
	/**
	 * Tell the type of object this is
	 * 
	 * @return string
	 */
	public function object()
	{
		return 'DefaultUnit';
	}
}
