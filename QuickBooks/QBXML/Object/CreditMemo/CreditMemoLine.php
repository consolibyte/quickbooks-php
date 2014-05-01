<?php

/**
 * QuickBooks CreditMemoLine object class
 * 
 * @author Jayson Lindsley <jay.lindsley@gmail.com>
 * @author Keith Palmer <keith@consolibyte.com>
 *
 * TODO: Add support for items as per the QBXML spec
 *
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Object
 */

/**
 * QuickBooks object base class
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object.php');

/**
 * QuickBooks CreditMemo class
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/CreditMemo.php');

class QuickBooks_QBXML_Object_CreditMemo_CreditMemoLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks CreditMemo CreditMemoLine object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	/**
	 * Set the item name for this credit memo line
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setItemName($name)
	{
		return $this->set('ItemRef FullName', $name);
	}
	
	//Use this one!
	public function setItemFullName($FullName)
	{
		return $this->setFullNameType('ItemRef FullName', null, null, $FullName);
	}

	/**
	 * Get the name of the item for this invoice line item
	 * 
	 * @return string
	 */
	public function getItemName()
	{
		return $this->get('ItemRef FullName');
	}
	
	public function getItemFullName()
	{
		return $this->get('ItemRef FullName');
	}

	public function setDescription($descrip)
	{
		return $this->setDesc($descrip);
	}
	
	public function getDescription()
	{
		return $this->getDesc();
	}

	public function setDesc($value)
	{
		return $this->set('Desc', $value);
	}

	public function setQuantity($quan)
	{
		return $this->set('Quantity', (float) $quan);
	}
	
	public function getQuantity()
	{
		return $this->get('Quantity');
	}

	public function setRate($value)
	{
		return $this->set('Rate', (float) $value);
	}

	public function getRate()
	{
		return $this->get('Rate');
	}

	public function setClassFullName($value)
	{
		return $this->set('ClassRef FullName', $value);
	}

	public function setAmount($amount)
	{
		return $this->setAmountType('Amount', $amount);
	}

	public function getAmount()
	{
		if ($amount = $this->get('Amount'))
		{
			return $this->get('Amount');
		}
		return $this->get('Rate') * $this->get('Quantity');
	}

	public function asXML($root = null, $parent = null, $object = null)
	{
		$this->_cleanup();
		
		switch ($parent)
		{
			case QUICKBOOKS_ADD_CREDITMEMO:
				$root = 'CreditMemoLineAdd';
				$parent = null;
				break;
			case QUICKBOOKS_MOD_CREDITMEMO:
				$root = 'CreditMemoLineMod';
				$parent = null;
				break;
		}
		
		return parent::asXML($root, $parent, $object);
	}

	/**
	 * @param boolean $todo_for_empty_elements	A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE
	 * @param string $indent
	 * @param string $root
	 * @return string
	 */
	public function asQBXML($request, $todo_for_empty_elements = QUICKBOOKS_OBJECT_XML_DROP, $indent = "\t", $root = null)
	{
		$this->_cleanup();
		
		return parent::asQBXML($request, $todo_for_empty_elements, $indent, $root);
	}
	
	/**
	 * Tell the type of object this is
	 * 
	 * @return string
	 */
	public function object()
	{
		return 'CreditMemoLine';
	}
}