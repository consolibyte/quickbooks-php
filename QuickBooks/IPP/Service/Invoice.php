<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Invoice extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = '<InvoiceQuery xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.intuit.com/sb/cdm/v2"></InvoiceQuery>';
		
		return parent::findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_INVOICE, $xml);
	}
}