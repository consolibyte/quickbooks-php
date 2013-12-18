<?php

/**
 * QuickBooks PHP DevKit
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 */

class QuickBooks_IPP_OAuth
{
	private $_secrets;

	protected $_oauth_consumer_key;
	protected $_oauth_consumer_secret;
	
	protected $_oauth_access_token;
	protected $_oauth_access_token_secret;

	protected $_version = null;
	protected $_signature = null;
	protected $_keyfile;

	/**
	 * 
	 */
	const NONCE = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';

	const DEFAULT_VERSION = '1.0';
	const DEFAULT_SIGNATURE = 'HMAC-SHA1';

	const SIGNATURE_PLAINTEXT = 'PLAINTEXT';
	const SIGNATURE_HMAC = 'HMAC-SHA1';
	const SIGNATURE_RSA = 'RSA-SHA1';

	/** 
	 * Create our OAuth instance
	 */
	public function __construct($oauth_consumer_key, $oauth_consumer_secret)
	{
		$this->_oauth_consumer_key = $oauth_consumer_key;
		$this->_oauth_consumer_secret = $oauth_consumer_secret;
		
		$this->_version = QuickBooks_IPP_OAuth::DEFAULT_VERSION;
		$this->_signature = QuickBooks_IPP_OAuth::DEFAULT_SIGNATURE;
	}
	
	/**
	 * Set the signature method
	 * 
	 * 
	 */
	public function signature($method, $keyfile = null)
	{
		$this->_signature = $method;
		$this->_keyfile = $keyfile;
	}
	
	/**
	 * Sign an OAuth request and return the signing data (auth string, URL, etc.)
	 *
	 * 
	 */
	public function sign($method, $url, $oauth_token = null, $oauth_token_secret = null, $params = array()) 
	{
		/*
		print('got in: [' . $method . '], ' . $url);
		print_r($params);
		print('<br /><br /><br />');
		*/
		
		if (!is_array($params))
		{
			$params = array();
		}
		
		$params = array_merge($params, array(
			'oauth_consumer_key' => $this->_oauth_consumer_key, 
			'oauth_signature_method' => $this->_signature, 
			'oauth_nonce' => $this->_nonce(), 
			'oauth_timestamp' => $this->_timestamp(), 
			'oauth_version' => $this->_version,
			));
		
		// Add in the tokens if they were passed in
		if ($oauth_token)
		{
			$params['oauth_token'] = $oauth_token;
		}
		
		if ($oauth_token_secret)
		{
			$params['oauth_secret'] = $oauth_token_secret;
		}
		
		// Generate the signature
		$signature_and_basestring = $this->_generateSignature($this->_signature, $method, $url, $params);
		
		$params['oauth_signature'] = $signature_and_basestring[1];
		
		/*
		print('<pre>');
		print('BASE STRING IS [' . $signature_and_basestring[0] . ']' . "\n\n");
		print('SIGNATURE IS: [' . $params['oauth_signature'] . ']');
		print('</pre>');
		*/
		
		$normalized = $this->_normalize($params);
		
		/*
		print('NORMALIZE 1 [' . $normalized . ']' . "\n");
		print('NORMZLIZE 2 [' . $this->_normalize2($params) . ']' . "\n");
		*/

		if (false !== ($pos = strpos($url, '?')))
		{
			$url = substr($url, 0, $pos);
		}
		
		$normalized_url = $url . '?' . $normalized;			// normalized URL

		return array (
			0 => $signature_and_basestring[0], 		// signature basestring
			1 => $signature_and_basestring[1],		// signature
			2 => $normalized_url, 
			3 => $this->_generateHeader($params, $normalized),	// header string
			);
	}

	protected function _generateHeader($params, $normalized) 
	{
		// oauth_signature="' . $this->_escape($params['oauth_signature']) . '", 

		$str = 'OAuth realm="", 
			oauth_signature_method="' . $params['oauth_signature_method'] . '", 
			oauth_signature="' . $this->_escape($params['oauth_signature']) . '", 			
			oauth_nonce="' . $params['oauth_nonce'] . '", 
			oauth_timestamp="' . $params['oauth_timestamp'] . '", ';
			
		if (isset($params['oauth_token']))
		{
			$str .= ' oauth_token="' . $params['oauth_token'] . '", ';
		}
		
		$str .= ' oauth_consumer_key="' . $params['oauth_consumer_key'] . '", 
			oauth_version="' . $params['oauth_version'] . '"';
			
		return str_replace(array('  ', '   '), ' ', str_replace(array("\r", "\n", "\t"), ' ', $str));
	}

