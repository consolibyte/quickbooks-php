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

class QuickBooks_IPP_Service_Customer extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID, $query = null, $page = 1, $size = 50, $options = array())
	{
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $query, null, $page, $size, '', $options);
	}

	/**
	 * Get a customer by ID 
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realmID					
	 * @param string $ID						The ID of the customer (this expects an IdType, which includes the domain)
	 * @return QuickBooks_IPP_Object_Customer	The customer object
	 */
	public function findById($Context, $realmID, $IDType, $query = null)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $IDType, $xml, $query);
	}
	
	/**
	 * Get a customer by name
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realmID					
	 * @param string $name						The name of the customer 
	 * @return QuickBooks_IPP_Object_Customer	The customer object
	 */
	public function findByName($Context, $realmID, $name)
	{
		$xml = null;
		return parent::_findByName($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $name, $xml);
	}
	
	/**
	 * Delete a customer from IDS/QuickBooks
	 *
	 *
	 */
	public function delete($Context, $realmID, $IDType)
	{
		return parent::_delete($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $IDType);
	}
	
	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $Object);
	}
	
	public function update($Context, $realmID, $IDType, $Object)
	{
		return parent::_update($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $Object, $IDType);
	}
}