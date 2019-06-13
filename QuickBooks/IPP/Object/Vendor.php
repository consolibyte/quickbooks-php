<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Vendor extends QuickBooks_IPP_Object
{
	protected function _defaults()
	{
		return array(
			'TypeOf' => 'Person', 
			);
	}	
}
