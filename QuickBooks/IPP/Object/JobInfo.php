<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_JobInfo extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(
			'Status' => true, 
			'StartDate' => true, 
			'ProjectedEndDate' => true, 
			'EndDate' => true, 
			'Description' => true, 
			'JobTypeId' => true, 
			'JobTypeName' => true, 
			);
	}
}
