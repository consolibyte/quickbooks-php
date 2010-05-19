<?php

/**
 * 
 * 
 * 
 * @package QuickBooks
 * @subpackage IPP
 */

/**
 * 
 * 
 *
 */
abstract class QuickBooks_IPP_Service
{
	/**
	 * The last raw XML request
	 * @var string
	 */
	protected $_last_request;
	
	/**
	 * The last raw XML response
	 * @var string
	 */
	protected $_last_response;
	
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_last_debug;
	
	/**
	 * The last error code
	 * @var string
	 */
	protected $_errcode;
	
	/**
	 * The last error message
	 * @var string
	 */
	protected $_errtext;
	
	/**
	 * The last error detail
	 * @var string
	 */
	protected $_errdetail;
	
	/**
	 * 
	 * 
	 */
	public function __construct()
	{
		$this->_errcode = QuickBooks_IPP::ERROR_OK;
		
		$this->_last_request = null;
		$this->_last_response = null;
		$this->_last_debug = array();
	}
	
	protected function _report($Context, $realmID, $resource, $xml = '')
	{
		$IPP = $Context->IPP();
		
		if (!$xml)
		{
			$xml = '';
			$xml .= '<?xml version="1.0" encoding="UTF-8"?>' . QUICKBOOKS_CRLF;
			$xml .= '<' . $resource . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/' . $IPP->version() . '"></' . $resource . '>';
		}
		
		$return = $IPP->IDS($Context, $realmID, $resource, QuickBooks_IPP::IDS_REPORT, $xml);
		$this->_setLastRequestResponse($Context->lastRequest(), $Context->lastResponse());
		$this->_setLastDebug($Context->lastDebug());
		
		return $return;
	}
	
	protected function _delete($Context, $realmID, $resource, $IDType, $xml = '')
	{
		$IPP = $Context->IPP();
		
		if (!$xml)
		{
			$parse = QuickBooks_IPP_IDS::parseIDType($IDType);
			
			$xml = '';
			$xml .= '<?xml version="1.0" encoding="UTF-8"?>' . QUICKBOOKS_CRLF;
			$xml .= '<' . $resource . 'Query xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/' . $IPP->version() . '">' . QUICKBOOKS_CRLF;
			$xml .= '	<TransactionIdSet>' . QUICKBOOKS_CRLF;
			$xml .= '		<Id idDomain="' . $parse[0] . '">' . $parse[1] . '</Id>' . QUICKBOOKS_CRLF;
			$xml .= '	</TransactionIdSet>' . QUICKBOOKS_CRLF;
			$xml .= '</' . $resource . 'Query>';
		}
		
		$return = $IPP->IDS($Context, $realmID, $resource, QuickBooks_IPP::IDS_QUERY, $xml);
		$this->_setLastRequestResponse($Context->lastRequest(), $Context->lastResponse());
		$this->_setLastDebug($Context->lastDebug());
		
		if (count($return))
		{
			return $return[0];
		}
		
		return null;
	}
	
	/**
	 * 
	 * 
	 */
	protected function _guessResource($xml, $optype)
	{
		$tmp = explode('_', get_class($this));
		return end($tmp);
	}
	
	/**
	 * 
	 * 
	 */
	public function rawQuery($Context, $realmID, $xml, $resource = null)
	{
		$IPP = $Context->IPP();
		
		if (!$resource)
		{
			$resource = $this->_guessResource($xml, QuickBooks_IPP::IDS_QUERY);
		}
		
		return $this->_findAll($Context, $realmID, $resource, $xml);
	}
	
	public function rawAdd()
	{
		
	}
	
	protected function _findAll($Context, $realmID, $resource, $xml = '')
	{
		$IPP = $Context->IPP();
		
		if (!$xml)
		{
			$xml = '';
			$xml .= '<?xml version="1.0" encoding="UTF-8"?>' . QUICKBOOKS_CRLF;
			$xml .= '<' . $resource . 'Query xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/' . $IPP->version() . '"></' . $resource . 'Query>';
		}
		
		$return = $IPP->IDS($Context, $realmID, $resource, QuickBooks_IPP::IDS_QUERY, $xml);
		$this->_setLastRequestResponse($Context->lastRequest(), $Context->lastResponse());
		$this->_setLastDebug($Context->lastDebug());
		
		return $return;
	}
	
	/** 
	 * Add an IDS object via IPP
	 * 
	 * @param QuickBooks_IPP_Context $Context
	 * @param integer $realmID
	 * @param string $resource
	 * @param object $Object
	 * @return integer
	 */
	protected function _add($Context, $realmID, $resource, $Object)
	{
		$IPP = $Context->IPP();
		
		// 
		
		//$Object->unsetAddress();
		//$Object->unsetPhone();
		//$Object->unsetDBAName();
		
		$unsets = array(
			'Id', 
			'SyncToken', 
			'MetaData', 
			'ExternalKey', 
			'Synchronized', 
			'PartyReferenceId', 
			'SalesTaxCodeId', 		// @todo These are customer/vendor specific and probably shouldn't be here
			'SalesTaxCodeName',
			'OpenBalanceDate', 
			'OpenBalance', 
			);
		
		foreach ($unsets as $unset)
		{
			$Object->remove($unset);
		}
		
		// Build the XML request
		$xml = '';
		$xml .= '<?xml version="1.0" encoding="UTF-8"?>' . QUICKBOOKS_CRLF;
		$xml .= '<Add xmlns="http://www.intuit.com/sb/cdm/' . $IPP->version() . '" ' . QUICKBOOKS_CRLF;
		$xml .= '	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' . QUICKBOOKS_CRLF;
		$xml .= '	RequestId="' . md5(mt_rand() . microtime()) . '" ' . QUICKBOOKS_CRLF;
		$xml .= '	xsi:schemaLocation="http://www.intuit.com/sb/cdm/' . $IPP->version() . ' ./RestDataFilter.xsd ">' . QUICKBOOKS_CRLF;
		$xml .= '	<OfferingId>ipp</OfferingId>' . QUICKBOOKS_CRLF;
		$xml .= '	<ExternalRealmId>' . $realmID . '</ExternalRealmId>' . QUICKBOOKS_CRLF;
		$xml .= '' . $Object->asIDSXML(1, null, QuickBooks_IPP::IDS_ADD);
		$xml .= '</Add>';
		
		// Send the data to IPP 
		$return = $IPP->IDS($Context, $realmID, $resource, QuickBooks_IPP::IDS_ADD, $xml);
		$this->_setLastRequestResponse($Context->lastRequest(), $Context->lastResponse());
		$this->_setLastDebug($Context->lastDebug());
		
		if ($IPP->errorCode() != QuickBooks_IPP::ERROR_OK)
		{
			$this->_setError(
				$IPP->errorCode(), 
				$IPP->errorText(), 
				$IPP->errorDetail());
			
			return false;
		}
		
		return $return;
	}
	
