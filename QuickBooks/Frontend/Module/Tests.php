<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

QuickBooks_Loader::load('/QuickBooks/Test/Driver.php');

class QuickBooks_Frontend_Module_Tests extends QuickBooks_Frontend_Module
{
	protected $_driver;
	protected $_skin;
	
	final public function __construct($driver, $skin, $menu)
	{
		$this->_driver = $driver;
		$this->_skin = $skin;
	}
	
	/**
	 * 
	 * 
	 * @return array 
	 */
	protected function _authenticateParameters()
	{
		$defaults = array(
			'username' => '', 
			'password' => '', 
			);
		
		if (isset($_POST['authenticate']) and is_array($_POST['authenticate']))
		{
			return array_merge($defaults, $_POST['authenticate']);
		}
		
		return $defaults;
	}
	
	/**
	 * 
	 * 
	 * @return array
	 */
	protected function _sendRequestXMLParameters()
	{
		$defaults = array(
			'ticket' => '', 
			'majorversion' => '1', 
			'minorversion' => '0', 
			'country' => 'US', 
			'companyfile' => '', 
			'hcpresponse' => '', 
			);
		
		if (isset($_POST['sendRequestXML']) and is_array($_POST['sendRequestXML']))
		{
			return array_merge($defaults, $_POST['sendRequestXML']);
		}
		
		return $defaults;
	}
	
	protected function _receiveResponseXMLParameters()
	{
		$defaults = array(
			'ticket' => '', 
			'hresult' => '', 
			'message' => '', 
			'response' => '',  
			);
		
		if (isset($_POST['receiveResponseXML']) and is_array($_POST['receiveResponseXML']))
		{
			return array_merge($defaults, $_POST['receiveResponseXML']);
		}
		
		return $defaults;
	}
	
	protected function _soapMethod()
	{
		if (isset($_POST['soap_method']))
		{
			return $_POST['soap_method'];
		}	
		
		return null;
	}
	
	protected function _soapURL()
	{
		if (isset($_POST['soap_url']))
		{
			return $_POST['soap_url'];
		}
		
		return null;
	}
	
	public function home($MOD, $DO)
	{
		$available = array(
			'QuickBooks_Test_Driver_Mysql', 
			'QuickBooks_Test_Driver_Pgsql', 
			);
		
		$Test = new QuickBooks_Test_Driver();
		$Test->run(false);
		
		$result = $Test->result();
		print_r($result);
	}
	
	public function clientForm($MOD, $DO)
	{
		$soap_url = $this->_soapURL();
		if (empty($soap_url))
		{
			$soap_url = 'https://';
			if ($_SERVER['HTTP_HOST'] == 'localhost' or empty($_SERVER['HTTPS']))
			{
				$soap_url = 'http://';
			}
			$soap_url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/server.php';
		}
		
		$soap_method = $this->_soapMethod();
		
		$this->_skin->assign('soap_url', $soap_url);
		$this->_skin->assign('soap_method', $soap_method);
		
		$this->_skin->display('Tests/clientForm.tpl');
	}
	
	public function clientResult($MOD, $DO)
	{
		$Client = new QuickBooks_Client($this->_soapURL());
		
		switch ($this->_soapMethod())
		{
			case 'authenticate':
				
				$params = $this->_authenticateParameters();
				$result = $Client->authenticate($params['username'], $params['password']);
				
				break;
			case 'clientVersion':
				
				break;
			case 'serverVersion':
				
				break;
			case 'sendRequestXML':
				
				$params = $this->_sendRequestXMLParameters();
				$result = $Client->sendRequestXML($params['ticket'], 
					$params['hcpresponse'], 
					$params['companyfile'], 
					$params['country'], 
					$params['majorversion'], 
					$params['minorversion']);
				
				break;
			case 'receiveResponseXML':
				
				$params = $this->_receiveResponseXMLParameters();
				$result = $Client->receiveResponseXML($params['ticket'], 
					$params['response'], 
					$params['hresult'], 
					$params['message']);
				
				break;
		}
		
		$this->_skin->assign('soap_method', $this->_soapMethod());
		$this->_skin->assign('soap_url', $this->_soapURL());
		
		switch ($this->_soapMethod())
		{
			case 'authenticate':
				
				$this->_skin->assign('new_soap_method', 'sendRequestXML');
				
				break;
			case 'sendRequestXML':
				
				$this->_skin->assign('new_soap_method', 'receiveResponseXML');
				
				break;
			case 'receiveResponseXML':
				
				$this->_skin->assign('new_soap_method', 'sendRequestXML');
				
				break;
		}
		
		$raw_request = $Client->getLastRequest();
		
		$errnum = 0;
		$errmsg = '';
		$Parser = new QuickBooks_XML($raw_request);
		$formatted_request = $Parser->beautify($errnum, $errmsg, false);
		
		$raw_response = $Client->getLastResponse();
		$errnum = 0;
		$errmsg = '';
		$Parser = new QuickBooks_XML($raw_response);
		$formatted_response = $Parser->beautify($errnum, $errmsg, false);
		
		$this->_skin->assign('result', $result);
		$this->_skin->assign('soap_raw_request', $raw_request);
		$this->_skin->assign('soap_formatted_request', $formatted_request);
		$this->_skin->assign('soap_raw_response', $raw_response);
		$this->_skin->assign('soap_formatted_response', $formatted_response);
		
		$this->_skin->display('Tests/clientResult.tpl');
	}
	
	static public function menu()
	{
		return array(
			//'?MOD=tests&DO=home' => 'Run Tests', 
			'?MOD=tests&DO=clientForm' => 'SOAP Client', 
			);
	}
	
	static public function name()
	{
		return 'Tests';
	}
	
	static public function order()
	{
		return 50;
	}
}
	
?>