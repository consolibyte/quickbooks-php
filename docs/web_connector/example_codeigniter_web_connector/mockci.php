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

class CI_Controller
{
	protected $load;
 
	protected $config;
 
	protected $db;
	
	public function __construct()
	{
		$this->load = new Loader($this);
		$this->config = Config::instance();
		$this->db = new Database();
	}
	
	static public function instance()
	{
		return new CI_Controller();
	}
	
	public function model($name, $Model)
	{
		$this->$name = $Model;
	}
}

class CI_Model
{
}

class Loader
{
	protected $_controller;
	
	public function __construct($Controller)
	{
		$this->_controller = $Controller;
	}
	
	public function config(string $file)
	{
		$Config = Config::instance();
		
		$config = array();
		require_once dirname(__FILE__) . '/config/' . $file . '.php';
		
		$Config->merge($config);
	}
	
	public function model($model)
	{
		require_once dirname(__FILE__) . '/models/' . $model . '.php';
		
		$var = $model . '_model';
		$Model = new $var();
		
		$this->_controller->model($model, $Model);
	}
}

class Config
{
	protected $_data = array();
	
	protected function __construct()
 {
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
	public $username = 'root';
 
	public $password = 'root';
 
	public $hostname = 'localhost';
 
	public $database = 'citest';
}
