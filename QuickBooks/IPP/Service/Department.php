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
 * @author Thomas Rientjes
 * 
 * @package QuickBooks
 * @subpackage IPP
 */


QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Department extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID)
	{
		$xml = null;
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DEPARTMENT, $xml);
	}

	/**
	 * Get a department by ID
	 *
	 * @param QuickBooks_IPP_Context $Context
	 * @param string $realmID
	 * @param $IDType
	 * @return QuickBooks_IPP_Object_Department The department object
	 */
	public function findById($Context, $realmID, $IDType)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DEPARTMENT, $IDType, $xml);
	}
	
	/**
	 * Add a new department to QuickBooks
	 *
	 * @param QuickBooks_IPP_Context $Context
	 * @param string $realmID
	 * @param QuickBooks_IPP_Object_Department
	 * @return string The new ID of the created department
	 */
	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DEPARTMENT, $Object);
	}

	public function query($Context, $realm, $query)
	{
		return parent::_query($Context, $realm, $query);
	}
}