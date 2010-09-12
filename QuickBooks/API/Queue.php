<?php

/**
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
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

