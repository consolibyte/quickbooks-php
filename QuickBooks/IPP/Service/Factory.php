<?php

class QuickBooks_IPP_Service_Factory
{
	public function newInstance($Context, $which)
	{
		$class = 'QuickBooks_IPP_Service_' . $which;
		
		return new $class($Context->IPP());
	}
}