	/**
	 * Find a record by ID number 
	 * 
	 * 
	 */
	protected function _findById($Context, $realmID, $resource, $IDType, $domain, $xml = '')
	{
		$IPP = $Context->IPP();
		
		if (!$domain)
		{
			$domain = QuickBooks_IPP_IDS::DOMAIN_QB;
		}
		
		if (!$xml)
		{
			$parse = QuickBooks_IPP_IDS::parseIDType($IDType);
			
			$xml = '';
			$xml .= '<?xml version="1.0" encoding="UTF-8"?>' . QUICKBOOKS_CRLF;
			$xml .= '<' . $resource . 'Query xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/' . $IPP->version() . '">' . QUICKBOOKS_CRLF;
			$xml .= '	<TransactionIdSet>' . QUICKBOOKS_CRLF;
			$xml .= '		<Id idDomain="' . $parse['domain'] . '">' . $parse['ID'] . '</Id>' . QUICKBOOKS_CRLF;
			$xml .= '	</TransactionIdSet>' . QUICKBOOKS_CRLF;
			$xml .= '</' . $resource . 'Query>';
		}
		
		$return = $IPP->IDS($Context, $realmID, $resource, QuickBooks_IPP::IDS_QUERY, $xml);
		$this->_setLastRequestResponse($Context->lastRequest(), $Context->lastResponse());
		$this->_setLastDebug($Context->lastDebug());
		
		if (count($return))
		{
			return $return[0];
		}
		
		return null;
	}
	
	/**
	 * Set the last XML request and XML response that was made by this service
	 *
	 * @param string $request		The last XML request that was made
	 * @param string $response		The last XML response that was made
	 * @return void
	 */
	protected function _setLastRequestResponse($request, $response)
	{
		$this->_last_request = $request;
		$this->_last_response = $response;
	}
	
	protected function _setLastDebug($debug)
	{
		$this->_last_debug = $debug;
	}
	
	/**
	 * Get the last XML request that was made 
	 * 
	 * @param object $Context		
	 * @return string
	 */
	public function lastRequest($Context = null)
	{
		if ($Context)
		{
			return $Context->lastRequest();
		}
		
		return $this->_last_request;
	}
	
	/**
	 * Get the last raw XML response that was returned
	 *
	 * @param object $Context		If you provide a specific context, this will return the last response using that particular context, otherwise it will return the last response from this service
	 * @return string				The last raw XML response
	 */
	public function lastResponse($Context = null)
	{
		if ($Context)
		{
			return $Context->lastResponse();
		}
		
		return $this->_last_response;
	}
	
	public function lastDebug($Context = null)
	{
		if ($Context)
		{
			return $Context->lastDebug();
		}
		
		return $this->_last_debug;
	}
	
	/**
	 * Get the error number of the last error that occured
	 * 
	 * @return mixed		The error number (or error code, some QuickBooks error codes are hex strings)
	 */
	public function errorCode()
	{
		return $this->_errcode;
	}
	
	/**
	 * Alias if ->errorCode()   (here for consistency with rest of framework)
	 */
	public function errorNumber()
	{
		return $this->errorCode();
	}
	
	/**
	 * Get the last error message that was reported
	 * 
	 * Remember that issuing new commands may cause previous unchecked errors 
	 * to be *cleared*, so make sure you check for errors if you expect an 
	 * error might occur!
	 * 
	 * @return string
	 */
	public function errorText()
	{
		return $this->_errtext;
	}
	
	/**
	 * Alias of ->errorText()   (here for consistency with rest of framework)
	 */
	public function errorMessage()
	{
		return $this->errorText();
	}
	
	/**
	 *  Get the error detail message from the response
	 * 
	 * The error detail node sometimes contains additional information about 
	 * the error that occurred. You should make sure to also check the result 
	 * of ->errorCode() and ->errorMessage() too. 
	 * 
	 * @return string
	 */
	public function errorDetail()
	{
		return $this->_errdetail;
	}	
	
	/** 
	 * Tell whether or not an error occurred
	 * 
	 * @return boolean
	 */
	public function hasErrors()
	{
		return $this->_errcode != QuickBooks_IPP::ERROR_OK;
	}
	
	/**
	 * Set an error message
	 * 
	 * @param integer $errnum	The error number/code
	 * @param string $errmsg	The text error message
	 * @return void
	 */
	protected function _setError($errcode, $errtext = '', $errdetail = '')
	{
		$this->_errcode = $errcode;
		$this->_errtext = $errtext;
		$this->_errdetail = $errdetail;
	}	
}