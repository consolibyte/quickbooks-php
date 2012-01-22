<?php 

/**
 * Bill class for QuickBooks 
 * 
 * @author Keith Palmer Jr. <keith@ConsoliBYTE.com>
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
 *
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Bill/ItemLine.php');

/**
 *
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Bill/ExpenseLine.php');

/**
 * 
 */
class QuickBooks_QBXML_Object_Bill extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_JournalEntry object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	/**
	 * Set the customer ListID
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setVendorListID($ListID)
	{
		return $this->set('VendorRef ListID' , $ListID);
	}
	
	/**
	 * Set the customer ApplicationID (auto-replaced by the API with a ListID)
	 * 
	 * @param mixed $value
	 * @return boolean
	 */
	public function setVendorApplicationID($value)
	{
		return $this->set('VendorRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_VENDOR, QUICKBOOKS_LISTID, $value));
	}
	
	/**
	 * Set the customer name
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setVendorFullname($name)
	{
		return $this->set('VendorRef FullName', $name);
	}
	
	/**
	 * Get the customer ListID
	 * 
	 * @return string
	 */
	public function getVendorListID()
	{
		return $this->get('VendorRef ListID');
	}

	/**
	 * Get the customer application ID
	 * 
	 * @return mixed
	 */
	public function getVendorApplicationID()
	{
		return $this->extractApplicationID($this->get('VendorRef ' . QUICKBOOKS_API_APPLICATIONID));
	}

	// Path: TxnDate, datatype: DATETYPE
	
	/**
	 * Set the TxnDate for the JournalEntry
	 * 
	 * @param string $date
	 * @return boolean
	 */
	public function setTxnDate($date)
	{
		return $this->setDateType('TxnDate', $date);
	}

	/**
	 * Get the TxnDate for the JournalEntry
	 * 
	 * @param ? $format = null
	 * @return string
	 */
	public function getTxnDate($format = null)
	{
		return $this->getDateType('TxnDate', $format);
	}

	/**
	 * @see QuickBooks_Object_JournalEntry::setTxnDate()
	 */
	public function setTransactionDate($date)
	{
		return $this->setTxnDate($date); 
	}

	/**
	 * @see QuickBooks_Object_JournalEntry::getTxnDate()
	 */
	public function getTransactionDate($format = null)
	{
		$this->getTxnDate($format = null);
	}
	// Path: RefNumber, datatype: STRTYPE
	
	public function setDueDate($date)
	{
		return $this->setDateType('DueDate', $date);
	}
	
	public function getDueDate($format = 'Y-m-d')
	{
		return $this->getDateType('DueDate', $format);
	}
	
	/**
	 * Set the RefNumber for the JournalEntry
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setRefNumber($value)
	{
		return $this->set('RefNumber', $value);
	}

	/**
	 * Get the RefNumber for the JournalEntry
	 * 
	 * @return string
	 */
	public function getRefNumber()
	{
		return $this->get('RefNumber');
	}

	// Path: Memo, datatype: STRTYPE
	
	/**
	 * Set the Memo for the JournalEntry
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setMemo($value)
	{
		return $this->set('Memo', $value);
	}

	/**
	 * Get the Memo for the JournalEntry
	 * 
	 * @return string
	 */
	public function getMemo()
	{
		return $this->get('Memo');
	}
	
	public function addExpenseLine($obj)
	{
		return $this->addListItem('ExpenseLine', $obj);
	}
	
	public function addItemLine($obj)
	{
		return $this->addListItem('ItemLine', $obj);	
	}
	
	
	public function asList($request)
	{
		switch ($request)
		{
			case 'BillAddRq':
				
				if (isset($this->_object['ItemLine']))
				{
					$this->_object['ItemLineAdd'] = $this->_object['ItemLine'];
				}
				
				if (isset($this->_object['ExpenseLine']))
				{
					$this->_object['ExpenseLineAdd'] = $this->_object['ExpenseLine'];
				}
				
				break;
			case 'BillModRq':
				
				
				break;
		}
		
		return parent::asList($request);
	}

	public function asXML($root = null, $parent = null, $object = null)
	{
		if (is_null($object))
		{
			$object = $this->_object;
		}
		
		switch ($root)
		{
			case QUICKBOOKS_ADD_BILL:
				
				if (!empty($object['ItemLineAdd']))
				{
					foreach ($object['ItemLineAdd'] as $key => $obj)
					{
						$obj->setOverride('ItemLineAdd');
					}
				}
				
				if (!empty($object['ExpenseLineAdd']))
				{
					foreach ($object['ExpenseLineAdd'] as $key => $obj)
					{
						$obj->setOverride('ExpenseLineAdd');
					}				
				}
					
				break;
			case QUICKBOOKS_MOD_BILL:
				
				if (!empty($object['ItemLineMod']))
				{
					foreach ($object['ItemLineMod'] as $key => $obj)
					{
						$obj->setOverride('ItemLineMod');
					}
				}
				
				if (!empty($object['ExpenseLineMod']))
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
	 * Tell the type of object this is
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_BILL;
	}		
}

