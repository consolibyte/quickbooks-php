<?php

/**
 * Object-Oriented API to QuickBooks data structures/qbXML interfaces  
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * * IMPORTANT * 
 * When using the API with callback functions, you *MUST MAKE SURE* that the 
 * registered callback functions are declared (and if the callback functions 
 * are declared in some included file somewhere, make sure the included file 
 * is, in fact, included. 
 * 
 * This is especially important when using the API with the 
 * QuickBooks_Server_API component (the typical way of using this API). Make 
 * sure that not only does this class have access to your callback functions, 
 * but that the file instantiating your QuickBooks_Server_API server also has 
 * access to these callback functions! 
 * 
 * 
 * <code>
 * 
 * 
 * </code>
 * 
 * @todo Iterator support for searches... add a $use_iterators parameter, auto-limit to X iterators? 
 * @todo Support API sources: qbXML/Web Connector, qbXML/RDS SOAP server, SQL, etc.
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage API
 */

/**
 * Generic utility methods
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

/**
 * Iterator support for the API
 */
QuickBooks_Loader::load('/QuickBooks/Iterator.php');

/**
 * QuickBooks API source base class
 */
QuickBooks_Loader::load('/QuickBooks/API/Source.php');

/**
 * 
 * 
 */
define('QUICKBOOKS_API_OK', QUICKBOOKS_ERROR_OK);

/**
 * 
 * 
 */ 
define('QUICKBOOKS_API_ERROR_OK', QUICKBOOKS_API_OK);

/**
 * 
 * 
 */
define('QUICKBOOKS_API_ERROR_INTERNAL', -971);

/**
 * 
 * 
 */
define('QUICKBOOKS_API_ERROR_XML', -972);

/**
 * An error message indicating there was a problem establishing a socket (TCP/HTTP?) to a remote host
 * @var integer
 */
define('QUICKBOOKS_API_ERROR_SOCKET', -973);

/**
 * An error message indicating there was a problem with a parameter passed to a method
 * @var integer
 */
define('QUICKBOOKS_API_ERROR_PARAM', -974);

/**
 * An error message indicating there was a problem with an HTTP protocol related transaction
 * @var integer
 */
define('QUICKBOOKS_API_ERROR_HTTP', -975);

// ApplicationIDs allow auto-resolving of application IDs to QuickBooks ListID and TxnIDs
if (!defined('QUICKBOOKS_API_APPLICATIONID'))
{
	/**
	 * 
	 */
	define('QUICKBOOKS_API_APPLICATIONID', 'APIApplicationID');
}

if (!defined('QUICKBOOKS_API_APPLICATIONEDITSEQUENCE'))
{
	/**
	 * 
	 */
	define('QUICKBOOKS_API_APPLICATIONEDITSEQUENCE', 'APIApplicationEditSequence');
}

/**
 * Access a remote RDS server
 * 
 */
define('QUICKBOOKS_API_SOURCE_RDS', 'rds');

/**
 * QuickBooks Windows COM access
 */
define('QUICKBOOKS_API_SOURCE_COM', 'com');

/**
 * Access an SQL mirror of the QuickBooks database schema
 * 
 * QuickBooks_API(QUICKBOOKS_API_TYPE_SQL, 'mysql://user:pass@localhost/dbname');		// real-time query the mirrored SQL database
 * 
 * 
 */
define('QUICKBOOKS_API_SOURCE_SQL', 'sql');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_API_MAPPING_SERIALIZE', 'serialize');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_API_MAPPING_DELIMITER', 'delim');

// Default ApplicationID mapping
if (!defined('QUICKBOOKS_API_MAPPING'))
{
	/**
	 * 
	 * @var string
	 */
	define('QUICKBOOKS_API_MAPPING', QUICKBOOKS_API_MAPPING_DELIMITER);
}

// Users can override the default delimiter
if (!defined('QUICKBOOKS_API_MAPPING_DELIMITER_DELIMITER'))
{
	/**
	 * Default delimiter for delimiter mapping mode
	 * @var string
	 */
	define('QUICKBOOKS_API_MAPPING_DELIMITER_DELIMITER', '|');
}

/**
 * QuickBooks API object class
 * 
 * 
 */
class QuickBooks_API
{
	/**
	 * Access QuickBooks via the QuickBooks Web Connector
	 */
	const SOURCE_WEB = 'web';
	const SOURCE_WEB_CONNECTOR = 'web';
	
	/**
	 * Access QuickBooks Online Edition
	 */
	const SOURCE_OE = 'oe';
	const SOURCE_ONLINE_EDITION = 'oe';
	
	/**
	 * The type of QuickBooks source we're using
	 * @var string
	 */
	protected $_type;
	
	/**
	 * The QuickBooks source instance
	 * @var QuickBooks_Source
	 */
	protected $_source;
	
	/**
	 * The QuickBooks driver instance
	 * @var QuickBooks_Driver
	 */
	protected $_driver;
	
	/**
	 * Whether or not real-time mode is enabled
	 * 
	 * @var boolean
	 */
	protected $_realtime;
	
	/**
	 * 
	 */
	protected $_realtime_return;
	
	/**
	 * 
	 */
	protected $_user;
	
	/**
	 * Whether or not to enable masking of sensitive data (credit card numbers, etc.)
	 * @var boolean
	 */
	protected $_masking;
	
	/*
	protected $_errnum;
	protected $_errmsg;
	
	protected $_last_request;
	protected $_last_response;
	*/
	
	/**
	 * Create a new QuickBooks_API object instance
	 * 
	 * @param string $api_driver_dsn		A DSN-style connection string to the driver class (i.e.: mysql://root:password@locahost/database)
	 * @param string $user					The username of the QuickBooks user using this API class
	 * @param string $source_type			A constant, one of: QUICKBOOKS_API_SOURCE_WEB, QUICKBOOKS_API_SOURCE_SQL, etc. 
	 * @param string $source_dsn			The source DSN-style connection string
	 * @param array $api_options
	 * @param array $source_options
	 * @param array $driver_options
	 * @param array $callback_options
	 */
	public function __construct($api_driver_dsn, $user, $source_type, $source_dsn = null, $api_options = array(), $source_options = array(), $driver_options = array(), $callback_options = array())
	{
		$this->_user = $user;
		
		if (empty($source_options['qbxml_version']) and !empty($api_options['qbxml_version']))
		{
			$source_options['qbxml_version'] = $api_options['qbxml_version'];
		}
		
		if (empty($source_options['qbxml_onerror']) and !empty($api_options['qbxml_onerror']))
		{
			$source_options['qbxml_onerror'] = $api_options['qbxml_onerror'];
		}
		
		$this->_config = $this->_defaults($api_options);
		
		// @TODO We need a better way of setting the logging level... 
		$hooks = array();
		$log_level = QUICKBOOKS_LOG_DEVELOP;
		
		$this->_driver = null;
		if ($api_driver_dsn)
		{
			$this->_driver = QuickBooks_Driver_Factory::create($api_driver_dsn, $driver_options, $hooks, $log_level);
		}
		
		$this->_source = $this->_sourceFactory($this->_driver, $user, $source_type, $source_dsn, $source_options);
		
		// Masking of sensitive data
		$this->_masking = true;
	}
	
	/**
	 * Merge custom configuration options with the default configuration options for the API class
	 * 
	 * @param array $arr		The custom configuration options
	 * @return array			A full set of configuration options (custom options merged over defaults)
	 */
	protected function _defaults($arr)
	{
		$defaults = array(
			'enable_realtime' => false, 
			'check_callbacks' => true, 
			'qbxml_version' => null, 
			'qbxml_onerror' => 'stopOnError',  
			'qbxml_locale' => null, 
			'map_create_handler' => null, 
			'map_to_quickbooks_handler' => null,
			'map_to_application_handler' => null,
			'map_to_editsequence_handler' => null,  
			);
			
		return array_merge($defaults, $arr);
	}

	/**
	 * Get the error number of the last error that occured
	 * 
	 * @return mixed		The error number (or error code, some QuickBooks error codes are hex strings)
	 */
	public function errorNumber()
	{
		return $this->_source->errorNumber();
	}
	
	/**
	 * Get the last error message that was reported
	 * 
	 * Remember that issuing new commands may cause previous unchecked errors 
	 * to be *cleared*, so make sure you check for errors if you expect an 
	 * error might occur!
	 * 
	 * @return string
	 */
	public function errorMessage()
	{
		return $this->_source->errorMessage();
	}
	
	/**
	 * Get the last raw response that the data source sent us (usually a qbXML response)
	 * 
	 * @return string
	 */
	public function lastResponse()
	{
		return $this->_source->lastResponse();
	}
	
	/**
	 * Get the last raw request that the data source issued (qbXML request or otherwise)
	 * 
	 * @return string
	 */
	public function lastRequest()
	{
		return $this->_source->lastRequest();
	}
	
	public function connectionTicket($cticket = null)
	{
		return $this->_source->connectionTicket($cticket);
	}
	
