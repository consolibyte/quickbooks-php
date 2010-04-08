<?php

/**
 * QuickBooks Web Connector API source
 *  
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage API
 */

/**
 * API source base class (web connector source, online edition source, COM source, etc.)
 */
QuickBooks_Loader::load('/QuickBooks/API/Source.php');

/**
 * 
 */
define('QUICKBOOKS_API_SOURCE_WEB_ACTION', 'APISourceWebAction');

/**
 * 
 */
class QuickBooks_API_Source_Web extends QuickBooks_API_Source
{
	/**
	 * The QuickBooks back-end driver object
	 * @var QuickBooks_Driver
	 */
	protected $_driver;
	
	/**
	 * The username of the Web Connector user
	 * @var string
	 */
	protected $_user;
	
	/**
	 * Configuration variables
	 * @var array
	 */
	protected $_config;
	
	protected $_qbxml_version;
	
	protected $_qbxml_locale;
	
	/**
	 * 
	 * 
	 */
	public function __construct(&$driver_obj, $user, $dsn, $options = array())
	{
		$this->_driver = $driver_obj;
		$this->_user = $user;
		
		$this->_config = $this->_defaults($options);
		
		//$this->_qbxml_version = null;
		//$this->_qbxml_locale = null;
		
		$this->_qbXMLLocale($this->_config['qbxml_locale']);
		$this->_qbXMLVersion($this->_config['qbxml_version']);
		
		// This particular 'source' uses the same database connection/DSN as 
		//	the driver, so there's no real reason to pull the user from 
		//	elsewhere... 
	}
	
	/**
	 * Merge configuration options with the default configuration options
	 * 
	 * @param array $options
	 * @return array
	 */
	protected function _defaults($options)
	{
		$defaults = array(
			'qbxml_version' => '{$version}', 
			'qbxml_onerror' => '{$onerror}', 
			'qbxml_locale' => QUICKBOOKS_LOCALE_US, 
			'always_use_iterator' => false, 
			);
		
		return array_merge($defaults, $options);
	}
	
	/**
	 * 
	 * 
	 * @param string $xml
	 * @param string $version
	 * @param string $onerror
	 * @return string
	 */
	protected function _makeValidQBXML($xml, $version = '{$version}', $locale = '{$locale}', $onerror = '{$onerror}')
	{
		$pre = '<?xml version="1.0" encoding="utf-8"?>
			<?qbxml version="' . $version . '"?>
			<QBXML>
				<QBXMLMsgsRq onError="' . $onerror . '">';
		
		$post = '</QBXMLMsgsRq>
			</QBXML>';
		
		/*
		$pos_starttag = strpos($xml, '<');
		$pos_endtag = strpos($xml, '>');
		
		if ($pos_starttag >= 0 and $pos_endtag > $pos_starttag)
		{
			$tag = substr($xml, $pos_starttag + 1, $pos_endtag - $pos_starttag - 1);
			
			$pre .= '<' . $tag . 'Rq>';
			$post = '</' . $tag . 'Rq>' . $post;
			
			if (false !== strpos($xml, '<' . $tag . 'Rq'))
			{
				$pre = '';
				$post = '';
			}
		} 
		*/
		
		return $pre . $xml . $post;
	}

	/**
	 * Set the connection ticket (the Web Connector has no notion of connection tickets, so this does nothing!)
	 * 
	 * @return void
	 */
	protected function _connectionTicket($cticket)
	{
		return null;
	}

	/**
	 * Set the framework ticket (due to the non-real-time nature of the Web Connector, this does nothing!)
	 *
	 * @return void
	 */
	protected function _frameworkTicket($lticket)
	{
		return null;
	}
	
	/**
	 * Set the session ticket (due to the non-real-time nature of the Web Connector, this does nothing!)
	 * 
	 * @return void
	 */
	protected function _sessionTicket($sticket)
	{
		return null;
	}
	
	/**
	 * Set the application ID (the Web Connector has no notion of application IDs, so this does nothing!)
	 * 
	 * @return void
	 */
	protected function _applicationID($appid)
	{
		return null;
	}
	
	/**
	 * Set the application login (the Web Connector has no notion of application logins, so this does nothing!)
	 * 
	 * @return void
	 */
	protected function _applicationLogin($login)
	{
		return null;
	}
	
	protected function _qbXMLVersion($version = null)
	{
		$current = $this->_qbxml_version;
		
		if ($version)
		{
			$this->_qbxml_version = $version;
		}
		
		return $current;
	}
	
	protected function _qbXMLLocale($locale = null)
	{
		$current = $this->_qbxml_locale;
		
		if ($locale)
		{
			$this->_qbxml_locale = $locale;
		}
		
		return $current;
	}	
	
