<?php

/**
 *
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 *
 * @license LICENSE.txt
 * @author Ryan Bantz <ryan@rykelabs.com>
 *
 * @package QuickBooks
 * @subpackage IPP
 */


QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Attachable extends QuickBooks_IPP_Service
{

	/**
	 * Resource.
	 *
	 * @var string
	 */
	private $_resource = 'Attachable';

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

	/**
	 * Updates attachable.
	 *
	 * @param object $Context Context.
	 * @param string $realmID Company Id.
	 * @param string $IDType  Resource.
	 * @param object $Object  Object.
	 *
	 * @return boolean
	 */
	public function update($Context, $realmID, $IDType, $Object)
	{
		return $this->_update($Context, $realmID, $this->_resource, $Object, $IDType);
	}

	/**
	 * Query.
	 *
	 * @param QuickBooks_IPP_Context $Context Context.
	 * @param string                 $realm   Company ID.
	 * @param string                 $query   Query.
	 *
	 * @return integer
	 */
	public function query($Context, $realm, $query)
	{
		return $this->_query($Context, $realm, $query);
	}

	public function download($Context, $realmID, $ID)
	{
		return parent::_download($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DOWNLOAD, $ID);
	}

	/**
	 * Deletes attachable.
	 *
	 * @param object $Context Context.
	 * @param string $realmID Company Id.
	 * @param string $IDType  Resource.
	 *
	 * @return boolean
	 */
	public function delete($Context, $realmID, $IDType)
	{
		return $this->_delete($Context, $realmID, 'Attachable', $IDType);
	}

}
