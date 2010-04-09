<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_MetaData extends QuickBooks_IPP_Object
{
	public function getLastUpdatedTime($format = null)
	{
		if ($format)
		{
			return date($format, strtotime($this->get('LastUpdatedTime')));
		}
		
		return $this->get('LastUpdatedTime');
	}
}
