PHP DevKit for QuickBooks - Intuit Partner Platform Quick-Start
===============================================================

From ConsoliBYTE Wiki

Download a \*nightly\* build of the latest code:

*   [https://github.com/consolibyte/quickbooks-php](https://web.archive.org/web/20210918050755/https://github.com/consolibyte/quickbooks-php)

"Create an app" with Intuit by following the instructions here (you only have to go through the "Create an App" step - after you've done that you'll be shown the app token and OAuth credentials that you need):

*   [https://developer.intuit.com/docs/0025_quickbooksapi/0010_getting_started#Create](https://web.archive.org/web/20210918050755/https://developer.intuit.com/docs/0025_quickbooksapi/0010_getting_started#Create)

(direct link to registration: [https://developer.intuit.com/Application/Create/IA](https://web.archive.org/web/20210918050755/https://developer.intuit.com/Application/Create/IA))

Extract the files and look at the code in this directory:

*   docs/example_app_ipp_v3/

You will need to modify config.php and change these variables:

*   $token (this is your application token from registration)
*   $oauth_consumer_key (this is your OAuth consumer key from registration)
*   $oauth_consumer_secret (this is your OAuth consumer secret from registration)

*   $quickbooks_oauth_url (this is the URL of the 'oauth.php' script)
*   $quickbooks_success_url (this is the URL of the 'success.php' script)
*   $quickbooks_menu_url (this is the URL of the 'menu.php' script)

*   $dsn (this points to your database)

*   $encryption_key (this will be used to encrypt the OAuth tokens stored in your database)

Visit the /index.php URL in a browser, and you should be able to connect and exchange data with QuickBooks.

Going forward, you will want to change the $the_tenant variable - this variable should be filled in with a unique identifier for every one of your "tenants" in your SaaS multi-tenant architecture.

There are additional examples in the "docs/example_app_ipp_v3/" which you should review.

*   [https://github.com/consolibyte/quickbooks-php/tree/master/docs/example_app_ipp_v3](https://web.archive.org/web/20210918050755/https://github.com/consolibyte/quickbooks-php/tree/master/docs/example_app_ipp_v3)
