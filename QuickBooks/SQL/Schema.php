<?php

/**
 * Schema mapping methods for mapping XML schemas to SQL schemas, and vice-versa
 * 
 * * THANKS! *
 * Extra special thanks go out to Garrett at Space Coast IC for putting gobs of 
 * time and effort into completing this schema for a project for his company.  
 * 
 * @author Keith Palmer <keith@consolibyte.com>, Garrett <grgisme@gmail.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage SQL
 */

/**
 * QuickBooks SQL base class (is this even required?)
 */
QuickBooks_Loader::load('/QuickBooks/SQL.php');

/**
 * XML parsing
 */
QuickBooks_Loader::load('/QuickBooks/XML.php');

/**
 * Various utilities methods
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

/**
 * Map a SQL schema to a qbXML schema
 * @var char
 */
define('QUICKBOOKS_SQL_SCHEMA_MAP_TO_XML', 'q');

/**
 * Map a qbXML schema to an SQL schema
 * @var char
 */
define('QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL', 's');

/**
 * Schema mapping methods for mapping XML schemas to SQL schemas, and vice versa
 * 
 * The QuickBooks SQL mirror server needs to map the QuickBooks qbXML XML 
 * schema to an SQL schema that can be stored in a standard SQL database. This 
 * class provides static methods which provide mapping from XML to SQL schemas, 
 * and then vice-versa for when you need to convert SQL objects back to qbXML 
 * objects.  
 */
class QuickBooks_SQL_Schema
{
	/**
	 * Take a qbXML schema and transform that schema to an SQL schema definition
	 * 
	 * @param string $xml			The XML string to transform
	 * @param array $tables			An array of... erm... something?
	 * @return boolean 
	 */
	static public function mapSchemaToSQLDefinition($xml, &$tables)
	{
		$Parser = new QuickBooks_XML_Parser($xml);
		
		$errnum = 0;
		$errmsg = '';
		$tmp = $Parser->parse($errnum, $errmsg);
		
		$tmp = $tmp->children();
		$base = current($tmp);
		
		$tmp = $base->children();
		$rs = next($tmp);
		
		foreach ($rs->children() as $qbxml)
		{
			QuickBooks_SQL_Schema::_transform('', $qbxml, $tables);
		}
		
		/*
		while (count($subtables) > 0)
		{
			$node = array_shift($subtables);
			
			$subsubtables = array();
			$tables[] = QuickBooks_SQL_Schema::_transform('', $node, $subsubtables);
			
			$subtables = array_merge($subtables, $subsubtables);
		}
		*/
		
		// The code below tries to guess as a good set of indexes to use for 
		//	any database tables we've generated from the schema. The code looks 
		//	at all of the fields in the table and if any of them are *ListID or 
		//	*TxnID it makes them indexes. 
		
		// This is a list of field names that will *always* be assigned 
		//	indexes, regardless of what table they are in
		$always_index_fields = array(
			'qbsql_external_id', 
			'Name', 
			'FullName', 
			'EntityType', 
			'TxnType', 
			'Email', 
			//'Phone', 
			'IsActive', 
			'RefNumber', 
			//'Address_City', 
			//'Address_State', 
			'Address_Country', 
			//'Address_PostalCode', 
			//'BillAddress_City', 
			//'BillAddress_State', 
			'BillAddress_Country', 
			//'BillAddress_PostalCode', 
			//'ShipAddress_City', 
			//'ShipAddress_State', 
			'ShipAddress_Country', 
			//'ShipAddress_PostalCode', 
			'CompanyName', 
			//'FirstName', 
			'LastName', 
			//'Contact', 
			'TxnDate', 
			'IsPaid', 
			'IsPending', 
			'IsManuallyClosed', 
			'IsFullyReceived', 
			'IsToBePrinted', 
			'IsToBeEmailed', 
			'IsFullyInvoiced', 
			//'IsFinanceCharge', 
			);
		
		// This is a list of table.field names that will be assigned indexes 
		$always_index_tablefields = array(
			//'Account.AccountType', 
			);
		
		/*
		'*FullName', 
		'*ListID', 
		'*TxnID', 
		'*EntityType', 
		'*TxnType', 
		'*LineID', 
		*/
		
		foreach ($tables as $table => $tabledef)
		{
			$uniques = array();
			$indexes = array();
			
			foreach ($tabledef[1] as $field => $fielddef)
			{
				if ($field == 'ListID' or 		// Unique keys
					$field == 'TxnID' or 
					$field == 'Name')
				{
					// We can't apply indexes to TEXT columns, so we need to 
					//	check and make sure the column isn't of type TEXT 
					//	before we decide to use this as an index
					
					if ($fielddef[0] != QUICKBOOKS_DRIVER_SQL_TEXT)
					{
						$uniques[] = $field;
					}
				}
				else if (substr($field, -6, 6) == 'ListID' or 		// Other things we should index for performance
					substr($field, -5, 5) == 'TxnID' or 
					substr($field, -6, 6) == 'LineID' or 
					in_array($field, $always_index_fields) or 
					in_array($table . '.' . $field, $always_index_tablefields))
				{
					// We can't apply indexes to TEXT columns, so we need to 
					//	check and make sure the column isn't of type TEXT 
					//	before we decide to use this as an index
					
					if ($fielddef[0] != QUICKBOOKS_DRIVER_SQL_TEXT)
					{
						$indexes[] = $field;
					}
				}
			}
			
			//print_r($indexes);
			//print_r($uniques);
			
			$tables[$table][3] = $indexes;
			$tables[$table][4] = $uniques;
		}
		
		return true;
	}
	
	/**
	 * Transform an XML document into an SQL schema
	 * 
	 * @param string $curpath
	 * @param QuickBooks_XML_Node $node
	 * @param array $tables
	 * @return 
	 */
	static protected function _transform($curpath, $node, &$tables)
	{
		print('' . $curpath . '   node: ' . $node->name() . "\n");
		
		$table = '';
		$field = '';
		
		$this_sql = array();
		$other_sql = array();
		QuickBooks_SQL_Schema::mapToSchema($curpath . ' ' . $node->name(), QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $this_sql, $other_sql);
		
		foreach (array_merge(array( $this_sql ), $other_sql) as $sql)
		{
			$table = $sql[0];
			$field = $sql[1];
			
			/*
			if (!$sql[0] or !$sql[1])
			{
				print('		table for node: ' . $sql[0] . "\n");
				print('		field for node: ' . $sql[1] . "\n");
			}
			else
			{
				print("\n");
			}
			*/
			
			if ($table)
			{
				if (!isset($tables[$table]))
				{
					$tables[$table] = array(
						0 => $table, 
						1 => array(),		// fields
						2 => null, 			// primary key
						3 => array(), 		// other keys
						4 => array(  ), 		// uniques
						);
				}
			}
			
			if ($table and $field)
			{
				if (!isset($tables[$table][1][$field]))
				{
					$tables[$table][1][$field] = QuickBooks_SQL_Schema::mapFieldToSQLDefinition($table, $field, $node->data());
				}
			}
		}
		
		if ($node->childCount())
		{
			foreach ($node->children() as $child)
			{
				QuickBooks_SQL_Schema::_transform($curpath . ' ' . $node->name(), $child, $tables);
			}
		}
		
		return true;
	}
	
	/**
	 * Tell whether or not a string matches the given pattern (replacement for fnmatch(), which isn't available on some systems)
	 * 
	 * @param string $pattern		The pattern (use wild-cards like * and ?)
	 * @param string $str			The string to test
	 * @return boolean
	 */
	static protected function _fnmatch($pattern, $str)
	{
		return QuickBooks_Utilities::fnmatch($pattern, $str);
	}
	
	/**
	 * 
	 * 
	 * 
	 * 
	 */
	static public function mapIndexes($table)
	{
		
	}
	
