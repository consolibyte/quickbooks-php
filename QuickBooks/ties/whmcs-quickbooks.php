<?php

/**
 * WHMCS + QuickBooks
 * 
 * @author ConsoliBYTE, LLC <support@ConsoliBYTE.com>
 * @link http://www.consolibyte.com/
 */

/**
 * WHMCS + QuickBooks
 */
class whmcs_quickbooks
{
	protected $_db_host;
	protected $_db_user;
	protected $_db_pass;
	protected $_db_name;
	protected $_db_prefix;
	
	protected $_db_conn;

	
	protected $_table_avail = array(
		'accounts',
		//'activitylog',
		'addons',
		//'adminlog',
		//'adminperms',
		//'adminroles',
		//'admins',
		//'adminsecurityquestions',
		'affiliates',
		'affiliatesaccounts',
		'affiliateshistory',
		'affiliatespending',
		'affiliateswithdrawals',
		'announcements',
		//'bannedemails',
		//'bannedips',
		'billableitems',
		'browserlinks',
		'calendar',
		'cancelrequests',
		'clientgroups',
		'clients',
		'clientsfiles',
		//'configuration',
		'contacts',
		'credit',
		'currencies',
		'customfields',
		'customfieldsvalues',
		'domainpricing',
		'domains',
		'domainsadditionalfields',
		'downloadcats',
		'downloads',
		'emails',
		'emailtemplates',
		//'fraud',
		//'gatewaylog',
		'hosting',
		'hostingaddons',
		'hostingconfigoptions',
		'invoiceitems',
		'invoices',
		'knowledgebase',
		'knowledgebasecats',
		'knowledgebaselinks',
		'links',
		'networkissues',
		'notes',
		'orders',
		'paymentgateways',
		'pricing',
		'productconfiggroups',
		'productconfiglinks',
		'productconfigoptions',
		'productconfigoptionssub',
		'productgroups',
		'products',
		'promotions',
		'quoteitems',
		'quotes',
		'registrars',
		'servergroups',
		'servergroupsrel',
		'servers',
		'sslorders',
		'tax',
		//'ticketbreaklines',
		//'ticketdepartments',
		//'ticketescalations',
		//'ticketlog',
		//'ticketmaillog',
		//'ticketnotes',
		//'ticketpredefinedcats',
		//'ticketpredefinedreplies',
		//'ticketreplies',
		//'tickets',
		//'ticketspamfilters',
		//'ticketstatuses',
		//'todolist',
		'upgrades',
		//'whoislog',	
		);
	
	protected $_field_strip = array(
		'password' => '', 
		'securityqans' => '', 
		'cardnum' => '', 
		'startdate' => '', 
		'expdate' => '', 
		'issuenumber' => '',
		'pwresetkey' => '', 
		'pwresetexpiry' => '', 
		);
	
	protected $_api_cryptkey;
	protected $_api_debug;
	
	public function __construct()
	{
		
	}
	
	public function start()
	{
		header('Content-Type: text/plain');
		
		require_once 'configuration.php';
		
		$this->_db_host = $db_host;
		$this->_db_user = $db_username;
		$this->_db_pass = $db_password;
		$this->_db_name = $db_name;
		$this->_db_prefix = 'tbl';
		
		$this->_api_cryptkey = '';
		if (!empty($api_encryption_hash))
		{
			$this->_api_cryptkey = $api_encryption_hash;
		}
		
		$this->_api_debug = false;
		if (!empty($api_allow_debug))
		{
			$this->_api_debug = (boolean) $api_allow_debug;
		}
		
		$this->_connect();
		
		if (!empty($_REQUEST['action']) and 
			!empty($_REQUEST['username']) and 
			!empty($_REQUEST['password']))
		{
			$whmcs_action = $_REQUEST['action'];
			$whmcs_username = $_REQUEST['username'];
			$whmcs_password = $_REQUEST['password'];
			
			// Check if the remote IP address is banned
			$sql = "SELECT * FROM " . $this->_db_prefix . "bannedips WHERE ip = '" . $this->_escape($_SERVER['REMOTE_ADDR']) . "' ";
			$arr = $this->_fetch($this->_query($sql));
			
			if (!$arr)
			{
				$sql = "SELECT * FROM " . $this->_db_prefix . "configuration WHERE setting = 'APIAllowedIPs'";
				$arr = $this->_fetch($this->_query($sql));
				
				$ipaddrs = explode("\n", $arr['value']);
				
				$ipcheck = false;
				foreach ($ipaddrs as $ipaddr)
				{
					if (trim($ipaddr) == $_SERVER['REMOTE_ADDR'])
					{
						$ipcheck = true;
						break;
					}
				}
				
				if ($ipcheck)
				{
					$usercheck = false;
					
					$sql = "SELECT * FROM " . $this->_db_prefix . "admins ";
					$res = $this->_query($sql);
					while ($arr = $this->_fetch($res))
					{
						if (md5($arr['username']) == $whmcs_username and 
							$arr['password'] == $whmcs_password)
						{
							$usercheck = true;
							break;
						}
					}
					
					if ($usercheck)
					{
						$response = null;
						$err = null;
						
						switch ($whmcs_action)
						{
							case 'table':
								$response = $this->_actionTable($err);
								break;
							default:
								break;
						}
						
						if (!$err)
						{
							return $this->_response(true, 'Success!', $response);
						}
						else
						{
							$msg = 'Action error: ' . $err;
						}
					}
					else
					{
						$msg = 'Invalid username or password.';
					}
				}
				else
				{
					$msg = 'Invalid IP address: ' . $_SERVER['REMOTE_ADDR'];
				}
			}
			else
			{
				$msg = 'Banned IP address: ' . $_SERVER['REMOTE_ADDR'];
			}
		}
		else
		{
			$msg = 'No action/username/password provided.';
		}
			
		return $this->_response(false, $msg);
	}
	
