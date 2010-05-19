<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_BillPaymentCreditCard extends QuickBooks_IPP_Service
{
	public function findById($Context, $realmID, $IDType, $domain = null)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_BILLPAYMENTCREDITCARD, $IDType, $domain, $xml);
	}
	
	public function findAll($Context, $realmID)
	{
		$xml = null;
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_BILLPAYMENTCREDITCARD, $xml);
	}
}