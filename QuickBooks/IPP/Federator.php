<?php

/**
 * SAML Gateway for Intuit Partner Platform integrations
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@ConsoliBYTE.com>
 * 
 * @package QuickBooks
 * @subpackage IPP
 */

/*
function federator_callback($ticket, $target_url, $auth_id)
{
	
	
	return TRUE;		// return TRUE to let the Federator instance redirect to $target_url
	return FALSE;		// return FALSE to handle whatever happens next yourself
}

if you don't provide a callback function, a default callback will be used 
which stores the data in the database defined by $dsn, and then forwards 
the user on to the target URL.

*/

if (!defined('QUICKBOOKS_IPP_FEDERATOR_MAX_SAML_LENGTH'))
{
	/**
	 * 
	 */
	define('QUICKBOOKS_IPP_FEDERATOR_MAX_SAML_LENGTH', 8200);
}

if (!defined('QUICKBOOKS_IPP_FEDERATOR_TEST_SAML'))
{
	define('QUICKBOOKS_IPP_FEDERATOR_TEST_SAML', 'PHNhbWxwOlJlc3BvbnNlIElzc3VlSW5zdGFudD0iMjAxMC0wNC0yMlQxNDozMDo0Ni44MDJaIiBJRD0iWmJpeWVyTGExWGxPajdZejdxempwZlhYdGZrIiBWZXJzaW9uPSIyLjAiIHhtbG5zOnNhbWxwPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6cHJvdG9jb2wiPjxzYW1sOklzc3VlciB4bWxuczpzYW1sPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6YXNzZXJ0aW9uIj5JREZFRF9QUk9EX0lEUF9TUF9BUFA8L3NhbWw6SXNzdWVyPjxzYW1scDpTdGF0dXM+PHNhbWxwOlN0YXR1c0NvZGUgVmFsdWU9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpzdGF0dXM6U3VjY2VzcyIvPjwvc2FtbHA6U3RhdHVzPjxzYW1sOkFzc2VydGlvbiBWZXJzaW9uPSIyLjAiIElzc3VlSW5zdGFudD0iMjAxMC0wNC0yMlQxNDozMDo0Ni44MzhaIiBJRD0iTmpmMnouQWZ3bFhXMUZxVU9PZmFFX2lkaWNQIiB4bWxuczpzYW1sPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6YXNzZXJ0aW9uIj48c2FtbDpJc3N1ZXI+SURGRURfUFJPRF9JRFBfU1BfQVBQPC9zYW1sOklzc3Vlcj48ZHM6U2lnbmF0dXJlIHhtbG5zOmRzPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjIj4KPGRzOlNpZ25lZEluZm8+CjxkczpDYW5vbmljYWxpemF0aW9uTWV0aG9kIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8xMC94bWwtZXhjLWMxNG4jIi8+CjxkczpTaWduYXR1cmVNZXRob2QgQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjcnNhLXNoYTEiLz4KPGRzOlJlZmVyZW5jZSBVUkk9IiNOamYyei5BZndsWFcxRnFVT09mYUVfaWRpY1AiPgo8ZHM6VHJhbnNmb3Jtcz4KPGRzOlRyYW5zZm9ybSBBbGdvcml0aG09Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvMDkveG1sZHNpZyNlbnZlbG9wZWQtc2lnbmF0dXJlIi8+CjxkczpUcmFuc2Zvcm0gQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzEwL3htbC1leGMtYzE0biMiLz4KPC9kczpUcmFuc2Zvcm1zPgo8ZHM6RGlnZXN0TWV0aG9kIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnI3NoYTEiLz4KPGRzOkRpZ2VzdFZhbHVlPnp1ampTSUFHdnZQd01pUTdIV2ZOM1ZZTHI3WT08L2RzOkRpZ2VzdFZhbHVlPgo8L2RzOlJlZmVyZW5jZT4KPC9kczpTaWduZWRJbmZvPgo8ZHM6U2lnbmF0dXJlVmFsdWU+CmpzY3hPRnk2T3dwc0ZoNVJ3Wk5RQXBBRFBFWVcrZytKWDlwUEtrTnJ2c0ExYnVkRDJFb3Y4bjNSaDFHVTVwTU84RzM0YWNMZnJhTysKWWVMcWNpTnYvMkVQYzRKUUFqdnhuOWtiekN5eXMvaGlvZGk2QmN6eHJHRFVlZ1JWRUtLUnhieFNHOHVoUmdZd1FIdHQ4VW1FSUt3NApzbGlXUGM4SE9XUUxIZHk5bG9TUjVoVVpSRGMxVGpBSEJVQlFYdnNydXNKdDBGa1g3aHk3MVE0R2lrOE9NOUFFKzF6OEVzR2J6b1RwCnIweXlYUFBFZVlDMCtaRGZLUUZDZ081b2hJZEdZRWtJY1hRRjNxajQ1VVVlQUVnZVM3SmdGSzB3a2NWSVRIU1MxOFIxanlCQ3RFeWUKOEtnQWdKUEwzVjF2V3kzeTM2aWFxOUNNOUE0M2RLeDFaeEJ1aUE9PQo8L2RzOlNpZ25hdHVyZVZhbHVlPgo8L2RzOlNpZ25hdHVyZT48c2FtbDpTdWJqZWN0PjxzYW1sOk5hbWVJRCBGb3JtYXQ9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjEuMTpuYW1laWQtZm9ybWF0OnVuc3BlY2lmaWVkIj5iMjUwM2Y3OS0wOTFmLTRjNmQtYWJkZS0wZmJmNTQxYzM4ZjQ8L3NhbWw6TmFtZUlEPjxzYW1sOlN1YmplY3RDb25maXJtYXRpb24gTWV0aG9kPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6Y206YmVhcmVyIj48c2FtbDpTdWJqZWN0Q29uZmlybWF0aW9uRGF0YSBOb3RPbk9yQWZ0ZXI9IjIwMTAtMDQtMjJUMTQ6MzU6NDYuODM4WiIgUmVjaXBpZW50PSJodHRwczovL3NlY3VyZS5jb25zb2xpYnl0ZS5jb20vZGV2ZWwvc2FtbC90ZXN0LnBocCIvPjwvc2FtbDpTdWJqZWN0Q29uZmlybWF0aW9uPjwvc2FtbDpTdWJqZWN0PjxzYW1sOkNvbmRpdGlvbnMgTm90T25PckFmdGVyPSIyMDEwLTA0LTIyVDE0OjM1OjQ2LjgzOFoiIE5vdEJlZm9yZT0iMjAxMC0wNC0yMlQxNDoyODo0Ni44MzhaIj48c2FtbDpBdWRpZW5jZVJlc3RyaWN0aW9uPjxzYW1sOkF1ZGllbmNlPnBocC5jb25zb2xpYnl0ZS5wcm9kLWludHVpdC5pcHAucHJvZDwvc2FtbDpBdWRpZW5jZT48L3NhbWw6QXVkaWVuY2VSZXN0cmljdGlvbj48L3NhbWw6Q29uZGl0aW9ucz48c2FtbDpBdXRoblN0YXRlbWVudCBBdXRobkluc3RhbnQ9IjIwMTAtMDQtMjJUMTQ6MzA6NDYuODM4WiIgU2Vzc2lvbkluZGV4PSJOamYyei5BZndsWFcxRnFVT09mYUVfaWRpY1AiPjxzYW1sOkF1dGhuQ29udGV4dD48c2FtbDpBdXRobkNvbnRleHRDbGFzc1JlZj51cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6YWM6Y2xhc3Nlczp1bnNwZWNpZmllZDwvc2FtbDpBdXRobkNvbnRleHRDbGFzc1JlZj48L3NhbWw6QXV0aG5Db250ZXh0Pjwvc2FtbDpBdXRoblN0YXRlbWVudD48c2FtbDpBdHRyaWJ1dGVTdGF0ZW1lbnQgeG1sbnM6eHM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvWE1MU2NoZW1hIj48c2FtbDpBdHRyaWJ1dGUgTmFtZUZvcm1hdD0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6Mi4wOmF0dHJuYW1lLWZvcm1hdDpiYXNpYyIgTmFtZT0iSW50dWl0LkZlZGVyYXRpb24ucmVhbG1JRFBzZXVkb255bSI+PHNhbWw6QXR0cmlidXRlVmFsdWUgeHNpOnR5cGU9InhzOnN0cmluZyIgeG1sbnM6eHNpPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxL1hNTFNjaGVtYS1pbnN0YW5jZSI+Yjc2NWZkM2QtYzJhNC00ZDEyLTlmNTUtMTAzMzdiMGQ3NWMzPC9zYW1sOkF0dHJpYnV0ZVZhbHVlPjwvc2FtbDpBdHRyaWJ1dGU+PHNhbWw6RW5jcnlwdGVkQXR0cmlidXRlPjx4ZW5jOkVuY3J5cHRlZERhdGEgVHlwZT0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8wNC94bWxlbmMjRWxlbWVudCIgeG1sbnM6eGVuYz0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8wNC94bWxlbmMjIj48eGVuYzpFbmNyeXB0aW9uTWV0aG9kIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8wNC94bWxlbmMjYWVzMTI4LWNiYyIgeG1sbnM6eGVuYz0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8wNC94bWxlbmMjIi8+PGRzOktleUluZm8geG1sbnM6ZHM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvMDkveG1sZHNpZyMiPgo8eGVuYzpFbmNyeXB0ZWRLZXkgeG1sbnM6eGVuYz0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8wNC94bWxlbmMjIj48eGVuYzpFbmNyeXB0aW9uTWV0aG9kIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8wNC94bWxlbmMjcnNhLTFfNSIgeG1sbnM6eGVuYz0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8wNC94bWxlbmMjIi8+PHhlbmM6Q2lwaGVyRGF0YSB4bWxuczp4ZW5jPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGVuYyMiPjx4ZW5jOkNpcGhlclZhbHVlIHhtbG5zOnhlbmM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvMDQveG1sZW5jIyI+V1dLY3RxaVlOUUYrdTc3MklvUm5ONnAvZHlOUDYrU2FRZ0R2TE5wNEd4SEphR3l2a2kvYjEzNGs4OG9meVduM2sxT05qdHJXbm9MUApiRCttRFY5Q2lOeS9Qbk1NZEdWS0xGUjdFV1JFV1prNDVKck1jN2FnZkF3SE1TTGVCOGxXaFJ3R3NkQmdnNlJGU0c1aHdveThKZXUzClN0blIrS21VclNHMURtRVJweDg9PC94ZW5jOkNpcGhlclZhbHVlPjwveGVuYzpDaXBoZXJEYXRhPjwveGVuYzpFbmNyeXB0ZWRLZXk+PC9kczpLZXlJbmZvPjx4ZW5jOkNpcGhlckRhdGEgeG1sbnM6eGVuYz0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8wNC94bWxlbmMjIj48eGVuYzpDaXBoZXJWYWx1ZSB4bWxuczp4ZW5jPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGVuYyMiPjhUT3pyRjlUNUdqM3ZXdkh2NmM1UCttZE9TR3Qyd0N0ek11LzgxVmxUNC9NVEZmM1J1dXJ1U01JSTcvUUF4RUNvd3lIbHpUeWxyRzgKS2k0dEE1T3dzVkhvd3Fneitmbng3UTU4MTdQUyszKzBTR2JERkFwblQ5a3ZRVEZkZWZGS3d4UXhnL25kTUNHZCtzRDFEZWk0VEIyMwpJTXVpRkVURExNWDhqOCtjQWZKTDdUdTA4WkZIQVZTaWF1enM5bkNtUHVvZzcxR0tIcHpmSkdocDNvZXdGbnN6M010ZWVYUm8yWHVUCmNWTjhsOElnWUV5OHl2b2RPQTlNc3RpSnFWZWNYWVFLODR4NTJtUjdsOFpPb1JENHFaZzZsRzBaNHNnZDRjcVFUVlY1QUtvNldlS0oKbi9wL3NvUmhBOTB1TWMyMGl5c1JHd0doS0JoOENHZHlKOXV2c0h4c3cxVHVXUGRSM0N0VXB2NVlZejhxK0UzeWppV0VsVCtPaEhXOQpoYWN4b2x5cTA5M2Npbm9sdUQycTNLWjVjSkxWQndpcXV3TklJWkNvbzIvWHVaYjIrd0x3QmpyN1pkdDlUSUI5V1lRelcxcnJWTUpBCk9VMmFBOVNWdEhxcytqTitQMnVGODYwVWxsdEd5YmlxWjFiQ2MyOWk1VHR5Y000STVuWVhVcC9ET2FlZGZWTllQSlBpYmgzRVBoSDEKZVk5SDdDeENSWURYL1V5SkJiTUtldXozNEtWQ1ByeWN0TzFzQ1hQUmtlN0lIS3A4Z2NodjRLYjZ6UERhcEVJUFdEeUxtRzRXOCtnNgpWdnFoMVNsY1Q4TkRhdTF0UEZzOURtT3NNTkdGYTBrVDwveGVuYzpDaXBoZXJWYWx1ZT48L3hlbmM6Q2lwaGVyRGF0YT48L3hlbmM6RW5jcnlwdGVkRGF0YT48L3NhbWw6RW5jcnlwdGVkQXR0cmlidXRlPjxzYW1sOkF0dHJpYnV0ZSBOYW1lRm9ybWF0PSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6YXR0cm5hbWUtZm9ybWF0OmJhc2ljIiBOYW1lPSJyZWFsbUlEIj48c2FtbDpBdHRyaWJ1dGVWYWx1ZSB4c2k6dHlwZT0ieHM6c3RyaW5nIiB4bWxuczp4c2k9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvWE1MU2NoZW1hLWluc3RhbmNlIj4xNzM2NDI0Mzg8L3NhbWw6QXR0cmlidXRlVmFsdWU+PC9zYW1sOkF0dHJpYnV0ZT48c2FtbDpBdHRyaWJ1dGUgTmFtZUZvcm1hdD0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6Mi4wOmF0dHJuYW1lLWZvcm1hdDpiYXNpYyIgTmFtZT0idGFyZ2V0VXJsIj48c2FtbDpBdHRyaWJ1dGVWYWx1ZSB4c2k6dHlwZT0ieHM6c3RyaW5nIiB4bWxuczp4c2k9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvWE1MU2NoZW1hLWluc3RhbmNlIj5odHRwczovL3NlY3VyZS5jb25zb2xpYnl0ZS5jb20vZGV2ZWwvc2FtbC90ZXN0Mi5waHA8L3NhbWw6QXR0cmlidXRlVmFsdWU+PC9zYW1sOkF0dHJpYnV0ZT48L3NhbWw6QXR0cmlidXRlU3RhdGVtZW50Pjwvc2FtbDpBc3NlcnRpb24+PC9zYW1scDpSZXNwb25zZT4=');
}

