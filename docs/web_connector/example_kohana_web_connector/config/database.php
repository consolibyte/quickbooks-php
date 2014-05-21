<?php defined('SYSPATH') OR die('No direct access allowed.');


/**
 * THIS FILE IS NOT THE REAL DATABASE.PHP 
 * 
 * This is a small snippet to demonstrate adding the
 * qb_data database to your kohana configuration file
 * 
 * @author Jayson Lindsley <jay.lindsley@gmail.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

return array
(
	'qb_data' => array
	(
		'type'       => 'mysql',
		'connection' => array(
			'hostname'   => 'localhost',
			'username'   => 'your_qbapi_username',
			'password'   => 'your_qbapi_password',
			'persistent' => FALSE,
			'database'   => 'qb_data',
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => FALSE,
	), 
);

?>