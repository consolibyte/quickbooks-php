PHP DevKit for QuickBooks - Quick-Start
=======================================

From ConsoliBYTE Wiki

Contents
--------

*   [1 PHP DevKit for QuickBooks Web Connector Quick-Start](#PHP_DevKit_for_QuickBooks_Web_Connector_Quick-Start)
    *   [1.1 Getting Stuff Installed](#Getting_Stuff_Installed)
    *   [1.2 Troubleshooting](#Troubleshooting)
    *   [1.3 Notes](#Notes)

PHP DevKit for QuickBooks Web Connector Quick-Start
---------------------------------------------------

I'm going to try to quickly describe here what you need to do to get QuickBooks up and running and interacting correctly with the Web Connector and your web application.

This assumes your doing an integration using the basic features of this framework. You'll need to look at these files for examples:

1.  docs/example_web_connector.php

This is the main example file that shows how to set up a SOAP Web Service that QuickBooks will talk to and allow exchange of data with.

1.  docs/example_web_connector_queueing.php

The SOAP Web Service will work off of a queueing mechanism. You'll queue up events within your application, then when QuickBooks and the Web Connector connect you'll build qbXML requests from those actions and send them to QuickBooks. This file shows you how to queue up events/actions.

1.  docs/example_web_connector_qwc.php

This file shows you how to programatically create a .QWC file, the file that tells the Web Connector how to connect to your SOAP server.

### Getting Stuff Installed

1.  Install QuickBooks (if you havn't already) and get a company ready to test with
2.  Install the QuickBooks Web Connector on the same computer as QuickBooks: [http://marketplace.intuit.com/webconnector/](https://web.archive.org/web/20220630162035/http://marketplace.intuit.com/webconnector/)
3.  Install the QuickBooks SDK (optional, but nice to have!) (some parts of it only work on Windows, the documentation is HTML and will work on Apple and Linux)
4.  Know your MySQL connection string, you'll use it later, it should look like below.

```pre
mysql://YOUR_MYSQL_USERNAME:YOUR_MYSQL_PASSWORD@YOUR_MYSQL_HOSTNAME/YOUR_MYSQL_DATABASE
```

1.  Modify docs/example_web_connector.php (or docs/example_server.php if you're using the old code) by changing the $dsn variable to your MySQL connection string.
2.  If you want, you can modify the $username and $password variables in that file. These variables \*are only used once\* to initialize the database - after that, if you want to change them you have to change them in the "quickbooks_user" SQL table instead.
3.  Create a .QWC file, using the username you put in $username, to point to your example_web_connector.php URL by...

1.  1.  Modifying the example on our wiki: [QuickBooks Example .QWC File](https://web.archive.org/web/20220630162035/http://www.consolibyte.com/docs/index.php/QuickBooks_Example_.QWC_File "QuickBooks Example .QWC File")
    2.  Programatically create one: (see: docs/example_web_connector_qwc.php)

1.  Load the .QWC file into the QuickBooks Web Connector by clicking the 'Add Application' button
2.  Enter the password you put in $password into the Web Connector
3.  Test the QuickBooks connection by telling the QuickBooks Web Connector to update. The docs/example_web_connector.php script by default adds random dummy customers named "ConsoliBYTE (random number here)" to QuickBooks. If you see that customer in QuickBooks, then communication with QuickBooks was successful, congratulations! Otherwise, you'll have to look through the quickbooks_log MySQL table and the Web Connector log file to find what's going wrong.
4.  After this initial test, NOTHING WILL BE TRANSFERRED (you'll see "No data exchange required") on subsequent runs. To get more stuff to transfer, you need to queue stuff up to transfer -- [https://github.com/consolibyte/quickbooks-php/blob/master/docs/web_connector/example_web_connector_queueing.php](https://web.archive.org/web/20220630162035/https://github.com/consolibyte/quickbooks-php/blob/master/docs/web_connector/example_web_connector_queueing.php)

### Troubleshooting

If you need help, use the forums:

*   [http://www.consolibyte.com/forum/](https://web.archive.org/web/20220630162035/http://www.consolibyte.com/forum/)

### Notes

The $username and $password variables in the script are only ever used ONCE to initialize the database. After that, the username/password can be changed/managed by editing the records in the "quickbooks_user" SQL table.

The password is stored by default as a salted SHA1 hash. The table also accepts SHA1 hashes, MD5 hashes, and plain-text passwords.

These usernames/passwords have NOTHING to do with your Quickbooks usernames, Windows usernames, or anything. This is just the username that the SOAP server uses to connect with the Web Connector.

