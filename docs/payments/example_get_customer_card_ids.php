<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

$Payments = new QuickBooks_Payments($oauth_consumer_key, $oauth_consumer_secret, $sandbox);

$CustomerService = new QuickBooks_IPP_Service_Customer();

$customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE Id = '91' ");

foreach ($customers as $Customer)
{
    print('Customer Id=' . $Customer->getId() . ' is named: ' . $Customer->getFullyQualifiedName() . '<br>');

    $result = $Payments->getCards($Context, $Customer->getId());

    print("\n\n\n\n");
    print($Payments->lastRequest());
    print("\n\n\n\n");
    print($Payments->lastResponse());
    print("\n\n\n\n");
    print(print_r($Payments->lastHTTPInfo(), true));
    print("\n\n\n\n");
}

print("\n\n\n\n");
print("\n\n\n\n");
print('Request [' . $CustomerService->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $CustomerService->lastResponse() . ']');
print("\n\n\n\n");
print('Error [' . $CustomerService->lastError() . ']');
print("\n\n\n\n");

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>