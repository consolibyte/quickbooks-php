<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Check extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = '<CheckQuery xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/v2"></CheckQuery>';
		
		return parent::findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CHECK, $xml);
	}
}