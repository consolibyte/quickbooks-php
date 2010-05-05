<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Customer extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = null;
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $xml);
	}
	
	/**
	 * Delete a customer from IDS/QuickBooks
	 *
	 *
	 */
	public function delete($Context, $realmID, $IDType)
	{
		return parent::_delete($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $IDType);
	}
	
	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $Object);
	}
}