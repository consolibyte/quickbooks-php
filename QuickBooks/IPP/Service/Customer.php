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
	public function findAll($Context, $realm, $query = null, $page = 1, $size = 50, $options = array())
	{
		return parent::_findAll($Context, $realm, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $query, null, $page, $size, '', $options);
	}

	/**
	 * Get a customer by ID 
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realm					
	 * @param string $ID						The ID of the customer (this expects an IdType, which includes the domain)
	 * @return QuickBooks_IPP_Object_Customer	The customer object
	 */
	public function findById($Context, $realm, $IDType, $query = null)
	{
		$xml = null;
		return parent::_findById($Context, $realm, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $IDType, $xml, $query);
	}
	
	/**
	 * Get a customer by name
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realm					
	 * @param string $name						The name of the customer 
	 * @return QuickBooks_IPP_Object_Customer	The customer object
	 */
	public function findByName($Context, $realm, $name)
	{
		$xml = null;
		return parent::_findByName($Context, $realm, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $name, $xml);
	}
	
	/**
	 * Delete a customer from IDS/QuickBooks
	 *
	 *
	 */
	public function delete($Context, $realm, $IDType)
	{
		return parent::_delete($Context, $realm, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $IDType);
	}
	
	public function add($Context, $realm, $Object)
	{
		return parent::_add($Context, $realm, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $Object);
	}
	
	public function update($Context, $realm, $IDType, $Object)
	{
		return parent::_update($Context, $realm, QuickBooks_IPP_IDS::RESOURCE_CUSTOMER, $Object, $IDType);
	}

	public function query($Context, $realm, $query)
	{
		return parent::_query($Context, $realm, $query);
	}
}