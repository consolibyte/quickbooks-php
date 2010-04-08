<?php

/**
 * Schema object for: ARRefundCreditCardAddRq
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
class QuickBooks_QBXML_Schema_Object_ARRefundCreditCardAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ARRefundCreditCardAdd CustomerRef ListID' => 'IDTYPE',
  'ARRefundCreditCardAdd CustomerRef FullName' => 'STRTYPE',
  'ARRefundCreditCardAdd RefundFromAccountRef ListID' => 'IDTYPE',
  'ARRefundCreditCardAdd RefundFromAccountRef FullName' => 'STRTYPE',
  'ARRefundCreditCardAdd ARAccountRef ListID' => 'IDTYPE',
  'ARRefundCreditCardAdd ARAccountRef FullName' => 'STRTYPE',
  'ARRefundCreditCardAdd TxnDate' => 'DATETYPE',
  'ARRefundCreditCardAdd RefNumber' => 'STRTYPE',
  'ARRefundCreditCardAdd Address Addr1' => 'STRTYPE',
  'ARRefundCreditCardAdd Address Addr2' => 'STRTYPE',
  'ARRefundCreditCardAdd Address Addr3' => 'STRTYPE',
  'ARRefundCreditCardAdd Address Addr4' => 'STRTYPE',
  'ARRefundCreditCardAdd Address Addr5' => 'STRTYPE',
  'ARRefundCreditCardAdd Address City' => 'STRTYPE',
  'ARRefundCreditCardAdd Address State' => 'STRTYPE',
  'ARRefundCreditCardAdd Address PostalCode' => 'STRTYPE',
  'ARRefundCreditCardAdd Address Country' => 'STRTYPE',
  'ARRefundCreditCardAdd Address Note' => 'STRTYPE',
  'ARRefundCreditCardAdd PaymentMethodRef ListID' => 'IDTYPE',
  'ARRefundCreditCardAdd PaymentMethodRef FullName' => 'STRTYPE',
  'ARRefundCreditCardAdd Memo' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => 'INTTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => 'INTTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => 'ENUMTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => 'ENUMTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => 'INTTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => 'ENUMTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => 'ENUMTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => 'ENUMTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => 'STRTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => 'INTTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => 'ENUMTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => 'DATETIMETYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => 'INTTYPE',
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => 'STRTYPE',
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd TxnID' => 'IDTYPE',
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd RefundAmount' => 'AMTTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ARRefundCreditCardAdd CustomerRef ListID' => 0,
  'ARRefundCreditCardAdd CustomerRef FullName' => 209,
  'ARRefundCreditCardAdd RefundFromAccountRef ListID' => 0,
  'ARRefundCreditCardAdd RefundFromAccountRef FullName' => 209,
  'ARRefundCreditCardAdd ARAccountRef ListID' => 0,
  'ARRefundCreditCardAdd ARAccountRef FullName' => 209,
  'ARRefundCreditCardAdd TxnDate' => 0,
  'ARRefundCreditCardAdd RefNumber' => 11,
  'ARRefundCreditCardAdd Address Addr1' => 41,
  'ARRefundCreditCardAdd Address Addr2' => 41,
  'ARRefundCreditCardAdd Address Addr3' => 41,
  'ARRefundCreditCardAdd Address Addr4' => 41,
  'ARRefundCreditCardAdd Address Addr5' => 41,
  'ARRefundCreditCardAdd Address City' => 31,
  'ARRefundCreditCardAdd Address State' => 21,
  'ARRefundCreditCardAdd Address PostalCode' => 13,
  'ARRefundCreditCardAdd Address Country' => 31,
  'ARRefundCreditCardAdd Address Note' => 41,
  'ARRefundCreditCardAdd PaymentMethodRef ListID' => 0,
  'ARRefundCreditCardAdd PaymentMethodRef FullName' => 209,
  'ARRefundCreditCardAdd Memo' => 4095,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => 25,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => 41,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => 41,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => 18,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => 24,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => 60,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => 24,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => 32,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => 12,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => 84,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => 16,
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd TxnID' => 0,
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd RefundAmount' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ARRefundCreditCardAdd CustomerRef ListID' => true,
  'ARRefundCreditCardAdd CustomerRef FullName' => true,
  'ARRefundCreditCardAdd RefundFromAccountRef ListID' => true,
  'ARRefundCreditCardAdd RefundFromAccountRef FullName' => true,
  'ARRefundCreditCardAdd ARAccountRef ListID' => true,
  'ARRefundCreditCardAdd ARAccountRef FullName' => true,
  'ARRefundCreditCardAdd TxnDate' => true,
  'ARRefundCreditCardAdd RefNumber' => true,
  'ARRefundCreditCardAdd Address Addr1' => true,
  'ARRefundCreditCardAdd Address Addr2' => true,
  'ARRefundCreditCardAdd Address Addr3' => true,
  'ARRefundCreditCardAdd Address Addr4' => true,
  'ARRefundCreditCardAdd Address Addr5' => true,
  'ARRefundCreditCardAdd Address City' => true,
  'ARRefundCreditCardAdd Address State' => true,
  'ARRefundCreditCardAdd Address PostalCode' => true,
  'ARRefundCreditCardAdd Address Country' => true,
  'ARRefundCreditCardAdd Address Note' => true,
  'ARRefundCreditCardAdd PaymentMethodRef ListID' => true,
  'ARRefundCreditCardAdd PaymentMethodRef FullName' => true,
  'ARRefundCreditCardAdd Memo' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => true,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => true,
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd TxnID' => false,
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd RefundAmount' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ARRefundCreditCardAdd CustomerRef ListID' => 999.99,
  'ARRefundCreditCardAdd CustomerRef FullName' => 999.99,
  'ARRefundCreditCardAdd RefundFromAccountRef ListID' => 999.99,
  'ARRefundCreditCardAdd RefundFromAccountRef FullName' => 999.99,
  'ARRefundCreditCardAdd ARAccountRef ListID' => 999.99,
  'ARRefundCreditCardAdd ARAccountRef FullName' => 999.99,
  'ARRefundCreditCardAdd TxnDate' => 999.99,
  'ARRefundCreditCardAdd RefNumber' => 999.99,
  'ARRefundCreditCardAdd Address Addr1' => 999.99,
  'ARRefundCreditCardAdd Address Addr2' => 999.99,
  'ARRefundCreditCardAdd Address Addr3' => 999.99,
  'ARRefundCreditCardAdd Address Addr4' => 2,
  'ARRefundCreditCardAdd Address Addr5' => 6,
  'ARRefundCreditCardAdd Address City' => 999.99,
  'ARRefundCreditCardAdd Address State' => 999.99,
  'ARRefundCreditCardAdd Address PostalCode' => 999.99,
  'ARRefundCreditCardAdd Address Country' => 999.99,
  'ARRefundCreditCardAdd Address Note' => 6,
  'ARRefundCreditCardAdd PaymentMethodRef ListID' => 999.99,
  'ARRefundCreditCardAdd PaymentMethodRef FullName' => 999.99,
  'ARRefundCreditCardAdd Memo' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => 0,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => 6,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => 7,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => 6,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => 999.99,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => 6,
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd TxnID' => 0,
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd RefundAmount' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ARRefundCreditCardAdd CustomerRef ListID' => false,
  'ARRefundCreditCardAdd CustomerRef FullName' => false,
  'ARRefundCreditCardAdd RefundFromAccountRef ListID' => false,
  'ARRefundCreditCardAdd RefundFromAccountRef FullName' => false,
  'ARRefundCreditCardAdd ARAccountRef ListID' => false,
  'ARRefundCreditCardAdd ARAccountRef FullName' => false,
  'ARRefundCreditCardAdd TxnDate' => false,
  'ARRefundCreditCardAdd RefNumber' => false,
  'ARRefundCreditCardAdd Address Addr1' => false,
  'ARRefundCreditCardAdd Address Addr2' => false,
  'ARRefundCreditCardAdd Address Addr3' => false,
  'ARRefundCreditCardAdd Address Addr4' => false,
  'ARRefundCreditCardAdd Address Addr5' => false,
  'ARRefundCreditCardAdd Address City' => false,
  'ARRefundCreditCardAdd Address State' => false,
  'ARRefundCreditCardAdd Address PostalCode' => false,
  'ARRefundCreditCardAdd Address Country' => false,
  'ARRefundCreditCardAdd Address Note' => false,
  'ARRefundCreditCardAdd PaymentMethodRef ListID' => false,
  'ARRefundCreditCardAdd PaymentMethodRef FullName' => false,
  'ARRefundCreditCardAdd Memo' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultCode' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSZip' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp' => false,
  'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID' => false,
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd TxnID' => false,
  'ARRefundCreditCardAdd RefundAppliedToTxnAdd RefundAmount' => false,
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
  0 => 'ARRefundCreditCardAdd',
  1 => 'ARRefundCreditCardAdd CustomerRef',
  2 => 'ARRefundCreditCardAdd CustomerRef ListID',
  3 => 'ARRefundCreditCardAdd CustomerRef FullName',
  4 => 'ARRefundCreditCardAdd RefundFromAccountRef ListID',
  5 => 'ARRefundCreditCardAdd RefundFromAccountRef FullName',
  6 => 'ARRefundCreditCardAdd ARAccountRef ListID',
  7 => 'ARRefundCreditCardAdd ARAccountRef FullName',
  8 => 'ARRefundCreditCardAdd TxnDate',
  9 => 'ARRefundCreditCardAdd RefNumber',
  10 => 'ARRefundCreditCardAdd Address Addr1',
  11 => 'ARRefundCreditCardAdd Address Addr2',
  12 => 'ARRefundCreditCardAdd Address Addr3',
  13 => 'ARRefundCreditCardAdd Address Addr4',
  14 => 'ARRefundCreditCardAdd Address Addr5',
  15 => 'ARRefundCreditCardAdd Address City',
  16 => 'ARRefundCreditCardAdd Address State',
  17 => 'ARRefundCreditCardAdd Address PostalCode',
  18 => 'ARRefundCreditCardAdd Address Country',
  19 => 'ARRefundCreditCardAdd Address Note',
  20 => 'ARRefundCreditCardAdd PaymentMethodRef ListID',
  21 => 'ARRefundCreditCardAdd PaymentMethodRef FullName',
  22 => 'ARRefundCreditCardAdd Memo',
  23 => 'ARRefundCreditCardAdd',
  24 => 'ARRefundCreditCardAdd CreditCardTxnInfo',
  25 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo',
  26 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardNumber',
  27 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationMonth',
  28 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo ExpirationYear',
  29 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo NameOnCard',
  30 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardAddress',
  31 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardPostalCode',
  32 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CommercialCardCode',
  33 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo TransactionMode',
  34 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnInputInfo CreditCardTxnType',
  35 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultCode',
  36 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ResultMessage',
  37 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CreditCardTransID',
  38 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo MerchantAccountNumber',
  39 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AuthorizationCode',
  40 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSStreet',
  41 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo AVSZip',
  42 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo CardSecurityCodeMatch',
  43 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ReconBatchID',
  44 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentGroupingCode',
  45 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo PaymentStatus',
  46 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationTime',
  47 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo TxnAuthorizationStamp',
  48 => 'ARRefundCreditCardAdd CreditCardTxnInfo CreditCardTxnResultInfo ClientTransID',
  49 => 'ARRefundCreditCardAdd RefundAppliedToTxnAdd TxnID',
  50 => 'ARRefundCreditCardAdd RefundAppliedToTxnAdd RefundAmount',
  51 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>