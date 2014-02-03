<?php

/**
 * 
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @license LICENSE.txt
 * @author Keith Palmer <Keith@ConsoliBYTE.com>
 * 
 * @package QuickBooks
 * @subpackage IPP
 */


QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_CreditMemo extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = null;
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CREDITMEMO, $xml);
	}
	
	/** 
	 * Add a new Credit Memo to IDS/QuickBooks
	 * 
	 * @param QuickBooks_IPP_Context $Context
	 * @param string $realmID
	 * @param QuickBooks_IPP_Object_CreditMemo $Object			The Credit Memo to add
	 * @return string											The Id value of the new credit memo
	 */
	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CREDITMEMO, $Object);
	}
	
	public function delete($Context, $realmID, $ID)
	{
		return parent::_delete($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CREDITMEMO, $ID);
	}

	public function query($Context, $realm, $query)
	{
		return parent::_query($Context, $realm, $query);
	}

	public function findById($Context, $realmID, $ID, $domain = null)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CREDITMEMO, $ID, $domain, $xml);
	}
}