<?php

abstract class QuickBooks_Runnable
{
	public function __construct(
		$dsn_or_conn, 
		$user, 
		$map = array(), 
		$onerror = array(), 
		$hooks = array(), 
		$log_level = QUICKBOOKS_LOG_NORMAL, 
		$soap = QUICKBOOKS_SOAPSERVER_BUILTIN, 
		$wsdl = QUICKBOOKS_WSDL, 
		$soap_options = array(), 
		$handler_options = array(), 
		$driver_options = array(), 
		$api_options = array(), 
		$source_options = array(), 
		$callback_options = array())
	{
		
	}	
	
	/**
	 * Merge two arrays, allowing $arr2 to be merged over matching keys in $arr1
	 * 
	 * If $arr1 or $arr2 are arrays of arrays, and $array_of_arrays is set to 
	 * true, then the arrays of arrays will be merged, allowing $arr2 to 
	 * override $arr1 entries. If the arrays of arrays are numerically indexed, 
	 * $arr2 entries will be appended to $arr1 entries. 
	 * 
	 * @param array $arr1
	 * @param array $arr2
	 * @param boolean $array_of_arrays
	 * @return array
	 */
	protected function _merge($arr1, $arr2, $array_of_arrays = false)
	{
		if ($array_of_arrays)
		{
			foreach ($arr2 as $key => $funcs)
			{
				if (!is_array($funcs))
				{
					$funcs = array( $funcs );
				}
				
				if (isset($arr1[$key]))
				{
					if (!is_array($arr1[$key]))
					{
						$arr1[$key] = array( $arr1[$key] );
					}
					
					$arr1[$key] = array_merge($arr1[$key], $funcs);
				}
				else
				{
					$arr1[$key] = $funcs;
				}
			}
			
			return $arr1;
		}
		else
		{
			// *DO NOT* use array_merge() here, it screws things up!!!
			//return array_merge($arr1, $arr2);
			
			foreach ($arr2 as $key => $value)
			{
				$arr1[$key] = $value;
			}
			
			return $arr1;
		}
	}
	
	abstract public function run();
}