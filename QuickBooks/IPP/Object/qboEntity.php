<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_qboEntity extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(
			'qboId' => true, 
			'qboEntityType' => true, 
			'qboLastUpdatedTime' => true, 
		);
	}
}
