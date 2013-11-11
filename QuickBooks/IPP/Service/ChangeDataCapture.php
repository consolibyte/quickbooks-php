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

class QuickBooks_IPP_Service_ChangeDataCapture extends QuickBooks_IPP_Service
{
	public function cdc($Context, $realmID, $entities, $timestamp, $page = 1, $size = null)
	{
		return parent::_cdc($Context, $realmID, $entities, $timestamp, $page, $size);
	}
	
}