	/**
	 * 
	 * 
	 */
	protected function _escape($str) 
	{
		if ($str === false)
		{
			return $str;
		}
		else
		{
			return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode($str)));
		}
	}
	
	protected function _timestamp()
	{
		//return 1326976195;
		
		//return 1318622958;
		return time();
	}

	protected function _nonce($len = 5) 
	{
		//return '1234';
		
		$tmp = str_split(QuickBooks_IPP_OAuth::NONCE);
		shuffle($tmp);
		
		//return 'kYjzVBB8Y0ZFabxSWbWovY3uYSQ2pTgmZeNu2VS4cg';
		return substr(implode('', $tmp), 0, $len);
	}
		
	protected function _normalize($params)
	{	
		$normalized = array();

		ksort($params);
		foreach ($params as $key => $value)
		{
		    // all names and values are already urlencoded, exclude the oauth signature
		    if ($key != 'oauth_secret')
		   	{
				if (is_array($value))
				{
					$sort = $value;
					sort($sort);
					foreach ($sort as $subkey => $subvalue)
					{
						$normalized[] = $this->_escape($key) . '=' . $this->_escape($subvalue);
					}
				}
				else
				{
					$normalized[] = $this->_escape($key) . '=' . $this->_escape($value);
				}
			}
		}
		
		return implode('&', $normalized);
	}

	protected function _generateSignature($signature, $method, $url, $params = array()) 
	{
		/*
		print('<pre>params for signing');
		print_r($params);
		print('</pre>');
		*/
		
		//if (false !== strpos($url, 'get_access'))
		/*if (true)
		{
			print($url . '<br />' . "\r\n\r\n");
			die('NORMALIZE MINE [' . $this->_normalize($params) . ']');
		}*/
		
		/*
		print('<pre>');
		print('NORMALIZING [' . "\n");
		print($this->_normalize($params) . "]\n\n\n");
		print('SECRET KEY FOR SIGNING [' . $secret . ']' . "\n");
		print('</pre>');
		*/
		
		if (false !== ($pos = strpos($url, '?')))
		{
			$tmp = array();
			parse_str(substr($url, $pos + 1), $tmp);

			// Bad hack for magic quotes... *sigh* stupid PHP
			if (get_magic_quotes_gpc())
			{
				foreach ($tmp as $key => $value)
				{
					if (!is_array($value))
					{
						$tmp[$key] = stripslashes($value);
					}
				}
			}

			$params = array_merge($tmp, $params);

			$url = substr($url, 0, $pos);
		}

		//print('url [' . $url . ']' . "\n");
		//print_r($params);

		$sbs = $this->_escape($method) . '&' . $this->_escape($url) . '&' . $this->_escape($this->_normalize($params));
		
		//print('sbs [' . $sbs . ']' . "\n");

		// Which signature method? 
		switch ($signature)
		{
			case QuickBooks_IPP_OAuth::SIGNATURE_HMAC:
				return $this->_generateSignature_HMAC($sbs, $method, $url, $params);	
			case QuickBooks_IPP_OAuth::SIGNATURE_RSA:
				return $this->_generateSignature_RSA($sbs, $method, $url, $params);
		}
		
		return false;
	}
	

	/*
		// Pull the private key ID from the certificate
		$privatekeyid = openssl_get_privatekey($cert);
		
		// Sign using the key
		$sig = false;
		$ok  = openssl_sign($base_string, $sig, $privatekeyid);   
		
		// Release the key resource
		openssl_free_key($privatekeyid);
		
		base64_encode($sig)
	*/
		
	
	protected function _generateSignature_RSA($sbs, $method, $url, $params = array())
	{
		// $res = ... 
		$res = openssl_pkey_get_private('file://' . $this->_keyfile);
		
		/*
		print('key id is: [');
		print_r($res);
		print(']');
		print("\n\n\n");
		*/
		
		$signature = null;
		$retr = openssl_sign($sbs, $signature, $res);
		
		openssl_free_key($res);
		
		return array(
			0 => $sbs, 
			1 => base64_encode($signature), 
			);
	}
		
		
		
	/*
	$key = $request->urlencode($consumer_secret).'&'.$request->urlencode($token_secret);
	$signature = base64_encode(hash_hmac("sha1", $base_string, $key, true));
	*/	
		
	protected function _generateSignature_HMAC($sbs, $method, $url, $params = array())
	{
		$secret = $this->_escape($this->_oauth_consumer_secret);
		
		$secret .= '&';
		
		if (!empty($params['oauth_secret']))
		{
			$secret .= $this->_escape($params['oauth_secret']);
		}

		//print('generating signature from [' . $secret . ']' . "\n\n");
		
		return array(
			0 => $sbs, 
			1 => base64_encode(hash_hmac('sha1', $sbs, $secret, true)), 
			);
	}
}
