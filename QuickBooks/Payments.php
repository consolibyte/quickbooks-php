<?php

/**
 * QuickBooks Payments class
 * 
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
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
QuickBooks_Loader::load('/QuickBooks/Payments/CreditCard.php');

/**
 * QuickBooks merchant service transaction class
 */
QuickBooks_Loader::load('/QuickBooks/Payments/Transaction.php');

/**
 * Token class
 */
QuickBooks_Loader::load('/QuickBooks/Payments/Token.php');

/**
 * QuickBooks Merchant Service implementation
 */
class Quickbooks_Payments
{
	/**
	 * No error occurred
	 * @var integer
	 */
	const OK = QUICKBOOKS_ERROR_OK;
	
	/**
	 * No error occurred
	 * @var integer
	 */
	const ERROR_OK = QUICKBOOKS_ERROR_OK;

	const ERROR_AUTH = -2000;
	const ERROR_HTTP = -2001;

	const ERROR_DECLINE = -2002;

	const STATUS_DECLINED = 'DECLINED';
	
	const URL_CHARGE = '/quickbooks/v4/payments/charges';
	const URL_TOKEN = '/quickbooks/v4/payments/tokens';
	//const URL_ACCOUNT = '/quickbooks/v4/customers/<id>/bank-accounts';
	const URL_CARD = '/quickbooks/v4/customers/<id>/cards';
	const URL_ECHECK = '/quickbooks/v4/payments/echecks';
	const URL_REFUND = '/quickbooks/v4/payments/charges/<id>/refunds';

	const BASE_SANDBOX = 'https://sandbox.api.intuit.com';
	const BASE_PRODUCTION = 'https://api.intuit.com';

	protected $_sandbox = false;
	protected $_debug = false;
	protected $_driver = null;
	protected $_masking = false;

	protected $_oauth_consumer_key;
	protected $_oauth_consumer_secret;

	protected $_last_request;
	protected $_last_response;
	protected $_last_httpinfo;

	protected $_last_errnum;
	protected $_last_errmsg;
	protected $_last_errdetail;
	protected $_last_errtype;
	protected $_last_errinfolink;

	public function __construct($oauth_consumer_key, $oauth_consumer_secret, $sandbox = false)
	{
		$this->_oauth_consumer_key = $oauth_consumer_key;
		$this->_oauth_consumer_secret = $oauth_consumer_secret;

		$this->_sandbox = (bool) $sandbox;
	}

	protected function _getBaseURL()
	{
		if ($this->_sandbox)
		{
			return Quickbooks_Payments::BASE_SANDBOX;
		}
		else
		{
			return Quickbooks_Payments::BASE_PRODUCTION;
		}
	}

	public function debit($Context, $Object_or_token, $amount, $description = '')
	{
		$payload = array(
			'amount' => sprintf('%01.2f', $amount), 
			'paymentMode' => 'WEB',
			);

		if ($Object_or_token instanceof QuickBooks_Payments_CreditCard)
		{
			$this->_setError();
		}
		else if ($Object_or_token instanceof QuickBooks_Payments_BankAccount)
		{
			$payload['bankAccount'] = $Object_or_token->toArray();
		}
		else if ($Object_or_token instanceof QuickBooks_Payments_Token)
		{
			// It's a token 
			$payload['token'] = $Object_or_token->toString();
		}
		else
		{
			// It's a string token 
			$payload['token'] = $Object_or_token;
		}

		//print('making request');
		//print_r($payload);

		// Sign the request 
		$resp = $this->_http($Context, QuickBooks_Payments::URL_ECHECK, json_encode($payload));

		$data = json_decode($resp, true);

		//print_r($data);
		//exit;

		if ($this->_handleError($data))
		{
			return false;
		}

		return new QuickBooks_Payments_Transaction($data);
	}

	public function charge($Context, $Object_or_token, $amount, $currency = 'USD', $description = '')
	{
		$capture = true;
		return $this->_chargeOrAuth($Context, $Object_or_token, $amount, $currency, $capture, $description);
	}

	public function authorize($Context, $Object_or_token, $amount, $currency = 'USD', $description = '')
	{
		$capture = false;
		return $this->_chargeOrAuth($Context, $Object_or_token, $amount, $currency, $capture, $description);
	}

