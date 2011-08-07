<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Payment extends QuickBooks_IPP_Object
{
	protected function _defaults()
	{
		return array(
			//'TypeOf' => 'Person', 
			);
	}
	
	protected function _order()
	{
		return array(
			'Id' => true, 
			'SyncToken' => true, 
			'MetaData' => true, 
			'CustomField' => true, 
			'Header' => true, 
			'Line' => true, 
			);
	}
}
