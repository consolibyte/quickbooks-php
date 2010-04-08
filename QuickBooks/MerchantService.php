<?php

/**
 * QuickBooks Merchant Service class 
 * 
 * QuickBooks Merchant Service enables online stores to charge credit cards and 
 * debit cards via simple HTTPS POSTs to the QuickBooks Merchant Service 
 * payment gateway. This class simplifies the process and wraps it in a nice 
 * OOP interface. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 *  
 * @package QuickBooks
 * @subpackage MerchantAccount
 */

/**
 * No error occurred
 * @var integer
 */
define('QUICKBOOKS_MERCHANTSERVICE_OK', QUICKBOOKS_ERROR_OK);

/**
 * No error occurred
 * @var integer
 */
define('QUICKBOOKS_MERCHANTSERVICE_ERROR_OK', QUICKBOOKS_MERCHANTSERVICE_OK);

/**
 * Indicates a generic internal error
 * @param integer
 */
define('QUICKBOOKS_MERCHANTSERVICE_ERROR_INTERNAL', -1091);

/**
 * Indicates an error when parsing an XML stream
 * @param integer
 */
define('QUICKBOOKS_MERCHANTSERVICE_ERROR_XML', -1092);

/**
 * Indicates an error establishing a socket connection to QBMS
 * @param integer
 */
define('QUICKBOOKS_MERCHANTSERVICE_ERROR_SOCKET', -1093);

/**
 * Indicates an error with a parameter passed to QBMS
 * @param integer
 */
define('QUICKBOOKS_MERCHANTSERVICE_ERROR_PARAM', -1094);

/**
 * Indicates an internal SSL-related error
 * @param integer
 */
define('QUICKBOOKS_MERCHANTSERVICE_ERROR_SSL', -1095);

/**
 * 
 * 
 */
define('QUICKBOOKS_MERCHANTSERVICE_ERROR_HTTP', -1096);

/**
 * Indicates that this transaction type is a 'Charge' (actually capture funds on a credit/debit card)
 * @var string
 */
define('QUICKBOOKS_MERCHANTSERVICE_TYPE_CHARGE', 'Charge');

/**
 * Indicates that this transaction type is an 'Authorization' (hold funds, but don't actually charge the card)
 * @var string
 */
define('QUICKBOOKS_MERCHANTSERVICE_TYPE_AUTHORIZE', 'Authorize');

/**
 * Capture the authorized funds on a credit card
 * @var string
 */
define('QUICKBOOKS_MERCHANTSERVICE_TYPE_CAPTURE', 'Capture');

/**
 * Void a pending credit card authorization
 * @var string
 */
define('QUICKBOOKS_MERCHANTSERVICE_TYPE_VOID', 'Void');

/**
 * Refund a credit card payment
 * @var string
 */
define('QUICKBOOKS_MERCHANTSERVICE_TYPE_REFUND', 'Refund');

/**
 * Void or refund, depending on the transaction type/status
 * @var string
 */
define('QUICKBOOKS_MERCHANTSERVICE_TYPE_VOIDORREFUND', 'VoidOrRefund');

/**
 * Constant for the NotAvailable response some fields return 
 * @var string
 */
define('QUICKBOOKS_MERCHANTSERVICE_NOTAVAILABLE', 'NotAvailable');

/**
 * Constant to indicate success
 * @var string
 */
define('QUICKBOOKS_MERCHANTSERVICE_PASS', 'Pass');

define('QUICKBOOKS_MERCHANTSERVICE_FAIL', 'Fail');

define('QUICKBOOKS_MERCHANTSERVICE_SEVERITY_INFO', 'INFO');

define('QUICKBOOKS_MERCHANTSERVICE_SEVERITY_WARN', 'WARN');

define('QUICKBOOKS_MERCHANTSERVICE_SEVERITY_ERROR', 'ERROR');

/*
2000
Authentication failed -- Invalid login name or password / certificate / ticket
2010
Unauthorized
2020
Session Authentication required
2030
Unsupported signon version
2040
Internal err

*/

/**
 * 
 * Status OK, AVS Street and Zip fail, card security code fail
 * 
 * IMPORTANT NOTE: This 
 */
define('QUICKBOOKS_MERCHANTSERVICE_TEST_AVSZIPCVVFAIL', 'configid=10000_avscvdfail');

define('QUICKBOOKS_MERCHANTSERVICE_TEST_COMMUNICATIONERROR', 'configid=10200_comm');

/*
<NameOnCard>configid=value </NameOnCard>
Simply replace “value in the above line with one of the ConfigID values listeds in Table 6-2 
on page 44. 
Table 6-2 ConfigID values and the errors they generate:
Error to be 
Returned ConfigID value to insert Error Emulated
10200 10200_comm An error occurred while communicating with the credit 
card processing gateway.
10201 10201_login An error occurred during login to the processing 
gateway.
10301 10301_ccinvalid This credit card account number is invalid.
10400 10400_insufffunds This account does not have sufficient funds to process 
this transaction.
10401 10401_decline The request to process this transaction has been 
declined. 
10403 10403_acctinvalid The merchant account information submitted is not 
recognized.
10404 10404_referral This transaction has been declined, but can be 
approved by obtaining a Voice Authorization code from 
the card issuer.
10405 10405_void An error occurred while attempting to void this 
transaction.
10406 10406_capture An error occurred while processing the capture 
transaction.
10500 10500_general A general error occurred at the credit card processing 
gateway.
*/

