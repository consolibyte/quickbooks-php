<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_SalesRep extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(	
			'Id' => true, 
			'MetaData' => true, 
			'NameOf' => true, 
			'Employee' => true, 
			'Vendor' => true, 
			'OtherName' => true, 
			'Initials' => true, 
			);
	}
}

