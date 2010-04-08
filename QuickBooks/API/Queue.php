<?php

/**
 * 
 * 
 * So, say you have a bunch of queries to run against QuickBooks RDS, but you 
 * don't want to sit there and wait until all of the freakin' queries process, 
 * right? 
 * 
 * You use the API to stick all of hte queries in a queue... then you call the 
 * queue class later in a cron job, and tell it ot process everything in the 
 * queue. It processes them, and calls the callback function for each one. 
 * 
 * 
 */

class QuickBooks_API_Queue
{
	public function __construct()
	{
		
	}
	
	public function handle()
	{
		
	}
}

