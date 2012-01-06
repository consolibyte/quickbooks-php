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

class QuickBooks_IPP_Service_Company extends QuickBooks_IPP_Service
{
	/**
	 * Get a company by realmID 
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realmID					
	 * @return QuickBooks_IPP_Object_Customer	The customer object
	 */
	public function findById($Context, $realmID)
	{
		$xml = null;
		
		// WATCH OUT!   We pass in the realmID as ID value
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_COMPANY, $realmID, $xml);
	}
}