	public function sessionTicket($sticket = null)
	{
		return $this->_source->sessionTicket($sticket);
	}
	
	public function applicationID($appid = null)
	{
		return $this->_source->applicationID($appid);
	}
	
	public function applicationLogin($login = null)
	{
		return $this->_source->applicationLogin($login);
	}
	
	/**
	 * Get (or set) the current QuickBooks connector username
	 * 
	 * @param string $user
	 * @return string
	 */
	public function user($user = null)
	{
		if ($user)
		{
			$this->_user = $user;
		}
		
		return $this->_user;
	}
	
	/**
	 * Send a message to the logger
	 * 
	 * @param string $msg		The message to log
	 * @param integer $lvl		The logging level this is at
	 * @return boolean
	 */
	public function log($msg, $lvl = null)
	{
		return $this->_log($msg, $lvl);
	}
	
	protected function _log($msg, $lvl = null)
	{
		if ($this->_masking)
		{
			// Mask credit card numbers, session tickets, and connection tickets
			$msg = QuickBooks_Utilities::mask($msg);
		}
		
		return $this->_driver->log($msg, $lvl);
	}
	
	/**
	 * Create an instance of a QuickBooks_Source subclass 
	 * 
	 * @param QuickBooks_Driver $driver_obj		A QuickBooks_Driver instance
	 * @param string $user						The username we're using for the API
	 * @param string $type						The type of source we want to create
	 * @param string $dsn						The DSN-style string for the source
	 * @param array $options					An array of source options
	 * @return QuickBooks_API_Source			
	 */
	protected function _sourceFactory(&$driver_obj, $user, $type, $dsn, $options = array())
	{
		$file = '/QuickBooks/API/Source/' . ucfirst(strtolower($type)) . '.php';
		$class = 'QuickBooks_API_Source_' . ucfirst(strtolower($type));
		
		QuickBooks_Loader::load($file);
		
		if (class_exists($class))
		{
			return new $class($driver_obj, $user, $dsn, $options);
		}
		
		return null;
	}
	
	/**
	 * Create a mapping between a QuickBooks TxnID or ListID and a unique id or PRIMARY KEY in your application
	 * 
	 * @param string $object_type
	 * @param string $TxnID_or_ListID
	 * @param mixed $webapp_ID
	 * @param string $editsequence
	 * @param string $callback
	 * @return boolean
	 */
	public function createMapping($object_type, $webapp_ID, $ListID_or_TxnID, $editsequence, $extra = array(), $callback = null)
	{
		return $this->_mapCreate($object_type, $webapp_ID, $ListID_or_TxnID, $editsequence, $extra);
	}
	
	/**
	 * Fetch the application primary key for a QuickBooks ListID or TxnID 
	 * 
	 * @param string $object_type
	 * @param string $ListID_or_TxnID
	 * @return mixed
	 */
	public function fetchApplicationID($object_type, $ListID_or_TxnID, $callback = null)
	{
		return $this->_mapToApplicationID($object_type, $ListID_or_TxnID);
	}
	
