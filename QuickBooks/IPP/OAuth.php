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

	/**
	 * 
	 */
	const NONCE = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';

	const OAUTH_VERSION = '1.0';
	const OAUTH_SIGNATURE = 'HMAC-SHA1';

	/** 
	 * 
	 */
	public function __construct($oauth_consumer_key, $oauth_consumer_secret)
	{
		$this->_oauth_consumer_key = $oauth_consumer_key;
		$this->_oauth_consumer_secret = $oauth_consumer_secret;
	}

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
			'oauth_signature_method' => QuickBooks_IPP_OAuth::OAUTH_SIGNATURE, 
			'oauth_nonce' => $this->_nonce(), 
			'oauth_timestamp' => $this->_timestamp(), 
			'oauth_version' => QuickBooks_IPP_OAuth::OAUTH_VERSION,
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
		$signature_and_basestring = $this->_generateSignature($method, $url, $params);
		
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
		
		return array (
			0 => $signature_and_basestring[0], 		// signature basestring
			1 => $signature_and_basestring[1],		// signature
			2 => $url . '?' . $normalized,			// normalized URL
			3 => $this->_generateHeader($params, $normalized),	// header string
			);
	}

	protected function _generateHeader($params, $normalized) 
	{
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
			return str_replace('%7E', '~', rawurlencode($str));
		}
	}
	
	protected function _timestamp()
	{
		//return 1326976195;
		
		return time();
	}

	protected function _nonce($len = 5) 
	{
		//return '1234';
		
		$tmp = str_split(QuickBooks_IPP_OAuth::NONCE);
		shuffle($tmp);
			
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

	protected function _generateSignature($method, $url, $params = array()) 
	{
		$secret = $this->_escape($this->_oauth_consumer_secret);

		$secret .= '&';
		
		if (!empty($params['oauth_secret']))
		{
			$secret .= $this->_escape($params['oauth_secret']);
		}
		
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
		
		$sbs = $this->_escape($method) . '&' . $this->_escape($url) . '&' . $this->_escape($this->_normalize($params));
		
		return array(
			0 => $sbs, 
			1 => base64_encode(hash_hmac('sha1', $sbs, $secret, true)), 
			);
	}
}
