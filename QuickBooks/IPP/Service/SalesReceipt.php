<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_SalesReceipt extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = null;
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, $xml);
	}
	
	/**
	 * Add a new sales receipt to IDS/QuickBooks
	 *
	 * @param QuickBooks_IPP_Context $Context
	 * @param string $realmID
	 * @param QuickBooks_IPP_Object_SalesReceipt $Object		The sales receipt to add
	 * @return string											The Id value of the new sales receipt
	 */
	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, $Object);
	}	
}