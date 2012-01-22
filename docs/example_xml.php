<?php

/**
 * Example XML parsing
 * 
 * I've decided to include a simple XML parser as I've had some 
 * requests/concerns from people who don't have PHP XML support built in or 
 * just didn't care for the PHP simplexml or DOM extensions. In any case, this 
 * might make it easier for some people to parse the result qbXML responses. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Plain text
header('Content-Type: text/plain');

// Error reporting
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

/**
 * QuickBooks classes
 */
require_once '../QuickBooks.php';

$start = microtime(true);

// Our test XML tag
$xml = '
	<Tag1>
		<NestedTag age="25" gender="male" 
			note="Keith &quot;Worminator&quot; Palmer">
			<AnotherTag>Keith</AnotherTag>
		</NestedTag>
	</Tag1>';
	
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
	
	// Now fetch some stuff from the parsed document
	print('Hello there ' . $Root->getChildDataAt('Tag1 NestedTag AnotherTag') . "\n");
	
	print_r($Root->getChildAttributesAt('Tag1 NestedTag'));
	print("\n");
	print('Root tag name is: ' . $Root->name() . "\n");

	$NestedTag = $Root->getChildAt('Tag1 NestedTag');
	print_r($NestedTag);
}
else
{
	print('XML validation failed: [' . $errnum . ': ' . $errmsg . ']');
}

$xml2 = '
	<Animals>
		<Animal id="1"
			age="1" >
			<Name>Yamaguchi</Name>
			<Type>Rooster</Type>
		</Animal>
		<Animal id="2"
			age="2">
			<Name>Agnus</Name>
			<Type>Hen</Type>
		</Animal>
		<Animal id="3"
			age="3">
			<Name>Wasabi</Name>
			<Type>Hen</Type>
			<Note>Wasabi &amp; Yamaguchi are in *loooovvvveee*</Note>
		</Animal>
	</Animals>';

print("\n");
print('List of animal names: ' . "\n");

$Parser->load($xml2);

$errnum = 0;
$errmsg = '';
if ($Parser->validate($errnum, $errmsg))
{
	$Doc = $Parser->parse($errnum, $errmsg);
	$Root = $Doc->getRoot();
	
	$List = $Root->getChildAt('Animals');
	
	foreach ($List->children() as $Animal)
	{
		$name = $Animal->getChildDataAt('Animal Name');
		$note = $Animal->getChildDataAt('Animal Note');
		print("\t" . $name . ' (' . $note . ')' . "\n");
	}	
}
else
{
	print('XML validation failed: [' . $errnum . ': ' . $errmsg . ']');
}

$value = 'Keith & Shannon went to Kurt\'s store!';

print("\n");
print('Double encoded: ' . QuickBooks_XML::encode(QuickBooks_XML::encode($value)) . "\n");
print('NOT double encoded: ' . QuickBooks_XML::encode(QuickBooks_XML::encode($value, true, false), true, false) . "\n");

print("\n");
print("\n");

// CDATA test
$xml_cdata = '<?xml version=\'1.0\' encoding=\'UTF-8\' standalone=\'yes\'?>
<foxydata>
	<transactions>
		<transaction>
			<id><![CDATA[792498]]></id>
			<store_id><![CDATA[1575]]></store_id>
			<transaction_date><![CDATA[2009-12-16 01:01:14]]></transaction_date>
			<processor_response><![CDATA[Paypal Reference <VTJA4D1B8414 & test]]></processor_response>
			<customer_id><![CDATA[161976]]></customer_id>
			<is_anonymous><![CDATA[1]]></is_anonymous>
		</transaction>
	</transactions>
</foxydata>';

$errnum = 0;
$errmsg = '';
$Parser = new QuickBooks_XML_Parser($xml_cdata);
if ($Doc = $Parser->parse($errnum, $errmsg))
{
	print($Doc->asXML());
}
else
{
	print('Error: ' . $errnum . ': ' . $errmsg);
}

print("\n");

print('total time: ' . (microtime(true) - $start) . ' seconds');
print("\n");
