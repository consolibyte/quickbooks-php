<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class InventoryAssemblyItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_inventoryassemblyitem = new QuickBooks_Object_InventoryAssemblyItem();
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
    $this->assertNull($this->_inventoryassemblyitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_inventoryassemblyitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getName());
  }

  public function test_get_uninitialized_sales_description() {
    $this->assertNull($this->_inventoryassemblyitem->getSalesDescription());
  }

  public function test_set_sales_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setSalesDescription($str));

    return $str;
  }

  public function test_set_get_sales_description() {
    $str = $this->test_set_sales_description();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getSalesDescription());
  }

  public function test_get_uninitialized_sales_price() {
    $this->assertNull($this->_inventoryassemblyitem->getSalesPrice());
  }

  public function test_set_sales_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_inventoryassemblyitem->setSalesPrice($str));

    return $str;
  }

  public function test_set_get_sales_price() {
    $str = $this->test_set_sales_price();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getSalesPrice());
  }

  public function test_get_uninitialized_income_account_list_id() {
    $this->assertNull($this->_inventoryassemblyitem->getIncomeAccountListID());
  }

  public function test_set_income_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setIncomeAccountListID($str));

    return $str;
  }

  public function test_set_get_income_account_list_id() {
    $str = $this->test_set_income_account_list_id();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getIncomeAccountListID());
  }

  public function test_get_uninitialized_income_account_name() {
    $this->assertNull($this->_inventoryassemblyitem->getIncomeAccountName());
  }

  public function test_set_income_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setIncomeAccountName($str));

    return $str;
  }

  public function test_set_get_income_account_name() {
    $str = $this->test_set_income_account_name();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getIncomeAccountName());
  }

  public function test_get_uninitialized_income_account_application_id() {
    $this->assertNull($this->_inventoryassemblyitem->getIncomeAccountApplicationID());
  }

  public function test_set_income_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setIncomeAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_income_account_application_id() {
    $str = $this->test_set_income_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_inventoryassemblyitem->getIncomeAccountApplicationID());
  }

  public function test_get_uninitialized_asset_account_name() {
    $this->assertNull($this->_inventoryassemblyitem->getAssetAccountName());
  }

  public function test_set_asset_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setAssetAccountName($str));

    return $str;
  }

  public function test_set_get_asset_account_name() {
    $str = $this->test_set_asset_account_name();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getAssetAccountName());
  }

  public function test_get_uninitialized_asset_account_list_id() {
    $this->assertNull($this->_inventoryassemblyitem->getAssetAccountListID());
  }

  public function test_set_asset_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setAssetAccountListID($str));

    return $str;
  }

  public function test_set_get_asset_account_list_id() {
    $str = $this->test_set_asset_account_list_id();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getAssetAccountListID());
  }

  public function test_get_uninitialized_asset_account_application_id() {
    $this->assertNull($this->_inventoryassemblyitem->getAssetAccountApplicationID());
  }

  public function test_set_asset_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setAssetAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_asset_account_application_id() {
    $str = $this->test_set_asset_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_inventoryassemblyitem->getAssetAccountApplicationID());
  }

  public function test_get_uninitialized_purchase_description() {
    $this->assertNull($this->_inventoryassemblyitem->getPurchaseDescription());
  }

  public function test_set_purchase_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setPurchaseDescription($str));

    return $str;
  }

  public function test_set_get_purchase_description() {
    $str = $this->test_set_purchase_description();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getPurchaseDescription());
  }

  public function test_get_uninitialized_purchase_cost() {
    $this->assertNull($this->_inventoryassemblyitem->getPurchaseCost());
  }

  public function test_set_purchase_cost() {
    $str = $this->random_nums();
    $this->assertTrue($this->_inventoryassemblyitem->setPurchaseCost($str));

    return $str;
  }

  public function test_set_get_purchase_cost() {
    $str = $this->test_set_purchase_cost();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getPurchaseCost());
  }

  public function test_get_uninitialized_cogsaccount_list_id() {
    $this->assertNull($this->_inventoryassemblyitem->getCOGSAccountListID());
  }

  public function test_set_cogsaccount_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setCOGSAccountListID($str));

    return $str;
  }

  public function test_set_get_cogsaccount_list_id() {
    $str = $this->test_set_cogsaccount_list_id();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getCOGSAccountListID());
  }

  public function test_get_uninitialized_cogsaccount_name() {
    $this->assertNull($this->_inventoryassemblyitem->getCOGSAccountName());
  }

  public function test_set_cogsaccount_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setCOGSAccountName($str));

    return $str;
  }

  public function test_set_get_cogsaccount_name() {
    $str = $this->test_set_cogsaccount_name();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getCOGSAccountName());
  }

  public function test_get_uninitialized_cogsaccount_application_id() {
    $this->assertNull($this->_inventoryassemblyitem->getCOGSAccountApplicationID());
  }

  public function test_set_cogsaccount_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setCOGSAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_cogsaccount_application_id() {
    $str = $this->test_set_cogsaccount_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_inventoryassemblyitem->getCOGSAccountApplicationID());
  }

  public function test_get_uninitialized_preferred_vendor_list_id() {
    $this->assertNull($this->_inventoryassemblyitem->getPreferredVendorListID());
  }

  public function test_set_preferred_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setPreferredVendorListID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_list_id() {
    $str = $this->test_set_preferred_vendor_list_id();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getPreferredVendorListID());
  }

  public function test_get_uninitialized_preferred_vendor_name() {
    $this->assertNull($this->_inventoryassemblyitem->getPreferredVendorName());
  }

  public function test_set_preferred_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setPreferredVendorName($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_name() {
    $str = $this->test_set_preferred_vendor_name();
    $this->assertEquals($str, $this->_inventoryassemblyitem->getPreferredVendorName());
  }

  public function test_get_uninitialized_preferred_vendor_application_id() {
    $this->assertNull($this->_inventoryassemblyitem->getPreferredVendorApplicationID());
  }

  public function test_set_preferred_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_inventoryassemblyitem->setPreferredVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_application_id() {
    $str = $this->test_set_preferred_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_inventoryassemblyitem->getPreferredVendorApplicationID());
  }
}

