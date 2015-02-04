<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Attachable extends QuickBooks_IPP_Object
{

	/**
	 * Defaults.
	 *
	 * @return array
	 */
	protected function _defaults()
	{
		return array();
	}

	/**
	 * Order.
	 *
	 * @return array
	 */
	protected function _order()
	{
		return array(
			'Id' => true,
			'SyncToken' => true,
			'MetaData' => true,
		);
	}

}
