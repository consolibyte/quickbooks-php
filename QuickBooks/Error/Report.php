<?php

/**
 * 
 * 
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
class QuickBooks_Error_Report
{
	const MODE_QUEUE = 'queue';
	
	const MODE_MIRROR = 'mirror';
	
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
	public function &create($mode, $date_from = null, $date_to = null, $fetch_full_record = false, $restrict = array())
	{
		switch ($mode)
		{
			case QuickBooks_Error_Report::MODE_QUEUE:
				return $this->_createForQueue($date_from, $date_to, $fetch_full_record, $restrict);
			case QuickBooks_Error_Report::MODE_MIRROR:
				return $this->_createForMirror($date_from, $date_to, $fetch_full_record, $restrict);
			default:
				return false;
		}
	}
	
	protected function _createForQueue($date_from, $date_to, $fetch_full_record, $restrict)
	{
		
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected function &_createForMirror($date_from, $date_to, $fetch_full_record, $restrict)
	{
		$Driver = $this->_driver;
		
		$report = array();
		
		$do_restrict = count($restrict) > 0;
		
		foreach (QuickBooks_Utilities::listActions('*IMPORT*') as $action)
		{
			$object = QuickBooks_Utilities::actionToObject($action);
			
			if ($do_restrict and 
				!in_array($object, $restrict))
			{
				continue;
			}
			
			$pretty = $this->_prettyName($object);
			$report[$pretty] = array();
			
			QuickBooks_SQL_Schema::mapPrimaryKey($object, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $table_and_field);  
			
			if (!empty($table_and_field[0]) and 
				!empty($table_and_field[1]))
			{
				$sql = "
					SELECT 
						*
					FROM 
						" . QUICKBOOKS_DRIVER_SQL_PREFIX_SQL . $table_and_field[0] . " 
					WHERE 
						LENGTH(" . QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER . ") > 0 ";

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
					
					$report[$pretty][] = array(
						$arr[QUICKBOOKS_DRIVER_SQL_FIELD_ID], 
						$this->_fetchSomeField($arr, array( 'ListID', 'TxnID' )),  
						$this->_fetchSomeField($arr, array( 'FullName', 'Name', 'RefNumber' )),
						$this->_fetchSomeField($arr, array( 'TxnDate' )),  
						$this->_fetchSomeField($arr, array( 'Customer_FullName', 'Vendor_FullName' )),
						$arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER], 
						$arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_MESSAGE], 
						QuickBooks_Error_Report::describe($arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER], $arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_MESSAGE]), 
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
	
	public function HTML($mode, $date_from = null, $date_to = null, $fetch_full_record = false, $restrict = array(), $skip_empties = true)
	{
		$html = '';
		
		$report = $this->create($mode, $date_from, $date_to, $fetch_full_record, $restrict);
		
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
			$html .= '			<td>Error Details</td>' . QUICKBOOKS_CRLF;
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