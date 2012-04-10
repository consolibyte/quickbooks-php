<?php

ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);

require '/Users/kpalmer/Projects/QuickBooks/QuickBooks.php';

$Parser = new QuickBooks_IPP_Parser();

$response = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><CompanyMetaData xmlns="http://www.intuit.com/sb/cdm/v2" xmlns:qbp="http://www.intuit.com/sb/cdm/qbopayroll/v1" xmlns:qbo="http://www.intuit.com/sb/cdm/qbo"><QBNRegisteredCompanyName>Rock Castle Construction</QBNRegisteredCompanyName><Address><Line1>1735 County Road</Line1><City>South Jordan</City><CountrySubDivisionCode>UT</CountrySubDivisionCode><PostalCode>84095</PostalCode><Tag>COMPANY_ADDRESS</Tag></Address><Phone><FreeFormNumber>(801)654-4568</FreeFormNumber></Phone><Email><Address>noah.goodrich+intuit@lendio.com</Address><Tag>COMPANY_EMAIL</Tag></Email><LegalAddress><Line1>1735 County Road</Line1><City>South Jordan</City><CountrySubDivisionCode>UT</CountrySubDivisionCode><PostalCode>84095</PostalCode><Tag>LEGAL_ADDRESS</Tag></LegalAddress><IndustryType>Other Nonprofit or Exempt Organization</IndustryType></CompanyMetaData>';

$xml_errnum = null;
$xml_errmsg = null;
$err_code = null;
$err_desc = null;
$err_db = null;

$parsed = $Parser->parseIDS($response, QuickBooks_IPP_IDS::OPTYPE_FINDBYID, $xml_errnum, $xml_errmsg, $err_code, $err_desc, $err_db);

print_r($parsed);

