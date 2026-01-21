<?php

/**
 * Base class for QuickBooks objects
 * 
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Object
 */

/**
 * QuickBooks XML stuff (we need this for some constants)
 */
QuickBooks_Loader::load('/QuickBooks/XML.php', false);

/**
 * QuickBooks XML parser class
 */
QuickBooks_Loader::load('/QuickBooks/XML/Parser.php');

/**
 * QuickBooks data type casting
 */
QuickBooks_Loader::load('/QuickBooks/Cast.php');

/**
 * Base class for QuickBooks objects
 */
abstract class QuickBooks_QBXML_Object
{
	/**
	 * QuickBooks XML parser option - preserve empty XML elements
	 */
	const XML_PRESERVE = QuickBooks_XML::XML_PRESERVE;
	
	/**
	 * QuickBooks XML parser option - drop empty XML elements
	 */
	const XML_DROP = QuickBooks_XML::XML_DROP;
	
	/**
	 * QuickBooks XML parser option - compress /> empty XML elements
	 */
	const XML_COMPRESS = QuickBooks_XML::XML_COMPRESS;

	/**
	 * Keys/values stored within the object
	 * 
	 * @var array
	 */
	protected $_object = array();
	
	/**
	 * Create a new instance of this QuickBooks class
	 * 
	 * @param array $arr
	 */
	public function __construct($arr)
	{
		$this->_object = $arr; 
	}
	
	/**
	 * Return a constant indicating the type of object
	 * 
	 * @return string
	 */
	abstract public function object();
		
	/**
	 * Get the date/time this object was created in QuickBooks
	 * 
	 * @param string $format		If you want the date/time in a particular format, specify the format here (use the notation from {@link http://www.php.net/date})
	 * @return string
	 */
	public function getTimeCreated($format = null)
	{
		if (!is_null($format))
		{
			return date($format, strtotime($this->get('TimeCreated')));
		}
		
		return $this->get('TimeCreated');
	}

	/** 
	 * Get the date/time when this object was last modified in QuickBooks
	 * 
	 * @param string $format		If you want the date/time in a particular format, specify the format here (use the notation from {@link http://www.php.net/date})
	 * @return string
	 */	
	public function getTimeModified($format = null)
	{
		if (!is_null($format))
		{
			return date($format, strtotime($this->get('TimeModified')));
		}
		
		return $this->get('TimeModified');
	}
	
	public function setEditSequence($value)
	{
		return $this->set('EditSequence', $value);
	}
	
	/**
	 * Get the QuickBooks EditSequence for this object
	 * 
	 * @return integer
	 */
	public function getEditSequence()
	{
		return $this->get('EditSequence');
	}
	
	/**
	 * Set a value within the object
	 * 
	 * @param string $key
	 * @param string $value
	 * @return boolean
	 */
	public function set($key, $value, $cast = true)
	{
		if (is_array($value))
		{
			$this->_object[$key] = $value;
		}
		else
		{
			//print('set(' . $key . ', ' . $value . ', ' . $cast . ')' . "\n");
			
			if ($cast and $value != '__EMPTY__')
			{
				$value = QuickBooks_Cast::cast($this->object(), $key, $value, true, false);
			}
			
			//print('	setting [' . $key . '] to value {' . $value . '}' . "\n");
			
			$this->_object[$key] = $value;
		}
		
		return true;
	}
	
	/**
	 * Get a value from the object
	 * 
	 * @param string $key		The key to fetch the value for
	 * @param mixed $default	If there is no value set for the given key, this will be returned
	 * @return mixed			The value fetched
	 */
	public function get($key, $default = null)
	{
		if (isset($this->_object[$key]))
		{
			return $this->_object[$key];
		}
		
		return $default;
	}
	
	/**
	 * Get a FullName value (where : separates parent and child items)
	 * 
	 * @param string $fullname_key		The key to set, i.e. FullName
	 * @param string $name_key			The 'Name' key, i.e. Name
	 * @param string $parent_key		The parent key, i.e. ParentRef_FullName
	 * @param mixed $default
	 * @return string
	 */
	public function getFullNameType($fullname_key, $name_key, $parent_key, $default = null)
	{
		$fullname = $this->get($fullname_key);
		if (!$fullname)
		{
			$name = $this->get($name_key);
			$parent = $this->get($parent_key);
			
			if ($name and $parent)
			{
				$fullname = $parent . ':' . $name;
			}
			else
			{
				$fullname = $name;
			}
		}
		
		return $fullname;
	}
	
