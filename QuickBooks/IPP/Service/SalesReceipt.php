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

class QuickBooks_IPP_Service_SalesReceipt extends QuickBooks_IPP_Service
{
	public function update($Context, $realmID, $IDType, $Object)
	{
		return parent::_update($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, $Object, $IDType);
	}
	
	/**
	 * Add a new sales receipt to IDS/QuickBooks
	 *
	 * @param QuickBooks_IPP_Context $Context
	 * @param string $realmID
	 * @param QuickBooks_IPP_Object_SalesReceipt $Object		The sales receipt to add
	 * @return string											The Id value of the new sales receipt
	 */
	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, $Object);
	}	

	public function query($Context, $realm, $query)
	{
		return parent::_query($Context, $realm, $query);
	}

	public function findById($Context, $realmID, $ID, $domain = null)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, $ID, $domain, $xml);
	}

	public function delete($Context, $realmID, $IDType)
	{
		return parent::_delete($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, $IDType);
	}

	public function void($Context, $realmID, $IDType)
	{
		return parent::_void($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, $IDType);
	}

	public function pdf($Context, $realmID, $IDType)
	{
		return parent::_pdf($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, $IDType);
	}

	public function send($Context, $realmID, $IDType)
	{
		return parent::_send($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, $IDType);
	}
}