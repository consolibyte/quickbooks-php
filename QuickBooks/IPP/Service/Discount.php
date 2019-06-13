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

// 
QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Discount extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID, $query = null, $page = 1, $size = 50)
	{
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DISCOUNT, $query, null, $page, $size);
	}

	/**
	 * Get a customer by ID 
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realmID					
	 * @param string $ID						The ID of the discount (this expects an IdType, which includes the domain)
	 * @return QuickBooks_IPP_Object_Discount	The Discount object
	 */
	public function findById($Context, $realmID, $ID)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DISCOUNT, $ID, $xml);
	}

}