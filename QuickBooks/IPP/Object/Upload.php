<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Upload extends QuickBooks_IPP_Object
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

	/**
	 * As XML.
	 *
	 * @param integer $indent  Indent.
	 * @param string  $parent  Parent.
	 * @param string  $optype  Operation type.
	 * @param string  $flavor  Flavor.
	 * @param string  $version Version.
	 *
	 * @return string
	 */
	public function asXML(
		$indent = 0, $parent = null, $optype = null, $flavor = null, $version = QuickBooks_IPP_IDS::VERSION_3
	) {
		$ret = '--Asrf456BGe4hacebdf13572468' . QUICKBOOKS_CRLF;
		$file = pathinfo($this->getFileName(), PATHINFO_FILENAME);
		$ret .= 'Content-Disposition: form-data; name="file_content_02"; filename="' . $file . '"' . QUICKBOOKS_CRLF;
		$ret .= 'Content-Type: ' . $this->getContentType() . QUICKBOOKS_CRLF . QUICKBOOKS_CRLF;
		$file = file_get_contents($this->getFileName());
		$ret .= $file;
		$ret .= '--Asrf456BGe4hacebdf13572468--' . QUICKBOOKS_CRLF . QUICKBOOKS_CRLF;

		return $ret;
	}

}
