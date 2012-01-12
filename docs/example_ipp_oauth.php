<?php

require_once 'config.php';
require_once "IntuitAnywhere.php";
require_once '/Users/kpalmer/Projects/QuickBooks/QuickBooks.php';


$IntuitAnywhere = new QuickBooks_IntuitAnywhere($oauth_consumer_key, $oauth_consumer_secret, $this_url, $that_url);

if ($IntuitAnywhere->handle())
{
	; // The user has been connected, and will be redirected to $that_url automatically. 
}
else
{
	die('Oh no, something bad happened: ' . $Federator->errorNumber() . ': ' . $Federator->errorMessage());
}