	protected function _actionTable(&$err)
	{
		if (!empty($_REQUEST['table']) and 
			isset($_REQUEST['offset']))
		{
			$whmcs_table = $_REQUEST['table'];
			$whmcs_offset = (int) $_REQUEST['offset'];
			
			if (in_array($whmcs_table, $this->_table_avail))
			{
				$list = array();
				
				$res = $this->_query("SELECT * FROM " . $this->_escape($this->_db_prefix . $whmcs_table) . " WHERE id > " . $whmcs_offset);
				while ($arr = $this->_fetch($res))
				{
					$list[] = array_merge($arr, $this->_field_strip);
				}
				
				return $list;
			}
			else
			{
				$err = 'Table is not in allowed list.';
			}
		}
		else
		{
			$err = 'No table/offset specified.';
		}
	}
	
	protected function _response($status, $message, $response = null)
	{
		$fields = array();
		$data = array();
		$count = 0;
		
		if (count($response))
		{
			$fields = array_keys($response[0]);
			$count = count($response);
			
			for ($i = 0; $i < $count; $i++)
			{
				$data[] = array_values($response[$i]);
			}
		}
		
		$output = array( 'status' => $status, 'message' => $message, 'count' => count($data), 'fields' => $fields, 'data' => $data );
		
		if (!empty($_REQUEST['_debug']) and 
			$this->_api_debug == true)
		{
			print_r($output);
			exit;
		}
		else
		{
			$serialized = serialize($output);
			
			if ($this->_api_cryptkey)
			{
				$serialized = base64_encode($this->_encrypt($this->_api_cryptkey, $serialized));
			}
			
			print($serialized);
			exit;
		}
	}
	
	protected function _connect()
	{
		$this->_db_conn = mysql_connect($this->_db_host, $this->_db_user, $this->_db_pass, true);
		mysql_select_db($this->_db_name, $this->_db_conn);
	}
	
	protected function _query($sql)
	{
		return mysql_query($sql, $this->_db_conn);
	}
	
	protected function _fetch($res)
	{
		return mysql_fetch_array($res, MYSQL_ASSOC);
	}
	
	protected function _escape($str)
	{
		return mysql_real_escape_string($str, $this->_db_conn);
	}
	
	protected function _encrypt($pwd, $data, $ispwdhex = 0)
	{
		if ($ispwdhex)
		{
			$pwd = @pack('H*', $pwd); 
		}
		
		$key[] = '';
		$box[] = '';
		$cipher = '';

		$pwd_length = strlen($pwd);
		$data_length = strlen($data);

		for ($i = 0; $i < 256; $i++)
		{
			$key[$i] = ord($pwd[$i % $pwd_length]);
			$box[$i] = $i;
		}
		
		for ($j = $i = 0; $i < 256; $i++)
		{
			$j = ($j + $box[$i] + $key[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		
		for ($a = $j = $i = 0; $i < $data_length; $i++)
		{
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$k = $box[(($box[$a] + $box[$j]) % 256)];
			$cipher .= chr(ord($data[$i]) ^ $k);
		}
		
		return $cipher;
	}
	
	protected function _decrypt($pwd, $data, $ispwdhex = 0)
	{
		return $this->_encrypt($pwd, $data, $ispwdhex);
	}	
}

$tie = new whmcs_quickbooks();
$tie->start();


