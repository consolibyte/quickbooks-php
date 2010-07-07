<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Estimate extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = null;
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_ESTIMATE, $xml);
	}
	
	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_ESTIMATE, $Object);
	}	
	
	/**
	 * Get an estimate by ID 
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realmID					
	 * @param string $ID						The ID of the estimate (this expects an IdType, which includes the domain)
	 * @return QuickBooks_IPP_Object_Employee	The estimate object
	 */
	public function findById($Context, $realmID, $ID)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_ESTIMATE, $ID, null, $xml);
	}	
}