	public function useLiveEnvironment($yes_or_no)
	{
		return false;
	}
	
	public function useTestEnvironment($yes_or_no)
	{
		return false;
	}
	
	public function useDebugMode($yes_or_no)
	{
		return false;	
	}
	
	/**
	 * 
	 * 
	 * @param string $method
	 * @param string $action
	 * @param string $type
	 * @param QuickBooks_Object $object
	 * @param array $callbacks
	 * @param integer $webapp_ID
	 * @param integer $priority
	 * @param string $err
	 * @param integer $recur
	 * @return boolean
	 */
	public function handleObject($method, $action, $type, $object, $callbacks, $webapp_ID, $priority, &$err, $recur = null)
	{
		return false;
	}
	
	public function handleArray($method, $action, $type, $array, $callbacks, $webapp_ID, $priority, &$err, $recur = null)
	{
		return false;
	}
	
	/**
	 * 
	 * 
	 * @param string $method
	 * @param string $action
	 * @param string $type
	 * @param string $qbxml
	 * @param array $callbacks
	 * @param mixed $uniqueid
	 * @param integer $priority
	 * @param string $err
	 * @param integer $recur
	 * @return boolean
	 */
	public function handleQBXML($method, $action, $type, $qbxml, $callbacks, $uniqueid, $priority, &$err, $recur = null)
	{
		if (strlen($uniqueid) == 0)
		{
			$uniqueid = md5(time() . $this->_user . mt_rand());
		}
		
		// The qbXML requests that get passed to this function are without the 
		//	typical qbXML wrapper info, so we need to modify them to make them 
		// 	into complete, valid requests. 
		$qbxml = $this->_makeValidQBXML($qbxml, $this->_config['qbxml_version'], $this->_config['qbxml_onerror']);
		
		$extra = array(
			'method' => $method, 
			'action' => $action, 
			'type' => $type, 
			'api' => true, 
			//'qbxml' => $qbxml, 
			'uniqueid' => $uniqueid, 
			'callbacks' => $callbacks, 
			'options' => $this->_config, 
			'recur' => $recur, 
			);	
		
		//print_r($qbxml);
		
		if ($recur)
		{
			return $this->_driver->recurEnqueue($this->_user, $recur, $action, $uniqueid, true, $priority, $extra, $qbxml);
		}
		else
		{
			return $this->_driver->queueEnqueue($this->_user, $action, $uniqueid, true, $priority, $extra, $qbxml);
		}
	}
	
	public function  handleSQL($method, $action, $type, $sql, $callbacks, $webapp_ID, $priority, &$err, $recur = null)
	{
		return false;
	}
	
