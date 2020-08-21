<?php

/**
 * Created by PhpStorm.
 * User: Artush
 * Date: 18.01.2017
 * Time: 13:19
 */

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Deposit extends QuickBooks_IPP_Object
{
    protected function _defaults()
    {
        return array(
            //'TypeOf' => 'Person',
        );
    }

    protected function _order()
    {
        return array(
            'Id' => true,
            'SyncToken' => true,
            'MetaData' => true,
            'CustomField' => true,
            'Header' => true,
            'Line' => true,
            'TxnDate' => true,
            'CurrencyRef' => true,
            'CurrencyRef_name' => true,
            'PrivateNote' => true,
            'DepositToAccountRef' => true,
            'DepositToAccountRef_name' => true,
            'GlobalTaxCalculation' => true,
            'TotalAmt' => true

        );
    }

}