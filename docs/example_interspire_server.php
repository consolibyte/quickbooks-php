<?php

// 

/**
 * Example IMSCart integration server
 * 
 * @package docs
 * @subpackage integrator
 */

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks/');

// 
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

define('QUICKBOOKS_SERVER_INTEGRATOR_OFFSET', 60 * 60 * 24 * 130);

/**
 * 
 */
require_once 'QuickBooks.php';

// 
//$dsn_or_conn = 'mysql://username:password@hostname/database';
$dsn = 'mysql://root:@localhost/quickbooks_interspire';

// 
//$integrator_dsn_or_conn = 'mysql://username:password@hostname/database';
$integrator_dsn = 'mysql://root:@localhost/quickbooks_interspire';

$user = 'interspire2';
$pass = 'password';

$alert = 'you@yourdomain.com';

$map = array();
$onerror = array();
$hooks = array();
$log_level = QUICKBOOKS_LOG_DEVELOP;
$soap = QUICKBOOKS_SOAPSERVER_BUILTIN;
$wsdl = QUICKBOOKS_WSDL;
$soap_options = array();
$handler_options = array(); 
$driver_options = array();
$api_options = array();
$source_options = array();

// 
$integrator_options = array(
	//'debug_datetime' => '2009-01-12 12:00:00', 		// For debugging *only*! Make sure you comment this out!
	
	'push_products_as' => QUICKBOOKS_OBJECT_INVENTORYITEM, 
	'push_orders_as' => QUICKBOOKS_OBJECT_SALESRECEIPT,
	'push_giftcertificates_as' => QUICKBOOKS_OBJECT_SERVICEITEM, 
	'send_orders_as_pending' => false, 
	'send_orders_as_to_be_emailed' => false, 
	'send_orders_as_to_be_printed' => false, 
	'customer_name_for_query_format' => '$LastName, $FirstName', 
	'encryption_token' => '16d5e66a841344fdce8577c7ced463aa', 
	'customer_defaults' => array(
		'CustomerTypeName' => 'C Retail Sales', 
		'TermsName' => 'Prepaid', 
		'SalesRepName' => 'webst',
		'PriceLevelName' => 'Retail', 
		'SalesTaxItemName' => 'MA State Tax', 
		), 
	'order_defaults' => array(
		'SalesRepName' => 'webst', 
		'Other' => 'webstore', 
		'ShipMethodName' => 'fed ex', 
		), 
	'additional_customer_queries' => array( 
		'SELECT 
			CASE 
				WHEN isc_orders.ordshipstate = \'Massachusetts\' THEN \'TAX\' 
				ELSE \'STE\' 
			END AS SalesTaxCodeName
		FROM
			isc_orders
		LEFT JOIN
			isc_customers ON isc_customers.customerid = isc_orders.ordcustid 
		WHERE
			isc_orders.ordcustid = \'$CustomerID\' 
		ORDER BY
			isc_orders.orddate DESC 
		LIMIT 1' ), 
	'default_getorderitemsfororder_query' => '
		SELECT 
			CASE 
				WHEN ordprodid > 0 AND ( LENGTH(vcsku) = 0 OR vcsku IS NULL ) THEN ordprodsku
				WHEN ordprodid > 0 AND LENGTH(vcsku) THEN vcsku 
				ELSE \'giftcertificate\' 
			END AS ProductID, 
			ordprodname AS Descrip, 
			ordprodcost AS Rate, 
			ordprodqty AS Quantity,
			CASE 
				WHEN p.prodistaxable > 0 AND o.ordtaxrate > 0 THEN \'Tax\'
				ELSE \'Non\' 
			END AS SalesTaxCodeName, 
			ordprodoptions AS Custom_ProductOptions
		FROM 
			isc_order_products AS op
		LEFT JOIN 
			isc_product_variation_combinations AS pvc ON op.ordprodvariationid = pvc.combinationid 
		LEFT JOIN
			isc_products AS p ON op.ordprodid = p.productid 
		LEFT JOIN 
			isc_orders AS o ON op.orderorderid = o.orderid
		WHERE
			orderorderid = $OrderID ', 
	'default_getproduct_query' => '
		(
			SELECT 
				$ProductID AS ProductID,
				$ProductID AS Name, 
				prodname AS SalesDescrip, 
				prodprice AS SalesPrice, 
				$IncomeAccountName AS IncomeAccountName,
				$COGSAccountName AS COGSAccountName,
				$AssetAccountName AS AssetAccountName
			FROM 
				isc_products AS p, 
				isc_product_variation_combinations AS pvc
			WHERE
				pvc.vcproductid = p.productid AND 
				pvc.vcsku = $ProductID
		) UNION (
			SELECT 
				$ProductID AS ProductID,
				$ProductID AS Name, 
				prodname AS SalesDescrip, 
				prodprice AS SalesPrice, 
				$IncomeAccountName AS IncomeAccountName,
				$COGSAccountName AS COGSAccountName,
				$AssetAccountName AS AssetAccountName
			FROM 
				isc_products AS p
			WHERE
				p.prodcode = $ProductID
		) LIMIT 1', 
	'default_getshipping_query' => '
		SELECT
			NULL As Nothing
		FROM
			isc_orders
		WHERE
			orderid = $OrderID ', 
	'default_gethandling_query' => '
		SELECT 
			NULL As Nothing
		FROM
			isc_orders
		WHERE
			orderid = $OrderID ', 	
	'customer_extras_queries' => array(
		0 => '
		(
			SELECT
				0 AS OwnerID, 
				\'e-mail\' AS DataExtName,  
				\'Customer\' AS ListDataExtType, 
				$CustomerID AS ListObjID, 
				custconemail AS DataExtValue
			FROM
				isc_customers
			WHERE
				customerid = $CustomerID AND 
				$CustomerID NOT LIKE \'O:%\' 
		) UNION ( 
			SELECT	
				0 AS OwnerID, 
				\'e-mail\' AS DataExtName, 
				\'Customer\' AS ListDataExtType, 
				$CustomerID AS ListObjID, 
				ordbillemail AS DataExtValue
			FROM
				isc_orders
			WHERE
				orderid = SUBSTRING($CustomerID, 3) AND 
				$CustomerID LIKE \'O:%\'
		) ',
	), 
	'orderitem_additional_queries' => array(
		0 => '
			SELECT 
				ordershipmodule AS ShipMethodID, 
				(ordhandlingcost + ordshipcost) AS Amount,
				CONCAT(\'Shipping and Handling: \', ordshipmethod) AS Descrip,
				\'' . QUICKBOOKS_NONTAXABLE . '\' AS SalesTaxCodeName
			FROM
				isc_orders
			WHERE
				orderid = $OrderID', 
		1 => '
			SELECT
				CONCAT(\'Billing phone number: \', ordbillphone, \', Shipping phone number: \', ordshipphone) AS Descrip
			FROM
				isc_orders
			WHERE
				orderid = $OrderID ',
	), 
		
	//'push_payments' => false, 
	//'customer_name_for_add_format' => '$LastName, $FirstName', 
	);

$callback_options = array();

if (!QuickBooks_Utilities::initialized($dsn))
{
	QuickBooks_Utilities::initialize($dsn);
	QuickBooks_Utilities::createUser($dsn, $user, $pass);
}

// 
$Server = new QuickBooks_Server_Integrator_Interspire(
		$dsn, 
		$integrator_dsn, 
		$alert, 
		$user, 
		$map,
		$onerror, 
		$hooks, 
		$log_level, 
		$soap,
		$wsdl, 
		$soap_options, 
		$handler_options, 
		$driver_options, 
		$api_options, 
		$source_options, 
		$integrator_options, 
		$callback_options);
$Server->handle(true, true);

?>