	public function supported()
	{
		return array(
			QUICKBOOKS_ADD_CLASS, 
			QUICKBOOKS_QUERY_CLASS, 
			
			QUICKBOOKS_ADD_ACCOUNT, 
			QUICKBOOKS_MOD_ACCOUNT, 
			QUICKBOOKS_QUERY_ACCOUNT, 
			
			QUICKBOOKS_ADD_BILL, 
			QUICKBOOKS_MOD_BILL, 
			QUICKBOOKS_QUERY_BILL, 
			
			QUICKBOOKS_ADD_BILLPAYMENTCHECK, 
			QUICKBOOKS_MOD_BILLPAYMENTCHECK, 
			QUICKBOOKS_QUERY_BILLPAYMENTCHECK, 
			
			QUICKBOOKS_ADD_BILLPAYMENTCREDITCARD, 
			QUICKBOOKS_MOD_BILLPAYMENTCREDITCARD, 
			QUICKBOOKS_QUERY_BILLPAYMENTCREDITCARD, 			
			
			QUICKBOOKS_ADD_CUSTOMER,
			QUICKBOOKS_MOD_CUSTOMER,  
			QUICKBOOKS_QUERY_CUSTOMER,
			
			QUICKBOOKS_ADD_CUSTOMERTYPE, 
			QUICKBOOKS_QUERY_CUSTOMERTYPE, 
			
			QUICKBOOKS_ADD_DEPOSIT, 
			QUICKBOOKS_MOD_DEPOSIT, 
			QUICKBOOKS_QUERY_DEPOSIT, 
			
			QUICKBOOKS_ADD_DATAEXT, 
			QUICKBOOKS_MOD_DATAEXT, 
			QUICKBOOKS_DEL_DATAEXT, 
			
			QUICKBOOKS_ADD_INVOICE, 
			QUICKBOOKS_MOD_INVOICE, 
			QUICKBOOKS_QUERY_INVOICE, 
						
			QUICKBOOKS_ADD_EMPLOYEE, 
			QUICKBOOKS_MOD_EMPLOYEE, 
			QUICKBOOKS_QUERY_EMPLOYEE, 
			
			QUICKBOOKS_ADD_ESTIMATE, 
			QUICKBOOKS_MOD_ESTIMATE, 
			QUICKBOOKS_QUERY_ESTIMATE, 
			
			QUICKBOOKS_ADD_PAYMENTMETHOD, 
			QUICKBOOKS_QUERY_PAYMENTMETHOD, 
			
			QUICKBOOKS_ADD_RECEIVEPAYMENT, 
			QUICKBOOKS_MOD_RECEIVEPAYMENT,
			QUICKBOOKS_QUERY_RECEIVEPAYMENT,  
			
			QUICKBOOKS_ADD_JOURNALENTRY, 
			QUICKBOOKS_MOD_JOURNALENTRY, 
			QUICKBOOKS_QUERY_JOURNALENTRY, 
			
			QUICKBOOKS_QUERY_ITEM,
			
			QUICKBOOKS_ADD_DISCOUNTITEM, 
			QUICKBOOKS_MOD_DISCOUNTITEM, 
			QUICKBOOKS_QUERY_DISCOUNTITEM, 
			
			QUICKBOOKS_ADD_FIXEDASSETITEM, 
			QUICKBOOKS_MOD_FIXEDASSETITEM, 
			QUICKBOOKS_QUERY_FIXEDASSETITEM, 
			
			QUICKBOOKS_ADD_SERVICEITEM,
			QUICKBOOKS_MOD_SERVICEITEM, 
			QUICKBOOKS_QUERY_SERVICEITEM,  
			
			QUICKBOOKS_ADD_INVENTORYADJUSTMENT,

			QUICKBOOKS_ADD_INVENTORYITEM, 
			QUICKBOOKS_MOD_INVENTORYITEM, 
			QUICKBOOKS_QUERY_INVENTORYITEM,
			 
			QUICKBOOKS_ADD_NONINVENTORYITEM,
			QUICKBOOKS_MOD_NONINVENTORYITEM, 
			QUICKBOOKS_QUERY_NONINVENTORYITEM,
			  
			QUICKBOOKS_ADD_OTHERCHARGEITEM, 
			QUICKBOOKS_MOD_OTHERCHARGEITEM, 
			QUICKBOOKS_QUERY_OTHERCHARGEITEM, 

			QUICKBOOKS_ADD_ITEMRECEIPT,
			QUICKBOOKS_MOD_ITEMRECEIPT,
			QUICKBOOKS_QUERY_ITEMRECEIPT,

			QUICKBOOKS_ADD_SALESTAXCODE, 
			//QUICKBOOKS_MOD_SALESTAXCODE, 
			QUICKBOOKS_QUERY_SALESTAXCODE, 

			QUICKBOOKS_ADD_SALESTAXITEM, 
			QUICKBOOKS_MOD_SALESTAXITEM, 
			QUICKBOOKS_QUERY_SALESTAXITEM,
			
			QUICKBOOKS_ADD_SALESTAXGROUPITEM, 
			QUICKBOOKS_MOD_SALESTAXGROUPITEM, 
			QUICKBOOKS_QUERY_SALESTAXGROUPITEM, 
			
			QUICKBOOKS_ADD_SALESRECEIPT, 
			QUICKBOOKS_MOD_SALESRECEIPT, 
			QUICKBOOKS_QUERY_SALESRECEIPT, 
			
			QUICKBOOKS_ADD_SHIPMETHOD, 
			QUICKBOOKS_QUERY_SHIPMETHOD, 						
			
			QUICKBOOKS_ADD_UNITOFMEASURESET, 
			//QUICKBOOKS_MOD_UNITOFMEASURESET, 
			QUICKBOOKS_QUERY_UNITOFMEASURESET, 
			
			QUICKBOOKS_ADD_VENDOR, 
			QUICKBOOKS_MOD_VENDOR, 
			QUICKBOOKS_QUERY_VENDOR,  
			);
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsApplicationIDs()
	{
		return true;
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsAdding()
	{
		return true;
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsDeleting()
	{
		return true;
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsModifying()
	{
		return true;
	}
	
	public function supportsQuerying()
	{
		return true;
	}
	
	public function supportsRealtime()
	{
		return false;
	}
	
	public function supportsRecurring()
	{
		return true;
	}
	
	public function understandsSQL()
	{
		return false;
	}
	
	public function understandsQBXML()
	{
		return true;
	}
	
	public function understandsArrays()
	{
		return false;
	}
	
	public function understandsObjects()
	{
		return false;
	}
}
