<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service/Report.php');

class QuickBooks_IPP_Service_Report_TopCustomersBySales extends QuickBooks_IPP_Service_Report
{
	public function report($Context, $realmID)
	{
		$xml = null;
		return parent::_report($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_REPORT_TOPCUSTOMERSBYSALES, $xml);
	}
}