if (!defined('QUICKBOOKS_IPP_FEDERATOR_TEST_KEY'))
{
	define('QUICKBOOKS_IPP_FEDERATOR_TEST_KEY', '-----BEGIN RSA PRIVATE KEY-----' . "\n" . 'MIICXgIBAAKBgQDJ44e+mLkoqSeEwy81RajedaZ6UbGsS1LTVFyZp+0S6JTISmoT' . "\n" . 'ZpkuiDsvMxWrYnGQmA/SHUySx41KQWsMd13JjGOVQp569xlu1O/q7/5cPGiUkCb/' . "\n" . 'j+OdBI5KWgsGo6G5KMHEL8FcXNKWsZaldKLObyx5mUeFXYJZIxSIgThGcQIDAQAB' . "\n" . 'AoGBAJnao+BEUxcBkfRDKv7WD1M5JZ2iFFzRKlWSvN78clcul/Prgds3HRWxDCl0' . "\n" . 'LNdnNlSTDbt6SJizKqGkKQhfD0DmzPRC6JW2hXFIbr4xBIHQ4g4sH/v7AphxFk0R' . "\n" . '7zyjfa/kVd7EJgnf1mZubqYm3wu7iEPvUVsZ3p4/3DnshdKBAkEA7IuaQULUnhXt' . "\n" . 'h74xgLLRA6baWRquQtACBPqtENjwqEhSek196/0MXLmRhmTeGGjx3yD6MSSuEtLq' . "\n" . '9jAZwYzaTQJBANp+Pmt03YFY6+MHnkpAvqgRaCFoDBvV9LNP4c484LN+svuuCTJQ' . "\n" . 'kBqBD6Q3yHrprn/zOZNpRtoyfBWMGMFkprUCQG9z6496TLHbxRpjW/G2z1K4KEM5' . "\n" . 'lgf2+CyebDL29JVl1i64Gm+5wDxkVxQKrLa1o9ktMZU8IiTOalTrHweaNTUCQQCx' . "\n" . 'pXVQ3yr98PORmm8bxjp94fE9QCCgPTyA0lEw4xR7PGd/9Eer7g7MTeUOywAo13i2' . "\n" . 'tWY5sZ4W6Hc0+bxi+VgFAkEAk2GLtkjfpdE87HZ1wOUF6Hy2BRiY/ENDPo4oC+00' . "\n" . '07OqlunePjrq/GvJDha6EKkrsdPdBVaPiArLpPZ14HKVkQ==' . "\n" . '-----END RSA PRIVATE KEY-----');
}

