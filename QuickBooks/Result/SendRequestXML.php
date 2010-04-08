<?php

/**
 * Response result for the SOAP ->sendRequestXML() method call
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * QuickBooks result base class
 */
QuickBooks_Loader::load('/QuickBooks/Result.php');

/**
 * Response result for the SOAP ->sendRequestXML() method call
 */
class QuickBooks_Result_SendRequestXML extends QuickBooks_Result
{
	/**
	 * A QBXML XML request string
	 * 
	 * @var string
	 */
	public $sendRequestXMLResult;
	
	/**
	 * Create a new result response
	 * 
	 * @param string $xml	The XML request to send to QuickBooks
	 */
	public function __construct($xml)
	{
		$this->sendRequestXMLResult = $xml;
	}
}
