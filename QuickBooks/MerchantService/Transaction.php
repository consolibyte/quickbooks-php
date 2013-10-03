<?php

/**
 * QuickBooks Merchant Service transaction class
 * 
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * This class represents a transaction returned by the QuickBooks Merchant 
 * Service web gateway. 
 * 
 * @package QuickBooks
 * @subpackage MerchantService
 */

/**
 * QuickBooks MerchantService transaction processor
 */
QuickBooks_Loader::load('/QuickBooks/MerchantService.php');

/**
 * XML parser class
 */
QuickBooks_Loader::load('/QuickBooks/XML/Parser.php');

/**
 * QuickBooks Merchant Service transaction class
 */
class QuickBooks_MerchantService_Transaction
{
	/**
	 * The type of transaction (QUICKBOOKS_MERCHANTSERVICE_CHARGE, etc.)
	 * @var string
	 */
	protected $_type;
	
	/**
	 * The transaction ID
	 * @var string
	 */
	protected $_transID;
	
	/**
	 * The client transaction ID
	 * @var string
	 */
	protected $_clientTransID;
	protected $_authcode;
	protected $_merchant;
	protected $_batch;
	protected $_paymentgroup;
	protected $_paymentstatus;
	protected $_txnauthtime;
	protected $_txnauthstamp;
	protected $_avsstreet;
	protected $_avszip;
	protected $_cvvmatch;
	protected $_networkname;
	protected $_networknumber;
	
	protected $_resultcode;
	protected $_resultmessage;

	protected $_creditcardnumber;
	protected $_expmonth;
	protected $_expyear;
	protected $_nameoncard;
	protected $_address;
	protected $_postalcode;
	
	/**
	 * Create a new Transaction object
	 * 
	 * @note There is more information available to be set in the transaction 
	 * 	object by using the ->setExtraData() method. 
	 * 
	 * @param string $type
	 * @param string $transID
	 * @param string $clientTransID
	 * @param string $authcode
	 * @param string $merchant
	 * @param string $batch
	 * @param string $paymengroup
	 * @param string $paymentstatus
	 * @param string $txnauthtime
	 * @param string $txnauthstamp
	 * @param string $avsstreet
	 * @param string $avszip
	 * @param string $cvvmatch
	 * @param string $networkname
	 * @param string $networknumber
	 */
	public function __construct($type, $transID, $clientTransID = null, $authcode = null, $merchant = null, $batch = null, $paymentgroup = null, $paymentstatus = null, $txnauthtime = null, $txnauthstamp = null, $avsstreet = null, $avszip = null, $cvvmatch = null, $networkname = null, $networknumber = null)
	{
		$this->_type = $type;
		$this->_transID = $transID;
		$this->_clientTransID = $clientTransID;
		$this->_authcode = $authcode;
		$this->_merchant = $merchant;
		$this->_batch = $batch;
		$this->_paymentgroup = $paymentgroup;
		$this->_paymentstatus = $paymentstatus;
		$this->_txnauthtime = $txnauthtime;
		$this->_txnauthstamp = $txnauthstamp;
		$this->_avsstreet = $avsstreet;
		$this->_avszip = $avszip;
		$this->_cvvmatch = $cvvmatch;
		$this->_networkname = $networkname;
		$this->_networknumber = $networknumber;
	}
	
	/** 
	 * 
	 * 
	 */
	public function setExtraData($resultcode, $resultmessage, $creditcardnumber, $expmonth, $expyear, $nameoncard, $address, $postalcode)
	{
		$this->_resultcode = $resultcode;
		$this->_resultmessage = $resultmessage;
		
		$this->_creditcardnumber = $creditcardnumber;
		$this->_expmonth = $expmonth;
		$this->_expyear = $expyear;
		$this->_nameoncard = $nameoncard;
		$this->_address = $address;
		$this->_postalcode = $postalcode;
		
		return true;		
	}
	
	/**
	 * Set the transaction ID for this transaction
	 * 
	 * @param string $transID
	 * @return void
	 */
	public function setTransactionID($transID)
	{
		$this->_transID = $transID;
	}
	
	/**
	 * Set the client transaction ID for this transaction
	 * 
	 * @param string $clientTransID
	 * @return void
	 */
	public function setClientTransactionID($clientTransID)
	{
		$this->_clientTransID = $clientTransID;
	}
	
	/**
	 * Get the transaction ID
	 * 
	 * @return string
	 */
	public function getTransactionID()
	{
		return $this->_transID;
	}
	
	/**
	 * 
	 * 
	 */
	public function getClientTransactionID()
	{
		return $this->_clientTransID;
	}
	