	/**
	 * Set a Name field
	 * 
	 * @param string $name_key
	 * @param string $value
	 * @return void
	 */
	public function setNameType($name_key, $value)
	{
		return $this->set($name_key, str_replace(':', '-', $value));
	}
	
	/**
	 * Set a FullName field
	 * 
	 * @param string $fullname_key
	 * @param string $name_key
	 * @param string $parent_key
	 * @param string $value
	 * @return void
	 */
	public function setFullNameType($fullname_key, $name_key, $parent_key, $value)
	{
		if (false !== strpos($value, ':'))
		{
			if ($name_key and $parent_key)
			{
				// This covers the case where we are setting FullName, which 
				//	needs to be broken up into:
				//		Name
				//		ParentRef FullName
				
				$explode = explode(':', $value);
				$name = end($explode);
				$parent = implode(':', array_slice($explode, 0, -1));
				
				$this->set($name_key, $name);
				$this->set($parent_key, $parent);
				
				// Build the parent name from the newly set Name and ParentRef (need to fetch because they might have been casted/truncate)
				$value = $this->get($parent_key) . ':' . $this->get($name_key);
			}
			else
			{
				// This covers the case where we are setting 
				//	CustomerType_FullName, there is no separate parent element, 
				//	so we just set the whole chunk 
				
				; 
			}
		}
		else
		{
			$this->set($name_key, $value);
			
			// Fetch the Name (need to fetch because they might have been casted/truncate)
			$value = $this->get($name_key);
		}
		
		$this->set($fullname_key, $value);
	}
	
	/**
	 * Set a boolean value
	 * 
	 * @param string $key		
	 * @param mixed $value		
	 * @return boolean			
	 */
	public function setBooleanType($key, $value)
	{
		//print('setting BooleanType [' . $key . '] to ' . $value . "\n");
		
		if ($value == 'true' or $value === 1 or $value === true)
		{
			//print("\t" . ' set to TRUE' . "\n");
			return $this->set($key, 'true');
		}
		
		//print("\t" . ' set to FALSE' . "\n");
		return $this->set($key, 'false');
	}
	
	/**
	 * 
	 * 
	 * @param string $key
	 * @param boolean $default
	 * @return boolean
	 */
	public function getBooleanType($key, $default = null)
	{
		if ($this->exists($key))
		{ 
			$boolean = $this->get($key);
			if (is_bool($boolean))
			{
				return $boolean;
			}
			else if ($boolean == 'false')
			{
				return false;
			}
			else if ($boolean == 'true')
			{
				return true;
			}
		}
		
		return $default == 'true' or $default === 1 or $default === true;
	}
	
	/**
	 * Set a date 
	 * 
	 * @param string $key		The key for where to store the date
	 * @param mixed $date		The date value (accepts anything www.php.net/strtotime can convert or unix timestamps)
	 * @return boolean
	 */
	public function setDateType($key, $date, $dont_allow_19691231 = true)
	{
		if ($date == '1969-12-31' and $dont_allow_19691231)
		{
			return false;
		}
		
		if (!strlen($date) or 
			$date == '0')
		{
			return false;
		}
		
		// 1228241458		vs.		19830102
		//if (ereg('^[[:digit:]]+$', $date) and strlen($date) > 8)
		if (ctype_digit($date) and strlen($date) > 8)
		{
			// It's a unix timestamp (seconds since unix epoch, conver to string)
			$date = date('Y-m-d', $date);
		}
		
		return $this->set($key, date('Y-m-d', strtotime($date)));
	}
	
