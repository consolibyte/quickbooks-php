Forked to fix issues in PHP 8 and improve the code.

QuickBooks PHP DevKit
=====================

QuickBooks integration support for PHP 5.x+

The package you've downloaded contains code and documentation for connecting various versions and editions of QuickBooks to PHP, allowing your PHP applications to do fancy things like:

- Automatically send orders placed on your website to QuickBooks Online or QuickBooks for Windows
- Charge credit cards using Intuit Payments / QuickBooks Merchant Services
- Connect to QuickBooks v3 APIs via OAuth
- Get access to QuickBooks reports
- Pull information out of QuickBooks and display it online
- Connect to all Microsoft Windows versions of QuickBooks
- Connect to all QuickBooks Online versions
- Authenticate via OAuth
- etc. etc. etc.

Almost anything you can do in the QuickBooks GUI, in QuickBooks Online Edition, and with QuickBooks Merchant Service can be accomplished via this framework.

## Quick Start Guides & Examples

* QuickBooks FOR WINDOWS (via QuickBooks Web Connector)
  - Read the [quick start guide for the Web Connector/QuickBooks for Windows](https://github.com/mc2contributor/quickbooks-php/blob/master/QuickStart-Windows.md)
  - Examples: docs/web_connector/

* QuickBooks ONLINE (via Intuit Partner Platform/Intuit Anywhere)
  - Read the [quick start guide for Intuit Partner Platform/QuickBooks Online] (https://github.com/mc2contributor/quickbooks-php/blob/master/QuickStart-Online.md)
  - Examples: docs/partner_platform/example_app_ipp_v3/

See the docs/ folder for more examples.

## OAuth 1.0 to OAuth 2.0 migration

You can find information on how to migrate your app from OAuth v1.0 to OAuth v2.0 below. We are also working on getting OpenID Connect and an automated token migration process ready -- coming soon.

* <https://github.com/consolibyte/quickbooks-php/blob/master/README_OAUTHV1_TO_OAUTHV2.md>

## Support

### Questions/general support 

**Before you ask for help** make sure you: 

- If you're connecting to QuickBooks Online, run the `troubleshooting.php` script: <https://github.com/consolibyte/quickbooks-php/blob/master/docs/partner_platform/example_app_ipp_v3/troubleshooting.php>
- Make sure you post your code - we can't help without seeing what you're doing.

**Now** that you have the output of the `troubleshooting.php` script and your code together, ask in one of these two places: 

- StackOverflow: <https://stackoverflow.com/questions/tagged/quickbooks> (This is the best place to get support)
- Intuit Dev Forums: <https://help.developer.intuit.com/s/>

### Bugs/pull requests 

- GitHub: <https://github.com/consolibyte/quickbooks-php>

### Additional Info

There is additional documentation and additional examples on our legacy and new wikis:

- https://web.archive.org/web/20221209200524/http://wiki.consolibyte.com/wiki/doku.php/quickbooks     (legacy)
- https://web.archive.org/web/20221129185859/http://www.consolibyte.com/docs/index.php/QuickBooks     (new wiki)




-------------------------------------
###Keith Palmer###
- Find the original author on Twitter at https://twitter.com/keith_palmer_jr
