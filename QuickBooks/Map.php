<?php

abstract class QuickBooks_Map
{
	const MAP_QBXML = 'qbxml';
	
	const MAP_IDS = 'ids';
	
	const MARK_ADD = 'add';
	
	const MARK_MOD = 'mod';
	
	const MARK_DELETE = 'delete';
	
	abstract public function adds($adds = array(), $mark_as_queued = true);
	
	abstract public function mods($mods = array(), $mark_as_queued = true);
	
	abstract public function imports($imports = array());
	
	abstract public function queries($queries = array());
	
	abstract public function mark($mark_as, $object_or_action, $ID, $TxnID_or_ListID = null, $errnum = null, $errmsg = null);
}