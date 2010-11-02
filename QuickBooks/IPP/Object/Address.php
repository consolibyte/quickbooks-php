<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Address extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(
			'Line1' => true, 
			'Line2' => true, 
			'City' => true, 
			'PostalCode' => true, 
			);
	}

}
