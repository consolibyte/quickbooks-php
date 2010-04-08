<?php

/**
 * Authentication base class for QuickBooks Web Connector server
 * 
 * You can write your own custom authentication handlers by implementing this 
 * interface and dropping your class in the QuickBooks/Authenticate/ directory 
 * with a filename of Yourauthenticationname.php. So, if you were to implement 
 * a class named QuickBooks_Authenticate_Myauthhandler, you would place your 
 * custom authentication handler in QuickBooks/Authenticate/Myauthhandler.php. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Authenticate
 */

/**
 * Base authentication interface
 */
interface QuickBooks_Authenticate
{
	/**
	 * Create an instance of the authentication class
	 * 
	 * @param string $dsn	A DSN-style connection string (i.e.: scheme://user:pass@hostname:123/whatever)
	 */
	public function __construct($dsn);
	
	/**
	 * Log in using the given username and password
	 * 
	 * @param string $username	The username to use to login
	 * @param string $password	The password for the user
	 * @return boolean			Return TRUE if the login succeeded, FALSE if it was an incorrect username/password 
	 */
	public function authenticate($username, $password, &$company_file, &$wait_before_next_update, &$min_run_every_n_seconds);
}
