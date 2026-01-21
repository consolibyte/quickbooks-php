<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Email extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(
			'Id' => true, 
			'Address' => true, 
			'Default' => true, 
			'Tag' => true,
			); 
	}
}
