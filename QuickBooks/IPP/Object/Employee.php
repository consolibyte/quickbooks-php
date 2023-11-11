<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Employee extends QuickBooks_IPP_Object
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
			'MetaData' => true, 
			'PartyReferenceId' => true, 	
			'TypeOf' => true, 
			'Name' => true, 
			'Address' => true, 
			'Phone' => true, 
			'WebSite' => true, 
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
			'EmployeeType' => true, 
			'EmployeeNumber' => true, 
			'HiredDate' => true, 
			'ReleasedDate' => true, 
			'UseTimeEntry' => true, 
			);
	}
}

