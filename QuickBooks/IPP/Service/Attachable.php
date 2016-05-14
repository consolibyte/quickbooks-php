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
 * @author Ryan Bantz <ryan@rykelabs.com>
 *
 * @package QuickBooks
 * @subpackage IPP
 */


QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Attachable extends QuickBooks_IPP_Service
{
	public function query($Context, $realm, $query)
	{
		return parent::_query($Context, $realm, $query);
	}

	public function download($Context, $realmID, $ID)
	{
		return parent::_download($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DOWNLOAD, $ID);
	}

}
