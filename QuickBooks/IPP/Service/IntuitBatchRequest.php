<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_IntuitBatchRequest extends QuickBooks_IPP_Service
{
	
	public function sendRequest($Context, $realm, $xml)
	{
		return parent::_sendBatchRequest($Context, $realm, $xml);
	}
	
}