/**
 * Utilities class (for masking and some other misc things)
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

/**
 * HTTP connection class
 */
QuickBooks_Loader::load('/QuickBooks/HTTP.php');

/**
 * QuickBooks driver factory for database logging
 */
QuickBooks_Loader::load('/QuickBooks/Driver/Factory.php');

/**
 * QuickBooks credit card class
 */
QuickBooks_Loader::load('/QuickBooks/MerchantService/CreditCard.php');

/**
 * QuickBooks merchant service transaction class
 */
QuickBooks_Loader::load('/QuickBooks/MerchantService/Transaction.php');

/**
 * QuickBooks Merchant Service implementation
 */
class Quickbooks_MerchantService
{
	/**
	 * The connection ticket used to connect to QuickBooks Merchant Service
	 * @var string
	 */
	protected $_connection_ticket;
	
	/**
	 * The application login used to log in
	 * @var string
	 */
	protected $_application_login;
	
	//protected $_app_name;
	
	//protected $_app_url;
	
	//protected $_app_id;
	
	//protected $_auth_id;
	
	protected $_certificate;
	
	//protected $_logfile = '/tmp/curlerrors.txt';
	
	protected $_driver;
	
	protected $_test;
	protected $_debug;
	protected $_masking;
	
	//Testing - https://webmerchantaccount.ptc.quickbooks.com/j/AppGateway
	//Debug - https://webmerchantaccount.quickbooks.com/j/diag/http
	
	protected $_live_gateway = 'https://webmerchantaccount.quickbooks.com/j/AppGateway';
	protected $_test_gateway = 'https://webmerchantaccount.ptc.quickbooks.com/j/AppGateway';
	
	protected $_ticket_session = '';
	protected $_ticket_connection = '';
	
	protected $_last_request;
	protected $_last_response;
	
	protected $_batch;
	
	protected $_errnum;
	protected $_errmsg;
	
	protected $_warnnum;
	protected $_warnmsg;
	
	/**
	 * 
	 * 
	 * 
	 */
	public function __construct($dsn, $certificate, $application_login = null, $connection_ticket = null) 
	{
		$this->_test = false;
		$this->_debug = false;
		
		// Mask credit card numbers
		$this->_masking = true;
		
		if ($dsn)
		{
			// @TODO Figure out a better way to set the logging level
			$driver_options = array();
			$driver_hooks = array();
			$driver_loglevel = QUICKBOOKS_LOG_DEVELOP;
			$this->_driver = QuickBooks_Driver_Factory::create($dsn, $driver_options, $driver_hooks, $driver_loglevel);
		}
		
		if ($application_login)
		{
			$this->_application_login = $application_login;
		}
		else if ($this->_driver)
		{
			
		}
		
		if ($connection_ticket)
		{
			$this->_ticket_connection = $connection_ticket;
		}
		else if ($this->_driver)
		{
			//$this->_ticket_connection = $this->_driver->
		}
		
		$this->_certificate = $certificate;		
		
		$this->_errnum = QUICKBOOKS_MERCHANTSERVICE_OK;
		$this->_errmsg = '';
		
		$this->_warnnum = QUICKBOOKS_MERCHANTSERVICE_OK;
		$this->_warnmsg = '';		
	}
	
	/**
	 * Get the error number of the last error that occured
	 * 
	 * @return integer
	 */
	public function errorNumber()
	{
		return $this->_errnum;
	}
	
	/**
	 * Get the error message of the last error that occured
	 * 
	 * @return string
	 */
	public function errorMessage()
	{
		return $this->_errmsg;
	}
	
	/**
	 * Get the error number of the last error that occured
	 * 
	 * @return integer
	 */
	public function warningNumber()
	{
		return $this->_warnnum;
	}
	
	/**
	 * Get the error message of the last error that occured
	 * 
	 * @return string
	 */
	public function warningMessage()
	{
		return $this->_warnmsg;
	}	
	
	/**
	 * Get the last raw XML response that was received
	 * 
	 * @return string
	 */
	public function lastResponse()
	{
		return $this->_last_response;
	}
	
	/**
	 * Get the last raw XML request that was sent
	 *
	 * @return string
	 */
	public function lastRequest()
	{
		return $this->_last_request;
	}
	
