<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Upload extends QuickBooks_IPP_Service
{

	/**
	 * Resource.
	 *
	 * @var string
	 */
	private $_resource = 'Upload';

	/**
	 * Add.
	 *
	 * @param QuickBooks_IPP_Context $Context Context.
	 * @param string                 $realmID Company ID.
	 * @param object                 $Object  Object.
	 *
	 * @return integer
	 */
	public function add($Context, $realmID, $Object)
	{
		return $this->_add($Context, $realmID, $this->_resource, $Object);
	}

}
