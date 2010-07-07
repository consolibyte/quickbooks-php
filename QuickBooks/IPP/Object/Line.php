<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Line extends QuickBooks_IPP_Object
{
	public function getQuantity()
	{
		return $this->get('Qty');
	}
	
	public function getDescription()
	{
		return $this->get('Desc');
	}
}