	/**
	 * Tell whether or not we know the application primary key for a QuickBooks ListID or TxnID
	 * 
	 * @param string $object_type
	 * @param string $ListID_or_TxnID
	 * @return boolean
	 */
	public function hasApplicationID($object_type, $ListID_or_TxnID)
	{
		if ($this->fetchApplicationID($object_type, $ListID_or_TxnID))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Fetch the QuickBooks ListID or TxnID for an application primary key
	 * 
	 * @param string $object_type	A QuickBooks object-type constant, i.e.: QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_OBJECT_INVOICE, etc. 
	 * @param mixed $webapp_ID		The unique ID or PRIMARY KEY of the object within your application
	 * @return string				A QuickBooks TxnID or ListID
	 */
	public function fetchQuickbooksID($object_type, $webapp_ID, $callback = null)
	{
		return $this->_mapToQuickBooksID($object_type, $webapp_ID);
	}
	
	/**
	 * Fetch the QuickBooks EditSequence for an application primary key
	 * 
	 * @param string $object_type
	 * @param mixed $webapp_ID
	 * @return string
	 */
	public function fetchEditSequence($object_type, $webapp_ID, $callback = null)
	{
		return $this->_mapToEditSequence($object_type, $webapp_ID);
	}
	
	/**
	 * 
	 * 
	 */
	public function fetchExtraData($object_type, $webapp_ID, $callback = null)
	{
		
	}
	
	/**
	 * Tell whether or not we know the EditSequence for an application primary key
	 * 
	 * @param string $object_type
	 * @param mixed $webapp_ID
	 * @return boolean
	 */
	public function hasEditSequence($object_type, $webapp_ID, $callback = null)
	{
		if ($this->fetchEditSequence($object_type, $webapp_ID))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Tell whether or not a given object has a ListID or TxnID associated with it
	 * 
	 * * Note *
	 * This function *does not* query QuickBooks, it only queries the internal 
	 * mapping of QuickBooks IDs to PRIMARY KEYS. The mappings can be created 
	 * with the {@link QuickBooks_API::createMapping()} method and the API 
	 * tries to automatically create the mapping when you add or update an 
	 * object and provide a PRIMARY KEY when calling the ->add* or ->update* 
	 * method.  
	 * 
	 * @param string $object_type
	 * @param mixed $webapp_ID
	 * @return boolean
	 */
	public function hasQuickBooksID($object_type, $webapp_ID, $callback = null)
	{
		if ($this->fetchQuickBooksID($object_type, $webapp_ID))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * 
	 * @param string $module
	 * @param string $key
	 * @param mixed $value
	 * @param string $type
	 * @param array $opts
	 * @return boolean
	 */
	public function configWrite($module, $key, $value, $type = null, $opts = null)
	{
		return $this->_driver->configWrite($this->_user, $module, $key, $value, $type, $opts);
	}
	
	/**
	 * 
	 * 
	 * @param string $module
	 * @param string $key
	 * @param string $type
	 * @param array $opts
	 * @return mixed
	 */
	public function configRead($module, $key, &$type, &$opts)
	{
		return $this->_driver->configRead($this->_user, $module, $key, $type, $opts);
	}
	
	/**
	 * Issue a raw SQL query to the API, and retrieve the SQL database resource
	 * 
	 * @param string $sql
	 * @return resource
	 */
	public function sql($sql, $callback = null, $webapp_ID =  null)
	{
		if ($this->_source->understandsSQL())
		{
			
			return $this->_source->sql($sql);
		}
		
		return false;
	}
	
	/**
	 * Callback helper function for real-time connections... 
	 * 
	 * @note Grumble, grumble... there must be a better !&@#&@% way to do this... 
	 * 
	 * 
	 */
	public function __realtimeCallback($method, $action, $ID, $err, $qbxml, $Object, $qbres)
	{
		//print('realtime callback got called!');
		
		$this->_realtime_return = array(
			'method' => $method, 
			'action' => $action, 
			'ID' => $ID, 
			'qbxml' => $qbxml, 
			'object' => $Object, 
			'qbres' => $qbres, 
			);
			
		return true;
	}
	
	/**
	 * Issue a qbXML request to the API, and retrieve the qbXML response 
	 * 
	 * @param string $qbxml			A valid qbXML request
	 * @param mixed $callbacks		A valid callback value (function name, object and method, or class name and method) or an array of callbacks
	 * @param mixed $webapp_ID		Your web application's primary ID value for this record (if applicable)
	 * @param integer $priority		The priority of this request (if using a queued model of communication)
	 * @return boolean				
	 */
	public function qbxml($qbxml, $callbacks = null, $webapp_ID = null, $priority = null)
	{
		if ($this->_source->understandsQBXML())
		{
			if (!empty($callbacks) and !is_array($callbacks))
			{
				$callbacks = array( $callbacks );
			}
			
			// 
			if ($this->usingRealtime())
			{
				//$callbacks = array_merge($callbacks, array( array( $this, '__realtimeCallback' ) ));
				$callbacks = array( array( $this, '__realtimeCallback' ) );
			}
			
			//print_r($callbacks);
			
			if (!strlen($webapp_ID))
			{
				$webapp_ID = md5(mt_rand() . time() . $this->_user);
			}
			
			$method = null;
			$action = null;
			$type = null;
			
			$err = '';
			$tmp = $this->_source->handleQBXML($method, $action, $type, $qbxml, $callbacks, $webapp_ID, $priority, $err);
			
			// Real-time support
			if ($this->usingRealtime())
			{
				return $this->_realtime_return['qbxml'];
			}
			
			return $tmp;
		}
		
		$err = 'Source does not understand qbXML requests.';
		return false;
	}
	
	/**
	 * 
	 * 
	 * @param mixed $res
	 * @param boolean $as_object
	 * @param integer $index
	 * @return mixed
	 */
	public function fetch($res, $as_object = true, $index = null)
	{
		if (is_resource($res) and $this->_source->supportsSQL())		// It's a database/file resource
		{
			return $this->_source->fetch($res, $as_object, $index);
		}
		else if (is_string($res))		// It's an XML string
		{
			
		}
		
		return false;
	}
	
	/**
	 * 
	 * 
	 * @return string $str
	 * @return string
	 */
	public function escape($str)
	{
		return $this->_source->escape($str);
	}
	
	/**
	 * Whether or not to use the TEST Intuit developement gateways
	 *
	 * @param boolean $yes_or_no	TRUE to use the test development gateways, FALSE to use the live gateways
	 * @return boolean
	 */
	public function useTestEnvironment($yes_or_no)
	{
		return $this->_source->useTestEnvironment((boolean) $yes_or_no);
	}
	
	/**
	 * Whether or not to use the LIVE Intuit gateways
	 * 
	 * @param boolean $yes_or_no		TRUE to use the live gateway, FALSE to use the test gateway
	 * @return boolean
	 */
	public function useLiveEnvironment($yes_or_no)
	{
		return $this->_source->useTestEnvironment(! (boolean) $yes_or_no);
	}
	
	/**
	 * Turn debugging mode on or off
	 * 
	 * Turning debugging mode on will result in a large amount of output being 
	 * printed directly to stdout (the web browser or the console)
	 * 
	 * @param boolean $yes_or_no
	 * @return void
	 */
	public function useDebugMode($yes_or_no)
	{
		return $this->_source->useDebugMode((boolean) $yes_or_no);
	}	
	
	/**
	 * @deprecated Use QuickBooks_API::priority() instead
	 */ 
	protected function _guessPriority($action, $dependency = null)
	{
		return QuickBooks_API::priority($action, $dependency);
	}
	
	/**
	 * Guess the appropriate priority for an action
	 * 
	 * @param string $action		The action to guess for
	 * @param string $dependency	A dependency (i.e. a DataExtAdd that depends on a CustomerAdd)
	 * @return integer				The best guess at the proper priority
	 */
	static public function priority($action, $dependency = null)
	{
		return QuickBooks_Utilities::priorityForAction($action, $dependency);
	}
	
	public function qbXMLVersion($version = null)
	{
		return $this->_source->qbXMLVersion($version);
	}
	
	public function qbXMLLocale($locale = null)
	{
		return $this->_source->qbXMLLocale($locale);
	}
	
	/**
	 * 
	 * 
	 * @param string $request
	 * @param QuickBooks_Object $obj
	 * @param boolean $continue_on_error
	 * @param string $err
	 * @return array
	 */
	protected function _mapApplicationIDs($request, &$obj, $continue_on_error, &$err)
	{
		foreach ($obj->asList($request) as $key => $value)
		{
			if (is_array($value))
			{
				// this function neeeds to beable to handle arrays, or objects
				/*
				foreach ($value as $subvalue)
				{
					$err = '';
					if ($this->_mapApplicationIDs($request, $subvalue, $continue_on_error, $err))
					{
						; // do nothing
					}
					else if (!$continue_on_error)
					{
						$err = 'Recursive map error: ' . $err;
						return false;
					}
				}
				*/
			}
			else
			{
				/*
				if (substr($key, strlen(QUICKBOOKS_API_APPLICATIONID) * -1, strlen(QUICKBOOKS_API_APPLICATIONID)) == QUICKBOOKS_API_APPLICATIONID)
				{
					$type = null;
					$tag = null;
					$ID = null;
					$obj->decodeApplicationID($value, $type, $tag, $ID);
					
					if ($ListID_or_TxnID = $this->_mapToQuickBooksID($type, $ID))
					{
						$back = substr($key, 0, -1 * (strlen(QUICKBOOKS_API_APPLICATIONID) + 1));
						
						$obj->set($back . ' ' . $tag, $ListID_or_TxnID);
					}
					else if (!$continue_on_error)
					{
						$err = 'Unable to map key: ' . $key;
						return false;
					}
				}*/
			}
		}
		
		return true;
	}
	
	/**
	 * 
	 *  
	 * 
	 */
	static public function encodeApplicationID($type, $tag, $ID)
	{
		switch (QUICKBOOKS_API_MAPPING)
		{
			case QUICKBOOKS_API_MAPPING_SERIALIZE:
				return base64_encode(serialize(array( $type, $tag, $ID )));
			case QUICKBOOKS_API_MAPPING_DELIMITER:
			default:
				return implode(QUICKBOOKS_API_MAPPING_DELIMITER_DELIMITER, array( $type, $tag, $ID ));
		}
	}
	
	static public function encodeApplicationEditSequence($type, $tag, $ID)
	{
		return QuickBooks_API::encodeApplicationID($type, $tag, $ID);
	}
	
	/**
	 * Decode an application ID into it's parts
	 * 
	 * @param string $encode		The encoded application ID
	 * @param string $type			The type of record this is for (Customer, or Account, or Item, or etc.)
	 * @param string $tag			The tag this should be transformed into (ListID, or TxnID, or etc.)
	 * @param string $ID			The application ID value
	 * @return boolean
	 */
	static public function decodeApplicationID($encode, &$type, &$tag, &$ID)
	{
		switch (QUICKBOOKS_API_MAPPING)
		{
			case QUICKBOOKS_API_MAPPING_SERIALIZE:
				if ($arr = unserialize(base64_decode($encode)))
				{
					$type = current($arr);
					$tag = next($arr);
					$ID = next($arr);
					
					return true;
				}
				break;
			case QUICKBOOKS_API_MAPPING_DELIMITER:
			default:
				if ($arr = explode(QUICKBOOKS_API_MAPPING_DELIMITER_DELIMITER, $encode))
				{
					//print_r($arr);
					
					$type = current($arr);
					$tag = next($arr);
					$ID = next($arr);
					
					return true;
				}
				break;
		}
		
		return false;
	}
	
	static public function decodeApplicationEditSequence($encode, &$type, &$tag, &$ID)
	{
		return QuickBooks_API::decodeApplicationID($encode, $type, $tag, $ID);
	}
	
	/**
	 * 
	 * 
	 * @param string $encode
	 * @return mixed
	 */
	static public function extractApplicationID($encode)
	{
		$type = null;
		$tag = null;
		$ID = null;
		
		if (QuickBooks_API::decodeApplicationID($encode, $type, $tag, $ID))
		{
			return $ID;
		}
		
		return null;
	}
	
	static public function extractApplicationEditSequence($value)
	{
		return QuickBooks_API::extractApplicationID($value);
	}
	
	/**
	 * Create a mapping between an application's primary key and a QuickBooks object
	 * 
	 * @param string $type				The type of QuickBooks object (i.e.: QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_OBJECT_INVOICE, etc.)
	 * @param mixed $ID					The primary key of the application record
	 * @param string $ListID_or_TxnID	The ListID or TxnID of the object within QuickBooks
	 * @param string $editsequence		The EditSequence of the object within QuickBooks
	 * @param mixed $extra				
	 * @return boolean					
	 */
	protected function _mapCreate($type, $ID, $ListID_or_TxnID, $editsequence = '', $extra = array())
	{
		if (strlen($this->_config['map_create_handler']))
		{
			$func = $this->_config['map_create_handler'];
			
			if (false === strpos($func, '::'))
			{
				return $func($type, $ID, $ListID_or_TxnID, $editsequence, $extra); 
			}
			else
			{
				$tmp = explode('::', $func);
				
				return call_user_func(array( $tmp[0], $tmp[1] ), $type, $ID, $ListID_or_TxnID, $editsequence, $extra);
			}
		}
		else
		{ 
			return $this->_driver->identMap($this->_user, $type, $ID, $ListID_or_TxnID, $editsequence, $extra);
		}
	}
	
	/**
	 * Map an application primary key to a QuickBooks ListID or TxnID
	 * 
	 * @param string $type		The type of object (i.e.: QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_OBJECT_INVOICE, etc.)
	 * @param mixed $ID			The primary key of the record
	 * @return string			The ListID or TxnID (or NULL if it couldn't be mapped)			
	 */
	protected function _mapToQuickBooksID($type, $ID)
	{
		$editsequence = '';
		$extra = null;
		if (strlen($this->_config['map_to_quickbooks_handler']))		// Custom map handler
		{
			$func = $this->_config['map_to_quickbooks_handler'];
			
			if (false === strpos($func, '::'))
			{
				return $func($type, $ID); 
			}
			else
			{
				$tmp = explode('::', $func);
				
				return call_user_func(array( $tmp[0], $tmp[1] ), $type, $ID);
			}
		}
		else if ($ListID_or_TxnID = $this->_driver->identToQuickBooks($this->_user, $type, $ID, $editsequence, $extra))
		{
			return $ListID_or_TxnID;
		}
		
		return null;
	}
	
	/**
	 * Map a QuickBooks ListID or TxnID to an application primary key
	 * 
	 * @param string $type					The type of object
	 * @param string $ListID_or_TxnID		The ListID or TxnID of the object within QuickBooks
	 * @return string						The application record primary key
	 */
	protected function _mapToApplicationID($type, $ListID_or_TxnID)
	{
		$extra = null;
		if (strlen($this->_config['map_to_application_handler']))		// Custom mapping handler
		{
			$func = $this->_config['map_to_application_handler'];
			
			if (false === strpos($func, '::'))
			{
				return $func($type, $ListID_or_TxnID); 
			}
			else
			{
				$tmp = explode('::', $func);
				
				return call_user_func(array( $tmp[0], $tmp[1] ), $type, $ListID_or_TxnID);
			}
		}
		else if ($ID = $this->_driver->identToApplication($this->_user, $type, $ListID_or_TxnID, $extra))
		{
			// //else if ($ID = $this->fetchApplicationID($type, $ListID_or_TxnID))
			
			return $ID;
		}
		
		return null;
	}
	
	/**
	 * Map a type and application primary key to a QuickBooks EditSequence string
	 * 
	 * @param string $type		The type of object
	 * @param mixed $ID			The application primary key
	 * @return string			The QuickBooks EditSequence string
	 */
	protected function _mapToEditSequence($type, $ID)
	{
		$editsequence = '';
		$extra = null;
		if (strlen($this->_config['map_to_editsequence_handler']))		// Custom mapping handler
		{
			$func = $this->_config['map_to_editsequence_handler'];
			
			if (false === strpos($func, '::'))
			{
				return $func($type, $ID); 
			}
			else
			{
				$tmp = explode('::', $func);
				
				return call_user_func(array( $tmp[0], $tmp[1] ), $type, $ID);
			}
		}
		else if ($ListID_or_TxnID = $this->_driver->identToQuickBooks($this->_user, $type, $ID, $editsequence, $extra))
		{
			return $editsequence;
		}
		
		return null;
	}
	
	protected function _doGet($method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur)
	{
		$retr = $this->_doQuery($method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, $err, $recur);
		
		if ($this->usingRealtime() and 
			is_object($retr))
		{
			return $retr->next();
		}
		
		return false;
	}
	
	/**
	 * 
	 * 
	 * @param string $method
	 * @param string $action
	 * @param string $type
	 * @param QuickBooks_Object $obj
	 * @param mixed $callbacks
	 * @param integer $priority
	 * @param string $err
	 * @return boolean
	 */
	protected function _doQuery($method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur)
	{
		// If this action is supported by this API source... 
		if ($this->supportsAction($action))
		{
			$request = QuickBooks_Utilities::actionToRequest($action);
			
			// 
			if (!is_array($callbacks))
			{
				$callbacks = array( $callbacks );
			}

			// 
			if ($this->usingRealtime())
			{
				//$callbacks = array_merge($callbacks, array( array( $this, '__realtimeCallback' ) ));
				$callbacks = array( array( $this, '__realtimeCallback' ) );
			}
			
			if (is_null($priority))
			{
				$priority = $this->_guessPriority($action);
			}
			
			if ($this->_source->understandsObjects())
			{
				$tmp = $this->_source->handleObject($method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, $err, $recur);
				return $tmp;
			}
			else if ($this->_source->understandsQBXML())
			{
				// Get the version and locale we're using
				$locale = $this->qbXMLLocale();
				$version = $this->qbXMLVersion();
				
				// Conver the object to qbXMl
				$qbxml = $obj->asQBXML($request, $version, $locale, $action);				
				
				// Old way which didn't support locales or versions
				//$qbxml = $obj->asQBXML($request, null, null, $action);
				
				//print($qbxml);
				//exit;
				
				$tmp = $this->_source->handleQBXML($method, $action, $type, $qbxml, $callbacks, $webapp_ID, $priority, $err, $recur);
				
				// Real-time support
				if ($this->usingRealtime())
				{
					return $this->_realtime_return['object'];
				}
				
				return $tmp;
			}
			else if ($this->_source->understandsArrays())
			{
				$array = $obj->asArray();
				
				$tmp = $this->_source->handleArray($method, $action, $type, $array, $callbacks, $webapp_ID, $priority, $err, $recur);
				return $tmp;
			}
			else
			{
				$err = 'Source does not understand any available input method!';
				return false;
			}
		}
		
		$err = 'Source does not support method: ' . $method . '(...)';
		return false;
	}
	
	/**
	 * 
	 * 
	 * @param string $method
	 * @param string $action
	 * @param string $type
	 * @param QuickBooks_Object $object
	 * @param string $callback
	 * @param string $err
	 * @return boolean
	 */
	protected function _doAdd($method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err)
	{
		if ($this->supportsAction($action))
		{
			$request = $action . 'Rq';
			
			// support for multiple callbacks (the source must call each callback)
			if (!is_array($callbacks))
			{
				$callbacks = array( $callbacks );
			}
			
			// 
			if ($this->usingRealtime())
			{
				//$callbacks = array_merge($callbacks, array( array( $this, '__realtimeCallback' ) ));
				$callbacks = array( array( $this, '__realtimeCallback' ) );
			}
			
			if (!strlen($webapp_ID))
			{
				$webapp_ID = md5(mt_rand() . time() . $this->_user);
			}
			
			if (is_null($priority))
			{
				$priority = $this->_guessPriority($action);
			}
			
			if ($this->_source->understandsObjects())
			{
				$tmp = $this->_source->handleObject($method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, $err);
			}
			else if ($this->_source->understandsQBXML())
			{
				// Get the version and locale we're using
				$locale = $this->qbXMLLocale();
				$version = $this->qbXMLVersion();
				
				// Conver the object to qbXMl
				$qbxml = $obj->asQBXML($request, $version, $locale, $action);
				
				// Process the request
				$tmp = $this->_source->handleQBXML($method, $action, $type, $qbxml, $callbacks, $webapp_ID, $priority, $err);
			}
			else if ($this->_source->understandsArrays())
			{
				$array = $obj->asArray();
				$tmp = $this->_source->handleArray($method, $action, $type, $array, $callbacks, $webapp_ID, $priority, $err);
			}
			else
			{
				$err = 'Source does not understand any available input method!';
				return false;
			}
			
			// Real-time support
			if ($this->usingRealtime())
			{
				return $this->_realtime_return['object'];
			}			
			
			// @TODO support real-time and callback checking...? 
			return $tmp;
			
			/*
			if (strlen($callback) and 
				!$this->usingRealtime())
			{
				if ($this->_options['check_callbacks'] and !function_exists($callback))
				{
					$err = 'An invalid callback was provided: ' . $callback;
					return false;
				}
				
				// Queue up the request so the callback gets called when something does get returned
				//$this->_driver->apiQueue();
				
				return (boolean) $tmp;
			}
			else if ($this->usingRealtime())
			{
				if (is_string($tmp))
				{
					
				}
				else if (is_object($tmp))
				{
					
				}
				else if (is_array($tmp))
				{
					
				}
				
				$err = 'Realtime is enabled, but source returned: ' . var_dump($tmp, true);
				return false;
			}
			else
			{
				$err = 'Realtime is disabled, but no callback was provided!';
				return false;
			}*/
			
		}
		
		$err = 'Source does not support method: ' . $method . '(...)';
		return false;
	}
	
	protected function _doMod($method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err)
	{
		if ($this->supportsAction($action))
		{
			$request = $action . 'Rq';
			
			// support for multiple callbacks (the source must call each callback)
			if (!is_array($callbacks))
			{
				$callbacks = array( $callbacks );
			}
			
			// Build a mapping if they've provided an association and the mapping doesn't exist 
			if ($webapp_ID and !$this->hasQuickBooksID($type, $webapp_ID))
			{
				$EditSequence = $obj->getEditSequence();
				
				if ($ListID = $obj->get('ListID'))
				{
					$this->createMapping($type, $webapp_ID, $ListID, $EditSequence);
				}
				else if ($TxnID = $obj->get('TxnID'))
				{
					$this->createMapping($type, $webapp_ID, $TxnID, $EditSequence);
				}
			}
			
			if ($webapp_ID)
			{
				if (!$obj->get('ListID') and !$obj->get('TxnID'))
				{
					// OK, they're trying to do a modification *but* they havn't provided a ListID or TxnID... 
					//	... but they *did* provide an application ID... 
					
					
				}
				
				if (!$obj->getEditSequence())
				{
					$obj->setApplicationEditSequence($webapp_ID);
				}
			}
			else
			{
				// Generate a random webapp_ID for the queueing class
				
				$webapp_ID = md5(mt_rand() . time() . $this->_user);
			}
			
			if (is_null($priority))
			{
				$priority = $this->_guessPriority($action);
			}

			
			if ($this->_source->understandsObjects())
			{
				$tmp = $this->_source->handleObject($method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, $err);
			}
			else if ($this->_source->understandsQBXML())
			{
				//print_r($obj);
				
				$qbxml = $obj->asQBXML($request, null, null, $action);
				
				//print_r($qbxml);
				
				$tmp = $this->_source->handleQBXML($method, $action, $type, $qbxml, $callbacks, $webapp_ID, $priority, $err);
			}
			else if ($this->_source->understandsArrays())
			{
				$array = $obj->asArray();
				$tmp = $this->_source->handleArray($method, $action, $type, $array, $callbacks, $webapp_ID, $priority, $err);
			}
			else
			{
				$err = 'Source does not understand any available input method!';
				return false;
			}
			
			// @TODO support real-time and callback checking...? 
			return $tmp;
		}		
		
		return false;
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public function addDataExt($obj, $callback = null, $webapp_ID = null, $priority = null, $dependency = null)
	{
		if (is_null($priority) and !is_null($dependency))
		{
			$priority = QuickBooks_API::priority(QUICKBOOKS_ADD_DATAEXT, $dependency);
		}
		
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_DATAEXT, QUICKBOOKS_OBJECT_DATAEXT, $obj, $callback, $webapp_ID, $priority, $err);		
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public function modifyDataExt($obj, $callback = null, $webapp_ID = null, $priority = null, $dependency = null)
	{
		if (is_null($priority) and !is_null($dependency))
		{
			$priority = QuickBooks_API::priority(QUICKBOOKS_MOD_DATAEXT, $dependency);
		}
		
		$err = '';
		return $this->_doMod(__METHOD__, QUICKBOOKS_MOD_DATAEXT, QUICKBOOKS_OBJECT_DATAEXT, $obj, $callback, $webapp_ID, $priority, $err);		
	}	
	
	/**
	 * Add a customer to QuickBooks
	 * 
	 * @param QuickBooks_Object_Customer $obj	The customer object to add
	 * @param string $callback					The name of a callback function to call when QuickBooks returns it's response
	 * @param mixed $webapp_ID					The PRIMARY KEY or otherwise unique ID for this customer within your application
	 * @param integer $priority					The priority of the request (higher priorities get run first, you really shouldn't need to change this...)
	 * @return boolean							Whether or not the request was *queued* successfully (or an object if you're using real-time mode)
	 */
	public function addCustomer($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_CUSTOMER, QUICKBOOKS_OBJECT_CUSTOMER, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/**
	 * Modify a customer record
	 * 
	 * @param QuickBooks_Object_Customer $obj	The customer object to modify
	 * @param string $callback					The name of a callback function to call when QuickBooks returns it's response
	 * @param mixed $webapp_ID					The PRIMARY KEY or unique ID for this customer within your application
	 * @param integer $priority					The priority of the request
	 * @return boolean							
	 */
	public function modifyCustomer($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doMod(__METHOD__, QUICKBOOKS_MOD_CUSTOMER, QUICKBOOKS_OBJECT_CUSTOMER, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/** 
	 * Get a customer by unique ListID value
	 * 
	 * @param string $ListID
	 * @param string $callback
	 * @param integer $priority
	 * @return boolean
	 */
	public function getCustomer($ListID, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Customer( array( 'ListID' => $ListID ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_CUSTOMER, QUICKBOOKS_OBJECT_CUSTOMER, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	/**
	 * Get a customer by name
	 * 
	 * @param string $name
	 * @param string $callback
	 * @param integer $priority
	 * @return boolean
	 */
	public function getCustomerByName($name, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Customer( array( 'FullName' => $name ) );
		
		$err = '';
		return $this->_doGet(__METHOD__, QUICKBOOKS_QUERY_CUSTOMER, QUICKBOOKS_OBJECT_CUSTOMER, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	/**
	 * Get a customer record by ListID value
	 * 
	 * @param string $ListID
	 * @param string $callback
	 * @param integer $priority
	 * @return boolean 
	 */
	/*public function getCustomerByListID($ListID, $callback = null, $priority = null)
	{
		$obj = new QuickBooks_Object_Customer( array( 'ListID' => $ListID ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_CUSTOMER, QUICKBOOKS_OBJECT_CUSTOMER, $obj, $callback, $priority, $err);
	}*/
	
	/**
	 * Search for customers within QuickBooks
	 * 
	 * @param array $arr			An array of search parameters 
	 * @param string $callback		A callback function or method to be called to handle the response from QuickBooks
	 * @param integer $webapp_ID	
	 * @param integer $priority		The priority of this request 
	 * @param boolean $recur		
	 * @return boolean				
	 */
	public function searchCustomers($arr = array(), $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Customer($arr);
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_CUSTOMER, QUICKBOOKS_OBJECT_CUSTOMER, $obj, $callback, $webapp_ID, $priority, $err, $recur);
		// 						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
	}
		
	/**
	 * 
	 */
	public function listCustomersCreatedAfter($datetime, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		
	}
	
	/**
	 * 
	 */
	public function listCustomersCreatedBefore($datetime, $callback = null)
	{
		
	}
	
	/**
	 * 
	 */
	public function listCustomersCreatedBetween($start_datetime, $end_datetime, $callback = null)
	{
		
	}
	
	public function addVendor($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_VENDOR, QUICKBOOKS_OBJECT_VENDOR, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	public function addShipMethod($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_SHIPMETHOD, QUICKBOOKS_OBJECT_SHIPMETHOD, $obj, $callback, $webapp_ID, $priority, $err);
	}

	/**
	 * 
	 * 
	 * @param string $name
	 * @param string $callback
	 * @param mixed $webapp_ID
	 * @param integer $priority
	 * @return boolean
	 */
	public function getPaymentMethodByName($name, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_PaymentMethod( array( 'FullName' => $name ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_PAYMENTMETHOD, QUICKBOOKS_OBJECT_PAYMENTMETHOD, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function addPaymentMethod($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_PAYMENTMETHOD, QUICKBOOKS_OBJECT_PAYMENTMETHOD, $obj, $callback, $webapp_ID, $priority, $err);
	}

	/**
	 * 
	 * 
	 * @param string $name
	 * @param string $callback
	 * @param mixed $webapp_ID
	 * @param integer $priority
	 * @return boolean
	 */
	public function getShipMethodByName($name, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_ShipMethod( array( 'FullName' => $name ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_SHIPMETHOD, QUICKBOOKS_OBJECT_SHIPMETHOD, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	/**
	 * 
	 */
	public function addServiceItem($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_SERVICEITEM, QUICKBOOKS_OBJECT_SERVICEITEM, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	public function addInventoryAdjustment($obj, $callback = null, $webapp_ID = null, $priority = null, $dependency = null)
	{
		if (is_null($priority) and !is_null($dependency))
			$priority = QuickBooks_API::priority(QUICKBOOKS_ADD_INVENTORYADJUSTMENT, $dependency);

		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_INVENTORYADJUSTMENT, QUICKBOOKS_OBJECT_INVENTORYADJUSTMENT, $obj, $callback, $webapp_ID, $priority, $err);
	}

	public function addNonInventoryItem($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_NONINVENTORYITEM, QUICKBOOKS_OBJECT_NONINVENTORYITEM, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	public function addInventoryItem($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_INVENTORYITEM, QUICKBOOKS_OBJECT_INVENTORYITEM, $obj, $callback, $webapp_ID, $priority, $err);
	}

	public function addReceiptItem($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_RECEIPTITEM, QUICKBOOKS_OBJECT_RECEIPTITEM, $obj, $callback, $webapp_ID, $priority, $err);
	}

	public function modifyReceiptItem($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doMod(__METHOD__, QUICKBOOKS_MOD_RECEIPTITEM, QUICKBOOKS_OBJECT_RECEIPTITEM, $obj, $callback, $webapp_ID, $priority, $err);
	}

	public function queryReceiptItem($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doMod(__METHOD__, QUICKBOOKS_QUERY_RECEIPTITEM, QUICKBOOKS_OBJECT_RECEIPTITEM, $obj, $callback, $webapp_ID, $priority, $err);
	}

	public function getVendor($ListID, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Vendor( array( 'ListID' => $ListID ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_VENDOR, QUICKBOOKS_OBJECT_VENDOR, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function getVendorByName($name, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Vendor( array( 'FullName' => $name ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_VENDOR, QUICKBOOKS_OBJECT_VENDOR, $obj, $callback, $webapp_ID, $priority, $err, $recur = null);
	}
	
	public function getServiceItem($ListID, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_ServiceItem( array( 'ListID' => $ListID ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_SERVICEITEM, QUICKBOOKS_OBJECT_SERVICEITEM, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function getInventoryItem($ListID, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_InventoryItem( array( 'ListID' => $ListID ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_INVENTORYITEM, QUICKBOOKS_OBJECT_INVENTORYITEM, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function getNonInventoryItem($ListID, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_NonInventoryItem( array( 'ListID' => $ListID ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_NONINVENTORYITEM, QUICKBOOKS_OBJECT_NONINVENTORYITEM, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function getServiceItemByName($name, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_ServiceItem( array( 'FullName' => $name ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_SERVICEITEM, QUICKBOOKS_OBJECT_SERVICEITEM, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function getInventoryItemByName($name, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_InventoryItem( array( 'FullName' => $name ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_INVENTORYITEM, QUICKBOOKS_OBJECT_INVENTORYITEM, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function getNonInventoryItemByName($name, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_NonInventoryItem( array( 'FullName' => $name ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_NONINVENTORYITEM, QUICKBOOKS_OBJECT_NONINVENTORYITEM, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	/**
	 * 
	 */
	public function getItemByName($name, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Item( array( 'FullName' => $name ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_ITEM, QUICKBOOKS_OBJECT_ITEM, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function searchClasses($arr = array(), $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Class();
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_CLASS, QUICKBOOKS_OBJECT_CLASS, $obj, $callback, $webapp_ID, $priority, $err, $recur);
		// 						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
	}
	
	public function searchVendors($arr = array(), $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Vendor();
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_VENDOR, QUICKBOOKS_OBJECT_VENDOR, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function listAccountsModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $return = array(), $recur = null)
	{
		$obj = new QuickBooks_Object_Account();
		
		if (!is_null($start_datetime))
		{
			$obj->set('FromModifiedDate', QuickBooks_Utilities::datetime($start_datetime));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ToModifiedDate', QuickBooks_Utilities::datetime($end_datetime));
		}
		
		//$obj->set('IncludeRetElement', array( 'FullName', 'IsActive', 'AccountType', 'SpecialAccountType' ));
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_ACCOUNT, QUICKBOOKS_OBJECT_ACCOUNT, $obj, $callback, null, $priority, $err, $recur);
	}
	
	public function listAccountsModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listAccountsModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listAccountsModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listAccountsModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}
	
	public function searchAccounts($arr = array(), $callback = null, $webapp_ID = null, $priority =  null, $recur = null)
	{
		$obj = new QuickBooks_Object_Account($arr);
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_ACCOUNT, QUICKBOOKS_OBJECT_ACCOUNT, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function listCustomerTypesModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $return = array(), $recur = null)
	{
		$obj = new QuickBooks_Object_CustomerType();
		
		if (!is_null($start_datetime))
		{
			$obj->set('FromModifiedDate', QuickBooks_Utilities::datetime($start_datetime));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ToModifiedDate', QuickBooks_Utilities::datetime($end_datetime));
		}
		
		//$obj->set('IncludeRetElement', array( 'FullName', 'IsActive', 'AccountType', 'SpecialAccountType' ));
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_CUSTOMERTYPE, QUICKBOOKS_OBJECT_CUSTOMERTYPE, $obj, $callback, null, $priority, $err, $recur);
	}
	
	public function listCustomerTypesModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listCustomerTypesModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listCustomerTypesModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listCustomerTypesModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}

	public function listPaymentMethodsModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $return = array(), $recur = null)
	{
		$obj = new QuickBooks_Object_PaymentMethod();
		
		if (!is_null($start_datetime))
		{
			$obj->set('FromModifiedDate', QuickBooks_Utilities::datetime($start_datetime));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ToModifiedDate', QuickBooks_Utilities::datetime($end_datetime));
		}
		
		//$obj->set('IncludeRetElement', array( 'FullName', 'IsActive', 'AccountType', 'SpecialAccountType' ));
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_PAYMENTMETHOD, QUICKBOOKS_OBJECT_PAYMENTMETHOD, $obj, $callback, null, $priority, $err, $recur);
	}
	
	public function listPaymentMethodsModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listPaymentMethodsModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listPaymentMethodsModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listPaymentMethodsModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}
	
	public function listClassesModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $return = array(), $recur = null)
	{
		$obj = new QuickBooks_Object_Class();
		
		if (!is_null($start_datetime))
		{
			$obj->set('FromModifiedDate', QuickBooks_Utilities::datetime($start_datetime));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ToModifiedDate', QuickBooks_Utilities::datetime($end_datetime));
		}
		
		//$obj->set('IncludeRetElement', array( 'FullName', 'IsActive', 'AccountType', 'SpecialAccountType' ));
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_CLASS, QUICKBOOKS_OBJECT_CLASS, $obj, $callback, null, $priority, $err, $recur);
	}
	
	public function listClassesModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listClassesModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listClassesModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listClassesModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}

	/**
	 * Get a list of UnitOfMeasureSet objects modified between a certain date range
	 * 
	 * @param string $start_datetime
	 * @param string $end_datetime
	 * @param string $callback
	 * @param integer $priority
	 * @param array $return
	 * @param mixed $recur
	 * @return boolean
	 */
	public function listUnitOfMeasureSetsModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $return = array(), $recur = null)
	{
		$obj = new QuickBooks_Object_UnitOfMeasureSet();
		
		if (!is_null($start_datetime))
		{
			$obj->set('FromModifiedDate', QuickBooks_Utilities::datetime($start_datetime));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ToModifiedDate', QuickBooks_Utilities::datetime($end_datetime));
		}
		
		//$obj->set('IncludeRetElement', array( 'FullName', 'IsActive', 'AccountType', 'SpecialAccountType' ));
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_UNITOFMEASURESET, QUICKBOOKS_OBJECT_UNITOFMEASURESET, $obj, $callback, null, $priority, $err, $recur);
	}
	
	/**
	 * Get a list of UnitOfMeasureSet objects modified before a specific date/time
	 * 
	 * @return boolean
	 */
	public function listUnitOfMeasureSetsModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listUnitOfMeasureSetsModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	/**
	 * Get a list of UnitOfMeasureSet objects modified after a specific date/time
	 * 
	 * @return boolean
	 */
	public function listUnitOfMeasureSetsModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listUnitOfMeasureSetsModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}


	/**
	 * Get a list of UnitOfMeasureSet objects modified between a certain date range
	 * 
	 * @param string $start_datetime
	 * @param string $end_datetime
	 * @param string $callback
	 * @param integer $priority
	 * @param array $return
	 * @param mixed $recur
	 * @return boolean
	 */
	public function listSalesTaxCodesModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $return = array(), $recur = null)
	{
		$obj = new QuickBooks_Object_SalesTaxCode();
		
		if (!is_null($start_datetime))
		{
			$obj->set('FromModifiedDate', QuickBooks_Utilities::datetime($start_datetime));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ToModifiedDate', QuickBooks_Utilities::datetime($end_datetime));
		}
		
		//$obj->set('IncludeRetElement', array( 'FullName', 'IsActive', 'AccountType', 'SpecialAccountType' ));
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_SALESTAXCODE, QUICKBOOKS_OBJECT_SALESTAXCODE, $obj, $callback, null, $priority, $err, $recur);
	}
	
	/**
	 * Get a list of UnitOfMeasureSet objects modified before a specific date/time
	 * 
	 * @return boolean
	 */
	public function listSalesTaxCodesModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listSalesTaxCodesModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	/**
	 * Get a list of UnitOfMeasureSet objects modified after a specific date/time
	 * 
	 * @return boolean
	 */
	public function listSalesTaxCodesModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listSalesTaxCodesModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}



	public function listShipMethodsModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $return = array(), $recur = null)
	{
		$obj = new QuickBooks_Object_ShipMethod();
		
		if (!is_null($start_datetime))
		{
			$obj->set('FromModifiedDate', QuickBooks_Utilities::datetime($start_datetime));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ToModifiedDate', QuickBooks_Utilities::datetime($end_datetime));
		}
		
		//$obj->set('IncludeRetElement', array( 'FullName', 'IsActive', 'AccountType', 'SpecialAccountType' ));
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_SHIPMETHOD, QUICKBOOKS_OBJECT_SHIPMETHOD, $obj, $callback, null, $priority, $err, $recur);
	}
	
	public function listShipMethodsModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listShipMethodsModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listShipMethodsModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listShipMethodsModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}

	/**
	 * 
	 * 
	 */
	public function listSalesTaxItemsModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $return = array(), $recur = null)
	{
		$obj = new QuickBooks_Object_SalesTaxItem();
		
		if (!is_null($start_datetime))
		{
			$obj->set('FromModifiedDate', QuickBooks_Utilities::datetime($start_datetime));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ToModifiedDate', QuickBooks_Utilities::datetime($end_datetime));
		}
		
		//$obj->set('IncludeRetElement', array( 'FullName', 'IsActive', 'AccountType', 'SpecialAccountType' ));
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_SALESTAXITEM, QUICKBOOKS_OBJECT_SALESTAXITEM, $obj, $callback, null, $priority, $err, $recur);
	}
	
	public function listSalesTaxItemsModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listSalesTaxItemsModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listSalesTaxItemsModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listSalesTaxItemsModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}

	/**
	 * 
	 * 
	 */
	public function listSalesTaxGroupItemsModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $return = array(), $recur = null)
	{
		$obj = new QuickBooks_Object_SalesTaxGroupItem();
		
		if (!is_null($start_datetime))
		{
			$obj->set('FromModifiedDate', QuickBooks_Utilities::datetime($start_datetime));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ToModifiedDate', QuickBooks_Utilities::datetime($end_datetime));
		}
		
		//$obj->set('IncludeRetElement', array( 'FullName', 'IsActive', 'AccountType', 'SpecialAccountType' ));
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_SALESTAXGROUPITEM, QUICKBOOKS_OBJECT_SALESTAXGROUPITEM, $obj, $callback, null, $priority, $err, $recur);
	}
	
	public function listSalesTaxGroupItemsModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listSalesTaxGroupItemsModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listSalesTaxGroupItemsModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listSalesTaxGroupItemsModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}
	
	/**
	 * Add a journal entry to QuickBooks
	 * 
	 * @param QuickBooks_Object_JournalEntry	The journal entry object to add to QuickBooks
	 * @param callback $callback				A callback function to call when a value is retrieved from QuickBooks
	 * @param integer $webapp_ID				A unique ID that your application uses to identify this object (i.e.: primary key value)
	 * @param integer $priority				
	 * @return boolean 						
	 */
	public function addJournalEntry($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_JOURNALENTRY, QUICKBOOKS_OBJECT_JOURNALENTRY, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/**
	 * Add an invoice to QuickBooks
	 * 
	 * @param QuickBooks_Object_Invoice		The invoice to add to QuickBooks
	 * @param callback $callback			A callback function to call when a value is retrieved from QuickBooks
	 * @param integer $webapp_ID			A unique ID that your application uses to identify this object (i.e.: primary key value)
	 * @param integer $priority				
	 * @return boolean 						
	 */
	public function addInvoice($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_INVOICE, QUICKBOOKS_OBJECT_INVOICE, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/**
	 * Add a sales receipt to QuickBooks
	 * 
	 * @param QuickBooks_Object_SalesReceipt
	 * @param string $callback
	 * @param integer $webapp_ID
	 * @param integer $priority
	 * @return boolean
	 */
	public function addSalesReceipt($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_SALESRECEIPT, QUICKBOOKS_OBJECT_SALESRECEIPT, $obj, $callback, $webapp_ID, $priority, $err);
	}	
	
	public function addAccount($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_ACCOUNT, QUICKBOOKS_OBJECT_ACCOUNT, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	public function addClass($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_CLASS, QUICKBOOKS_OBJECT_CLASS, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/**
	 * 
	 */
	public function getInvoice($TxnID, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Invoice( array( 'TxnID' => $TxnID ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_INVOICE, QUICKBOOKS_OBJECT_INVOICE, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function searchInvoices($arr = array(), $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$defaults = array(
			'IncludeLineItems' => 'true', 
			);
		
		$arr = array_merge($defaults, $arr);
		
		$obj = new QuickBooks_Object_Invoice($arr);
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_INVOICE, QUICKBOOKS_OBJECT_INVOICE, $obj, $callback, $webapp_ID, $priority, $err, $recur);
		// 						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
	}
	
	public function listInvoicesCreatedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Invoice();
		
		if (!is_null($start_datetime))
		{
			$obj->set('TxnDateRangeFilter FromTxnDate', date('Y-m-d\TH:i:s', strtotime($start_datetime)));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('TxnDateRangeFilter ToTxnDate', date('Y-m-d\TH:i:s', strtotime($end_datetime)));
		}
		
		$obj->set('IncludeLineItems', 'true');
		$obj->set('IncludeLinkedTxns', 'true');
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_INVOICE, QUICKBOOKS_OBJECT_INVOICE, $obj, $callback, $priority, $err, $recur);
	}
	
	public function listInvoicesCreatedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listInvoicesCreatedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listInvoicesCreatedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listInvoicesCreatedBetween($datetime, null, $callback, $priority, $recur);		
	}
	
	public function listInvoicesForCustomer($customer_ListID, $callback = null)
	{
		
	}

	public function listInvoicesModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Invoice();
		
		if (!is_null($start_datetime))
		{
			$obj->set('ModifiedDateRangeFilter FromModifiedDate', date('Y-m-d\TH:i:s', strtotime($start_datetime)));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ModifiedDateRangeFilter ToModifiedDate', date('Y-m-d\TH:i:s', strtotime($end_datetime)));
		}
		
		$obj->set('IncludeLineItems', 'true');
		$obj->set('IncludeLinkedTxns', 'true');
		
		$err = '';
		//					$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_INVOICE, QUICKBOOKS_OBJECT_INVOICE, $obj, $callback, null, $priority, $err, $recur);
	}
	
	public function listInvoicesModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listInvoicesModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listInvoicesModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listInvoicesModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}
	
	public function getInvoiceByRefNumber($refnumber, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Invoice( array( 'RefNumber' => $refnumber ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_INVOICE, QUICKBOOKS_OBJECT_INVOICE, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function getEstimate($TxnID, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Estimate( array( 'TxnID' => $TxnID ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_ESTIMATE, QUICKBOOKS_OBJECT_ESTIMATE, $obj, $callback, $webapp_ID, $priority, $err, $recur);		
	}
	
	public function getEstimateByRefNumber($refnumber, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Estimate( array( 'RefNumber' => $refnumber ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_ESTIMATE, QUICKBOOKS_OBJECT_ESTIMATE, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	/**
	 * 
	 * 
	 * @param array $arr
	 * @param string $callback
	 * @param integer $priority
	 * @return boolean
	 */
	public function searchEstimates($arr = array(), $callback = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Estimate();
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_ESTIMATE, QUICKBOOKS_OBJECT_ESTIMATE, $obj, $callback, $priority, $err, $recur);
	}

	public function listEstimatesCreatedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Estimate();
		
		if (!is_null($start_datetime))
		{
			$obj->set('TxnDateRangeFilter FromTxnDate', date('Y-m-d\TH:i:s', strtotime($start_datetime)));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('TxnDateRangeFilter ToTxnDate', date('Y-m-d\TH:i:s', strtotime($end_datetime)));
		}
		
		$obj->set('IncludeLineItems', 'true');
		$obj->set('IncludeLinkedTxns', 'true');		
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_ESTIMATE, QUICKBOOKS_OBJECT_ESTIMATE, $obj, $callback, $priority, $err, $recur);
	}
	
	public function listEstimatesCreatedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listEstimatesCreatedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listEstimatesCreatedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listEstimatesCreatedBetween($datetime, null, $callback, $priority, $recur);		
	}
	
	public function listEstimatesForCustomer($customer_ListID, $callback = null, $priority = null)
	{
		
	}

	public function listEstimatesModifiedBetween($start_datetime, $end_datetime, $callback = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_Estimate();
		
		if (!is_null($start_datetime))
		{
			$obj->set('ModifiedDateRangeFilter FromModifiedDate', date('Y-m-d\TH:i:s', strtotime($start_datetime)));
		}
		
		if (!is_null($end_datetime))
		{
			$obj->set('ModifiedDateRangeFilter ToModifiedDate', date('Y-m-d\TH:i:s', strtotime($end_datetime)));
		}
		
		$obj->set('IncludeLineItems', 'true');
		$obj->set('IncludeLinkedTxns', 'true');	
		
		$err = '';
		//						$method, $action, $type, $obj, $callbacks, $webapp_ID, $priority, &$err, $recur
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_ESTIMATE, QUICKBOOKS_OBJECT_ESTIMATE, $obj, $callback, null, $priority, $err, $recur);
	}
	
	public function listEstimatesModifiedBefore($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listEstimatesModifiedBetween(null, $datetime, $callback, $priority, $recur);
	}
	
	public function listEstimatesModifiedAfter($datetime, $callback = null, $priority = null, $recur = null)
	{
		return $this->listEstimatesModifiedBetween($datetime, null, $callback, $priority, $recur);		
	}
	
	/**
	 * 
	 */
	public function addEstimate($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_ESTIMATE, QUICKBOOKS_OBJECT_ESTIMATE, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/**
	 * 
	 * 
	 */
	public function modifyEstimate($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		if ($webapp_ID)
		{
			//$this->createMapping();
		}
		
		$err = '';
		return $this->_doMod(__METHOD__, QUICKBOOKS_MOD_ESTIMATE, QUICKBOOKS_OBJECT_ESTIMATE, $obj, $callback, null, $priority, $err);
	}

	/**
	 * 
	 */
	public function addBill($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_BILL, QUICKBOOKS_OBJECT_BILL, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/**
	 * 
	 * 
	 */
	public function modifyBill($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		if ($webapp_ID)
		{
			//$this->createMapping();
		}
		
		$err = '';
		return $this->_doMod(__METHOD__, QUICKBOOKS_MOD_BILL, QUICKBOOKS_OBJECT_BILL, $obj, $callback, null, $priority, $err);
	}

	/**
	 * 
	 */
	public function addBillPaymentCheck($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_BILLPAYMENTCHECK, QUICKBOOKS_OBJECT_BILLPAYMENTCHECK, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/**
	 * 
	 * 
	 */
	public function modifyBillPaymentCheck($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		if ($webapp_ID)
		{
			//$this->createMapping();
		}
		
		$err = '';
		return $this->_doMod(__METHOD__, QUICKBOOKS_MOD_BILLPAYMENTCHECK, QUICKBOOKS_OBJECT_BILLPAYMENTCHECK, $obj, $callback, null, $priority, $err);
	}


	public function addCheck($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_CHECK, QUICKBOOKS_OBJECT_CHECK, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/**
	 * 
	 * 
	 */
	public function modifyCheck($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		if ($webapp_ID)
		{
			//$this->createMapping();
		}
		
		$err = '';
		return $this->_doMod(__METHOD__, QUICKBOOKS_MOD_CHECK, QUICKBOOKS_OBJECT_CHECK, $obj, $callback, null, $priority, $err);
	}

	public function addDeposit($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_DEPOSIT, QUICKBOOKS_OBJECT_DEPOSIT, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	/**
	 * 
	 * 
	 */
	public function modifyDeposit($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		if ($webapp_ID)
		{
			//$this->createMapping();
		}
		
		$err = '';
		return $this->_doMod(__METHOD__, QUICKBOOKS_MOD_DEPOSIT, QUICKBOOKS_OBJECT_DEPOSIT, $obj, $callback, null, $priority, $err);
	}

	
	public function addReceivePayment($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_RECEIVEPAYMENT, QUICKBOOKS_OBJECT_RECEIVEPAYMENT, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	public function modifyReceivePayment($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		
	}
	
	public function getReceivePayment($TxnID, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_ReceivePayment( array( 'TxnID' => $TxnID ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_RECEIVEPAYMENT, QUICKBOOKS_OBJECT_RECEIVEPAYMENT, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function getReceivePaymentByRefNumber($refnumber, $callback = null, $webapp_ID = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_ReceivePayment( array( 'RefNumber' => $refnumber ) );
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_RECEIVEPAYMENT, QUICKBOOKS_OBJECT_RECEIVEPAYMENT, $obj, $callback, $webapp_ID, $priority, $err, $recur);
	}
	
	public function searchReceivePayments($arr = array(), $callback = null, $priority = null, $recur = null)
	{
		$obj = new QuickBooks_Object_ReceivePayment();
		
		$err = '';
		return $this->_doQuery(__METHOD__, QUICKBOOKS_QUERY_RECEIVEPAYMENT, QUICKBOOKS_OBJECT_RECEIVEPAYMENT, $obj, $callback, $priority, $err, $recur);
	}
	
	public function listReceivePaymentsForCustomer()
	{
		
	}
	
	public function addSalesOrder($obj, $callback = null, $webapp_ID = null, $priority = null)
	{
		$err = '';
		return $this->_doAdd(__METHOD__, QUICKBOOKS_ADD_SALESORDER, QUICKBOOKS_OBJECT_SALESORDER, $obj, $callback, $webapp_ID, $priority, $err);
	}
	
	public function getSalesOrder($TxnID, $callback = null, $webapp_ID = null, $priority = null)
	{
		
	}
	
	public function listSalesOrdersCreatedBetween($start_datetime, $end_datetime, $callback = null)
	{
		
	}
	
	public function supportsAction($action)
	{
		//$list = $this->supported();
		//return in_array($action, $list);
		return true;
	}
	
	public function supported()
	{
		return $this->_source->supported();
	}
	
	public function supportsWriting()
	{
		return $this->_source->supportsWriting();
	}
	
	public function supportsReading()
	{
		return $this->_source->supportsReading();
	}
	
	public function supportsAdding()
	{
		return $this->_source->supportsAdding();
	}
	
	public function supportsDeleting()
	{
		
	}
	
	public function supportsModifying()
	{
		
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsQuerying()
	{
		return $this->_source->supportsQuerying();
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsSQL()
	{
		return $this->_source->understandsSQL();
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function supportsQBXML()
	{
		return $this->_source->understandsQBXML();
	}
	
	/**
	 * 
	 * 
	 */
	public function supportsRealtime()
	{
		return $this->_source->supportsRealtime();
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function enableRealtime()
	{
		if ($this->supportsRealtime())
		{
			$this->_realtime = true;
			return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * 
	 */
	public function disableRealtime()
	{
		$this->_realtime = false;
		return true;
	}
	
	/**
	 * 
	 * 
	 */
	public function usingRealtime()
	{
		return $this->_realtime and $this->supportsRealtime();
	}
	
	/**
	 * 
	 * 
	 * @deprecated	Use ->errorNumber() and ->errorMessage() instead
	 * @return string
	 */
	public function lastError()
	{
		return $this->errorNumber() . ': ' . $this->errorMessage();
	}
	
	public function debug()
	{
		
	}
	
	/**
	 * 
	 * 
	 * @deprecated This is bad... but right now the inetgrators need this
	 * 
	 * @return QuickBooks_Driver_* class
	 */
	public function driver()
	{
		return $this->_driver;
	}
}



	/*
	
	the QuickBooks_Server_API should understand how to:
	 - take objects from the $extra and convert them to actions
	 - take qbXML from the $extra and just send it out 
	 - 
	 
	we need an extra table *because* we need a place to store the 
	callback functions!
	(or can we use $extra for this as well...?) 
	
	
	it would be better if we didn't need an extra table... that way 
	we don't have to write extra driver methods just for the API stuff  
	
	$extra = array(
		'qbxml' => $my_qbxml, 
		'array' => $my_array, 
		'object' => $my_object, 
		'callback' => $my_callback,
		);
	
	OR
	
	do we write a generic ->get(), ->set() methods that eachd river 
	needs to implement... and then use that? 
	
	
	*** The $source_dsn username and password component should be the 
	* web connector username that we use to queue things up
	* 
	* or instead if it's like OE source, thats the QB username/password
	* 
	* or instead if its SQL source, the mysql username/password
	* 
	
	
	// everything is prioritized, so if you do a addCustomer(), addInvoice(), 
	 * the API guartentees that the customer gets added first, then the invoice
	 * You can embed some tags in the Invoice:
	 * 
	 * <ApplicationID>15</ApplicationID> which the API will automatically look 
	 * for, look up with fetchQuickBooksID(), and if found replace with the 
	 * QuickBooks ListID or TxnID as appropriate (based on the tag its' nested in)
	 * 
	 * 
	
	
	*/

/*


BETTER IDEA!  **** NO THIS IS *NOT* A BETTER IDEA DON'T USE IT!

$API = new QuickBooks_API(QUICKBOOKS_API_TYPE_RPC, 'mysql:// bla bla bla');
// queues up things for the API server, the API server has the request/response handlers built in, API returns 

$API = new QuickBooks_API(QUICKBOOKS_API_TYPE_SQL, 'mysq:// where the SQL database mirror is');
// queues up things for the SQL server, SQL server returns qbXML records, we convert to objects and call callbacks

$API = new QuickBooks_API(QUICKBOOKS_API_TYPE_RDS, 'rds:// bla bla bla ');




IF WE USE AN QuickBooks_Server_API() type server, 
then we can auto-register an authentication hook which drops stuff from the 
api queue into the queued events... 

we can also override the handle() method so that when a response gets called, 
we automatically call the callback function (from quickbooks_api_queue) and 
do our thing


/*** THIS I S AGOOD IDEA HERE! ***


$API = new QuickBooks_API(QUICKBOOKS_API_TYPE_API, 'mysql:// path to our api queue', 'api://localhost/qbsoap/qbapi.php');

$API = new QuickBooks_API(QUICKBOOKS_API_TYPE_SQL', 'mysql:// path to our api queue', 'mysql:// path to our SQL database mirror');

$API = new QuickBooks_API(QUICKBOOKS_API_TYPE_RDS', 'mysql:// path to our api queue', 'rds://localhost/path/to/rds-server');

if ($API->supportsRealTimeRequests())
{
	$API->setRealTimeRequests(true);
}
else
{
	$API->setRealTimeRequests(false);
}

// For real-time requests
$Customer = $API->getCustomer(12);

// For non-realtime requests
$API->getCustomer(12, 'my_callback_function');

function my_callback_function($Customer)
{
	
}

*
*
For the 'Queue' source:
-----------------------
You issue a request, which adds a record to the 'quickbooks_api_queue' table 
The quickbooks_server class looks for records in the api_queue table, if 
records exist, then it registeres request/response handlers for those events, and drops the events in the queue
those pre-built request/response handlers handle the events

quickbooks_api_queue:
	id, qb_action, ident, callback, request_handler, response_handler, write_datetime, mod_datetime
										(these should be probably be hard-coded per api call)

pulls record 
registeres a response handler
registered a request handler
drops it in the queue
request goes out
response received

parse xml recieved

return parsed XML to the quickbooks_api
quickbooks_api converts to objects/iterators
quickbooks_api either returns it or calls the callback


For the 'Sql' source:
---------------------
You issue a request, it goes out and queries the SQL database based on the 
schema definintions, parse response

return parsed SQL to quickbooks_api
quickbooks_api converts to objects/iterators
quickbooks_api either returns it or calls the callback


 */
