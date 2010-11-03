<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Account extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(
			'Id' => true, 	
			'MetaData' => true, 
			'Name' => true, 
			'AccountParentId' => true, 
			'AccountParentName' => true, 
			'Desc' => true, 
			'Active' => true, 
			'Type' => true, 
			'Subtype' => true, 
			'AcctNum' => true, 
			'BankNum' => true, 
			'OpeningBalance' => true, 
			'OpeningBalanceDate' => true, 
			'CurrentBalance' => true, 
			'CurrentBalanceWithSubAccounts' => true, 
			);
	}
}
