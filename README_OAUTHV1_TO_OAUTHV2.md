
# Migrating from OAuth 1.0 to OAuth 2.0

## Automatic migration (auto-migrate existing OAuth 1.0 tokens to OAuth 2.0 tokens)

@todo 

## Manual migration (have people re-connect manually to get OAuth 2.0 tokens)

0. make a backup of your code
0. make a backup of your existing OAuth tokens 
0. git clone the new code 
0. make code changes as detailed below

## Code change - IntuitAnywhere constructor

This constructor for the `QuickBooks_IPP_IntuitAnywhere` class has changed. 

Anywhere you see this: 

```
new QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret, $quickbooks_oauth_url, $quickbooks_success_url);
```
 
Needs to change to this (note hte new parameters): 

``` 
new QuickBooks_IPP_IntuitAnywhere(QuickBooks_IPP_IntuitAnywhere::OAUTH_V2, $sandbox, $scope, $dsn, $encryption_key, $oauth_client_id, $oauth_client_secret, $quickbooks_oauth_url, $quickbooks_success_url);
```

## Database changes 
  
```  
ALTER TABLE `quickbooks_oauth`
RENAME TO `quickbooks_oauthv1`;  
```

```  
ALTER TABLE `quickbooks_oauthv1`
CHANGE `quickbooks_oauth_id` `quickbooks_oauthv1_id` int(10) unsigned NOT NULL AUTO_INCREMENT FIRST;  
```

``` 
CREATE TABLE `quickbooks_oauthv2` (
  `quickbooks_oauthv2_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_tenant` varchar(255) NOT NULL,
  `oauth_state` varchar(255) DEFAULT NULL,
  `oauth_access_token` text,
  `oauth_refresh_token` text,
  `oauth_access_expiry` datetime DEFAULT NULL,
  `oauth_refresh_expiry` datetime DEFAULT NULL,
  `qb_realm` varchar(32) DEFAULT NULL,
  `request_datetime` datetime NOT NULL,
  `access_datetime` datetime DEFAULT NULL,
  `last_access_datetime` datetime DEFAULT NULL,
  `last_refresh_datetime` datetime DEFAULT NULL,
  `touch_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`quickbooks_oauthv2_id`)
);
```  
  
## Code change - IntuitAnywhere->load(...)  
  
```  
  $creds = $IntuitAnywhere->load($the_username, $the_tenant);
 to
    $creds = $IntuitAnywhere->load($the_tenant);  
  ```
  
  
  ```
  if ($IntuitAnywhere->check($the_tenant) and
  
  
  	$IntuitAnywhere->test($the_tenant))
  ```
  
  
  ```
  $IPP->authMode(
  		QuickBooks_IPP::AUTHMODE_OAUTH,
  		$creds);
  ```
  
  
  ```
  // Set up the IPP instance
  	$IPP = new QuickBooks_IPP($dsn);
  	to
  	// Set up the IPP instance
    	$IPP = new QuickBooks_IPP($dsn, $encryption_key);
  ```
  
  
  
  can they turn off logging if they don't want the logging? 
  
  
  
  is the reconect script even necessary anymore? 
  
  
  
  TODO KEITH
  
  test oauth v1 example 
  
  test v2 from scratch 
  
  make sure the STATE nonce gets validated
  
  minor version change  