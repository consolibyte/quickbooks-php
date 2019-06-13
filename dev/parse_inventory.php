<?php 

$xml = '<?xml version="1.0" ?>
<QBXML>
   <QBXMLMsgsRs>
      <GeneralSummaryReportQueryRs statusCode="0" statusSeverity="Info" statusMessage="Status OK">
         <ReportRet>
            <ReportTitle>Inventory Stock Status by Item</ReportTitle>
            <ReportSubtitle>February 1 - 4, 2011</ReportSubtitle>
            <ReportBasis>Accrual</ReportBasis>
            <NumRows>6</NumRows>
            <NumColumns>9</NumColumns>
            <NumColTitleRows>1</NumColTitleRows>
            
            <ColDesc colID="1" dataType="STRTYPE">
               <ColTitle titleRow="1" />
               <ColType>Blank</ColType>
            </ColDesc>
            
            <ColDesc colID="2" dataType="STRTYPE">
               <ColTitle titleRow="1" value="Item Description" />
               <ColType>ItemDesc</ColType>
            </ColDesc>
            
            <ColDesc colID="3" dataType="STRTYPE">
               <ColTitle titleRow="1" value="Pref Vendor" />
               <ColType>ItemVendor</ColType>
            </ColDesc>
            
            <ColDesc colID="4" dataType="QUANTYPE">
               <ColTitle titleRow="1" value="Reorder Pt" />
               <ColType>ReorderPoint</ColType>
            </ColDesc>
            
            <ColDesc colID="5" dataType="QUANTYPE">
               <ColTitle titleRow="1" value="On Hand" />
               <ColType>QuantityOnHand</ColType>
            </ColDesc>
            
            <ColDesc colID="6" dataType="BOOLTYPE">
               <ColTitle titleRow="1" value="Order" />
               <ColType>SuggestedReorder</ColType>
            </ColDesc>
            
            <ColDesc colID="7" dataType="QUANTYPE">
               <ColTitle titleRow="1" value="On PO" />
               <ColType>QuantityOnOrder</ColType>
            </ColDesc>
            
            <ColDesc colID="8" dataType="DATETYPE">
               <ColTitle titleRow="1" value="Next Deliv" />
               <ColType>EarliestReceiptDate</ColType>
            </ColDesc>
            
            <ColDesc colID="9" dataType="QUANTYPE">
               <ColTitle titleRow="1" value="Sales/Week" />
               <ColType>SalesPerWeek</ColType>
            </ColDesc>
            
            <ReportData>
               <TextRow rowNumber="1" value="Inventory" />
               
               <DataRow rowNumber="2">
                  <RowData rowType="item" value="another inventory" />
                  <ColData colID="1" value="another inventory" />
                  <ColData colID="4" value="5" />
                  <ColData colID="5" value="35" />
                  <ColData colID="6" value="false" />
                  <ColData colID="7" value="0" />
                  <ColData colID="9" value="0" />
               </DataRow>
               
               <TextRow rowNumber="3" value="test inventory part" />
               
               <DataRow rowNumber="4">
                  <RowData rowType="item" value="test inventory part:test sub product" />
                  <ColData colID="1" value="test sub product" />
                  <ColData colID="5" value="5" />
                  <ColData colID="6" value="false" />
                  <ColData colID="7" value="0" />
                  <ColData colID="9" value="0" />
               </DataRow>
               
               <DataRow rowNumber="5">
                  <RowData rowType="item" value="test inventory part" />
                  <ColData colID="1" value="test inventory part - Other" />
                  <ColData colID="4" value="5" />
                  <ColData colID="5" value="12" />
                  <ColData colID="6" value="false" />
                  <ColData colID="7" value="5" />
                  <ColData colID="8" value="2010-09-27" />
                  <ColData colID="9" value="0" />
               </DataRow>
               
               <SubtotalRow rowNumber="6">
                  <RowData rowType="item" value="test inventory part" />
                  <ColData colID="1" value="Total test inventory part" />
                  <ColData colID="5" value="17" />
                  <ColData colID="7" value="5" />
                  <ColData colID="9" value="0" />
               </SubtotalRow>
            </ReportData>
         </ReportRet>
      </GeneralSummaryReportQueryRs>
   </QBXMLMsgsRs>
</QBXML>';

$Testme = new Testme();

$Testme->_processReport($xml);

