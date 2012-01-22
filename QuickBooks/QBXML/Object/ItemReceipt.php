<?php

/**
 * QuickBooks ReceiptItem object container
 *
 * @todo Add and verify the Mod schema
 * @todo Documentation
 * @todo Explain in documentation about how to use LinkToTxnID
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
 * Expense lines for ReceiptItems
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/ItemReceipt/ExpenseLine.php');
/**
 * ItemLine lines for ReceiptItems
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/ItemReceipt/ItemLine.php');
/**
 * ItemGroup lines for ReceiptItems
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/ItemReceipt/ItemGroupLine.php');

/**
 * Quickbooks ReceiptItem definition
 */
class QuickBooks_QBXML_Object_ItemReceipt extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks ReceiptItem object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	/**
	 * Gets the Vendor ListID
	 */
	public function getVendorListID()
	{
		return $this->get('VendorRef ListID');
	}

	/**
	 * Set the Vendor ListID
	 *
	 * @param string ListID
	 * @return boolean
	 */
	public function setVendorListID($value)
	{
		return $this->set('VendorRef ListID', $value);
	}

	/**
	 * Gets the Vendor Name
	 */
	public function getVendorName()
	{
		return $this->get('VendorRef FullName');
	}

	/**
	 * Set the Vendor Name
	 *
	 * @param string name
	 * @return boolean
	 */
	public function setVendorName($value)
	{
		return $this->set('VendorRef FullName', $value);
	}

	/**
	 * Gets the Account ListID
	 */
	public function getAPAccountListID()
	{
		return $this->get('APAccountRef ListID');
	}

	/**
	 * Set the Account ListID
	 *
	 * @param string ListID
	 * @return boolean
	 */
	public function setAPAccountListID($value)
	{
		return $this->set('APAccountRef ListID', $value);
	}

	/**
	 * Gets the Account Name
	 */
	public function getAPAccountName()
	{
		return $this->get('APAccountRef FullName');
	}

	/**
	 * Set the account Name
	 *
	 * @param string name
	 * @return boolean
	 */
	public function setAPAccountName($value)
	{
		return $this->set('APAccountRef FullName', $value);
	}

	/**
	 * Gets the transaction date
	 */
	public function getTxnDate()
	{
		return $this->get('TxnDate');
	}

	/**
	 * Set the transaction date
	 *
	 * @param string
	 * @return boolean
	 */
	public function setTxnDate($value)
	{
		return $this->set('TxnDate', $value);
	}

	/**
	 * Gets the RefNumber
	 */
	public function getRefNumber()
	{
		return $this->get('RefNumber');
	}

	/**
	 * Set the RefNumber
	 *
	 * @return boolean
	 */
	public function setRefNumber($value)
	{
		return $this->set('RefNumber', $value);
	}

	/**
	 * Gets the Memo
	 */
	public function getMemo()
	{
		return $this->get('Memo');
	}

	/**
	 * Set the Memo
	 *
	 * @param string
	 * @return boolean
	 */
	public function setMemo($value)
	{
		return $this->set('Memo', $value);
	}

	// In the 8.0 SDK...
	/**
	 * Gets the Exchange Rate
	 */
	/*
	public function getExchangeRate()
	{
		return $this->get('ExchangeRate');
	}
	*/
	/**
	 * Set the Exchange Rate
	 *
	 * @param float $rate
	 * @return boolean
	 */
	/*
	public function setExchangeRate($rate)
	{
		return $this->set('ExchangeRate', $rate);
	}
	*/

	/**
	 * Gets the LinkToTxnID
	 */
	public function getLinkToTxnIDList()
	{
		return $this->get('LinkToTxnIDList');
	}

	/**
	 * Sets the LinksToTxnID
	 * @param string $TxnID
	 */
	public function setLinkToTxnIDList($TxnIDs)
	{
		return $this->set('LinkToTxnIDList', $TxnIDs);
	}

	public function addItemLine($obj)
	{
		return $this->addListItem('ItemLine', $obj);
	}

	public function addItemGroupLine($obj)
	{
		return $this->addListItem('ItemGroupLine', $obj);
	}
	
	public function addExpenseLine($obj)
	{
		return $this->addListItem('ExpenseLine', $obj);
	}

	/**
	 * Gets the ExpenseLine at @param $i
	 *
	 * @param $i a number between 0 and added Lines-1
	 */
	public function getExpenseLine($i)
	{
		return $this->getListItem('ExpenseLine', $i);
	}

	/**
	 * Gets a list of all Expense Lines
	 */
	public function getExpenseLines()
	{
		return $this->getList('ExpenseLine');
	}

	/**
	 * Gets the ItemLine at @param $i
	 *
	 * @param $i a number between 0 and added Lines-1
	 */
	public function getItemLine($i)
	{
		return $this->getListItem('ItemLine', $i);
	}

	/**
	 * Gets a list of all Item Lines
	 */
	public function getItemLines()
	{
		return $this->getList('ItemLine');
	}
	
	/**
	 * Gets the ItemGroupLine at @param $i
	 *
	 * @param $i a number between 0 and added Lines-1
	 */
	public function getItemGroupLine($i)
	{
		return $this->getListItem('ItemGroupLine', $i);
	}

	/**
	 * Gets a list of all ItemGroup Lines
	 */
	public function getItemGroupLines()
	{
		return $this->getList('ItemGroupLine');
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

	public function asList($request)
	{
		switch ($request)
		{
			case QUICKBOOKS_ADD_RECEIPTITEM . 'Rq':
				if (isset($this->_object['ItemLine']))
				{
					$this->_object['ItemLineAdd'] = $this->_object['ItemLine'];
				}
				if (isset($this->_object['ItemGroupLine']))
				{
					$this->_object['ItemGroupLineAdd'] = $this->_object['ItemGroupLine'];
				}
				if (isset($this->_object['ExpenseLine']))
				{
					$this->_object['ExpenseLineAdd'] = $this->_object['ExpenseLine'];
				}
				break;

			case QUICKBOOKS_MOD_RECEIPTITEM . 'Rq':
				if (isset($this->_object['ItemLine']))
				{
					$this->_object['ItemLineMod'] = $this->_object['ItemLine'];
				}
				if (isset($this->_object['ItemGroupLine']))
				{
					$this->_object['ItemGroupLineMod'] = $this->_object['ItemGroupLine'];
				}
				if (isset($this->_object['ExpenseLine']))
				{
					$this->_object['ExpenseLineMod'] = $this->_object['ExpenseLine'];
				}
				break;

			case QUICKBOOKS_QUERY_RECEIPTITEM . 'Rq':
				if (isset($this->_object['ItemLine']))
				{
					$this->_object['ItemLineQuery'] = $this->_object['ItemLine'];
				}
				if (isset($this->_object['ItemGroupLine']))
				{
					$this->_object['ItemGroupLineQuery'] = $this->_object['ItemGroupLine'];
				}
				if (isset($this->_object['ExpenseLIne']))
				{
					$this->_object['ExpenseLineQuery'] = $this->_object['ExpenseLine'];
				}
				break;
		}

		return parent::asList($request);
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
		
		switch ($root)
		{
			case QUICKBOOKS_ADD_RECEIPTITEM:
				if (isset($object['ItemLineAdd']))
				{
					foreach ($object['ItemLineAdd'] as $key => $obj)
					{
						$obj->setOverride('ItemLineAdd');
					}
				}
				if (isset($object['ItemGroupLineAdd']))
				{
					foreach ($object['ItemGroupLineAdd'] as $key => $obj)
					{
						$obj->setOverride('ItemGroupLineAdd');
					}
				}
				if (isset($object['ExpenseLineAdd']))
				{
					foreach ($object['ExpenseLineAdd'] as $key => $obj)
					{
						$obj->setOverride('ExpenseLineAdd');
					}
				}
				break;
			// For possible future use...
			/*
			case QUICKBOOKS_QUERY_RECEIPTITEM:
				if (isset($this->_object['ItemLineAdd']))
				{
					foreach ($this->_object['ItemLineQuery'] as $key => $obj)
					{
						$obj->setOverride('ItemLineQuery');
					}
				}
				if (isset($this->_object['ItemGroupLineAdd']))
				{
					foreach ($this->_object['ItemGroupQuery'] as $key => $obj)
					{
						$obj->setOverride('ItemGroupQuery');
					}
				}
				if (isset($this->_object['ExpenseLineAdd']))
				{
					foreach ($this->_object['ExpenseLineQuery'] as $key => $obj)
					{
						$obj->setOverride('ExpenseLineQuery');
					}
				}
				break;
			*/
			case QUICKBOOKS_MOD_RECEIPTITEM:
				if (isset($object['ItemLineAdd']))
				{
					foreach ($object['ItemLineMod'] as $key => $obj)
					{
						$obj->setOverride('ItemLineMod');
					}
				}
				if (isset($object['ItemGroupLineAdd']))
				{
					foreach ($object['ItemGroupMod'] as $key => $obj)
					{
						$obj->setOverride('ItemGroupMod');
					}
				}
				if (isset($object['ExpenseLineAdd']))
				{
					foreach ($object['ExpenseLineMod'] as $key => $obj)
					{
						$obj->setOverride('ExpenseLineMod');
					}
				}
				break;
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
		return QUICKBOOKS_OBJECT_RECEIPTITEM;
	}
}

