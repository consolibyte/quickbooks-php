<?php

QuickBooks_Loader::load('/QuickBooks/Map.php');

QuickBooks_Loader::load('/QuickBooks/Driver/Factory.php');

class QuickBooks_Map_QBXML extends QuickBooks_Map
{
	protected $_driver;
	
	public function __construct($dsn_or_Driver, $driver_options = array())
	{
		if (is_object($dsn_or_Driver))
		{
			$this->_driver = $dsn_or_Driver;
		}
		else
		{
			$this->_driver = QuickBooks_Driver_Factory::create($dsn_or_Driver, $driver_options);
		}
	} 
	
	public function mark($mark_as, $object_or_action, $ID, $TxnID_or_ListID = null, $errnum = null, $errmsg = null)
	{
		$Driver = $this->_driver;
		
		$object = QuickBooks_Utilities::actionToObject($object_or_action);
			
		$table_and_field = array();
			
		// Convert to table and primary key, select qbsql id
		QuickBooks_SQL_Schema::mapPrimaryKey($object, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $table_and_field);  
			
		if (!empty($table_and_field[0]) and 
			!empty($table_and_field[1]))
		{
			switch ($mark_as)
			{
				case QuickBooks_Map::MARK_ADD:
					
					$arr = array();
					
					if ($TxnID_or_ListID)
					{
						$arr[$table_and_field[1]] = $TxnID_or_ListID;
					}
					
					if ($errnum)
					{
						$arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER] = $errnum;
						$arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_MESSAGE] = $errmsg;
					}
					
					$where = array(
						array( QUICKBOOKS_DRIVER_SQL_FIELD_ID => $ID ),
						);
						
					$Driver->update(
						QUICKBOOKS_DRIVER_SQL_PREFIX_SQL . $table_and_field[0], 
						$arr, 
						$where);
					
					break;
			}
		}
		
		return false;
	}
	
	public function flat($map, $object_or_action, $ID)
	{
		$Driver = $this->_driver;
		
		if ($map == QuickBooks_Map::MAP_QBXML)
		{
			$object = QuickBooks_Utilities::actionToObject($object_or_action);
			
			$table_and_field = array();
			
			// Convert to table and primary key, select qbsql id
			QuickBooks_SQL_Schema::mapPrimaryKey($object, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $table_and_field);  
			
			if (!empty($table_and_field[0]) and 
				!empty($table_and_field[1]))
			{
				$errnum = null;
				$errmsg = null;
				return $Driver->fetch($Driver->query("
					SELECT 
						* 
					FROM 
						" . QUICKBOOKS_DRIVER_SQL_PREFIX_SQL . $table_and_field[0] . "
					WHERE 
						" . QUICKBOOKS_DRIVER_SQL_FIELD_ID . " = " . (int) $ID, $errnum, $errmsg));
			}
		}
		
		return null;
	}
	
	public function adds($adds = array(), $mark_as_queued = true)
	{
		$Driver = $this->_driver;
		
		$NOW = date('Y-m-d H:i:s');
		
		$sql_add = $adds;
		
		$list = array();
		
		// Check if any objects need to be pushed back to QuickBooks 
		foreach ($sql_add as $action => $priority)
		{
			$object = QuickBooks_Utilities::actionToObject($action);
			
			$Driver->log('Action is: ' . $action . ', object is: ' . $object);
			
			$table_and_field = array();
			
			// Convert to table and primary key, select qbsql id
			QuickBooks_SQL_Schema::mapPrimaryKey($object, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $table_and_field);  
			
			$Driver->log('Searching table: ' . print_r($table_and_field, true) . ' for ADDED records.', null, QUICKBOOKS_LOG_DEBUG);
			
			//print_r($table_and_field);
			
			if (!empty($table_and_field[0]) and 
				!empty($table_and_field[1]))
			{
				// For ADDs
				// 	- Do not sync if to_skip = 1
				//	- Do not sync if to_delete = 1
				//	- Do not sync if last_errnum is not empty		@TODO Implement this
				
				$sql = "
					SELECT 
						" . QUICKBOOKS_DRIVER_SQL_FIELD_ID . ", 
						" . QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER . "
					FROM 
						" . QUICKBOOKS_DRIVER_SQL_PREFIX_SQL . $table_and_field[0] . " 
					WHERE 
						" . QUICKBOOKS_DRIVER_SQL_FIELD_MODIFY . " IS NOT NULL AND 
						" . QUICKBOOKS_DRIVER_SQL_FIELD_RESYNC . " IS NULL AND 
						" . QUICKBOOKS_DRIVER_SQL_FIELD_TO_SKIP . " != 1 AND 
						" . QUICKBOOKS_DRIVER_SQL_FIELD_TO_DELETE . " != 1 AND 
						" . QUICKBOOKS_DRIVER_SQL_FIELD_FLAG_DELETED . " != 1 AND 
						" . QUICKBOOKS_DRIVER_SQL_FIELD_MODIFY . " <= '" . $NOW . "' ";
				//		" . QUICKBOOKS_DRIVER_SQL_FLAG_TO_VOID . " != 1 ";
				
				$Driver->log($sql);
						
				$errnum = 0;
				$errmsg = '';
				$res = $Driver->query($sql, $errnum, $errmsg);
				while ($arr = $Driver->fetch($res))
				{
					if (strlen($arr[QUICKBOOKS_DRIVER_SQL_FIELD_ERROR_NUMBER]))
					{
						continue;
					}
					
					if (!isset($list[$action]))
					{
						$list[$action] = array();
					}
					
					$list[$action][$arr[QUICKBOOKS_DRIVER_SQL_FIELD_ID]] = $priority;
					
					if ($mark_as_queued)
					{
						// Make the record as having been ->enqueue()d
						$errnum = 0;
						$errmsg = '';
						$Driver->query("
							UPDATE 
								" . QUICKBOOKS_DRIVER_SQL_PREFIX_SQL . $table_and_field[0] . " 
							SET 
								" . QUICKBOOKS_DRIVER_SQL_FIELD_ENQUEUE_TIME . " = '" . date('Y-m-d H:i:s') . "'
							WHERE 
								" . QUICKBOOKS_DRIVER_SQL_FIELD_ID . " = " . $arr[QUICKBOOKS_DRIVER_SQL_FIELD_ID], $errnum, $errmsg);
					}
				}
			}
		}

		return $list;
	}

	public function mods($mods = array(), $mark_as_queued = true)
	{
		return array();
	}
	
	public function imports($imports = array())
	{
		return array();
	}
	
	public function queries($queries = array())
	{
		return array();
	}
}