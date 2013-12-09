<?php defined('SYSPATH') OR die('No direct access allowed.');


/**
 * THIS FILE IS NOT THE REAL BOOTSTRAPPER 
 * 
 * This file demonstrates a possible routing for your API
 * for instance, this route means you will redirect the api to
 * yourdomain.com/qbapi/
 * append a route to the bottom of your bootstrap
 * 
 * @author Jayson Lindsley <jay.lindsley@gmail.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

Route::set('qbapi', 'qbapi(<directory>(/<controller>(/<action>)))')
	->defaults(array(
		'directory' => 'qbapi',
		'controller' => 'quickbooks',
		'action' => 'index',
	));
	