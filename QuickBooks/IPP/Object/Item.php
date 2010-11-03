<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Item extends QuickBooks_IPP_Object
{
	protected function _order()
	{
		return array(
			'Id' => true, 
			'MetaData' => true, 
			'ItemParentId' => true, 
			'Unique Identifier' => true, 
			'ItemParentName' => true, 
			'Name' => true, 
			'Desc' => true, 
			'Taxable' => true, 
			'Active' => true, 
			'UnitPrice' => true, 
			'Type' => true, 
			'UOMId' => true, 
			'UOMAbbrv' => true, 
			'IncomeAccountRef' => true, 
			'PurchaseDesc' => true, 
			'PurchaseCost' => true, 
			'ExpenseAccountRef' => true, 
			'COGSAccountRef' => true, 
			'AssetAccountRef' => true, 
			'PrefVendorRef' => true, 
			'AvgCost' => true, 
			'QtyOnHand' => true, 
			'QtyOnPurchaseOrder' => true, 
			'QtyOnSalesOrder' => true, 
			'ReorderPoint' => true, 
			'ManPartNum' => true, 	
		);
	}
}
