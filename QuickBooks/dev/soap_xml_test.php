<?php

require_once '/Users/keithpalmerjr/Projects/QuickBooks/QuickBooks.php';

$xml = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><receiveResponseXML xmlns="http://developer.intuit.com/"><ticket>7fe1d3dccd44d65f2f3d85a077f1705f</ticket><response>&lt;?xml version="1.0" ?&gt;
&lt;QBXML&gt;
&lt;QBXMLMsgsRs&gt;
&lt;ItemServiceAddRs requestID="SXRlbVNlcnZpY2VBZGR8c2hpcHBpbmc=" statusCode="3100" statusSeverity="Error" statusMessage="The name &amp;quot;Shipping Item - QuickBooks Inte&amp;quot; of the list element is already in use." /&gt;
&lt;/QBXMLMsgsRs&gt;
&lt;/QBXML&gt;
</response><hresult /><message /></receiveResponseXML></soap:Body></soap:Envelope>';

$Parser = new QuickBooks_XML_Parser($xml);

$errnum = null;
$errmsg = null;
if ($Document = $Parser->parse($errnum, $errmsg))
{
	print_r($Document);
}