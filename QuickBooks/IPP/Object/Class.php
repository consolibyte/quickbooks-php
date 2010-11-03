<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Class extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(
			'Id' => true, 
			'MetaData' => true, 
			'Name' => true, 
			'ClassParentId' => true, 
			'ClassParentName' => true, 
			'Active' => true, 
			);
	}
}
