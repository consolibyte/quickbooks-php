<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_TimeActivity extends QuickBooks_IPP_Object
{
	protected function _defaults()
	{
		return array(
			);
	}
	
	protected function _order()
	{
		/*
		return array(
			'Id' => true, 
			'SyncToken' => true, 
			'MetaData' => true, 
			'Synchronized' => true, 
			'Draft' => true, 
			'TxnDate' => true, 
			'NameOf' => true, 
			'Employee' => true, 
			'CustomerId' => true, 
			'JobId' => true, 
			'ItemId' => true, 
			'ItemType' => true, 
			'PayItemId' => true, 
			'BillableStatus' => true, 
			'HourlyRate' => true, 
			'Hours' => true, 
			'Minutes' => true, 
			'Seconds' => true, 
			'StartTime' => true, 
			'EndTime' => true, 
			'Description' => true, 
			);
		*/

		return array(
			'Id' => true, 
			'SyncToken' => true, 
			'MetaData' => true, 
			'Synchronized' => true, 
			'Draft' => true, 
			'TxnDate' => true, 
			'NameOf' => true, 
			'Employee' => true, 
			'CustomerId' => true, 
			'CustomerName' => true, // added CustomerName
			'JobId' => true, 
			'ItemId' => true, 
			'ItemName' => true, // added ItemName
			'ItemType' => true, 
			'ClassId' => true, // added ClassId
			'PayItemId' => true, 
			'BillableStatus' => true, 
			'HourlyRate' => true, 
			'Hours' => true, 
			'Minutes' => true, 
			'Seconds' => true, 
			'StartTime' => true, 
			'EndTime' => true, 
			'Description' => true, 
			);
	}
}

