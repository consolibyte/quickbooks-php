<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Client
 */

/**
 * 
 * 
 * 
 */
class QuickBooks_Request_SendRequestXML extends QuickBooks_Request
{
	public $ticket;
	
	public $strHCPResponse;
	
	public $strCompanyFileName;
	
	public $qbXMLCountry;
	
	public $qbXMLMajorVers;
	
	public $qbXMLMinorVers;
	
	public function __construct($ticket = null, $hcpresponse = null, $companyfile = null, $country = null, $majorversion = null, $minorversion = null)
	{
		$this->ticket = $ticket;
		$this->strHCPResponse = $hcpresponse;
		$this->strCompanyFileName = $companyfile;
		$this->qbXMLCountry = $country;
		$this->qbXMLMajorVers = (int) $majorversion;
		$this->qbXMLMinorVers = (int) $minorversion;
	}
}
