<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Cash extends QuickBooks_IPP_Object
{	
	protected function _order()
	{
		return array();
	}

}
