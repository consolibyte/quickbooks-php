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


QuickBooks_Loader::load('/QuickBooks/IPP/Service/Report.php');

class QuickBooks_IPP_Service_Report_AccountBalances extends QuickBooks_IPP_Service_Report
{
	public function report($Context, $realmID)
	{
		$xml = null;
		return parent::_report($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_REPORT_ACCOUNTBALANCES, $xml);
	}
}