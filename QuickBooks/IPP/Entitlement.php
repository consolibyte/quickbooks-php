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
 * 
 * 
 */

class QuickBooks_IPP_Entitlement
{
	protected $_entitlement_id;
	
	protected $_name;
	
	protected $_term_id;
	
	protected $_term;

	const TERM_ON = 'On';
	const TERM_OFF = 'Off';
	
	public function __construct($entitlement_id, $name, $term)
	{
		$this->_entitlement_id = $entitlement_id;
		$this->_name = $name;
		$this->_term = $term;
	}

	public function getId()
	{
		return $this->_entitlement_id;
	}

	public function isOn()
	{
		return $this->_term == self::TERM_ON;
	}

	public function isOff()
	{
		return $this->_term == self::TERM_OFF;
	}

	public function getValue()
	{
		return $this->_term;
	}
	
	public function getEntitlementId()
	{
		return $this->_entitlement_id;
	}
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function getTermId()
	{
		return $this->_term_id;
	}
	
	public function getTerm()
	{
		return $this->_term;
	}
}