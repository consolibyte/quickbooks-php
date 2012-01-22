<?php

/**
 * QuickBooks .QWC file generation class
 * 
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
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

/**
 * QuickBooks .QWC file generation
 * 
 * 
 */
class QuickBooks_WebConnector_QWC
{
	protected $_name;
	protected $_descrip;
	protected $_appurl;
	protected $_appsupport;
	protected $_username;
	protected $_fileid;
	protected $_ownerid;
	protected $_qbtype;
	protected $_readonly;
	protected $_run_every_n_seconds;
	protected $_personaldata;
	protected $_unattendedmode;
	protected $_authflags;
	protected $_notify;
	protected $_appdisplayname;
	protected $_appuniquename;
	protected $_appid;
	
	const SUPPORTED_DEFAULT = '';
	const SUPPORTED_ALL = '0x0';
	const SUPPORTED_SIMPLESTART = '0x1'; 
	const SUPPORTED_PRO = '0x2'; 
	const SUPPORTED_PREMIER = '0x4'; 
	const SUPPORTED_ENTERPRISE = '0x8';

	const PERSONALDATA_DEFAULT = '';
	const PERSONALDATA_NOTNEEDED = 'pdpNotNeeded';
	const PERSONALDATA_OPTIONAL = 'pdpOptional';
	const PERSONALDATA_REQUIRED = 'pdpRequired';

	const UNATTENDEDMODE_DEFAULT = '';
	const UNATTENDEDMODE_REQUIRED = 'umpRequired';
	const UNATTENDEDMODE_OPTIONAL = 'umpOptional';
	
	/**
	 * Generate a valid QuickBooks Web Connector *.QWC file 
	 * 
	 * @param string $name			The name of the QuickBooks Web Connector job (something descriptive, this gets displayed to the end-user)
	 * @param string $descrip		A short description of the QuickBooks Web Connector job (something descriptive, this gets displayed to the end-user)
	 * @param string $appurl		The absolute URL to the SOAP server (this *MUST* be a HTTPS:// link *UNLESS* it's running on localhost)
	 * @param string $appsupport	A URL where an end-user can go to get support for the application
	 * @param string $username		The username that QuickBooks Web Connector should use to connect
	 * @param string $fileid		A file-ID value... apparently you can just make this up, make it resemble this string: {57F3B9B6-86F1-4fcc-B1FF-966DE1813D20}
	 * @param string $ownerid		As above, apparently you can just make this up, make it resemble this string: {57F3B9B6-86F1-4fcc-B1FF-966DE1813D20}
	 * @param string $qbtype		Either QUICKBOOKS_TYPE_QBFS or QUICKBOOKS_TYPE_QBPOS
	 * @param boolean $readonly		Whether or not to open the connection as read-only
	 * @param integer $run_every_n_seconds		If you want to schedule the job to run every once in a while automatically, you can pass in a number of seconds between runs here
	 * @param string $personaldata	
	 * @param string $unattendedmode
	 * @param string $authflags
	 * @param boolean $notify
	 * @param string $appdisplayname
	 * @param string $appuniquename
	 * @param string $appid
	 * @return string
	 */
	public function __construct(
		$name, 
		$descrip, 
		$appurl, 
		$appsupport, 
		$username, 
		$fileid, 
		$ownerid, 
		$qbtype = QUICKBOOKS_TYPE_QBFS, 
		$readonly = false, 
		$run_every_n_seconds = null, 
		$personaldata = QuickBooks_WebConnector_QWC::PERSONALDATA_DEFAULT, 
		$unattendedmode = QuickBooks_WebConnector_QWC::UNATTENDEDMODE_DEFAULT, 
		$authflags = QuickBooks_WebConnector_QWC::SUPPORTED_DEFAULT, 
		$notify = false, 
		$appdisplayname = '', 
		$appuniquename = '', 
		$appid = '')
	{
		$this->_name = $name;
		$this->_descrip = $descrip;
		$this->_appurl = $appurl;
		$this->_appsupport = $appsupport;
		$this->_username = $username;
		$this->_fileid = $fileid;
		$this->_ownerid = $ownerid; 
		$this->_qbtype = $qbtype;
		$this->_readonly = $readonly;
		$this->_run_every_n_seconds = $run_every_n_seconds;
		$this->_personaldata = $personaldata;
		$this->_unattendedmode = $unattendedmode;
		$this->_authflags = $authflags;
		$this->_notify = $notify;
		$this->_appdisplayname = $appdisplayname;
		$this->_appuniquename = $appuniquename;
		$this->_appid = $appid;
	}
	
