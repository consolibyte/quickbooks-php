<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Department extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(
			'Id' => true, 
			'MetaData' => true, 
			'Name' => true, 
			'DepartmentParentId' => true,
			'DepartmentParentName' => true,
			'Active' => true, 
		);
	}
}
