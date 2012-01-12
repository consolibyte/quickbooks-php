<?php



include ('OAuthSimple.php');  

class QuickBooks_IPP_IntuitAnywhere 
{
	protected $_this_url;
	protected $_that_url;
	
	protected $_consumer_key;
	protected $_consumer_secret;
	
	protected $_errnum;
	protected $_errmsg;
	
	protected $_debug;
	
	protected $_oauth_token;
	protected $_oauth_token_secret;
	
	const URL_REQUEST_TOKEN = 'https://oauth.intuit.com/oauth/v1/get_request_token';
	const URL_ACCESS_TOKEN = 'https://oauth.intuit.com/oauth/v1/get_access_token';
	const URL_CONNECT_BEGIN = 'https://appcenter.intuit.com/Connect/Begin';
	
	var $authenticated;

	/**
	 * 
	 *
	 * @param string $consumer_key		The OAuth consumer key Intuit gives you
	 * @param string $consumer_secret	The OAuth consumer secret Intuit gives you
	 * @param string $this_url			The URL of your QuickBooks_IntuitAnywhere class instance
	 * @param string $that_url			The URL the user should be sent to after authenticated 
	 */
	public function __construct($consumer_key, $consumer_secret, $this_url, $that_url) 
	{
		$this->_this_url = $this_url;
		$this->_that_url = $that_url;
		
		$this->_consumer_key = $consumer_key;
		$this->_consumer_secret = $consumer_secret;
		
		$this->_debug = false;
		
		$this->_oauth_token = null;
		$this->_oauth_token_secret = null;
	}

	/**
	 * Turn on/off debug mode
	 * 
	 * @param boolean $true_or_false
	 */
	public function useDebugMode($true_or_false)
	{
		$this->_debug = (boolean) $true_or_false;
	}
	
	/**
	 * Get the last error number
	 * 
	 * @return integer
	 */
	public function errorNumber()
	{
		return $this->_errnum;
	}
	
