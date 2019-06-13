<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_LinkedTxn extends QuickBooks_IPP_Object
{
	public function setTxnId($Id)
	{
		return $this->set('TxnId', QuickBooks_IPP_IDS::usableIDType($Id));
	}
}
