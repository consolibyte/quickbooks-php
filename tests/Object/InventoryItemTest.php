<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class InventoryItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_inventoryitem = new QuickBooks_Object_InventoryItem();
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
    $this->assertNull($this->_inventoryitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_inventoryitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_inventoryitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_inventoryitem->getName());
  }

  public function test_get_uninitialized_sales_description() {
    $this->assertNull($this->_inventoryitem->getSalesDescription());
  }

  public function test_set_sales_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setSalesDescription($str));

    return $str;
  }

  public function test_set_get_sales_description() {
    $str = $this->test_set_sales_description();
    $this->assertEquals($str, $this->_inventoryitem->getSalesDescription());
  }

  public function test_get_uninitialized_sales_price() {
    $this->assertNull($this->_inventoryitem->getSalesPrice());
  }

  public function test_set_sales_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_inventoryitem->setSalesPrice($str));

    return $str;
  }

  public function test_set_get_sales_price() {
    $str = $this->test_set_sales_price();
    $this->assertEquals($str, $this->_inventoryitem->getSalesPrice());
  }

  public function test_get_uninitialized_income_account_list_id() {
    $this->assertNull($this->_inventoryitem->getIncomeAccountListID());
  }

  public function test_set_income_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setIncomeAccountListID($str));

    return $str;
  }

  public function test_set_get_income_account_list_id() {
    $str = $this->test_set_income_account_list_id();
    $this->assertEquals($str, $this->_inventoryitem->getIncomeAccountListID());
  }

  public function test_get_uninitialized_income_account_name() {
    $this->assertNull($this->_inventoryitem->getIncomeAccountName());
  }

  public function test_set_income_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setIncomeAccountName($str));

    return $str;
  }

  public function test_set_get_income_account_name() {
    $str = $this->test_set_income_account_name();
    $this->assertEquals($str, $this->_inventoryitem->getIncomeAccountName());
  }

  public function test_get_uninitialized_income_account_application_id() {
    $this->assertNull($this->_inventoryitem->getIncomeAccountApplicationID());
  }

  public function test_set_income_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setIncomeAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_income_account_application_id() {
    $str = $this->test_set_income_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_inventoryitem->getIncomeAccountApplicationID());
  }

  public function test_get_uninitialized_asset_account_name() {
    $this->assertNull($this->_inventoryitem->getAssetAccountName());
  }

  public function test_set_asset_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setAssetAccountName($str));

    return $str;
  }

  public function test_set_get_asset_account_name() {
    $str = $this->test_set_asset_account_name();
    $this->assertEquals($str, $this->_inventoryitem->getAssetAccountName());
  }

  public function test_get_uninitialized_asset_account_list_id() {
    $this->assertNull($this->_inventoryitem->getAssetAccountListID());
  }

  public function test_set_asset_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setAssetAccountListID($str));

    return $str;
  }

  public function test_set_get_asset_account_list_id() {
    $str = $this->test_set_asset_account_list_id();
    $this->assertEquals($str, $this->_inventoryitem->getAssetAccountListID());
  }

  public function test_get_uninitialized_asset_account_application_id() {
    $this->assertNull($this->_inventoryitem->getAssetAccountApplicationID());
  }

  public function test_set_asset_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setAssetAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_asset_account_application_id() {
    $str = $this->test_set_asset_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_inventoryitem->getAssetAccountApplicationID());
  }

  public function test_get_uninitialized_purchase_description() {
    $this->assertNull($this->_inventoryitem->getPurchaseDescription());
  }

  public function test_set_purchase_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setPurchaseDescription($str));

    return $str;
  }

  public function test_set_get_purchase_description() {
    $str = $this->test_set_purchase_description();
    $this->assertEquals($str, $this->_inventoryitem->getPurchaseDescription());
  }

  public function test_get_uninitialized_purchase_cost() {
    $this->assertNull($this->_inventoryitem->getPurchaseCost());
  }

  public function test_set_purchase_cost() {
    $str = $this->random_nums();
    $this->assertTrue($this->_inventoryitem->setPurchaseCost($str));

    return $str;
  }

  public function test_set_get_purchase_cost() {
    $str = $this->test_set_purchase_cost();
    $this->assertEquals($str, $this->_inventoryitem->getPurchaseCost());
  }

  public function test_get_uninitialized_cogsaccount_list_id() {
    $this->assertNull($this->_inventoryitem->getCOGSAccountListID());
  }

  public function test_set_cogsaccount_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setCOGSAccountListID($str));

    return $str;
  }

  public function test_set_get_cogsaccount_list_id() {
    $str = $this->test_set_cogsaccount_list_id();
    $this->assertEquals($str, $this->_inventoryitem->getCOGSAccountListID());
  }

  public function test_get_uninitialized_cogsaccount_name() {
    $this->assertNull($this->_inventoryitem->getCOGSAccountName());
  }

  public function test_set_cogsaccount_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setCOGSAccountName($str));

    return $str;
  }

  public function test_set_get_cogsaccount_name() {
    $str = $this->test_set_cogsaccount_name();
    $this->assertEquals($str, $this->_inventoryitem->getCOGSAccountName());
  }

  public function test_get_uninitialized_cogsaccount_application_id() {
    $this->assertNull($this->_inventoryitem->getCOGSAccountApplicationID());
  }

  public function test_set_cogsaccount_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setCOGSAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_cogsaccount_application_id() {
    $str = $this->test_set_cogsaccount_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_inventoryitem->getCOGSAccountApplicationID());
  }

  public function test_get_uninitialized_preferred_vendor_list_id() {
    $this->assertNull($this->_inventoryitem->getPreferredVendorListID());
  }

  public function test_set_preferred_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setPreferredVendorListID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_list_id() {
    $str = $this->test_set_preferred_vendor_list_id();
    $this->assertEquals($str, $this->_inventoryitem->getPreferredVendorListID());
  }

  public function test_get_uninitialized_preferred_vendor_name() {
    $this->assertNull($this->_inventoryitem->getPreferredVendorName());
  }

  public function test_set_preferred_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setPreferredVendorName($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_name() {
    $str = $this->test_set_preferred_vendor_name();
    $this->assertEquals($str, $this->_inventoryitem->getPreferredVendorName());
  }

  public function test_get_uninitialized_preferred_vendor_application_id() {
    $this->assertNull($this->_inventoryitem->getPreferredVendorApplicationID());
  }

  public function test_set_preferred_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryitem->setPreferredVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_application_id() {
    $str = $this->test_set_preferred_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_inventoryitem->getPreferredVendorApplicationID());
  }
}

