<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class OtherChargeItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_otherchargeitem = new QuickBooks_Object_OtherChargeItem();
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
    $this->assertNull($this->_otherchargeitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_otherchargeitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_otherchargeitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_otherchargeitem->getName());
  }

  public function test_get_uninitialized_is_active() {
    $this->assertFalse($this->_otherchargeitem->getIsActive());
  }

  public function test_set_is_active() {
    $str = FALSE;
    $this->assertTrue($this->_otherchargeitem->setIsActive($str));

    return $str;
  }

  public function test_set_get_is_active() {
    $str = $this->test_set_is_active();
    $this->assertEquals($str, $this->_otherchargeitem->getIsActive());
  }

  public function test_get_uninitialized_parent_list_id() {
    $this->assertNull($this->_otherchargeitem->getParentListID());
  }

  public function test_set_parent_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setParentListID($str));

    return $str;
  }

  public function test_set_get_parent_list_id() {
    $str = $this->test_set_parent_list_id();
    $this->assertEquals($str, $this->_otherchargeitem->getParentListID());
  }

  public function test_get_uninitialized_parent_name() {
    $this->assertNull($this->_otherchargeitem->getParentName());
  }

  public function test_set_parent_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setParentName($str));

    return $str;
  }

  public function test_set_get_parent_name() {
    $str = $this->test_set_parent_name();
    $this->assertEquals($str, $this->_otherchargeitem->getParentName());
  }

  public function test_get_uninitialized_parent_application_id() {
    $this->assertFalse($this->_otherchargeitem->getParentApplicationID());
  }

  public function test_set_parent_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setParentApplicationID($str));

    return $str;
  }

  public function test_set_get_parent_application_id() {
    $str = $this->test_set_parent_application_id();
    $this->assertEquals($str, $this->_otherchargeitem->getParentApplicationID());
  }

  public function test_get_uninitialized_sales_tax_code_list_id() {
    $this->assertNull($this->_otherchargeitem->getSalesTaxCodeListID());
  }

  public function test_set_sales_tax_code_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setSalesTaxCodeListID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_list_id() {
    $str = $this->test_set_sales_tax_code_list_id();
    $this->assertEquals($str, $this->_otherchargeitem->getSalesTaxCodeListID());
  }

  public function test_get_uninitialized_sales_tax_code_name() {
    $this->assertNull($this->_otherchargeitem->getSalesTaxCodeName());
  }

  public function test_set_sales_tax_code_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setSalesTaxCodeName($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_name() {
    $str = $this->test_set_sales_tax_code_name();
    $this->assertEquals($str, $this->_otherchargeitem->getSalesTaxCodeName());
  }

  public function test_get_uninitialized_sales_tax_code_application_id() {
    $this->assertFalse($this->_otherchargeitem->getSalesTaxCodeApplicationID());
  }

  public function test_set_sales_tax_code_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setSalesTaxCodeApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_application_id() {
    $str = $this->test_set_sales_tax_code_application_id();
    $this->assertEquals($str, $this->_otherchargeitem->getSalesTaxCodeApplicationID());
  }

  public function test_get_uninitialized_description() {
    $this->assertNull($this->_otherchargeitem->getDescription());
  }

  public function test_set_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setDescription($str));

    return $str;
  }

  public function test_set_get_description() {
    $str = $this->test_set_description();
    $this->assertEquals($str, $this->_otherchargeitem->getDescription());
  }

  public function test_get_uninitialized_price() {
    $this->assertNull($this->_otherchargeitem->getPrice());
  }

  public function test_set_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_otherchargeitem->setPrice($str));

    return $str;
  }

  public function test_set_get_price() {
    $str = $this->test_set_price();
    $this->assertEquals($str, $this->_otherchargeitem->getPrice());
  }

  public function test_get_uninitialized_price_percent() {
    $this->assertNull($this->_otherchargeitem->getPricePercent());
  }

  public function test_set_price_percent() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setPricePercent($str));

    return $str;
  }

  public function test_set_get_price_percent() {
    $str = $this->test_set_price_percent();
    $this->assertEquals($str, $this->_otherchargeitem->getPricePercent());
  }

  public function test_get_uninitialized_account_list_id() {
    $this->assertNull($this->_otherchargeitem->getAccountListID());
  }

  public function test_set_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setAccountListID($str));

    return $str;
  }

  public function test_set_get_account_list_id() {
    $str = $this->test_set_account_list_id();
    $this->assertEquals($str, $this->_otherchargeitem->getAccountListID());
  }

  public function test_get_uninitialized_account_name() {
    $this->assertNull($this->_otherchargeitem->getAccountName());
  }

  public function test_set_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setAccountName($str));

    return $str;
  }

  public function test_set_get_account_name() {
    $str = $this->test_set_account_name();
    $this->assertEquals($str, $this->_otherchargeitem->getAccountName());
  }

  public function test_get_uninitialized_account_application_id() {
    $this->assertNull($this->_otherchargeitem->getAccountApplicationID());
  }

  public function test_set_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_account_application_id() {
    $str = $this->test_set_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_otherchargeitem->getAccountApplicationID());
  }

  public function test_get_uninitialized_sales_description() {
    $this->assertNull($this->_otherchargeitem->getSalesDescription());
  }

  public function test_set_sales_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setSalesDescription($str));

    return $str;
  }

  public function test_set_get_sales_description() {
    $str = $this->test_set_sales_description();
    $this->assertEquals($str, $this->_otherchargeitem->getSalesDescription());
  }

  public function test_get_uninitialized_sales_price() {
    $this->assertNull($this->_otherchargeitem->getSalesPrice());
  }

  public function test_set_sales_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_otherchargeitem->setSalesPrice($str));

    return $str;
  }

  public function test_set_get_sales_price() {
    $str = $this->test_set_sales_price();
    $this->assertEquals($str, $this->_otherchargeitem->getSalesPrice());
  }

  public function test_get_uninitialized_income_account_list_id() {
    $this->assertNull($this->_otherchargeitem->getIncomeAccountListID());
  }

  public function test_set_income_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setIncomeAccountListID($str));

    return $str;
  }

  public function test_set_get_income_account_list_id() {
    $str = $this->test_set_income_account_list_id();
    $this->assertEquals($str, $this->_otherchargeitem->getIncomeAccountListID());
  }

  public function test_get_uninitialized_income_account_name() {
    $this->assertNull($this->_otherchargeitem->getIncomeAccountName());
  }

  public function test_set_income_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setIncomeAccountName($str));

    return $str;
  }

  public function test_set_get_income_account_name() {
    $str = $this->test_set_income_account_name();
    $this->assertEquals($str, $this->_otherchargeitem->getIncomeAccountName());
  }

  public function test_get_uninitialized_income_account_application_id() {
    $this->assertNull($this->_otherchargeitem->getIncomeAccountApplicationID());
  }

  public function test_set_income_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setIncomeAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_income_account_application_id() {
    $str = $this->test_set_income_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_otherchargeitem->getIncomeAccountApplicationID());
  }

  public function test_get_uninitialized_purchase_description() {
    $this->assertNull($this->_otherchargeitem->getPurchaseDescription());
  }

  public function test_set_purchase_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setPurchaseDescription($str));

    return $str;
  }

  public function test_set_get_purchase_description() {
    $str = $this->test_set_purchase_description();
    $this->assertEquals($str, $this->_otherchargeitem->getPurchaseDescription());
  }

  public function test_get_uninitialized_purchase_cost() {
    $this->assertNull($this->_otherchargeitem->getPurchaseCost());
  }

  public function test_set_purchase_cost() {
    $str = $this->random_nums();
    $this->assertTrue($this->_otherchargeitem->setPurchaseCost($str));

    return $str;
  }

  public function test_set_get_purchase_cost() {
    $str = $this->test_set_purchase_cost();
    $this->assertEquals($str, $this->_otherchargeitem->getPurchaseCost());
  }

  public function test_get_uninitialized_expense_account_list_id() {
    $this->assertNull($this->_otherchargeitem->getExpenseAccountListID());
  }

  public function test_set_expense_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setExpenseAccountListID($str));

    return $str;
  }

  public function test_set_get_expense_account_list_id() {
    $str = $this->test_set_expense_account_list_id();
    $this->assertEquals($str, $this->_otherchargeitem->getExpenseAccountListID());
  }

  public function test_get_uninitialized_expense_account_name() {
    $this->assertNull($this->_otherchargeitem->getExpenseAccountName());
  }

  public function test_set_expense_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setExpenseAccountName($str));

    return $str;
  }

  public function test_set_get_expense_account_name() {
    $str = $this->test_set_expense_account_name();
    $this->assertEquals($str, $this->_otherchargeitem->getExpenseAccountName());
  }

  public function test_get_uninitialized_expense_account_application_id() {
    $this->assertNull($this->_otherchargeitem->getExpenseAccountApplicationID());
  }

  public function test_set_expense_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setExpenseAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_expense_account_application_id() {
    $str = $this->test_set_expense_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_otherchargeitem->getExpenseAccountApplicationID());
  }

  public function test_get_uninitialized_preferred_vendor_list_id() {
    $this->assertNull($this->_otherchargeitem->getPreferredVendorListID());
  }

  public function test_set_preferred_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setPreferredVendorListID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_list_id() {
    $str = $this->test_set_preferred_vendor_list_id();
    $this->assertEquals($str, $this->_otherchargeitem->getPreferredVendorListID());
  }

  public function test_get_uninitialized_preferred_vendor_name() {
    $this->assertNull($this->_otherchargeitem->getPreferredVendorName());
  }

  public function test_set_preferred_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setPreferredVendorName($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_name() {
    $str = $this->test_set_preferred_vendor_name();
    $this->assertEquals($str, $this->_otherchargeitem->getPreferredVendorName());
  }

  public function test_get_uninitialized_preferred_vendor_application_id() {
    $this->assertNull($this->_otherchargeitem->getPreferredVendorApplicationID());
  }

  public function test_set_preferred_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_otherchargeitem->setPreferredVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_application_id() {
    $str = $this->test_set_preferred_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_otherchargeitem->getPreferredVendorApplicationID());
  }
}

