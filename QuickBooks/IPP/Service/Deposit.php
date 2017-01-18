<?php

/**
 * Created by PhpStorm.
 * User: Artush
 * Date: 18.01.2017
 * Time: 13:22
 */
QuickBooks_Loader::load('/QuickBooks/IPP/Service.php');

class QuickBooks_IPP_Service_Deposit extends QuickBooks_IPP_Service
{
    public function add($Context, $realmID, $Object)
    {
        return parent::_add($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DEPOSIT, $Object);
    }

    public function query($Context, $realm, $query)
    {
        return parent::_query($Context, $realm, $query);
    }

    public function update($Context, $realm, $IDType, $Object)
    {
        return parent::_update($Context, $realm, QuickBooks_IPP_IDS::RESOURCE_DEPOSIT, $Object, $IDType);
    }

    public function delete($Context, $realmID, $IDType)
    {
        return parent::_delete($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DEPOSIT, $IDType);
    }

    public function void($Context, $realmID, $IDType)
    {
        return parent::_void($Context, $realmID, QuickBooks_IPP_IDS::RESOURCE_DEPOSIT, $IDType);
    }
}