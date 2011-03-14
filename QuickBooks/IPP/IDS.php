<?php

/**
 * QuickBooks IPP/IDS constants
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <Keith@ConsoliBYTE.com>
 * 
 * @package QuickBooks
 * @subpackage IPP
 */

/**
 * 
 * 
 * 
 */
class QuickBooks_IPP_IDS
{
	const OPTYPE_ADD = 'Add';
	
	const OPTYPE_MOD = 'Mod';
	
	const OPTYPE_DELETE = 'Delete';
	
	const OPTYPE_QUERY = 'Query';
	
	const OPTYPE_REPORT = 'Report';
	
	const DOMAIN_NG = 'ng';
	
	const DOMAIN_QB = 'qb';
	
	const VERSION_1 = 'v1';
	
	const VERSION_2 = 'v2';
	
	const VERSION_LATEST = 'v2';
	
	
	const RESOURCE_REPORT_ACCOUNTBALANCES = 'ReportAccountBalances';
	
	const RESOURCE_REPORT_BALANCESHEET = 'ReportBalanceSheet';
	
	const RESOURCE_REPORT_CUSTOMERSWHOOWEME = 'ReportCustomersWhoOweMe';
	
	const RESOURCE_REPORT_INCOMEBREAKDOWN = 'ReportIncomeBreakdown';
	
	const RESOURCE_REPORT_PROFITANDLOSS = 'ReportProfitAndLoss';
	
	const RESOURCE_REPORT_SALESSUMMARY = 'ReportSalesSummary';
	
	const RESOURCE_REPORT_TOPCUSTOMERSBYSALES = 'ReportTopCustomersBySales';
	
	
	const RESOURCE_ACCOUNT = 'Account';
	
	const RESOURCE_BILL = 'Bill';
	
	const RESOURCE_BILLPAYMENT = 'BillPayment';
	
	const RESOURCE_BILLPAYMENTCREDITCARD = 'BillPaymentCreditCard';
	
	const RESOURCE_CHECK = 'Check';
	
	const RESOURCE_CLASS = 'Class';
	
	const RESOURCE_CREDITMEMO = 'CreditMemo';
	
	const RESOURCE_CUSTOMER = 'Customer';
	
	const RESOURCE_DISCOUNT = 'Discount';
	
	const RESOURCE_EMPLOYEE = 'Employee';
	
	const RESOURCE_ESTIMATE = 'Estimate';
	
	const RESOURCE_INVOICE = 'Invoice';
	
	const RESOURCE_INVENTORYADJUSTMENT = 'InventoryAdjustment';
	
	const RESOURCE_ITEM = 'Item';
	
	const RESOURCE_ITEMCONSOLIDATED = 'ItemConsolidated';
	
	const RESOURCE_ITEMRECEIPT = 'ItemReceipt';
	
	const RESOURCE_JOB = 'Job';
	
	const RESOURCE_JOURNALENTRY = 'JournalEntry';
	
	const RESOURCE_PAYMENT = 'Payment';
	
	const RESOURCE_PAYMENTMETHOD = 'PaymentMethod';
	
	const RESOURCE_PREFERENCES = 'Preferences';
	
	const RESOURCE_PURCHASEORDER = 'PurchaseOrder';
	
	const RESOURCE_SALESORDER = 'SalesOrder';
	
	const RESOURCE_SALESRECEIPT = 'SalesReceipt';
	
	const RESOURCE_SALESREP = 'SalesRep';
	
	const RESOURCE_SALESTAX = 'SalesTax';
	
	const RESOURCE_SALESTAXCODE = 'SalesTaxCode';
	
	const RESOURCE_SHIPMETHOD = 'ShipMethod';
	
	const RESOURCE_TERM = 'Term';
	
	const RESOURCE_UOM = 'UOM';
	const RESOURCE_UNITOFMEASURE = 'UOM';
	
	const RESOURCE_VENDOR = 'Vendor';
	
	const RESOURCE_VENDORCREDIT = 'VendorCredit';
	
	/**
	 * 
	 * 
	 * 
	 */
	static public function resourceToKeyType($resource)
	{
		$txns = array(
			QuickBooks_IPP_IDS::RESOURCE_BILL, 
			QuickBooks_IPP_IDS::RESOURCE_BILLPAYMENT,
			QuickBooks_IPP_IDS::RESOURCE_BILLPAYMENTCREDITCARD, 
			QuickBooks_IPP_IDS::RESOURCE_CHECK,
			QuickBooks_IPP_IDS::RESOURCE_CREDITMEMO,
			QuickBooks_IPP_IDS::RESOURCE_ESTIMATE, 
			QuickBooks_IPP_IDS::RESOURCE_INVOICE, 
			QuickBooks_IPP_IDS::RESOURCE_ITEMRECEIPT,
			QuickBooks_IPP_IDS::RESOURCE_JOURNALENTRY, 
			QuickBooks_IPP_IDS::RESOURCE_PAYMENT, 
			QuickBooks_IPP_IDS::RESOURCE_PURCHASEORDER, 
			QuickBooks_IPP_IDS::RESOURCE_SALESORDER, 
			QuickBooks_IPP_IDS::RESOURCE_SALESRECEIPT, 
			QuickBooks_IPP_IDS::RESOURCE_VENDORCREDIT,
			);
		
		if (in_array($resource, $txns))
		{
			return 'TransactionId';
		}
		
		return 'ListId';
	}
	
	static public function parseIDType($str)
	{
		// @todo Add validation here so that it always returns the correct types (string/integer)
		$arr = explode('-', trim($str, '{}'));
		
		if (count($arr) == 2)
		{
			$arr['domain'] = $arr[0];
			$arr['ID'] = $arr[1];
			
			return $arr;
		}
		
		return array( 0 => '?', 'domain' => '?', 1 => $str, 'ID' => $str );
	}
	
	static public function buildIDType($domain, $ID)
	{
		return '{' . $domain . '-' . $ID . '}';
	}
}