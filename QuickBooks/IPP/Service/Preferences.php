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

class QuickBooks_IPP_Service_Preferences extends QuickBooks_IPP_Service
{
	/**
	 * Get a company by realmID 
	 * 
	 * @param QuickBooks_IPP_Context $Context	
	 * @param string $realmID					
	 * @return QuickBooks_IPP_Object_Customer	The customer object
	 */
	public function query($Context, $realm, $query)
	{
		return parent::_query($Context, $realm, $query);
	}

	public function get($Context, $realm)
	{
		if ($list = parent::_query($Context, $realm, "SELECT * FROM Preferences"))
		{
			return $list[0];
		}

		return false;
	}
}