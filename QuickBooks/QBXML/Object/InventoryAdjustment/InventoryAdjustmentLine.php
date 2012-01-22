<?php

/**
 * QuickBooks InventoryAdjustment object container
 *
 * @todo Verify the get/set methods on this one... it was copied from InventoryItem
 *
 * @author Harley Laue <harley.laue@gmail.com>
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
 * Quickbooks InventoryAdjustmentLine definition
 */
class QuickBooks_QBXML_Object_InventoryAdjustment_InventoryAdjustmentLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks InventoryAdjustment object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	public function getLineItemListID($ListID)
	{
		return $this->get('ItemRef ListID');
	}

	public function setLineItemListID($ListID)
	{
		return $this->set('ItemRef ListID', $ListID);
	}

	public function getLineItemName($name)
	{
		return $this->get('ItemRef FullName');
	}

	public function setLineItemName($name)
	{
		return $this->set('ItemRef FullName', $name);
	}

	public function getLineQuantityNew($value)
	{
		return $this->get('QuantityAdjustment NewQuantity');
	}

	public function setLineQuantityNew($value)
	{
		return $this->set('QuantityAdjustment NewQuantity', $value);
	}

	public function getLineQuantityDifference($value)
	{
		return $this->get('QuantityAdjustment QuantityDifference');
	}

	public function setLineQuantityDifference($value)
	{
		return $this->set('QuantityAdjustment QuantityDifference', $value);
	}

	public function getLineValueQuantity($value)
	{
		return $this->get('ValueAdjustment NewQuantity');
	}

	public function setLineValueQuantity($value)
	{
		return $this->set('ValueAdjustment NewQuantity', $value);
	}

	public function getLineValueNew($value)
	{
		return $this->get('ValueAdjustment NewValue');
	}

	public function setLineValueNew($value)
	{
		return $this->set('ValueAdjustment NewValue', $value);
	}
	/**
	 *
	 *
	 * @return boolean
	 */
	protected function _cleanup()
	{
		return true;
	}

	/**
	 *
	 */
	public function asArray($request, $nest = true)
	{
		$this->_cleanup();

		return parent::asArray($request, $nest);
	}

	public function asXML($root = null, $parent = null, $object = null)
	{
		if (is_null($object))
		{
			$object = $this->_object;
		}
		
		switch ($parent)
		{
			case QUICKBOOKS_ADD_INVENTORYADJUSTMENT:
				$root = 'InventoryAdjustmentLineAdd';
				$parent = null;
				break;
// Currently unimplemented
/*
			case QUICKBOOKS_QUERY_INVENTORYADJUSTMENT:
				$root = 'InventoryAdjustmentLineQuery';
				break;
*/
		}

		return parent::asXML($root, $parent, $object);
	}

	/**
	 * Convert this object to a valid qbXML request
	 *
	 * @param string $request					The type of request to convert this to (examples: CustomerAddRq, CustomerModRq, CustomerQueryRq)
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
	 * Tell what type of object this is
	 *
	 * @return string
	 */
	public function object()
	{
		return "InventoryAdjustmentLine";
	}
}
