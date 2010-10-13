<?php

// Error reporting
header('Content-Type: text/plain');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks/');

/**
 * QuickBooks classes
 */
require_once 'QuickBooks.php';

$start = microtime(true);
	
$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<foxydata>
	<transactions>
		<transaction>
			<id><![CDATA[3247]]></id>
			<store_id><![CDATA[9]]></store_id>
			<transaction_date><![CDATA[2009-10-19 12:51:18]]></transaction_date>
			<processor_response><![CDATA[Authorize.net Transaction ID:2150746594]]></processor_response>
			<processor_response_details>
				<merchantReferenceCode><![CDATA[3797]]></merchantReferenceCode>
				<requestToken><![CDATA[Azj//wFEsrZ+43+52sqEe7OAAigjD]]></requestToken>
				<ccAuthReply__cvCode><![CDATA[M]]></ccAuthReply__cvCode>
				<ccAuthReply__authorizationCode><![CDATA[193189]]></ccAuthReply__authorizationCode>
				<ccAuthReply__authorizedDateTime><![CDATA[2010-04-21T04:37:29Z]]></ccAuthReply__authorizedDateTime>
				<ccAuthReply__avsCode><![CDATA[Y]]></ccAuthReply__avsCode>
				<ccAuthReply__reconciliationID><![CDATA[]]></ccAuthReply__reconciliationID>
			</processor_response_details>
			<customer_id><![CDATA[116]]></customer_id>
			<is_anonymous><![CDATA[0]]></is_anonymous>
			<customer_first_name><![CDATA[John]]></customer_first_name>
			<customer_last_name><![CDATA[Doe]]></customer_last_name>
			<customer_company><![CDATA[ACME Inc.]]></customer_company>
			<customer_address1><![CDATA[555 Mulberry Dr.]]></customer_address1>
			<customer_address2><![CDATA[#200]]></customer_address2>
			<customer_city><![CDATA[Pleasantville]]></customer_city>
			<customer_state><![CDATA[CA]]></customer_state>
			<customer_postal_code><![CDATA[90740]]></customer_postal_code>
			<customer_country><![CDATA[US]]></customer_country>
			<customer_phone><![CDATA[555-444-3333]]></customer_phone>
			<customer_email><![CDATA[test1@example.com]]></customer_email>
			<customer_ip><![CDATA[64.203.53.230]]></customer_ip>
			<shipping_first_name><![CDATA[]]></shipping_first_name>
			<shipping_last_name><![CDATA[]]></shipping_last_name>
			<shipping_company><![CDATA[]]></shipping_company>
			<shipping_address1><![CDATA[]]></shipping_address1>
			<shipping_address2><![CDATA[]]></shipping_address2>
			<shipping_city><![CDATA[]]></shipping_city>
			<shipping_state><![CDATA[]]></shipping_state>
			<shipping_postal_code><![CDATA[]]></shipping_postal_code>
			<shipping_country><![CDATA[]]></shipping_country>
			<shipping_phone><![CDATA[]]></shipping_phone>
			<shipto_shipping_service_description><![CDATA[]]></shipto_shipping_service_description>
			<purchase_order><![CDATA[]]></purchase_order>
			<cc_number_masked><![CDATA[xxxxxxxxxxxx1111]]></cc_number_masked>
			<cc_type><![CDATA[Visa]]></cc_type>
			<cc_exp_month><![CDATA[01]]></cc_exp_month>
			<cc_exp_year><![CDATA[2011]]></cc_exp_year>
			<product_total><![CDATA[15.88]]></product_total>
			<tax_total><![CDATA[0]]></tax_total>
			<shipping_total><![CDATA[85.29]]></shipping_total>
			<order_total><![CDATA[101.17]]></order_total>
			<payment_gateway_type><![CDATA[authorize]]></payment_gateway_type>
			<receipt_url><![CDATA[https://example.foxycart.tld/receipt?id=c78daaf951dc0c0b373ce3ed6f123d0b]]></receipt_url>
			<next_transaction_date><![CDATA[2009-12-01]]></next_transaction_date>
			<subscription_end_date><![CDATA[2010-01-01]]></subscription_end_date>
			<sub_token_url><![CDATA[https://example.foxycart.tld/cart?sub_token=ae2f8d30b9a38158a9020d76b95ca327]]></sub_token_url>
			<taxes>
				<tax>
					<tax_rate><![CDATA[1.0000]]></tax_rate>
					<tax_name><![CDATA[Global Tax]]></tax_name>
					<tax_amount><![CDATA[0]]></tax_amount>
				</tax>
			</taxes>
			<discounts>
				<discount>
					<code><![CDATA[coupon_code_as_entered]]></code>
					<name><![CDATA[$5 off all orders over $5!]]></name>
					<amount><![CDATA[-5]]></amount>
					<display><![CDATA[-5.00]]></display>
					<coupon_discount_type><![CDATA[price_amount]]></coupon_discount_type>
					<coupon_discount_details><![CDATA[5-5]]></coupon_discount_details>
				</discount>
			</discounts>
			<customer_password><![CDATA[6a204bd89f3c8348afd5c77c717a097a]]></customer_password>
			<custom_fields>
				<custom_field>
					<custom_field_name><![CDATA[ga]]></custom_field_name>
					<custom_field_value><![CDATA[#__utma=1.1224957675.1255981724.1255981724.1255981724.1&__utmb=1.3.10.1255981724&__utmc=1&__utmx=-&__utmz=1.1255981724.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)&__utmv=-&__utmk=21352507]]></custom_field_value>
				</custom_field>
				<custom_field>
					<custom_field_name><![CDATA[example_hidden]]></custom_field_name>
					<custom_field_value><![CDATA[value_1]]></custom_field_value>
				</custom_field>
				<custom_field>
					<custom_field_name><![CDATA[Hidden_Value]]></custom_field_name>
					<custom_field_value><![CDATA[My_Name_Is_Jonas]]></custom_field_value>
				</custom_field>
			</custom_fields>
			<transaction_details>
				<transaction_detail>
					<product_name><![CDATA[Example Product]]></product_name>
					<product_price><![CDATA[10.00]]></product_price>
					<product_quantity><![CDATA[1]]></product_quantity>
					<product_weight><![CDATA[4.000]]></product_weight>
					<product_code><![CDATA[abc123zzz]]></product_code>
					<downloadable_url><![CDATA[]]></downloadable_url>
					<subscription_frequency><![CDATA[]]></subscription_frequency>
					<subscription_startdate><![CDATA[0000-00-00]]></subscription_startdate>
					<shipto><![CDATA[Me]]></shipto>
					<category_description><![CDATA[Discount: Price: Percentage]]></category_description>
					<category_code><![CDATA[discount_price_percentage]]></category_code>
					<product_delivery_type><![CDATA[shipped]]></product_delivery_type>
					<transaction_detail_options>
						<transaction_detail_option>
							<product_option_name><![CDATA[color]]></product_option_name>
							<product_option_value><![CDATA[red]]></product_option_value>
							<price_mod><![CDATA[-4.000]]></price_mod>
							<weight_mod><![CDATA[0.000]]></weight_mod>
						</transaction_detail_option>
						<transaction_detail_option>
							<product_option_name><![CDATA[Price Discount Amount]]></product_option_name>
							<product_option_value><![CDATA[-2%]]></product_option_value>
							<price_mod><![CDATA[-0.120]]></price_mod>
							<weight_mod><![CDATA[0.000]]></weight_mod>
						</transaction_detail_option>
					</transaction_detail_options>
				</transaction_detail>
				<transaction_detail>
					<product_name><![CDATA[Example Subscription]]></product_name>
					<product_price><![CDATA[10.00]]></product_price>
					<product_quantity><![CDATA[1]]></product_quantity>
					<product_weight><![CDATA[4.000]]></product_weight>
					<product_code><![CDATA[xyz456]]></product_code>
					<downloadable_url><![CDATA[]]></downloadable_url>
					<subscription_frequency><![CDATA[1m]]></subscription_frequency>
					<subscription_startdate><![CDATA[2009-12-01]]></subscription_startdate>
					<shipto><![CDATA[Me]]></shipto>
					<category_description><![CDATA[Default for all products]]></category_description>
					<category_code><![CDATA[DEFAULT]]></category_code>
					<product_delivery_type><![CDATA[flat_rate]]></product_delivery_type>
					<transaction_detail_options>
						<transaction_detail_option>
							<product_option_name><![CDATA[color]]></product_option_name>
							<product_option_value><![CDATA[red]]></product_option_value>
							<price_mod><![CDATA[-4.000]]></price_mod>
							<weight_mod><![CDATA[0.000]]></weight_mod>
						</transaction_detail_option>
					</transaction_detail_options>
				</transaction_detail>
				<transaction_detail>
					<product_name><![CDATA[some pdf]]></product_name>
					<product_price><![CDATA[10.00]]></product_price>
					<product_quantity><![CDATA[1]]></product_quantity>
					<product_weight><![CDATA[0.000]]></product_weight>
					<product_code><![CDATA[some-pdf]]></product_code>
					<downloadable_url><![CDATA[https://example.foxycart.tld/dev/dl.php?p=djX6DTD8eqkU83ndWtJ6ywtiFLEnazhhM9h]]></downloadable_url>
					<subscription_frequency><![CDATA[]]></subscription_frequency>
					<subscription_startdate><![CDATA[0000-00-00]]></subscription_startdate>
					<shipto><![CDATA[Me]]></shipto>
					<category_description><![CDATA[Downloadables]]></category_description>
					<category_code><![CDATA[OL]]></category_code>
					<product_delivery_type><![CDATA[downloaded]]></product_delivery_type>
					<transaction_detail_options/>
				</transaction_detail>
			</transaction_details>
			<shipto_addresses>
				<shipto_address>
					<address_id><![CDATA[55]]></address_id>
					<address_name><![CDATA[Me]]></address_name>
					<shipto_first_name><![CDATA[Madre]]></shipto_first_name>
					<shipto_last_name><![CDATA[Doe]]></shipto_last_name>
					<shipto_company><![CDATA[]]></shipto_company>
					<shipto_address1><![CDATA[1234 Calle de Carretas]]></shipto_address1>
					<shipto_address2><![CDATA[]]></shipto_address2>
					<shipto_city><![CDATA[Madrid]]></shipto_city>
					<shipto_state><![CDATA[Madrid]]></shipto_state>
					<shipto_postal_code><![CDATA[28004]]></shipto_postal_code>
					<shipto_country><![CDATA[ES]]></shipto_country>
					<date_created><![CDATA[2010-02-06 12:30:31]]></date_created>
					<date_modified><![CDATA[2010-02-06 12:30:31]]></date_modified>
					<shipto_shipping_service_description><![CDATA[UPS Next Day Air]]></shipto_shipping_service_description>
				</shipto_address>
			</shipto_addresses>
		</transaction>
		<transaction>
			<id><![CDATA[3250]]></id>
			<store_id><![CDATA[9]]></store_id>
			<transaction_date><![CDATA[2009-10-19 13:20:56]]></transaction_date>
			<processor_response><![CDATA[PayPal Transaction ID:3WA89407UK383652C]]></processor_response>
			<customer_id><![CDATA[168]]></customer_id>
			<is_anonymous><![CDATA[1]]></is_anonymous>
			<customer_first_name><![CDATA[Test]]></customer_first_name>
			<customer_last_name><![CDATA[User]]></customer_last_name>
			<customer_company><![CDATA[]]></customer_company>
			<customer_address1><![CDATA[1 Main St]]></customer_address1>
			<customer_address2><![CDATA[]]></customer_address2>
			<customer_city><![CDATA[San Jose]]></customer_city>
			<customer_state><![CDATA[CA]]></customer_state>
			<customer_postal_code><![CDATA[95131]]></customer_postal_code>
			<customer_country><![CDATA[US]]></customer_country>
			<customer_phone><![CDATA[]]></customer_phone>
			<customer_email><![CDATA[list_1255983093_per@example.com]]></customer_email>
			<customer_ip><![CDATA[64.203.53.230]]></customer_ip>
			<shipping_first_name><![CDATA[]]></shipping_first_name>
			<shipping_last_name><![CDATA[]]></shipping_last_name>
			<shipping_company><![CDATA[]]></shipping_company>
			<shipping_address1><![CDATA[]]></shipping_address1>
			<shipping_address2><![CDATA[]]></shipping_address2>
			<shipping_city><![CDATA[]]></shipping_city>
			<shipping_state><![CDATA[]]></shipping_state>
			<shipping_postal_code><![CDATA[]]></shipping_postal_code>
			<shipping_country><![CDATA[]]></shipping_country>
			<shipping_phone><![CDATA[]]></shipping_phone>
			<shipto_shipping_service_description><![CDATA[]]></shipto_shipping_service_description>
			<purchase_order><![CDATA[]]></purchase_order>
			<cc_number_masked><![CDATA[]]></cc_number_masked>
			<cc_type><![CDATA[]]></cc_type>
			<cc_exp_month><![CDATA[]]></cc_exp_month>
			<cc_exp_year><![CDATA[]]></cc_exp_year>
			<product_total><![CDATA[130]]></product_total>
			<tax_total><![CDATA[21.00748]]></tax_total>
			<shipping_total><![CDATA[44]]></shipping_total>
			<order_total><![CDATA[195.00748]]></order_total>
			<payment_gateway_type><![CDATA[paypal_express]]></payment_gateway_type>
			<receipt_url><![CDATA[https://example.foxycart.tld/receipt?id=a6ec3c604df4bda7b26bd8692901fec6]]></receipt_url>
			<next_transaction_date><![CDATA[]]></next_transaction_date>
			<subscription_end_date><![CDATA[0000-00-00]]></subscription_end_date>
			<sub_token_url><![CDATA[]]></sub_token_url>
			<taxes>
				<tax>
					<tax_rate><![CDATA[10.1596]]></tax_rate>
					<tax_name><![CDATA[California]]></tax_name>
					<tax_amount><![CDATA[13.20748]]></tax_amount>
				</tax>
				<tax>
					<tax_rate><![CDATA[5.0000]]></tax_rate>
					<tax_name><![CDATA[US]]></tax_name>
					<tax_amount><![CDATA[6.5]]></tax_amount>
				</tax>
				<tax>
					<tax_rate><![CDATA[1.0000]]></tax_rate>
					<tax_name><![CDATA[Global Tax]]></tax_name>
					<tax_amount><![CDATA[1.3]]></tax_amount>
				</tax>
			</taxes>
			<discounts/>
			<customer_password><![CDATA[d41d8cd98f00b204e9800998ecf8427e]]></customer_password>
			<custom_fields>
				<custom_field>
					<custom_field_name><![CDATA[ga]]></custom_field_name>
					<custom_field_value><![CDATA[#__utma=1.1484107376.1255983648.1255983648.1255983648.1&__utmb=1.1.10.1255983648&__utmc=1&__utmx=-&__utmz=1.1255983648.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)&__utmv=-&__utmk=22470587]]></custom_field_value>
				</custom_field>
			</custom_fields>
			<transaction_details>
				<transaction_detail>
					<product_name><![CDATA[testing]]></product_name>
					<product_price><![CDATA[10.00]]></product_price>
					<product_quantity><![CDATA[13]]></product_quantity>
					<product_weight><![CDATA[0.000]]></product_weight>
					<product_code><![CDATA[]]></product_code>
					<downloadable_url><![CDATA[]]></downloadable_url>
					<subscription_frequency><![CDATA[]]></subscription_frequency>
					<subscription_startdate><![CDATA[0000-00-00]]></subscription_startdate>
					<shipto><![CDATA[]]></shipto>
					<category_description><![CDATA[Default for all products]]></category_description>
					<category_code><![CDATA[DEFAULT]]></category_code>
					<product_delivery_type><![CDATA[flat_rate]]></product_delivery_type>
					<transaction_detail_options/>
				</transaction_detail>
			</transaction_details>
			<shipto_addresses/>
		</transaction>
		<transaction>
			<id><![CDATA[3251]]></id>
			<store_id><![CDATA[9]]></store_id>
			<transaction_date><![CDATA[2009-10-19 13:29:33]]></transaction_date>
			<processor_response><![CDATA[Purchase Order]]></processor_response>
			<customer_id><![CDATA[169]]></customer_id>
			<is_anonymous><![CDATA[1]]></is_anonymous>
			<customer_first_name><![CDATA[John]]></customer_first_name>
			<customer_last_name><![CDATA[Doe, Jr.]]></customer_last_name>
			<customer_company><![CDATA[]]></customer_company>
			<customer_address1><![CDATA[555 Testing]]></customer_address1>
			<customer_address2><![CDATA[Suite 8]]></customer_address2>
			<customer_city><![CDATA[Happyville]]></customer_city>
			<customer_state><![CDATA[CA]]></customer_state>
			<customer_postal_code><![CDATA[92107]]></customer_postal_code>
			<customer_country><![CDATA[US]]></customer_country>
			<customer_phone><![CDATA[]]></customer_phone>
			<customer_email><![CDATA[test1@example.com]]></customer_email>
			<customer_ip><![CDATA[64.203.53.230]]></customer_ip>
			<shipping_first_name><![CDATA[]]></shipping_first_name>
			<shipping_last_name><![CDATA[]]></shipping_last_name>
			<shipping_company><![CDATA[]]></shipping_company>
			<shipping_address1><![CDATA[]]></shipping_address1>
			<shipping_address2><![CDATA[]]></shipping_address2>
			<shipping_city><![CDATA[]]></shipping_city>
			<shipping_state><![CDATA[]]></shipping_state>
			<shipping_postal_code><![CDATA[]]></shipping_postal_code>
			<shipping_country><![CDATA[]]></shipping_country>
			<shipping_phone><![CDATA[]]></shipping_phone>
			<shipto_shipping_service_description><![CDATA[: Customer Pickup]]></shipto_shipping_service_description>
			<purchase_order><![CDATA[Test PO #]]></purchase_order>
			<cc_number_masked><![CDATA[]]></cc_number_masked>
			<cc_type><![CDATA[]]></cc_type>
			<cc_exp_month><![CDATA[]]></cc_exp_month>
			<cc_exp_year><![CDATA[]]></cc_exp_year>
			<product_total><![CDATA[5.88]]></product_total>
			<tax_total><![CDATA[0]]></tax_total>
			<shipping_total><![CDATA[2.294]]></shipping_total>
			<order_total><![CDATA[8.174]]></order_total>
			<payment_gateway_type><![CDATA[purchase_order]]></payment_gateway_type>
			<receipt_url><![CDATA[https://example.foxycart.tld/receipt?id=bcb9fdb7af94ef95b32de45f167bd89f]]></receipt_url>
			<next_transaction_date><![CDATA[]]></next_transaction_date>
			<subscription_end_date><![CDATA[0000-00-00]]></subscription_end_date>
			<sub_token_url><![CDATA[]]></sub_token_url>
			<taxes/>
			<discounts/>
			<customer_password><![CDATA[d41d8cd98f00b204e9800998ecf8427e]]></customer_password>
			<custom_fields>
				<custom_field>
					<custom_field_name><![CDATA[ga]]></custom_field_name>
					<custom_field_value><![CDATA[#__utma=1.1484107376.1255983648.1255983648.1255983648.1&__utmb=1.1.10.1255983648&__utmc=1&__utmx=-&__utmz=1.1255983648.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)&__utmv=-&__utmk=22470587]]></custom_field_value>
				</custom_field>
				<custom_field>
					<custom_field_name><![CDATA[example_hidden]]></custom_field_name>
					<custom_field_value><![CDATA[value_1]]></custom_field_value>
				</custom_field>
				<custom_field>
					<custom_field_name><![CDATA[Hidden_Value]]></custom_field_name>
					<custom_field_value><![CDATA[My_Name_Is_Jonas]]></custom_field_value>
				</custom_field>
			</custom_fields>
			<transaction_details>
				<transaction_detail>
					<product_name><![CDATA[Example Product]]></product_name>
					<product_price><![CDATA[10.00]]></product_price>
					<product_quantity><![CDATA[1]]></product_quantity>
					<product_weight><![CDATA[4.000]]></product_weight>
					<product_code><![CDATA[abc123zzz]]></product_code>
					<downloadable_url><![CDATA[]]></downloadable_url>
					<subscription_frequency><![CDATA[]]></subscription_frequency>
					<subscription_startdate><![CDATA[0000-00-00]]></subscription_startdate>
					<shipto><![CDATA[]]></shipto>
					<category_description><![CDATA[Discount: Price: Percentage]]></category_description>
					<category_code><![CDATA[discount_price_percentage]]></category_code>
					<product_delivery_type><![CDATA[shipped]]></product_delivery_type>
					<transaction_detail_options>
						<transaction_detail_option>
							<product_option_name><![CDATA[color]]></product_option_name>
							<product_option_value><![CDATA[red]]></product_option_value>
							<price_mod><![CDATA[-4.000]]></price_mod>
							<weight_mod><![CDATA[0.000]]></weight_mod>
						</transaction_detail_option>
						<transaction_detail_option>
							<product_option_name><![CDATA[Price Discount Amount]]></product_option_name>
							<product_option_value><![CDATA[-2%]]></product_option_value>
							<price_mod><![CDATA[-0.120]]></price_mod>
							<weight_mod><![CDATA[0.000]]></weight_mod>
						</transaction_detail_option>
					</transaction_detail_options>
				</transaction_detail>
			</transaction_details>
			<shipto_addresses/>
		</transaction>
	</transactions>
</foxydata>';

$use_parser = null;			// Auto-detect the best choice
//$use_parser = QuickBooks_XML::PARSER_BUILTIN;		// Use the built in XML parser
//$use_parser = QuickBooks_XML::PARSER_SIMPLEXML;		// Use the PHP simpleXML extension
	
// Create the new object
$Parser = new QuickBooks_XML_Parser($xml, $use_parser);

print('Using backend: [' . $Parser->backend() . ']' . "\n");
print("\n");


// Parse the XML document
$errnum = 0;
$errmsg = '';
if ($Parser->validate($errnum, $errmsg))
{
	// Parse it into a document
	$Doc = $Parser->parse($errnum, $errmsg);
		
	// Get the root node from the document
	$Root = $Doc->getRoot();
	
	$fp = fopen('dev_xml_performance.' . $Parser->backend() . '.txt', 'w+');
	fwrite($fp, print_r($Root, true));
	fclose($fp);
}
else
{
	print('XML validation failed: [' . $errnum . ': ' . $errmsg . ']');
}


print("\n");

print('total time: ' . (microtime(true) - $start) . ' seconds');
print("\n");
