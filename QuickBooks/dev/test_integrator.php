<?php

require_once '../../QuickBooks.php';

require_once 'QuickBooks/Integrator/Imscart.php';

$dsn = 'mysql://root:@localhost/imscart';

$driver = QuickBooks_Utilities::driverFactory($dsn);

$api = QuickBooks_API_Singleton::getInstance($dsn, 'imscart', QUICKBOOKS_API_SOURCE_WEB);

$Imscart = new QuickBooks_Integrator_Imscart($driver, array());

//$Customer = $Imscart->getCustomer(2680);
//print($Customer->asQBXML('CustomerAddRq'));

//$ServiceItem = $Imscart->getProduct(5);
//print($ServiceItem->asQBXML('ItemServiceAddRq'));

$Order = $Imscart->getOrder(191);
print($Order->asQBXML('InvoiceAddRq'));

//$ShipMethod = $Imscart->getShipMethod(50);
//print($ShipMethod->asQBXML('ShipMethodAddRq'));

//$Payment = $Imscart->getPayment(207);
//print($Payment->asQBXML('ReceivePaymentAddRq'));

//$Shipping = $Imscart->getShippingForOrder(191);
//print($Shipping->asQBXML(QUICKBOOKS_ADD_SERVICEITEM));


?>