// 
QuickBooks_Loader::load('/QuickBooks/XML/Parser.php');

// 
QuickBooks_Loader::load('/QuickBooks/Callbacks.php');

/**
 * 
 * 
 *
 */
class QuickBooks_IPP_Federator
{
	/**
	 * SAML authorization
	 * @var string
	 */
	const TYPE_SAML = 'saml';
	
	/**
	 * No error, everything is OK
	 * @var integer
	 */
	const ERROR_OK = QUICKBOOKS_ERROR_OK;
	
	/**
	 * Error indicating there's a problem with the key file
	 * @var integer
	 */
	const ERROR_KEY = 1;
	
	const ERROR_XML = 2;
	
	const ERROR_SAML = 3;
	
	const ERROR_INTERNAL = 4;
	
	const ERROR_CALLBACK = 5;
	
	const ERROR_COOKIE = 6;
	
	const URL_OAUTH = 'https://oauth.intuit.com/oauth/v1/get_access_token_by_intuit_pseudonym';
	
	const TIMEOUT_OAUTH = 3000;		// Expires after almost an hour
	
	protected $_type;
	
	protected $_key;
	
	protected $_callback;
	
	protected $_driver;
	
	protected $_debug;
	
	protected $_errnum;
	
	protected $_errmsg;
	
