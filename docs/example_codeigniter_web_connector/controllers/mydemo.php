<?php

/**
 * Example CodeIgniter QuickBooks Web Connector integration
 * 
 * This is a tiny pretend application which throws something into the queue so 
 * that the Web Connector can process it. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

/**
 * Example CodeIgniter controller for QuickBooks Web Connector integrations
 */
class MyDemo extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		// QuickBooks config
		$this->load->config('quickbooks');
		
		// Load the QuickBooks model
		$this->load->model('quickbooks');
		
		// Configure the model
		$this->quickbooks->dsn('mysql://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/' . $this->db->database);
		
		// Load your other models here... 
		//$this->load->model('yourmodel1');
		//$this->load->model('yourmodel2');
		//$this->load->model('yourmodel3');
	}
	
	public function show_form()
	{
		// Show a form here which collects someone's name and e-mail address
		
		// $this->load->view('some_view_here');
	}
	
	public function do_something()
	{
		// Do something to store the form data here
		// 
		// $data = array(
		// 	'name' => $this->input->post('name'),
		//	'email' => $this->input->post('email'), 
		// 	);
		// 
		// $this->db->insert('your_table', $data);
		// $your_customer_id = $this->db->insert_id();
		
		$this->quickbooks->enqueue(QUICKBOOKS_ADD_CUSTOMER, $your_customer_id);
		
		// $this->load->view('some_other_view');
	}
}