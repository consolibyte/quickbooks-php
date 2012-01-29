<?php

/**
 * QuickBooks SOAP server component
 * 
 * This pure PHP SOAP server is provided for users that do not have access to 
 * the PHP ext/soap SOAP extension. It's also useful for testing, as it makes 
 * debugging a little bit easier (non-fatal errors and print() statements will 
 * show up, where-as with the PHP extension, it gobbles up all regular PHP 
 * standard output) 
 * 
 * Note: This is *not* a generic SOAP server, and *will not* work with other 
 * SOAP services outside of the QuickBooks Web Connector SOAP specification. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage SOAP
 */ 

/**
 * QuickBooks framework built-in XML parser
 */
QuickBooks_Loader::load('/QuickBooks/XML.php');

/**
 * QuickBooks SOAP server component
 */
class QuickBooks_SOAP_Server
{
	/**
	 * An instance of the class which handles the SOAP methods
	 */
	protected $_class;
	
	/**
	 * Create a new QuickBooks_SOAP_Server instance
	 * 
	 * @param string $wsdl
	 * @param array $soap_options
	 */
	public function __construct($wsdl, $soap_options)
	{
		// 
	}
	
	/**
	 * Create an instance of a request type object
	 * 
	 * @param string $request
	 * @return QuickBooks_Request
	 */
	protected function _requestFactory($request)
	{
		$class = 'QuickBooks_WebConnector_Request_' . ucfirst(strtolower($request));
		$file = '/QuickBooks/WebConnector/Request/' . ucfirst(strtolower($request)) . '.php';
		
		// Make sure that class gets loaded
		QuickBooks_Loader::load($file, false);
		
		if (class_exists($class))
		{
			return new $class();
		}
		
		return false;
	}
	
	/**
	 * Handle a SOAP request
	 * 
	 * @param string $raw_http_input		The raw incoming SOAP request (HTTP request body)
	 * @return boolean
	 */	
	public function handle($raw_http_input)
	{
		// Determine the method, call the correct handler function 
		
		$builtin = QuickBooks_XML::PARSER_BUILTIN;		// The SimpleXML parser has a difference namespace behavior, so force this to use the builtin parser
		$Parser = new QuickBooks_XML_Parser($raw_http_input, $builtin);
		
		$errnum = 0;
		$errmsg = '';
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			//print('parsing...');
			
			$Root = $Doc->getRoot();
			
			$Body = $Root->getChildAt('SOAP-ENV:Envelope SOAP-ENV:Body');
			if (!$Body)
			{
				$Body = $Root->getChildAt('soap:Envelope soap:Body');
			}
			
			$Container = $Body->getChild(0);
			
			$Request = null;
			$method = '';
			if ($Container)
			{
				$namespace = '';
				$method = $this->_namespace($Container->name(), $namespace);
				$Request = $this->_requestFactory($method);
				
				foreach ($Container->children() as $Child)
				{
					$namespace = '';
					$member = $this->_namespace($Child->name(), $namespace);
					
					//$Request->$member = html_entity_decode($Child->data(), ENT_QUOTES);
					$Request->$member = $Child->data();
				}
			}
			
			//print('method is: ' . $method . "\n");
			
			$Response = null;
			if (method_exists($this->_class, $method))
			{
				$Response = $this->_class->$method($Request);
			}
			
			$soap = '<?xml version="1.0" encoding="UTF-8"?>
			<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
			 xmlns:ns1="http://developer.intuit.com/">
				<SOAP-ENV:Body><ns1:' . $method . 'Response>';
			
			$vars = get_object_vars($Response);
			
			$soap .= $this->_serialize($vars);
			
			$soap .= '</ns1:' . $method . 'Response>
			</SOAP-ENV:Body>
			</SOAP-ENV:Envelope>';
			
			print($soap);
			return true;
		}
		else
		{
			$soap = '';
			$soap .= '<?xml version="1.0" encoding="UTF-8"?>' . QUICKBOOKS_CRLF;
			$soap .= '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">' . QUICKBOOKS_CRLF;
			$soap .= '	<SOAP-ENV:Body>' . QUICKBOOKS_CRLF;
			$soap .= '		<SOAP-ENV:Fault>' . QUICKBOOKS_CRLF;
			$soap .= '			<faultcode>SOAP-ENV:Client</faultcode>' . QUICKBOOKS_CRLF;
			$soap .= '			<faultstring>Bad Request: ' . htmlspecialchars($errnum) . ': ' . htmlspecialchars($errmsg) . '</faultstring>' . QUICKBOOKS_CRLF;
			$soap .= '		</SOAP-ENV:Fault>' . QUICKBOOKS_CRLF;
			$soap .= '	</SOAP-ENV:Body>' . QUICKBOOKS_CRLF;
			$soap .= '</SOAP-ENV:Envelope>' . QUICKBOOKS_CRLF;
			
			print($soap);
			return false;
		}
	}
	
	protected function _namespace($full_tag, &$namespace)
	{
		if (false !== strpos($full_tag, ':'))
		{
			$tmp = explode(':', $full_tag);
		
			$namespace = current($tmp);
			return next($tmp);
		}
		
		$namespace = '';
		return $full_tag;
	}
	
	/**
	 * 
	 */
	protected function _serialize($vars)
	{
		$soap = '';
		
		if (is_array($vars))
		{
			foreach ($vars as $key => $value)
			{
				$soap .= '<ns1:' . $key . '>';
				
				if (is_array($value))
				{
					foreach ($value as $subkey => $subvalue)
					{
						$soap .= '<ns1:string>' . htmlspecialchars($subvalue) . '</ns1:string>' . "\n";
					}
				}
				else
				{
					$soap .= htmlspecialchars($value);
				}
				
				$soap .= '</ns1:' . $key . '>';
			}
		}
		
		return $soap;
	}
	
	/** 
	 * 
	 */
	public function setClass($class, $dsn_or_conn, $map, $onerror, $hooks, $log_level, $raw_http_input, $handler_options, $driver_options, $callback_options)
	{
		$this->_class = new $class($dsn_or_conn, $map, $onerror, $hooks, $log_level, $raw_http_input, $handler_options, $driver_options, $callback_options);
	}
	
	/**
	 * 
	 */
	public function getFunctions()
	{
		return get_class_methods($this->_class);
	}

}