	protected $_config;
	
	protected $_log;

	public function __construct($private_key, $dsn = null, $callback = null, $config = array())
	{
		$this->_key = $private_key;
		
		$this->_driver = null;
		if ($dsn)
		{
			// @todo Logging
			$this->_driver = QuickBooks_Driver_Factory::create($dsn);
		}
		
		$this->_log = '';
		
		$this->_errnum = QuickBooks_IPP_Federator::ERROR_OK;
		$this->_errmsg = '';
		
		$this->_callback = $callback;
		
		$this->_config = $this->_defaults($config);
	}
	
	protected function _defaults($config)
	{
		$defaults = array(
			'cookie_httponly' => true, 
			'cookie_secure' => null, 		// null is for auto-detection based on $_SERVER['HTTPS']
			'cookie_domain' => '',			// www.php.net/setcookie() says we can send an empty string for the default value of the current domain 
			'cookie_path' => '/', 
			'cookie_expire' => 0, 			// expire when the browser closes
			
			'http_redirect_method' => null, 
			'http_redirect_delay' => 0, 
			
			'test_username' => '', 
			'test_password' => '', 
			'test_target' => '', 
			'test_param_dbid' => '', 
			'test_param_realm' => '', 
			'test_param_state' => '', 
			
			'segfault_openssl_private_decrypt' => null, 
			
			'log_string' => true,
			'log_level' => QUICKBOOKS_LOG_NORMAL, 
			);
		
		$config = array_merge($defaults, (array) $config);
		
		if (is_null($config['cookie_secure']))
		{
			$config['cookie_secure'] = (boolean) isset($_SERVER['HTTPS']);
		}
		
		return $config;
	}
	