	public function http($filename = 'quickbooks.qwc')
	{
		header('Content-type: text/xml');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		print($this->generate());
		return true;
	}
	
	public function save($where)
	{
		
	}

	/**
	 * 
	 * 
	 * @return string
	 */
	public function generate()
	{
		$name = $this->_name;
		$descrip = $this->_descrip;
		$appurl = $this->_appurl;
		$appsupport = $this->_appsupport;
		$username = $this->_username;
		$fileid = $this->_fileid;
		$ownerid = $this->_ownerid; 
		$qbtype = $this->_qbtype;
		$readonly = $this->_readonly;
		$run_every_n_seconds = $this->_run_every_n_seconds;
		$personaldata = $this->_personaldata;
		$unattendedmode = $this->_unattendedmode;
		$authflags = $this->_authflags;
		$notify = $this->_notify;
		$appdisplayname = $this->_appdisplayname;
		$appuniquename = $this->_appuniquename;
		$appid = $this->_appid;	
	
		/*
		AppDisplayName
		AppUniqueName
		AuthFlags
			- 0x0 (all, default)
			- 0x0 (All, default) 
			- 0x1 (SupportQBSimpleStart) 
			- 0x2 (SupportQBPro) 
			- 0x4 (SupportQBPremier) 
			- 0x8 (SupportQBEnterprise)
		Notify			true or false
		PersonalDataPref
			- pdpNotNeeded
			- pdpOptional
			- pdpRequired
		Style	(do not support, package only supports default style)
		UnattendedModePref
			- umpRequired
			- umpOptional
		CertURL
		*/ 
		
		if ($run_every_n_seconds and 
			!is_numeric($run_every_n_seconds))
		{
			$run_every_n_seconds = QuickBooks_Utilities::intervalToSeconds($run_every_n_seconds);
		}
			
		$ownerid = '{' . trim($ownerid, '{}') . '}';
		$fileid = '{' . trim($fileid, '{}') . '}';
			
		$xml = '';
		
		$xml .= '<?xml version="1.0"?>' . QUICKBOOKS_CRLF;
		$xml .= '<QBWCXML>' . QUICKBOOKS_CRLF;
		$xml .= "\t" . '<AppName>' . htmlspecialchars($name) . '</AppName>' . QUICKBOOKS_CRLF;
		$xml .= "\t" . '<AppID>' . htmlspecialchars($appid) . '</AppID>' . QUICKBOOKS_CRLF;
		$xml .= "\t" . '<AppURL>' . htmlspecialchars($appurl) . '</AppURL>' . QUICKBOOKS_CRLF;
		$xml .= "\t" . '<AppDescription>' . htmlspecialchars($descrip) . '</AppDescription>' . QUICKBOOKS_CRLF;
		$xml .= "\t" . '<AppSupport>' . htmlspecialchars($appsupport) . '</AppSupport>' . QUICKBOOKS_CRLF;
		$xml .= "\t" . '<UserName>' . htmlspecialchars($username) . '</UserName>' . QUICKBOOKS_CRLF;
		$xml .= "\t" . '<OwnerID>' . $ownerid . '</OwnerID>' . QUICKBOOKS_CRLF;
		$xml .= "\t" . '<FileID>' . $fileid . '</FileID>' . QUICKBOOKS_CRLF;
		$xml .= "\t" . '<QBType>' . $qbtype . '</QBType>' . QUICKBOOKS_CRLF;
			
		if ($personaldata != QuickBooks_WebConnector_QWC::PERSONALDATA_DEFAULT)
		{
			$xml .= "\t" . '<PersonalDataPref>' . $personaldata . '</PersonalDataPref>' . QUICKBOOKS_CRLF;
		}
			
		if ($unattendedmode != QuickBooks_WebConnector_QWC::UNATTENDEDMODE_DEFAULT)
		{
			$xml .= "\t" . '<UnattendedModePref>' . $unattendedmode . '</UnattendedModePref>' . QUICKBOOKS_CRLF;
		}
			
		if ($authflags != QuickBooks_WebConnector_QWC::SUPPORTED_DEFAULT)
		{
			$xml .= "\t" . '<AuthFlags>' . $authflags . '</AuthFlags>' . QUICKBOOKS_CRLF;
		}
			
		if ($notify)
		{
			$xml .= "\t" . '<Notify>true</Notify>' . QUICKBOOKS_CRLF;
		}
		else
		{
			$xml .= "\t" . '<Notify>false</Notify>' . QUICKBOOKS_CRLF;
		}
			
		if ($appdisplayname)
		{
			$xml .= "\t" . '<AppDisplayName>' . $appdisplayname . '</AppDisplayName>' . QUICKBOOKS_CRLF;
		}
			
		if ($appuniquename)
		{
			$xml .= "\t" . '<AppUniqueName>' . $appuniquename . '</AppUniqueName>' . QUICKBOOKS_CRLF;
		}
			
		if ((int) $run_every_n_seconds > 0 and (int) $run_every_n_seconds < 60)
		{
			$xml .= "\t" . '<Scheduler>' . QUICKBOOKS_CRLF;
			$xml .= "\t" . "\t" . '<RunEveryNSeconds>' . (int) $run_every_n_seconds . '</RunEveryNSeconds>' . QUICKBOOKS_CRLF;
			$xml .= "\t" . '</Scheduler>' . QUICKBOOKS_CRLF;
		}
		else if ((int) $run_every_n_seconds >= 60)
		{
			$xml .= "\t" . '<Scheduler>' . QUICKBOOKS_CRLF;
			$xml .= "\t" . "\t" . '<RunEveryNMinutes>' . floor($run_every_n_seconds / 60) . '</RunEveryNMinutes>' . QUICKBOOKS_CRLF;
			$xml .= "\t" . '</Scheduler>' . QUICKBOOKS_CRLF;
		}
			
		if ($readonly)
		{
			$xml .= "\t" . '<IsReadOnly>true</IsReadOnly>' . QUICKBOOKS_CRLF;
		}
		else
		{
			$xml .= "\t" . '<IsReadOnly>false</IsReadOnly>' . QUICKBOOKS_CRLF;
		}
			
		$xml .= '</QBWCXML>';
			
		return trim($xml);				
	}
	
