<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Vendor extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = '<VendorQuery xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/v2"></VendorQuery>';
		
		return parent::findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_VENDOR, $xml);
	}
}