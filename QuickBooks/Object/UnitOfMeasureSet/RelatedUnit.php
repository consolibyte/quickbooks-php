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
QuickBooks_Loader::load('/QuickBooks/Object.php');

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Object/UnitOfMeasureSet.php');

/**
 * 
 * 
 */
class QuickBooks_Object_UnitOfMeasureSet_RelatedUnit extends QuickBooks_Object
{
	public function setName($name)
	{
		return $this->set('Name', $name);
	}
	
	public function getName()
	{
		return $this->get('Name');
	}
	
	public function setAbbreviation($abbrev)
	{
		return $this->set('Abbreviation', $abbrev);
	}
	
	public function getAbbreviation()
	{
		return $this->get('Abbreviation');
	}
	
	public function getConversionRatio()
	{
		return $this->get('ConversionRatio');
	}
	
	public function setConversionRatio($ratio)
	{
		return $this->set('ConversionRatio', $ratio);
	}
		
	/**
	 * Tell the type of object this is
	 * 
	 * @return string
	 */
	public function object()
	{
		return 'RelatedUnit';
	}
}
