<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Header extends QuickBooks_IPP_Object
{
	public function setTxnDate($value)
	{
		return $this->setDateType('TxnDate', $value);
	}
	
	public function getTxnDate($format = 'Y-m-d')
	{
		return $this->getDateType('TxnDate', $format);
	}
	
	protected function _order()
	{
		return array(
			'DocNumber' => true, 
			'TxnDate' => true, 
			'Note' => true, 
			'Status' => true, 
			'CustomerId' => true, 
			'CustomerName' => true, 
			'JobId' => true, 
			'JobName' => true, 
			'RemitToId' => true, 
			'RemitToName' => true, 
			'ClassId' => true, 
			'ClassName' => true, 
			'SalesRepId' => true, 
			'SalesRepName' => true, 
			'SalesTaxCodeId' => true, 
			'SalesTaxCodeName' => true, 
			'PONumber' => true, 
			'FOB' => true, 
			'ShipDate' => true, 
			'SubTotalAmt' => true, 
			'TaxId' => true, 
			'TaxName' => true, 
			'TaxGroupId' => true, 
			'TaxGroupName' => true, 
			'TaxRate' => true, 
			'TaxAmt' => true, 
			'ToBePrinted' => true, 
			'ToBeEmailed' => true, 
			'Custom' => true,
			'BillAddr' => true,  			// Not part of SalesReceipt
			'ShipAddr' => true, 
			'ShipMethodId' => true, 	
			'ShipMethodName' => true, 
			'Balance' => true, 				// Not part of SalesReceipt
			'DepositToAccountId' => true, 	
			'DepositToAccountName' => true, 
			'PaymentMethodId' => true, 
			'PaymentMethodName' => true, 
			'Detail' => true, 
			'DiscountAmt' => true, 	
			'DiscountRate' => true, 
			'DiscountAccountId' => true, 
			'DiscountAccountName' => true, 
			'DiscountTaxable' => true, 
			'TotalAmt' => true, 			// This needs to be almost last for Payments (or at least after PaymentMethodName)
			);
	}
}
