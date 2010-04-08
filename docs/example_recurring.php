<?php

/**
 * Example integration with an application
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Require the queueuing class
require_once 'QuickBooks.php';

// QuickBooks queueing class
$queue = new QuickBooks_Queue('mysql://root:password@localhost/your_database_name');

/*
 * What I want to happen is this:
 * 
 * Assuming the Web Connector is scheduled to run every 10 minutes, I want to 
 * make sure that once per every 24 hours we run a CustomerQuery to get new 
 * customers.
 * 
 * To make this happen, I'm going to register a recurring event. You only need 
 * to register this event *once* and it will automatically insert a 
 * CustomerQuery request into the queue every 24 hours for you from then on. 
 */ 

// Register the recurring event	
$queue->recurring('24 hours', 'CustomerQuery', 'get-new-customers');

// You can use other intervals too, these should all work as well:
// $queue->recurring(600, 'CustomerQuery', 'get-old-customers');		// 600 seconds (10 minutes)
// $queue->recurring('7 days', 'CustomerQuery', 'get-old-customers');	
// $queue->recurring('2 weeks', 'CustomerQuery', 'get-old-customers');
// 
?>