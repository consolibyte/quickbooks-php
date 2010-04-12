<?php

/**
 * 
 */

/**
 * 
 * 
 *
 */
class QuickBooks_IPP_Service
{
	protected $_last_request;
	protected $_last_response;
	
	protected $_errcode;
	protected $_errtext;
	protected $_errdetail;
	
	public function __construct()
	{
		$this->_errcode = QuickBooks_IPP::ERROR_OK;
	}
	
	protected function _findAll($Context, $realmID, $resource, $xml = '')
	{
		$IPP = $Context->IPP();
		
		if (!$xml)
		{
			$xml = '<' . $resource . 'Query xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/v2"></' . $resource . 'Query>';
		}
		
		$return = $IPP->IDS($Context, $realmID, $resource, QuickBooks_IPP::IDS_QUERY, $xml);
		$this->_setLastRequestResponse($Context->lastRequest(), $Context->lastResponse());
		
		return $return;
	}
	
	protected function _add($Context, $realmID, $resource, $Object)
	{
		$IPP = $Context->IPP();
		
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
			<Add xmlns="http://www.intuit.com/sb/cdm/v2" 
				xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
				RequestId="' . md5(mt_rand() . microtime()) . '" 
				xsi:schemaLocation="http://www.intuit.com/sb/cdm/v2 ./RestDataFilter.xsd ">
				<OfferingId>ipp</OfferingId>
				<ExternalRealmId>' . $realmID . '</ExternalRealmId>
				<!--<Object xsi:type="Customer">
					<TypeOf>Person</TypeOf>
					<Name>Jack Thompson</Name>
					<Title>Mr</Title>
					<GivenName>Jack</GivenName>
					<MiddleName>NMI</MiddleName>
					<FamilyName>Thompson</FamilyName>
					<Suffix>Sr</Suffix>
					<Gender>Male</Gender>-->
					' . $Object->asIDSXML(0, null, QuickBooks_IPP::IDS_ADD) . '
				<!--</Object>-->
			</Add>';
		
		$return = $IPP->IDS($Context, $realmID, $resource, QuickBooks_IPP::IDS_ADD, $xml);
		$this->_setLastRequestResponse($Context->lastRequest(), $Context->lastResponse());
		
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
	
	protected function _setLastRequestResponse($request, $response)
	{
		$this->_last_request = $request;
		$this->_last_response = $response;
	}
	
	public function lastRequest($Context = null)
	{
		if ($Context)
		{
			return $Context->lastRequest();
		}
		
		return $this->_last_request;
	}
	
	public function lastResponse($Context = null)
	{
		if ($Context)
		{
			return $Context->lastResponse();
		}
		
		return $this->_last_response;
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
	 *  
	 */
	public function errorDetail()
	{
		return $this->_errdetail;
	}	
	
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