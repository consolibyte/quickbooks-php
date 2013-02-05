<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Data extends QuickBooks_IPP_Object
{
	public function getRowCount()
	{
		return count($this->_data['DataRow']);
	}
}