	protected function _log($msg, $level = QUICKBOOKS_LOG_NORMAL)
	{
		if ($this->_config['log_level'] >= $level)
		{
			if ($this->_debug)
			{
				print(date('Y-m-d H:i:s') . ': ' . $msg . QUICKBOOKS_CRLF);
			}
			
			if ($this->_config['log_string'])
			{
				$this->_log .= $msg . QUICKBOOKS_CRLF . QUICKBOOKS_CRLF . QUICKBOOKS_CRLF;
			}
			
			if ($this->_driver)
			{
				
			}
		}
	}
	
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
	
	public function lastLog()
	{
		return $this->_log;
	}
		
	public function handle($input = null)
	{
		// We only support SAML for now
		return $this->_handleSAML($input);
	}
	
	/**
	 * Check if an OAuth token auth/realm psuedonym for the given user
	 * 
	 * @param string $token					Your Intuit application token
	 * @param string $encryption_key		Your internal encryption key
	 * @param string $user					The username or user ID from within your app
	 * @param string $tenant				The tenant ID from within your app
	 * @return boolean						TRUE if OAuth credentials exist, FALSE if they do not
	 */
	public function checkOAuth($token, $encryption_key, $user, $tenant)
	{
		/*
		if ($arr = $this->loadOAuth($token, $encryption_key, $user, $tenant))
		{
			return true;
		}
		*/
		
		if (!$this->_driver)
		{
			return false;
		}
		
		if ($arr = $this->_driver->oauthLoad($encryption_key, $user, $tenant))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * 
	 * @param string $token					Your Intuit application token
	 * @param string $encryption_key		Your internal encryption key
	 * @param string $user					The username or user ID from within your app
	 * @param string $tenant				The tenant ID from within your app
	 * @return array						An array of OAuth credentials 
	 */
	public function loadOAuth($token, $encryption_key, $user, $tenant)
	{
		if (!$this->_driver)
		{
			return false;
		}
		
		if ($arr = $this->_driver->oauthLoad($encryption_key, $user, $tenant) and
			strlen($arr['oauth_access_token']) > 0 and
			strlen($arr['oauth_access_token_secret']) > 0)
		{
			$arr['oauth_consumer_key'] = $token;
			$arr['oauth_consumer_secret'] = null;
			
			return $arr;
		}
			
		return false;
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public function refreshOAuth($provider, $token, $pem_key, $encryption_key, $app_username, $app_tenant)
	{
		if (!$this->_driver)
		{
			$this->_log('Could not connect to OAuth, no DRIVER storage instance.');
			return false;
		}
		
		// Load from OAuth
		$arr = $this->_driver->oauthLoad($encryption_key, $app_username, $app_tenant);
		
		if ($arr)
		{
			// Check the timestamps to see if they are more than 1 HOUR old
			if (time() - strtotime($arr['access_datetime']) < QuickBooks_IPP_Federator::TIMEOUT_OAUTH)
			{
				// Use the existing tokens
				
				print('USING EXISTING TOKEN' . "\n\n");
				
				return true;
			}
			else
			{
				// Otherwise, fetch a new OAuth token
				
				//print('we need to fetch a new token,e xpired!');
				//print_r($arr);
				
				print('REFRESHING TOKEN!' . "\n\n");
				
				$connected = $this->connectOAuth($provider, $token, $pem_key, $encryption_key, $app_username, $app_tenant, 
					$arr['oauth_request_token'], 
					$arr['oauth_request_token_secret'], 
					null, 
					null);
					
				return $connected;
			}
		}
		
		return false;
	}
	
	/**
	 * Fetch OAuth tokens with the data provided to you in the SAML request
	 * 
	 * Federated applications can use OAuth for unattended access to IDS data. 
	 * (i.e. access data even if the user isn't logged in) Before you start 
	 * using this, you have to make sure Intuit onboards you for OAuth access.
	 * 
	 * @param string $provider					Your federated provider id (Intuit should have given you this)
	 * @param string $token						Your application token
	 * @param string $key						The full path to your .pem file (e.g. /path/to/file.pem)
	 * @param string $user						The username or user ID of the authenticating user
	 * @param string $tenant					The tenant ID of the authenticating user
	 * @param string $auth_id_pseudonym			The Auth ID Pseudonym extracted from the SAML message
	 * @param string $realm_id_pseudonym		The Realm ID Pseudonym extracted from the SAML message
	 * @return boolean
	 */
	public function connectOAuth($provider, $token, $pem_key, $encryption_key, $app_username, $app_tenant, $auth_id_pseudonym, $realm_id_pseudonym, $realm, $flavor)
	{
		if (!$this->_driver)
		{
			$this->_log('Could not connect to OAuth, no DRIVER storage instance.');
			return false;
		}
		
		$url = QuickBooks_IPP_Federator::URL_OAUTH;
		
		// First we need to push the request data into the OAuth storage
		$this->_driver->oauthRequestWrite(
			$app_username, 
			$app_tenant, 
			$auth_id_pseudonym, 
			$realm_id_pseudonym);
		
		$params = array(
			'xoauth_service_provider_id' => $provider,
			'xoauth_auth_id_pseudonym' => $auth_id_pseudonym, 
			'xoauth_realm_id_pseudonym' => $realm_id_pseudonym,
			);
		
		// Create our OAuth instance class
		$OAuth = new QuickBooks_IPP_OAuth(
			$token,		// The "consumer key" in this case is our application token 
			'');		// There is no consumer secret 
		
		$OAuth->signature(QuickBooks_IPP_OAuth::SIGNATURE_RSA, $pem_key);
		
		// Sign the request
		$sign = $OAuth->sign(QuickBooks_IPP_OAuth::METHOD_GET, $url, null, null, $params);
		
		// Now make our HTTP request to get the OAuth tokens 
		$HTTP = new QuickBooks_HTTP($sign[2]);
		
		$HTTP->useDebugMode($this->_debug);
		
		$data = $HTTP->GET();
		
		$this->_log('OAuth HTTP request: [' . $HTTP->lastRequest() . ']');
		$this->_log('OAuth HTTP response: [' . $HTTP->lastResponse() . ']');
		
		if ($data)
		{
			$tmp = array();
			parse_str($data, $tmp);
			
			if (!empty($tmp['oauth_token']) and 
				!empty($tmp['oauth_token_secret']))
			{
				// Store the OAuth tokens  
				
				$this->_log('Storing OAuth tokens...');
				
				return $this->_driver->oauthAccessWrite(
					$encryption_key, 
					$auth_id_pseudonym, 
					$tmp['oauth_token'], 
					$tmp['oauth_token_secret'], 
					$realm, 
					$flavor);
			}
		}
		
		return false;
	}
	
	protected function _handleSAML($SAML = null)
	{
		$this->_log('Starting up (initialized with ' . strlen($SAML) . ' bytes)');

		if ($this->_config['test_username'] and 
			$this->_config['test_password'])
		{
			$SAML = QUICKBOOKS_IPP_FEDERATOR_TEST_SAML;
			$private_key_data = QUICKBOOKS_IPP_FEDERATOR_TEST_KEY;
		}
		
		if (!$SAML)
		{
			if (!empty($_POST['SAMLResponse']))
			{
				$SAML = base64_decode($_POST['SAMLResponse']);
			}
			else
			{
				$msg = 'No SAML request in $_POST vars.';
				$this->_log($msg);
				$this->_setError(QuickBooks_IPP_Federator::ERROR_SAML, $msg);
				return false;
			}
		}
		
		if (strlen($SAML) > QUICKBOOKS_IPP_FEDERATOR_MAX_SAML_LENGTH)
		{
			$msg = 'SAML request seems unusually large, at ' . strlen($SAML) . ' bytes.';
			$this->_log($msg);
			$this->_setError(QuickBooks_IPP_Federator::ERROR_SAML, $msg);
			return false;
		}
		
		if ($this->_config['test_username'] and 
			$this->_config['test_password'])
		{
			; // Do nothing, we already fetched our private key data up there ^^^
		}
		else
		{
			$fp = fopen($this->_key, 'r');
			$private_key_data = fread($fp, 8192);
			fclose($fp);
		}
		
		// Decode the SAML request if it's base64 encoded
		if (false === strpos($SAML, '<'))
		{
			$SAML = base64_decode($SAML);
		}
		
		$this->_log('Incoming SAML request: ' . substr($SAML, 0, 128) . '...');
		$this->_log($SAML, QUICKBOOKS_LOG_DEBUG);
		
		//print("\n\n" . $SAML . "\n\n");
		// 
		$private_key = openssl_get_privatekey($private_key_data);
		//$public_key = openssl_get_publickey($__publicKey);
		
		$use_backend = QuickBooks_XML_Parser::BACKEND_BUILTIN;
		$Parser = new QuickBooks_XML_Parser($SAML, $use_backend);
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			$Root = $Doc->getRoot();
			
			$auth_id = $Root->getChildDataAt('samlp:Response saml:Assertion saml:Subject saml:NameID');
			$this->_log('Auth ID: [' . $auth_id . ']');
			
			if (!$auth_id)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract Auth ID from SAML response.');
				return false;
			}
			
			/*
			$AttributeStatement = $Root->getChildAt('samlp:Response saml:Assertion saml:AttributeStatement');
			
			foreach ($AttributeStatement->children() as $Node)
			{
				if ($Node->name() == 'saml:Attribute')
				{
					$Attribute = $Node;
					
					print_r($Attribute);
				}
			}
			exit;
			*/
			
			$encrypted_key = $Root->getChildDataAt('samlp:Response saml:Assertion saml:AttributeStatement saml:EncryptedAttribute xenc:EncryptedData ds:KeyInfo xenc:EncryptedKey xenc:CipherData xenc:CipherValue');
			$this->_log('Encrypted key: [' . $encrypted_key . ']');
			
			if (!$encrypted_key)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract encrypted key from SAML response.');
				return false;
			}
			
			$encrypted_ticket = $Root->getChildDataAt('samlp:Response saml:Assertion saml:AttributeStatement saml:EncryptedAttribute xenc:EncryptedData xenc:CipherData xenc:CipherValue');
			$this->_log('Encrypted ticket: [' . $encrypted_ticket . ']');

			if (!$encrypted_ticket)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract encrypted ticket from SAML response.');
				return false;
			}
			
