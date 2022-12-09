<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_AttachableRef extends QuickBooks_IPP_Object
{

	/**
	 * Returns object as XML.
	 *
	 * @param integer $indent Indent.
	 * @param string  $parent Parent.
	 * @param string  $optype Operation type.
	 * @param string  $flavor Flavor.
	 *
	 * @return string
	 */
	public function _asXML_v3($indent, $parent, $optype, $flavor)
	{
		$entity_type = $this->getEntityType();

		if ( !$entity_type ) {
			return '';
		}

		$xml = str_repeat("\t", $indent) . '<AttachableRef>' . QUICKBOOKS_CRLF;
		$entity_id = str_replace(array('{', '}', '-'), '', $this->getEntityRef());

		$xml .= str_repeat("\t", $indent + 1) . '<EntityRef type="' . $entity_type . '">' . $entity_id . '</EntityRef>';
		$xml .= QUICKBOOKS_CRLF;
		$xml .= str_repeat("\t", $indent) . '</AttachableRef>' . QUICKBOOKS_CRLF;

		return $xml;
	}

}