	/**
	 * Get a date value
	 * 
	 * @param string $key		Get a date value
	 * @param string $format	The format (any format from www.php.net/date)
	 * @return string
	 */
	public function getDateType($key, $format = 'Y-m-d')
	{
		if (!strlen($format))
		{
			$format = 'Y-m-d';
		}
		
		if ($this->exists($key) and $this->get($key))
		{
			return date($format, strtotime($this->get($key)));
		}
		
		return null;
	}
	
	public function setAmountType($key, $amount)
	{
		$this->set($key, sprintf('%01.2f', (float) $amount));
	}
	
	public function getAmountType($key)
	{
		return sprintf('%01.2f', (float) $this->get($key));
	}
	
	/**
	 * Tell if a data field exists within the object
	 * 
	 * @param string $key
	 * @return boolean
	 */
	public function exists($key)
	{
		return isset($this->_object[$key]);
	}
	
	/**
	 * Removes a key from this object
	 * 
	 * @param string $key
	 * @return boolean
	 */
	public function remove($key)
	{
		if (isset($this->_object[$key]))
		{
			unset($this->_object[$key]);
			return true;
		}
		
		return false;
	}
	
	public function getListItem($key, $index)
	{
		$list = $this->getList($key);
		
		if (isset($list[$index]))
		{
			return $list[$index];
		}
		
		return null;
	}
	
	/**
	 * 
	 * 
	 */
	public function addListItem($key, $obj)
	{
		$list = $this->getList($key);
		
		$list[] = $obj;
		
		return $this->set($key, $list);
	}
	
	/**
	 * 
	 */
	public function getList($key)
	{
		$list = $this->get($key, array());
		
		if (!is_array($list))
		{
			$list = array();
		}
		
		return $list;
	}
	
	/**
	 * 
	 */
	public function getArray($pattern, $defaults = array(), $defaults_if_empty = true)
	{
		$list = array();
		foreach ($this->_object as $key => $value)
		{
			if ($this->_fnmatch($pattern, $key))
			{
				$list[$key] = $value;
				
				if ($defaults_if_empty and 
					empty($value) and 
					isset($defaults[$key]))
				{
					$list[$key] = $defaults[$key];
				}
			}
		}
		
		return array_merge($defaults, $list);
	}
	
	/**
	 * Do some fancy string matching
	 * 
	 * @param string $pattern
	 * @param string $str
	 * @return boolean
	 */
	protected function _fnmatch($pattern, $str)
	{
		return QuickBooks_Utilities::fnmatch($pattern, $str);
	}
	
	/**
	 * Get a qbXML schema object for a particular type of request
	 * 
	 * Schema objects are used to build and validate qbXML requests and the 
	 * fields and data types of qbXML elements. 
	 * 
	 * @param string $request		A valid QuickBooks API request (for example: CustomerAddRq, InvoiceQueryRq, CustomerModRq, etc.)
	 * @return QuickBooks_QBXML_Schema_Object
	 */
	protected function _schema($request)
	{
		if (strtolower(substr($request, -2, 2)) != 'rq')
		{
			$request = $request . 'Rq';
		}
		
		$class = 'QuickBooks_QBXML_Schema_Object_' . $request;
		$file = 'QuickBooks/QBXML/Schema/Object/' . $request . '.php';
		
		include_once $file;
		
		if (class_exists($class))
		{
			return new $class();
		}
		
		return false;
	}
	
	/**
	 * Convert this QuickBooks object to an XML node object representation
	 * 
	 * @param string $root			The node to use as the root node of the XML node structure
	 * @param string $parent		
	 * @return QuickBooks_XML_Node
	 */
	public function asXML($root = null, $parent = null, $object = null)
	{
		if (is_null($root))
		{
			$root = $this->object();
		}
		
		if (is_null($object))
		{
			$object = $this->_object;
		}
		
		$Node = new QuickBooks_XML_Node($root);
		
		foreach ($object as $key => $value)
		{
			if (is_array($value))
			{
				$Node->setChildDataAt($root . ' ' . $key, '', true);
				
				foreach ($value as $sub)
				{
					//print('printing sub' . "\n");
					//print_r($sub);
					//print($sub->asXML());
					$Node->addChildAt($root, $sub->asXML(null, $root));
				}
			}
			else 
			{
				$Node->setChildDataAt($root . ' ' . $key, $value, true);
			}
		}
		
		//print_r($Node);
		
		return $Node;
	}
	