	/**
	 * Get the last error message
	 * 
	 * @return string
	 */
	public function errorMessage()
	{
		return $this->_errmsg;
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
	
	public function handle()
	{
		if ($this->authenticated)
		{
			// They are already logged in, send them on to exchange data
			print('
				Already authenticated, go here:	<a href="' . $this->_that_url . '">' . $this->_that_url . '</a>
			');
			exit;
		}
		else
		{
			if (isset($_REQUEST['oauth_token']))
			{
				// We're in the middle of an OAuth token session
				
				print('TOKEN [[' . $_REQUEST['oauth_token'] . ']]');
				print('<br /><br />');
				
				$arr = mysql_fetch_array(mysql_query("
					SELECT
						*
					FROM
						quickbooks_oauth
					WHERE
						oauth_request_token = '" . $_REQUEST['oauth_token'] . "' "));
				
				if ($arr)
				{
					//$this->_oauth_token = $arr['oauth_token'];
					//$this->_oauth_token_secret = $arr['oauth_token_secret'];
					
					$info = $this->_getAccessToken(
						$arr['oauth_request_token'], 
						$arr['oauth_request_token_secret'], 
						$_REQUEST['oauth_verifier']);
					
					if ($info)
					{
						mysql_query("
							UPDATE
								quickbooks_oauth
							SET
								oauth_access_token = '" . $info['oauth_token'] . "', 
								oauth_access_token_secret = '" . $info['oauth_token_secret'] . "', 
								qb_realm = '" . $_REQUEST['realmId'] . "', 
								qb_flavor = '" . $_REQUEST['dataSource'] . "'
							WHERE
								quickbooks_oauth_id = " . $arr['quickbooks_oauth_id']);
						
						
						print_r($_REQUEST);
						print_r($info);
		
						//print('authd now, go here <a href="exchange_data.php">exchange_data.php</a>');
						header('Location: ' . $this->_that_url);
						exit;
					}
					else
					{
						// Something went wrong when fetching the user token...?
						print('something went wrong fetching user token');
					}
				}
				else
				{
					print('something went wrong... invalid oauth token?');
				}
			}
			else
			{
				$auth_url = $this->_getAuthenticateURL($this->_this_url);
				
				// Forward them to the auth page
				header('Location: ' . $auth_url);
				exit;
			}
		}
		
		return true;
	}


	

	/* USER AUTHENTICATION FUNCTIONS */
		
	protected function _getAuthenticateURL($url) 
	{
		$info = $this->_request(QuickBooks_IntuitAnywhere::URL_REQUEST_TOKEN, array('oauth_callback' => $url));
		
		$vars = array();
		parse_str($info, $vars);
		
		mysql_query("
			INSERT INTO 
				quickbooks_oauth
			(
				oauth_request_token,
				oauth_request_token_secret
			) VALUES (
				'" . $vars['oauth_token'] . "',
				'" . $vars['oauth_token_secret'] . "'
			)");
		
		return QuickBooks_IntuitAnywhere::URL_CONNECT_BEGIN . '?oauth_callback=' . urlencode($url) . '&oauth_consumer_key=' . $this->_consumer_key . '&oauth_token=' . $vars['oauth_token'];	
	}
	
	protected function _getAccessToken($oauth_token, $oauth_token_secret, $verifier) 
	{
		if ($str = $this->_request(QuickBooks_IntuitAnywhere::URL_ACCESS_TOKEN, array( 'oauth_verifier' => $verifier ), '', $oauth_token, $oauth_token_secret))
		{
			$info = array();
			parse_str($tmp, $info);
			
			return $info;		
		}
		
		return false;
	}
	
	public function widgetConnect()
	{
		
	}
		
	public function widgetMenu() 
	{
		try {
			return $this->_request('https://appcenter.intuit.com/api/v1/Account/AppMenu',array(),true);
		} catch (OAuthSimpleException $e) {
			print_r($e);
		}
	}

	protected function _request($path, $parameters = array(), $authenticated = false, $token = '', $secret = '', $data = '') 
	{
		$oauth = new OAuthSimple();
		
		$signatures = array(
			'consumer_key' => $this->_consumer_key, 
			'shared_secret' => $this->_consumer_secret  
		);
		
    if ( $authenticated ) {
    	$signatures['access_token'] = $this->access_token;
    	$signatures['access_secret'] = $this->access_secret;
    
    } elseif ( $token ) {
    	$signatures['access_token'] = $token;
    	$signatures['access_secret'] = $secret;
    } 
    
    $sign_args = array(
    	'path'=>$path,  
      'parameters'=>$parameters,  
      'signatures'=>$signatures
    );
    
    if ( $data ) {
    	$sign_args['action'] = 'POST';
    }
    $signed = $oauth->sign($sign_args);  

		

    $curl = curl_init();  
    if ( $data ) {
		/* THIS IS WHERE I STARTED PLAYING WITH DIFFERENT THINGS TO GET THE POST TO WORK */
		
    	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: '.$signed['header']));//,'Content-Type: application/xml'));
  		curl_setopt($curl, CURLOPT_URL,$path);
    	curl_setopt($curl, CURLOPT_POST,       1 );
    	curl_setopt($curl, CURLOPT_POSTFIELDS, urlencode($data) );
    } else {
    	curl_setopt($curl, CURLOPT_URL,$signed['signed_url']);  
    }    
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);  
    
    //curl_setopt($curl,CURLOPT_ENCODING,'gzip,deflate');
    //curl_setopt($curl,CURLOPT_SETTIMEOUT,2);  
    
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    
    $buffer = curl_exec($curl);  
    
    /*
    print('<pre>');
    print_r(curl_getinfo($curl));
    print('</pre>');
    
  	print('[[' . $buffer . ']]');
  	*/
  	
  	return $buffer;  
  	
  	
	
	}
}


