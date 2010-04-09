<?php

class QuickBooks_IPP_Service
{
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
		
		return $IPP->IDS($Context, $realmID, $resource, $xml);
	}
	
	public function lastRequest($Context)
	{
		$IPP = $Context->IPP();
		return $IPP->lastRequest();
	}
	
	public function lastResponse($Context)
	{
		$IPP = $Context->IPP();
		return $IPP->lastResponse();
	}
}