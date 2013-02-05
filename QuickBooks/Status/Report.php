<?php

/**
 * 
 * 
 * Copyright (c) 2010-04-16 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <Keith@ConsoliBYTE.com>
 * 
 * @package QuickBooks
 * @subpackage Error
 */

// 
QuickBooks_Loader::load('/QuickBooks/Driver/Factory.php');

// 
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

// 
QuickBooks_Loader::load('/QuickBooks/SQL/Schema.php');

/**
 * 
 * 
 *
 */
class QuickBooks_Status_Report
{
	const MODE_QUEUE_ERRORS = 'queue-errors';
	
	const MODE_QUEUE_RECORDS = 'queue-records';
	
	const MODE_MIRROR_ERRORS = 'mirror-errors';
	
	const MODE_MIRROR_RECORDS = 'mirror-records';
	
	const STATUS_OK = 'OK';
	
	const STATUS_NOTICE = 'Notice';
	
	const STATUS_CAUTION = 'Caution';
	
	const STATUS_WARNING = 'Warning';
	
	const STATUS_DANGER = 'Danger';
	
	const STATUS_UNKNOWN = 'Unknown';
	
	protected $_driver;
	
	public function __construct($dsn, $config = array())
	{
		$this->_driver = QuickBooks_Driver_Factory::create($dsn, $config);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public function create($mode, $user = null, $date_from = null, $date_to = null, $fetch_full_record = false, $restrict = array())
	{
		$Driver = $this->_driver;
		
		if (!$user)
		{
			$user = $Driver->authDefault();
		}
		
		switch ($mode)
		{
			case QuickBooks_Status_Report::MODE_QUEUE_ERRORS:
			case QuickBooks_Status_Report::MODE_QUEUE_RECORDS:
				return $this->_createForQueue($mode, $user, $date_from, $date_to, $fetch_full_record, $restrict);
			case QuickBooks_Status_Report::MODE_MIRROR_ERRORS:
			case QuickBooks_Status_Report::MODE_MIRROR_RECORDS:	
				return $this->_createForMirror($mode, $user, $date_from, $date_to, $fetch_full_record, $restrict);
			default:
				return false;
		}
	}
	
	/**
	 * Get information about the status of a connection to QuickBooks
	 * 
	 * The returned array will look something like this:
	 * <pre>
	 * Array ( 
	 * 	[0] => danger 					// This is a constant, one of the QuickBooks_Status_Report::STATUS_* constants
	 * 	[1] => ERROR: A connection has not been made in 54 days, 1 hours and 46 minutes! Contact support to get this issue resolved! 
	 * 	[2] => 2010-03-19 12:26:41 		// This is the last time the given user logged in
	 * 	[3] => 2010-03-19 12:26:41 		// This is the last time the given user performed any action 
	 * )
	 * </pre>
	 * 
	 * @param string $user
	 * @param array $levels
	 * @return array			An array of status information 
	 */
	public function status($user = null, $levels = array())
	{
		$Driver = $this->_driver;
		
		if (!$user)
		{
			$user = $Driver->authDefault();
		}
		
		if (!count($levels))
		{
			$levels = array(
				60 * 60 * 12 => array( QuickBooks_Status_Report::STATUS_NOTICE, 'Notice: A connection has not been made in %d days, %d hours and %d minutes.' ),  
				60 * 60 * 24 => array( QuickBooks_Status_Report::STATUS_CAUTION, 'Caution: A connection has not been made in %d days, %d hours and %d minutes.' ),
				60 * 60 * 36 => array( QuickBooks_Status_Report::STATUS_WARNING, 'Warning! A connection has not been made in %d days, %d hours and %d minutes.' ),
				60 * 60 * 48 => array( QuickBooks_Status_Report::STATUS_DANGER, 'DANGER! A connection has not been made in %d days, %d hours and %d minutes! Contact support to get this issue resolved!' ),  
				);
		}
		
		if (!isset($levels[0]))
		{
			$levels[0] = array( QuickBooks_Status_Report::STATUS_OK, 'Status is OK. Last connection made %d days, %d hours, and %d minutes ago.' );
		}
		
		if (!isset($levels[-1]))
		{
			$levels[-1] = array( QuickBooks_Status_Report::STATUS_UNKNOWN, 'Status is unknown.');
		}
		
		//print_r($levels);
		
		// Find the status from the ticket table
		$last = $Driver->authLast($user);
		if (is_array($last))
		{
			krsort($levels);
			
			$ago = time() - strtotime($last[1]);
					
			$days = floor($ago / (60 * 60 * 24));
			$hours = floor(($ago - ($days * 60 * 60 * 24)) / 60.0 / 60.0);
			$minutes = max(1, floor(($ago - ($days * 60 * 60 * 24) - ($hours * 60 * 60)) / 60.0));
			
			$retr = null;
			
			foreach ($levels as $level => $tuple)
			{
				if ($level <= 0)
				{
					continue;
				}
				
				if ($ago > $level)
				{
					$retr = $tuple;
					break;
				}
			}
			
			if (!$retr)
			{
				$retr = $levels[0];
			}
			
			$retr[1] = sprintf($retr[1], $days, $hours, $minutes);
			
			$retr[] = $last[0];
			$retr[] = $last[1];
			
			return $retr;
		}
		
		return $levels[-1];
	}
	
	public function connection($type, $user = null)
	{
		
	}
	
	protected function &_createForQueue($mode, $user, $date_from, $date_to, $fetch_full_record, $restrict)
	{
		$Driver = $this->_driver;
		
		$report = array();
		
		$list = $Driver->queueReport($user, $date_from, $date_to);
		
		$statuses = array(
			QUICKBOOKS_STATUS_QUEUED => 'Queued', 
			QUICKBOOKS_STATUS_SUCCESS => 'Successfully processed', 
			QUICKBOOKS_STATUS_ERROR => 'Error', 
			QUICKBOOKS_STATUS_PROCESSING => 'Currently being processed', 
			QUICKBOOKS_STATUS_HANDLED => 'An error occurred, but the error was handled', 
			QUICKBOOKS_STATUS_CANCELLED => 'Cancelled', 
			QUICKBOOKS_STATUS_REMOVED => 'Removed from queue', 
			QUICKBOOKS_STATUS_NOOP => 'No operation occurred', 
			);

		foreach ($list as $key => $arr)
		{
			$errnum = '';
			$errmsg = '';
			if ($arr['msg'] and 
				$pos = strpos($arr['msg'], ':'))
			{
				$errnum = substr($arr['msg'], 0, $pos);
				$errmsg = substr($arr['msg'], $pos + 2);
			}
			else if ($arr['msg'])
			{
				$errnum = '?';
				$errmsg = $arr['msg'];
			}
			
			$record = array(
				$arr['quickbooks_queue_id'], 
				$arr['qb_action'], 
				$arr['ident'], 
				$arr['priority'], 
				$statuses[$arr['qb_status']], 
				$errnum, 
				$errmsg, 
				QuickBooks_Status_Report::describe($errnum, $errmsg),
				$arr['enqueue_datetime'], 
				$arr['dequeue_datetime'], 
				);
			
			$report[] = $record;
		}
		
		return $report;
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected function &_createForMirror($mode, $user, $date_from, $date_to, $fetch_full_record, $restrict)
	{
		$Driver = $this->_driver;
		
		$report = array();
		
		$do_restrict = count($restrict) > 0;
		
		$actions = QuickBooks_Utilities::listActions('*IMPORT*');
		//print_r($actions);
		//print_r($restrict);
		
		foreach ($actions as $action)
		{
			$object = QuickBooks_Utilities::actionToObject($action);
			
			//print('checking object [' . $object . ']' . "<br />");
			
			if ($do_restrict and 
				!in_array($object, $restrict))
			{
				continue;
			}
			
			//print('doing object: ' . $object . '<br />');
			
			$pretty = $this->_prettyName($object);
			$report[$pretty] = array();
			
			QuickBooks_SQL_Schema::mapPrimaryKey($object, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $table_and_field);  
			
			//print_r($table_and_field);
			
			if (!empty($table_and_field[0]) and 
				!empty($table_and_field[1]))
			{
				$sql = "
					SELECT 
						*
					FROM 
						" . QUICKBOOKS_DRIVER_SQL_PREFIX_SQL . $table_and_field[0] . " 
					WHERE ";
				
				if ($mode == QuickBooks_Status_Report::MODE_MIRROR_ERRORS)
				{
					$sql .= " LENGTH(" . QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER . ") > 0 ";
				}
				else
				{
					$sql .= " 1 ";
				}

				if ($timestamp = strtotime($date_from) and 
					$timestamp > 0)
				{
					$sql .= " AND TimeCreated >= '" . date('Y-m-d H:i:s', $timestamp) . "' ";
				}
				
				if ($timestamp = strtotime($date_to) and 
					$timestamp > 0)
				{
					$sql .= " AND TimeCreated <= '" . date('Y-m-d H:i:s', $timestamp) . "' ";
				}
				
				$sql .= " ORDER BY qbsql_id DESC ";
				
				//print($sql);
				
				$errnum = 0;
				$errmsg = '';
				$res = $Driver->query($sql, $errnum, $errmsg);
				while ($arr = $Driver->fetch($res))
				{
					$record = null;
					if ($fetch_full_record)
					{
						$record = $arr;
					}
					
					if ($arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER])
					{
						$details = QuickBooks_Status_Report::describe($arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER], $arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_MESSAGE]);
					}
					else if ($arr[QUICKBOOKS_DRIVER_SQL_FIELD_RESYNC] == $arr[QUICKBOOKS_DRIVER_SQL_FIELD_MODIFY])
					{
						$details = 'Synced successfully.';
					}
					else if ($arr[QUICKBOOKS_DRIVER_SQL_FIELD_MODIFY] > $arr[QUICKBOOKS_DRIVER_SQL_FIELD_RESYNC])
					{
						$details = 'Waiting to sync.';
					}
					
					$report[$pretty][] = array(
						$arr[QUICKBOOKS_DRIVER_SQL_FIELD_ID], 
						$this->_fetchSomeField($arr, array( 'ListID', 'TxnID' )),  
						$this->_fetchSomeField($arr, array( 'FullName', 'Name', 'RefNumber' )),
						$this->_fetchSomeField($arr, array( 'TxnDate' )),  
						$this->_fetchSomeField($arr, array( 'Customer_FullName', 'Vendor_FullName' )),
						$arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER], 
						$arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_MESSAGE], 
						$details, 
						$arr[QUICKBOOKS_DRIVER_SQL_FIELD_DEQUEUE_TIME], 
						$record,   
						);
				}
			}
		}
		
		return $report;
	}
	
	protected function _fetchSomeField($arr, $fields)
	{
		foreach ($fields as $field)
		{
			if (isset($arr[$field]))
			{
				return $arr[$field];
			}
		}
		
		return null;
	}
	
	/**
	 * 
	 * @todo This might be better suited to the Utilities class in case we want to use it somewhere else
	 */
	protected function _prettyName($constant)
	{
		//$constant = str_replace('Import', '', $constant);
		
		$strlen = strlen($constant);
		for ($i = 1; $i < $strlen; $i++)
		{
			if (strtoupper($constant[$i]) == $constant[$i])
			{
				$constant = substr($constant, 0, $i) . ' ' . substr($constant, $i);
				$i = $i + 2;
			}
		}
		
		return $constant;
	}
	
	public function HTML($mode, $user = null, $date_from = null, $date_to = null, $fetch_full_record = false, $restrict = array(), $skip_empties = true)
	{
		$report = $this->create($mode, $user, $date_from, $date_to, $fetch_full_record, $restrict);
		
		switch ($mode)
		{
			case QuickBooks_Status_Report::MODE_MIRROR_RECORDS:
			case QuickBooks_Status_Report::MODE_MIRROR_ERRORS:	
				return $this->_htmlForMirror($report, $skip_empties);
			case QuickBooks_Status_Report::MODE_QUEUE_RECORDS:
			case QuickBooks_Status_Report::MODE_QUEUE_ERRORS:
				return $this->_htmlForQueue($report);
			default:
				return '';
		}
	}
	
	protected function _htmlForQueue($report)
	{
		$html = '';
		
		$html .= '<table>' . QUICKBOOKS_CRLF;
		$html .= '	<thead>' . QUICKBOOKS_CRLF;
		$html .= '		<tr>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Queue ID</td>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Action</td>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Record ID</td>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Priority</td>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Status</td>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Error Number</td>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Error Message</td>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Status Details</td>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Queued</td>' . QUICKBOOKS_CRLF;
		$html .= '			<td>Processed</td>' . QUICKBOOKS_CRLF;
		$html .= '		</tr>' . QUICKBOOKS_CRLF;
		$html .= '	</thead>' . QUICKBOOKS_CRLF;
		$html .= '	</tbody>' . QUICKBOOKS_CRLF;
			
		foreach ($report as $record)
		{
			$html .= '		<tr>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[0] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[1] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[2] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[3] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[4] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[5] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[6] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[7] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[8] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>' . $record[9] . '</td>' . QUICKBOOKS_CRLF;
			$html .= '		</tr>' . QUICKBOOKS_CRLF;
		}
			
		$html .= '	</tbody>' . QUICKBOOKS_CRLF;
		$html .= '</table>' . QUICKBOOKS_CRLF;
		
		return $html;
	}
	
	protected function _htmlForMirror($report, $skip_empties)
	{
		$html = '';
		
		foreach ($report as $type => $records)
		{
			if ($skip_empties and 
				!count($records))
			{
				continue;	
			}
			
			$html .= '<table>' . QUICKBOOKS_CRLF;
			$html .= '	<thead>' . QUICKBOOKS_CRLF;
			$html .= '		<tr>' . QUICKBOOKS_CRLF;
			$html .= '			<td colspan="9">' . $type . '</td>' . QUICKBOOKS_CRLF;
			$html .= '		</tr>' . QUICKBOOKS_CRLF;
			$html .= '		<tr>' . QUICKBOOKS_CRLF;
			$html .= '			<td>SQL ID</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>ListID or TxnID</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>Name or RefNumber</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>Transaction Date</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>Entity Name</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>Error Number</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>Error Message</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>Status Details</td>' . QUICKBOOKS_CRLF;
			$html .= '			<td>Date/Time</td>' . QUICKBOOKS_CRLF;
			$html .= '		</tr>' . QUICKBOOKS_CRLF;
			$html .= '	</thead>' . QUICKBOOKS_CRLF;
			$html .= '	</tbody>' . QUICKBOOKS_CRLF;
			
			foreach ($records as $record)
			{
				$html .= '		<tr>' . QUICKBOOKS_CRLF;
				$html .= '			<td>' . $record[0] . '</td>' . QUICKBOOKS_CRLF;
				$html .= '			<td>' . $record[1] . '</td>' . QUICKBOOKS_CRLF;
				$html .= '			<td>' . $record[2] . '</td>' . QUICKBOOKS_CRLF;
				$html .= '			<td>' . $record[3] . '</td>' . QUICKBOOKS_CRLF;
				$html .= '			<td>' . $record[4] . '</td>' . QUICKBOOKS_CRLF;
				$html .= '			<td>' . $record[5] . '</td>' . QUICKBOOKS_CRLF;
				$html .= '			<td>' . $record[6] . '</td>' . QUICKBOOKS_CRLF;
				$html .= '			<td>' . $record[7] . '</td>' . QUICKBOOKS_CRLF;
				$html .= '			<td>' . $record[8] . '</td>' . QUICKBOOKS_CRLF;
				$html .= '		</tr>' . QUICKBOOKS_CRLF;
			}
			
			$html .= '	</tbody>' . QUICKBOOKS_CRLF;
			$html .= '</table>' . QUICKBOOKS_CRLF;
			$html .= '<br />' . QUICKBOOKS_CRLF;
		}
		
		return $html;
	}
	
	public function XML($mode, $date_from = null, $date_to = null, $fetch_full_record = false, $restrict = array())
	{
		
	}
	
	/**
	 * 
	 * 
	 * @todo Make this better for error codes that get thrown for more than one different type of error.
	 * 
	 */
	static public function describe($errcode, $errmsg)
	{
		static $errs = array(
			3100 => array(
				'*' => 'QuickBooks "Name" fields must be unique across all Customers, Vendors, Employees, and Other Names. Is there another Customer, Vendor, Employee, or Other Name with the same name as this record?', 
				), 
			);
		
		if (isset($errs[$errcode]))
		{
			return $errs[$errcode]['*'];
		}
		
		return '';
	}
}