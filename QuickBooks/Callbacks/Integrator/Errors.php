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
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * 
 */
class QuickBooks_Callbacks_Integrator_Errors
{
	/**
	 *
	 * Error message: 
	 * 	"3170: There was an error when modifying a data extension named 
	 * 	&quot;e-mail&quot;.  QuickBooks error message: This list has been 
	 * 	modified by another user."
	 *
	 * Solution: 
	 * 	Send the request again, it usually goes through the second time.
	 * 
	 * 
	 */
	static public function e3170_errorsaving($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		switch ($action)
		{
			case QUICKBOOKS_MOD_DATAEXT:
				
				// Ignore it for now... oops!
				return true;
			default:
				return false;
		}
		
		// (default clause for switch() statement)
	}	
	
	/**
	 *
	 *
	 *
	 */
	static public function e3180_errorsaving($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		switch ($action)
		{
			case QUICKBOOKS_ADD_DATAEXT:
				
				// Ignore it, this happens when we try to DataExtAdd a DataExt that already exists
				return true;
			default:
				return false;
		}
		
		// (default clause for switch() statement)
	}
	
	static public function e3200_editsequence($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		switch ($action)
		{
			case QUICKBOOKS_MOD_CUSTOMER:
				
				// EditSequence for this customer is out-of-date, query for the customer to get the latest EditSequence, and re-send
				return QuickBooks_Callbacks_Integrator_Callbacks::integrateQueryCustomer($ID);
			default:
				return false;
		}
	}
	
	/**
	 * 
	 * 
	 * 
	 * 
	 */
	static public function e3100_alreadyexists($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		//print('exists!');
		
		// These are special-case handlers, handle these by querying
		switch ($ID)
		{
			case QUICKBOOKS_INTEGRATOR_COUPON_ID:
			case QUICKBOOKS_INTEGRATOR_SHIPPING_ID:
			case QUICKBOOKS_INTEGRATOR_HANDLING_ID:
			case QUICKBOOKS_INTEGRATOR_DISCOUNT_ID:
				
				// @TODO Fix this... I'm not sure whether we should issue another
				//	query (havn't we queried already...?) or just ignore this because
				//	we'll refer to these items by FullName in the requests, so if
				//	it already exists we're golden, or...? 
				
				return true;
				
				switch ($action)
				{
					case QUICKBOOKS_ADD_SERVICEITEM:
						
						break;
					case QUICKBOOKS_ADD_DISCOUNTITEM:
						
						break;
					case QUICKBOOKS_ADD_OTHERCHARGEITEM:
							
						break;
				}
				
				return true;
		}
		
		switch ($action)
		{
			case QUICKBOOKS_ADD_PAYMENTMETHOD:
				
				break;
			case QUICKBOOKS_ADD_SHIPMETHOD:
				
				break;
			case QUICKBOOKS_ADD_NONINVENTORYITEM:
				
				break;
			case QUICKBOOKS_ADD_INVENTORYITEM:
				
				break;
			case QUICKBOOKS_ADD_SERVICEITEM:
				
				
				
				return true;
			case QUICKBOOKS_ADD_CUSTOMER:
				
				// Do a query for the customer
				// @todo Does this have the potential to cause an infinite loop?  Add, taken by Vendor, Query, Add, taken by Vendor, Query, etc. etc. etc.
				//return QuickBooks_Callbacks_Integrator_Callbacks::integrateQueryCustomer($ID);
				return true;
		}
		
		return false;
	}
	
	/** 
	 * This error occurs when we send a request to QuickBooks that has an error, or that QuickBooks doesn't understand (old version of QuickBooks)
	 * 
	 * @param string $requestID
	 * @return boolean
	 */
	static public function e0x80040400_foundanerror($requestID, $user, $action, $ident, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		if ($action == QUICKBOOKS_QUERY_UNITOFMEASURESET)
		{
			// Some versions don't support this query, so ignore this error
			return true;
		}
		
		return false;
	}
	
	static public function e3250_featurenotenabled($requestID, $user, $action, $ident, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		if ($action == QUICKBOOKS_QUERY_UNITOFMEASURESET)
		{
			// Some versions don't support UnitOfMeasureSetQuery
			return true;
		}

		return false;
	}
	
	/**
	 * 
	 * 
	 * 
	 */	
	static public function e_catchall($requestID, $user, $action, $ident, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		if (!empty($config['_error_email']))
		{
			$msg = '';
			$msg .= 'Error number: ' . $errnum . "\r\n";
			$msg .= 'Error message: ' . $errmsg . "\r\n";
			$msg .= "\r\n";
			$msg .= 'Action: ' . $action . "\r\n";
			$msg .= 'Ident: ' . $ident . "\r\n";
			$msg .= "\r\n";
			$msg .= 'Extra: ' . print_r($extra, true) . "\r\n";
			$msg .= "\r\n";
			$msg .= 'qbXML: ' . $xml . "\r\n";
			
			mail($config['_error_email'], $config['_error_subject'], $msg, 'From: ' . $config['_error_from'] . "\r\n");
		}
		
		return false;
	}
}