	/**
	 * Set an error message
	 * 
	 * @param integer $errnum	The error number/code
	 * @param string $errmsg	The text error message
	 * @return void
	 */
	protected function _setError($errnum, $errmsg = '')
	{
		$this->_errnum = $errnum;
		$this->_errmsg = $errmsg;
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected function _setWarning($warnnum, $warnmsg = '')
	{
		$this->_warnnum = $warnnum;
		$this->_warnmsg = $warnmsg;
	}
	
	/**
	 *
	 * @TODO Implement this
	 */
	public function addListener()
	{
		
	}
	
	/** 
	 * Set to TRUE to use the Intuit development environment (make sure you have registered your application as a DEVELOPMENT application!)
	 *
	 * @param boolean $yes_or_no
	 * @return void
	 */
	public function useTestEnvironment($yes_or_no)
	{
		$this->_test = (boolean) $yes_or_no;
	}
	
	/**
	 * Set to TRUE to use the Intuit live environment (make sure you have registered your application as a PRODUCTION application!)
	 *
	 * @param boolean $yes_or_no
	 * @return void
	 */
	public function useLiveEnvironment($yes_or_no)
	{
		$this->_test = ! (boolean) $yes_or_no;
	}
	
	/**
	 * If masking is enabled (default) then credit card numbers, connection tickets, and session tickets will be masked when output or logged
	 * 
	 * @param boolean $yes_or_no
	 * @return void
	 */
	public function useMasking($yes_or_no)
	{
		$this->_masking = (boolean) $yes_or_no;
	}
	
	/**
	 * Turn debugging mode on or off
	 * 
	 * Turning debugging mode on will result in a large amount of output being 
	 * printed directly to stdout (the web browser or the console)
	 * 
	 * @param boolean $yes_or_no
	 * @return void
	 */
	public function useDebugMode($yes_or_no)
	{
		$this->_debug = (boolean) $yes_or_no;
	}
	
	protected function _extractTagContents($tag, $data)
	{
		// SessionTicket
		if (false !== strpos($data, '<' . $tag . '>') and 
			false !== strpos($data, '</' . $tag . '>'))
		{
			$data = strstr($data, '<' . $tag . '>');
			$end = strpos($data, '</' . $tag . '>');
			
			return substr($data, strlen($tag) + 2, $end - (strlen($tag) + 2));
		}
		
		return null;
	}
	
	protected function _extractAttribute($attr, $data, $which = 0)
	{
		if ($which == 1)
		{
			$spos = strpos($data, $attr . '="');
			$data = substr($data, $spos + strlen($attr));
		}
		
		if (false !== ($spos = strpos($data, $attr . '="')) and 
			false !== ($epos = strpos($data, '"', $spos + strlen($attr) + 2)))
		{
			//print('start: ' . $spos . "\n");
			//print('end: ' . $epos . "\n");
			
			return substr($data, $spos + strlen($attr) + 2, $epos - $spos - strlen($attr) - 2);
		}
		
		return '';
	}
	
	public function signOn()
	{
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_OK);
		
		$xml = '';
		$xml .= '<?xml version="1.0" ?>' . QUICKBOOKS_CRLF;
		$xml .= '<?qbmsxml version="3.0"?>' . QUICKBOOKS_CRLF;
		$xml .= '<QBMSXML>' . QUICKBOOKS_CRLF;
		$xml .= '	<SignonMsgsRq>' . QUICKBOOKS_CRLF;
		
		if ($this->_certificate)
		{
			$this->_log('Signing on a HOSTED QBMS application.', QUICKBOOKS_LOG_DEBUG);
			
			$xml .= '		<SignonAppCertRq>' . QUICKBOOKS_CRLF;
			$xml .= '			<ClientDateTime>' . date('Y-m-d\TH:i:s') . '</ClientDateTime>' . QUICKBOOKS_CRLF;
			$xml .= '			<ApplicationLogin>' . $this->_application_login . '</ApplicationLogin>' . QUICKBOOKS_CRLF;
			$xml .= '			<ConnectionTicket>' . $this->_ticket_connection . '</ConnectionTicket>' . QUICKBOOKS_CRLF;
			$xml .= '		</SignonAppCertRq>' . QUICKBOOKS_CRLF;
		}
		else
		{
			$this->_log('Signing on as a DESKTOP QBMS application.', QUICKBOOKS_LOG_DEBUG);
			
			$xml .= '		<SignonDesktopRq>' . QUICKBOOKS_CRLF;
			$xml .= '			<ClientDateTime>' . date('Y-m-d\TH:i:s') . '</ClientDateTime>' . QUICKBOOKS_CRLF;
			$xml .= '			<ApplicationLogin>' . $this->_application_login . '</ApplicationLogin>' . QUICKBOOKS_CRLF;
			$xml .= '			<ConnectionTicket>' . $this->_ticket_connection . '</ConnectionTicket>' . QUICKBOOKS_CRLF;
			$xml .= '		</SignonDesktopRq>' . QUICKBOOKS_CRLF;			
		}
		
		$xml .= '	</SignonMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '</QBMSXML>' . QUICKBOOKS_CRLF;
		
		$errnum = QUICKBOOKS_MERCHANTSERVICE_OK;
		$errmsg = '';
		
		$response = $this->_request($xml, $errnum, $errmsg);
		
		if ($errnum)
		{
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_SOCKET, $errnum . ': ' . $errmsg);
			return false;
		}
		
		$code = $this->_extractAttribute('statusCode', $response);
		$message = $this->_extractAttribute('statusMessage', $response);
		$severity = $this->_extractAttribute('statusSeverity', $response);
		
		$this->_log('SignOn (initial) response: ' . $severity . '/' . $code . ': ' . $message, QUICKBOOKS_LOG_DEBUG);
		
		if ($code != QUICKBOOKS_MERCHANTSERVICE_OK)
		{
			$this->_setError($code, $message);
			return false;
		}
		
