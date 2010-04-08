<?php

require_once '../../QuickBooks.php';

$arr = array(
	'Name' => 'Sales', 
	'Descrip' => 'Test', 
);

$path_or_tablefield = 'account.Descrip';

$mode = QUICKBOOKS_SQL_SCHEMA_MAP_TO_XML;

$map = array();
$others = array();
QuickBooks_SQL_Schema::mapToSchema($path_or_tablefield, $mode, $map, $others);

print("\n\n");
print_r($map);

$path_or_tablefield = 'account.SomethingElse';

$mode = QUICKBOOKS_SQL_SCHEMA_MAP_TO_XML;

$map = array();
$others = array();
QuickBooks_SQL_Schema::mapToSchema($path_or_tablefield, $mode, $map, $others);

print("\n\n");
print_r($map);

$path_or_tablefield = 'account.Parent_ListID';

$mode = QUICKBOOKS_SQL_SCHEMA_MAP_TO_XML;

$map = array();
$others = array();
QuickBooks_SQL_Schema::mapToSchema($path_or_tablefield, $mode, $map, $others);

print("\n\n");
print_r($map);




print("\n\n");

?>