	public function getAuthorizationCode()
	{
		return $this->_authcode;
	}
	
	public function getMerchantAccountNumber()
	{
		return $this->_merchant;
	}
	
	/**
	 * Get the address verification (AVS) status of the transaction
	 * 
	 * @return string An AVS result (QUICKBOOKS_MERCHANTSERVICE_PASS, QUICKBOOKS_MERCHANTSERVICE_FAIL, QUICKBOOKS_MERCHANTSERVICE_NOTAVAILABLE)
	 */
	public function getAVSStreet()
	{
		return $this->_avsstreet;
	}

	public function setAVSStreet($avsstreet)
	{
		$this->_avsstreet = $avsstreet;
	}

	/**
	 * Get the postal code verification (AVS) status of the transaction
	 * 
	 * @return string An AVS result (QUICKBOOKS_MERCHANTSERVICE_PASS, QUICKBOOKS_MERCHANTSERVICE_FAIL, QUICKBOOKS_MERCHANTSERVICE_NOTAVAILABLE)
	 */	
	public function getAVSZip()
	{
		return $this->_avszip;
	}

	public function setAVSZip($avszip)
	{
		return $this->_avszip = $avszip;
	}
	
	public function getCardSecurityCodeMatch()
	{
		return $this->_cvvmatch;
	}

	public function setCardSecurityCodeMatch($cvvmatch)
	{
		return $this->_cvvmatch = $cvvmatch;
	}
	
	public function getReconBatchID()
	{
		return $this->_batch;
	}
	
	public function getPaymentGroupingCode()
	{
		return $this->_paymentgroup;
	}
	
	public function getPaymentStatus()
	{
		return $this->_paymentstatus;
	}
	
	public function getTxnAuthorizationTime()
	{
		return $this->_txnauthtime;
	}
	
	public function getTxnAuthorizationStamp()
	{
		return $this->_txnauthstamp;
	}

