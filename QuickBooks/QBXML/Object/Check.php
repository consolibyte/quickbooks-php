<?php 

/**
 * Check class for QuickBooks 
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
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Check/ExpenseLine.php');

/**
 *
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Check/ItemLine.php');

/**
 *
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Check/ItemGroupLine.php');

/**
 *
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Check/ApplyCheckToTxn.php');

/**
 * 
 */
class QuickBooks_QBXML_Object_Check extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Check object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	// Path: AccountRef ListID, datatype: 
	
	/**
	 * Set the AccountRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setAccountListID($ListID)
	{
		return $this->set('AccountRef ListID', $ListID);
	}

	/**
	 * Get the AccountRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getAccountListID()
	{
		return $this->get('AccountRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setAccountApplicationID($value)
	{
		return $this->set('AccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getAccountApplicationID()
	{
		return $this->get('AccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}

	// Path: AccountRef FullName, datatype: 
	
	/**
	 * Set the AccountRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setAccountName($FullName)
	{
		return $this->set('AccountRef FullName', $FullName);
	}

	/**
	 * Get the AccountRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getAccountName()
	{
		return $this->get('AccountRef FullName');
	}

	// Path: PayeeEntityRef ListID, datatype: 
	
	/**
	 * Set the PayeeEntityRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setPayeeEntityListID($ListID)
	{
		return $this->set('PayeeEntityRef ListID', $ListID);
	}

	/**
	 * Get the PayeeEntityRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getPayeeEntityListID()
	{
		return $this->get('PayeeEntityRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setPayeeEntityApplicationID($value)
	{
		return $this->set('PayeeEntityRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_PAYEEENTITY, QUICKBOOKS_LISTID, $value));
	}

	public function getPayeeEntityApplicationID()
	{
		return $this->get('PayeeEntityRef ' . QUICKBOOKS_API_APPLICATIONID);
	}

	// Path: PayeeEntityRef FullName, datatype: 
	
	/**
	 * Set the PayeeEntityRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setPayeeEntityFullName($FullName)
	{
		return $this->set('PayeeEntityRef FullName', $FullName);
	}

	/**
	 * Get the PayeeEntityRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getPayeeEntityFullName()
	{
		return $this->get('PayeeEntityRef FullName');
	}

	// Path: RefNumber, datatype: STRTYPE
	
	/**
	 * Set the RefNumber for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setRefNumber($value)
	{
		return $this->set('RefNumber', $value);
	}

	/**
	 * Get the RefNumber for the Check
	 * 
	 * @return string
	 */
	public function getRefNumber()
	{
		return $this->get('RefNumber');
	}

	// Path: TxnDate, datatype: DATETYPE
	
	/**
	 * Set the TxnDate for the Check
	 * 
	 * @param string $date
	 * @return boolean
	 */
	public function setTxnDate($date)
	{
		return $this->setDateType('TxnDate', $date);
	}

	/**
	 * Get the TxnDate for the Check
	 * 
	 * @param ? $format = null
	 * @return string
	 */
	public function getTxnDate($format = null)
	{
		return $this->getDateType('TxnDate', $format);
	}

	/**
	 * @see QuickBooks_Object_Check::setTxnDate()
	 */
	public function setTransactionDate($date)
	{
		return $this->setTxnDate($date); 
	}

	/**
	 * @see QuickBooks_Object_Check::getTxnDate()
	 */
	public function getTransactionDate($format = null)
	{
		return $this->getTxnDate($format = null);
	}
	// Path: Memo, datatype: STRTYPE
	
	/**
	 * Set the Memo for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setMemo($value)
	{
		return $this->set('Memo', $value);
	}

	/**
	 * Get the Memo for the Check
	 * 
	 * @return string
	 */
	public function getMemo()
	{
		return $this->get('Memo');
	}

	// Path: IsToBePrinted, datatype: BOOLTYPE
	
	/**
	 * Set the IsToBePrinted for the Check
	 * 
	 * @param boolean $bool
	 * @return boolean
	 */
	public function setIsToBePrinted($bool)
	{
		return $this->setBooleanType('IsToBePrinted', $bool);
	}

	/**
	 * Get the IsToBePrinted for the Check
	 * 
	 * @return boolean
	 */
	public function getIsToBePrinted()
	{
		return $this->getBooleanType('IsToBePrinted');
	}

	// Path: IsTaxIncluded, datatype: BOOLTYPE
	
	/**
	 * Set the IsTaxIncluded for the Check
	 * 
	 * @param boolean $bool
	 * @return boolean
	 */
	public function setIsTaxIncluded($bool)
	{
		return $this->setBooleanType('IsTaxIncluded', $bool);
	}

	/**
	 * Get the IsTaxIncluded for the Check
	 * 
	 * @return boolean
	 */
	public function getIsTaxIncluded()
	{
		return $this->getBooleanType('IsTaxIncluded');
	}

	// Path: SalesTaxCodeRef ListID, datatype: 
	
	/**
	 * Set the SalesTaxCodeRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setSalesTaxCodeListID($ListID)
	{
		return $this->set('SalesTaxCodeRef ListID', $ListID);
	}

	/**
	 * Get the SalesTaxCodeRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getSalesTaxCodeListID()
	{
		return $this->get('SalesTaxCodeRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setSalesTaxCodeApplicationID($value)
	{
		return $this->set('SalesTaxCodeRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_SALESTAXCODE, QUICKBOOKS_LISTID, $value));
	}

	public function getSalesTaxCodeApplicationID()
	{
		return $this->get('SalesTaxCodeRef ' . QUICKBOOKS_API_APPLICATIONID);
	}

	// Path: SalesTaxCodeRef FullName, datatype: 
	
	/**
	 * Set the SalesTaxCodeRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setSalesTaxCodeName($FullName)
	{
		return $this->set('SalesTaxCodeRef FullName', $FullName);
	}

	/**
	 * Get the SalesTaxCodeRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getSalesTaxCodeName()
	{
		return $this->get('SalesTaxCodeRef FullName');
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
	
	public function addAddCheckToTxn($obj)
	{
		return $this->addListItem('AddCheckToTxn', $obj);
	}
	
	public function asList($request)
	{
		switch ($request)
		{
			case 'CheckAddRq':
				
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
				
				if (isset($this->_object['AddCheckToTxn']))
				{
					$this->_object['AddCheckToTxnAdd'] = $this->_object['AddCheckToTxn'];
				}
				
				break;
			case 'CheckModRq':
				
				
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
			case QUICKBOOKS_ADD_CHECK:
				
				if (!empty($object['ItemLineAdd']))
				{
					foreach ($object['ItemLineAdd'] as $key => $obj)
					{
						$obj->setOverride('ItemLineAdd');
					}
				}

				if (!empty($object['ItemGroupLineAdd']))
				{
					foreach ($object['ItemGroupLineAdd'] as $key => $obj)
					{
						$obj->setOverride('ItemGroupLineAdd');
					}				
				}
				
				if (!empty($object['ExpenseLineAdd']))
				{
					foreach ($object['ExpenseLineAdd'] as $key => $obj)
					{
						$obj->setOverride('ExpenseLineAdd');
					}
				}
				
				if (!empty($object['ApplyCheckToTxnAdd']))
				{
					foreach ($object['ApplyCheckToTxnAdd'] as $key => $obj)
					{
						$obj->setOverride('ApplyCheckToTxnAdd');
					}			
				}
				
				break;
			case QUICKBOOKS_MOD_CHECK:
				if (isset($object['ItemLine']))
				{
					$object['ItemLineMod'] = $object['ItemLine'];
				}
				break;
		}
		
		return parent::asXML($root, $parent, $object);
	}
	
	/**
	 * 
	 */
	public function asArray($request, $nest = true)
	{
		$this->_cleanup();
		return parent::asArray($request, $nest);
	}
	
	/**
	 * 
	 * 
	 * @param boolean $todo_for_empty_elements	A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE
	 * @param string $indent
	 * @param string $root
	 * @return string
	 */
	public function asQBXML($request, $todo_for_empty_elements = QuickBooks_QBXML_Object::XML_DROP, $indent = "\t", $root = null, $parent = null)
	{
		$this->_cleanup();
		return parent::asQBXML($request, $todo_for_empty_elements, $indent, $root);
	}
	
	/**
	 *
	 */
	protected function _cleanup()
	{
		
	}
	
	/**
	 * Tell what type of object this is 
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_CHECK;
	}	
}

