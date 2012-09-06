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
 * @author Jared Cheney <jared@tsheets.com>
 * 
 * @package QuickBooks
 * @subpackage IPP
 */


QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_TimeActivity extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID, $query = null, $page = 1, $size = 50, $options = array())
	{
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_TIMEACTIVITY, $query, null, $page, $size, '', $options);
	}

	/**
	 * Get a timeactivity by ID 
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realmID					
	 * @param string $ID						The ID of the timeactivity (this expects an IdType, which includes the domain)
	 * @return QuickBooks_IPP_Object_TimeActivity	The timeactivity object
	 */
	public function findById($Context, $realmID, $IDType, $query = null)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_TIMEACTIVITY, $IDType, $xml, $query);
	}
	
	/**
	 * Delete a timeactivity from IDS/QuickBooks
	 *
	 *
	 */
	public function delete($Context, $realmID, $IDType)
	{
		return parent::_delete($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_TIMEACTIVITY, $IDType);
	}
	
	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_TIMEACTIVITY, $Object);
	}
	
	public function update($Context, $realmID, $IDType, $Object)
	{
		return parent::_update($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_TIMEACTIVITY, $Object, $IDType);
	}
}