		if ($ticket = $this->_extractTagContents('SessionTicket', $response))
		{
			$this->_ticket_session = $ticket;
			
			return true;
		}
		
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_INTERNAL, 'Could not locate SessionTicket in response.');
		
		return false;
	}
	
	/**
	 * 
	 * 
	 * 
	 * 
	 */
	public function isSignedOn()
	{
		return strlen($this->_ticket_session) > 0;
	}
	
	protected function _transRequestID($type, $Obj, $amount, $force_new_transaction = true)
	{
		$rand = '';
		if ($force_new_transaction)
		{
			$rand = mt_rand() . microtime();
		}
		
		return md5($type . '-' . serialize($Obj) . '-' . $amount . '-' . $rand);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected function _doQBMS($type, $path, $xml, $CreditCard = null)
	{
		$errnum = QUICKBOOKS_MERCHANTSERVICE_OK;
		$errmsg = '';
		$response = $this->_request($xml, $errnum, $errmsg);
		
		if ($errnum)
		{
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_SOCKET, $errnum . ': ' . $errmsg);
			return false;
		}
		
		$signon_code = $this->_extractAttribute('statusCode', $response, 0);
		$signon_message = '';
		$signon_severity = $this->_extractAttribute('statusSeverity', $response, 0);
		
		if ($signon_code != QUICKBOOKS_MERCHANTSERVICE_OK)
		{
			$signon_message = $this->_extractAttribute('statusMessage', $response, 0);
		}
		
		$this->_log('SignOn (with session) response: ' . $signon_severity . '/' . $signon_code . ': ' . $signon_message, QUICKBOOKS_LOG_DEBUG);
		
		if ($signon_code != QUICKBOOKS_MERCHANTSERVICE_OK)
		{
			$this->_setError($signon_code, $signon_message);
			return false;
		}		
		
		$qbms_code = $this->_extractAttribute('statusCode', $response, 1);
		$qbms_message = $this->_extractAttribute('statusMessage', $response, 0);	// 0th instance, because QBMS doesn't return a statusMessage for the first sucessful request
		$qbms_severity = $this->_extractAttribute('statusSeverity', $response, 1);
		
		$this->_log('QBMS Response: ' . $qbms_severity . '/' . $qbms_code . ': ' . $qbms_message, QUICKBOOKS_LOG_DEBUG);
		
		//if ($qbms_code != QUICKBOOKS_MERCHANTSERVICE_OK)
		if (!$qbms_severity or $qbms_severity == QUICKBOOKS_MERCHANTSERVICE_SEVERITY_ERROR)
		{
			$this->_setError($qbms_code, $qbms_message);
			return false;
		}
		else if ($qbms_severity == QUICKBOOKS_MERCHANTSERVICE_SEVERITY_WARN)
		{
			$this->_setWarning($qbms_code, $qbms_message);
			// return false;		// DO NOT RETURN HERE (it's just a warning)
		}
		else if ($qbms_severity == QUICKBOOKS_MERCHANTSERVICE_SEVERITY_INFO)
		{
			; // Do nothing...
		}
		else
		{
			// If we get here, something has gone really wrong... no statusSeverity code indicating pass/fail/warn was returned???
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_INTERNAL, 'Could not locate a statusSeverity="..." attribute in returned stream: ' . $response);
			return false;
		}
		
		// Create a transaction result 
		
		$xml_errnum = 0;
		$xml_errmsg = '';
		if ($Transaction = $this->_parseResponse($type, $path, $response, $xml_errnum, $xml_errmsg))
		{
			if ($CreditCard instanceof QuickBooks_MerchantService_CreditCard)
			{
				$Transaction->setExtraData(
					$qbms_code, 
					$qbms_message, 
					$CreditCard->getNumber(true), 
					$CreditCard->getExpirationMonth(), 
					$CreditCard->getExpirationYear(), 
					$CreditCard->getName(), 
					$CreditCard->getAddress(), 
					$CreditCard->getPostalCode());
			}
			
			return $Transaction;
		}
		
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_XML, $xml_errnum . ': ' . $xml_errmsg);
		return false;		
	}
	
	/**
	 * 
	 * 
	 */
	public function authorize($Card, $amount, $is_card_present = false, $is_ecommerce = true, $is_recurring = false, $force_new_transaction = true)
	{
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_OK);
		$this->_log('authorize()', QUICKBOOKS_LOG_VERBOSE);
		
		if (!$this->isSignedOn())
		{
			$this->signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}
		
		$transRequestID = $this->_transRequestID(QUICKBOOKS_MERCHANTSERVICE_TYPE_AUTHORIZE, $Card, $amount, $force_new_transaction);
		
		$xml = '<?xml version="1.0" ?>' . QUICKBOOKS_CRLF;
		$xml .= '<?qbmsxml version="3.0"?>' . QUICKBOOKS_CRLF;
		$xml .= '<QBMSXML>' . QUICKBOOKS_CRLF;
		$xml .= $this->_createSessionXML();
		$xml .= '	<QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '		<CustomerCreditCardAuthRq>' . QUICKBOOKS_CRLF;
		$xml .= '			<TransRequestID>' . $transRequestID . '</TransRequestID>' . QUICKBOOKS_CRLF;
		$xml .= $this->_createCreditCardXML($Card, $amount, $is_card_present, $is_ecommerce, $is_recurring);
		$xml .= '		</CustomerCreditCardAuthRq>' . QUICKBOOKS_CRLF;
		$xml .= '	</QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '</QBMSXML>' . QUICKBOOKS_CRLF;
		
		return $this->_doQBMS(QUICKBOOKS_MERCHANTSERVICE_TYPE_AUTHORIZE, 'QBMSXML/QBMSXMLMsgsRs/CustomerCreditCardAuthRs', $xml, $Card);
	}
	
	protected function _createSessionXML()
	{
		$xml = '';
		
		$xml .= '	<SignonMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '		<SignonTicketRq>' . QUICKBOOKS_CRLF;
		$xml .= '			<ClientDateTime>' . date('Y-m-d\TH:i:s') . '</ClientDateTime>' . QUICKBOOKS_CRLF;
		$xml .= '			<SessionTicket>' . $this->_ticket_session . '</SessionTicket>' . QUICKBOOKS_CRLF;
		$xml .= '		</SignonTicketRq>' . QUICKBOOKS_CRLF;
		$xml .= '	</SignonMsgsRq>' . QUICKBOOKS_CRLF;
		
		return $xml;
	}
		
	protected function _parseResponse($type, $path, $xml, &$errnum, &$errmsg)
	{
		static $look = array(
			'CreditCardTransID' => null, 
			'AuthorizationCode' => null, 
			'AVSStreet' => null,
			'AVSZip' => null, 
			'CardSecurityCodeMatch' => null, 
			'ClientTransID' => null,  
			'MerchantAccountNumber' => null, 
			'ReconBatchID' => null, 
			'PaymentGroupingCode' => null,
			'PaymentStatus' => null, 
			'TxnAuthorizationTime' => null, 
			'TxnAuthorizationStamp' => null, 
			'NetworkName' => null, 
			'NetworkNumber' => null, 
			'DebitCardTransID' => null, 
			);
		
		$Parser = new QuickBooks_XML_Parser($xml);
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			$Node = $Doc->getRoot();
			
			$trans = array();
			foreach ($look as $node => $null)
			{
				$trans[$node] = $Node->getChildDataAt($path . '/' . $node);
			}
			
			// 
			if ($trans['DebitCardTransID'])
			{
				$trans['CreditCardTransID'] = $trans['DebitCardTransID'];
			}
			
			return new QuickBooks_MerchantService_Transaction(
				$type, 
				$trans['CreditCardTransID'], 
				$trans['ClientTransID'], 
				$trans['AuthorizationCode'], 
				$trans['MerchantAccountNumber'], 
				$trans['ReconBatchID'], 
				$trans['PaymentGroupingCode'], 
				$trans['PaymentStatus'], 
				$trans['TxnAuthorizationTime'], 
				$trans['TxnAuthorizationStamp'], 
				$trans['AVSStreet'], 
				$trans['AVSZip'], 
				$trans['CardSecurityCodeMatch'], 
				$trans['NetworkName'], 
				$trans['NetworkNumber']);
		}
		
		return false;
	}
	
	protected function _createCreditCardXML($Card, $amount, $is_card_present, $is_ecommerce, $is_recurring, $include_address_data = true)
	{
		$xml = '';
		
		$is_track2_data = false;
		
		if ($is_track2_data)
		{
			//<Track2Data >STRTYPE</Track2Data> <!-- optional -->	
		}
		else
		{
			$xml .= '			<CreditCardNumber>' . $Card->getNumber() . '</CreditCardNumber>' . QUICKBOOKS_CRLF;
			$xml .= '			<ExpirationMonth>' . $Card->getExpirationMonth() . '</ExpirationMonth>' . QUICKBOOKS_CRLF;
			$xml .= '			<ExpirationYear>' . $Card->getExpirationYear() . '</ExpirationYear>' . QUICKBOOKS_CRLF;
			//$xml .= '			<IsCardPresent>BOOLTYPE</IsCardPresent>' . QUICKBOOKS_CRLF;
			//$xml .= '			<IsECommerce >BOOLTYPE</IsECommerce>' . QUICKBOOKS_CRLF;
			//$xml .= '			<IsRecurring >BOOLTYPE</IsRecurring>' . QUICKBOOKS_CRLF;
		}
		
		$xml .= '			<Amount>' . sprintf('%01.2f', (float) $amount) . '</Amount>' . QUICKBOOKS_CRLF;
		$xml .= '			<NameOnCard>' . substr(htmlspecialchars($Card->getName()), 0, 30) . '</NameOnCard>' . QUICKBOOKS_CRLF;
		
		if ($include_address_data)
		{
			$xml .= '			<CreditCardAddress>' . substr(htmlspecialchars($Card->getAddress()), 0, 30) . '</CreditCardAddress>' . QUICKBOOKS_CRLF;
			$xml .= '			<CreditCardPostalCode>' . substr(str_replace(array('-', ' ', '.'), '', $Card->getPostalCode()), 0, 9) . '</CreditCardPostalCode>' . QUICKBOOKS_CRLF;
		}
		
		//$xml .= '			<CommercialCardCode >STRTYPE</CommercialCardCode>' . QUICKBOOKS_CRLF;
		//$xml .= '			<SalesTaxAmount >AMTTYPE</SalesTaxAmount>' . QUICKBOOKS_CRLF;

		if ($Card->getCVVCode())
		{
			$xml .= '			<CardSecurityCode>' . $Card->getCVVCode() . '</CardSecurityCode>' . QUICKBOOKS_CRLF;
		}
		
		/*
		<Lodging>
		<FolioID >STRTYPE</FolioID> <!-- required -->
		<!-- ChargeType may have one of the following values: ConventionFees, GiftShop, Golf, HealthClub, Hotel, Restaurant, Salon, Tennis -->
		<ChargeType >ENUMTYPE</ChargeType> <!-- optional -->
		<CheckInDate >DATETYPE</CheckInDate> <!-- optional -->
		<CheckOutDate >DATETYPE</CheckOutDate> <!-- optional -->
		<LengthOfStay >INTTYPE</LengthOfStay> <!-- optional -->
		<RoomRate >AMTTYPE</RoomRate> <!-- optional -->
		<!-- ExtraCharge may have one of the following values: GiftShop, Laundry, MiniBar, Restaurant, Telephone, Other -->
		<ExtraCharge >ENUMTYPE</ExtraCharge> <!-- must occur 0 - 6 times -->
		<!-- SpecialProgram may have one of the following values: AdvanceDeposit, AssuredReservation, DelayedCharge, ExpressService, NormalCharge, NoShowCharge -->
		<SpecialProgram >ENUMTYPE</SpecialProgram> <!-- optional -->
		<TotalAuthAmount >AMTTYPE</TotalAuthAmount> <!-- optional -->
		</Lodging>
		<Restaurant> <!-- optional -->
		<ServerID >STRTYPE</ServerID> <!-- optional -->
		<FoodAmount >AMTTYPE</FoodAmount> <!-- optional -->
		<BeverageAmount >AMTTYPE</BeverageAmount> <!-- optional -->
		<TaxAmount >AMTTYPE</TaxAmount> <!-- optional -->
		<TipAmount >AMTTYPE</TipAmount> <!-- optional -->
		</Restaurant>
		*/
		
		return $xml;		
	}
	
	/**
	 * 
	 * 
	 * 
	 * 
	 */
	public function charge($Card, $amount, $is_card_present = false, $is_ecommerce = true, $is_recurring = false, $force_new_transaction = true)
	{
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_OK);
		$this->_log('charge()', QUICKBOOKS_LOG_VERBOSE);
		
		if (!$this->isSignedOn())
		{
			$this->signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}
		
		$transRequestID = $this->_transRequestID(QUICKBOOKS_MERCHANTSERVICE_TYPE_CHARGE, $Card, $amount, $force_new_transaction);
		
		$xml = '';
		$xml .= '<?xml version="1.0" encoding="utf-8"?>' . QUICKBOOKS_CRLF;
		$xml .= '<?qbmsxml version="3.0"?>' . QUICKBOOKS_CRLF;
		$xml .= '<QBMSXML>' . QUICKBOOKS_CRLF;
		$xml .= $this->_createSessionXML();
		$xml .= '	<QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '		<CustomerCreditCardChargeRq>' . QUICKBOOKS_CRLF;
		$xml .= '			<TransRequestID>' . $transRequestID . '</TransRequestID>' . QUICKBOOKS_CRLF;
		
		$xml .= $this->_createCreditCardXML($Card, $amount, $is_card_present, $is_ecommerce, $is_recurring);
		
		//<BatchID >STRTYPE</BatchID> <!-- optional -->
		$xml .= '		</CustomerCreditCardChargeRq>' . QUICKBOOKS_CRLF;
		$xml .= '	</QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;		
		$xml .= '</QBMSXML>' . QUICKBOOKS_CRLF;
		
		return $this->_doQBMS(QUICKBOOKS_MERCHANTSERVICE_TYPE_CHARGE, 'QBMSXML/QBMSXMLMsgsRs/CustomerCreditCardChargeRs', $xml, $Card);
	}
	
	/**
	 * 
	 * 
	 * @param QuickBooks_MerchantService_Transaction $Transaction
	 * @param float $amount
	 * @return QuickBooks_MerchantService_Transaction
	 */
	public function capture($Transaction, $amount = null, $force_new_transaction = true)
	{
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_OK);
		$this->_log('capture()', QUICKBOOKS_LOG_VERBOSE);
		
		// Fetch a session ticket if we havn't already
		if (!$this->isSignedOn())
		{
			$this->signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}
		
		// Error checking
		if (!($Transaction instanceof QuickBooks_MerchantService_Transaction))
		{
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_PARAM, 'capture() expects first parameter to be a Transaction object, got: ' . print_r($Transaction, true));
			return false;
		}
		
		if (!is_numeric($amount))
		{
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_PARAM, 'capture() expects second parameter to be a float, got: ' . print_r($amount, true));
			return false;
		}
		
		$transRequestID = $this->_transRequestID(QUICKBOOKS_MERCHANTSERVICE_TYPE_CHARGE, $Transaction, $amount, $force_new_transaction);
		
		$xml = '';
		$xml .= '<?xml version="1.0" encoding="utf-8"?>' . QUICKBOOKS_CRLF;
		$xml .= '<?qbmsxml version="3.0"?>' . QUICKBOOKS_CRLF;
		$xml .= '<QBMSXML>' . QUICKBOOKS_CRLF;
		$xml .= $this->_createSessionXML();
		$xml .= '	<QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '		<CustomerCreditCardCaptureRq>' . QUICKBOOKS_CRLF;
		$xml .= '			<TransRequestID>' . $transRequestID . '</TransRequestID>' . QUICKBOOKS_CRLF;
		$xml .= '			<CreditCardTransID>' . $Transaction->getTransactionID() . '</CreditCardTransID>' . QUICKBOOKS_CRLF;
		
		if ((float) $amount)
		{
			$xml .= '			<Amount>' . sprintf('%01.2f', (float) $amount) . '</Amount>' . QUICKBOOKS_CRLF;
		}
		
		//<BatchID >STRTYPE</BatchID> <!-- optional -->
		
		$xml .= '		</CustomerCreditCardCaptureRq>' . QUICKBOOKS_CRLF;
		$xml .= '	</QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '</QBMSXML>' . QUICKBOOKS_CRLF;
		
		return $this->_doQBMS(QUICKBOOKS_MERCHANTSERVICE_TYPE_CAPTURE, 'QBMSXML/QBMSXMLMsgsRs/CustomerCreditCardCaptureRs', $xml);
	}
	
	/**
	 * Refund a credit card a given amount
	 * 
	 * 
	 */
	public function refund($Card, $amount, $is_card_present = false, $is_ecommerce = true, $force_new_transaction = true)
	{
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_OK);
		$this->_log('refund()', QUICKBOOKS_LOG_VERBOSE);
		
		if (!$this->isSignedOn())
		{
			$this->signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}
		
		// Error checking
		if (!($Card instanceof QuickBooks_MerchantService_CreditCard))
		{
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_PARAM, 'refund() expects first parameter to be a Card object, got: ' . print_r($Card, true));
			return false;
		}
		
		if (!is_numeric($amount))
		{
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_PARAM, 'refund() expects second parameter to be a float, got: ' . print_r($amount, true));
			return false;
		}
		
		$transRequestID = $this->_transRequestID(QUICKBOOKS_MERCHANTSERVICE_TYPE_REFUND, $Card, $amount, $force_new_transaction);
		
		$xml = '';
		$xml .= '<?xml version="1.0" encoding="utf-8"?>' . QUICKBOOKS_CRLF;
		$xml .= '<?qbmsxml version="3.0"?>' . QUICKBOOKS_CRLF;
		$xml .= '<QBMSXML>' . QUICKBOOKS_CRLF;
		$xml .= $this->_createSessionXML();
		$xml .= '	<QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '		<CustomerCreditCardRefundRq>' . QUICKBOOKS_CRLF;
		$xml .= '			<TransRequestID>' . $transRequestID . '</TransRequestID>' . QUICKBOOKS_CRLF;
		
		$xml .= $this->_createCreditCardXML($Card, $amount, $is_card_present, $is_ecommerce, false, false);
		
		//<BatchID >STRTYPE</BatchID> <!-- optional -->
		$xml .= '		</CustomerCreditCardRefundRq>' . QUICKBOOKS_CRLF;
		$xml .= '	</QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;		
		$xml .= '</QBMSXML>' . QUICKBOOKS_CRLF;
		
		return $this->_doQBMS(QUICKBOOKS_MERCHANTSERVICE_TYPE_CAPTURE, 'QBMSXML/QBMSXMLMsgsRs/CustomerCreditCardRefundRs', $xml, $Card);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public function void($Transaction, $force_new_transaction = true)
	{
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_OK);
		$this->_log('void()', QUICKBOOKS_LOG_VERBOSE);
		
		if (!$this->isSignedOn())
		{
			$this->signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}
		
		// Error checking
		if (!($Transaction instanceof QuickBooks_MerchantService_Transaction))
		{
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_PARAM, 'void() expects first parameter to be a Transaction object, got: ' . print_r($Transaction, true));
			return false;
		}
		
		$transRequestID = $this->_transRequestID(QUICKBOOKS_MERCHANTSERVICE_TYPE_VOID, $Transaction, null, $force_new_transaction);
		
		$xml = '';
		$xml .= '<?xml version="1.0" encoding="utf-8"?>' . QUICKBOOKS_CRLF;
		$xml .= '<?qbmsxml version="3.0"?>' . QUICKBOOKS_CRLF;
		$xml .= '<QBMSXML>' . QUICKBOOKS_CRLF;
		$xml .= $this->_createSessionXML();
		$xml .= '	<QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '		<CustomerCreditCardTxnVoidRq>' . QUICKBOOKS_CRLF;
		$xml .= '			<TransRequestID>' . $transRequestID . '</TransRequestID>' . QUICKBOOKS_CRLF;
		$xml .= '			<CreditCardTransID>' . $Transaction->getTransactionID() . '</CreditCardTransID>' . QUICKBOOKS_CRLF;
		
		$xml .= '		</CustomerCreditCardTxnVoidRq>' . QUICKBOOKS_CRLF;
		$xml .= '	</QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '</QBMSXML>' . QUICKBOOKS_CRLF;
			
		return $this->_doQBMS(QUICKBOOKS_MERCHANTSERVICE_TYPE_VOID, 'QBMSXML/QBMSXMLMsgsRs/CustomerCreditCardTxnVoidRs', $xml);
	}
		
	/**
	 * 
	 * 
	 * 
	 */
	public function voidOrRefund($Transaction, $amount = null, $force_new_transaction = true)
	{
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_OK);
		$this->_log('voidOrRefund()', QUICKBOOKS_LOG_VERBOSE);
		
		if (!$this->isSignedOn())
		{
			$this->signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}
		
		// Error checking
		if (!($Transaction instanceof QuickBooks_MerchantService_Transaction))
		{
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_PARAM, 'voidOrRefund() expects first parameter to be a Transaction object, got: ' . print_r($Transaction, true));
			return false;
		}
		
		if (!is_numeric($amount))
		{
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_PARAM, 'voidOrRefund() expects second parameter to be a float, got: ' . print_r($amount, true));
			return false;
		}
		
		$transRequestID = $this->_transRequestID(QUICKBOOKS_MERCHANTSERVICE_TYPE_VOIDORREFUND, $Transaction, $amount, $force_new_transaction);
		
		$xml = '';
		$xml .= '<?xml version="1.0" encoding="utf-8"?>' . QUICKBOOKS_CRLF;
		$xml .= '<?qbmsxml version="3.0"?>' . QUICKBOOKS_CRLF;
		$xml .= '<QBMSXML>' . QUICKBOOKS_CRLF;
		$xml .= $this->_createSessionXML();
		$xml .= '	<QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '		<CustomerCreditCardTxnVoidOrRefundRq>' . QUICKBOOKS_CRLF;
		$xml .= '			<TransRequestID>' . $transRequestID . '</TransRequestID>' . QUICKBOOKS_CRLF;
		$xml .= '			<CreditCardTransID>' . $Transaction->getTransactionID() . '</CreditCardTransID>' . QUICKBOOKS_CRLF;
		
		if ((float) $amount)
		{
			$xml .= '			<Amount>' . sprintf('%01.2f', (float) $amount) . '</Amount>' . QUICKBOOKS_CRLF;
		}
		
		//<BatchID >STRTYPE</BatchID> <!-- optional -->
		
		$xml .= '		</CustomerCreditCardTxnVoidOrRefundRq>' . QUICKBOOKS_CRLF;
		$xml .= '	</QBMSXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$xml .= '</QBMSXML>' . QUICKBOOKS_CRLF;
		
		return $this->_doQBMS(QUICKBOOKS_MERCHANTSERVICE_TYPE_VOIDORREFUND, 'QBMSXML/QBMSXMLMsgsRs/CustomerCreditCardTxnVoidOrRefundRs', $xml);
	}	
	
	protected function _getBatch($BatchID, $for_close = false)
	{
		if (!$BatchID)
		{
			if ($this->_batch)
			{
				return $this->_batch;
			}
			else
			{
				$BatchID = date('md');
			}
		}
		
		return $BatchID;
	}
	
	public function batchOpen($BatchID = null)
	{
		$this->_batch = $this->_getBatch($BatchID);
	}
	
	public function batchClose($BatchID = null)
	{
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_OK);
		
		if (!$this->isSignedOn())
		{
			$this->signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}
		
		$BatchID = $this->_getBatch($BatchID, true);
		
		// Send the batch close request
		
		
	}
	
	/**
	 * Get the HTTP/HTTPS gateway to use 
	 * 
	 * @return string
	 */	
	protected function _gateway()
	{
		if ($this->_test)
		{
			$this->_log('Using TEST gateway: ' . $this->_test_gateway, QUICKBOOKS_LOG_DEVELOP);
			return $this->_test_gateway;
		}
		
		$this->_log('Using LIVE gateway: ' . $this->_live_gateway, QUICKBOOKS_LOG_DEVELOP);
		return $this->_live_gateway;
	}
	
	/**
	 * 
	 * 
	 * 
	 * @param string $message
	 * @param integer $level
	 * @return boolean
	 */
	protected function _log($message, $level = QUICKBOOKS_LOG_NORMAL)
	{
		if ($this->_masking)
		{
			$message = QuickBooks_Utilities::mask($message);
		}
		
		if ($this->_debug)
		{
			print($message . QUICKBOOKS_CRLF);
		}
		
		if ($this->_driver)
		{
			// Send it to the driver to be logged 
			$this->_driver->log($message, $this->_ticket_session, $level);
		}
		
		return true;
	}
	
	/**
	 * Log a message 
	 *
	 *
	 */
	public function log($message, $level = QUICKBOOKS_LOG_NORMAL)
	{
		return $this->_log($message, $level);
	}
	
	/**
	 * 
	 * 
	 * @param string $xml
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return string 
	 */
	protected function _request($xml, &$errnum, &$errmsg) 
	{
		$HTTP = new QuickBooks_HTTP($this->_gateway());
		
		$headers = array(
			'Content-Type' => 'application/x-qbmsxml',
			);
		$HTTP->setHeaders($headers);
		
		// Turn on debugging for the HTTP object if it's been enabled in the payment processor
		$HTTP->useDebugMode($this->_debug);
		
		// 
		$HTTP->setRawBody($xml);
		
		$HTTP->verifyHost(false);
		$HTTP->verifyPeer(false);
		
		if ($this->_certificate)
		{
			$HTTP->setCertificate($this->_certificate);
		}
		
		$return = $HTTP->POST();
		
		$this->_last_request = $HTTP->lastRequest();
		$this->_last_response = $HTTP->lastResponse();
		
		// 
		$this->_log($HTTP->getLog(), QUICKBOOKS_LOG_DEBUG);
		
		$errnum = $HTTP->errorNumber();
		$errmsg = $HTTP->errorMessage();
		
		if ($errnum)
		{
			// An error occurred!
			$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_HTTP, $errnum . ': ' . $errmsg);
			return false;
		}
		
		// Everything is good, return the data!
		$this->_setError(QUICKBOOKS_MERCHANTSERVICE_ERROR_OK, '');
		return $return;
	}
}
