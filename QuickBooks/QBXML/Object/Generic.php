<?php

/**
 * QuickBooks Customer object container
 * 
 * Not used, might be used in future versions
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Object
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object.php');

/**
 * 
 */
class QuickBooks_QBXML_Object_Generic extends QuickBooks_QBXML_Object
{
	protected $_override;
	
	public function __construct($arr = array(), $override = '')
	{
		$this->_override = $override;
		
		parent::__construct($arr);
	}
	
	public function getOverride()
	{
		return $this->_override;
	}
	
	public function setOverride($override)
	{
		$this->_override = $override;
		
		return true;
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	protected function _cleanup()
	{
		
		return true;
	}
	
	/**
	 * 
	 */
	public function asArray($request, $nest = true)
	{
		$this->_cleanup();
		
		return parent::asArray($request, $nest);
	}
	
	/**
	 * Tell what type of object this is 
	 * 
	 * @return string
	 */
	public function object()
	{
		return $this->getOverride();
	}
}

?>
