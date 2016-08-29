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

class QuickBooks_IPP_Service_TaxService extends QuickBooks_IPP_Service
{
	public function query($Context, $realm, $query)
	{
		return parent::_query($Context, $realm, $query);
	}
	
	public function add($Context, $realmID, $Object)
	{
		// TaxService needs to append the /taxcode as well (ie. taxservice/taxcode) because its special I guess
		// @author jbaldock 2016-07-28 added to support JSON requests which this method absolutely requires on QB API (they do not support XML for this method)
		return parent::_add_json($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_TAXSERVICE . '/' . QuickBooks_IPP_IDS::RESOURCE_TAXCODE, $Object);
	}
}