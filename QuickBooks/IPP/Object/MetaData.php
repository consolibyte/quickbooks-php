<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_MetaData extends QuickBooks_IPP_Object
{
	public function getLastUpdatedTime($format = 'Y-m-d H:i:s')
	{
		return $this->getDateType('LastUpdatedTime', $format);
	}
	
	protected function _order()
	{
		return array(
			'CreatedBy' => true, 
			'CreatedById' => true, 
			'CreateTime' => true, 
			'LastModifiedBy' => true, 
			'LastModifiedById' => true, 
			'LastUpdatedTime' => true, 
			);
	}
}
