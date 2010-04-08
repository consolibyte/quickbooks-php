<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class FixedAssetItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_fixedassetitem = new QuickBooks_Object_FixedAssetItem();
  }

  public function random_nums($len = 0) {
    if ($len == 0) {
      $len = rand(1,5);
    }

    return substr(rand(), $len);
  }

  public function random_chars($len = 0) {
    if ($len == 0) {
      $len = rand(5,20);
    }

    return substr(md5(microtime()), $len);
  }


  public function test_get_uninitialized_list_id() {
    $this->assertNull($this->_fixedassetitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_fixedassetitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_fixedassetitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_fixedassetitem->getName());
  }

  public function test_get_uninitialized_sales_description() {
    $this->assertNull($this->_fixedassetitem->getSalesDescription());
  }

  public function test_set_sales_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setSalesDescription($str));

    return $str;
  }

  public function test_set_get_sales_description() {
    $str = $this->test_set_sales_description();
    $this->assertEquals($str, $this->_fixedassetitem->getSalesDescription());
  }

  public function test_get_uninitialized_sales_price() {
    $this->assertNull($this->_fixedassetitem->getSalesPrice());
  }

  public function test_set_sales_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_fixedassetitem->setSalesPrice($str));

    return $str;
  }

  public function test_set_get_sales_price() {
    $str = $this->test_set_sales_price();
    $this->assertEquals($str, $this->_fixedassetitem->getSalesPrice());
  }

  public function test_get_uninitialized_income_account_list_id() {
    $this->assertNull($this->_fixedassetitem->getIncomeAccountListID());
  }

  public function test_set_income_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setIncomeAccountListID($str));

    return $str;
  }

  public function test_set_get_income_account_list_id() {
    $str = $this->test_set_income_account_list_id();
    $this->assertEquals($str, $this->_fixedassetitem->getIncomeAccountListID());
  }

  public function test_get_uninitialized_income_account_name() {
    $this->assertNull($this->_fixedassetitem->getIncomeAccountName());
  }

  public function test_set_income_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setIncomeAccountName($str));

    return $str;
  }

  public function test_set_get_income_account_name() {
    $str = $this->test_set_income_account_name();
    $this->assertEquals($str, $this->_fixedassetitem->getIncomeAccountName());
  }

  public function test_get_uninitialized_income_account_application_id() {
    $this->assertNull($this->_fixedassetitem->getIncomeAccountApplicationID());
  }

  public function test_set_income_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setIncomeAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_income_account_application_id() {
    $str = $this->test_set_income_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_fixedassetitem->getIncomeAccountApplicationID());
  }

  public function test_get_uninitialized_asset_account_name() {
    $this->assertNull($this->_fixedassetitem->getAssetAccountName());
  }

  public function test_set_asset_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setAssetAccountName($str));

    return $str;
  }

  public function test_set_get_asset_account_name() {
    $str = $this->test_set_asset_account_name();
    $this->assertEquals($str, $this->_fixedassetitem->getAssetAccountName());
  }

  public function test_get_uninitialized_asset_account_list_id() {
    $this->assertNull($this->_fixedassetitem->getAssetAccountListID());
  }

  public function test_set_asset_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setAssetAccountListID($str));

    return $str;
  }

  public function test_set_get_asset_account_list_id() {
    $str = $this->test_set_asset_account_list_id();
    $this->assertEquals($str, $this->_fixedassetitem->getAssetAccountListID());
  }

  public function test_get_uninitialized_asset_account_application_id() {
    $this->assertNull($this->_fixedassetitem->getAssetAccountApplicationID());
  }

  public function test_set_asset_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setAssetAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_asset_account_application_id() {
    $str = $this->test_set_asset_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_fixedassetitem->getAssetAccountApplicationID());
  }

  public function test_get_uninitialized_purchase_description() {
    $this->assertNull($this->_fixedassetitem->getPurchaseDescription());
  }

  public function test_set_purchase_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setPurchaseDescription($str));

    return $str;
  }

  public function test_set_get_purchase_description() {
    $str = $this->test_set_purchase_description();
    $this->assertEquals($str, $this->_fixedassetitem->getPurchaseDescription());
  }

  public function test_get_uninitialized_purchase_cost() {
    $this->assertNull($this->_fixedassetitem->getPurchaseCost());
  }

  public function test_set_purchase_cost() {
    $str = $this->random_nums();
    $this->assertTrue($this->_fixedassetitem->setPurchaseCost($str));

    return $str;
  }

  public function test_set_get_purchase_cost() {
    $str = $this->test_set_purchase_cost();
    $this->assertEquals($str, $this->_fixedassetitem->getPurchaseCost());
  }

  public function test_get_uninitialized_cogsaccount_list_id() {
    $this->assertNull($this->_fixedassetitem->getCOGSAccountListID());
  }

  public function test_set_cogsaccount_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setCOGSAccountListID($str));

    return $str;
  }

  public function test_set_get_cogsaccount_list_id() {
    $str = $this->test_set_cogsaccount_list_id();
    $this->assertEquals($str, $this->_fixedassetitem->getCOGSAccountListID());
  }

  public function test_get_uninitialized_cogsaccount_name() {
    $this->assertNull($this->_fixedassetitem->getCOGSAccountName());
  }

  public function test_set_cogsaccount_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setCOGSAccountName($str));

    return $str;
  }

  public function test_set_get_cogsaccount_name() {
    $str = $this->test_set_cogsaccount_name();
    $this->assertEquals($str, $this->_fixedassetitem->getCOGSAccountName());
  }

  public function test_get_uninitialized_cogsaccount_application_id() {
    $this->assertNull($this->_fixedassetitem->getCOGSAccountApplicationID());
  }

  public function test_set_cogsaccount_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setCOGSAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_cogsaccount_application_id() {
    $str = $this->test_set_cogsaccount_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_fixedassetitem->getCOGSAccountApplicationID());
  }

  public function test_get_uninitialized_preferred_vendor_list_id() {
    $this->assertNull($this->_fixedassetitem->getPreferredVendorListID());
  }

  public function test_set_preferred_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setPreferredVendorListID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_list_id() {
    $str = $this->test_set_preferred_vendor_list_id();
    $this->assertEquals($str, $this->_fixedassetitem->getPreferredVendorListID());
  }

  public function test_get_uninitialized_preferred_vendor_name() {
    $this->assertNull($this->_fixedassetitem->getPreferredVendorName());
  }

  public function test_set_preferred_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setPreferredVendorName($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_name() {
    $str = $this->test_set_preferred_vendor_name();
    $this->assertEquals($str, $this->_fixedassetitem->getPreferredVendorName());
  }

  public function test_get_uninitialized_preferred_vendor_application_id() {
    $this->assertNull($this->_fixedassetitem->getPreferredVendorApplicationID());
  }

  public function test_set_preferred_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_fixedassetitem->setPreferredVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_application_id() {
    $str = $this->test_set_preferred_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_fixedassetitem->getPreferredVendorApplicationID());
  }
}