			// Loop through the nodes, fetching the attributes from the SAML request
			$Node = $Root->getChildAt('samlp:Response saml:Assertion saml:AttributeStatement');
			
			$target_url = null;
			$realm_id_pseudonym = null;
			
			foreach ($Node->children() as $ChildNode)
			{
				if ($ChildNode->name() == 'saml:Attribute')
				{
					$Attribute = $ChildNode;
					
					if ($Attribute->getAttribute('Name') == 'targetUrl')
					{
						$ChildChildNode = $Attribute->getChild(0);
						$target_url = $ChildChildNode->data();
					}
					else if ($Attribute->getAttribute('Name') == 'Intuit.Federation.realmIDPseudonym')
					{
						$ChildChildNode = $Attribute->getChild(0);
						$realm_id_pseudonym = $ChildChildNode->data();
					}
				}
			}
			
			$this->_log('Target URL: [' . $target_url . ']');
			$this->_log('Realm ID Pseudonym: [' . $realm_id_pseudonym . ']');
			//exit;
			
			if (!$target_url)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract target URL from SAML response.');
				return false;
			}
			
			/*
			// Get the signatureValue
			$node = $xml->xpath('/samlp:Response/saml:Assertion/ds:Signature/ds:SignatureValue');
			$signatureValue = $node[0];
			
			# Get the signed node
			$signInfo = $xml->xpath('/samlp:Response/saml:Assertion/ds:Signature/ds:SignedInfo');
			*/
			
			// The key and ticket are base64 encoded, decode them
			$decoded_key = base64_decode($encrypted_key);
			$decoded_ticket = base64_decode($encrypted_ticket);
			
			// Decrypt the key
			$decrypted_key = null;
			$result = $this->_segfault_openssl_private_decrypt($decoded_key, $decrypted_key, $private_key_data);

			$this->_log('Key: [' . $decrypted_key . ']');

			if (!$decrypted_key)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract decrypted key from SAML response.');
				return false;
			}
			
			// @todo Swap out for QuickBooks_Encrypt implementation 
			// Get the key size for decryption
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			
			// $decoded_ticket is stored as: 
			//	16-byte IV  
			//		CONCAT WITH 
			// 	XX-byte actual encrypted ticket in XML format 
			
			// Get the IV
			$iv = substr($decoded_ticket, 0, $iv_size);
			
			// This is the actual encrypted ticket
			$cipher = substr($decoded_ticket, $iv_size);
			
			// @todo Swap out for QuickBooks_Encrypt implementation 
			// Decrypt the ticket
			$decrypted_ticket = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $decrypted_key, $cipher, MCRYPT_MODE_CBC, $iv); 
			
			// Remove the padding from the ticket
			$last_byte = substr($decrypted_ticket, -1, 1);
			$padding = -ord($last_byte);
			$decrypted_ticket = substr($decrypted_ticket, 0, $padding);
			
			$this->_log('Decrypted ticket is ' . strlen($decrypted_ticket) . ' bytes long...');
			$this->_log($decrypted_ticket, QUICKBOOKS_LOG_DEBUG);
			
			// Parse the XML format to get at the actual ticket value
			$ticket = null;
			$errnum = null;
			$errmsg = null;
			$use_backend = QuickBooks_XML_Parser::BACKEND_BUILTIN;
			$Parser = new QuickBooks_XML_Parser($decrypted_ticket, $use_backend);
			if ($Doc = $Parser->parse($errnum, $errmsg))
			{
				$Root = $Doc->getRoot();
				
				$ticket = $Root->getChildDataAt('Attribute saml:AttributeValue');
				$this->_log('Ticket: [' . $ticket . ']');
				
				// Check for test mode overrides
				if ($this->_config['test_username'] and 
					$this->_config['test_password'])
				{
					$username = $this->_config['test_username'];
					$password = $this->_config['test_password'];
					$token = 'blablabla';
					
					$test_replace = array(
						'{dbid}' => $this->_config['test_param_dbid'], 
						'{realm}' => $this->_config['test_param_realm'], 
						'{state}' => $this->_config['test_param_state'], 
						);
					
					$target_url = str_replace(array_keys($test_replace), array_values($test_replace), $this->_config['test_target']);
					
					// Grab a ticket
					$IPP = new QuickBooks_IPP();
					$Context = $IPP->authenticate($username, $password, $token);
					
					$ticket = $Context->ticket();
					
					$this->_log('TEST MODE [authid=' . $auth_id . ', ticket=' . $ticket . ', target_url=' . $target_url . ']');
				}
				
				return $this->_doCallback($auth_id, $ticket, $target_url, $realm_id_pseudonym);
			}
			else
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_XML, 'XML parser error while parsing SAML ticket: ' . $errnum . ':' . $errmsg);
				return false;
			}
		}
		else
		{
			$this->_setError(QuickBooks_IPP_Federator::ERROR_XML, 'XML parser error while parsing SAML response: ' . $errnum . ': ' . $errmsg);
			return false;
		}
	}
	
	protected function _doCallback($auth_id, $ticket, $target_url, $realm_id_pseudonym)
	{
		if ($this->_callback)
		{
			$err = '';
			
			$redirect = QuickBooks_Callbacks::callSAMLCallback(
				$this->_driver, 
				$this->_callback, 
				$auth_id, 
				$ticket, 
				$target_url, 
				$realm_id_pseudonym,
				$this->_config,
				$err);
			
			if ($err)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_CALLBACK, 'Callback said: ' . $err);
				return false;
			}
		}
		else
		{
			// Just set the cookie
			$cookie_expire = (int) $this->_config['cookie_expire'];
			$cookie_path = $this->_config['cookie_path'];
			$cookie_domain = $this->_config['cookie_domain'];
			$cookie_secure = (boolean) $this->_config['cookie_secure'];
			$cookie_httponly = (boolean) $this->_config['cookie_httponly'];
			
			//print('setting cookie: ' . print_r($this->_config, true));
			
			if (QuickBooks_IPP_Federator::setCookie($ticket, $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure, $cookie_httponly))
			{
				$redirect = true;
			}
			else
			{
				// Cookie failed to set for some reason
				$this->_setError(QuickBooks_IPP_Federator::ERROR_COOKIE, 'Could not set the IPP context cookie (did you make sure *not* to send any output yet?)');
				return false;
			}
		}
		
		if ($redirect)
		{
			$this->_doRedirect($target_url);
		}
		
		return true;
	}
	
	protected function _doRedirect($target_url)
	{
		$html = '<html><head><meta http-equiv="refresh" content="' . $this->_config['http_redirect_delay'] . ';url=' . htmlspecialchars($target_url) . '"></head><body></body></html>';
		print($html);
		return true;
	}
	
	/**
	 * 
	 *
	 */
	static public function setCookie($value, $expire = 0, $path = '/', $domain = '', $secure = null, $httponly = true)
	{
		if (is_null($secure))
		{
			$secure = (boolean) isset($_SERVER['HTTPS']);
		}
		
		//$secure = true;		// This is required per IPP security guidelines
		//$httponly = true;
		
		// P3P header to make Internet Exploder set cookies in iFrames
		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

		return setcookie(QuickBooks_IPP::COOKIE, $value, $expire, $path, $domain, $secure, $httponly);
	}
	
	/**
	 * 
	 *
	 */
	static public function getCookie()
	{
		if (isset($_COOKIE[QuickBooks_IPP::COOKIE]))
		{
			return $_COOKIE[QuickBooks_IPP::COOKIE];
		}
		
		return null;
	}
	
	protected function _segfault_openssl_private_decrypt($decoded_key, &$decrypted_key, $private_key_data)
	{
		if ($this->_config['segfault_openssl_private_decrypt'])
		{
			$filename = tempnam('/tmp', 'segfault_openssl_private_decrypt__');
			$fp = fopen($filename, 'w+');
			fwrite($fp, serialize(array( $decoded_key, $private_key_data )));
			fclose($fp);
			
			$command = $this->_config['segfault_openssl_private_decrypt'] . ' ' . $filename;
			
			$this->_log('Using segfault_openssl_private_decrypt work-around [' . $command . ']');
			
			$output = array();
			$return_var = null;
			exec($command, $output, $return_var);
			
			//print("\n\n\n\n-----------------\n");
			//print_r(implode(PHP_EOL, $output));
			//print("\n---------------------\n\n\n\n");
			
			$this->_log('The segfault_openssl_private_decrypt work-around returned [' . $return_var . ']');
			
			$decrypted_key = implode(PHP_EOL, $output);
			return true;
		}
		else
		{
			// Decrypt the key
			$decrypted_key = null;
			$result = openssl_private_decrypt($decoded_key, $decrypted_key, $private_key_data);
			return $result;
		}
	}
}
