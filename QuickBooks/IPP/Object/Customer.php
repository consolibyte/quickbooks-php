<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Customer extends QuickBooks_IPP_Object
{
	protected function _defaults()
	{
		return array(
			'TypeOf' => 'Person', 
			);
	}
	
	protected function _order()
	{
		return array(
			'Id' => true, 
			'SyncToken' => true, 
			'MetaData' => true, 
			'Synchronized' => true, 
			'CustomField' => true, 
			'PartyReferenceId' => true, 
			'TypeOf' => true, 
			'Name' => true, 
			'Address' => true, 
			'Phone' => true, 
			'Website' => true, 
			'Email' => true, 
			'Title' => true, 
			'GivenName' => true, 
			'MiddleName' => true, 
			'FamilyName' => true, 
			'Suffix' => true, 
			'Gender' => true, 
			'BirthDate' => true, 
			'LegalName' => true, 
			'DBAName' => true, 
			'TaxIdentifier' => true, 
			'Notes' => true, 
			'Active' => true, 
			'ShowAs' => true, 
			'CustomerTypeId' => true, 
			'CustomerTypeName' => true, 
			'SalesTermId' => true, 
			'SalesTermName' => true, 
			'SalesRepId' => true, 
			'SalesRepName' => true, 
			'SalesTaxCodeId' => true, 
			'SalesTaxCodeName' => true, 
			'TaxId' => true, 
			'TaxName' => true, 
			'TaxGroupId' => true, 
			'TaxGroupName' => true, 
			'PaymentMethodId' => true, 
			'PaymentMethodName' => true, 
			'PriceLevelId' => true, 
			'PriceLevelName' => true, 
			'OpenBalance' => true, 
			'OpenBalanceDate' => true, 
			'OpenBalanceWithJobs' => true, 
			'CreditLimit' => true, 
			'AcctNum' => true, 
			'OverDueBalance' => true, 
			'TotalRevenue' => true, 
			'TotalExpense' => true, 
			'JobInfo' => true, 		
			);
	}
}

