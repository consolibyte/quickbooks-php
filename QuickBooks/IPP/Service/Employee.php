<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Employee extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = null;
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_EMPLOYEE, $xml);
	}
	
	/**
	 * Get an employee by ID 
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realmID					
	 * @param string $ID						The ID of the customer (this expects an IdType, which includes the domain)
	 * @return QuickBooks_IPP_Object_Employee	The employee object
	 */
	public function findById($Context, $realmID, $ID)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_EMPLOYEE, $ID, null, $xml);
	}	
}