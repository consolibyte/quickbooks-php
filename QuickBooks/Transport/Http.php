<?php

/**
 * 
 * 
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt  
 * 
 * @package QuickBooks
 * @subpackage Transport
 */

/**
 *
 */
QuickBooks_Loader::load('/QuickBooks/Transport.php');

/**
 * 
 * 
 * 
 * 
 * 
 */
class QuickBooks_Transport_HTTP extends QuickBooks_Transport
{
	/**
	 * 
	 */
	protected $_dsn;
	
	/**
	 *
	 */
	protected $_mode;
	
	protected $_user;
	
	protected $_action;
	
	protected $_done;
	
	/**
	 * 
	 *
	 * 
	 */
	public function __construct($dsn, $mode, $user, $action, $config = array())
	{
		$this->_dsn = $dsn;
		$this->_mode = $mode;
		$this->_user = $user;
		$this->_action = $action;
		
		$this->_done = false;
	}
	
	/**
	 * Fix various compatibility issues that PHP causes (magic quotes, etc.)
	 * 
	 * @return void
	 */
	protected function _compat()
	{
		if (function_exists('get_magic_quotes_gpc') and 
			get_magic_quotes_gpc()) 
		{
			function __QuickBooks_Transport_HTTP_ssd($value)
			{
				if (is_array($value))
				{
					$value = array_map('__QuickBooks_Transport_HTTP_ssd', $value);
				}
				else
				{
					$value = stripslashes($value);
				}
				
				return $value;
			}
		}
		
		$_POST = array_map('__QuickBooks_Transport_HTTP_ssd', $_POST);
		$_GET = array_map('__QuickBooks_Transport_HTTP_ssd', $_GET);
		$_COOKIE = array_map('__QuickBooks_Transport_HTTP_ssd', $_COOKIE);
		$_REQUEST = array_map('__QuickBooks_Transport_HTTP_ssd', $_REQUEST);
	}
	
	/**
	 * Tell whether or not this transport class is ready to process input
	 * 
	 * @return boolean
	 */
	public function ready()
	{
		return !empty($_POST['method']) and 
			!$this->_done;
	}
	
	/**
	 * Accept input from the data source and queue things up 
	 * 
	 * @param QuickBooks_Driver $Driver
	 * @return boolean
	 */
	public function input($Driver)
	{
		if ($this->_mode != QUICKBOOKS_TRANSPORT_MODE_INPUT)
		{
			return false;
		}
		
		// Clean up magic quotes junk
		$this->_compat();
		
		$defaults = array(
			'method' => QUICKBOOKS_TRANSPORT_METHOD_ENQUEUE, 
			'action' => $this->_action, 
			'ident' => null, 
			'replace' => true, 
			'priority' => 0, 
			'extra' => null, 
			'qbxml' => null, 
			'id' => null, 
			);
		
		$data = array_merge($defaults, $_POST);
		
		if (empty($data['id']))
		{
			$data['id'] = QuickBooks_Utilities::generateGUID();
		}
		
		$data['extra'] = array( 
			'__extra' => $data['extra'], 
			'__id' => $data['id'], 
			'__method' => $data['method'], 
			'__replace' => $data['replace'],
			'__priority' => $data['priority'] );
		
		// They must pass *at least* a valid method *and* either an action, or a qbXML request
		$errno = QUICKBOOKS_TRANSPORT_ERROR_OK;
		$errmsg = null;
		
		if (!$data['action'] and !$data['qbxml'])
		{
			$errno = QUICKBOOKS_TRANSPORT_ERROR_MISSING;
			$errmsg = 'You must HTTP POST at least either an "action" parameter or a "qbxml" parameter.';
		}
		else if (!is_numeric($data['priority']))
		{
			$errno = QUICKBOOKS_TRANSPORT_ERROR_VALIDATE;
			$errmsg = 'The value "' . $data['priority'] . '" is invalid for the priority field.';
		}
		
		if (!$errno)
		{
			$ok = false;
			switch ($data['method'])
			{
				case QUICKBOOKS_TRANSPORT_METHOD_ENQUEUE:
				
					$ok = $Driver->queueEnqueue(
						$this->_user, 
						$data['action'], 
						$data['ident'], 
						(boolean) $data['replace'], 
						(int) $data['priority'], 
						$data['extra'], 
						$data['qbxml']);
					
					break;
				case QUICKBOOKS_TRANSPORT_METHOD_EXISTS:
				case QUICKBOOKS_TRANSPORT_METHOD_RECUR:
				default:
					
					$errmsg = 'Unimplemented method: ' . $data['method'];
					
					break;
			}
		}
		
		$this->_ack($data, $ok, $data['id'], $errno, $errmsg);
		
		$this->_done = true;
		
		return $ok == true;
	}
	
