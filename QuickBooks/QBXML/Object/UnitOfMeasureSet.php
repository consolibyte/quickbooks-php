<?php

/**
 * QuickBooks Unit of Measure Set object container
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
 * 
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/UnitOfMeasureSet/DefaultUnit.php');

/** 
 * 
 * 
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/UnitOfMeasureSet/RelatedUnit.php');

/**
 * 
 */
class QuickBooks_QBXML_Object_UnitOfMeasureSet extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Class object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
		
		// These things occur because it's a repeatable element who name doesn't do the *Add, *Mod, *Ret thing, trash these
		$unsets = array(
			'RelatedUnit Name', 
			'RelatedUnit Abbreviation', 
			'RelatedUnit ConversionRatio', 
			'DefaultUnit UnitUsedFor', 
			'DefaultUnit Unit', 
			);
		
		foreach ($unsets as $unset)
		{
			if (isset($this->_object[$unset]))
			{
				unset($this->_object[$unset]);
			}
		}
	}
	
	/**
	 * Set the ListID of the Class
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setListID($ListID)
	{
		return $this->set('ListID', $ListID);
	}
	
	/**
	 * Get the ListID of the Class
	 * 
	 * @return string
	 */
	public function getListID()
	{
		return $this->get('ListID');
	}
		
	/**
	 * Set the name of the class
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setName($name)
	{
		return $this->set('Name', $name);
	}
	
	/**
	 * Get the name of the class
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->get('Name');
	}
		
	/**
	 * Set this Class active or not
	 * 
	 * @param boolean $value
	 * @return boolean
	 */
	public function setIsActive($value)
	{
		return $this->setBooleanType('IsActive', $value);
	}
	
	/**
	 * Tell whether or not this class object is active
	 * 
	 * @return boolean
	 */
	public function getIsActive()
	{
		return $this->getBooleanType('IsActive');
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public function setUnitOfMeasureType($type)
	{
		return $this->set('UnitOfMeasureType', $type);
	}
	
	public function getUnitOfMeasureType()
	{
		return $this->get('UnitOfMeasureType');
	}
	
	public function setBaseUnitName($name)
	{
		return $this->set('BaseUnit Name', $name);
	}
	
	public function getBaseUnitName()
	{
		return $this->get('BaseUnit Name');
	}
	
	public function setBaseUnitAbbreviation($abbr)
	{
		return $this->set('BaseUnit Abbreviation', $abbr);
	}
	
	public function getBaseUnitAbbreviation()
	{
		return $this->get('BaseUnit Abbreviation');
	}
	
	
	public function addRelatedUnit($obj)
	{
		return $this->addListItem('RelatedUnit', $obj);
	}
	
	public function getRelatedUnit($i)
	{
		return $this->getListItem('RelatedUnit', $i);
	}
	
	public function listRelatedUnits()
	{
		return $this->getList('RelatedUnit');
	}


	public function addDefaultUnit($obj)
	{
		return $this->addListItem('DefaultUnit', $obj);
	}
	
	public function getDefaultUnit($i)
	{
		return $this->getListItem('DefaultUnit', $i);
	}
	
	public function listDefaultUnits()
	{
		return $this->getList('DefaultUnit');
	}
	
	
	/**
	 * Tell what type of object this is 
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_UNITOFMEASURESET;
	}
}