class Testme
{
	public function _processReport($xml)
	{
		$col_defs = array();
		
		// First, find the column definitions
		$tmp = $xml;
		$find = 'ColDesc';
		while ($inner = Testme::_reportNextXML($tmp, $find))
		{
			//print('---------' . "\n");
			//print($inner);
			//print("\n" . '-----------' . "\n");
			
			$colID = Testme::_reportExtractColID($inner);
			$type = Testme::_reportExtractColType($inner);
			
			$col_defs[$colID] = $type;
			
			//print('  colID [' . $colID . ']');
			//print('  type [' . $type . ']' . "\n");
			
			//print("\n\n\n\n");
		}
		
		//print_r($col_defs);
		
		$items = array();
		
		// Now, find the actual data
		$tmp = $xml;
		$find = 'DataRow';
		while ($inner = Testme::_reportNextXML($tmp, $find))
		{
			//print('---------' . "\n");
			//print($inner);
			//print("\n" . '-----------' . "\n");
			
			$item = array(
				'FullName' => null, 
				'Blank' => null, 					// 
				'ItemDesc' => null, 				// 
				'ItemVendor' => null, 				// Pref Vendor
				'ReorderPoint' => null, 			// Reorder Pt
				'QuantityOnHand' => null, 			// On Hand
				'SuggestedReorder' => null, 		// Order
				'QuantityOnOrder' => null, 			// On PO
				'EarliestReceiptDate' => null, 		// Next Deliv
				'SalesPerWeek' => null, 			// Sales/Week
				);
			
			$find2 = 'RowData';
			if ($tag = Testme::_reportNextTag($inner, $find2))
			{
				$value = Testme::_reportExtractColValue($tag);
				
				$item['FullName'] = $value;
			}
				
			$find3 = 'ColData';
			while ($tag = Testme::_reportNextTag($inner, $find3))
			{
				$colID = Testme::_reportExtractColID($tag);
				$value = Testme::_reportExtractColValue($tag);
				
				//print('[' . $tag . ']' . "\n");
				//print('	colID: [' . $colID . ']' . "\n");
				//print('	value: [' . $value . ']' . "\n");
				
				//print("\n");
				
				if (array_key_exists($colID, $col_defs))
				{
					$item[$col_defs[$colID]] = $value;
				}
			}
			
			$items[] = $item;
			
			//print("\n\n\n\n\n");
		}
		
		print_r($items);
		
		// UPDATE item SET QuantityOnHand = x WHERE FullName = y, resync = NOW() AND qbsql_resync_datetime = qbsql_modify_timestamp
		// if (!affected_rows)
		// 	UPDATE item SET QuantityOnHand = x WHERE FullName = y 		// this was a modified item, so it needs to stay modified
	}
	
	static protected function _reportExtractColID($xml)
	{
		$find = 'colID="';
		if (false !== ($sta = strpos($xml, $find)))
		{
			$end = strpos($xml, '"', $sta + strlen($find));
			
			return substr($xml, $sta + strlen($find), $end - $sta - strlen($find));
		}
		
		return null;
	}
	
	static protected function _reportExtractColType($xml)
	{
		$find = '<ColType>';
		if (false !== ($sta = strpos($xml, $find)))
		{
			$end = strpos($xml, '</ColType>', $sta + strlen($find));
			
			return substr($xml, $sta + strlen($find), $end - $sta - strlen($find));
		}
		
		return null;
	}
	
	static protected function _reportExtractColValue($xml)
	{
		$find = 'value="';
		if (false !== ($sta = strpos($xml, $find)))
		{
			$end = strpos($xml, '"', $sta + strlen($find));
			
			return substr($xml, $sta + strlen($find), $end - $sta - strlen($find));
		}
		
		return null;
	}
	
	static protected function _reportNextTag(&$xml, $find)
	{
		if (false !== ($sta = strpos($xml, $find)))
		{
			$end = strpos($xml, ' />', $sta);
			/*if (false === $end)
			{
				$end = strpos($xml, '</' . $find);
			}*/
			
			if (false !== $end)
			{
				$data = substr($xml, $sta - 1, $end - $sta + 4);
				
				$xml = substr($xml, $end + 2);
				
				return $data;
			}
		}
		
		return false;
	}
	
	static protected function _reportNextXML(&$xml, $find)
	{
		if (false !== ($sta = strpos($xml, $find)))
		{
			$end = strpos($xml, '/' . $find);
			
			$data = substr($xml, $sta - 1, $end - $sta + strlen($find) + 3);
			
			$xml = substr($xml, $end + strlen($find));
			
			return $data;
		}
		
		return false;
	}
}