	/**
	 * 
	 * 
	 *
	 */
	protected function _ack($data, $ok, $ID, $errnum, $errmsg)
	{
		if ($this->_mode != QUICKBOOKS_TRANSPORT_MODE_INPUT)
		{
			return false;
		}
		
		$status = QUICKBOOKS_TRANSPORT_STATUS_ERR;
		if ($ok)
		{
			$status = QUICKBOOKS_TRANSPORT_STATUS_OK;
		}
		
		$output = '';
		$output .= 'Status=' . $status . "\r\n";
		$output .= 'ID=' . $ID . "\r\n";
		$output .= 'ErrorCode=' . $errnum . "\r\n";
		$output .= 'ErrorMessage=' . $errmsg . "\r\n";
		
		print($output);
	}
	
	public function output($Driver, $method, $action, $ident, $replace, $priority, $extra, $qbxml, $id)
	{
		if ($this->_mode != QUICKBOOKS_TRANSPORT_MODE_OUTPUT)
		{
			return false;
		}

		$data = '';
		$vars = array(
			'method' => $method, 
			'action' => $action, 
			'ident' => $ident, 
			'replace' => $replace, 
			'priority' => $priority, 
			'extra' => $extra, 
			'qbxml' => $qbxml, 
			'id' => $id, 
			);
		foreach ($vars as $key => $value)
		{
			$data .= $key . '=' . urlencode($value) . '&';
		}
		
		if (function_exists('curl_init'))
		{
			return $this->_outputCurl($data);
		}
		else
		{
			return $this->_outputFsockopen($data);
		}
	}
	
	public function _outputCurl($data)
	{
		
		$ch = curl_init($this->_dsn);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		$resp = curl_exec($ch);
		curl_close($ch);
		
		//print($resp);
		
		return true;
	}
	
	public function _outputFsockopen($data)
	{
		$defaults = array(
			'scheme' => 'http', 
			'port' => 80, 
			'path' => '/', 
			);
		
		$parse = QuickBooks_Utilities::parseDSN($this->_dsn, $defaults);
		
		$socket_host = $parse['host'];
		$socket_port = $parse['port'];
		
		if ($parse['scheme'] == 'https')
		{
			$socket_host = 'ssl://' . $parse['host'];
			
			if ($socket_port == 80)
			{
				$socket_port = 443;
			}
		}
		
		$fp = fsockopen($socket_host, $socket_port); 
		fputs($fp, 'POST ' . $parse['path'] . ' HTTP/1.0' . "\r\n"); 
		fputs($fp, 'Host: ' . $parse['host'] . "\r\n"); 
		fputs($fp, 'Content-Type: application/x-www-form-urlencoded' . "\r\n"); 
		fputs($fp, 'Content-Length: ' . strlen($data) ."\r\n"); 
		fputs($fp, 'Connection: close' . "\r\n");
		fputs($fp, "\r\n"); 
		fputs($fp, $data); 
		
		$bytes = 0;
		$resp = '';
		while (!feof($fp) and $bytes < 1000) 
		{ 
			$tmp = fgets($fp, 128);
			$bytes += strlen($tmp);
			
			$resp .= $tmp; 
		}
		
		//print($resp);
		
		fclose($fp);
		
		return true;
	}
}