	public function _chargeOrAuth($Context, $Object_or_token, $amount, $currency, $capture, $description)
	{
		$payload = array(
			'amount' => sprintf('%01.2f', $amount), 
			'currency' => $currency, 
			);

		if ($Object_or_token instanceof QuickBooks_Payments_CreditCard)
		{
			$payload['card'] = $Object_or_token->toArray();
		}
		else if ($Object_or_token instanceof QuickBooks_Payments_BankAccount)
		{
			$this->_setError();
			return false;
		}
		else if ($Object_or_token instanceof QuickBooks_Payments_Token)
		{
			// It's a token 
			$payload['token'] = $Object_or_token->toString();
		}
		else
		{
			// It's a string token 
			$payload['token'] = $Object_or_token;
		}

		// Sign the request 
		$resp = $this->_http($Context, QuickBooks_Payments::URL_CHARGE, json_encode($payload));

		$data = json_decode($resp, true);

		if ($this->_handleError($data))
		{
			return false;
		}

		return new QuickBooks_Payments_Transaction($data);
	}

	public function tokenize($Context, $Object)
	{
		if ($Object instanceof QuickBooks_Payments_CreditCard)
		{
			$payload = array(
				'card' => $Object->toArray()
				);
		}
		else if ($Object instanceof QuickBooks_Payments_BankAccount)
		{

		}
		else
		{
			$this->_setError();
			return false;
		}

		$resp = $this->_http($Context, QuickBooks_Payments::URL_TOKEN, json_encode($payload));

		$data = json_decode($resp, true);

		if (isset($data['value']))
		{
			return new QuickBooks_Payments_Token($data['value']);
		}

		// Error handling 
		$this->_handleError($data);
		return false;
	}

	/**
	 * Get information about a charge that was made previously 
	 * 
	 * @param  [type] $Context [description]
	 * @param  [type] $id      [description]
	 * @return [type]          [description]
	 */
	public function getCharge($Context, $id)
	{
		$resp = $this->_http($Context, QuickBooks_Payments::URL_CHARGE . '/' . $id, null);

		$data = json_decode($resp, true);

		$ignore_declines = true;
		if ($this->_handleError($data, $ignore_declines))
		{
			return false;
		}

		return new QuickBooks_Payments_Transaction($data);
	}

	/**
	 * Get information about a debit that was made previously
	 * 
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getDebit($Context, $id)
	{
		$resp = $this->_http($Context, QuickBooks_Payments::URL_ECHECK . '/' . $id, null);

		$data = json_decode($resp, true);

		$ignore_declines = true;
		if ($this->_handleError($data, $ignore_declines))
		{
			return false;
		}

		return new QuickBooks_Payments_Transaction($data);
	}

	public function refund($Context, $id, $amount)
	{
		$url = str_replace('<id>', $id, QuickBooks_Payments::URL_REFUND);

		$payload = array(
			'amount' => $amount, 
			);
		
		$resp = $this->_http($Context, $url, json_encode($payload));

		$data = json_decode($resp, true);

		if ($this->_handleError($data))
		{
			return false;
		}

		return new QuickBooks_Payments_Transaction($data);
	}

	public function getChargeRefund()
	{

	}

	public function getDebitRefund()
	{

	}

	public function getCards($Context, $id)
	{
		$id = str_replace(array('{', '}', '-'), '', $id);

		$url = str_replace('<id>', $id, QuickBooks_Payments::URL_CARD);

		//print "Trying to get gards for: " . $url . "\n";
		$resp = $this->_http($Context, $url, null);

		//print "Request: ";
		//print_r($this->_last_request);
		//print "Response: ";
		//print_r($this->_last_response);

		// error_log($resp);

		$data = json_decode($resp, true);

		if ($this->_handleError($data))
		{
			return false;
		}

		$list = array();

		foreach ($data as $card)
		{
			// How do I stuff this into
			$creditcard = new QuickBooks_Payments_CreditCard(); 
			$list[] = $creditcard->fromArray($card);
		}

		print_r($list);

		return $list;
	}

	protected function _handleError($data, $ignore_declines = false)
	{
		if (!$data)
		{
			// Check for 401/other errors 
			$info = $this->_last_httpinfo;

			if ($info['http_code'] == QuickBooks_HTTP::HTTP_401)
			{
				$this->_setError($info['http_code'], 'Unauthorized.');
				return true;
			}
		}

		if (isset($data['errors']))
		{
			$err = array_merge(array(
				'code' => null, 
				'message' => null, 
				'type' => null, 
				'detail' => null, 
				'infoLink' => null, 
				), $data['errors'][0]);

			$this->_setError($err['code'], $err['message'], $err['type'], $err['detail'], $err['infoLink']);

			return true;
		}

		if (!$ignore_declines)
		{
			if (isset($data['status']) and 
				$data['status'] == self::STATUS_DECLINED)
			{
				$this->_setError(self::ERROR_DECLINE, 'This transaction was declined.');

				return true;
			}
		}

		return false;
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
	
	public function lastError()
	{
		return $this->_last_errnum . ': ' . $this->_last_errmsg;
	}

	public function lastHTTPInfo()
	{
		return $this->_last_httpinfo;
	}

	/**
	 * Set an error message
	 * 
	 * @param integer $errnum	The error number/code
	 * @param string $errmsg	The text error message
	 * @return void
	 */
	protected function _setError($errnum, $errmsg = '', $type = null, $detail = null, $infolink = null)
	{
		$this->_last_errnum = $errnum;
		$this->_last_errmsg = $errmsg;

		$this->_last_errtype = $type;
		$this->_last_errdetail = $detail;
		$this->_last_errinfolink = $infolink; 
	}	