	public function asArray($request, $nest = false)
	{
		
	}
	
	protected function _cleanup()
	{
		
	}
	
	/**
	 * Convert this object to a valid qbXML request/response
	 * 
	 * @todo Support for qbXML versions
	 * 
	 * @param boolean $compress_empty_elements
	 * @param string $indent
	 * @param string $root
	 * @return string
	 */
	//public function asQBXML($request, $todo_for_empty_elements = QUICKBOOKS_XML_XML_DROP, $indent = "\t", $root = null)
	public function asQBXML($request, $version = null, $locale = null, $root = null)
	{
		$todo_for_empty_elements = QuickBooks_XML::XML_DROP;
		$indent = "\t";
		
		// Call any cleanup routines
		$this->_cleanup();
		
		// 
		if (strtolower(substr($request, -2, 2)) != 'rq')
		{
			$request .= 'Rq';
		}
		
		$Request = new QuickBooks_XML_Node($request);
		
		if ($schema = $this->_schema($request))
		{
			$tmp = array();
			
			// Restrict it to a specific qbXML version?
			if ($version)
			{
				
			}
			
			// Restrict it to a specific qbXML locale?
			if ($locale)
			{
				// List of fields which are not supported for some versions of qbXML
				
				if (strlen($locale) == 2)
				{
					// The OSR lists locales as 'QBOE', 'QBUK', 'QBCA', etc. vs. our QUICKBOOKS_LOCALE_* constants of just 'OE', 'UK', 'CA', etc.
					$locale = 'QB' . $locale;
				}
				
				$locales = $schema->localePaths();
			}

			$thelist = $this->asList($request);
			$reordered = $schema->reorderPaths(array_keys($thelist));

			foreach ($reordered as $key => $path)
			{
				$value = $this->_object[$path];
				
				if (is_array($value))
				{	
					$tmp[$path] = array();
					
					foreach ($value as $arr)
					{
						$tmp2 = array();
						
						foreach ($arr->asList('') as $inkey => $invalue)
						{
							$arr->set($path . ' ' . $inkey, $invalue);
						}
						
						foreach ($schema->reorderPaths(array_keys($arr->asList(''))) as $subkey => $subpath)
						{
							// We need this later, so store it
							$fullpath = $subpath;
							
							if ($locale and 
								isset($locales[$subpath]))
							{
								if (in_array($locale, $locales[$subpath]))
								{
									// 
									//print('found: ' . $subpath . ' (' . $locale . ') so skipping!' . "\n");
								}
								else
								{
									$subpath = substr($subpath, strlen($path) + 1);
									$tmp2[$subpath] = $arr->get($subpath);									
								}
							}
							else
							{
								$subpath = substr($subpath, strlen($path) + 1);
								$tmp2[$subpath] = $arr->get($subpath);								
							}
							
							if ($schema->dataType($fullpath) == QUICKBOOKS_QBXML_SCHEMA_TYPE_AMTTYPE and 
								isset($tmp2[$subpath]))
							{
								$tmp2[$subpath] = sprintf('%01.2f', $tmp2[$subpath]);
							}
						}
						
						$tmp2 = new QuickBooks_QBXML_Object_Generic($tmp2, $arr->object());
						
						$tmp[$path][] = $tmp2;
					}
				}
				else
				{
					// Do some simple data type casting... 
					if ($schema->dataType($path) == QUICKBOOKS_QBXML_SCHEMA_TYPE_AMTTYPE)
					{
						$this->_object[$path] = sprintf('%01.2f', $this->_object[$path]);
					}
					
					if ($locale and 				// If a locale is specified...
						isset($locales[$path]))		// ... and this path is set in the locales restriction array
					{
						// Check to see if it's supported by the given locale
						
						if (in_array($locale, $locales[$path]))
						{
							// It's not supported by this locale, don't show add it
						}
						else
						{
							$tmp[$path] = $this->_object[$path];
						}
					}
					else
					{
						// If we don't know whether or not it's supported, return it!
							
						$tmp[$path] = $this->_object[$path];
					}
				}
			}
			
			// *DO NOT* change the source values of the original object! 
			//$this->_object = $tmp;
			
			if ($wrapper = $schema->qbxmlWrapper())
			{
				
				$Node = $this->asXML($wrapper, null, $tmp);
				$Request->addChild($Node);
				
				return $Request->asXML($todo_for_empty_elements, $indent);
			}
			else if (count($this->_object) == 0)
			{
				// This catches the cases where we just want to get *all* objects 
				//	back (no filters) and thus the root level qbXML element is *empty* 
				//	and we need to *preserve* this empty element rather than just 
				//	drop it (which results in an empty string, and thus invalid query)
				
				$Node = $this->asXML($request, null, $tmp);
				
				return $Node->asXML(QuickBooks_XML::XML_PRESERVE, $indent);
			}
			else
			{
				$Node = $this->asXML($request, null, $tmp);
				
				return $Node->asXML($todo_for_empty_elements, $indent);
			}
		}
		
		return '';
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public function asList($request)
	{
		$arr = $this->_object;
		$object = $this->object();
		
		/*
		foreach ($arr as $key => $value)
		{
			$arr[$key] = QuickBooks_Cast::cast($object, $key, $value);
		}
		*/
		
		return $arr;
	}

	/**
	 * 
	 * 
	 */
	static protected function _fromXMLHelper($class, $XML)
	{
		if (is_object($XML))
		{
			$paths = $XML->asArray(QuickBooks_XML::ARRAY_PATHS);
			foreach ($paths as $path => $value)
			{
				$newpath = implode(' ', array_slice(explode(' ', $path), 1));
				$paths[$newpath] = $value;
				unset($paths[$path]);
			}
			
			return new $class($paths);		
		}
		
		return null;
	}
	
	/**
	 * Convert a QuickBooks_XML_Node object to a QuickBooks_Object_* object instance 
	 * 
	 * @param QuickBooks_XML_Node $XML
	 * @param string $action_or_object
	 * @return QuickBooks_Object
	 */
	static public function fromXML($XML, $action_or_object = null)
	{		
		if (!$action_or_object or $action_or_object == QUICKBOOKS_QUERY_ITEM)
		{
			$action_or_object = $XML->name();
		}
		
		$type = QuickBooks_Utilities::actionToObject($action_or_object);
		
		$exceptions = array(
			QUICKBOOKS_OBJECT_SERVICEITEM => 'ServiceItem', 
			QUICKBOOKS_OBJECT_INVENTORYITEM => 'InventoryItem', 
			QUICKBOOKS_OBJECT_NONINVENTORYITEM => 'NonInventoryItem', 
			QUICKBOOKS_OBJECT_DISCOUNTITEM => 'DiscountItem', 
			QUICKBOOKS_OBJECT_FIXEDASSETITEM => 'FixedAssetItem', 
			QUICKBOOKS_OBJECT_GROUPITEM => 'GroupItem', 
			QUICKBOOKS_OBJECT_OTHERCHARGEITEM => 'OtherChargeItem', 
			QUICKBOOKS_OBJECT_SALESTAXITEM => 'SalesTaxItem', 
			QUICKBOOKS_OBJECT_SALESTAXGROUPITEM => 'SalesTaxGroupItem', 
			QUICKBOOKS_OBJECT_SUBTOTALITEM => 'SubtotalItem', 
			QUICKBOOKS_OBJECT_INVENTORYASSEMBLYITEM => 'InventoryAssemblyItem', 
			);
		
		if (isset($exceptions[$type]))
		{
			$type = $exceptions[$type];
		}
		
		//print('trying to create type: {' . $type . '}' . "\n");
		
		$class = 'QuickBooks_QBXML_Object_' . ucfirst(strtolower($type));
		
		if (true) 		//class_exists($class, false))
		{
			$Object = QuickBooks_QBXML_Object::_fromXMLHelper($class, $XML);
			
			if (!is_object($Object))
			{
				return false;
			}
			
			$children = array();
			switch ($Object->object())
			{
				case QUICKBOOKS_OBJECT_RECEIVEPAYMENT:

					$children = array(
						'AppliedToTxnRet' => array( 'QuickBooks_QBXML_Object_ReceivePayment_AppliedToTxn', 'addAppliedToTxn' ),
						);

					break;
				case QUICKBOOKS_OBJECT_BILL:
					
					$children = array(
						'ItemLineRet' => array( 'QuickBooks_QBXML_Object_Bill_ItemLine', 'addItemLine' ), 
						'ExpenseLineRet' => array( 'QuickBooks_QBXML_Object_Bill_ExpenseLine', 'addExpenseLine' ), 
						);					
					
					break;
				case QUICKBOOKS_OBJECT_PURCHASEORDER:
					
					$children = array(
						'PurchaseOrderLineRet' => array( 'QuickBooks_QBXML_Object_PurchaseOrder_PurchaseOrderLine', 'addPurchaseOrderLine' ), 
						);
					
					break;
				case QUICKBOOKS_OBJECT_INVOICE:
					
					$children = array( 
						'InvoiceLineRet' => array( 'QuickBooks_QBXML_Object_Invoice_InvoiceLine', 'addInvoiceLine' ), 
						);
					
					break;
				case QUICKBOOKS_OBJECT_ESTIMATE:
					
					$children = array( 
						'EstimateLineRet' => array( 'QuickBooks_QBXML_Object_Estimate_EstimateLine', 'addEstimateLine' ), 
						);					
					
					break;
				case QUICKBOOKS_OBJECT_SALESRECEIPT:
					
					$children = array( 
						'SalesReceiptLineRet' => array( 'QuickBooks_QBXML_Object_SalesReceipt_SalesReceiptLine', 'addSalesReceiptLine' ), 
						);					
					
					break;
				case QUICKBOOKS_OBJECT_JOURNALENTRY:
					
					$children = array(
						'JournalCreditLineRet' => array( 'QuickBooks_QBXML_Object_JournalEntry_JournalCreditLine', 'addCreditLine' ), 
						'JournalDebitLineRet' => array( 'QuickBooks_QBXML_Object_JournalEntry_JournalDebitLine', 'addDebitLine' ), 
						);
					
					break;
				case QUICKBOOKS_OBJECT_SALESTAXGROUPITEM:
					
					$children = array(
						'ItemSalesTaxRef' => array( 'QuickBooks_QBXML_Object_SalesTaxGroupItem_ItemSalesTaxRef', 'addItemSalesTaxRef' ), 
						);
					
					break;
				case QUICKBOOKS_OBJECT_UNITOFMEASURESET:
					
					$children = array(
						'RelatedUnit' => array( 'QuickBooks_QBXML_Object_UnitOfMeasureSet_RelatedUnit', 'addRelatedUnit' ), 
						'DefaultUnit' => array( 'QuickBooks_QBXML_Object_UnitOfMeasureSet_DefaultUnit', 'addDefaultUnit' ), 
						);
					
					break;
			}
			
			foreach ($children as $node => $tmp)
			{
				$childclass = $tmp[0];
				$childmethod = $tmp[1];
				
				if (class_exists($childclass))
				{
					foreach ($XML->children() as $ChildXML)
					{
						if ($ChildXML->name() == $node)
						{
							$ChildObject = QuickBooks_QBXML_Object::_fromXMLHelper($childclass, $ChildXML);
							$Object->$childmethod($ChildObject);			
						}	
					}
				}
				else
				{
					print('Missing class: ' . $childclass . "\n");
				}
			}
			
			return $Object;
		}
		
		return false;		
	}
	
	/**
	 * Convert a qbXML string to a QuickBooks_Object_* object instance
	 * 
	 * @param string $qbxml
	 * @param string $action_or_object
	 * @return QuickBooks_Object
	 */
	static public function fromQBXML($qbxml, $action_or_object = null)
	{
		$errnum = null;
		$errmsg = null;
		
		$Parser = new QuickBooks_XML_Parser($qbxml);
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			$XML = $Doc->getRoot();
			
			return QuickBooks_QBXML_Object::fromXML($XML, $action_or_object);
		}
		
		return false;
	}
}