	/**
	 * Tell the SQL primary key for a given XML path, or the XML path for a given table/field combination
	 * 
	 * @todo This should support the uppercase/lowercase table/field names option set (->_defaults() a generic method, everything calls it to get default options)
	 * 
	 * @param string $path_or_tablefield
	 * @param string $mode
	 * @param mixed $map					In SCHEMA_MAP_TO_SQL mode, this is set to a tuple containing the SQL table and SQL field name, in SQL_MAP_TO_SCHEMA mode this is set to the XML path
	 * @return void
	 */
	static public function mapPrimaryKey($path_or_tablefield, $mode, &$map, $options = array())
	{		
		static $xml_to_sql = array(
			'AccountRet' => 																			array( 'Account', 'ListID' ), 
			'AccountRet TaxLineInfoRet' => 																array( 'Account_TaxLineInfo', array( 'Account_ListID', 'TaxLineInfo_TaxLineID') ), 
			'AccountRet DataExtRet' => 																	array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'BillingRateRet' =>  																		array( 'BillingRate', 'ListID' ),
			'BillingRateRet BillingRatePerItemRet' => 													array( 'BillingRate_BillingRatePerItem', array( 'BillingRate_ListID', 'Item_ListID' ) ),		
			'BillPaymentCheckRet' => 																	array( 'BillPaymentCheck', 'TxnID' ),
			'BillPaymentCheckRet AppliedToTxnRet' => 													array( 'BillPaymentCheck_AppliedToTxn', array( 'ToTxnID', 'FromTxnID' ) ), 
			'BillPaymentCheckRet DataExtRet' => 														array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'BillPaymentCreditCardRet' => 																array( 'BillPaymentCreditCard', 'TxnID' ),
			'BillPaymentCreditCardRet AppliedToTxnRet' => 												array( 'BillPaymentCreditCard_AppliedToTxn', array( 'ToTxnID', 'FromTxnID' ) ), 
			'BillPaymentCreditCardRet DataExtRet' => 													array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'BillRet' => 																				array( 'Bill', 'TxnID' ),
			'BillRet LinkedTxn' => 																		array( 'Bill_LinkedTxn', array( 'ToTxnID', 'FromTxnID' ) ),
			'BillRet ExpenseLineRet' => 																array( 'Bill_ExpenseLine', array( 'Bill_TxnID', 'TxnLineID') ),  	
			'BillRet ItemLineRet' => 																	array( 'Bill_ItemLine', array( 'Bill_TxnID', 'TxnLineID' ) ),  	
			'BillRet ItemGroupLineRet' => 																array( 'Bill_ItemGroupLine', array( 'Bill_TxnID', 'TxnLineID' ) ), 
			'BillRet ItemGroupLineRet ItemLineRet' => 													array( 'Bill_ItemGroupLine_ItemLine', array( 'Bill_TxnID', 'Bill_ItemGroupLine_TxnLineID', 'TxnLineID' ) ), 	
			'BillRet DataExtRet' => 																	array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'BillToPayRet BillToPay' => 																array( 'BillToPay', 'TxnID' ), 
			'BillToPayRet CreditToApply' => 															array( 'CreditToApply', 'TxnID' ), 
			'BuildAssemblyRet' => 																		array( 'BuildAssembly', 'TxnID' ),  
			'ChargeRet' => 																				array( 'Charge', 'TxnID' ),  
			'ChargeRet DataExtRet' => 																	array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'CheckRet' => 																				array( 'Check', 'TxnID' ), 
			'CheckRet ExpenseLineRet' => 																array( 'Check_ExpenseLine', array( 'Check_TxnID', 'TxnLineID' ) ), 
			'CheckRet ItemLineRet' => 																	array( 'Check_ItemLine', array( 'Check_TxnID', 'TxnLineID' ) ), 
			'CheckRet ItemGroupLineRet' => 																array( 'Check_ItemGroupLine', array( 'Check_TxnID', 'TxnLineID' ) ), 
			'CheckRet ItemGroupLineRet ItemLineRet' => 													array( 'Check_ItemGroupLine_ItemLine', array( 'Check_TxnID', 'Check_ItemGroupLine_TxnLineID', 'TxnLineID' ) ),
			'CheckRet DataExtRet' => 																	array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'CheckRet LinkedTxn' => 																	array( 'Check_LinkedTxn', array( 'ToTxnID', 'FromTxnID' ) ), 
			'ClassRet' => 																				array( 'Class', 'ListID' ), 
			'CompanyRet' => 																			array( 'Company', 'CompanyName' ),  
			'CompanyRet SubscribedServices Services' =>													array( 'Company_SubscribedServices_Services', array('Company_CompanyName', 'Name') ),  
			'CompanyRet DataExtRet' => 																	array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'HostRet' => 																				array( 'Host', 'ProductName' ), 
			'PreferencesRet' => 																		array( 'Preferences', 'qbsql_external_id' ), 
			'CreditCardChargeRet' =>																	array( 'CreditCardCharge', 'TxnID' ),
			'CreditCardChargeRet ExpenseLineRet' =>														array( 'CreditCardCharge_ExpenseLine', array( 'CreditCardCharge_TxnID', 'TxnLineID' ) ),
			'CreditCardChargeRet ItemLineRet' =>														array( 'CreditCardCharge_ItemLine', array( 'CreditCardCharge_TxnID', 'TxnLineID' ) ),
			'CreditCardChargeRet ItemGroupLineRet' =>													array( 'CreditCardCharge_ItemGroupLine', array( 'CreditCardCharge_TxnID', 'TxnLineID' ) ),
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet' =>										array( 'CreditCardCharge_ItemGroupLine_ItemLine', array( 'CreditCardCharge_TxnID', 'CreditCardCharge_ItemGroupLine_TxnLineID', 'TxnLineID' ) ),
			'CreditCardChargeRet DataExtRet' => 														array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'CreditCardCreditRet' =>																	array( 'CreditCardCredit', 'TxnID' ),
			'CreditCardCreditRet ExpenseLineRet' =>														array( 'CreditCardCredit_ExpenseLine', array( 'CreditCardCredit_TxnID', 'TxnLineID' ) ),
			'CreditCardCreditRet ItemLineRet' =>														array( 'CreditCardCredit_ItemLine', array( 'CreditCardCredit_TxnID', 'TxnLineID' ) ),
			'CreditCardCreditRet ItemGroupLineRet' =>													array( 'CreditCardCredit_ItemGroupLine', array( 'CreditCardCredit_TxnID', 'TxnLineID' ) ),
			'CreditCardCreditRet ItemGroupLineRet ItemLineRet' =>										array( 'CreditCardCredit_ItemGroupLine_ItemLine', array( 'CreditCardCredit_TxnID', 'CreditCardCredit_ItemGroupLine_TxnLineID', 'TxnLineID' ) ),
			'CreditCardCreditRet DataExtRet' => 														array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'CreditMemoRet' => 																			array( 'CreditMemo', 'TxnID' ), 
			'CreditMemoRet CreditMemoLineRet' => 														array( 'CreditMemo_CreditMemoLine', array( 'CreditMemo_TxnID', 'TxnLineID' ) ), 
			'CreditMemoRet CreditMemoLineGroupRet' => 													array( 'CreditMemo_CreditMemoLineGroup', array( 'CreditMemo_TxnID', 'TxnLineID' ) ), 
			//'CreditMemoRet CreditMemoLineGroupRet ItemGroupRef' => 									array( null, null ), 
			//'CreditMemoRet CreditMemoLineGroupRet ItemGroupRef *' => 									array( 'CreditMemo_CreditMemoLineGroup', 'ItemGroup_*' ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet' => 								array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', array( 'CreditMemo_TxnID', 'CreditMemo_CreditMemoLineGroup_TxnLineID', 'TxnLineID' ) ), 
			'CreditMemoRet DataExtRet' => 																array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'CreditMemoRet CreditMemoLineGroupRet DataExtRet' => 										array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet DataExtRet' => 						array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'CreditMemoRet LinkedTxn' => 																array( 'CreditMemo_LinkedTxn', array( 'ToTxnID', 'FromTxnID' ) ), 
			'CustomerRet' => 																			array( 'Customer', 'ListID' ),
			'CustomerRet DataExtRet' => 																array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'CustomerMsgRet' => 																		array( 'CustomerMsg', 'ListID' ),
			'CustomerTypeRet' => 																		array( 'CustomerType', 'ListID' ),
			'CurrencyRet' => 																			array( 'Currency', 'ListID' ), 
			'DataExtDefRet' => 																			array( 'DataExtDef', 'DataExtName' ),
			'DataExtDefRet AssignToObject' => 															array( 'DataExtDef_AssignToObject', array( 'DataExtDef_DataExtName', 'AssignToObject' ) ),
			'DateDrivenTermsRet' => 																	array( 'DateDrivenTerms', 'ListID' ),
			'DepositRet' => 																			array( 'Deposit', 'TxnID' ), 
			'DepositRet DepositLineRet' => 																array( 'Deposit_DepositLine', array( 'Deposit_TxnID', 'TxnID' ) ), 
			'DepositRet DataExtRet' => 																	array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'EmployeeRet' => 																			array( 'Employee', 'ListID' ), 
			'EmployeeRet EmployeePayrollInfo Earnings' => 												array( 'Employee_Earnings', array( 'Employee_ListID', 'PayrollItemWage_ListID' ) ), 
			'EmployeeRet DataExtRet' => 																array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'EstimateRet' => 																			array( 'Estimate', 'TxnID' ), 
			'EstimateRet EstimateLineRet' => 															array( 'Estimate_EstimateLine', array( 'Estimate_TxnID', 'TxnLineID' ) ),  
			'EstimateRet EstimateLineRet DataExtRet' => 												array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'EstimateRet EstimateLineGroupRet' => 														array( 'Estimate_EstimateLineGroup', array( 'Estimate_TxnID', 'TxnLineID' ) ), 
			'EstimateRet EstimateLineGroupRet DataExtRet' => 											array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'EstimateRet EstimateLineGroupRet EstimateLineRet' => 										array( 'Estimate_EstimateLineGroup_EstimateLine', array( 'Estimate_TxnID', 'Estimate_EstimateLineGroup_TxnLineID', 'TxnLineID' ) ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet DataExtRet' => 							array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'EstimateRet LinkedTxn' => 																	array( 'Estimate_LinkedTxn', array( 'ToTxnID', 'FromTxnID' ) ), 		
			'EstimateRet DataExtRet' => 																array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'InventoryAdjustmentRet' => 																array( 'InventoryAdjustment', 'TxnID' ), 
			'InventoryAdjustmentRet InventoryAdjustmentLineRet' => 										array( 'InventoryAdjustment_InventoryAdjustmentLine', array( 'InventoryAdjustment_TxnID', 'TxnLineID' ) ), 
			'InventoryAdjustmentRet DataExtRet' => 														array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'InvoiceRet' => 																			array( 'Invoice', 'TxnID' ), 
			'InvoiceRet InvoiceLineRet' => 																array( 'Invoice_InvoiceLine', array( 'Invoice_TxnID', 'TxnLineID' ) ),  
			'InvoiceRet InvoiceLineRet DataExtRet' => 													array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'InvoiceRet InvoiceLineGroupRet' => 														array( 'Invoice_InvoiceLineGroup', array( 'Invoice_TxnID', 'TxnLineID' ) ), 
			'InvoiceRet InvoiceLineGroupRet DataExtRet' => 												array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet' => 											array( 'Invoice_InvoiceLineGroup_InvoiceLine', array( 'Invoice_TxnID', 'Invoice_InvoiceLineGroup_TxnLineID', 'TxnLineID' ) ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet DataExtRet' => 								array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),
			'InvoiceRet LinkedTxn' => 																	array( 'Invoice_LinkedTxn', array( 'ToTxnID', 'FromTxnID' ) ), 
			'InvoiceRet DataExtRet' => 																	array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemInventoryRet' => 																		array( 'ItemInventory', 'ListID' ), 
			'ItemInventoryRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemInventoryAssemblyRet' => 																array( 'ItemInventoryAssembly', 'ListID' ), 
			'ItemInventoryAssemblyRet ItemInventoryAssemblyLine' => 									array( 'ItemInventoryAssembly_ItemInventoryAssemblyLine', array( 'ItemInventoryAssembly_ListID', 'ItemInventory_ListID' ) ), 
			'ItemInventoryAssemblyRet DataExtRet' => 													array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemNonInventoryRet' => 																	array( 'ItemNonInventory', 'ListID' ), 
			'ItemNonInventoryRet DataExtRet' => 														array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemDiscountRet' => 																		array( 'ItemDiscount', 'ListID' ),
			'ItemDiscountRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemFixedAssetRet' => 																		array( 'ItemFixedAsset', 'ListID' ),
			'ItemFixedAssetRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemGroupRet' => 																			array( 'ItemGroup', 'ListID' ),
			'ItemGroupRet ItemGroupLine' => 															array( 'ItemGroup_ItemGroupLine', array( 'ItemGroup_ListID', 'Item_ListID' ) ),
			'ItemGroupRet DataExtRet' => 																array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemOtherChargeRet' => 																	array( 'ItemOtherCharge', 'ListID' ), 
			'ItemOtherChargeRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemPaymentRet' => 																		array( 'ItemPayment', 'ListID' ), 
			'ItemPaymentRet DataExtRet' => 																array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemReceiptRet' => 																		array( 'ItemReceipt', 'TxnID' ), 
			'ItemReceiptRet ExpenseLineRet' => 															array( 'ItemReceipt_ExpenseLine', array( 'ItemReceipt_TxnID', 'TxnLineID' ) ), 
			'ItemReceiptRet ItemLineRet' => 															array( 'ItemReceipt_ItemLine', array( 'ItemReceipt_TxnID', 'TxnLineID' ) ), 
			'ItemReceiptRet ItemGroupLineRet' => 														array( 'ItemReceipt_ItemGroupLine', array( 'ItemReceipt_TxnID', 'TxnLineID' ) ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet' => 											array( 'ItemReceipt_ItemGroupLine_ItemLine', array( 'ItemReceipt_TxnID', 'ItemReceipt_ItemGroupLine_TxnLineID', 'TxnLineID' ) ), 
			'ItemReceiptRet LinkedTxn' => 																array( 'ItemReceipt_LinkedTxn', array( 'ToTxnID', 'FromTxnID' ) ), 
			'ItemReceiptRet DataExtRet' => 																array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemSalesTaxRet' => 																		array( 'ItemSalesTax', 'ListID' ), 
			'ItemSalesTaxRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemSalesTaxGroupRet' => 																	array( 'ItemSalesTaxGroup', 'ListID' ), 
			'ItemSalesTaxGroupRet ItemSalesTaxRef' => 													array( 'ItemSalesTaxGroup_ItemSalesTax', array( 'ItemSalesTaxGroup_ListID', 'ListID' ) ), 
			'ItemSalesTaxGroupRet DataExtRet' => 														array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemServiceRet' => 																		array( 'ItemService', 'ListID' ), 
			'ItemServiceRet DataExtRet' => 																array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ItemSubtotalRet' => 																		array( 'ItemSubtotal', 'ListID' ),
			'ItemSubtotalRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'JobTypeRet' => 																			array( 'JobType', 'ListID' ),
			'JournalEntryRet' => 																		array( 'JournalEntry', 'TxnID' ),
			'JournalEntryRet JournalCreditLine' => 														array( 'JournalEntry_JournalCreditLine', array( 'JournalEntry_TxnID', 'TxnLineID' ) ),
			'JournalEntryRet JournalDebitLine' => 														array( 'JournalEntry_JournalDebitLine', array( 'JournalEntry_TxnID', 'TxnLineID' ) ),
			'JournalEntryRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'PaymentMethodRet' => 																		array( 'PaymentMethod', 'ListID' ),
			'PayrollItemWageRet' => 																	array( 'PayrollItemWage', 'ListID' ),
			'PriceLevelRet' => 																			array( 'PriceLevel', 'ListID' ),
			'PriceLevelRet PriceLevelPerItemRet' => 													array( 'PriceLevel_PriceLevelPerItem', array( 'PriceLevel_ListID', 'Item_ListID' ) ),
			'PurchaseOrderRet' =>																		array( 'PurchaseOrder', 'TxnID' ),
			'PurchaseOrderRet PurchaseOrderLineRet' =>													array( 'PurchaseOrder_PurchaseOrderLine', array( 'PurchaseOrder_TxnID', 'TxnLineID' ) ),
			'PurchaseOrderRet PurchaseOrderLineRet DataExtRet' => 										array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'PurchaseOrderRet PurchaseOrderLineGroupRet' =>												array( 'PurchaseOrder_PurchaseOrderLineGroup', array( 'PurchaseOrder_TxnID', 'TxnLineID' ) ),
			'PurchaseOrderRet PurchaseOrderLineGroupRet DataExtRet' => 									array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet' =>						array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', array( 'PurchaseOrder_TxnID', 'PurchaseOrder_PurchaseOrderLineGroup_TxnLineID', 'TxnLineID' ) ),
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet DataExtRet' => 			array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'PurchaseOrderRet LinkedTxn' => 															array( 'PurchaseOrder_LinkedTxn', array( 'ToTxnID', 'FromTxnID' ) ), 
			'PurchaseOrderRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'ReceivePaymentRet' => 																		array( 'ReceivePayment', 'TxnID' ),  			
			'ReceivePaymentRet AppliedToTxnRet' => 														array( 'ReceivePayment_AppliedToTxn', array( 'ToTxnID', 'FromTxnID' ) ), 
			'ReceivePaymentRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'SalesOrderRet' => 																			array( 'SalesOrder', 'TxnID' ),
			'SalesOrderRet SalesOrderLineRet' => 														array( 'SalesOrder_SalesOrderLine', array( 'SalesOrder_TxnID', 'TxnLineID' ) ),
			'SalesOrderRet SalesOrderLineRet DataExtRet' => 											array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'SalesOrderRet SalesOrderLineGroupRet' => 													array( 'SalesOrder_SalesOrderLineGroup', array( 'SalesOrder_TxnID', 'TxnLineID' ) ),
			'SalesOrderRet SalesOrderLineGroupRet DataExtRet' => 										array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet' => 								array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', array( 'SalesOrder_TxnID', 'SalesOrder_SalesOrderLineGroup_TxnLineID', 'TxnLineID' ) ),
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet DataExtRet' => 						array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'SalesOrderRet LinkedTxn' => 																array( 'SalesOrder_LinkedTxn', array( 'ToTxnID', 'FromTxnID' ) ), 	
			'SalesOrderRet DataExtRet' => 																array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'SalesReceiptRet' =>																		array( 'SalesReceipt', 'TxnID' ),
			'SalesReceiptRet SalesReceiptLineRet' =>													array( 'SalesReceipt_SalesReceiptLine', array( 'SalesReceipt_TxnID', 'TxnLineID' ) ),
			'SalesReceiptRet SalesReceiptLineRet DataExtRet' => 										array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'SalesReceiptRet SalesReceiptLineGroupRet' =>												array( 'SalesReceipt_SalesReceiptLineGroup', array( 'SalesReceipt_TxnID', 'TxnLineID' ) ),
			'SalesReceiptRet SalesReceiptLineGroupRet DataExtRet' => 									array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet' =>							array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', array( 'SalesReceipt_TxnID', 'SalesReceipt_SalesReceiptLineGroup_TxnLineID', 'TxnLineID' ) ),
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet DataExtRet' => 				array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'SalesReceiptRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'SalesRepRet' =>																			array( 'SalesRep', 'ListID' ),
			'SalesTaxCodeRet' =>																		array( 'SalesTaxCode', 'ListID' ),
			'ShipMethodRet' =>																			array( 'ShipMethod', 'ListID' ),
			'StandardTermsRet' => 																		array( 'StandardTerms', 'ListID' ),
			'TimeTrackingRet' => 																		array( 'TimeTracking', 'TxnID' ),  	
			'UnitOfMeasureSetRet' => 																	array( 'UnitOfMeasureSet', 'ListID' ),  	
			'UnitOfMeasureSetRet RelatedUnit' => 														array( 'UnitOfMeasureSet_RelatedUnit', array( 'UnitOfMeasureSet_ListID', 'Name' ) ),  	
			'UnitOfMeasureSetRet DefaultUnit' => 														array( 'UnitOfMeasureSet_DefaultUnit', array( 'UnitOfMeasureSet_ListID', 'UnitUsedFor' ) ),  		
			'VehicleRet' => 																			array( 'Vehicle', 'ListID' ),
			'VehicleMileageRet' => 																		array( 'VehicleMileage', 'TxnID' ), 
			'VendorRet' => 																				array( 'Vendor', 'ListID' ),  
			'VendorRet DataExtRet' => 																	array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'VendorCreditRet' => 																		array( 'VendorCredit', 'TxnID' ),  
			'VendorCreditRet ExpenseLineRet' => 														array( 'VendorCredit_ExpenseLine', array( 'VendorCredit_TxnID', 'TxnLineID' ) ),  
			'VendorCreditRet ItemLineRet' => 															array( 'VendorCredit_ItemLine', array( 'VendorCredit_TxnID', 'TxnLineID' ) ),  
			'VendorCreditRet ItemGroupLineRet' => 														array( 'VendorCredit_ItemGroupLine', array( 'VendorCredit_TxnID', 'TxnLineID' ) ),  
			'VendorCreditRet ItemGroupLineRet ItemLineRet' => 											array( 'VendorCredit_ItemGroupLine_ItemLine', array( 'VendorCredit_TxnID', 'VendorCredit_ItemGroupLine_TxnLineID', 'TxnLineID' ) ),  
			'VendorCreditRet LinkedTxn' => 																array( 'VendorCredit_LinkedTxn', array( 'ToTxnID', 'FromTxnID' ) ), 
			'VendorCreditRet DataExtRet' => 															array( 'DataExt', array( 'EntityType', 'TxnType', 'Entity_ListID', 'Txn_TxnID' ) ),	
			'VendorTypeRet' => 																			array( 'VendorType', 'ListID' ),  
			'WorkersCompCodeRet' => 																	array( 'WorkersCompCode', 'ListID' ),  
				
			);
			
		if ($mode == QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL)
		{
			if (!isset($xml_to_sql[$path_or_tablefield]))
			{
				if (substr($path_or_tablefield, -3, 3) != 'Ret')
				{
					//$path_or_tablefield = substr($path_or_tablefield, 0, -3);
					$path_or_tablefield .= 'Ret';
					
					if (isset($xml_to_sql[$path_or_tablefield]))
					{
						$map = $xml_to_sql[$path_or_tablefield];
						QuickBooks_SQL_Schema::_applyOptions($map, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $options);
					}
				}
			}
			else
			{
				$map = $xml_to_sql[$path_or_tablefield];
				QuickBooks_SQL_Schema::_applyOptions($map, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $options);
			}
		}
		else
		{
			
		}
		
		return;
	}
	
	/**
	 * Map an XML node path to an SQL table/field OR map an SQL table/field to an XML node path
	 * 
	 * @param string $path			The XML path *or* 
	 * @param char $mode
	 * @param array $map
	 * @return void
	 */
	static public function mapToSchema($path_or_tablefield, $mode, &$map, &$others, $options = array())
	{
		static $xml_to_sql = array(
			'AccountRet' => 							array( 'Account', null ), 
			'AccountRet ParentRef' => 					array( null, null ), 
			'AccountRet ParentRef *' => 				array( 'Account', 'Parent_*' ), 
			'AccountRet TaxLineInfoRet' => 				array( 'Account_TaxLineInfo', null ), 
			//'AccountRet TaxLineInfoRet TaxLineID' => 	array( 'Account_TaxLineInfo', 'TaxLineInfo_TaxLineID' ), 
			'AccountRet TaxLineInfoRet *' => 			array( 'Account_TaxLineInfo', 'TaxLineInfo_*' ),  
			//'AccountRet DataExtRet' => 				array( null, null ), 
			//'AccountRet DataExtRet *' => 				array( 'DataExt', '*' ), 
			'AccountRet Desc' => 						array( 'Account', 'Descrip' ),
			
			'AccountRet DataExtRet' => 					array( 'DataExt', null ), 
			'AccountRet DataExtRet *' => 				array( 'DataExt', '*' ), 
			
			'AccountRet *' => 							array( 'Account', '*' ),  
			
			'BillingRateRet' => 									array( 'BillingRate', null ),
			'BillingRateRet BillingRatePerItemRet' => 				array( null, null ),
			'BillingRateRet BillingRatePerItemRet ItemRef' => 		array( null, null ), 
			'BillingRateRet BillingRatePerItemRet ItemRef *' => 	array( 'BillingRate_BillingRatePerItem', 'Item_*' ), 
			'BillingRateRet BillingRatePerItemRet *' => 			array( 'BillingRate_BillingRatePerItem', '*' ),  
			'BillingRateRet *' => 									array( 'BillingRate', '*' ), 
			
			'BillPaymentRet' => 									array( 'BillPayment', null ), 
			'BillPaymentRet *' => 									array( 'BillPayment', '*' ), 
			
			'BillPaymentCheckRet' => 										array( 'BillPaymentCheck', null ),
			
			'BillPaymentCheckRet PayeeEntityRef' => 						array( null, null ), 
			'BillPaymentCheckRet PayeeEntityRef *' =>						array( 'BillPaymentCheck', 'PayeeEntity_*' ), 
			'BillPaymentCheckRet APAccountRef' => 							array( null, null ), 
			'BillPaymentCheckRet APAccountRef *' => 						array( 'BillPaymentCheck', 'APAccount_*' ), 
			'BillPaymentCheckRet BankAccountRef' =>							array( null, null ), 
			'BillPaymentCheckRet BankAccountRef *' => 						array( 'BillPaymentCheck', 'BankAccount_*' ), 
			'BillPaymentCheckRet Address' => 								array( null, null ), 
			'BillPaymentCheckRet Address *' => 								array( 'BillPaymentCheck', 'Address_*' ), 
			'BillPaymentCheckRet AddressBlock' => 							array( null, null ), 
			'BillPaymentCheckRet AddressBlock *' => 						array( 'BillPaymentCheck', 'AddressBlock_*' ), 
			'BillPaymentCheckRet AppliedToTxnRet' => 						array( null, null ), 
			'BillPaymentCheckRet AppliedToTxnRet TxnID' => 					array( 'BillPaymentCheck_AppliedToTxn', 'ToTxnID' ), 
			'BillPaymentCheckRet AppliedToTxnRet DiscountAccountRef' => 	array( null, null ), 
			'BillPaymentCheckRet AppliedToTxnRet DiscountAccountRef *' => 	array( 'BillPaymentCheck_AppliedToTxn', 'DiscountAccount_*' ), 
			'BillPaymentCheckRet AppliedToTxnRet *' => 						array( 'BillPaymentCheck_AppliedToTxn', '*' ), 
			'BillPaymentCheckRet DataExtRet' => 							array( 'DataExt', null ), 
			'BillPaymentCheckRet DataExtRet *' => 							array( 'DataExt', '*' ),  
			'BillPaymentCheckRet *' => 										array( 'BillPaymentCheck', '*' ), 
			
			'BillPaymentCreditCardRet' => 										array( 'BillPaymentCreditCard', null ), 
			
			'BillPaymentCreditCardRet PayeeEntityRef' => 						array( null, null ), 
			'BillPaymentCreditCardRet PayeeEntityRef *' => 						array( 'BillPaymentCreditCard', 'PayeeEntity_*' ), 
			'BillPaymentCreditCardRet APAccountRef' => 							array( null, null ), 
			'BillPaymentCreditCardRet APAccountRef *' => 						array( 'BillPaymentCreditCard', 'APAccount_*' ), 
			'BillPaymentCreditCardRet CreditCardAccountRef' => 					array( null, null ), 
			'BillPaymentCreditCardRet CreditCardAccountRef *' => 				array( 'BillPaymentCreditCard', 'CreditCardAccount_*' ), 
			'BillPaymentCreditCardRet AppliedToTxnRet' => 						array( null, null ), 
			'BillPaymentCreditCardRet AppliedToTxnRet TxnID' => 				array( 'BillPaymentCreditCard_AppliedToTxn', 'ToTxnID' ), 
			'BillPaymentCreditCardRet AppliedToTxnRet DiscountAccountRef' => 	array( null, null ), 
			'BillPaymentCreditCardRet AppliedToTxnRet DiscountAccountRef *' => 	array( 'BillPaymentCreditCard_AppliedToTxn', 'DiscountAccount_*' ), 
			'BillPaymentCreditCardRet AppliedToTxnRet *' => 					array( 'BillPaymentCreditCard_AppliedToTxn', '*' ), 
			'BillPaymentCreditCardRet DataExtRet' => 							array( 'DataExt', null ), 
			'BillPaymentCreditCardRet DataExtRet *' => 							array( 'DataExt', '*' ), 
			
			'BillPaymentCreditCardRet *' => 									array( 'BillPaymentCreditCard', '*' ), 
			
			'BillRet' => 												array( 'Bill', null ),
			'BillRet VendorRef' => 										array( null, null ), 
			'BillRet VendorRef *' => 									array( 'Bill', 'Vendor_*' ), 
			'BillRet APAccountRef' => 									array( null, null ), 
			'BillRet APAccountRef *' => 								array( 'Bill', 'APAccount_*' ),
			'BillRet TermsRef' => 										array( null, null ), 
			'BillRet TermsRef *' => 									array( 'Bill', 'Terms_*' ),  
			'BillRet CurrencyRef' => 									array( null, null ), 
			'BillRet CurrencyRef *' => 									array( 'Bill', 'Currency_*' ), 			
			'BillRet LinkedTxn' => 										array( null, null ), 
			'BillRet LinkedTxn TxnID' => 								array( 'Bill_LinkedTxn', 'ToTxnID' ),
			'BillRet LinkedTxn *' => 									array( 'Bill_LinkedTxn', '*' ), 
			'BillRet ExpenseLineRet' => 								array( null, null ), 
			'BillRet ExpenseLineRet AccountRef' => 						array( null, null ), 
			'BillRet ExpenseLineRet AccountRef *' => 					array( 'Bill_ExpenseLine', 'Account_*' ), 
			'BillRet ExpenseLineRet CustomerRef' => 					array( null, null ), 
			'BillRet ExpenseLineRet CustomerRef *' =>					array( 'Bill_ExpenseLine', 'Customer_*' ), 
			'BillRet ExpenseLineRet ClassRef' => 						array( null, null ), 
			'BillRet ExpenseLineRet ClassRef *' => 						array( 'Bill_ExpenseLine', 'Class_*' ), 
			'BillRet ExpenseLineRet *' => 								array( 'Bill_ExpenseLine', '*' ), 
			'BillRet ItemLineRet' => 									array( null, null ), 
			'BillRet ItemLineRet ItemRef' => 							array( null, null ), 
			'BillRet ItemLineRet ItemRef *' => 							array( 'Bill_ItemLine', 'Item_*' ), 
			'BillRet ItemLineRet CustomerRef' => 						array( null, null ), 
			'BillRet ItemLineRet CustomerRef *' => 						array( 'Bill_ItemLine', 'Customer_*' ), 
			'BillRet ItemLineRet ClassRef' => 							array( null, null ), 
			'BillRet ItemLineRet ClassRef *' => 						array( 'Bill_ItemLine', 'Class_*' ), 
			'BillRet ItemLineRet Desc' => 								array( 'Bill_ItemLine', 'Descrip' ), 
			'BillRet ItemLineRet *' => 									array( 'Bill_ItemLine', '*' ), 
			'BillRet ItemGroupLineRet' => 								array( null, null ), 
			'BillRet ItemGroupLineRet ItemGroupRef' => 					array( null, null ), 
			'BillRet ItemGroupLineRet ItemGroupRef *' => 				array( 'Bill_ItemGroupLine', 'ItemGroup_*' ), 
			'BillRet ItemGroupLineRet Desc' => 							array( 'Bill_ItemGroupLine', 'Descrip' ), 
			'BillRet ItemGroupLineRet ItemLineRet' => 					array( null, null ), 
			'BillRet ItemGroupLineRet ItemLineRet ItemRef' => 			array( null, null ), 
			'BillRet ItemGroupLineRet ItemLineRet ItemRef *' => 		array( 'Bill_ItemGroupLine_ItemLine', 'Item_*' ), 
			'BillRet ItemGroupLineRet ItemLineRet Desc' => 				array( 'Bill_ItemGroupLine_ItemLine', 'Descrip' ), 
			'BillRet ItemGroupLineRet ItemLineRet CustomerRef' => 		array( null, null ), 
			'BillRet ItemGroupLineRet ItemLineRet CustomerRef *' => 	array( 'Bill_ItemGroupLine_ItemLine', 'Customer_*' ), 
			'BillRet ItemGroupLineRet ItemLineRet ClassRef' => 			array( null, null ), 
			'BillRet ItemGroupLineRet ItemLineRet ClassRef *' => 		array( 'Bill_ItemGroupLine_ItemLine', 'Class_*' ), 
			'BillRet ItemGroupLineRet ItemLineRet *' => 				array( 'Bill_ItemGroupLine_ItemLine', '*' ), 
			'BillRet ItemGroupLineRet *' => 							array( 'Bill_ItemGroupLine', '*' ), 
			'BillRet DataExtRet' => 									array( 'DataExt', null ), 
			'BillRet DataExtRet *' => 									array( 'DataExt', '*' ), 
			
			'BillRet *' => 												array( 'Bill', '*' ), 
			
			'BillToPayRet' => 									array( 'BillToPay', null ), 
			'BillToPayRet BillToPay' => 						array( null, null ), 
			'BillToPayRet BillToPay APAccountRef' => 			array( null, null ), 
			'BillToPayRet BillToPay APAccountRef *' => 			array( 'BillToPay', 'APAccount_*' ), 
			'BillToPayRet BillToPay *' => 						array( 'BillToPay', '*' ), 
			'BillToPayRet CreditToApply' => 					array( null, null ), 
			'BillToPayRet CreditToApply APAccountRef' => 		array( null, null ), 
			'BillToPayRet CreditToApply APAccountRef *' => 		array( 'CreditToApply', 'APAccount_*' ), 
			'BillToPayRet CreditToApply *' => 					array( 'CreditToApply', '*' ), 
			'BillToPayRet *' => 								array( null, null ), 
			
			'ChargeRet' => 							array( 'Charge', null ), 
			'ChargeRet CustomerRef' => 				array( null, null ), 
			'ChargeRet CustomerRef *' => 			array( 'Charge', 'Customer_*' ), 
			'ChargeRet ItemRef' => 					array( null, null ), 
			'ChargeRet ItemRef *' => 				array( 'Charge', 'Item_*' ), 
			'ChargeRet OverrideUOMSetRef' => 		array( null, null ), 
			'ChargeRet OverrideUOMSetRef *' => 		array( 'Charge', 'OverrideUOMSet_*' ), 
			'ChargeRet Desc' => 					array( 'Charge', 'Descrip' ), 
			'ChargeRet ARAccountRef' => 			array( null, null ), 
			'ChargeRet ARAccountRef *' => 			array( 'Charge', 'ARAccount_*' ), 
			'ChargeRet ClassRef' => 				array( null, null ), 
			'ChargeRet ClassRef *' => 				array( 'Charge', 'Class_*' ), 
			'ChargeRet DataExtRet' => 				array( 'DataExt', null ), 
			'ChargeRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			'ChargeRet *' => 						array( 'Charge', '*' ), 
			
			'CheckRet' => 														array( 'Check', null ), 
			'CheckRet AccountRef' => 											array( null, null ), 
			'CheckRet AccountRef *' => 											array( 'Check', 'Account_*' ), 
			'CheckRet PayeeEntityRef' => 										array( null, null ), 
			'CheckRet PayeeEntityRef *' => 										array( 'Check', 'PayeeEntityRef_*' ), 
			'CheckRet AddressBlock' => 											array( null, null ), 
			'CheckRet AddressBlock *' => 										array( 'Check', 'AddressBlock_*' ),
			'CheckRet Address' => 												array( null, null ), 
			'CheckRet Address *' => 											array( 'Check', 'Address_*' ),
			'CheckRet CurrencyRef' => 											array( null, null ), 
			'CheckRet CurrencyRef *' => 										array( 'Check', 'Currency_*' ), 			
			'CheckRet LinkedTxn' => 											array( null, null ), 
			'CheckRet LinkedTxn TxnID' => 										array( 'Check_LinkedTxn', 'ToTxnID' ),
			'CheckRet LinkedTxn *' => 											array( 'Check_LinkedTxn', '*' ), 
			'CheckRet ExpenseLineRet' => 										array( null, null ), 
			'CheckRet ExpenseLineRet AccountRef' => 							array( null, null ), 
			'CheckRet ExpenseLineRet AccountRef *' => 							array( 'Check_ExpenseLine', 'Account_*' ), 
			'CheckRet ExpenseLineRet CustomerRef' => 							array( null, null ), 
			'CheckRet ExpenseLineRet CustomerRef *' => 							array( 'Check_ExpenseLine', 'Customer_*' ), 
			'CheckRet ExpenseLineRet ClassRef' => 								array( null, null ), 
			'CheckRet ExpenseLineRet ClassRef *' => 							array( 'Check_ExpenseLine', 'Class_*' ), 
			'CheckRet ExpenseLineRet *' => 										array( 'Check_ExpenseLine', '*' ), 
			'CheckRet ItemLineRet' => 											array( null, null ), 
			'CheckRet ItemLineRet ItemRef' => 									array( null, null ), 
			'CheckRet ItemLineRet ItemRef *' => 								array( 'Check_ItemLine', 'Item_*' ), 
			'CheckRet ItemLineRet OverrideUOMSetRef' => 						array( null, null ), 
			'CheckRet ItemLineRet OverrideUOMSetRef *' => 						array( 'Check_ItemLine', 'OverrideUOMSet_*' ), 
			'CheckRet ItemLineRet CustomerRef' => 								array( null, null ), 
			'CheckRet ItemLineRet CustomerRef *' => 							array( 'Check_ItemLine', 'Customer_*' ),
			'CheckRet ItemLineRet ClassRef' => 									array( null, null ), 
			'CheckRet ItemLineRet ClassRef *' => 								array( 'Check_ItemLine', 'Class_*' ),
			'CheckRet ItemLineRet Desc' => 										array( 'Check_ItemLine', 'Descrip' ), 
			'CheckRet ItemLineRet *' => 										array( 'Check_ItemLine', '*' ), 
			'CheckRet ItemGroupLineRet' => 										array( null, null ), 
			'CheckRet ItemGroupLineRet ItemGroupRef' => 						array( null, null ), 
			'CheckRet ItemGroupLineRet ItemGroupRef *' => 						array( 'Check_ItemGroupLine', 'ItemGroup_*' ), 
			'CheckRet ItemGroupLineRet Desc' => 								array( 'Check_ItemGroupLine', 'Descrip' ), 
			'CheckRet ItemGroupLineRet OverrideUOMSetRef' => 					array( null, null ), 
			'CheckRet ItemGroupLineRet OverrideUOMSetRef *' => 					array( 'Check_ItemGroupLine', 'OverrideUOMSet_*' ), 
			'CheckRet ItemGroupLineRet ItemLineRet' => 							array( null, null ), 
			'CheckRet ItemGroupLineRet ItemLineRet ItemRef' => 					array( null, null ), 
			'CheckRet ItemGroupLineRet ItemLineRet ItemRef *' => 				array( 'Check_ItemGroupLine_ItemLine', 'Item_*' ), 
			'CheckRet ItemGroupLineRet ItemLineRet Desc' => 					array( 'Check_ItemGroupLine_ItemLine', 'Descrip' ), 
			'CheckRet ItemGroupLineRet ItemLineRet OverrideUOMSetRef' => 		array( null, null ), 
			'CheckRet ItemGroupLineRet ItemLineRet OverrideUOMSetRef *' => 		array( 'Check_ItemGroupLine_ItemLine', 'OverrideUOMSet_*' ), 
			'CheckRet ItemGroupLineRet ItemLineRet CustomerRef' => 				array( null, null ), 
			'CheckRet ItemGroupLineRet ItemLineRet CustomerRef *' => 			array( 'Check_ItemGroupLine_ItemLine', 'Customer_*' ), 
			'CheckRet ItemGroupLineRet ItemLineRet ClassRef' => 				array( null, null ), 
			'CheckRet ItemGroupLineRet ItemLineRet ClassRef *' => 				array( 'Check_ItemGroupLine_ItemLine', 'Class_*' ), 
			'CheckRet ItemGroupLineRet ItemLineRet *' => 						array( 'Check_ItemGroupLine_ItemLine', '*' ),  
			'CheckRet ItemGroupLineRet *' => 									array( 'Check_ItemGroupLine', '*' ), 
			'CheckRet DataExtRet' => 											array( null, null ), 
			'CheckRet DataExtRet *' => 											array( 'DataExt', '*' ),  
			'CheckRet *' => 													array( 'Check', '*' ), 
			
			'ClassRet' => 									array( 'Class', null ), 
			'ClassRet ParentRef' => 						array( null, null ), 
			'ClassRet ParentRef *' => 						array( 'Class', 'Parent_*' ),
			
			'ClassRet *' => 								array( 'Class', '*' ), 
			
			'CompanyRet' => 									array( 'Company', null ), 
			'CompanyRet Address' => 							array( null, null ), 
			'CompanyRet Address *' => 							array( 'Company', 'Address_*' ), 
			'CompanyRet AddressBlock' => 						array( null, null ), 
			'CompanyRet AddressBlock *' => 						array( 'Company', 'AddressBlock_*' ), 
			'CompanyRet LegalAddress' => 						array( null, null ), 
			'CompanyRet LegalAddress *' => 						array( 'Company', 'LegalAddress_*' ), 
			'CompanyRet CompanyAddressForCustomer' => 			array( null, null ), 
			'CompanyRet CompanyAddressForCustomer *' => 		array( 'Company', 'Company_CompanyAddressForCustomer_*' ), 
			'CompanyRet CompanyAddressBlockForCustomer' => 		array( null, null ), 
			'CompanyRet CompanyAddressBlockForCustomer *' => 	array( 'Company', 'Company_CompanyAddressBlockForCustomer_*' ), 
			
			'CompanyRet SubscribedServices' => 				array( null, null ), 
			'CompanyRet SubscribedServices Service' => 		array( null, null ), 
			'CompanyRet SubscribedServices Service *' => 	array( 'Company_SubscribedServices_Service', '*' ), 
			'CompanyRet SubscribedServices *' => 			array( 'Company', 'SubscribedServices_*' ), 
			
			'CompanyRet DataExtRet' => 						array( null, null ), 
			'CompanyRet DataExtRet *' => 					array( 'DataExt', '*' ), 
			
			'CompanyRet *' => 								array( 'Company', '*' ), 
			
			'CurrencyRet' => 								array( 'Currency', null ),
			
			'CurrencyRet CurrencyFormat' => 				array( null, null ), 
			'CurrencyRet CurrencyFormat *' => 				array( 'Currency', 'Currency_CurrencyFormat_*' ), 
			
			'CurrencyRet *' => 								array( 'Currency', '*' ),  
			
			'HostRet' => 									array( 'Host', null ), 
			'HostRet *' => 									array( 'Host', '*' ), 
			
			
			'PreferencesRet' => 							array( 'Preferences', null ), 
			
			'PreferencesRet AccountingPreferences' => 		array( null, null ), 
			'PreferencesRet AccountingPreferences *' => 	array( 'Preferences', 'AccountingPrefs_*' ), 
			
			'PreferencesRet FinanceChargePreferences' => 	array( null, null ), 
			
			'PreferencesRet FinanceChargePreferences FinanceChargeAccountRef' => array( null, null ), 
			'PreferencesRet FinanceChargePreferences FinanceChargeAccountRef *' => array( 'Preferences', 'FinanceChargePrefs_FinanceChargeAccount_*' ), 
			
			'PreferencesRet FinanceChargePreferences *' => 	array( 'Preferences', 'FinanceChargePrefs_*' ), 
			
			'PreferencesRet JobsAndEstimatesPreferences' => array( null, null ), 
			'PreferencesRet JobsAndEstimatesPreferences *' => array( 'Preferences', 'JobsAndEstimatesPrefs_*' ), 
			
			'PreferencesRet MultiCurrencyPreferences' => 	array( null, null ), 
			'PreferencesRet MultiCurrencyPreferences HomeCurrencyRef' => array( null, null ), 
			'PreferencesRet MultiCurrencyPreferences HomeCurrencyRef *' => array( 'Preferences', 'MultiCurrencyPrefs_HomeCurrency_*' ), 
			'PreferencesRet MultiCurrencyPreferences *' => 	array( 'Preferences', 'MultiCurrencyPrefs_*' ), 
			
			'PreferencesRet MultiLocationInventoryPreferences' => array( null, null ), 
			'PreferencesRet MultiLocationInventoryPreferences *' => array( 'Preferences', 'MultiLocationInventoryPrefs_*' ), 
			
			'PreferencesRet PurchasesAndVendorsPreferences' => array( null, null ), 
			'PreferencesRet PurchasesAndVendorsPreferences DefaultDiscountAccountRef' => array( null, null ), 
			'PreferencesRet PurchasesAndVendorsPreferences DefaultDiscountAccountRef *' => array( 'Preferences', 'PurchasesAndVendorsPrefs_DefaultDiscountAccount_*' ), 
			'PreferencesRet PurchasesAndVendorsPreferences *' => array( 'Preferences', 'PurchasesAndVendorsPrefs_*' ), 
			
			'PreferencesRet ReportsPreferences' => 			array( null, null ), 
			'PreferencesRet ReportsPreferences *' => 		array( 'Preferences', 'ReportsPrefs_*' ), 
			
			'PreferencesRet SalesAndCustomersPreferences' => array( null, null ), 
			'PreferencesRet SalesAndCustomersPreferences DefaultShipMethodRef' => array( null, null ), 
			'PreferencesRet SalesAndCustomersPreferences DefaultShipMethodRef *' => array( 'Preferences', 'SalesAndCustomersPrefs_DefaultShipMethod_*' ),
			'PreferencesRet SalesAndCustomersPreferences PriceLevels' => array( null, null ), 
			'PreferencesRet SalesAndCustomersPreferences PriceLevels *' => array( 'Preferences', 'SalesAndCustomersPrefs_PriceLevels_*' ),
			'PreferencesRet SalesAndCustomersPreferences *' => array( 'Preferences', 'SalesAndCustomersPrefs_*' ), 
			
			'PreferencesRet SalesTaxPreferences' => 		array( null, null ), 
			'PreferencesRet SalesTaxPreferences DefaultItemSalesTaxRef' => array( null, null ), 
			'PreferencesRet SalesTaxPreferences DefaultItemSalesTaxRef *' => array( 'Preferences', 'SalesTaxPrefs_DefaultItemSalesTax_*' ),
			'PreferencesRet SalesTaxPreferences DefaultTaxableSalesTaxCodeRef' => array( null, null ), 
			'PreferencesRet SalesTaxPreferences DefaultTaxableSalesTaxCodeRef *' => array( 'Preferences', 'SalesTaxPrefs_DefaultTaxableSalesTaxCode_*' ),
			'PreferencesRet SalesTaxPreferences DefaultNonTaxableSalesTaxCodeRef' => array( null, null ), 
			'PreferencesRet SalesTaxPreferences DefaultNonTaxableSalesTaxCodeRef *' => array( 'Preferences', 'SalesTaxPrefs_DefaultNonTaxableSalesTaxCode_*' ),
			'PreferencesRet SalesTaxPreferences *' => 		array( 'Preferences', 'SalesTaxPrefs_*' ), 
			
			'PreferencesRet TimeTrackingPreferences' => 	array( null, null ),  
			'PreferencesRet TimeTrackingPreferences *' => 	array( 'Preferences', 'TimeTrackingPrefs_*' ), 
			
			'PreferencesRet CurrentAppAccessRights' => 		array( null, null ), 
			'PreferencesRet CurrentAppAccessRights *' => 	array( 'Preferences', 'CurrentAppAccessRights_*' ), 
			
			'PreferencesRet *' => 							array( 'Preferences', '*' ), 
			
			
			'CreditCardChargeRet' => 						array( 'CreditCardCharge', null ),
			'CreditCardChargeRet AccountRef' => 			array( null, null ), 
			'CreditCardChargeRet AccountRef *' => 			array( 'CreditCardCharge', 'Account_*' ), 
			'CreditCardChargeRet PayeeEntityRef' => 		array( null, null ), 
			'CreditCardChargeRet PayeeEntityRef *' => 		array( 'CreditCardCharge', 'PayeeEntity_*' ), 			
			'CreditCardChargeRet CurrencyRef' => 			array( null, null ), 
			'CreditCardChargeRet CurrencyRef *' => 			array( 'CreditCardCharge', 'Currency_*' ), 			
			
			'CreditCardChargeRet ItemLineRet' => 							array( null, null ), 
			'CreditCardChargeRet ItemLineRet Desc' => 						array( 'CreditCardCharge_ItemLine', 'Descrip' ), 
			'CreditCardChargeRet ItemLineRet ItemRef' => 					array( null, null ), 
			'CreditCardChargeRet ItemLineRet ItemRef *' => 					array( 'CreditCardCharge_ItemLine', 'Item_*' ), 
			'CreditCardChargeRet ItemLineRet OverrideUOMSetRef' => 			array( null, null ), 
			'CreditCardChargeRet ItemLineRet OverrideUOMSetRef *' => 		array( 'CreditCardCharge_ItemLine', 'OverrideUOMSet_*' ), 
			'CreditCardChargeRet ItemLineRet CustomerRef' => 				array( null, null ), 
			'CreditCardChargeRet ItemLineRet CustomerRef *' => 				array( 'CreditCardCharge_ItemLine', 'Customer_*' ), 
			'CreditCardChargeRet ItemLineRet ClassRef' => 					array( null, null ), 
			'CreditCardChargeRet ItemLineRet ClassRef *' => 				array( 'CreditCardCharge_ItemLine', 'Class_*' ), 
			'CreditCardChargeRet ItemLineRet *' => 							array( 'CreditCardCharge_ItemLine', '*' ), 
			
			'CreditCardChargeRet ItemGroupLineRet' => 									array( null, null ), 
			'CreditCardChargeRet ItemGroupLineRet Desc' => 								array( 'CreditCardCharge_ItemGroupLine', 'Descrip' ), 
			'CreditCardChargeRet ItemGroupLineRet ItemGroupRef' => 						array( null, null ), 
			'CreditCardChargeRet ItemGroupLineRet ItemGroupRef *' => 					array( 'CreditCardCharge_ItemGroupLine', 'ItemGroup_*' ), 
			'CreditCardChargeRet ItemGroupLineRet OverrideUOMSetRef' => 				array( null, null ), 
			'CreditCardChargeRet ItemGroupLineRet OverrideUOMSetRef *' => 				array( 'CreditCardCharge_ItemGroupLine', 'OverrideUOMSet_*' ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet' => 						array( null, null ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet ItemRef' => 				array( null, null ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet ItemRef *' => 			array( 'CreditCardCharge_ItemGroupLine_ItemLine', 'Item_*' ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet Desc' => 					array( 'CreditCardCharge_ItemGroupLine_ItemLine', 'Descrip' ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet OverrideUOMSetRef' => 	array( null, null ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet OverrideUOMSetRef *' => 	array( 'CreditCardCharge_ItemGroupLine_ItemLine', 'OverrideUOMSet_*' ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet CustomerRef' => 			array( null, null ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet CustomerRef *' => 		array( 'CreditCardCharge_ItemGroupLine_ItemLine', 'Customer_*' ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet ClassRef' => 				array( null, null ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet ClassRef *' => 			array( 'CreditCardCharge_ItemGroupLine_ItemLine', 'Class_*' ), 
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet *' => 					array( 'CreditCardCharge_ItemGroupLine_ItemLine', '*' ), 
			'CreditCardChargeRet ItemGroupLineRet *' => 								array( 'CreditCardCharge_ItemGroupLine', '*' ), 
			
			'CreditCardChargeRet ExpenseLineRet' => 					array( null, null ), 
			'CreditCardChargeRet ExpenseLineRet AccountRef' => 			array( null, null ), 
			'CreditCardChargeRet ExpenseLineRet AccountRef *' => 		array( 'CreditCardCharge_ExpenseLine', 'Account_*' ), 
			'CreditCardChargeRet ExpenseLineRet CustomerRef' => 		array( null, null ), 
			'CreditCardChargeRet ExpenseLineRet CustomerRef *' => 		array( 'CreditCardCharge_ExpenseLine', 'Customer_*' ), 
			'CreditCardChargeRet ExpenseLineRet ClassRef' => 			array( null, null ), 
			'CreditCardChargeRet ExpenseLineRet ClassRef *' => 			array( 'CreditCardCharge_ExpenseLine', 'Class_*' ), 
			'CreditCardChargeRet ExpenseLineRet *' => 					array( 'CreditCardCharge_ExpenseLine', '*' ), 
			
			'CreditCardChargeRet DataExtRet' => 			array( null, null ), 
			'CreditCardChargeRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			'CreditCardChargeRet *' => 						array( 'CreditCardCharge', '*' ), 
			
			
			
			'CreditCardCreditRet' => 						array( 'CreditCardCredit', null ),
			'CreditCardCreditRet AccountRef' => 			array( null, null ), 
			'CreditCardCreditRet AccountRef *' => 			array( 'CreditCardCredit', 'Account_*' ), 
			'CreditCardCreditRet PayeeEntityRef' => 		array( null, null ), 
			'CreditCardCreditRet PayeeEntityRef *' => 		array( 'CreditCardCredit', 'PayeeEntity_*' ), 
			'CreditCardCreditRet CurrencyRef' => 			array( null, null ), 
			'CreditCardCreditRet CurrencyRef *' => 			array( 'CreditCardCredit', 'Currency_*' ), 
			
			'CreditCardCreditRet ExpenseLineRet' => 					array( null, null ),
			'CreditCardCreditRet ExpenseLineRet AccountRef' => 			array( null, null ), 
			'CreditCardCreditRet ExpenseLineRet AccountRef *' => 		array( 'CreditCardCredit_ExpenseLine', 'Account_*' ), 
			'CreditCardCreditRet ExpenseLineRet CustomerRef' => 		array( null, null ), 
			'CreditCardCreditRet ExpenseLineRet CustomerRef *' => 		array( 'CreditCardCredit_ExpenseLine', 'Customer_*' ), 
			'CreditCardCreditRet ExpenseLineRet ClassRef' => 			array( null, null ), 
			'CreditCardCreditRet ExpenseLineRet ClassRef *' => 			array( 'CreditCardCredit_ExpenseLine', 'Class_*' ), 
			'CreditCardCreditRet ExpenseLineRet *' => 					array( 'CreditCardCredit_ExpenseLine', '*' ), 
			
			'CreditCardCreditRet ItemLineRet' => 							array( null, null ),
			'CreditCardCreditRet ItemLineRet Desc' => 						array( 'CreditCardCredit_ItemLine', 'Descrip' ), 
			'CreditCardCreditRet ItemLineRet ItemRef' => 					array( null, null ), 
			'CreditCardCreditRet ItemLineRet ItemRef *' => 					array( 'CreditCardCredit_ItemLine', 'Item_*' ), 
			'CreditCardCreditRet ItemLineRet OverrideUOMSetRef' => 			array( null, null ), 
			'CreditCardCreditRet ItemLineRet OverrideUOMSetRef *' => 		array( 'CreditCardCredit_ItemLine', 'OverrideUOMSet_*' ), 
			'CreditCardCreditRet ItemLineRet CustomerRef' => 				array( null, null ), 
			'CreditCardCreditRet ItemLineRet CustomerRef *' => 				array( 'CreditCardCredit_ItemLine', 'Customer_*' ), 
			'CreditCardCreditRet ItemLineRet ClassRef' => 					array( null, null ), 
			'CreditCardCreditRet ItemLineRet ClassRef *' => 				array( 'CreditCardCredit_ItemLine', 'Class_*' ), 
			'CreditCardCreditRet ItemLineRet *' => 							array( 'CreditCardCredit_ItemLine', '*' ), 
			
			'CreditCardCreditRet ItemGroupLineRet' => 							array( null, null ),
			'CreditCardCreditRet ItemGroupLineRet Desc' => 						array( 'CreditCardCredit_ItemGroupLine', 'Descrip' ), 
			'CreditCardCreditRet ItemGroupLineRet ItemGroupRef' => 				array( null, null ), 
			'CreditCardCreditRet ItemGroupLineRet ItemGroupRef *' => 			array( 'CreditCardCredit_ItemGroupLine', 'ItemGroup_*' ), 
			'CreditCardCreditRet ItemGroupLineRet OverrideUOMSetRef' => 		array( null, null ), 
			'CreditCardCreditRet ItemGroupLineRet OverrideUOMSetRef *' => 		array( 'CreditCardCredit_ItemGroupLine', 'OverrideUOMSet_*' ), 
			'CreditCardCreditRet ItemGroupLineRet ItemLineRet' => 				array( null, null ), 
			'CreditCardCreditRet ItemGroupLineRet ItemLineRet Desc' => 			array( 'CreditCardCredit_ItemGroupLine_ItemLine', 'Descrip' ), 
			'CreditCardCreditRet ItemGroupLineRet ItemLineRet *' => 			array( 'CreditCardCredit_ItemGroupLine_ItemLine', '*' ), 
			'CreditCardCreditRet ItemGroupLineRet *' => 						array( 'CreditCardCredit_ItemGroupLine', '*' ), 
			
			'CreditCardCreditRet DataExtRet' => 				array( null, null ), 
			'CreditCardCreditRet DataExtRet *' => 				array( 'DataExt', '*' ), 
			
			'CreditCardCreditRet *' => 							array( 'CreditCardCredit', '*' ), 
			
			'CreditMemoRet' => 									array( 'CreditMemo', null ),
			'CreditMemoRet CustomerRef' => 						array( null, null ), 
			'CreditMemoRet CustomerRef *' => 					array( 'CreditMemo', 'Customer_*' ), 
			'CreditMemoRet ClassRef' => 						array( null, null ), 
			'CreditMemoRet ClassRef *' => 						array( 'CreditMemo', 'Class_*' ), 
			'CreditMemoRet ARAccountRef' => 					array( null, null ), 
			'CreditMemoRet ARAccountRef *' => 					array( 'CreditMemo', 'ARAccount_*' ), 
			'CreditMemoRet TemplateRef' => 						array( null, null ), 
			'CreditMemoRet TemplateRef *' => 					array( 'CreditMemo', 'Template_*' ), 
			'CreditMemoRet BillAddress' => 						array( null, null ), 
			'CreditMemoRet BillAddress *' => 					array( 'CreditMemo', 'BillAddress_*' ), 
			'CreditMemoRet BillAddressBlock' => 				array( null, null ), 
			'CreditMemoRet BillAddressBlock *' => 				array( 'CreditMemo', 'BillAddressBlock_*' ), 
			'CreditMemoRet ShipAddress' => 						array( null, null ), 
			'CreditMemoRet ShipAddress *' => 					array( 'CreditMemo', 'ShipAddress_*' ), 
			'CreditMemoRet ShipAddressBlock' => 				array( null, null ), 
			'CreditMemoRet ShipAddressBlock *' => 				array( 'CreditMemo', 'ShipAddressBlock_*' ), 
			'CreditMemoRet TermsRef' => 						array( null, null ), 
			'CreditMemoRet TermsRef *' => 						array( 'CreditMemo', 'Terms_*' ), 
			'CreditMemoRet SalesRepRef' => 						array( null, null ), 
			'CreditMemoRet SalesRepRef *' => 					array( 'CreditMemo', 'SalesRep_*' ), 
			'CreditMemoRet ShipMethodRef' => 					array( null, null ), 
			'CreditMemoRet ShipMethodRef *' => 					array( 'CreditMemo', 'ShipMethod_*' ), 
			'CreditMemoRet ItemSalesTaxRef' => 					array( null, null ), 
			'CreditMemoRet ItemSalesTaxRef *' => 				array( 'CreditMemo', 'ItemSalesTax_*' ), 
			'CreditMemoRet CustomerMsgRef' => 					array( null, null ), 
			'CreditMemoRet CustomerMsgRef *' => 				array( 'CreditMemo', 'CustomerMsg_*' ), 
			'CreditMemoRet CustomerSalesTaxCodeRef' => 			array( null, null ), 
			'CreditMemoRet CustomerSalesTaxCodeRef *' => 		array( 'CreditMemo', 'CustomerSalesTaxCode_*' ), 
			
			'CreditMemoRet LinkedTxn' => 			array( null, null ), 
			'CreditMemoRet LinkedTxn TxnID' => 		array( 'CreditMemo_LinkedTxn', 'ToTxnID' ),
			'CreditMemoRet LinkedTxn *' => 			array( 'CreditMemo_LinkedTxn', '*' ), 
			
			'CreditMemoRet CreditMemoLineRet' => 												array( null, null ), 
			'CreditMemoRet CreditMemoLineRet Desc' => 											array( 'CreditMemo_CreditMemoLine', 'Descrip' ), 
			'CreditMemoRet CreditMemoLineRet ItemRef' => 										array( null, null ), 
			'CreditMemoRet CreditMemoLineRet ItemRef *' => 										array( 'CreditMemo_CreditMemoLine', 'Item_*' ), 
			'CreditMemoRet CreditMemoLineRet OverrideUOMSetRef' => 								array( null, null ), 
			'CreditMemoRet CreditMemoLineRet OverrideUOMSetRef *' => 							array( 'CreditMemo_CreditMemoLine', 'OverrideUOMSet_*' ), 
			'CreditMemoRet CreditMemoLineRet ClassRef' => 										array( null, null ), 
			'CreditMemoRet CreditMemoLineRet ClassRef *' => 									array( 'CreditMemo_CreditMemoLine', 'Class_*' ), 
			'CreditMemoRet CreditMemoLineRet SalesTaxCodeRef' => 								array( null, null ), 
			'CreditMemoRet CreditMemoLineRet SalesTaxCodeRef *' => 								array( 'CreditMemo_CreditMemoLine', 'SalesTaxCode_*' ), 
			'CreditMemoRet CreditMemoLineRet CreditCardTxnInfo' => 								array( null, null ), 
			'CreditMemoRet CreditMemoLineRet CreditCardTxnInfo CreditCardTxnInputInfo' => 		array( null, null ), 
			'CreditMemoRet CreditMemoLineRet CreditCardTxnInfo CreditCardTxnInputInfo *' => 	array( 'CreditMemo_CreditMemoLine', 'CreditCardTxnInputInfo_*' ), 
			'CreditMemoRet CreditMemoLineRet CreditCardTxnInfo CreditCardTxnResultInfo' => 		array( null, null ), 
			'CreditMemoRet CreditMemoLineRet CreditCardTxnInfo CreditCardTxnResultInfo *' => 	array( 'CreditMemo_CreditMemoLine', 'CreditCardTxnResultInfo_*' ), 
			
			'CreditMemoRet CreditMemoLineRet DataExtRet' => 			array( 'DataExt', null ), 
			'CreditMemoRet CreditMemoLineRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			'CreditMemoRet CreditMemoLineRet *' => 						array( 'CreditMemo_CreditMemoLine', '*' ), 
			
			'CreditMemoRet CreditMemoLineGroupRet' => 							array( 'CreditMemo_CreditMemoLineGroup', null ), 
			'CreditMemoRet CreditMemoLineGroupRet Desc' => 						array( 'CreditMemo_CreditMemoLineGroup', 'Descrip' ), 
			'CreditMemoRet CreditMemoLineGroupRet ItemGroupRef' => 				array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet ItemGroupRef *' => 			array( 'CreditMemo_CreditMemoLineGroup', 'ItemGroup_*' ), 
			'CreditMemoRet CreditMemoLineGroupRet ItemRef' => 					array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet ItemRef *' => 				array( 'CreditMemo_CreditMemoLineGroup', 'ItemGroup_*' ), 
			'CreditMemoRet CreditMemoLineGroupRet OverrideUOMSetRef' => 		array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet OverrideUOMSetRef *' => 		array( 'CreditMemo_CreditMemoLineGroup', 'OverrideUOMSet_*' ), 
			
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet' => 												array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet ItemRef' => 										array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet ItemRef *' => 										array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'Item_*' ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet Desc' => 											array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'Descrip' ),
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet OverrideUOMSetRef' => 								array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet OverrideUOMSetRef *' => 							array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'OverrideUOMSet_*' ),  
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet ClassRef' => 										array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet ClassRef *' => 										array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'Class_*' ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet SalesTaxCodeRef' => 								array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet SalesTaxCodeRef *' => 								array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'SalesTaxCode_*' ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet CreditCardTxnInfo' => 								array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet CreditCardTxnInfo CreditCardTxnInputInfo' => 		array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet CreditCardTxnInfo CreditCardTxnInputInfo *' => 		array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'CreditCardTxnInfo_CreditCardTxnInputInfo_*' ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet CreditCardTxnInfo CreditCardTxnResultInfo' => 		array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet CreditCardTxnInfo CreditCardTxnResultInfo *' => 	array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'CreditCardTxnInfo_CreditCardTxnResultInfo_*' ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet CreditCardTxnInfo *' => 							array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'CreditCardTxnInfo_*' ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet DataExtRet' => 										array( null, null ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet DataExtRet *' => 									array( 'DataExt', '*' ), 
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet *' => 												array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', '*' ), 
			
			'CreditMemoRet CreditMemoLineGroupRet DataExtRet' => 			array( 'DataExt', null ), 
			'CreditMemoRet CreditMemoLineGroupRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			'CreditMemoRet CreditMemoLineGroupRet *' => 					array( 'CreditMemo_CreditMemoLineGroup', '*' ), 
			
			
			'CreditMemoRet DataExtRet' => 			array( 'DataExt', null ), 
			'CreditMemoRet DataExtRet *' => 		array( 'DataExt', '*' ), 
			'CreditMemoRet *' => 					array( 'CreditMemo', '*' ), 
			
			'CustomerRet' =>								array( 'Customer', null ),
			'CustomerRet ParentRef'	=> 						array( null, null ), 
			'CustomerRet ParentRef *' => 					array( 'Customer', 'Parent_*' ), 
			'CustomerRet BillAddress' => 					array( null, null ), 
			'CustomerRet BillAddress *' => 					array( 'Customer', 'BillAddress_*' ), 
			'CustomerRet ShipAddress' => 					array( null, null ), 
			'CustomerRet ShipAddress *' => 					array( 'Customer', 'ShipAddress_*' ), 
			'CustomerRet BillAddressBlock' => 				array( null, null ), 
			'CustomerRet BillAddressBlock *' => 			array( 'Customer', 'BillAddressBlock_*' ), 
			'CustomerRet ShipAddressBlock' => 				array( null, null ), 
			'CustomerRet ShipAddressBlock *' => 			array( 'Customer', 'ShipAddressBlock_*' ), 
			'CustomerRet CreditCardInfo' => 				array( null, null ), 
			'CustomerRet CreditCardInfo *' => 				array( 'Customer', 'CreditCardInfo_*' ), 
			'CustomerRet CustomerTypeRef' => 				array( null, null ), 
			'CustomerRet CustomerTypeRef *' => 				array( 'Customer', 'CustomerType_*' ), 
			'CustomerRet TermsRef' => 						array( null, null ), 
			'CustomerRet TermsRef *' => 					array( 'Customer', 'Terms_*' ), 
			'CustomerRet SalesRepRef' => 					array( null, null ), 
			'CustomerRet SalesRepRef *' => 					array( 'Customer', 'SalesRep_*' ), 
			'CustomerRet SalesTaxCodeRef' => 				array( null, null ), 
			'CustomerRet SalesTaxCodeRef *' => 				array( 'Customer', 'SalesTaxCode_*' ), 
			'CustomerRet ItemSalesTaxRef' => 				array( null, null ), 
			'CustomerRet ItemSalesTaxRef *' => 				array( 'Customer', 'ItemSalesTax_*' ), 
			'CustomerRet PreferredPaymentMethodRef' => 		array( null, null ), 
			'CustomerRet PreferredPaymentMethodRef *' => 	array( 'Customer', 'PreferredPaymentMethod_*' ), 
			'CustomerRet JobTypeRef' => 					array( null, null ), 
			'CustomerRet JobTypeRef *' => 					array( 'Customer', 'JobType_*' ), 
			'CustomerRet PriceLevelRef' => 					array( null, null ), 
			'CustomerRet PriceLevelRef *' => 				array( 'Customer', 'PriceLevel_*' ), 
			
			'CustomerRet DataExtRet' => 				array( 'DataExt', null ), 
			'CustomerRet DataExtRet *' => 				array( 'DataExt', '*' ), 
			
			'CustomerRet *' => 						array( 'Customer', '*' ), 
			
			'CustomerTypeRet' => 					array( 'CustomerType', null ),
			'CustomerTypeRet ParentRef' => 			array( 'CustomerType', null ), 
			'CustomerTypeRet ParentRef *' => 		array( 'CustomerType', 'Parent_*' ), 
			
			'CustomerTypeRet *' => 					array( 'CustomerType', '*' ), 
			
			'CustomerMsgRet' => 					array( 'CustomerMsg', null ), 
			
			'CustomerMsgRet *' => 					array( 'CustomerMsg', '*' ), 
			
			'DataExtDefRet' =>						array( 'DataExtDef', null ),
			'DataExtDefRet AssignToObject' => 		array( 'DataExtDef_AssignToObject', 'AssignToObject' ), 
			'DataExtDefRet *' => 					array( 'DataExtDef', '*' ), 
			
			'DateDrivenTermsRet' => 				array( 'DateDrivenTerms', null ), 
			'DateDrivenTermsRet *' => 				array( 'DateDrivenTerms', '*' ), 
			
			'DepositRet' => 								array( 'Deposit', null ), 
			'DepositRet DepositToAccountRef' => 			array( null, null ), 
			'DepositRet DepositToAccountRef *' => 			array( 'Deposit', 'DepositToAccount_*' ), 
			'DepositRet CashBackInfoRet' => 				array( null, null ), 
			'DepositRet CashBackInfoRet AccountRef' => 		array( null, null ), 
			'DepositRet CashBackInfoRet AccountRef *' => 	array( 'Deposit', 'CashBackInfo_Account_*' ), 
			'DepositRet CashBackInfoRet *' => 				array( 'Deposit', 'CashBackInfo_*' ), 
			
			'DepositRet DepositLineRet' => 							array( null, null ), 
			'DepositRet DepositLineRet EntityRef' => 				array( null, null ), 			
			'DepositRet DepositLineRet EntityRef *' => 				array( 'Deposit_DepositLine', 'Entity_*' ), 	
			'DepositRet DepositLineRet AccountRef' => 				array( null, null ), 			
			'DepositRet DepositLineRet AccountRef *' => 			array( 'Deposit_DepositLine', 'Account_*' ), 		
			'DepositRet DepositLineRet PaymentMethodRef' => 		array( null, null ), 			
			'DepositRet DepositLineRet PaymentMethodRef *' => 		array( 'Deposit_DepositLine', 'PaymentMethod_*' ), 
			'DepositRet DepositLineRet ClassRef' => 				array( null, null ), 			
			'DepositRet DepositLineRet ClassRef *' => 				array( 'Deposit_DepositLine', 'Class_*' ), 		
			'DepositRet DepositLineRet *' => 						array( 'Deposit_DepositLine', '*' ), 
			
			'DepositRet DataExtRet' => 								array( null, null ), 
			'DepositRet DataExtRet *' => 							array( 'DataExt', '*' ), 
			
			'DepositRet *' => 										array( 'Deposit', '*' ), 
			
			'EmployeeRet' => 										array( 'Employee', null ), 
			'EmployeeRet EmployeeAddress' => 						array( null, null ), 
			'EmployeeRet EmployeeAddress *' => 						array( 'Employee', 'EmployeeAddress_*' ), 
			'EmployeeRet BillingRateRef' => 						array( null, null ), 
			'EmployeeRet BillingRateRef *' => 						array( 'Employee', 'BillingRate_*' ), 
			
			'EmployeeRet EmployeePayrollInfo' => 								array( null, null ), 
			'EmployeeRet EmployeePayrollInfo ClassRef' => 						array( null, null ), 
			'EmployeeRet EmployeePayrollInfo ClassRef *' => 					array( 'Employee', 'EmployeePayrollInfo_Class_*' ), 
			'EmployeeRet EmployeePayrollInfo Earnings' => 						array( null, null ), 
			'EmployeeRet EmployeePayrollInfo Earnings PayrollItemWageRef' => 	array( null, null ), 
			'EmployeeRet EmployeePayrollInfo Earnings PayrollItemWageRef *' => 	array( 'Employee_Earnings', 'PayrollItemWage_*' ), 
			'EmployeeRet EmployeePayrollInfo Earnings *' => 					array( 'Employee_Earnings', '*' ), 
			
			'EmployeeRet EmployeePayrollInfo SickHours' => 			array( null, null ), 
			'EmployeeRet EmployeePayrollInfo SickHours *' => 		array( 'Employee', 'EmployeePayrollInfo_SickHours_*' ), 
			
			'EmployeeRet EmployeePayrollInfo VacationHours' => 		array( null, null ), 
			'EmployeeRet EmployeePayrollInfo VacationHours *' => 	array( 'Employee', 'EmployeePayrollInfo_VacationHours_*' ), 
			
			'EmployeeRet EmployeePayrollInfo *' => 		array( 'Employee', 'EmployeePayrollInfo_*' ), 
			
			'EmployeeRet DataExtRet' => 				array( null, null ), 
			'EmployeeRet DataExtRet *' => 				array( 'DataExt', '*' ), 
			
			'EmployeeRet *' => 							array( 'Employee', '*' ), 
			
			'EstimateRet' => 							array( 'Estimate', null ), 
			
			'EstimateRet CustomerRef' => 				array( null, null ), 
			'EstimateRet CustomerRef *' => 				array( 'Estimate', 'Customer_*' ), 
			'EstimateRet ClassRef' => 					array( null, null ), 
			'EstimateRet ClassRef *' => 				array( 'Estimate', 'Class_*' ), 
			'EstimateRet TemplateRef' => 				array( null, null ), 
			'EstimateRet TemplateRef *' => 				array( 'Estimate', 'Template_*' ), 
			'EstimateRet BillAddress' => 				array( null, null ), 
			'EstimateRet BillAddress *' => 				array( 'Estimate', 'BillAddress_*' ), 
			'EstimateRet ShipAddress' => 				array( null, null ), 
			'EstimateRet ShipAddress *' => 				array( 'Estimate', 'ShipAddress_*' ), 
			'EstimateRet BillAddressBlock' => 			array( null, null ), 
			'EstimateRet BillAddressBlock *' => 		array( 'Estimate', 'BillAddressBlock_*' ), 
			'EstimateRet ShipAddressBlock' => 			array( null, null ), 
			'EstimateRet ShipAddressBlock *' => 		array( 'Estimate', 'ShipAddressBlock_*' ),
			'EstimateRet TermsRef' => 					array( null, null ), 
			'EstimateRet TermsRef *' => 				array( 'Estimate', 'Terms_*' ), 
			'EstimateRet ItemSalesTaxRef' => 			array( null, null ), 
			'EstimateRet ItemSalesTaxRef *' => 			array( 'Estimate', 'ItemSalesTax_*' ), 
			'EstimateRet SalesRepRef' => 				array( null, null ), 
			'EstimateRet SalesRepRef *' => 				array( 'Estimate', 'SalesRep_*' ), 
			'EstimateRet CurrencyRef' => 				array( null, null ), 
			'EstimateRet CurrencyRef *' => 				array( 'Estimate', 'Currency_*' ), 
			'EstimateRet CustomerMsgRef' => 			array( null, null ), 
			'EstimateRet CustomerMsgRef *' => 			array( 'Estimate', 'CustomerMsg_*' ), 
			'EstimateRet CustomerSalesTaxCodeRef' =>	array( null, null ), 
			'EstimateRet CustomerSalesTaxCodeRef *' => 	array( 'Estimate', 'CustomerSalesTaxCode_*' ), 
			
			'EstimateRet LinkedTxn' => 					array( 'Estimate_LinkedTxn', null ), 
			'EstimateRet LinkedTxn TxnID' => 			array( 'Estimate_LinkedTxn', 'ToTxnID' ),
			'EstimateRet LinkedTxn *' => 				array( 'Estimate_LinkedTxn', '*' ),
			
			'EstimateRet EstimateLineRet' => 							array( null, null ),
			'EstimateRet EstimateLineRet Desc' => 						array( 'Estimate_EstimateLine', 'Descrip' ), 
			'EstimateRet EstimateLineRet ItemRef' => 					array( null, null ), 
			'EstimateRet EstimateLineRet ItemRef *' => 					array( 'Estimate_EstimateLine', 'Item_*' ), 
			'EstimateRet EstimateLineRet OverrideUOMSetRef' => 			array( null, null ), 
			'EstimateRet EstimateLineRet OverrideUOMSetRef *' => 		array( 'Estimate_EstimateLine', 'OverrideUOMSet_*' ), 
			'EstimateRet EstimateLineRet ClassRef' => 					array( null, null ), 
			'EstimateRet EstimateLineRet ClassRef *' => 				array( 'Estimate_EstimateLine', 'Class_*' ),
			'EstimateRet EstimateLineRet InventorySiteRef' => 			array( null, null ), 
			'EstimateRet EstimateLineRet InventorySiteRef *' => 		array( 'Estimate_EstimateLine', 'InventorySite_*' ), 
			'EstimateRet EstimateLineRet SalesTaxCodeRef' => 			array( null, null ), 
			'EstimateRet EstimateLineRet SalesTaxCodeRef *' => 			array( 'Estimate_EstimateLine', 'SalesTaxCode_*' ), 
			
			'EstimateRet EstimateLineRet DataExtRet' => 				array( 'DataExt', null ), 
			'EstimateRet EstimateLineRet DataExtRet *' => 				array( 'DataExt', '*' ), 
			
			'EstimateRet EstimateLineRet *' => 							array( 'Estimate_EstimateLine', '*' ), 
			
			'EstimateRet EstimateLineGroupRet' => 										array( null, null ), 
			'EstimateRet EstimateLineGroupRet Desc' => 									array( 'Estimate_EstimateLineGroup', 'Descrip' ),
			'EstimateRet EstimateLineGroupRet ItemGroupRef' =>							array( null, null ), 
			'EstimateRet EstimateLineGroupRet ItemGroupRef *' =>						array( 'Estimate_EstimateLineGroup', 'ItemGroup_*' ), 
			'EstimateRet EstimateLineGroupRet OverrideUOMSetRef' =>						array( null, null ), 
			'EstimateRet EstimateLineGroupRet OverrideUOMSetRef *' => 					array( 'Estimate_EstimateLineGroup', 'OverrideUOMSet_*' ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet' => 						array( null, null ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet ItemRef' => 				array( null, null ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet ItemRef *' => 			array( 'Estimate_EstimateLineGroup_EstimateLine', 'Item_*' ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet Desc' => 					array( 'Estimate_EstimateLineGroup_EstimateLine', 'Descrip' ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet OverrideUOMSetRef' => 	array( null, null ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet OverrideUOMSetRef *' => 	array( 'Estimate_EstimateLineGroup_EstimateLine', 'OverrideUOMSet_*' ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet ClassRef' => 				array( null, null ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet ClassRef *' => 			array( 'Estimate_EstimateLineGroup_EstimateLine', 'Class_*' ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet SalesTaxCodeRef' => 		array( null, null ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet SalesTaxCodeRef *' => 	array( 'Estimate_EstimateLineGroup_EstimateLine', 'SalesTaxCode_*' ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet DataExtRet' => 			array( null, null ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			'EstimateRet EstimateLineGroupRet EstimateLineRet *' => 					array( 'Estimate_EstimateLineGroup_EstimateLine', '*' ), 
			'EstimateRet EstimateLineGroupRet DataExtRet' => 							array( null, null ), 
			'EstimateRet EstimateLineGroupRet DataExtRet *' => 							array( 'DataExt', '*' ), 
			
			'EstimateRet EstimateLineGroupRet *' => 									array( 'Estimate_EstimateLineGroup', '*' ), 
			
			'EstimateRet DataExtRet' => 				array( null, null ), 
			'EstimateRet DataExtRet *' => 				array( 'DataExt', '*' ), 
			
			'EstimateRet *' => 							array( 'Estimate', '*' ), 
			
			'InventoryAdjustmentRet' => 				array( 'InventoryAdjustment', null ), 
			'InventoryAdjustmentRet AccountRef' => 		array( null, null ), 
			'InventoryAdjustmentRet AccountRef *' => 	array( 'InventoryAdjustment', 'Account_*' ), 
			'InventoryAdjustmentRet CustomerRef' => 	array( null, null ), 
			'InventoryAdjustmentRet CustomerRef *' => 	array( 'InventoryAdjustment', 'Customer_*' ), 
			'InventoryAdjustmentRet ClassRef' => 		array( null, null ), 
			'InventoryAdjustmentRet ClassRef *' => 		array( 'InventoryAdjustment', 'Class_*' ), 
			
			'InventoryAdjustmentRet InventoryAdjustmentLineRet' => 					array( null, null ), 
			'InventoryAdjustmentRet InventoryAdjustmentLineRet ItemRef' => 			array( null, null ), 
			'InventoryAdjustmentRet InventoryAdjustmentLineRet ItemRef *' => 		array( 'InventoryAdjustment_InventoryAdjustmentLine', 'Item_*' ), 
			'InventoryAdjustmentRet InventoryAdjustmentLineRet QuantityAdjustment' => array( null, null ), 
			'InventoryAdjustmentRet InventoryAdjustmentLineRet QuantityAdjustment *' => array( 'InventoryAdjustment_InventoryAdjustmentLine', 'QuantityAdjustment_*' ), 
			'InventoryAdjustmentRet InventoryAdjustmentLineRet ValueAdjustment' => array( null, null ), 
			'InventoryAdjustmentRet InventoryAdjustmentLineRet ValueAdjustment *' => array( 'InventoryAdjustment_InventoryAdjustmentLine', 'ValueAdjustment_*' ), 
			'InventoryAdjustmentRet InventoryAdjustmentLineRet *' => 				array( 'InventoryAdjustment_InventoryAdjustmentLine', '*' ), 
			
			'InventoryAdjustmentRet DataExtRet' => 		array( null, null ), 
			'InventoryAdjustmentRet DataExtRet *' => 	array( 'DataExt', '*' ), 
			
			'InventoryAdjustmentRet *' => 				array( 'InventoryAdjustment', '*' ), 
			
			'InvoiceRet' => 							array( 'Invoice', null ),  
			'InvoiceRet CustomerRef' => 				array( null, null ),			
			'InvoiceRet CustomerRef *' => 				array( 'Invoice', 'Customer_*' ), 
			'InvoiceRet ARAccountRef' => 				array( null, null ),			
			'InvoiceRet ARAccountRef *' => 				array( 'Invoice', 'ARAccount_*' ),
			'InvoiceRet ClassRef' =>					array( null, null ),  
			'InvoiceRet ClassRef *' => 					array( 'Invoice', 'Class_*' ), 
			'InvoiceRet TemplateRef' => 				array( null, null ), 			
			'InvoiceRet TemplateRef *' =>				array( 'Invoice', 'Template_*' ), 
			'InvoiceRet BillAddress' => 				array( 'Invoice', null ), 
			'InvoiceRet BillAddress *' => 				array( 'Invoice', 'BillAddress_*' ), 
			'InvoiceRet ShipAddress' => 				array( 'Invoice', null ), 
			'InvoiceRet ShipAddress *' => 				array( 'Invoice', 'ShipAddress_*' ), 
			'InvoiceRet BillAddressBlock' =>			array( 'Invoice', null ), 
			'InvoiceRet BillAddressBlock *' => 			array( 'Invoice', 'BillAddressBlock_*' ), 
			'InvoiceRet ShipAddressBlock' => 			array( 'Invoice', null ), 
			'InvoiceRet ShipAddressBlock *' => 			array( 'Invoice', 'ShipAddressBlock_*' ), 
			'InvoiceRet TermsRef' => 					array( null, null ), 
			'InvoiceRet TermsRef *' => 					array( 'Invoice', 'Terms_*' ), 
			'InvoiceRet ItemSalesTaxRef' => 			array( null, null ), 
			'InvoiceRet ItemSalesTaxRef *' => 			array( 'Invoice', 'ItemSalesTax_*' ), 
			'InvoiceRet ShipMethodRef' => 				array( null, null ),
			'InvoiceRet ShipMethodRef *' => 			array( 'Invoice', 'ShipMethod_*' ),  
			'InvoiceRet SalesRepRef' => 				array( null, null ), 
			'InvoiceRet SalesRepRef *' => 				array( 'Invoice', 'SalesRep_*' ), 
			'InvoiceRet CurrencyRef' => 				array( null, null ), 
			'InvoiceRet CurrencyRef *' => 				array( 'Invoice', 'Currency_*' ), 
			'InvoiceRet CustomerMsgRef' => 				array( null, null ), 
			'InvoiceRet CustomerMsgRef *' => 			array( 'Invoice', 'CustomerMsg_*' ), 
			'InvoiceRet CustomerSalesTaxCodeRef' =>		array( null, null ), 
			'InvoiceRet CustomerSalesTaxCodeRef *' => 	array( 'Invoice', 'CustomerSalesTaxCode_*' ), 
			
			'InvoiceRet LinkedTxn' => 				array( 'Invoice_LinkedTxn', null ), 
			'InvoiceRet LinkedTxn TxnID' => 		array( 'Invoice_LinkedTxn', 'ToTxnID' ),
			'InvoiceRet LinkedTxn *' => 			array( 'Invoice_LinkedTxn', '*' ),
			
			'InvoiceRet InvoiceLineRet' => 							array( null, null ),
			'InvoiceRet InvoiceLineRet ItemRef' => 					array( null, null ), 
			'InvoiceRet InvoiceLineRet ItemRef *' => 				array( 'Invoice_InvoiceLine', 'Item_*' ), 
			'InvoiceRet InvoiceLineRet OverrideUOMSetRef' => 		array( null, null ), 
			'InvoiceRet InvoiceLineRet OverrideUOMSetRef *' => 		array( 'Invoice_InvoiceLine', 'OverrideUOMSet_*' ), 
			'InvoiceRet InvoiceLineRet ClassRef' => 				array( null, null ), 
			'InvoiceRet InvoiceLineRet ClassRef *' => 				array( 'Invoice_InvoiceLine', 'Class_*' ), 
			'InvoiceRet InvoiceLineRet InventorySiteRef' => 		array( null, null ), 
			'InvoiceRet InvoiceLineRet InventorySiteRef *' => 		array( 'Invoice_InvoiceLine', 'InventorySite_*' ), 
			'InvoiceRet InvoiceLineRet SalesTaxCodeRef' => 			array( null, null ), 
			'InvoiceRet InvoiceLineRet SalesTaxCodeRef *' => 		array( 'Invoice_InvoiceLine', 'SalesTaxCode_*' ), 
			
			'InvoiceRet InvoiceLineRet Desc' =>						array( 'Invoice_InvoiceLine', 'Descrip' ), 
			
			'InvoiceRet InvoiceLineRet DataExtRet' => 				array( 'DataExt', null ), 
			'InvoiceRet InvoiceLineRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			
			'InvoiceRet InvoiceLineRet *' => 						array( 'Invoice_InvoiceLine', '*' ), 
			
			'InvoiceRet InvoiceLineGroupRet' => 					array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet ItemGroupRef' =>		array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet ItemGroupRef *' => 		array( 'Invoice_InvoiceLineGroup', 'ItemGroup_*' ), 
			'InvoiceRet InvoiceLineGroupRet OverrideUOMSetRef' =>	array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet OverrideUOMSetRef *' => array( 'Invoice_InvoiceLineGroup', 'OverrideUOMSet_*' ), 
			
			'InvoiceRet InvoiceLineGroupRet Desc' =>								array( 'Invoice_InvoiceLineGroup', 'Descrip' ), 
			
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet' => 						array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet ItemRef' => 				array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet ItemRef *' => 			array( 'Invoice_InvoiceLineGroup_InvoiceLine', 'Item_*' ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet Desc' => 				array( 'Invoice_InvoiceLineGroup_InvoiceLine', 'Descrip' ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet OverrideUOMSetRef' => 	array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet OverrideUOMSetRef *' => 	array( 'Invoice_InvoiceLineGroup_InvoiceLine', 'OverrideUOMSet_*' ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet ClassRef' => 			array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet ClassRef *' => 			array( 'Invoice_InvoiceLineGroup_InvoiceLine', 'Class_*' ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet SalesTaxCodeRef' => 		array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet SalesTaxCodeRef *' => 	array( 'Invoice_InvoiceLineGroup_InvoiceLine', 'SalesTaxCode_*' ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet DataExtRet' => 			array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet DataExtRet *' => 		array( 'DataExt', '*' ), 
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet *' => 					array( 'Invoice_InvoiceLineGroup_InvoiceLine', '*' ) ,
			
			'InvoiceRet InvoiceLineGroupRet DataExtRet' => 			array( null, null ), 
			'InvoiceRet InvoiceLineGroupRet DataExtRet *' => 		array( 'DataExt', '*' ), 
			
			'InvoiceRet InvoiceLineGroupRet *' => 					array( 'Invoice_InvoiceLineGroup', '*' ), 
			
			'InvoiceRet DataExtRet' => 				array( null, null ), 
			'InvoiceRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			
			'InvoiceRet *' => 						array( 'Invoice', '*' ),  
			
			'ItemDiscountRet' => 					array( 'ItemDiscount', null ), 
			'ItemDiscountRet ParentRef' => 			array( null, null ), 
			'ItemDiscountRet ParentRef *' => 		array( 'ItemDiscount', 'Parent_*' ), 
			'ItemDiscountRet SalesTaxCodeRef' => 	array( null, null ), 
			'ItemDiscountRet SalesTaxCodeRef *' => 	array( 'ItemDiscount', 'SalesTaxCode_*' ), 
			'ItemDiscountRet AccountRef' => 		array( null, null ), 
			'ItemDiscountRet AccountRef *' => 		array( 'ItemDiscount', 'Account_*' ), 
			'ItemDiscountRet DataExtRet' => 		array( null, null ), 
			'ItemDiscountRet DataExtRet *' => 		array( 'DataExt', '*' ), 
			'ItemDiscountRet *' => 					array( 'ItemDiscount', '*' ), 
			
			'ItemServiceRet' => 											array( 'ItemService', null ), 
			'ItemServiceRet ParentRef' => 									array( null, null ), 
			'ItemServiceRet ParentRef *' => 								array( 'ItemService', 'Parent_*' ), 
			'ItemServiceRet UnitOfMeasureSetRef' => 						array( null, null ), 
			'ItemServiceRet UnitOfMeasureSetRef *' => 						array( 'ItemService', 'UnitOfMeasureSet_*' ), 
			'ItemServiceRet SalesTaxCodeRef' => 							array( null, null ), 
			'ItemServiceRet SalesTaxCodeRef *' => 							array( 'ItemService', 'SalesTaxCode_*' ), 
			'ItemServiceRet SalesOrPurchase' => 							array( null, null ), 
			'ItemServiceRet SalesOrPurchase AccountRef' => 					array( null, null ), 
			'ItemServiceRet SalesOrPurchase AccountRef *' => 				array( 'ItemService', 'SalesOrPurchase_Account_*' ), 
			'ItemServiceRet SalesOrPurchase *' => 							array( 'ItemService', 'SalesOrPurchase_*' ), 
			'ItemServiceRet SalesAndPurchase' => 							array( null, null ), 
			'ItemServiceRet SalesAndPurchase IncomeAccountRef' => 			array( null, null ), 
			'ItemServiceRet SalesAndPurchase IncomeAccountRef *' => 		array( 'ItemService', 'SalesAndPurchase_IncomeAccount_*' ), 
			'ItemServiceRet SalesAndPurchase ExpenseAccountRef' => 			array( null, null ), 
			'ItemServiceRet SalesAndPurchase ExpenseAccountRef *' => 		array( 'ItemService', 'SalesAndPurchase_ExpenseAccount_*' ), 
			'ItemServiceRet SalesAndPurchase PrefVendorRef' => 				array( null, null ), 
			'ItemServiceRet SalesAndPurchase PrefVendorRef *' => 			array( 'ItemService', 'SalesAndPurchase_PrefVendor_*' ), 
			'ItemServiceRet SalesAndPurchase *' => 							array( 'ItemService', 'SalesAndPurchase_*' ), 
			
			'ItemServiceRet DataExtRet' => 									array( null, null ), 
			'ItemServiceRet DataExtRet *' => 								array( 'DataExt', '*' ), 
			'ItemServiceRet *' => 											array( 'ItemService', '*' ), 
			
			'ItemNonInventoryRet' => 										array( 'ItemNonInventory', null ), 
			'ItemNonInventoryRet ParentRef' => 								array( null, null ), 
			'ItemNonInventoryRet ParentRef *' => 							array( 'ItemNonInventory', 'Parent_*' ), 
			'ItemNonInventoryRet UnitOfMeasureRef' => 						array( null, null ), 
			'ItemNonInventoryRet UnitOfMeasureRef *' => 					array( 'itemnoninventory', 'UnitOfMeasure_*' ), 
			'ItemNonInventoryRet SalesTaxCodeRef' => 						array( null, null ), 
			'ItemNonInventoryRet SalesTaxCodeRef' => 						array( 'itemnoninventory', 'SalesTaxCode_*' ), 
			'ItemNonInventoryRet UnitOfMeasureSetRef' => 					array( null, null ), 
			'ItemNonInventoryRet UnitOfMeasureSetRef *' => 					array( 'ItemNonInventory', 'UnitOfMeasureSet_*' ), 
			'ItemNonInventoryRet SalesTaxCodeRef' => 						array( null, null ), 
			'ItemNonInventoryRet SalesTaxCodeRef *' => 						array( 'ItemNonInventory', 'SalesTaxCode_*' ), 
			'ItemNonInventoryRet SalesOrPurchase' => 						array( null, null ), 
			'ItemNonInventoryRet SalesOrPurchase *' => 						array( 'ItemNonInventory', 'SalesOrPurchase_*' ), 
			'ItemNonInventoryRet SalesOrPurchase AccountRef' => 			array( null, null ), 
			'ItemNonInventoryRet SalesOrPurchase AccountRef *' => 			array( 'ItemNonInventory', 'SalesOrPurchase_Account_*' ), 
			'ItemNonInventoryRet SalesAndPurchase' => 						array( null, null ), 
			'ItemNonInventoryRet SalesAndPurchase IncomeAccountRef' => 		array( null, null ), 
			'ItemNonInventoryRet SalesAndPurchase IncomeAccountRef *' => 	array( 'ItemNonInventory', 'SalesAndPurchase_IncomeAccount_*' ), 
			'ItemNonInventoryRet SalesAndPurchase ExpenseAccountRef' => 	array( null, null ), 
			'ItemNonInventoryRet SalesAndPurchase ExpenseAccountRef *' => 	array( 'ItemNonInventory', 'SalesAndPurchase_ExpenseAccount_*' ), 
			'ItemNonInventoryRet SalesAndPurchase PrefVendorRef' => 		array( null, null ), 
			'ItemNonInventoryRet SalesAndPurchase PrefVendorRef *' => 		array( 'ItemNonInventory', 'SalesAndPurchase_PrefVendor_*' ), 
			'ItemNonInventoryRet SalesAndPurchase *' => 					array( 'ItemNonInventory', 'SalesAndPurchase_*' ), 
			'ItemNonInventoryRet DataExtRet' => 							array( null, null ), 
			'ItemNonInventoryRet DataExtRet *' => 							array( 'DataExt', '*' ), 
			'ItemNonInventoryRet *' => 										array( 'ItemNonInventory', '*' ), 
			
			'ItemOtherChargeRet' => 											array( 'ItemOtherCharge', null ), 
			'ItemOtherChargeRet ParentRef' => 									array( null, null ), 
			'ItemOtherChargeRet ParentRef *' => 								array( 'ItemOtherCharge', 'Parent_*' ), 
			'ItemOtherChargeRet SalesTaxCodeRef' => 							array( null, null ), 
			'ItemOtherChargeRet SalesTaxCodeRef *' => 							array( 'ItemOtherCharge', 'SalesTaxCode_*' ), 
			'ItemOtherChargeRet SalesOrPurchase' => 							array( null, null ), 
			'ItemOtherChargeRet SalesOrPurchase *' => 							array( 'ItemOtherCharge', 'SalesOrPurchase_*' ), 
			'ItemOtherChargeRet SalesOrPurchase AccountRef' => 					array( null, null ), 
			'ItemOtherChargeRet SalesOrPurchase AccountRef *' => 				array( 'ItemOtherCharge', 'SalesOrPurchase_Account_*' ), 
			'ItemOtherChargeRet SalesAndPurchase' => 							array( null, null ), 
			'ItemOtherChargeRet SalesAndPurchase IncomeAccountRef' => 			array( null, null ), 
			'ItemOtherChargeRet SalesAndPurchase IncomeAccountRef *' => 		array( 'ItemOtherCharge', 'SalesAndPurchase_IncomeAccount_*' ), 
			'ItemOtherChargeRet SalesAndPurchase ExpenseAccountRef' => 			array( null, null ), 
			'ItemOtherChargeRet SalesAndPurchase ExpenseAccountRef *' => 		array( 'ItemOtherCharge', 'SalesAndPurchase_ExpenseAccount_*' ), 
			'ItemOtherChargeRet SalesAndPurchase PrefVendorRef' => 				array( null, null ), 
			'ItemOtherChargeRet SalesAndPurchase PrefVendorRef *' => 			array( 'ItemOtherCharge', 'SalesAndPurchase_PrefVendor_*' ), 
			'ItemOtherChargeRet SalesAndPurchase *' => 							array( 'ItemOtherCharge', 'SalesAndPurchase_*' ), 
			
			'ItemOtherChargeRet DataExtRet' => 				array( null, null ), 
			'ItemOtherChargeRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			'ItemOtherChargeRet *' => 						array( 'ItemOtherCharge', '*' ), 
			
			'ItemInventoryRet' => 							array( 'ItemInventory', null ), 
			'ItemInventoryRet ParentRef' => 				array( null, null ), 
			'ItemInventoryRet ParentRef *' => 				array( 'ItemInventory', 'Parent_*' ), 
			'ItemInventoryRet SalesTaxCodeRef' => 			array( null, null ), 
			'ItemInventoryRet SalesTaxCodeRef *' => 		array( 'ItemInventory', 'SalesTaxCode_*' ), 
			'ItemInventoryRet UnitOfMeasureSetRef' => 		array( null, null ), 
			'ItemInventoryRet UnitOfMeasureSetRef *' => 	array( 'ItemInventory', 'UnitOfMeasureSet_*' ), 
			'ItemInventoryRet IncomeAccountRef' => 			array( null, null ), 
			'ItemInventoryRet IncomeAccountRef *' => 		array( 'ItemInventory', 'IncomeAccount_*', ), 
			'ItemInventoryRet COGSAccountRef' => 			array( null, null ), 
			'ItemInventoryRet COGSAccountRef *' => 			array( 'ItemInventory', 'COGSAccount_*' ), 
			'ItemInventoryRet PrefVendorRef' => 			array( null, null ), 
			'ItemInventoryRet PrefVendorRef *' => 			array( 'ItemInventory', 'PrefVendor_*' ), 
			'ItemInventoryRet AssetAccountRef' => 			array( null, null ), 
			'ItemInventoryRet AssetAccountRef *' => 		array( 'ItemInventory', 'AssetAccount_*' ),
			'ItemInventoryRet DataExtRet' => 				array( null, null ), 
			'ItemInventoryRet DataExtRet *' => 				array( 'DataExt', '*' ), 
			'ItemInventoryRet *' =>							array( 'ItemInventory', '*' ),
			
			
			'ItemInventoryAssemblyRet' => 						array( 'ItemInventoryAssembly', null ), 
			'ItemInventoryAssemblyRet ParentRef' => 			array( null, null ), 
			'ItemInventoryAssemblyRet ParentRef *' => 			array( 'ItemInventoryAssembly', 'Parent_*' ), 
			'ItemInventoryAssemblyRet UnitOfMeasureSetRef' => 	array( null, null ), 
			'ItemInventoryAssemblyRet UnitOfMeasureSetRef *' => array( 'ItemInventoryAssembly', 'UnitOfMeasureSet_*' ), 
			'ItemInventoryAssemblyRet SalesTaxCodeRef' => 		array( null, null ), 
			'ItemInventoryAssemblyRet SalesTaxCodeRef *' => 	array( 'ItemInventoryAssembly', 'SalesTaxCode_*' ), 
			'ItemInventoryAssemblyRet IncomeAccountRef' => 		array( null, null ), 
			'ItemInventoryAssemblyRet IncomeAccountRef *' => 	array( 'ItemInventoryAssembly', 'IncomeAccount_*' ), 
			'ItemInventoryAssemblyRet COGSAccountRef' => 		array( null, null ), 
			'ItemInventoryAssemblyRet COGSAccountRef *' => 		array( 'ItemInventoryAssembly', 'COGSAccount_*' ), 
			'ItemInventoryAssemblyRet PrefVendorRef' => 		array( null, null ), 
			'ItemInventoryAssemblyRet PrefVendorRef *' => 		array( 'ItemInventoryAssembly', 'PrefVendor_*' ), 
			'ItemInventoryAssemblyRet AssetAccountRef' => 		array( null, null ), 
			'ItemInventoryAssemblyRet AssetAccountRef *' => 	array( 'ItemInventoryAssembly', 'AssetAccount_*' ), 
			
			'ItemInventoryAssemblyRet ItemInventoryAssemblyLine' => 					array( null, null ), 
			'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef' => 	array( null, null ), 
			'ItemInventoryAssemblyRet ItemInventoryAssemblyLine ItemInventoryRef *' => 	array( 'ItemInventoryAssembly_ItemInventoryAssemblyLine', 'ItemInventory_*' ), 
			'ItemInventoryAssemblyRet ItemInventoryAssemblyLine *' => 					array( 'ItemInventoryAssembly_ItemInventoryAssemblyLine', '*' ), 
			
			'ItemInventoryAssemblyRet DataExtRet' => 		array( null, null ), 
			'ItemInventoryAssemblyRet DataExtRet *' => 		array( 'DataExt', '*' ), 
			
			'ItemInventoryAssemblyRet *' => 				array( 'ItemInventoryAssembly', '*' ), 
			
			'ItemFixedAssetRet' => 							array( 'ItemFixedAsset', null ), 
			'ItemFixedAssetRet AssetAccountRef' => 			array( null, null ), 
			'ItemFixedAssetRet AssetAccountRef *' => 		array( 'ItemFixedAsset', 'AssetAccount_*' ), 
			'ItemFixedAssetRet FixedAssetSalesInfo' => 		array( null, null ), 
			'ItemFixedAssetRet FixedAssetSalesInfo *' => 	array( 'ItemFixedAsset', 'FixedAssetSalesInfo_*' ), 
			'ItemFixedAssetRet DataExtRet' => 				array( null, null ), 
			'ItemFixedAssetRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			
			'ItemFixedAssetRet *' => 						array( 'ItemFixedAsset', '*' ), 
			
			'ItemGroupRet' => 								array( 'ItemGroup', null ),
			'ItemGroupRet UnitOfMeasureSetRef' => 			array( null, null ), 
			'ItemGroupRet UnitOfMeasureSetRef *' => 		array( 'ItemGroup', 'UnitOfMeasureSet_*' ), 
			'ItemGroupRet ItemGroupLine' => 				array( null, null ), 
			'ItemGroupRet ItemGroupLine ItemRef' => 		array( null, null ),
			'ItemGroupRet ItemGroupLine ItemRef *' => 		array( 'ItemGroup_ItemGroupLine', 'Item_*' ),
			'ItemGroupRet ItemGroupLine *' => 				array( 'ItemGroup_ItemGroupLine', '*' ), 
			'ItemGroupRet DataExtRet' => 					array( null, null ), 
			'ItemGroupRet DataExtRet *' => 					array( 'DataExt', '*' ), 
			
			'ItemGroupRet *' => 							array( 'ItemGroup', '*' ),  
			
			'ItemSubtotalRet' => 							array( 'ItemSubtotal', null ), 
			'ItemSubtotalRet DataExtRet' => 				array( null, null ), 
			'ItemSubtotalRet DataExtRet *' => 				array( 'DataExt', '*' ),  
			
			'ItemSubtotalRet *' => 							array( 'ItemSubtotal', '*' ), 
			
			'ItemPaymentRet' => 							array( 'ItemPayment', null ), 
			'ItemPaymentRet DepositToAccountRef' => 		array( null, null ), 
			'ItemPaymentRet DepositToAccountRef *' => 		array( 'ItemPayment', 'DepositToAccount_*' ), 
			'ItemPaymentRet PaymentMethodRef' => 			array( null, null ), 
			'ItemPaymentRet PaymentMethodRef *' => 			array( 'ItemPayment', 'PaymentMethod_*' ), 
			
			'ItemPaymentRet DataExtRet' => 					array( null, null ), 
			'ItemPaymentRet DataExtRet *' => 				array( 'DataExt', '*' ),  
			'ItemPaymentRet *' => 							array( 'ItemPayment', '*' ), 
			
			'ItemSalesTaxRet' => 								array( 'ItemSalesTax', null ), 
			'ItemSalesTaxRet TaxVendorRef' => 					array( null, null ), 
			'ItemSalesTaxRet TaxVendorRef *' => 				array( 'ItemSalesTax', 'TaxVendor_*' ),
			'ItemSalesTaxRet DataExtRet' => 					array( null, null ), 
			'ItemSalesTaxRet DataExtRet *' => 					array( 'DataExt', '*' ),  
			
			'ItemSalesTaxRet *' => 							array( 'ItemSalesTax', '*' ), 
			
			'ItemSalesTaxGroupRet' => 						array( 'ItemSalesTaxGroup', null ), 
			'ItemSalesTaxGroupRet ItemSalesTaxRef' => 		array( null, null ), 
			'ItemSalesTaxGroupRet ItemSalesTaxRef *' => 	array( 'ItemSalesTaxGroup_ItemSalesTax', '*' ), 
			'ItemSalesTaxGroupRet DataExtRet' => 			array( null, null ), 
			'ItemSalesTaxGroupRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			'ItemSalesTaxGroupRet *' => 					array( 'ItemSalesTaxGroup', '*' ), 
			
			'ItemReceiptRet' => 							array( 'ItemReceipt', null ), 
			'ItemReceiptRet VendorRef' => 					array( null, null ), 
			'ItemReceiptRet VendorRef *' => 				array( 'ItemReceipt', 'Vendor_*' ), 
			'ItemReceiptRet APAccountRef' => 				array( null, null ), 
			'ItemReceiptRet APAccountRef *' => 				array( 'ItemReceipt', 'APAccount_*' ), 
			
			'ItemReceiptRet LinkedTxn' => 					array( 'ItemReceipt_LinkedTxn', null ), 
			'ItemReceiptRet LinkedTxn TxnID' => 			array( 'ItemReceipt_LinkedTxn', 'ToTxnID' ),
			'ItemReceiptRet LinkedTxn *' => 				array( 'ItemReceipt_LinkedTxn', '*' ),
			
			'ItemReceiptRet ExpenseLineRet' => 						array( 'ItemReceipt_ExpenseLine', null ), 
			'ItemReceiptRet ExpenseLineRet AccountRef' => 			array( null, null ), 
			'ItemReceiptRet ExpenseLineRet AccountRef *' => 		array( 'ItemReceipt_ExpenseLine', 'Account_*' ), 
			'ItemReceiptRet ExpenseLineRet CustomerRef' => 			array( null, null ), 
			'ItemReceiptRet ExpenseLineRet CustomerRef *' => 		array( 'ItemReceipt_ExpenseLine', 'Customer_*' ), 
			'ItemReceiptRet ExpenseLineRet ClassRef' => 			array( null, null ), 
			'ItemReceiptRet ExpenseLineRet ClassRef *' => 			array( 'ItemReceipt_ExpenseLine', 'Class_*' ), 
			'ItemReceiptRet ExpenseLineRet *' => 					array( 'ItemReceipt_ExpenseLine', '*' ),
			
			
			'ItemReceiptRet ItemLineRet' => 							array( 'ItemReceipt_ItemLine', null ), 
			'ItemReceiptRet ItemLineRet Desc' => 						array( 'ItemReceipt_ItemLine', 'Descrip' ), 
			'ItemReceiptRet ItemLineRet ItemRef' => 					array( null, null ), 
			'ItemReceiptRet ItemLineRet ItemRef *' => 					array( 'ItemReceipt_ItemLine', 'Item_*' ), 
			'ItemReceiptRet ItemLineRet OverrideUOMSetRef' => 			array( null, null ), 
			'ItemReceiptRet ItemLineRet OverrideUOMSetRef *' => 		array( 'ItemReceipt_ItemLine', 'OverrideUOMSet_*' ), 
			'ItemReceiptRet ItemLineRet CustomerRef' => 				array( null, null ), 
			'ItemReceiptRet ItemLineRet CustomerRef *' => 				array( 'ItemReceipt_ItemLine', 'Customer_*' ), 
			'ItemReceiptRet ItemLineRet ClassRef' => 					array( null, null ), 
			'ItemReceiptRet ItemLineRet ClassRef *' => 					array( 'ItemReceipt_ItemLine', 'Class_*' ), 
			'ItemReceiptRet ItemLineRet *' => 							array( 'ItemReceipt_ItemLine', '*' ),
			
			'ItemReceiptRet ItemGroupLineRet' => 									array( 'ItemReceipt_ItemGroupLine', null ), 
			'ItemReceiptRet ItemGroupLineRet Desc' => 								array( 'ItemReceipt_ItemGroupLine', 'Descrip' ), 
			'ItemReceiptRet ItemGroupLineRet ItemGroupRef' => 						array( null, null ), 
			'ItemReceiptRet ItemGroupLineRet ItemGroupRef *' => 					array( 'ItemReceipt_ItemGroupLine', 'ItemGroup_*' ), 
			'ItemReceiptRet ItemGroupLineRet OverrideUOMSetRef' => 					array( null, null ), 
			'ItemReceiptRet ItemGroupLineRet OverrideUOMSetRef *' => 				array( 'ItemReceipt_ItemGroupLine', 'OverrideUOMSet_*' ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet' => 						array( null, null ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet ItemRef' => 				array( null, null ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet ItemRef *' => 				array( 'ItemReceipt_ItemGroupLine_ItemLine', 'Item_*' ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet Desc' => 					array( 'ItemReceipt_ItemGroupLine_ItemLine', 'Descrip' ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet OverrideUOMSetRef' => 		array( null, null ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet OverrideUOMSetRef *' => 	array( 'ItemReceipt_ItemGroupLine_ItemLine', 'OverrideUOMSet_*' ), 			
			'ItemReceiptRet ItemGroupLineRet ItemLineRet CustomerRef' => 			array( null, null ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet CustomerRef *' => 			array( 'ItemReceipt_ItemGroupLine_ItemLine', 'Customer_*' ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet ClassRef' => 				array( null, null ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet ClassRef *' => 			array( 'ItemReceipt_ItemGroupLine_ItemLine', 'Class_*' ), 
			'ItemReceiptRet ItemGroupLineRet ItemLineRet *' => 						array( 'ItemReceipt_ItemGroupLine_ItemLine', '*' ), 
			
			'ItemReceiptRet ItemGroupLineRet *' => 									array( 'ItemReceipt_ItemGroupLine', '*' ),
			
			'ItemReceiptRet DataExtRet' => 			array( null, null ), 
			'ItemReceiptRet DataExtRet *' => 		array( 'DataExt', '*' ),  
			'ItemReceiptRet *' => 					array( 'ItemReceipt', '*' ), 
			
			'JobTypeRet' => 						array( 'JobType', null ), 
			'JobTypeRet ParentRef' => 				array( null, null ), 
			'JobTypeRet ParentRef *' => 			array( 'JobType', 'Parent_*'  ), 
			'JobTypeRet *' => 						array( 'JobType', '*' ), 
			
			'JournalEntryRet' => 									array( 'JournalEntry', null ),
			'JournalEntryRet JournalDebitLine' => 					array( null, null ), 
			'JournalEntryRet JournalDebitLine AccountRef' => 		array( null, null ), 
			'JournalEntryRet JournalDebitLine AccountRef *' => 		array( 'JournalEntry_JournalDebitLine', 'Account_*' ), 
			'JournalEntryRet JournalDebitLine EntityRef' => 		array( null, null ), 
			'JournalEntryRet JournalDebitLine EntityRef *' => 		array( 'JournalEntry_JournalDebitLine', 'Entity_*' ), 
			'JournalEntryRet JournalDebitLine ClassRef' => 			array( null, null ), 
			'JournalEntryRet JournalDebitLine ClassRef *' => 		array( 'JournalEntry_JournalDebitLine', 'Class_*' ), 
			'JournalEntryRet JournalDebitLine *' => 				array( 'JournalEntry_JournalDebitLine', '*' ), 
			
			
			'JournalEntryRet JournalCreditLine' => 						array( null, null ), 
			'JournalEntryRet JournalCreditLine AccountRef' => 			array( null, null ), 
			'JournalEntryRet JournalCreditLine AccountRef *' => 		array( 'JournalEntry_JournalCreditLine', 'Account_*' ), 
			'JournalEntryRet JournalCreditLine EntityRef' => 			array( null, null ), 
			'JournalEntryRet JournalCreditLine EntityRef *' => 			array( 'JournalEntry_JournalCreditLine', 'Entity_*' ), 
			'JournalEntryRet JournalCreditLine ClassRef' => 			array( null, null ), 
			'JournalEntryRet JournalCreditLine ClassRef *' => 			array( 'JournalEntry_JournalCreditLine', 'Class_*' ), 
			'JournalEntryRet JournalCreditLine *' => 					array( 'JournalEntry_JournalCreditLine', '*' ), 
			
			'JournalEntryRet DataExtRet' => 		array( null, null ), 
			'JournalEntryRet DataExtRet *' => 		array( 'DataExt', '*' ), 
			'JournalEntryRet *' => 					array( 'JournalEntry', '*' ), 
			
			'PaymentMethodRet' => 					array( 'PaymentMethod', null ), 
			'PaymentMethodRet *' => 				array( 'PaymentMethod', '*' ), 
			
			'PayrollItemWageRet' => 					array( 'PayrollItemWage', null ),
			'PayrollItemWageRet ExpenseAccountRef' => 	array( null, null ), 
			'PayrollItemWageRet ExpenseAccountRef *' => array( 'PayrollItemWage', 'ExpenseAccount_*' ), 
			
			'PayrollItemWageRet *' => 					array( 'PayrollItemWage', '*' ), 
			
			'PriceLevelRet' => 									array( 'PriceLevel', null ), 
			'PriceLevelRet PriceLevelPerItemRet' => 			array( null, null ), 
			'PriceLevelRet PriceLevelPerItemRet ItemRef' => 	array( null, null ), 
			'PriceLevelRet PriceLevelPerItemRet ItemRef *' => 	array( 'PriceLevel_PriceLevelPerItem', 'Item_*' ), 
			'PriceLevelRet PriceLevelPerItemRet *' => 			array( 'PriceLevel_PriceLevelPerItem', '*' ), 
			'PriceLevelRet *' => 								array( 'PriceLevel', '*' ), 
			
			'PurchaseOrderRet' => 											array( 'PurchaseOrder', null ),
			'PurchaseOrderRet VendorRef' => 								array( null, null ), 
			'PurchaseOrderRet VendorRef *' => 								array( 'PurchaseOrder', 'Vendor_*' ), 
			'PurchaseOrderRet VendorRef FullName' => 						array( 'PurchaseOrder', 'Vendor_FullName' ), 
			'PurchaseOrderRet ClassRef' =>									array( null, null ),  
			'PurchaseOrderRet ClassRef *' => 								array( 'PurchaseOrder', 'Class_*' ), 
			'PurchaseOrderRet ShipToEntityRef' => 							array( null, null ), 
			'PurchaseOrderRet ShipToEntityRef *' => 						array( 'PurchaseOrder', 'ShipToEntity_*' ), 
			'PurchaseOrderRet ShipToEntityRef FullName' => 					array( 'PurchaseOrder', 'ShipToEntity_FullName' ), 
			'PurchaseOrderRet TemplateRef' => 								array( null, null ), 			
			'PurchaseOrderRet TemplateRef *' =>								array( 'PurchaseOrder', 'Template_*' ), 
			'PurchaseOrderRet VendorAddress' => 							array( 'PurchaseOrder', null ), 
			'PurchaseOrderRet VendorAddress *' => 							array( 'PurchaseOrder', 'VendorAddress_*' ), 
			'PurchaseOrderRet VendorAddressBlock' =>						array( 'PurchaseOrder', null ), 
			'PurchaseOrderRet VendorAddressBlock *' => 						array( 'PurchaseOrder', 'VendorAddressBlock_*' ), 
			'PurchaseOrderRet ShipAddress' => 								array( 'PurchaseOrder', null ), 
			'PurchaseOrderRet ShipAddress *' => 							array( 'PurchaseOrder', 'ShipAddress_*' ), 
			'PurchaseOrderRet ShipAddressBlock' => 							array( 'PurchaseOrder', null ), 
			'PurchaseOrderRet ShipAddressBlock *' => 						array( 'PurchaseOrder', 'ShipAddressBlock_*' ), 
			'PurchaseOrderRet TermsRef' => 									array( null, null ), 
			'PurchaseOrderRet TermsRef *' => 								array( 'PurchaseOrder', 'Terms_*' ), 
			'PurchaseOrderRet ShipMethodRef' => 							array( null, null ), 
			'PurchaseOrderRet ShipMethodRef *' => 							array( 'PurchaseOrder', 'ShipMethod_*' ), 			
			'PurchaseOrderRet CurrencyRef' => 								array( null, null ), 
			'PurchaseOrderRet CurrencyRef *' => 							array( 'PurchaseOrder', 'Currency_*' ), 			
			'PurchaseOrderRet PurchaseOrderLineRet' => 						array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineRet ItemRef' => 				array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineRet ItemRef *' => 			array( 'PurchaseOrder_PurchaseOrderLine', 'Item_*' ), 
			'PurchaseOrderRet PurchaseOrderLineRet OverrideUOMSetRef' => 	array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineRet OverrideUOMSetRef *' => 	array( 'PurchaseOrder_PurchaseOrderLine', 'OverrideUOMSet_*' ), 
			'PurchaseOrderRet PurchaseOrderLineRet ClassRef' => 			array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineRet ClassRef *' => 			array( 'PurchaseOrder_PurchaseOrderLine', 'Class_*' ), 
			'PurchaseOrderRet PurchaseOrderLineRet CustomerRef' => 			array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineRet CustomerRef *' => 		array( 'PurchaseOrder_PurchaseOrderLine', 'Customer_*' ), 
			'PurchaseOrderRet PurchaseOrderLineRet Desc' => 				array( 'PurchaseOrder_PurchaseOrderLine', 'Descrip' ), 
			'PurchaseOrderRet PurchaseOrderLineRet DataExtRet' => 			array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineRet DataExtRet *' => 		array( 'DataExt', '*' ), 
			'PurchaseOrderRet PurchaseOrderLineRet *' => 					array( 'PurchaseOrder_PurchaseOrderLine', '*' ), 
			
			'PurchaseOrderRet PurchaseOrderLineGroupRet' => 											array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet ItemGroupRef' => 								array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet ItemGroupRef *' => 								array( 'PurchaseOrder_PurchaseOrderLineGroup', 'ItemGroup_*' ),
			'PurchaseOrderRet PurchaseOrderLineGroupRet OverrideUOMSetRef' => 							array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet OverrideUOMSetRef *' => 						array( 'PurchaseOrder_PurchaseOrderLineGroup', 'OverrideUOMSet_*' ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet Desc' => 										array( 'PurchaseOrder_PurchaseOrderLineGroup', 'Descrip' ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet' => 						array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet ItemRef' => 				array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet ItemRef *' => 				array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', 'Item_*' ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet Desc' => 					array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', 'Descrip' ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet OverrideUOMSetRef' => 		array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet OverrideUOMSetRef *' => 	array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', 'OverrideUOMSet_*' ), 
			
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet ClassRef' => 				array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet ClassRef *' =>				array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', 'Class_*' ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet CustomerRef' => 			array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet CustomerRef *' => 			array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', 'Customer_*' ), 
			
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet DataExtRet' => 			array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet DataExtRet *' => 			array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet DataExtRet *' => 			array( 'DataExt', '*' ),
			
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet *' => 						array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', '*' ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet DataExtRet' => 									array( null, null ), 
			'PurchaseOrderRet PurchaseOrderLineGroupRet DataExtRet *' => 								array( 'DataExt', '*' ), 
			
			'PurchaseOrderRet PurchaseOrderLineGroupRet *' => 											array( 'PurchaseOrder_PurchaseOrderLineGroup', '*' ), 
			
			'PurchaseOrderRet DataExtRet' => 			array( null, null ), 
			'PurchaseOrderRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			
			'PurchaseOrderRet LinkedTxn' => 			array( null, null ), 
			'PurchaseOrderRet LinkedTxn TxnID' => 		array( 'PurchaseOrder_LinkedTxn', 'ToTxnID' ), 
			'PurchaseOrderRet LinkedTxn *' => 			array( 'PurchaseOrder_LinkedTxn', '*' ), 
			'PurchaseOrderRet *' => 					array( 'PurchaseOrder', '*' ), 
			
			'ReceivePaymentRet' => 						array( 'ReceivePayment', null ), 
			'ReceivePaymentRet CustomerRef' => 			array( null, null ), 
			'ReceivePaymentRet CustomerRef *' => 		array( 'ReceivePayment', 'Customer_*' ), 
			'ReceivePaymentRet ARAccountRef' => 		array( null, null ), 
			'ReceivePaymentRet ARAccountRef *' => 		array( 'ReceivePayment', 'ARAccount_*', ),
			'ReceivePaymentRet PaymentMethodRef' => 	array( null, null ), 
			'ReceivePaymentRet PaymentMethodRef *' => 	array( 'ReceivePayment', 'PaymentMethod_*' ),  
			
			'ReceivePaymentRet DepositToAccountRef' => 							array( null, null ), 
			'ReceivePaymentRet DepositToAccountRef *' => 						array( 'ReceivePayment', 'DepositToAccount_*' ), 
			'ReceivePaymentRet CreditCardTxnInfo' => 							array( null, null ), 
			'ReceivePaymentRet CreditCardTxnInfo CreditCardTxnInputInfo' => 	array( null, null ), 
			'ReceivePaymentRet CreditCardTxnInfo CreditCardTxnInputInfo *' => 	array( 'ReceivePayment', 'CreditCardTxnInfo_CreditCardTxnInputInfo_*' ), 
			'ReceivePaymentRet CreditCardTxnInfo CreditCardTxnResultInfo' => 	array( null, null ), 
			'ReceivePaymentRet CreditCardTxnInfo CreditCardTxnResultInfo *' => 	array( 'ReceivePayment', 'CreditCardTxnInfo_CreditCardTxnResultInfo_*' ), 
			'ReceivePaymentRet AppliedToTxnRet' => 								array( null, null ), 
			'ReceivePaymentRet AppliedToTxnRet TxnID' => 						array( 'ReceivePayment_AppliedToTxn', 'ToTxnID' ), 
			'ReceivePaymentRet AppliedToTxnRet DiscountAccountRef' => 			array( null, null ),
			'ReceivePaymentRet AppliedToTxnRet DiscountAccountRef *' => 		array( 'ReceivePayment_AppliedToTxn', 'DiscountAccount_*' ),
			'ReceivePaymentRet AppliedToTxnRet *' => 							array( 'ReceivePayment_AppliedToTxn', '*' ),
			'ReceivePaymentRet DataExtRet' => 									array( null, null ), 
			'ReceivePaymentRet DataExtRet *' => 								array( 'DataExt', '*' ), 
			'ReceivePaymentRet *' => 											array( 'ReceivePayment', '*' ), 
			
			'SalesOrderRet' => 									array( 'SalesOrder', null ), 
			'SalesOrderRet CustomerRef' => 						array( null, null ), 
			'SalesOrderRet CustomerRef *' => 					array( 'SalesOrder', 'Customer_*' ), 
			'SalesOrderRet ClassRef' => 						array( null, null ), 
			'SalesOrderRet ClassRef *' => 						array( 'SalesOrder', 'Class_*' ), 
			'SalesOrderRet TemplateRef' => 						array( null, null ), 
			'SalesOrderRet TemplateRef *' => 					array( 'SalesOrder', 'Template_*' ), 
			'SalesOrderRet BillAddress' => 						array( null, null ), 
			'SalesOrderRet BillAddress *' => 					array( 'SalesOrder', 'BillAddress_*' ), 
			'SalesOrderRet BillAddressBlock' => 				array( null, null ), 
			'SalesOrderRet BillAddressBlock *' => 				array( 'SalesOrder', 'BillAddressBlock_*' ), 
			'SalesOrderRet ShipAddress' => 						array( null, null ), 
			'SalesOrderRet ShipAddress *' => 					array( 'SalesOrder', 'ShipAddress_*' ), 
			'SalesOrderRet ShipAddressBlock' => 				array( null, null ), 
			'SalesOrderRet ShipAddressBlock *' => 				array( 'SalesOrder', 'ShipAddressBlock_*' ), 
			'SalesOrderRet TermsRef' => 						array( null, null ), 
			'SalesOrderRet TermsRef *' => 						array( 'SalesOrder', 'Terms_*' ), 
			'SalesOrderRet SalesRepRef' => 						array( null, null ), 
			'SalesOrderRet SalesRepRef *' => 					array( 'SalesOrder', 'SalesRep_*' ), 
			'SalesOrderRet ShipMethodRef' => 					array( null, null ), 
			'SalesOrderRet ShipMethodRef *' => 					array( 'SalesOrder', 'ShipMethod_*' ), 
			'SalesOrderRet ItemSalesTaxRef' => 					array( null, null ), 
			'SalesOrderRet ItemSalesTaxRef *' => 				array( 'SalesOrder', 'ItemSalesTax_*' ), 
			'SalesOrderRet CustomerMsgRef' => 					array( null, null ), 
			'SalesOrderRet CustomerMsgRef *' => 				array( 'SalesOrder', 'CustomerMsg_*' ), 
			'SalesOrderRet CustomerSalesTaxCodeRef' => 			array( null, null ), 
			'SalesOrderRet CustomerSalesTaxCodeRef *' => 		array( 'SalesOrder', 'CustomerSalesTaxCode_*' ), 
			
			'SalesOrderRet LinkedTxn' => 				array( 'SalesOrder_LinkedTxn', null ), 
			'SalesOrderRet LinkedTxn TxnID' => 			array( 'SalesOrder_LinkedTxn', 'ToTxnID' ),
			'SalesOrderRet LinkedTxn *' => 				array( 'SalesOrder_LinkedTxn', '*' ),
			
			'SalesOrderRet SalesOrderLineRet' => 							array( 'SalesOrder_SalesOrderLine', null ), 
			'SalesOrderRet SalesOrderLineRet Desc' => 						array( 'SalesOrder_SalesOrderLine', 'Descrip' ), 
			'SalesOrderRet SalesOrderLineRet ItemRef' => 					array( null, null ), 
			'SalesOrderRet SalesOrderLineRet ItemRef *' => 					array( 'SalesOrder_SalesOrderLine', 'Item_*' ), 
			'SalesOrderRet SalesOrderLineRet OverrideUOMSetRef' => 			array( null, null ), 
			'SalesOrderRet SalesOrderLineRet OverrideUOMSetRef *' => 		array( 'SalesOrder_SalesOrderLine', 'OverrideUOMSet_*' ), 
			'SalesOrderRet SalesOrderLineRet ClassRef' => 					array( null, null ), 
			'SalesOrderRet SalesOrderLineRet ClassRef *' => 				array( 'SalesOrder_SalesOrderLine', 'Class_*' ), 
			'SalesOrderRet SalesOrderLineRet InventorySiteRef' => 			array( null, null ), 
			'SalesOrderRet SalesOrderLineRet InventorySiteRef *' => 		array( 'SalesOrder_SalesOrderLine', 'InventorySite_*' ), 
			'SalesOrderRet SalesOrderLineRet SalesTaxCodeRef' => 			array( null, null ), 
			'SalesOrderRet SalesOrderLineRet SalesTaxCodeRef *' => 			array( 'SalesOrder_SalesOrderLine', 'SalesTaxCode_*' ), 
			
			'SalesOrderRet SalesOrderLineRet DataExtRet' => 	array( null, null ), 
			'SalesOrderRet SalesOrderLineRet DataExtRet *' => 	array( 'DataExt', '*' ), 
			'SalesOrderRet SalesOrderLineRet *' => 				array( 'SalesOrder_SalesOrderLine', '*' ), 
			
			'SalesOrderRet SalesOrderLineGroupRet' => 							array( 'SalesOrder_SalesOrderLineGroup', null ), 
			'SalesOrderRet SalesOrderLineGroupRet Desc' => 						array( 'SalesOrder_SalesOrderLineGroup', 'Descrip' ), 
			'SalesOrderRet SalesOrderLineGroupRet ItemGroupRef' => 				array( null, null ), 
			'SalesOrderRet SalesOrderLineGroupRet ItemGroupRef *' => 			array( 'SalesOrder_SalesOrderLineGroup', 'ItemGroup_*' ),
			'SalesOrderRet SalesOrderLineGroupRet OverrideUOMSetRef' => 		array( null, null ), 
			'SalesOrderRet SalesOrderLineGroupRet OverrideUOMSetRef *' => 		array( 'SalesOrder_SalesOrderLineGroup', 'OverrideUOMSet_*' ), 
			
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet' => 						array( null, null ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet ItemRef' =>					array( null, null ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet ItemRef *' => 				array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', 'Item_*' ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet Desc' => 					array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', 'Descrip' ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet OverrideUOMSetRef' => 		array( null, null ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet OverrideUOMSetRef *' => 	array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', 'OverrideUOMSet_*' ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet SalesTaxCodeRef' => 		array( null, null ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet SalesTaxCodeRef *' => 		array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', 'SalesTaxCode_*' ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet ClassRef' => 				array( null, null ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet ClassRef *' => 				array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', 'Class_*' ), 
			
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet DataExtRet' => 				array( null, null ), 
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet *' => 						array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', '*' ), 
			
			'SalesOrderRet SalesOrderLineGroupRet DataExtRet' => 	array( null, null ), 
			'SalesOrderRet SalesOrderLineGroupRet DataExtRet *' => 	array( 'DataExt', '*' ), 
			'SalesOrderRet SalesOrderLineGroupRet *' => 			array( 'SalesOrder_SalesOrderLineGroup', '*' ), 
			
			'SalesOrderRet DataExtRet' => 	array( null, null ), 
			'SalesOrderRet DataExtRet *' => array( 'DataExt', '*' ), 
			'SalesOrderRet *' => 			array( 'SalesOrder', '*' ), 
			
			'SalesReceiptRet' => 								array( 'SalesReceipt', null ), 
			'SalesReceiptRet CustomerRef' => 					array( null, null ), 
			'SalesReceiptRet CustomerRef *' => 					array( 'SalesReceipt', 'Customer_*' ), 
			'SalesReceiptRet ClassRef' => 						array( null, null ), 
			'SalesReceiptRet ClassRef *' => 					array( 'SalesReceipt', 'Class_*' ), 
			'SalesReceiptRet TemplateRef' => 					array( null, null ), 
			'SalesReceiptRet TemplateRef *' => 					array( 'SalesReceipt', 'Template_*' ), 
			'SalesReceiptRet BillAddressBlock' => 				array( null, null ), 
			'SalesReceiptRet BillAddressBlock *' => 			array( 'SalesReceipt', 'BillAddressBlock_*' ), 
			'SalesReceiptRet BillAddress' => 					array( null, null ), 
			'SalesReceiptRet BillAddress *' => 					array( 'SalesReceipt', 'BillAddress_*' ), 
			'SalesReceiptRet ShipAddressBlock' => 				array( null, null ), 
			'SalesReceiptRet ShipAddressBlock *' => 			array( 'SalesReceipt', 'ShipAddressBlock_*' ), 
			'SalesReceiptRet ShipAddress' => 					array( null, null ), 
			'SalesReceiptRet ShipAddress *' => 					array( 'SalesReceipt', 'ShipAddress_*' ), 
			'SalesReceiptRet PaymentMethodRef' => 				array( null, null ), 
			'SalesReceiptRet PaymentMethodRef *' => 			array( 'SalesReceipt', 'PaymentMethod_*' ), 
			'SalesReceiptRet SalesRepRef' => 					array( null, null ), 
			'SalesReceiptRet SalesRepRef *' => 					array( 'SalesReceipt', 'SalesRep_*' ), 			
			'SalesReceiptRet ShipMethodRef' => 					array( null, null ), 
			'SalesReceiptRet ShipMethodRef *' => 				array( 'SalesReceipt', 'ShipMethod_*' ), 
			'SalesReceiptRet ItemSalesTaxRef' => 				array( null, null ), 
			'SalesReceiptRet ItemSalesTaxRef *' => 				array( 'SalesReceipt', 'ItemSalesTax_*' ), 
			'SalesReceiptRet CurrencyRef' =>					array( null, null ), 
			'SalesReceiptRet CurrencyRef *' => 					array( 'SalesReceipt', 'Currency_*' ), 
			'SalesReceiptRet CustomerMsgRef' => 				array( null, null ), 
			'SalesReceiptRet CustomerMsgRef *' => 				array( 'SalesReceipt', 'CustomerMsg_*' ), 
			'SalesReceiptRet CustomerSalesTaxCodeRef' => 		array( null, null ), 
			'SalesReceiptRet CustomerSalesTaxCodeRef *' => 		array( 'SalesReceipt', 'CustomerSalesTaxCode_*' ), 
			'SalesReceiptRet DepositToAccountRef' => 			array( null, null ), 
			'SalesReceiptRet DepositToAccountRef *' => 			array( 'SalesReceipt', 'DepositToAccount_*' ), 
			
			'SalesReceiptRet CreditCardTxnInfo' => 								array( null, null ), 
			'SalesReceiptRet CreditCardTxnInfo CreditCardTxnInputInfo' => 		array( null, null ), 
			'SalesReceiptRet CreditCardTxnInfo CreditCardTxnInputInfo *' => 	array( 'SalesReceipt', 'CreditCardTxnInfo_CreditCardTxnInputInfo_*' ), 
			'SalesReceiptRet CreditCardTxnInfo CreditCardTxnResultInfo' => 		array( null, null ), 
			'SalesReceiptRet CreditCardTxnInfo CreditCardTxnResultInfo *' => 	array( 'SalesReceipt', 'CreditCardTxnInfo_CreditCardTxnResultInfo_*' ), 
			'SalesReceiptRet CreditCardTxnInfo *' => 							array( 'SalesReceipt', 'CreditCardTxnInfo_*' ), 
			
			'SalesReceiptRet SalesReceiptLineRet' => 								array( null, null ), 
			'SalesReceiptRet SalesReceiptLineRet Desc' => 							array( 'SalesReceipt_SalesReceiptLine', 'Descrip' ), 
			'SalesReceiptRet SalesReceiptLineRet ItemRef' => 						array( null, null ), 
			'SalesReceiptRet SalesReceiptLineRet ItemRef *' => 						array( 'SalesReceipt_SalesReceiptLine', 'Item_*' ), 
			'SalesReceiptRet SalesReceiptLineRet OverrideUOMSetRef' => 				array( null, null ), 
			'SalesReceiptRet SalesReceiptLineRet OverrideUOMSetRef *' => 			array( 'SalesReceipt_SalesReceiptLine', 'OverrideUOMSet_*' ), 
			'SalesReceiptRet SalesReceiptLineRet ClassRef' => 						array( null, null ), 
			'SalesReceiptRet SalesReceiptLineRet ClassRef *' => 					array( 'SalesReceipt_SalesReceiptLine', 'Class_*' ), 
			'SalesReceiptRet SalesReceiptLineRet InventorySiteRef' => 				array( null, null ), 
			'SalesReceiptRet SalesReceiptLineRet InventorySiteRef *' => 			array( 'SalesReceipt_SalesReceiptLine', 'InventorySite_*' ), 
			'SalesReceiptRet SalesReceiptLineRet SalesTaxCodeRef' => 				array( null, null ), 
			'SalesReceiptRet SalesReceiptLineRet SalesTaxCodeRef *' => 				array( 'SalesReceipt_SalesReceiptLine', 'SalesTaxCode_*' ), 
			'SalesReceiptRet SalesReceiptLineRet CreditCardTxnInfo' => 				array( null, null ), 
			
			'SalesReceiptRet SalesReceiptLineRet CreditCardTxnInfo CreditCardTxnInputInfo' => 			array( null, null ), 
			'SalesReceiptRet SalesReceiptLineRet CreditCardTxnInfo CreditCardTxnInputInfo *' => 		array( 'SalesReceipt_SalesReceiptLine', 'CreditCardTxnInfo_CreditCardTxnInputInfo_*' ), 
			'SalesReceiptRet SalesReceiptLineRet CreditCardTxnInfo CreditCardTxnResultInfo' => 			array( null, null ), 
			'SalesReceiptRet SalesReceiptLineRet CreditCardTxnInfo CreditCardTxnResultInfo *' => 		array( 'SalesReceipt_SalesReceiptLine', 'CreditCardTxnInfo_CreditCardTxnResultInfo_*' ), 
			'SalesReceiptRet SalesReceiptLineRet CreditCardTxnInfo *' => 								array( 'SalesReceipt_SalesReceiptLine_CreditCardTxnInfo', '*' ), 
			
			'SalesReceiptRet SalesReceiptLineRet DataExtRet' => 	array( null, null ), 
			'SalesReceiptRet SalesReceiptLineRet DataExtRet *' => 	array( 'DataExt', '*' ), 
			'SalesReceiptRet SalesReceiptLineRet *' => 				array( 'SalesReceipt_SalesReceiptLine', '*' ), 
			
			'SalesReceiptRet SalesReceiptLineGroupRet' => 											array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet ItemGroupRef' => 								array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet ItemGroupRef *' => 							array( 'SalesReceipt_SalesReceiptLineGroup', 'ItemGroup_*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet OverrideUOMSetRef' => 						array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet OverrideUOMSetRef *' => 						array( 'SalesReceipt_SalesReceiptLineGroup', 'OverrideUOMSet_*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet Desc' => 										array( 'SalesReceipt_SalesReceiptLineGroup', 'Descrip' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet' => 						array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet ItemRef' => 				array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet ItemRef *' =>				array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'Item_*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet OverrideUOMSetRef' => 	array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet OverrideUOMSetRef *' => 	array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'OverrideUOMSet_*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet ClassRef' => 				array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet ClassRef *' => 			array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'Class_*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet SalesTaxCodeRef' => 		array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet SalesTaxCodeRef *' => 	array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'SalesTaxCode_*' ), 
			
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet Desc' => 											array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'Descrip' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet CreditCardTxnInfo' => 							array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet CreditCardTxnInfo CreditCardTxnInputInfo' => 		array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet CreditCardTxnInfo CreditCardTxnInputInfo *' => 	array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'CreditCardTxnInfo_CreditCardTxnInputInfo_*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet CreditCardTxnInfo CreditCardTxnResultInfo' => 	array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet CreditCardTxnInfo CreditCardTxnResultInfo *' => 	array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'CreditCardTxnInfo_CreditCardTxnResultInfo_*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet CreditCardTxnInfo *' => 							array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'CreditCardTxnInfo_*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet DataExtRet' => 									array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet DataExtRet *' => 									array( 'DataExt', '*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet *' => 											array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', '*' ), 
			
			'SalesReceiptRet SalesReceiptLineGroupRet DataExtRet' => 	array( null, null ), 
			'SalesReceiptRet SalesReceiptLineGroupRet DataExtRet *' => 	array( 'DataExt', '*' ), 
			'SalesReceiptRet SalesReceiptLineGroupRet *' => 			array( 'SalesReceipt_SalesReceiptLineGroup', '*' ), 
			
			'SalesReceiptRet DataExtRet' => 	array( null, null ), 
			'SalesReceiptRet DataExtRet *' => 	array( 'DataExt', '*' ), 
			'SalesReceiptRet *' => 				array( 'SalesReceipt', '*' ), 
			
			'SalesRepRet' => 								array( 'SalesRep', null ), 
			'SalesRepRet SalesRepEntityRef' => 				array( null, null ), 
			'SalesRepRet SalesRepEntityRef *' => 			array( 'SalesRep', 'SalesRepEntity_*' ), 
			'SalesRepRet *' => 								array( 'SalesRep', '*' ), 
			
			'SalesTaxCodeRet' => 							array( 'SalesTaxCode', null ),
			'SalesTaxCodeRet Desc' => 						array( 'SalesTaxCode', 'Descrip' ),  
			'SalesTaxCodeRet *' => 							array( 'SalesTaxCode', '*' ), 
			
			'ShipMethodRet' => 								array( 'ShipMethod', null ),
			'ShipMethodRet *' => 							array( 'ShipMethod', '*' ), 
			
			'StandardTermsRet' => 							array( 'StandardTerms', null ), 
			
			'StandardTermsRet *' => 						array( 'StandardTerms', '*' ),
			
			'StandardTermsRet' => 							array( null, null ), 
			'StandardTermsRet *' =>		 					array( 'StandardTerms', '*' ),
			
			'TemplateRet' => 								array( 'Template', null ), 
			'TemplateRet *' => 								array( 'Template', '*' ), 
			
			'TimeTrackingRet' => 							array( 'TimeTracking', null ),
			'TimeTrackingRet EntityRef' => 					array( null, null ),
			'TimeTrackingRet EntityRef *' => 				array( 'TimeTracking', 'Entity_*' ),
			'TimeTrackingRet CustomerRef' => 				array( null, null ),
			'TimeTrackingRet CustomerRef *' => 				array( 'TimeTracking', 'Customer_*' ),
			'TimeTrackingRet ItemServiceRef' => 			array( null, null ),
			'TimeTrackingRet ItemServiceRef *' => 			array( 'TimeTracking', 'ItemService_*' ),
			'TimeTrackingRet ClassRef' => 					array( null, null ),
			'TimeTrackingRet ClassRef *' => 				array( 'TimeTracking', 'Class_*' ),
			'TimeTrackingRet PayrollItemWageRef' => 		array( null, null ),
			'TimeTrackingRet PayrollItemWageRef *' => 		array( 'TimeTracking', 'PayrollItemWage_*' ),
			'TimeTrackingRet *' => 							array( 'TimeTracking', '*' ), 
			
			'UnitOfMeasureSetRet' => 				array( 'UnitOfMeasureSet', null ),
			'UnitOfMeasureSetRet BaseUnit' => 		array( null, null ), 
			'UnitOfMeasureSetRet BaseUnit *' => 	array( 'UnitOfMeasureSet', 'BaseUnit_*' ), 
			'UnitOfMeasureSetRet RelatedUnit' => 	array( null, null ), 
			'UnitOfMeasureSetRet RelatedUnit *' => 	array( 'UnitOfMeasureSet_RelatedUnit', '*' ), 
			'UnitOfMeasureSetRet DefaultUnit' => 	array( null, null ), 
			'UnitOfMeasureSetRet DefaultUnit *' => 	array( 'UnitOfMeasureSet_DefaultUnit', '*' ), 
			'UnitOfMeasureSetRet *' => 				array( 'UnitOfMeasureSet', '*' ), 
			
			'VehicleRet' => 						array( 'Vehicle', null ), 
			'VehicleRet Desc' => 					array( 'Vehicle', 'Descrip' ), 
			
			'VehicleRet *' => 						array( 'Vehicle', '*' ), 
			
			'VehicleMileageRet' => 						array( 'VehicleMileage', null ), 
			'VehicleMileageRet VehicleRef' => 			array( null, null ), 
			'VehicleMileageRet VehicleRef *' => 		array( 'VehicleMileage', 'Vehicle_*' ), 
			'VehicleMileageRet CustomerRef' => 			array( null, null ), 
			'VehicleMileageRet CustomerRef *' => 		array( 'VehicleMileage', 'Customer_*' ), 
			'VehicleMileageRet ItemRef' => 				array( null, null ), 
			'VehicleMileageRet ItemRef *' => 			array( 'VehicleMileage', 'Item_*' ), 
			'VehicleMileageRet ClassRef' => 			array( null, null ), 
			'VehicleMileageRet ClassRef *' => 			array( 'VehicleMileage', 'Class_*' ), 
			'VehicleMileageRet *' => 					array( 'VehicleMileage', '*' ), 
			
			'VendorRet' => 							array( 'Vendor', null ), 
			'VendorRet VendorAddress' => 			array( null, null ), 
			'VendorRet VendorAddress *' => 			array( 'Vendor', 'VendorAddress_*' ), 
			'VendorRet VendorAddressBlock' => 		array( null, null ), 
			'VendorRet VendorAddressBlock *' => 	array( 'Vendor', 'VendorAddressBlock_*' ), 
			'VendorRet VendorTypeRef' => 			array( null, null ), 
			'VendorRet VendorTypeRef *' => 			array( 'Vendor', 'VendorType_*' ), 
			'VendorRet TermsRef' => 				array( null, null ), 
			'VendorRet TermsRef *' => 				array( 'Vendor', 'Terms_*' ), 
			'VendorRet BillingRateRef' => 			array( null, null ), 
			'VendorRet BillingRateRef *' => 		array( 'Vendor', 'BillingRate_*' ), 
			'VendorRet DataExtRet' => 				array( null, null ), 
			'VendorRet DataExtRet *' => 			array( 'DataExt', '*' ), 
			'VendorRet *' => 						array( 'Vendor', '*' ),
			
			'VendorCreditRet' => 					array( 'VendorCredit', null, ),
			'VendorCreditRet VendorRef' => 			array( null, null ), 
			'VendorCreditRet VendorRef *' => 		array( 'VendorCredit', 'Vendor_*' ), 
			'VendorCreditRet APAccountRef' => 		array( null, null ), 
			'VendorCreditRet APAccountRef *' =>		array( 'VendorCredit', 'APAccount_*' ), 
			
			'VendorCreditRet LinkedTxn' => 			array( null, null ), 
			'VendorCreditRet LinkedTxn TxnID' => 	array( 'VendorCredit_LinkedTxn', 'ToTxnID' ),
			'VendorCreditRet LinkedTxn *' => 		array( 'VendorCredit_LinkedTxn', '*' ), 
			
			'VendorCreditRet ExpenseLineRet' => 					array( null, null ), 
			'VendorCreditRet ExpenseLineRet AccountRef' => 			array( null, null ), 
			'VendorCreditRet ExpenseLineRet AccountRef *' => 		array( 'VendorCredit_ExpenseLine', 'Account_*' ), 
			'VendorCreditRet ExpenseLineRet CustomerRef' => 		array( null, null ), 
			'VendorCreditRet ExpenseLineRet CustomerRef *' => 		array( 'VendorCredit_ExpenseLine', 'Customer_*' ), 
			'VendorCreditRet ExpenseLineRet ClassRef' => 			array( null, null ), 
			'VendorCreditRet ExpenseLineRet ClassRef *' => 			array( 'VendorCredit_ExpenseLine', 'Class_*' ), 
			'VendorCreditRet ExpenseLineRet *' => 					array( 'VendorCredit_ExpenseLine', '*' ), 
			
			'VendorCreditRet ItemLineRet' => 							array( null, null ),
			'VendorCreditRet ItemLineRet Desc' => 						array( 'VendorCredit_ItemLine', 'Descrip' ), 
			'VendorCreditRet ItemLineRet ItemRef' => 					array( null, null ), 
			'VendorCreditRet ItemLineRet ItemRef *' => 					array( 'VendorCredit_ItemLine', 'Item_*' ), 
			'VendorCreditRet ItemLineRet OverrideUOMSetRef' => 			array( null, null ), 
			'VendorCreditRet ItemLineRet OverrideUOMSetRef *' => 		array( 'VendorCredit_ItemLine', 'OverrideUOMSet_*' ), 
			'VendorCreditRet ItemLineRet CustomerRef' => 				array( null, null ), 
			'VendorCreditRet ItemLineRet CustomerRef *' => 				array( 'VendorCredit_ItemLine', 'Customer_*' ), 
			'VendorCreditRet ItemLineRet ClassRef' => 					array( null, null ), 
			'VendorCreditRet ItemLineRet ClassRef *' => 				array( 'VendorCredit_ItemLine', 'Class_*' ), 
			'VendorCreditRet ItemLineRet *' => 							array( 'VendorCredit_ItemLine', '*' ), 
			
			'VendorCreditRet ItemGroupLineRet' => 									array( null, null ),
			'VendorCreditRet ItemGroupLineRet Desc' => 								array( 'VendorCredit_ItemGroupLine', 'Descrip' ),  
			'VendorCreditRet ItemGroupLineRet ItemGroupRef' => 						array( null, null ), 
			'VendorCreditRet ItemGroupLineRet ItemGroupRef *' => 					array( 'VendorCredit_ItemGroupLine', 'ItemGroup_*' ), 
			'VendorCreditRet ItemGroupLineRet OverrideUOMSetRef' => 				array( null, null ), 
			'VendorCreditRet ItemGroupLineRet OverrideUOMSetRef *' => 				array( 'VendorCredit_ItemGroupLine', 'OverrideUOMSet_*' ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet' => 						array( null, null ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet ItemRef' => 				array( null, null ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet ItemRef *' => 			array( 'VendorCredit_ItemGroupLine_ItemLine', 'Item_*' ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet Desc' => 					array( 'VendorCredit_ItemGroupLine_ItemLine', 'Descrip' ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet OverrideUOMSetRef' => 	array( null, null ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet OverrideUOMSetRef *' => 	array( 'VendorCredit_ItemGroupLine_ItemLine', 'OverrideUOMSet_*' ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet CustomerRef' => 			array( null, null ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet CustomerRef *' => 		array( 'VendorCredit_ItemGroupLine_ItemLine', 'Customer_*' ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet ClassRef' => 				array( null, null ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet ClassRef *' => 			array( 'VendorCredit_ItemGroupLine_ItemLine', 'Class_*' ), 
			'VendorCreditRet ItemGroupLineRet ItemLineRet *' => 					array( 'VendorCredit_ItemGroupLine_ItemLine', '*' ), 
			'VendorCreditRet ItemGroupLineRet *' => 								array( 'VendorCredit_ItemGroupLine', '*' ), 
			
			'VendorCreditRet DataExtRet' => 	array( null, null ), 
			'VendorCreditRet DataExtRet *' => 	array( 'DataExt', '*' ), 
			'VendorCreditRet *' => 				array( 'VendorCredit', '*' ),  
			
			'VendorTypeRet' => 						array( 'VendorType', null ), 
			'VendorTypeRet ParentRef' => 			array( null, null ), 
			'VendorTypeRet ParentRef *' => 			array( 'VendorType', 'Parent_*' ), 
			'VendorTypeRet *' => 					array( 'VendorType', '*' ), 
			
			'WorkersCompCodeRet' => 				array( 'WorkersCompCode', null ), 
			'WorkersCompCodeRet Desc' => 			array( 'WorkersCompCode', 'Descrip' ), 
			'WorkersCompCodeRet RateHistory' => 	array( null, null ), 
			'WorkersCompCodeRet RateHistory *' => 	array( 'WorkersCompCode_RateHistory', '*' ), 
			'WorkersCompCodeRet *' => 				array( 'WorkersCompCode', '*' ), 
			);
			
		static $sql_to_xml = null;
		if (is_null($sql_to_xml))
		{
			foreach ($xml_to_sql as $xml => $sql)
			{
				$sql_to_xml[$sql[0] . '.' . $sql[1]] = $xml;
			}
		}
		
		// Mapping of:
		//	XPATH => array(
		//		array( table => extra field ), 
		//		array( another table => another extra field ), 	
		static $xml_to_sql_others = array(
			'AccountRet TaxLineInfoRet' => 											array(
				array( 'Account_TaxLineInfo', 'Account_ListID'),
				array( 'Account_TaxLineInfo', 'Account_FullName' ), 
				),
			'AccountRet DataExtRet' => 												array(
				array( 'DataExt', 'EntityType' ),
				array( 'DataExt', 'TxnType' ),
				array( 'DataExt', 'Entity_ListID' ),
				array( 'DataExt', 'Txn_TxnID' ),
				),
			'BillingRateRet BillingRatePerItemRet' => 								array( 
				array( 'BillingRate_BillingRatePerItem', 'BillingRate_ListID' ),
				array( 'BillingRate_BillingRatePerItem', 'BillingRate_FullName' ), 
				),
			'BillPaymentCheckRet' => array(
				array( 'BillPaymentCheck', 'ExchangeRate' ), 
				array( 'BillPaymentCheck', 'AmountInHomeCurrency' ), 
				), 
			'BillPaymentCheckRet AppliedToTxnRet' => 								array( 
				array( 'BillPaymentCheck_AppliedToTxn', 'FromTxnID' ),
				array( 'BillPaymentCheck_AppliedToTxn', 'BillPaymentCheck_TxnID' ), 
				),
			'BillPaymentCreditCardRet AppliedToTxnRet' => 							array( 
				array( 'BillPaymentCreditCard_AppliedToTxn', 'FromTxnID' ),
				array( 'BillPaymentCreditCard_AppliedToTxn', 'BillPaymentCreditCard_TxnID' ), 
				),
			'BillRet' => 															array(
				array( 'Bill', 'Tax1Total' ),
				array( 'Bill', 'Tax2Total' ),
				//array( 'Bill', 'ExchangeRate' ), 
				),
			'BillRet LinkedTxn' => 													array( 
				array( 'Bill_LinkedTxn', 'FromTxnID' ),
				array( 'Bill_LinkedTxn', 'Bill_TxnID' ), 
				array( 'Bill_LinkedTxn', 'LinkType' ),
				),	
			'BillRet ExpenseLineRet' => 											array(
				array( 'Bill_ExpenseLine', 'Bill_TxnID' ), 
				array( 'Bill_ExpenseLine', 'SortOrder' ), 
				),
			'BillRet ItemLineRet' => 												array(
				array( 'Bill_ItemLine', 'Bill_TxnID' ), 
				array( 'Bill_ItemLine', 'SortOrder' ), 
				),
			'BillRet ItemGroupLineRet' => 											array(
				array( 'Bill_ItemGroupLine', 'Bill_TxnID' ), 
				array( 'Bill_ItemGroupLine', 'TxnLineID' ), 
				array( 'Bill_ItemGroupLine', 'SortOrder' ), 
				),
			'BillRet ItemGroupLineRet ItemLineRet' => 								array(
				array( 'Bill_ItemGroupLine_ItemLine', 'Bill_ItemGroupLine_TxnLineID' ), 
				array( 'Bill_ItemGroupLine_ItemLine', 'Bill_TxnID' ), 
				array( 'Bill_ItemGroupLine_ItemLine', 'SortOrder' ), 
				),
			'ChargeRet' => 															array(
				array( 'Charge', 'IsPaid' ),
				),
			'CheckRet ExpenseLineRet' => 											array(
				array( 'Check_ExpenseLine', 'Check_TxnID' ), 
				array( 'Check_ExpenseLine', 'SortOrder' ), 
				), 
			'CheckRet ItemGroupLineRet' => 											array(
				array( 'Check_ItemGroupLine', 'Check_TxnID' ), 
				array( 'Check_ItemGroupLine', 'SortOrder' ), 
				), 
			'CheckRet ItemGroupLineRet ItemLineRet' => 								array(
				array( 'Check_ItemGroupLine_ItemLine', 'Check_TxnID' ), 
				array( 'Check_ItemGroupLine_ItemLine', 'Check_ItemGroupLine_TxnLineID' ), 
				array( 'Check_ItemGroupLine_ItemLine', 'SortOrder' ), 
				), 
			'CheckRet ItemLineRet' => 												array(
				array( 'Check_ItemLine', 'Check_TxnID' ), 
				array( 'Check_ItemLine', 'SortOrder' ), 
				), 
			'CheckRet LinkedTxn' => 												array( 
				array( 'Check_LinkedTxn', 'FromTxnID' ),
				array( 'Check_LinkedTxn', 'Check_TxnID' ), 
				array( 'Check_LinkedTxn', 'LinkType' ),
				),	
			'CompanyRet SubscribedServices Service' => 								array( 
				array( 'Company_SubscribedServices_Service', 'Company_CompanyName' ),
				),	
			'CreditCardChargeRet ExpenseLineRet' => 								array( 
				array( 'CreditCardCharge_ExpenseLine', 'CreditCardCharge_TxnID' ),
				array( 'CreditCardCharge_ExpenseLine', 'SortOrder' ), 
				),	
			'CreditCardChargeRet ItemLineRet' => 									array( 
				array( 'CreditCardCharge_ItemLine', 'CreditCardCharge_TxnID' ),
				array( 'CreditCardCharge_ItemLine', 'SortOrder' ), 
				),	
			'CreditCardChargeRet ItemGroupLineRet' => 								array( 
				array( 'CreditCardCharge_ItemGroupLine', 'CreditCardCharge_TxnID' ),
				array( 'CreditCardCharge_ItemGroupLine', 'SortOrder' ), 
				),	
			'CreditCardChargeRet ItemGroupLineRet ItemLineRet' => 					array( 
				array( 'CreditCardCharge_ItemGroupLine_ItemLine', 'CreditCardCharge_TxnID' ),
				array( 'CreditCardCharge_ItemGroupLine_ItemLine', 'CreditCardCharge_ItemGroupLine_TxnLineID' ),
				array( 'CreditCardCharge_ItemGroupLine_ItemLine', 'SortOrder' ), 
				),	
			'CreditCardCreditRet ExpenseLineRet' => 								array( 
				array( 'CreditCardCredit_ExpenseLine', 'CreditCardCredit_TxnID' ),
				array( 'CreditCardCredit_ExpenseLine', 'SortOrder' ), 
				),	
			'CreditCardCreditRet ItemLineRet' => 									array( 
				array( 'CreditCardCredit_ItemLine', 'CreditCardCredit_TxnID' ),
				array( 'CreditCardCredit_ItemLine', 'SortOrder' ), 
				),	
			'CreditCardCreditRet ItemGroupLineRet' => 								array( 
				array( 'CreditCardCredit_ItemGroupLine', 'CreditCardCredit_TxnID' ),
				array( 'CreditCardCredit_ItemGroupLine', 'SortOrder' ), 
				),	
			'CreditCardCreditRet ItemGroupLineRet ItemLineRet' => 					array( 
				array( 'CreditCardCredit_ItemGroupLine_ItemLine', 'CreditCardCredit_TxnID' ),
				array( 'CreditCardCredit_ItemGroupLine_ItemLine', 'CreditCardCredit_ItemGroupLine_TxnLineID' ),
				array( 'CreditCardCredit_ItemGroupLine_ItemLine', 'SortOrder' ), 
				),	
			'CreditMemoRet CreditMemoLineRet' => 									array( 
				array( 'CreditMemo_CreditMemoLine', 'CreditMemo_TxnID' ),
				array( 'CreditMemo_CreditMemoLine', 'SortOrder' ), 
				),	
			'CreditMemoRet CreditMemoLineGroupRet' => 								array( 
				array( 'CreditMemo_CreditMemoLineGroup', 'CreditMemo_TxnID' ),
				array( 'CreditMemo_CreditMemoLineGroup', 'SortOrder' ), 
				),	
			'CreditMemoRet CreditMemoLineGroupRet CreditMemoLineRet' => 			array( 
				array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'CreditMemo_TxnID' ),
				array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'CreditMemo_CreditMemoLineGroup_TxnLineID' ),
				array( 'CreditMemo_CreditMemoLineGroup_CreditMemoLine', 'SortOrder' ), 
				),	
			'CreditMemoRet LinkedTxn' => 											array( 
				array( 'CreditMemo_LinkedTxn', 'FromTxnID' ),
				array( 'CreditMemo_LinkedTxn', 'CreditMemo_TxnID' ), 
				array( 'CreditMemo_LinkedTxn', 'LinkType' ),
				),
			'DataExtDefRet AssignToObject' => 										array(
				array( 'DataExtDef_AssignToObject', 'DataExtDef_OwnerID' ),
				array( 'DataExtDef_AssignToObject', 'DataExtDef_DataExtName' ), 
				),
			'DepositRet DepositLineRet' => 											array( 
				array( 'Deposit_DepositLine', 'Deposit_TxnID' ),
				array( 'Deposit_DepositLine', 'SortOrder' ), 
				),	
			'EmployeeRet EmployeePayrollInfo Earnings' => 							array( 
				array( 'Employee_Earnings', 'Employee_ListID' ),
				),	
			'EstimateRet EstimateLineRet' => 										array(
				array( 'Estimate_EstimateLine', 'Estimate_TxnID' ), 
				array( 'Estimate_EstimateLine', 'SortOrder' ), 
				),
			'EstimateRet EstimateLineGroupRet' => 									array(
				array( 'Estimate_EstimateLineGroup', 'Estimate_TxnID' ), 
				array( 'Estimate_EstimateLineGroup', 'SortOrder' ), 
				),
			'EstimateRet EstimateLineGroupRet EstimateLineRet' => 					array(
				array( 'Estimate_EstimateLineGroup_EstimateLine', 'Estimate_TxnID' ), 
				array( 'Estimate_EstimateLineGroup_EstimateLine', 'Estimate_EstimateLineGroup_TxnLineID' ), 
				array( 'Estimate_EstimateLineGroup_EstimateLine', 'SortOrder' ), 
				),
			'EstimateRet LinkedTxn' => 												array(
				array( 'Estimate_LinkedTxn', 'FromTxnID' ),
				array( 'Estimate_LinkedTxn', 'Estimate_TxnID' ), 
				array( 'Estimate_LinkedTxn', 'LinkType' ),
				),	
			'InventoryAdjustmentRet InventoryAdjustmentLineRet' => 					array(
				array( 'InventoryAdjustment_InventoryAdjustmentLine', 'InventoryAdjustment_TxnID' ), 
				array( 'InventoryAdjustment_InventoryAdjustmentLine', 'SortOrder' ), 
				
				/*
				array( 'InventoryAdjustment_InventoryAdjustmentLine', 'QuantityAdjustment_NewQuantity' ), 
				array( 'InventoryAdjustment_InventoryAdjustmentLine', 'QuantityAdjustment_QuantityDifference' ), 
				
				array( 'InventoryAdjustment_InventoryAdjustmentLine', 'ValueAdjustment_NewQuantity' ), 
				array( 'InventoryAdjustment_InventoryAdjustmentLine', 'ValueAdjustment_QuantityDifference' ), 
				array( 'InventoryAdjustment_InventoryAdjustmentLine', 'ValueAdjustment_NewValue' ), 
				array( 'InventoryAdjustment_InventoryAdjustmentLine', 'ValueAdjustment_ValueDifference' ), 
				*/
				),			
			'InvoiceRet InvoiceLineRet' => 											array(
				array( 'Invoice_InvoiceLine', 'Invoice_TxnID' ), 
				array( 'Invoice_InvoiceLine', 'SortOrder' ), 
				),
			'InvoiceRet InvoiceLineGroupRet' => 									array(
				array( 'Invoice_InvoiceLineGroup', 'Invoice_TxnID' ), 
				array( 'Invoice_InvoiceLineGroup', 'SortOrder' ), 
				),
			'InvoiceRet InvoiceLineGroupRet InvoiceLineRet' => 						array(
				array( 'Invoice_InvoiceLineGroup_InvoiceLine', 'Invoice_TxnID' ), 
				array( 'Invoice_InvoiceLineGroup_InvoiceLine', 'Invoice_InvoiceLineGroup_TxnLineID' ), 
				array( 'Invoice_InvoiceLineGroup_InvoiceLine', 'SortOrder' ), 
				),
			'InvoiceRet LinkedTxn' => 												array(
				array( 'Invoice_LinkedTxn', 'FromTxnID' ),
				array( 'Invoice_LinkedTxn', 'Invoice_TxnID' ), 
				array( 'Invoice_LinkedTxn', 'LinkType' ),
				),
			'ItemGroupRet ItemGroupLine' => 										array(
				array( 'ItemGroup_ItemGroupLine', 'ItemGroup_ListID' ), 
				array( 'ItemGroup_ItemGroupLine', 'SortOrder' ), 
				),
			'ItemInventoryAssemblyRet ItemInventoryAssemblyLine' => 				array(
				array( 'ItemInventoryAssembly_ItemInventoryAssemblyLine', 'ItemInventoryAssembly_ListID' ), 
				array( 'ItemInventoryAssembly_ItemInventoryAssemblyLine', 'SortOrder' ), 
				),
			'ItemReceiptRet ExpenseLineRet' => 										array(
				array( 'ItemReceipt_ExpenseLine', 'ItemReceipt_TxnID' ), 
				array( 'ItemReceipt_ExpenseLine', 'SortOrder' ), 
				),
			'ItemReceiptRet ItemLineRet' => 										array(
				array( 'ItemReceipt_ItemLine', 'ItemReceipt_TxnID' ), 
				array( 'ItemReceipt_ItemLine', 'SortOrder' ), 
				),
			'ItemReceiptRet ItemGroupLineRet' => 									array(
				array( 'ItemReceipt_ItemGroupLine', 'ItemReceipt_TxnID' ), 
				array( 'ItemReceipt_ItemGroupLine', 'SortOrder' ), 
				),
			'ItemReceiptRet ItemGroupLineRet ItemLineRet' => 						array(
				array( 'ItemReceipt_ItemGroupLine_ItemLine', 'ItemReceipt_TxnID' ), 
				array( 'ItemReceipt_ItemGroupLine_ItemLine', 'ItemReceipt_ItemGroupLine_TxnLineID' ), 
				array( 'ItemReceipt_ItemGroupLine_ItemLine', 'SortOrder' ), 
				),
			'ItemReceiptRet LinkedTxn' => 											array(
				array( 'ItemReceipt_LinkedTxn', 'FromTxnID' ),
				array( 'ItemReceipt_LinkedTxn', 'ItemReceipt_TxnID' ), 
				array( 'ItemReceipt_LinkedTxn', 'LinkType' ),
				),
			'ItemSalesTaxGroupRet ItemSalesTaxRef' => 								array(
				array( 'ItemSalesTaxGroup_ItemSalesTax', 'ItemSalesTaxGroup_ListID' ),
				),
			'JournalEntryRet JournalDebitLine' => 									array(
				array( 'JournalEntry_JournalDebitLine', 'JournalEntry_TxnID' ),
				array( 'JournalEntry_JournalDebitLine', 'SortOrder' ), 
				),
			'JournalEntryRet JournalCreditLine' => 									array(
				array( 'JournalEntry_JournalCreditLine', 'JournalEntry_TxnID' ),
				array( 'JournalEntry_JournalCreditLine', 'SortOrder' ),
				),
			'PriceLevelRet PriceLevelPerItemRet' => 								array(
				array( 'PriceLevel_PriceLevelPerItem', 'PriceLevel_ListID' ),
				),
			'PurchaseOrderRet PurchaseOrderLineRet' => 								array(
				array( 'PurchaseOrder_PurchaseOrderLine', 'PurchaseOrder_TxnID' ),
				array( 'PurchaseOrder_PurchaseOrderLine', 'SortOrder' ),
				),
			'PurchaseOrderRet PurchaseOrderLineGroupRet' => 						array(
				array( 'PurchaseOrder_PurchaseOrderLineGroup', 'PurchaseOrder_TxnID' ),
				array( 'PurchaseOrder_PurchaseOrderLineGroup', 'SortOrder' ),
				),
			'PurchaseOrderRet PurchaseOrderLineGroupRet PurchaseOrderLineRet' => 	array(
				array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', 'PurchaseOrder_TxnID' ),
				array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', 'PurchaseOrder_PurchaseOrderLineGroup_TxnLineID' ),
				array( 'PurchaseOrder_PurchaseOrderLineGroup_PurchaseOrderLine', 'SortOrder' ),
				),
			'PurchaseOrderRet LinkedTxn' => 										array(
				array( 'PurchaseOrder_LinkedTxn', 'FromTxnID' ),
				array( 'PurchaseOrder_LinkedTxn', 'PurchaseOrder_TxnID' ),
				array( 'PurchaseOrder_LinkedTxn', 'LinkType' ),
				),
			'ReceivePaymentRet AppliedToTxnRet' => 									array(
				array( 'ReceivePayment_AppliedToTxn', 'FromTxnID' ),
				array( 'ReceivePayment_AppliedToTxn', 'ReceivePayment_TxnID' ),
				),
			'SalesOrderRet SalesOrderLineRet' => 									array(
				array( 'SalesOrder_SalesOrderLine', 'SalesOrder_TxnID' ),
				array( 'SalesOrder_SalesOrderLine', 'SortOrder' ),
				),
			'SalesOrderRet SalesOrderLineGroupRet' => 								array(
				array( 'SalesOrder_SalesOrderLineGroup', 'SalesOrder_TxnID' ),
				array( 'SalesOrder_SalesOrderLineGroup', 'SortOrder' ),
				),
			'SalesOrderRet SalesOrderLineGroupRet SalesOrderLineRet' => 			array(
				array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', 'SalesOrder_TxnID' ),
				array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', 'SalesOrder_SalesOrderLineGroup_TxnLineID' ),
				array( 'SalesOrder_SalesOrderLineGroup_SalesOrderLine', 'SortOrder' ),
				),
			'SalesOrderRet LinkedTxn' => 											array(
				array( 'SalesOrder_LinkedTxn', 'FromTxnID' ),
				array( 'SalesOrder_LinkedTxn', 'SalesOrder_TxnID' ),
				array( 'SalesOrder_LinkedTxn', 'LinkType' ),
				),
			'SalesReceiptRet SalesReceiptLineRet' => 								array(
				array( 'SalesReceipt_SalesReceiptLine', 'SalesReceipt_TxnID' ),
				array( 'SalesReceipt_SalesReceiptLine', 'SortOrder' ),
				),
			'SalesReceiptRet SalesReceiptLineGroupRet' => 							array(
				array( 'SalesReceipt_SalesReceiptLineGroup', 'SalesReceipt_TxnID' ),
				array( 'SalesReceipt_SalesReceiptLineGroup', 'SortOrder' ),
				),
			'SalesReceiptRet SalesReceiptLineGroupRet SalesReceiptLineRet' => 		array(
				array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'SalesReceipt_TxnID' ),
				array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'SalesReceipt_SalesReceiptLineGroup_TxnLineID' ),
				array( 'SalesReceipt_SalesReceiptLineGroup_SalesReceiptLine', 'SortOrder' ),
				),
			'UnitOfMeasureSetRet RelatedUnit' => 									array(
				array( 'UnitOfMeasureSet_RelatedUnit', 'UnitOfMeasureSet_ListID' ),
				),
			'UnitOfMeasureSetRet DefaultUnit' => 									array(
				array( 'UnitOfMeasureSet_DefaultUnit', 'UnitOfMeasureSet_ListID' ),
				),
			'VendorCreditRet ExpenseLineRet' => 									array(
				array( 'VendorCredit_ExpenseLine', 'VendorCredit_TxnID' ), 
				array( 'VendorCredit_ExpenseLine', 'SortOrder' ), 
				),
			'VendorCreditRet ItemLineRet' => 										array(
				array( 'VendorCredit_ItemLine', 'VendorCredit_TxnID' ), 
				array( 'VendorCredit_ItemLine', 'SortOrder' ), 
				),
			'VendorCreditRet ItemGroupLineRet' => 									array(
				array( 'VendorCredit_ItemGroupLine', 'VendorCredit_TxnID' ), 
				array( 'VendorCredit_ItemGroupLine', 'SortOrder' ), 
				),
			'VendorCreditRet ItemGroupLineRet ItemLineRet' => 						array(
				array( 'VendorCredit_ItemGroupLine_ItemLine', 'VendorCredit_TxnID' ), 
				array( 'VendorCredit_ItemGroupLine_ItemLine', 'VendorCredit_ItemGroupLine_TxnLineID' ), 
				array( 'VendorCredit_ItemGroupLine_ItemLine', 'SortOrder' ), 
				),
			'VendorCreditRet LinkedTxn' => 											array(
				array( 'VendorCredit_LinkedTxn', 'FromTxnID' ),
				array( 'VendorCredit_LinkedTxn', 'VendorCredit_TxnID' ),
				array( 'VendorCredit_LinkedTxn', 'LinkType' ),
				),
			'WorkersCompCodeRet RateHistory' => 									array(
				array( 'WorkersCompCode_RateHistory', 'WorkersCompCode_ListID' ), 
				),
			); 
			
		if ($mode == QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL)		// map the QuickBooks XML tags to SQL schema
		{
			$path = trim($path_or_tablefield);
			$spaces = substr_count($path, ' ');
			$map = array( null, null );		// default map
			
			// @todo Can we break out of this big loop early to improve performance? 
			
			foreach ($xml_to_sql as $pattern => $table_and_field)
			{
				if (substr_count($pattern, ' ') == $spaces and 		// check path depth
					false !== strpos($pattern, '*'))
				{
					if (QuickBooks_SQL_Schema::_fnmatch($pattern, $path)) 	// check it to see if this pattern matches
					{
						foreach (explode(' ', $pattern) as $kpart => $vpart)
						{
							if ($vpart == '*')
							{
								$xml = explode(' ', $path); 
								$match = $xml[$kpart];
								
								/*
								if ($options['uppercase_tables'])
								{
									$table_and_field[0] = strtoupper($table_and_field[0]);
								}
								else if ($options['lowercase_tables'])
								{
									$table_and_field[0] = strtolower($table_and_field[0]);
								}
								
								if ($options['uppercase_fields'])
								{
									$table_and_field[1] = strtoupper($table_and_field[1]);
								}
								else if ($options['lowercase_fields'])
								{
									$table_and_field[1] = strtolower($table_and_field[1]);
								}
								*/
								
								$map = array(
									$table_and_field[0], 
									str_replace('*', $match, $table_and_field[1]), 
									);
								
								QuickBooks_SQL_Schema::_applyOptions($map, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $options);
								
								break;
							}
						}
					}
				}
				else if ($pattern == $path)
				{
					$map = $table_and_field;
					QuickBooks_SQL_Schema::_applyOptions($map, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $options);
					
					if (isset($xml_to_sql_others[$pattern]))
					{
						$others = $xml_to_sql_others[$pattern];
						foreach ($others as $key => $other)
						{
							QuickBooks_SQL_Schema::_applyOptions($other, QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL, $options);
							$others[$key] = $other;
						}
					}
					
					break;
				}
			}
			
			//print_r($map);
			//print_r($others);
		}
		else		// mode = QUICKBOOKS_SQL_SCHEMA_MAP_TO_XML		map the SQL schema back to QuickBooks qbXML tags
		{
			$tablefield = trim($path_or_tablefield);
			$tablefield_compare = strtolower($tablefield);
			
			$underscores = substr_count($tablefield, '_');
			$map = '';
			
			foreach ($sql_to_xml as $pattern => $path)
			{
				$pattern_compare = strtolower($pattern);
				if ($pattern_compare == $tablefield_compare)
				{
					$map = $path;
					break;
				}
				else if (substr_count($pattern, '_') == $underscores and 
					false !== strpos($pattern, '*'))
				{
					if (QuickBooks_SQL_Schema::_fnmatch($pattern_compare, $tablefield_compare))
					{
						$tmp_pattern = explode('.', $pattern);
						if (count($tmp_pattern) == 2 and 
							$tmp_pattern[1] == '*')
						{
							// table.* pattern
							$tmp_tablefield = explode('.', $tablefield);
							
							$map = str_replace('*', $tmp_tablefield[1], $path);
							break;
						}
						else
						{
							//print('matched ' . $tablefield . ' to ' . $path . ' (' . $pattern . ') ' . "\n");
							
							$pos = strpos($pattern, '*');
							$field = substr($tablefield, $pos);
							
							$map = str_replace('*', $field, $path);
							break;
						}
					}
				}
			}
		}
	}
		
	static protected function _applyOptions(&$path_or_arrtablefield, $mode, $options)
	{
		$applied = 0;
		
		$defaults = array(
			'desc_to_descrip' => 			true, 
			'uppercase_tables' => 			false, 
			'lowercase_tables' => 			true, 
			'uppercase_fields' => 			false,
			'lowercase_fields' => 			false,
			'prepend_parent' => 			true,  
			);
			
		$options = array_merge($defaults, $options);
			
		if ($mode == QUICKBOOKS_SQL_SCHEMA_MAP_TO_SQL)
		{
			
			if ($options['uppercase_tables'])
			{
				$path_or_arrtablefield[0] = strtoupper($path_or_arrtablefield[0]);
				$applied++;
			}
			else if ($options['lowercase_tables'])
			{
				$path_or_arrtablefield[0] = strtolower($path_or_arrtablefield[0]);
				$applied++;
			}
			
			if ($options['uppercase_fields'])
			{
				$path_or_arrtablefield[1] = strtoupper($path_or_arrtablefield[1]);
				$applied++;
			}
			else if ($options['lowercase_fields'])
			{
				$path_or_arrtablefield[1] = strtolower($path_or_arrtablefield[1]);
				$applied++;
			}
				
			return $applied;
		}
		else
		{
			
		}
	}
			
	/**
	 * Map a qbXML XML field type to it's SQL type definition
	 * 
	 * @param string $object_type
	 * @param string $field
	 * @param string $qb_type
	 * @return array 
	 * @TODO We case the input to lowercase, and so the array has to be in lowercase. Is there a better way to do this?
	 */
	static public function mapFieldToSQLDefinition($object_type, $field, $qb_type)
	{
		// array( type, length, default )
		
		static $overrides = array(
			'billpaymentcheck' => array(
				'istobeprinted' => array( null, null, 'null' ), 
				), 
			'check' => array(
				'istobeprinted' => array( null, null, 'null' ), 
				),
			'creditmemo' => array(
				'ispending' => array( null, null, 'null' ), 
				),
			'creditmemo_creditmemoline' => array(
				'creditcardtxninputinfo_expirationmonth' => array( null, null, 'null' ),
				'creditcardtxninputinfo_expirationyear' => array( null, null, 'null' ),
				'creditcardtxnresultinfo_resultcode' => array( null, null, 'null' ),
				'creditcardtxnresultinfo_paymentgroupingcode' => array( null, null, 'null' ),
				'creditcardtxnresultinfo_txnauthorizationstamp' => array( null, null, 'null' ),
				), 
			'creditmemo_creditmemolinegroup_creditmemoline' => array(
				'creditcardtxninfo_creditcardtxninputinfo_expirationmonth' => array( null, null, 'null' ),
				'creditcardtxninfo_creditcardtxninputinfo_expirationyear' => array( null, null, 'null' ),
				'creditcardtxninfo_creditcardtxnresultinfo_resultcode' => array( null, null, 'null' ),
				'creditcardtxninfo_creditcardtxnresultinfo_paymentgroupingcode' => array( null, null, 'null' ),
				'creditcardtxninfo_creditcardtxnresultinfo_txnauthorizationstamp' => array( null, null, 'null' ),			
				), 
			'customer' => array(
				'creditcardinfo_expirationmonth' => array( null, null, 'null' ),
				'creditcardinfo_expirationyear' => array( null, null, 'null' )
				),
			'employee' => array(
				'employeepayrollinfo_clearearnings' => array( null, null, 'null' ),
				'employeepayrollinfo_isusingtimedatatocreatepaychecks' => array( null, null, 'null' ), 
				'employeepayrollinfo_sickhours_isresettinghourseachnewyear' => array( null, null, 'null' ),
				'employeepayrollinfo_vacationhours_isresettinghourseachnewyear' => array( null, null, 'null' ),
				), 
			'estimate' => array(
				'istobeemailed' => array( null, null, 'null' ), 
				),
			'estimate_estimateline' => array(
				'quantity' => array( null, null, 'null' ),
				),
			'itemnoninventory' => array(
				'salesorpurchase_price' => array( null, null, 'null' ),
				'salesorpurchase_pricepercent' => array( null, null, 'null' ),
				'salesorpurchase_salesprice' => array( null, null, 'null' ),
				'salesorpurchase_purchasecost' => array( null, null, 'null' )
				),
			'itemdiscount' => array(
				'discountrate' => array( null, null, 'null' ),
				'discountratepercent' => array( null, null, 'null' )
				),
			'inventoryadjustment_inventoryadjustmentline' => array(
				'quantityadjustment_newquantity' => array( null, null, 'null' ),
				'quantityadjustment_quantitydifference' => array( null, null, 'null' ),
				'valueadjustment_newquantity' => array( null, null, 'null' ),
				'valueadjustment_quantitydifference' => array( null, null, 'null' ),
				'valueadjustment_newvalue' => array( null, null, 'null' ),
				'valueadjustment_valuedifference' => array( null, null, 'null' ),
				),
			'invoice' => array(
				'ispending' => array( null, null, 'null' ),
				'isfinancecharge' => array( null, null, 'null' ),
				'ispaid' => array( null, null, 'null' ),
				'istobeprinted' => array( null, null, 'null' ), 
				'istobeemailed' => array( null, null, 'null' ), 			
				), 
			'invoice_invoiceline' => array(
				'quantity' => array( null, null, 'null' )
				),
			'purchaseorder' => array(
				'ismanuallyclosed' => array( null, null, 'null' ),
				'isfullyreceived' => array( null, null, 'null' ),
				'istobeprinted' => array( null, null, 'null' ), 
				'istobeemailed' => array( null, null, 'null' ), 
				), 
			'purchaseorder_purchaseorderline' => array(
				'ismanuallyclosed' => array( null, null, 'null' ),
				'receivedquantity' => array( null, null, 'null' ),
				'quantity' => array( null, null, 'null' )
				),
			'receivepayment' => array(
				'creditcardtxninfo_creditcardtxninputinfo_expirationmonth' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxninputinfo_expirationyear' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxnresultinfo_resultcode' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxnresultinfo_paymentgroupingcode' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxnresultinfo_txnauthorizationstamp' => array( null, null, 'null' ), 
				), 
			'salesorder' => array(
				'ismanuallyclosed' => array( null, null, 'null' ),
				'isfullyinvoiced' => array( null, null, 'null' ),
				'istobeprinted' => array( null, null, 'null' ), 
				'istobeemailed' => array( null, null, 'null' ), 
				), 
			'salesorder_salesorderline' => array(
				'quantity' => array( null, null, 'null' ),
				'invoiced' => array( null, null, 'null' ),
				'ismanuallyclosed' => array( null, null, 'null' ),
				),
			'salesreceipt' => array(
				'ispending' => array( null, null, 'null' ), 
				'istobeprinted' => array( null, null, 'null' ), 
				'istobeemailed' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxninputinfo_expirationmonth' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxninputinfo_expirationyear' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxnresultinfo_resultcode' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxnresultinfo_paymentgroupingcode' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxnresultinfo_txnauthorizationstamp' => array( null, null, 'null' ), 
				),
			'salesreceipt_salesreceiptline' => array(
				'quantity' => array( null, null, 'null' ),
				'creditcardtxninfo_creditcardtxninputinfo_expirationmonth' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxninputinfo_expirationyear' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxnresultinfo_resultcode' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxnresultinfo_paymentgroupingcode' => array( null, null, 'null' ), 
				'creditcardtxninfo_creditcardtxnresultinfo_txnauthorizationstamp' => array( null, null, 'null' ), 				
				), 	 
			);
			
		$object_type = strtolower($object_type);
		$field = strtolower($field);
			
		$type = QUICKBOOKS_DRIVER_SQL_VARCHAR;
		$length = 32;
		$default = null;
			
		// Default mappings for types
		switch ($qb_type)
		{
			case 'AMTTYPE':
				
				$type = QUICKBOOKS_DRIVER_SQL_DECIMAL;
				$length = '10,2';
				$default = 'null';
				
				break;
			case 'PRICETYPE':
				
				$type = QUICKBOOKS_DRIVER_SQL_DECIMAL;
				$length = '13,5';
				$default = 'null';
				
				break;
			case 'PERCENTTYPE':
				
				$type = QUICKBOOKS_DRIVER_SQL_DECIMAL;
				$length = '12,5';
				$default = 'null';
				
				break;
			case 'DATETYPE':
				
				$type = QUICKBOOKS_DRIVER_SQL_DATE;
				$length = null;
				$default = 'null';
				
				break;
			case 'DATETIMETYPE':
				
				$type = QUICKBOOKS_DRIVER_SQL_DATETIME;
				$length = null;
				$default = 'null';
				
				break;
			case 'BOOLTYPE':
				
				$type = QUICKBOOKS_DRIVER_SQL_BOOLEAN;
				$length = null;
				$default = false;
				
				break;
			case 'INTTYPE':
				
				$type = QUICKBOOKS_DRIVER_SQL_INTEGER;
				$length = null;
				$default = 0;
				
				break;
			case 'QUANTYPE':
			
				$type = QUICKBOOKS_DRIVER_SQL_DECIMAL;
				$length = '12,5';
				$default = 0;
			
				break;
			case 'IDTYPE':
				
				$type = QUICKBOOKS_DRIVER_SQL_VARCHAR;
				$length = 40;
				$default = 'null';
				
				break;
			case 'ENUMTYPE':
				
				$type = QUICKBOOKS_DRIVER_SQL_VARCHAR;
				$length = 40;
				$default = 'null';
				
				break;
			case 'STRTYPE':
			default:
				
				//print('casting: ' . $object_type . "\n");
				//print('field: ' . $field . "\n");
				
				$x = str_repeat('x', 10000);
				$length = strlen(QuickBooks_Cast::cast($object_type, $field, $x));
				
				// All FullName and *_FullName fields should be VARCHAR(255) so we can add INDEXes to them
				if ($length > 255 and 
					strtolower(substr($field, -8)) == 'fullname')
				{
					$length = 255;
				}
				
				// If the length is really long, put it in a TEXT field instead of a VARCHAR
				if ($length > 255)
				{
					$type = QUICKBOOKS_DRIVER_SQL_TEXT;
				}
				else
				{
					$type = QUICKBOOKS_DRIVER_SQL_VARCHAR;
				}
				
				$default = 'null';
				
				if ($field == 'EditSequence')
				{
					$length = 16;
				}
				else if (isset($overrides[$object_type][$field]))
				{
					// 
					
					if (!is_null($overrides[$object_type][$field][2]))
					{
						$default = $overrides[$object_type][$field][2];
					}
				}
				
				break;
		}
			
		// Overrides for mappings that couldn't be done automatically 
		/*switch ($object_type)
		{
			case 'invoice':
				switch ($field)
				{
					default:
						break;
				}
			default:
				
				switch ($field)
				{
					case 'isactive':
						$default = true;
						break;
					default:
						
						break;
				}
				
				break;
		}*/
		
		// @TODO -- Keith, is this a good way to accomplish converting all txnid/listid fields to varchar? ~Garrett
		if (stripos($field, 'listid') !== false or stripos($field, 'txnid') !== false)
		{
			$type = QUICKBOOKS_DRIVER_SQL_VARCHAR;
			$length = 40;
			$default = 'null';
		}
		else if (strtolower($field) == 'sortorder')
		{
			$type = QUICKBOOKS_DRIVER_SQL_INTEGER;
			$length = null;
			$default = 0;
		}
		
		if (isset($overrides[$object_type][$field]))
		{
			if (!is_null($overrides[$object_type][$field][0]))
			{
				$type = $overrides[$object_type][$field][0];
			}
			
			if (!is_null($overrides[$object_type][$field][1]))
			{
				$length = $overrides[$object_type][$field][1];
			}
			
			if (!is_null($overrides[$object_type][$field][2]))
			{
				$default = $overrides[$object_type][$field][2];
			}
		}
			
		return array( $type, $length, $default );
	}
}
