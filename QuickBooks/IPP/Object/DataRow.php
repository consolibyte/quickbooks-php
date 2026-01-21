<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_DataRow extends QuickBooks_IPP_Object
{
	public function getColumnData($i)
	{
		return $this->get('ColData', $i);
	}
}
