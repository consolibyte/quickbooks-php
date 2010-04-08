<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class NonInventoryItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_noninventoryitem = new QuickBooks_Object_NonInventoryItem();
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
    $this->assertNull($this->_noninventoryitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_noninventoryitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_noninventoryitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_noninventoryitem->getName());
  }

  public function test_get_uninitialized_description() {
    $this->assertNull($this->_noninventoryitem->getDescription());
  }

  public function test_set_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setDescription($str));

    return $str;
  }

  public function test_set_get_description() {
    $str = $this->test_set_description();
    $this->assertEquals($str, $this->_noninventoryitem->getDescription());
  }

  public function test_get_uninitialized_price() {
    $this->assertNull($this->_noninventoryitem->getPrice());
  }

  public function test_set_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_noninventoryitem->setPrice($str));

    return $str;
  }

  public function test_set_get_price() {
    $str = $this->test_set_price();
    $this->assertEquals($str, $this->_noninventoryitem->getPrice());
  }

  public function test_get_uninitialized_price_percent() {
    $this->assertNull($this->_noninventoryitem->getPricePercent());
  }

  public function test_set_price_percent() {
    $str = $this->random_nums();
    $this->assertTrue($this->_noninventoryitem->setPricePercent($str));

    return $str;
  }

  public function test_set_get_price_percent() {
    $str = $this->test_set_price_percent();
    $this->assertEquals($str, $this->_noninventoryitem->getPricePercent());
  }

  public function test_get_uninitialized_account_list_id() {
    $this->assertNull($this->_noninventoryitem->getAccountListID());
  }

  public function test_set_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setAccountListID($str));

    return $str;
  }

  public function test_set_get_account_list_id() {
    $str = $this->test_set_account_list_id();
    $this->assertEquals($str, $this->_noninventoryitem->getAccountListID());
  }

  public function test_get_uninitialized_account_name() {
    $this->assertNull($this->_noninventoryitem->getAccountName());
  }

  public function test_set_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setAccountName($str));

    return $str;
  }

  public function test_set_get_account_name() {
    $str = $this->test_set_account_name();
    $this->assertEquals($str, $this->_noninventoryitem->getAccountName());
  }

  public function test_get_uninitialized_account_application_id() {
    $this->assertNull($this->_noninventoryitem->getAccountApplicationID());
  }

  public function test_set_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_account_application_id() {
    $str = $this->test_set_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_noninventoryitem->getAccountApplicationID());
  }

  public function test_get_uninitialized_sales_description() {
    $this->assertNull($this->_noninventoryitem->getSalesDescription());
  }

  public function test_set_sales_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setSalesDescription($str));

    return $str;
  }

  public function test_set_get_sales_description() {
    $str = $this->test_set_sales_description();
    $this->assertEquals($str, $this->_noninventoryitem->getSalesDescription());
  }

  public function test_get_uninitialized_sales_price() {
    $this->assertNull($this->_noninventoryitem->getSalesPrice());
  }

  public function test_set_sales_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_noninventoryitem->setSalesPrice($str));

    return $str;
  }

  public function test_set_get_sales_price() {
    $str = $this->test_set_sales_price();
    $this->assertEquals($str, $this->_noninventoryitem->getSalesPrice());
  }

  public function test_get_uninitialized_income_account_list_id() {
    $this->assertNull($this->_noninventoryitem->getIncomeAccountListID());
  }

  public function test_set_income_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setIncomeAccountListID($str));

    return $str;
  }

  public function test_set_get_income_account_list_id() {
    $str = $this->test_set_income_account_list_id();
    $this->assertEquals($str, $this->_noninventoryitem->getIncomeAccountListID());
  }

  public function test_get_uninitialized_income_account_name() {
    $this->assertNull($this->_noninventoryitem->getIncomeAccountName());
  }

  public function test_set_income_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setIncomeAccountName($str));

    return $str;
  }

  public function test_set_get_income_account_name() {
    $str = $this->test_set_income_account_name();
    $this->assertEquals($str, $this->_noninventoryitem->getIncomeAccountName());
  }

  public function test_get_uninitialized_income_account_application_id() {
    $this->assertNull($this->_noninventoryitem->getIncomeAccountApplicationID());
  }

  public function test_set_income_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setIncomeAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_income_account_application_id() {
    $str = $this->test_set_income_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_noninventoryitem->getIncomeAccountApplicationID());
  }

  public function test_get_uninitialized_purchase_description() {
    $this->assertNull($this->_noninventoryitem->getPurchaseDescription());
  }

  public function test_set_purchase_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setPurchaseDescription($str));

    return $str;
  }

  public function test_set_get_purchase_description() {
    $str = $this->test_set_purchase_description();
    $this->assertEquals($str, $this->_noninventoryitem->getPurchaseDescription());
  }

  public function test_get_uninitialized_purchase_cost() {
    $this->assertNull($this->_noninventoryitem->getPurchaseCost());
  }

  public function test_set_purchase_cost() {
    $str = $this->random_nums();
    $this->assertTrue($this->_noninventoryitem->setPurchaseCost($str));

    return $str;
  }

  public function test_set_get_purchase_cost() {
    $str = $this->test_set_purchase_cost();
    $this->assertEquals($str, $this->_noninventoryitem->getPurchaseCost());
  }

  public function test_get_uninitialized_expense_account_list_id() {
    $this->assertNull($this->_noninventoryitem->getExpenseAccountListID());
  }

  public function test_set_expense_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setExpenseAccountListID($str));

    return $str;
  }

  public function test_set_get_expense_account_list_id() {
    $str = $this->test_set_expense_account_list_id();
    $this->assertEquals($str, $this->_noninventoryitem->getExpenseAccountListID());
  }

  public function test_get_uninitialized_expense_account_name() {
    $this->assertNull($this->_noninventoryitem->getExpenseAccountName());
  }

  public function test_set_expense_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setExpenseAccountName($str));

    return $str;
  }

  public function test_set_get_expense_account_name() {
    $str = $this->test_set_expense_account_name();
    $this->assertEquals($str, $this->_noninventoryitem->getExpenseAccountName());
  }

  public function test_get_uninitialized_expense_account_application_id() {
    $this->assertNull($this->_noninventoryitem->getExpenseAccountApplicationID());
  }

  public function test_set_expense_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setExpenseAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_expense_account_application_id() {
    $str = $this->test_set_expense_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_noninventoryitem->getExpenseAccountApplicationID());
  }

  public function test_get_uninitialized_preferred_vendor_list_id() {
    $this->assertNull($this->_noninventoryitem->getPreferredVendorListID());
  }

  public function test_set_preferred_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setPreferredVendorListID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_list_id() {
    $str = $this->test_set_preferred_vendor_list_id();
    $this->assertEquals($str, $this->_noninventoryitem->getPreferredVendorListID());
  }

  public function test_get_uninitialized_preferred_vendor_name() {
    $this->assertNull($this->_noninventoryitem->getPreferredVendorName());
  }

  public function test_set_preferred_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setPreferredVendorName($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_name() {
    $str = $this->test_set_preferred_vendor_name();
    $this->assertEquals($str, $this->_noninventoryitem->getPreferredVendorName());
  }

  public function test_get_uninitialized_preferred_vendor_application_id() {
    $this->assertNull($this->_noninventoryitem->getPreferredVendorApplicationID());
  }

  public function test_set_preferred_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_noninventoryitem->setPreferredVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_application_id() {
    $str = $this->test_set_preferred_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_noninventoryitem->getPreferredVendorApplicationID());
  }
}

