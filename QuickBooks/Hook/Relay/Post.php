<?php

/**
 * 
 * 
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Hook.php');

/**
 * 
 */
class QuickBooks_Hook_Relay_POST extends QuickBooks_Hook
{
	protected $_url;
	protected $_data;
	
	public function __construct($url, $other_data = array())
	{
		$this->_url = $url;
		$this->_data = (array) $other_data;
		
		parent::__construct($url);
	}
	
	public function hook($requestID, $user, $hook, &$err, $hook_data, $callback_config)
	{
		return $this->_post($hook_data, $err);
	}
	
	/**
	 * 
	 * 
	 * @todo Implement fsockopen() support
	 */
	protected function _post($data, &$err)
	{
		if (is_array($data))
		{
			// Merge any other data passed to the constructor into the array
			$data = array_merge($this->_data, $data);
			
			// Transform $data into a URL encoded string
			$data = http_build_query($data);
		}
		
		// POST the data to a remote host
		if (function_exists('curl_init'))
		{
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $this->_url);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			
			$response = curl_exec($ch);
			curl_close($ch);
			
			$tmp = explode(' ', $response);
			$status = (int) next($tmp);
			
			if ((int) $status == 200)
			{
				return true;
			}
			
			$err = 'Remote website returned a non-"200 OK" response: "' . $response . '"';
			return false;
		}
		else
		{
			$err = get_class($this) . ' requires the CURL PHP extension, sorry.';
			return false;
		}
	}
}