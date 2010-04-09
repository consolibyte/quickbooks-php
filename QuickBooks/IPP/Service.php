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
	
	public function __construct()
	{
		
	}
	
	protected function _findAll($Context, $realmID, $resource, $xml = '')
	{
		$IPP = $Context->IPP();
		
		if (!$xml)
		{
			$xml = '<' . $resource . 'Query xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/v2"></' . $resource . 'Query>';
		}
		
		$return = $IPP->IDS($Context, $realmID, $resource, $xml);
		$this->_setLastRequestResponse($Context->lastRequest(), $Context->lastResponse());
		
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
}