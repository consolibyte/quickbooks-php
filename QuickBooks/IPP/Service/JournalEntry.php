<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_JournalEntry extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = null;
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_JOURNALENTRY, $xml);
	}
}