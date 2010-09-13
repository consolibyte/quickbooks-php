<?php

/**
 * QuickBooks Frameworks declarations
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * Chances are that you're only using select parts of this large QuickBooks 
 * package because you're only doing a Web Connector integration, or you're 
 * only doing Merchant Services, or you're only doing XYZ, etc. etc. etc. 
 * 
 * These framework constants allow you to specify that you only want to include 
 * certain sets of files that are applicable to you, instead of including 
 * everything. Including everything has a performance penalty (on some machines 
 * it can take 0.3 seconds to load all of the includes) so including just the 
 * stuff you need can help to alleviate some performance headaches. 
 * 
 * @license LICENSE.txt
 * @author Keith Palmer <Keith@ConsoliBYTE.com>
 * 
 * @package QuickBooks
 * @subpackage Frameworks
 */

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_CONSTANTS', 1);

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_QUEUE', 2);

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_WEBCONNECTOR', 4);

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_MERCHANTSERVICE', 8);

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_ONLINEEDITION', 16);

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_WINDOWSCOM', 32);

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_OBJECTS', 64);

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_QBXML', 128);

/** 
 * 
 */
define('QUICKBOOKS_FRAMEWORK_FRONTEND', 256);

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_MISCELLANEOUS', 1024);

/**
 * 
 */
define('QUICKBOOKS_FRAMEWORK_IPP', 2048);