	/**
	 * 
	 * 
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'Type' => $this->_type, 
			'CreditCardTransID' => $this->_transID, 
			'AuthorizationCode' => $this->_authcode, 
			'AVSStreet' => $this->_avsstreet,
			'AVSZip' => $this->_avszip, 
			'CardSecurityCodeMatch' => $this->_cvvmatch, 
			'ClientTransID' => $this->_clientTransID,  
			'MerchantAccountNumber' => $this->_merchant, 
			'ReconBatchID' => $this->_batch, 
			'PaymentGroupingCode' => $this->_paymentgroup,
			'PaymentStatus' => $this->_paymentstatus, 
			'TxnAuthorizationTime' => $this->_txnauthtime, 
			'TxnAuthorizationStamp' => $this->_txnauthstamp, 
			'NetworkName' => $this->_networkname, 
			'NetworkNumber' => $this->_networknumber, 
			//'DebitCardTransID' => $this->_transID, 
			
			'CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardNumber' => $this->_creditcardnumber, 
			'CreditCardTxnInfo_CreditCardTxnInputInfo_ExpirationMonth' => $this->_expmonth, 
			'CreditCardTxnInfo_CreditCardTxnInputInfo_ExpirationYear' => $this->_expyear,
			'CreditCardTxnInfo_CreditCardTxnInputInfo_NameOnCard' => $this->_nameoncard, 
			'CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardAddress' => $this->_address,
			'CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardPostalCode' => $this->_postalcode, 
			// <CommercialCardCode >STRTYPE</CommercialCardCode> <!-- optional -->
			// <!-- TransactionMode may have one of the following values: CardNotPresent [DEFAULT], CardPresent -->
			// <TransactionMode >ENUMTYPE</TransactionMode> <!-- optional -->
			// <!-- CreditCardTxnType may have one of the following values: Authorization, Capture, Charge, Refund, VoiceAuthorization -->
			'CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardTxnType' => $this->_type, 

			'CreditCardTxnInfo_CreditCardTxnResultInfo_ResultCode' => $this->_resultcode, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_ResultMessage' => $this->_resultmessage, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_CreditCardTransID' => $this->_transID, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_MerchantAccountNumber' => $this->_merchant, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_AuthorizationCode' => $this->_authcode, 
			// <!-- AVSStreet may have one of the following values: Pass, Fail, NotAvailable -->
			'CreditCardTxnInfo_CreditCardTxnResultInfo_AVSStreet' => $this->_avsstreet, 
			// <!-- AVSZip may have one of the following values: Pass, Fail, NotAvailable -->
			'CreditCardTxnInfo_CreditCardTxnResultInfo_AVSZip' => $this->_avszip, 
			// <!-- CardSecurityCodeMatch may have one of the following values: Pass, Fail, NotAvailable -->
			'CreditCardTxnInfo_CreditCardTxnResultInfo_CardSecurityCodeMatch' => $this->_cvvmatch, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_ReconBatchID' => $this->_batch,
			'CreditCardTxnInfo_CreditCardTxnResultInfo_PaymentGroupingCode' => $this->_paymentgroup, 
			// <!-- PaymentStatus may have one of the following values: Unknown, Completed -->
			'CreditCardTxnInfo_CreditCardTxnResultInfo_PaymentStatus' => $this->_paymentstatus, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_TxnAuthorizationTime' => $this->_txnauthtime, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_TxnAuthorizationStamp' => $this->_txnauthstamp,
			'CreditCardTxnInfo_CreditCardTxnResultInfo_ClientTransID' => $this->_clientTransID, 	
			);
	}
	
	static public function fromArray($arr)
	{
		static $defaults = array(
			'Type' => null, 
			'CreditCardTransID' => null, 
			'AuthorizationCode' => null, 
			'AVSStreet' => null,
			'AVSZip' => null, 
			'CardSecurityCodeMatch' => null, 
			'ClientTransID' => null,  
			'MerchantAccountNumber' => null, 
			'ReconBatchID' => null, 
			'PaymentGroupingCode' => null,
			'PaymentStatus' => null, 
			'TxnAuthorizationTime' => null, 
			'TxnAuthorizationStamp' => null, 
			'NetworkName' => null, 
			'NetworkNumber' => null, 
			'DebitCardTransID' => null, 

			'CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardNumber' => null, 
			'CreditCardTxnInfo_CreditCardTxnInputInfo_ExpirationMonth' => null, 
			'CreditCardTxnInfo_CreditCardTxnInputInfo_ExpirationYear' => null, 
			'CreditCardTxnInfo_CreditCardTxnInputInfo_NameOnCard' => null, 
			'CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardAddress' => null, 
			'CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardPostalCode' => null, 
			// <CommercialCardCode >STRTYPE</CommercialCardCode> <!-- optional -->
			// <!-- TransactionMode may have one of the following values: CardNotPresent [DEFAULT], CardPresent -->
			// <TransactionMode >ENUMTYPE</TransactionMode> <!-- optional -->
			// <!-- CreditCardTxnType may have one of the following values: Authorization, Capture, Charge, Refund, VoiceAuthorization -->
			'CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardTxnType' => null, 

			'CreditCardTxnInfo_CreditCardTxnResultInfo_ResultCode' => null, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_ResultMessage' => null, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_CreditCardTransID' => null, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_MerchantAccountNumber' => null, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_AuthorizationCode' => null, 
			// <!-- AVSStreet may have one of the following values: Pass, Fail, NotAvailable -->
			'CreditCardTxnInfo_CreditCardTxnResultInfo_AVSStreet' => null, 
			// <!-- AVSZip may have one of the following values: Pass, Fail, NotAvailable -->
			'CreditCardTxnInfo_CreditCardTxnResultInfo_AVSZip' => null, 
			// <!-- CardSecurityCodeMatch may have one of the following values: Pass, Fail, NotAvailable -->
			'CreditCardTxnInfo_CreditCardTxnResultInfo_CardSecurityCodeMatch' => null, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_ReconBatchID' => null, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_PaymentGroupingCode' => null, 
			// <!-- PaymentStatus may have one of the following values: Unknown, Completed -->
			'CreditCardTxnInfo_CreditCardTxnResultInfo_PaymentStatus' => null, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_TxnAuthorizationTime' => null, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_TxnAuthorizationStamp' => null, 
			'CreditCardTxnInfo_CreditCardTxnResultInfo_ClientTransID' => null, 
			);		
		
		$trans = array_merge($defaults, $arr);
		
		$obj = new QuickBooks_MerchantService_Transaction(
			$trans['Type'], 
			$trans['CreditCardTransID'], 
			$trans['ClientTransID'], 
			$trans['AuthorizationCode'], 
			$trans['MerchantAccountNumber'], 
			$trans['ReconBatchID'], 
			$trans['PaymentGroupingCode'], 
			$trans['PaymentStatus'], 
			$trans['TxnAuthorizationTime'], 
			$trans['TxnAuthorizationStamp'], 
			$trans['AVSStreet'], 
			$trans['AVSZip'], 
			$trans['CardSecurityCodeMatch'], 
			$trans['NetworkName'], 
			$trans['NetworkNumber']);
			
		$obj->setExtraData(
			$trans['CreditCardTxnInfo_CreditCardTxnResultInfo_ResultCode'], 
			$trans['CreditCardTxnInfo_CreditCardTxnResultInfo_ResultMessage'], 
			$trans['CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardNumber'], 
			$trans['CreditCardTxnInfo_CreditCardTxnInputInfo_ExpirationMonth'], 
			$trans['CreditCardTxnInfo_CreditCardTxnInputInfo_ExpirationYear'], 
			$trans['CreditCardTxnInfo_CreditCardTxnInputInfo_NameOnCard'], 
			$trans['CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardAddress'],
			$trans['CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardPostalCode']);	
		
		return $obj;
	}
	
	public function toXML()
	{
		$xml = '';
		$xml .= '<?xml version="1.0" encoding="UTF-8" ?>' . QUICKBOOKS_CRLF;
		$xml .= '<QBMSTransaction>' . QUICKBOOKS_CRLF;
		foreach ($this->toArray() as $key => $value)
		{
			$xml .= '<' . $key . '>' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</' . $key . '>' . QUICKBOOKS_CRLF;
		}
		$xml .= '</QBMSTransaction>';
		
		return $xml;
	}
	
	public function toQBXML()
	{
		// CreditCardTxnInfo
		
		$arr = array(
			'CreditCardTxnInputInfo' => array(
				'CreditCardNumber' => $this->_creditcardnumber, 
				'ExpirationMonth' => $this->_expmonth, 
				'ExpirationYear' => $this->_expyear, 
				'NameOnCard' => $this->_nameoncard, 
				'CreditCardAddress' => $this->_address, 
				'CreditCardPostalCode' => $this->_postalcode, 
				// <!-- TransactionMode may have one of the following values: CardNotPresent [DEFAULT], CardPresent -->
				// TransactionMode	// CardNotPresent, CardPresent
				'CreditCardTxnType' => $this->_type, 
			), 
			'CreditCardTxnResultInfo' => array(
				'ResultCode' => $this->_resultcode, 
				'ResultMessage' => $this->_resultmessage, 
				
				'CreditCardTransID' => $this->_transID, 
				'MerchantAccountNumber' => $this->_merchant, 
				'AuthorizationCode' => $this->_authcode, 
				// <!-- AVSStreet may have one of the following values: Pass, Fail, NotAvailable -->
				'AVSStreet' => $this->_avsstreet,
				// <!-- AVSZip may have one of the following values: Pass, Fail, NotAvailable -->
				'AVSZip' => $this->_avszip,
				// <!-- CardSecurityCodeMatch may have one of the following values: Pass, Fail, NotAvailable -->
				'CardSecurityCodeMatch' => $this->_cvvmatch,
				'ReconBatchID'  => $this->_batch, 
				'PaymentGroupingCode' => $this->_paymentgroup, 
				// <!-- PaymentStatus may have one of the following values: Unknown, Completed -->
				'PaymentStatus' => $this->_paymentstatus, 
				'TxnAuthorizationTime' => $this->_txnauthtime, 
				'TxnAuthorizationStamp' => $this->_txnauthstamp, 
				'ClientTransID' => $this->_clientTransID, 
			));
		
		$xml = '';
		foreach ($arr as $creditcardtxn => $data)
		{
			$xml .= '<' . $creditcardtxn . '>' . QUICKBOOKS_CRLF;
			
			foreach ($data as $key => $value)
			{
				$xml .= "\t" . '<' . $key . '>' . htmlspecialchars($value) . '</' . $key . '>' . QUICKBOOKS_CRLF;
			}
			
			$xml .= '</' . $creditcardtxn . '>' . QUICKBOOKS_CRLF;
		}
		
		return $xml;
	}
	
	/**
	 * 
	 * 
	 * @param string $xml
	 * @return QuickBooks_MerchantService_Transaction
	 */
	static public function fromXML($xml)
	{		
		$errnum = 0;
		$errmsg = '';
		
		$arr = array();
		
		$Parser = new QuickBooks_XML_Parser($xml);
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			$Root = $Doc->getRoot();
			
			foreach ($Root->asArray(QuickBooks_XML::ARRAY_PATHS) as $path => $value)
			{
				$tmp = explode(' ', $path);
				$key = trim(end($tmp));
				
				$arr[$key] = $value;
			}
		}
		
		return QuickBooks_MerchantService_Transaction::fromArray($arr);
	}
	
	public function serialize()
	{
		return serialize($this->toArray());
	}
	
	static public function unserialize($str)
	{
		return QuickBooks_MerchantService_Transaction::fromArray(unserialize($str));
	}
}
