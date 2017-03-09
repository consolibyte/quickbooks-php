<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

    <pre>

<?php

$EXRService = new QuickBooks_IPP_Service_ExchangeRate();
/**
 *
 * {
 * "SourceCurrencyCode": "INR",
 * "TargetCurrencyCode": "USD",
 * "Rate": 7,
 * "AsOfDate": "2015-07-08",
 * "SyncToken": "0",
 * "MetaData": {
 * "LastUpdatedTime": "2015-07-07T12:38:40-07:00"
 * }
 * }
 */

$requestArray = [
    "SourceCurrencyCode" => "EUR",
    "TargetCurrencyCode" => "GBP",
    "Rate" => 1.95,
    "AsOfDate" => date("Y-m-d"),
    "SyncToken" => "11"

];

$result = $EXRService->setRate($Context, $realm, $requestArray);
var_dump($result, $realm);
//
//print("\n\n\n\n");
//print('Request [' . $IPP->lastRequest() . ']');
//print("\n\n\n\n");
//print('Response [' . $IPP->lastResponse() . ']');
//print("\n\n\n\n");

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>