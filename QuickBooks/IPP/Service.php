<?php

class QuickBooks_IPP_Service
{
	public function __construct()
	{
		
	}
	
	public function findAll($Context, $realmID, $resource, $xml = '')
	{
		$IPP = $Context->IPP();
		
		return $IPP->IDS($Context, $realmID, $resource, $xml);
	}
}