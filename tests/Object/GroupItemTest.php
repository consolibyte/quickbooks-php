<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class GroupItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_groupitem = new QuickBooks_Object_GroupItem();
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
    $this->assertNull($this->_groupitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_groupitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_groupitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_groupitem->getName());
  }

  public function test_get_uninitialized_sales_description() {
    $this->assertNull($this->_groupitem->getSalesDescription());
  }

  public function test_set_sales_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setSalesDescription($str));

    return $str;
  }

  public function test_set_get_sales_description() {
    $str = $this->test_set_sales_description();
    $this->assertEquals($str, $this->_groupitem->getSalesDescription());
  }

  public function test_get_uninitialized_sales_price() {
    $this->assertNull($this->_groupitem->getSalesPrice());
  }

  public function test_set_sales_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_groupitem->setSalesPrice($str));

    return $str;
  }

  public function test_set_get_sales_price() {
    $str = $this->test_set_sales_price();
    $this->assertEquals($str, $this->_groupitem->getSalesPrice());
  }

  public function test_get_uninitialized_income_account_list_id() {
    $this->assertNull($this->_groupitem->getIncomeAccountListID());
  }

  public function test_set_income_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setIncomeAccountListID($str));

    return $str;
  }

  public function test_set_get_income_account_list_id() {
    $str = $this->test_set_income_account_list_id();
    $this->assertEquals($str, $this->_groupitem->getIncomeAccountListID());
  }

  public function test_get_uninitialized_income_account_name() {
    $this->assertNull($this->_groupitem->getIncomeAccountName());
  }

  public function test_set_income_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setIncomeAccountName($str));

    return $str;
  }

  public function test_set_get_income_account_name() {
    $str = $this->test_set_income_account_name();
    $this->assertEquals($str, $this->_groupitem->getIncomeAccountName());
  }

  public function test_get_uninitialized_income_account_application_id() {
    $this->assertNull($this->_groupitem->getIncomeAccountApplicationID());
  }

  public function test_set_income_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setIncomeAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_income_account_application_id() {
    $str = $this->test_set_income_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_groupitem->getIncomeAccountApplicationID());
  }

  public function test_get_uninitialized_asset_account_name() {
    $this->assertNull($this->_groupitem->getAssetAccountName());
  }

  public function test_set_asset_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setAssetAccountName($str));

    return $str;
  }

  public function test_set_get_asset_account_name() {
    $str = $this->test_set_asset_account_name();
    $this->assertEquals($str, $this->_groupitem->getAssetAccountName());
  }

  public function test_get_uninitialized_asset_account_list_id() {
    $this->assertNull($this->_groupitem->getAssetAccountListID());
  }

  public function test_set_asset_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setAssetAccountListID($str));

    return $str;
  }

  public function test_set_get_asset_account_list_id() {
    $str = $this->test_set_asset_account_list_id();
    $this->assertEquals($str, $this->_groupitem->getAssetAccountListID());
  }

  public function test_get_uninitialized_asset_account_application_id() {
    $this->assertNull($this->_groupitem->getAssetAccountApplicationID());
  }

  public function test_set_asset_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setAssetAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_asset_account_application_id() {
    $str = $this->test_set_asset_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_groupitem->getAssetAccountApplicationID());
  }

  public function test_get_uninitialized_purchase_description() {
    $this->assertNull($this->_groupitem->getPurchaseDescription());
  }

  public function test_set_purchase_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setPurchaseDescription($str));

    return $str;
  }

  public function test_set_get_purchase_description() {
    $str = $this->test_set_purchase_description();
    $this->assertEquals($str, $this->_groupitem->getPurchaseDescription());
  }

  public function test_get_uninitialized_purchase_cost() {
    $this->assertNull($this->_groupitem->getPurchaseCost());
  }

  public function test_set_purchase_cost() {
    $str = $this->random_nums();
    $this->assertTrue($this->_groupitem->setPurchaseCost($str));

    return $str;
  }

  public function test_set_get_purchase_cost() {
    $str = $this->test_set_purchase_cost();
    $this->assertEquals($str, $this->_groupitem->getPurchaseCost());
  }

  public function test_get_uninitialized_cogsaccount_list_id() {
    $this->assertNull($this->_groupitem->getCOGSAccountListID());
  }

  public function test_set_cogsaccount_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setCOGSAccountListID($str));

    return $str;
  }

  public function test_set_get_cogsaccount_list_id() {
    $str = $this->test_set_cogsaccount_list_id();
    $this->assertEquals($str, $this->_groupitem->getCOGSAccountListID());
  }

  public function test_get_uninitialized_cogsaccount_name() {
    $this->assertNull($this->_groupitem->getCOGSAccountName());
  }

  public function test_set_cogsaccount_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setCOGSAccountName($str));

    return $str;
  }

  public function test_set_get_cogsaccount_name() {
    $str = $this->test_set_cogsaccount_name();
    $this->assertEquals($str, $this->_groupitem->getCOGSAccountName());
  }

  public function test_get_uninitialized_cogsaccount_application_id() {
    $this->assertNull($this->_groupitem->getCOGSAccountApplicationID());
  }

  public function test_set_cogsaccount_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setCOGSAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_cogsaccount_application_id() {
    $str = $this->test_set_cogsaccount_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_groupitem->getCOGSAccountApplicationID());
  }

  public function test_get_uninitialized_preferred_vendor_list_id() {
    $this->assertNull($this->_groupitem->getPreferredVendorListID());
  }

  public function test_set_preferred_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setPreferredVendorListID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_list_id() {
    $str = $this->test_set_preferred_vendor_list_id();
    $this->assertEquals($str, $this->_groupitem->getPreferredVendorListID());
  }

  public function test_get_uninitialized_preferred_vendor_name() {
    $this->assertNull($this->_groupitem->getPreferredVendorName());
  }

  public function test_set_preferred_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setPreferredVendorName($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_name() {
    $str = $this->test_set_preferred_vendor_name();
    $this->assertEquals($str, $this->_groupitem->getPreferredVendorName());
  }

  public function test_get_uninitialized_preferred_vendor_application_id() {
    $this->assertNull($this->_groupitem->getPreferredVendorApplicationID());
  }

  public function test_set_preferred_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_groupitem->setPreferredVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_application_id() {
    $str = $this->test_set_preferred_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_groupitem->getPreferredVendorApplicationID());
  }
}

