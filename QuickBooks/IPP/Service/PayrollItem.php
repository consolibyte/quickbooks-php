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

class QuickBooks_IPP_Service_PayrollItem extends QuickBooks_IPP_Service
{
	public function findAll($Context, $realmID, $query = null, $page = 1, $size = 50, $options = array())
	{
		return parent::_findAll($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_PAYROLLITEM, $query, null, $page, $size, '', $options);
	}
	
	public function findById($Context, $realmID, $ID)
	{
		$xml = null;
		return parent::_findById($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_PAYROLLITEM, $ID, $xml);
	}
	
	public function findByName($Context, $realmID, $name)
	{
		$list = $this->findAll($Context, $realmID, $name);
		
		foreach ($list as $Item)
		{
			if (strtolower($Item->getName()) == strtolower($name))
			{
				return $Item;
			}
		}
		
		return false;
	}
	
	public function add($Context, $realmID, $Object)
	{
		return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_PAYROLLITEM, $Object);
	}
	
	public function delete($Context, $realmID, $IDType)
	{
		return parent::_delete($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_PAYROLLITEM, $IDType);
	}
}