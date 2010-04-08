<?php

/**
 * Schema object for: ReceivePaymentAddRq
 * 
 * @author "Keith Palmer Jr." <Keith@ConsoliByte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage QBXML
 */

/**
 * 
 */
require_once 'QuickBooks.php';

/**
 * 
 */
require_once 'QuickBooks/QBXML/Schema/Object.php';

/**
 * 
 */
class QuickBooks_QBXML_Schema_Object_ReceivePaymentAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ReceivePaymentAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'CustomerRef ListID' => 'IDTYPE',
  'CustomerRef FullName' => 'STRTYPE',
  'ARAccountRef ListID' => 'IDTYPE',
  'ARAccountRef FullName' => 'STRTYPE',
  'TxnDate' => 'DATETYPE',
  'RefNumber' => 'STRTYPE',
  'TotalAmount' => 'AMTTYPE',
  'PaymentMethodRef ListID' => 'IDTYPE',
  'PaymentMethodRef FullName' => 'STRTYPE',
  'Memo' => 'STRTYPE',
  'DepositToAccountRef ListID' => 'IDTYPE',
  'DepositToAccountRef FullName' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => 'INTTYPE',
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => 'INTTYPE',
  'CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => 'ENUMTYPE',
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => 'ENUMTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => 'INTTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => 'ENUMTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => 'ENUMTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => 'ENUMTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => 'STRTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => 'INTTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => 'ENUMTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => 'DATETIMETYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => 'INTTYPE',
  'CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => 'STRTYPE',
  'IsAutoApply' => 'BOOLTYPE',
  'AppliedToTxnAdd TxnID' => 'IDTYPE',
  'AppliedToTxnAdd PaymentAmount' => 'AMTTYPE',
  'AppliedToTxnAdd TxnLineDetail TxnLineID' => 'IDTYPE',
  'AppliedToTxnAdd TxnLineDetail Amount' => 'AMTTYPE',
  'AppliedToTxnAdd SetCredit CreditTxnID' => 'IDTYPE',
  'AppliedToTxnAdd SetCredit TxnLineID' => 'IDTYPE',
  'AppliedToTxnAdd SetCredit AppliedAmount' => 'AMTTYPE',
  'AppliedToTxnAdd DiscountAmount' => 'AMTTYPE',
  'AppliedToTxnAdd DiscountAccountRef ListID' => 'IDTYPE',
  'AppliedToTxnAdd DiscountAccountRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'CustomerRef ListID' => 0,
  'CustomerRef FullName' => 209,
  'ARAccountRef ListID' => 0,
  'ARAccountRef FullName' => 209,
  'TxnDate' => 0,
  'RefNumber' => 20,
  'TotalAmount' => 0,
  'PaymentMethodRef ListID' => 0,
  'PaymentMethodRef FullName' => 209,
  'Memo' => 4095,
  'DepositToAccountRef ListID' => 0,
  'DepositToAccountRef FullName' => 209,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => 25,
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => 0,
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => 0,
  'CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => 41,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => 41,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => 18,
  'CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => 24,
  'CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => 0,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => 0,
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => 0,
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => 60,
  'CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => 24,
  'CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => 32,
  'CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => 12,
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => 0,
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => 0,
  'CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => 0,
  'CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => 84,
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => 0,
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => 0,
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => 0,
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => 0,
  'CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => 16,
  'IsAutoApply' => 0,
  'AppliedToTxnAdd TxnID' => 0,
  'AppliedToTxnAdd PaymentAmount' => 0,
  'AppliedToTxnAdd TxnLineDetail TxnLineID' => 0,
  'AppliedToTxnAdd TxnLineDetail Amount' => 0,
  'AppliedToTxnAdd SetCredit CreditTxnID' => 0,
  'AppliedToTxnAdd SetCredit TxnLineID' => 0,
  'AppliedToTxnAdd SetCredit AppliedAmount' => 0,
  'AppliedToTxnAdd DiscountAmount' => 0,
  'AppliedToTxnAdd DiscountAccountRef ListID' => 0,
  'AppliedToTxnAdd DiscountAccountRef FullName' => 209,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'CustomerRef ListID' => true,
  'CustomerRef FullName' => true,
  'ARAccountRef ListID' => true,
  'ARAccountRef FullName' => true,
  'TxnDate' => true,
  'RefNumber' => true,
  'TotalAmount' => true,
  'PaymentMethodRef ListID' => true,
  'PaymentMethodRef FullName' => true,
  'Memo' => true,
  'DepositToAccountRef ListID' => true,
  'DepositToAccountRef FullName' => true,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => true,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => true,
  'CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => true,
  'CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => true,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => true,
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => true,
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => true,
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => true,
  'CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => true,
  'CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => true,
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => true,
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => true,
  'CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => true,
  'IsAutoApply' => false,
  'AppliedToTxnAdd TxnID' => false,
  'AppliedToTxnAdd PaymentAmount' => true,
  'AppliedToTxnAdd TxnLineDetail TxnLineID' => false,
  'AppliedToTxnAdd TxnLineDetail Amount' => false,
  'AppliedToTxnAdd SetCredit CreditTxnID' => false,
  'AppliedToTxnAdd SetCredit TxnLineID' => false,
  'AppliedToTxnAdd SetCredit AppliedAmount' => false,
  'AppliedToTxnAdd DiscountAmount' => true,
  'AppliedToTxnAdd DiscountAccountRef ListID' => true,
  'AppliedToTxnAdd DiscountAccountRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'CustomerRef ListID' => 999.99,
  'CustomerRef FullName' => 999.99,
  'ARAccountRef ListID' => 999.99,
  'ARAccountRef FullName' => 999.99,
  'TxnDate' => 999.99,
  'RefNumber' => 999.99,
  'TotalAmount' => 999.99,
  'PaymentMethodRef ListID' => 999.99,
  'PaymentMethodRef FullName' => 999.99,
  'Memo' => 999.99,
  'DepositToAccountRef ListID' => 999.99,
  'DepositToAccountRef FullName' => 999.99,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => 999.99,
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => 0,
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => 999.99,
  'CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => 999.99,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => 999.99,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => 999.99,
  'CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => 999.99,
  'CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => 6,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => 7,
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => 6,
  'CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => 999.99,
  'CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => 6,
  'IsAutoApply' => 999.99,
  'AppliedToTxnAdd TxnID' => 0,
  'AppliedToTxnAdd PaymentAmount' => 999.99,
  'AppliedToTxnAdd TxnLineDetail TxnLineID' => 999.99,
  'AppliedToTxnAdd TxnLineDetail Amount' => 999.99,
  'AppliedToTxnAdd SetCredit CreditTxnID' => 0,
  'AppliedToTxnAdd SetCredit TxnLineID' => 999.99,
  'AppliedToTxnAdd SetCredit AppliedAmount' => 999.99,
  'AppliedToTxnAdd DiscountAmount' => 999.99,
  'AppliedToTxnAdd DiscountAccountRef ListID' => 999.99,
  'AppliedToTxnAdd DiscountAccountRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'CustomerRef ListID' => false,
  'CustomerRef FullName' => false,
  'ARAccountRef ListID' => false,
  'ARAccountRef FullName' => false,
  'TxnDate' => false,
  'RefNumber' => false,
  'TotalAmount' => false,
  'PaymentMethodRef ListID' => false,
  'PaymentMethodRef FullName' => false,
  'Memo' => false,
  'DepositToAccountRef ListID' => false,
  'DepositToAccountRef FullName' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => false,
  'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => false,
  'CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => false,
  'IsAutoApply' => false,
  'AppliedToTxnAdd TxnID' => false,
  'AppliedToTxnAdd PaymentAmount' => false,
  'AppliedToTxnAdd TxnLineDetail TxnLineID' => false,
  'AppliedToTxnAdd TxnLineDetail Amount' => false,
  'AppliedToTxnAdd SetCredit CreditTxnID' => false,
  'AppliedToTxnAdd SetCredit TxnLineID' => false,
  'AppliedToTxnAdd SetCredit AppliedAmount' => false,
  'AppliedToTxnAdd DiscountAmount' => false,
  'AppliedToTxnAdd DiscountAccountRef ListID' => false,
  'AppliedToTxnAdd DiscountAccountRef FullName' => false,
  'IncludeRetElement' => true,
);
			
		return $paths;
	}
	
	/*
	abstract protected function &_inLocalePaths()
	{
		static $paths = array(
			'FirstName' => array( 'QBD', 'QBCA', 'QBUK', 'QBAU' ), 
			'LastName' => array( 'QBD', 'QBCA', 'QBUK', 'QBAU' ),
			);
		
		return $paths;
	}
	*/
	
	protected function &_reorderPathsPaths()
	{
		static $paths = array (
  0 => 'CustomerRef ListID',
  1 => 'CustomerRef FullName',
  2 => 'ARAccountRef ListID',
  3 => 'ARAccountRef FullName',
  4 => 'TxnDate',
  5 => 'RefNumber',
  6 => 'TotalAmount',
  7 => 'PaymentMethodRef ListID',
  8 => 'PaymentMethodRef FullName',
  9 => 'Memo',
  10 => 'DepositToAccountRef ListID',
  11 => 'DepositToAccountRef FullName',
  12 => 'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber',
  13 => 'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth',
  14 => 'CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear',
  15 => 'CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard',
  16 => 'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress',
  17 => 'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode',
  18 => 'CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode',
  19 => 'CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode',
  20 => 'CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType',
  21 => 'CreditCardTxnInfo CreditCardTxnResultInfo ResultCode',
  22 => 'CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage',
  23 => 'CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID',
  24 => 'CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber',
  25 => 'CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode',
  26 => 'CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet',
  27 => 'CreditCardTxnInfo CreditCardTxnResultInfo AVSZip',
  28 => 'CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch',
  29 => 'CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID',
  30 => 'CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode',
  31 => 'CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus',
  32 => 'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime',
  33 => 'CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp',
  34 => 'CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID',
  35 => 'IsAutoApply',
  36 => 'AppliedToTxnAdd TxnID',
  37 => 'AppliedToTxnAdd PaymentAmount',
  38 => 'AppliedToTxnAdd TxnLineDetail TxnLineID',
  39 => 'AppliedToTxnAdd TxnLineDetail Amount',
  40 => 'AppliedToTxnAdd SetCredit CreditTxnID',
  41 => 'AppliedToTxnAdd SetCredit TxnLineID',
  42 => 'AppliedToTxnAdd SetCredit AppliedAmount',
  43 => 'AppliedToTxnAdd DiscountAmount',
  44 => 'AppliedToTxnAdd DiscountAccountRef ListID',
  45 => 'AppliedToTxnAdd DiscountAccountRef FullName',
  46 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>