	/**
	 * 
	 * 
	 * 
	 * @param string $message
	 * @param integer $level
	 * @return boolean
	 */
	public function log($message)
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
			$this->_driver->log($message, null, $level);
		}
		
		return true;
	}

	protected function _http($Context, $url_path, $raw_body)
	{
		$method = 'GET';
		if ($raw_body)
		{
			$method = 'POST';
		}

		$url = $this->_getBaseURL() . $url_path;

		$authcreds = $Context->authcreds();

		$params = array();

		$OAuth = new QuickBooks_IPP_OAuth($this->_oauth_consumer_key, $this->_oauth_consumer_secret);
		$signed = $OAuth->sign($method, $url, $authcreds['oauth_access_token'], $authcreds['oauth_access_token_secret'], $params);

		//print_r($signed);

		//$HTTP = new QuickBooks_HTTP($signed[2]);
		
		$HTTP = new QuickBooks_HTTP($url);
		
		$headers = array(
			'Content-Type' => 'application/json',
			'Request-Id' => QuickBooks_Utilities::GUID(),
			'Authorization' => $signed[3],
			);
		$HTTP->setHeaders($headers);
		
		// Turn on debugging for the HTTP object if it's been enabled in the payment processor
		$HTTP->useDebugMode($this->_debug);
		
		// 
		$HTTP->setRawBody($raw_body);
		
		$HTTP->verifyHost(false);
		$HTTP->verifyPeer(false);
		
		if ($method == 'POST')
		{
			$return = $HTTP->POST();
		}
		else if ($method == 'GET')
		{
			$return = $HTTP->GET();
		}
		else
		{
			$return = null;  // ERROR
		}
		
		$this->_last_request = $HTTP->lastRequest();
		$this->_last_response = $HTTP->lastResponse();
		
		// 
		$this->log($HTTP->getLog(), QUICKBOOKS_LOG_DEBUG);
		
		$info = $HTTP->lastInfo();
		$this->_last_httpinfo = $info;

		$errnum = $HTTP->errorNumber();
		$errmsg = $HTTP->errorMessage();
		
		if ($errnum)
		{
			// An error occurred!
			$this->_setError(QuickBooks_Payments::ERROR_HTTP, $errnum . ': ' . $errmsg);
			return false;
		}

		if ($info['http_code'] == 401)
		{
			$this->_setError(QuickBooks_Payments::ERROR_AUTH, 'Payments return a 401 Unauthorized status.');
			return false;
		}
		
		// Everything is good, return the data!
		$this->_setError(QuickBooks_Payments::ERROR_OK, '');
		return $return;
	}
}
