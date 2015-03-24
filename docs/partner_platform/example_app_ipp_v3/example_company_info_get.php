<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$CompanyInfoService = new QuickBooks_IPP_Service_CompanyInfo();

$Info = $CompanyInfoService->get($Context, $realm);

// Let's get some data! 
$company_type = $Info->getXPath('//CompanyInfo/NameValue[Name="CompanyType"]/Value');
print('Company type: ' . $company_type . "\n");

$company_name = $Info->getCompanyName();
print('Company name (method): ' . $company_name . "\n");

$company_name = $Info->getXPath('//CompanyInfo/CompanyName');
print('Company name (XPath): ' . $company_name . "\n");

$country = $Info->getCountry();
print('Country: ' . $country . "\n");

$email = $Info->getEmail()->getAddress();
print('Address: ' . $email . "\n");

$count = $Info->countNameValue();
for ($i = 0; $i < $count; $i++)
{
	$NameValue = $Info->getNameValue($i);
	//print_r($NameValue);

	print('NameValue: ' . $NameValue->getName() . ' = ' . $NameValue->getValue() . "\n");
}

print("\n\n\n");

// Here's a dump of all the data 
print('Dump of all data: ' . "\n");
print_r($Info);


/*
print($IPP->lastError($Context));

print("\n\n\n\n");
print('Request [' . $IPP->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $IPP->lastResponse() . ']');
print("\n\n\n\n");
*/

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>