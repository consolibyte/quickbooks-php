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

class QuickBooks_IPP_Service_Estimate extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = null;
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_ESTIMATE, $xml);
	}

	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_ESTIMATE, $Object);
	}

	public function update($Context, $realmID, $IDType, $Object)
	{
		return parent::_update($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_ESTIMATE, $Object, $IDType);
	}

	/**
	 * Get an estimate by ID
	 *
	 * @param QuickBooks_IPP_Context $Context
	 * @param string $realmID
	 * @param string $ID						The ID of the estimate (this expects an IdType, which includes the domain)
	 * @return QuickBooks_IPP_Object_Employee	The estimate object
	 */
	public function findById($Context, $realmID, $ID)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_ESTIMATE, $ID, null, $xml);
	}

	public function query($Context, $realm, $query)
	{
		return parent::_query($Context, $realm, $query);
	}
}