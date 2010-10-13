<?php

interface QuickBooks_XML_Backend
{
	public function __construct($xml);
	
	public function validate(&$errnum, &$errmsg);
	
	public function parse(&$errnum, &$errmsg);
	
	public function load($str);
}