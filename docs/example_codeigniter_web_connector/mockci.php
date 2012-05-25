<?php

/**
 * THIS FILE IS NOT RELEVANT TO WHATEVER IT IS YOU'RE TRYING TO DO! 
 * 
 * This is just a test harness we use for dev work. If you're looking for the 
 * CodeIgniter example, look at:
 * 	controllers/quickbooks.php
 * 	config/quickbooks.php
 * 
 * This file is not needed at all by you. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */


define('BASEPATH', dirname(__FILE__));

class Controller
{
	protected $load;
	protected $config;
	protected $db;
	
	protected function Controller()
	{
		$this->load = new Loader();
		$this->config = Config::instance();
		$this->db = new Database();
	}
	
	public function instance()
	{
		$CI = null;
		if (is_null($CI))
		{
			$CI = new Controller();
		}
		
		return $CI;
	}
}

class Loader
{
	public function config($file)
	{
		$Config = Config::instance();
		
		$config = array();
		require_once dirname(__FILE__) . '/config/' . $file . '.php';
		
		$Config->merge($config);
		
		return;
	}
}

class Config
{
	protected $_data;
	
	protected function __construct()
	{
		$this->_data = array();
	}
	
	static public function instance()
	{
		static $me = null;
		if (is_null($me))
		{
			$me = new Config();
		}
		
		return $me;
	}
	
	public function merge($data)
	{
		$this->_data = array_merge($this->_data, $data);
	}
	
	public function item($key)
	{
		return $this->_data[$key];
	}
}

class Database
{
	public $username;
	public $password;
	public $hostname;
	public $database;
	
	public function __construct()
	{
		$this->username = 'root';
		$this->password = 'root';
		$this->hostname = 'localhost';
		$this->database = 'citest';
	}
}
