<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_PayrollItem extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(
			'Id' => true,
			'MetaData' => true,
			'Unique Identifier' => true,
			'Name' => true,
			'Active' => true,
			'Type' => true,
		);
	}
}
