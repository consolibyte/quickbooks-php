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
	
	public function setTotalAmt($amt)
	{
		return $this->setAmountType('TotalAmt', $amt);
	}
	
	protected function _order()
	{
		return array(
			'DocNumber' => true, 
			'TxnDate' => true, 
			'Note' => true, 
			'Status' => true,
			'VendorId' => true, 
            'VendorName' => true,
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
			'PaymentMethodId' => true, 
			'PaymentMethodName' => true, 
			'TotalAmt' => true, 			// This needs to be almost last for Payments (or at least after PaymentMethodName)
			'BillAddr' => true,  			// Not part of SalesReceipt
			'ShipAddr' => true, 
			'BillEmail' => true,
			'ShipMethodId' => true, 	
			'ShipMethodName' => true, 
			'Balance' => true, 				// Not part of SalesReceipt
			'DepositToAccountId' => true, 	
			'DepositToAccountName' => true, 
			'Detail' => true, 
			'DiscountAmt' => true, 	
			'DiscountRate' => true, 
			'DiscountAccountId' => true, 
			'DiscountAccountName' => true, 
			'DiscountTaxable' => true, 
			);
	}
}
