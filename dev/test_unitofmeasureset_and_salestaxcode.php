<?php

require_once '../QuickBooks.php';

$qbxml = '
	<SalesTaxCodeRet>
		<ListID>1234-ABCD</ListID>
		<TimeCreated>2009-12-01T01:03:03</TimeCreated>
		<TimeModified>2009-12-01T01:03:03</TimeModified>
		<EditSequence>1234</EditSequence>
		<Name>NON</Name>
		<IsActive>true</IsActive>
		<IsTaxable>false</IsTaxable>
		<Desc>Non-taxable</Desc>
	</SalesTaxCodeRet>';

$SalesTaxCode = QuickBooks_Object::fromQBXML($qbxml);

print_r($SalesTaxCode);

print($SalesTaxCode->asQBXML(QUICKBOOKS_ADD_SALESTAXCODE));

//exit;

$qbxml = '
	<UnitOfMeasureSetRet>
		<ListID>1234-ABCD</ListID>
		<TimeCreated>2009-10-11T01:02:15</TimeCreated>
		<TimeModified>2009-10-11T14:26:12</TimeModified>
		<EditSequence>1234</EditSequence>
		<Name>7lb Box</Name>
		<IsActive>true</IsActive>
		<UnitOfMeasureType>Weight</UnitOfMeasureType>
		<BaseUnit>
			<Name>Pounds</Name>
			<Abbreviation>lbs</Abbreviation>
		</BaseUnit>
		<RelatedUnit>
			<Name>15lb Box</Name>
			<Abbreviation>15lbs</Abbreviation>
			<ConversionRatio>2</ConversionRatio>
		</RelatedUnit>
		<RelatedUnit>
			<Name>25lb Box</Name>
			<Abbreviation>25lbs</Abbreviation>
			<ConversionRatio>4</ConversionRatio>
		</RelatedUnit>
		<DefaultUnit>
			<UnitUsedFor>Sales</UnitUsedFor>
			<Unit>Pound</Unit>
		</DefaultUnit>
		<DefaultUnit>
			<UnitUsedFor>Purchase</UnitUsedFor>
			<Unit>2 Pounds</Unit>
		</DefaultUnit>
	</UnitOfMeasureSetRet>';

$UnitOfMeasureSet = QuickBooks_Object::fromQBXML($qbxml);

print_r($UnitOfMeasureSet);

print($UnitOfMeasureSet->asQBXML(QUICKBOOKS_ADD_UNITOFMEASURESET));