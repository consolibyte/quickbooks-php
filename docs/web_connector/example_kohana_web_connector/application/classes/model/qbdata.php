<?php defined('SYSPATH') or die('No direct script access.');

/**
 * QuickBooks Kohana Integration Example
 *
 * This sample will let you link up to the qb_data database
 * 
 * See model folder for example of how to move methods out of this
 * 
 * @author Jayson Lindsley <jay.lindsley@gmail.com>
 * 
 */
class Model_Qbdata extends ORM {

	public function __construct()
	{
		//link up this model to our qb_data database
		$this->_db = Database::instance('qb_data');
	}

	/* 
	 * Gets all Quickbooks errors from the database and returns the array to the caller
	 *
	 */
	public function GetErrors() { 
		//Build the query and condition
		$query = DB::select('quickbooks_queue_id', 'ident','qb_action','qbxml','msg','enqueue_datetime')->from('quickbooks_queue')->where('msg','!=',"");
		//Query against the models database
		$errorset = $this->_db->query(Database::SELECT, $query, FALSE)->as_array();
		//Go through the errors if you want to find some relevant data
		$errorset = Model_Qbdata::FetchDetails($errorset);
		//echo Debug::vars($errorset);
		return $errorset;
	}

	/* 
	 * Gets all Log entries from the quickbooks API
	 */
	public function GetLogs(){
		$query = DB::select()->from('quickbooks_logs');
		$logentries = $this->_db->query(Database::SELECT, $query, FALSE)->as_array();
		return $logentries; 
	}

	/* 
	 * Check how many items are in queue right now
	 */
	public function GetQueueBreakdown() {
		$metrics = array();
		//Initialize metrics measurements
		$metrics['custadd'] = 0;
		$metrics['custmod'] = 0;
		//prepare and execute query
		$query = DB::select()->from('quickbooks_queue');
		$qentry = $this->_db->query(Database::SELECT, $query, FALSE)->as_array();

		foreach ($qentry as $entry) {
			if($entry['qb_action'] == 'CustomerAdd')
				$metrics['custadd']++;
			elseif($entry['qb_action'] == 'CustomerMod')
				$metrics['custmod']++;
		}
		return $metrics;
	}


	/* 
	 * Uses the details of the action and ident to find additional information
	 */
	private function FetchDetails($errorset)
	{
		//if you'd like to check the queue to find more details you can do so here
		//for instance, of the action is CustomerAdd and it failed, you can pull the customer
		//using the details from the queue
	}
}