	/**
	 * Alias of QuickBooks_QWC::generate()
	 */
	public function __toString()
	{
		return $this->generate();
	}
		
	/**
	 * Generate a random File ID string
	 * 
	 * *** WARNING *** I have no idea if it is OK or not to do it like this... do you know? E-mail me! 
	 * 
	 * @param boolean $surround
	 * @return string
	 */
	static public function fileID($surround = true)
	{
		return QuickBooks_WebConnector_QWC::_guid($surround);
	}
	
	/**
	 * Generate a random GUID string
	 * 
	 * @param boolean $surround
	 * @return string
	 */
	static public function GUID($surround = true)
	{
		return QuickBooks_WebConnector_QWC::_guid($surround);
	}
	
	/**
	 * Generate a GUID
	 * 
	 * Note: This is used for tickets too, so it *must* be a RANDOM GUID!
	 * 
	 * @param boolean $surround
	 * @return string
	 */
	static protected function _guid($surround = true)
	{
		$guid = sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
			mt_rand(0, 65535), mt_rand(0, 65535), 
			mt_rand(0, 65535), 
			mt_rand(0, 4095),  
			bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)
			);  	
		if ($surround)
		{
			$guid = '{' . $guid . '}';
		}
			
		return $guid;	
	}
	
	/**
	 * Generate a random Owner ID string
	 * 
	 * *** WARNING *** I have no idea if it is OK or not to do it like this... do you know? E-mail me! 
	 * 
	 * @param boolean $surround
	 * @return string
	 */
	static public function ownerID($surround = true)
	{
		return QuickBooks_WebConnector_QWC::_guid($surround);
	}
	
}
