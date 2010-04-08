<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class PaymentItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_paymentitem = new QuickBooks_Object_PaymentItem();
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
    $this->assertNull($this->_paymentitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_paymentitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_paymentitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_paymentitem->getName());
  }

  public function test_get_uninitialized_is_active() {
    $this->assertFalse($this->_paymentitem->getIsActive());
  }

  public function test_set_is_active() {
    $str = TRUE;
    $this->assertTrue($this->_paymentitem->setIsActive($str));

    return $str;
  }

  public function test_set_get_is_active() {
    $str = $this->test_set_is_active();
    $this->assertEquals($str, $this->_paymentitem->getIsActive());
  }

  public function test_get_uninitialized_parent_list_id() {
    $this->assertNull($this->_paymentitem->getParentListID());
  }

  public function test_set_parent_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setParentListID($str));

    return $str;
  }

  public function test_set_get_parent_list_id() {
    $str = $this->test_set_parent_list_id();
    $this->assertEquals($str, $this->_paymentitem->getParentListID());
  }

  public function test_get_uninitialized_parent_name() {
    $this->assertNull($this->_paymentitem->getParentName());
  }

  public function test_set_parent_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setParentName($str));

    return $str;
  }

  public function test_set_get_parent_name() {
    $str = $this->test_set_parent_name();
    $this->assertEquals($str, $this->_paymentitem->getParentName());
  }

  public function test_get_uninitialized_parent_application_id() {
    $this->assertFalse($this->_paymentitem->getParentApplicationID());
  }

  public function test_set_parent_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setParentApplicationID($str));

    return $str;
  }

  public function test_set_get_parent_application_id() {
    $str = $this->test_set_parent_application_id();
    $this->assertEquals($str, $this->_paymentitem->getParentApplicationID());
  }

  public function test_get_uninitialized_sales_tax_code_list_id() {
    $this->assertNull($this->_paymentitem->getSalesTaxCodeListID());
  }

  public function test_set_sales_tax_code_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setSalesTaxCodeListID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_list_id() {
    $str = $this->test_set_sales_tax_code_list_id();
    $this->assertEquals($str, $this->_paymentitem->getSalesTaxCodeListID());
  }

  public function test_get_uninitialized_sales_tax_code_name() {
    $this->assertNull($this->_paymentitem->getSalesTaxCodeName());
  }

  public function test_set_sales_tax_code_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setSalesTaxCodeName($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_name() {
    $str = $this->test_set_sales_tax_code_name();
    $this->assertEquals($str, $this->_paymentitem->getSalesTaxCodeName());
  }

  public function test_get_uninitialized_sales_tax_code_application_id() {
    $this->assertFalse($this->_paymentitem->getSalesTaxCodeApplicationID());
  }

  public function test_set_sales_tax_code_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setSalesTaxCodeApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_application_id() {
    $str = $this->test_set_sales_tax_code_application_id();
    $this->assertEquals($str, $this->_paymentitem->getSalesTaxCodeApplicationID());
  }

  public function test_get_uninitialized_description() {
    $this->assertNull($this->_paymentitem->getDescription());
  }

  public function test_set_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setDescription($str));

    return $str;
  }

  public function test_set_get_description() {
    $str = $this->test_set_description();
    $this->assertEquals($str, $this->_paymentitem->getDescription());
  }

  public function test_get_uninitialized_price() {
    $this->assertNull($this->_paymentitem->getPrice());
  }

  public function test_set_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_paymentitem->setPrice($str));

    return $str;
  }

  public function test_set_get_price() {
    $str = $this->test_set_price();
    $this->assertEquals($str, $this->_paymentitem->getPrice());
  }

  public function test_get_uninitialized_price_percent() {
    $this->assertNull($this->_paymentitem->getPricePercent());
  }

  public function test_set_price_percent() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setPricePercent($str));

    return $str;
  }

  public function test_set_get_price_percent() {
    $str = $this->test_set_price_percent();
    $this->assertEquals($str, $this->_paymentitem->getPricePercent());
  }

  public function test_get_uninitialized_account_list_id() {
    $this->assertNull($this->_paymentitem->getAccountListID());
  }

  public function test_set_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setAccountListID($str));

    return $str;
  }

  public function test_set_get_account_list_id() {
    $str = $this->test_set_account_list_id();
    $this->assertEquals($str, $this->_paymentitem->getAccountListID());
  }

  public function test_get_uninitialized_account_name() {
    $this->assertNull($this->_paymentitem->getAccountName());
  }

  public function test_set_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setAccountName($str));

    return $str;
  }

  public function test_set_get_account_name() {
    $str = $this->test_set_account_name();
    $this->assertEquals($str, $this->_paymentitem->getAccountName());
  }

  public function test_get_uninitialized_account_application_id() {
    $this->assertNull($this->_paymentitem->getAccountApplicationID());
  }

  public function test_set_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_account_application_id() {
    $str = $this->test_set_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_paymentitem->getAccountApplicationID());
  }

  public function test_get_uninitialized_sales_description() {
    $this->assertNull($this->_paymentitem->getSalesDescription());
  }

  public function test_set_sales_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setSalesDescription($str));

    return $str;
  }

  public function test_set_get_sales_description() {
    $str = $this->test_set_sales_description();
    $this->assertEquals($str, $this->_paymentitem->getSalesDescription());
  }

  public function test_get_uninitialized_sales_price() {
    $this->assertNull($this->_paymentitem->getSalesPrice());
  }

  public function test_set_sales_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_paymentitem->setSalesPrice($str));

    return $str;
  }

  public function test_set_get_sales_price() {
    $str = $this->test_set_sales_price();
    $this->assertEquals($str, $this->_paymentitem->getSalesPrice());
  }

  public function test_get_uninitialized_income_account_list_id() {
    $this->assertNull($this->_paymentitem->getIncomeAccountListID());
  }

  public function test_set_income_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setIncomeAccountListID($str));

    return $str;
  }

  public function test_set_get_income_account_list_id() {
    $str = $this->test_set_income_account_list_id();
    $this->assertEquals($str, $this->_paymentitem->getIncomeAccountListID());
  }

  public function test_get_uninitialized_income_account_name() {
    $this->assertNull($this->_paymentitem->getIncomeAccountName());
  }

  public function test_set_income_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setIncomeAccountName($str));

    return $str;
  }

  public function test_set_get_income_account_name() {
    $str = $this->test_set_income_account_name();
    $this->assertEquals($str, $this->_paymentitem->getIncomeAccountName());
  }

  public function test_get_uninitialized_income_account_application_id() {
    $this->assertNull($this->_paymentitem->getIncomeAccountApplicationID());
  }

  public function test_set_income_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setIncomeAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_income_account_application_id() {
    $str = $this->test_set_income_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_paymentitem->getIncomeAccountApplicationID());
  }

  public function test_get_uninitialized_purchase_description() {
    $this->assertNull($this->_paymentitem->getPurchaseDescription());
  }

  public function test_set_purchase_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setPurchaseDescription($str));

    return $str;
  }

  public function test_set_get_purchase_description() {
    $str = $this->test_set_purchase_description();
    $this->assertEquals($str, $this->_paymentitem->getPurchaseDescription());
  }

  public function test_get_uninitialized_purchase_cost() {
    $this->assertNull($this->_paymentitem->getPurchaseCost());
  }

  public function test_set_purchase_cost() {
    $str = $this->random_nums();
    $this->assertTrue($this->_paymentitem->setPurchaseCost($str));

    return $str;
  }

  public function test_set_get_purchase_cost() {
    $str = $this->test_set_purchase_cost();
    $this->assertEquals($str, $this->_paymentitem->getPurchaseCost());
  }

  public function test_get_uninitialized_expense_account_list_id() {
    $this->assertNull($this->_paymentitem->getExpenseAccountListID());
  }

  public function test_set_expense_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setExpenseAccountListID($str));

    return $str;
  }

  public function test_set_get_expense_account_list_id() {
    $str = $this->test_set_expense_account_list_id();
    $this->assertEquals($str, $this->_paymentitem->getExpenseAccountListID());
  }

  public function test_get_uninitialized_expense_account_name() {
    $this->assertNull($this->_paymentitem->getExpenseAccountName());
  }

  public function test_set_expense_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setExpenseAccountName($str));

    return $str;
  }

  public function test_set_get_expense_account_name() {
    $str = $this->test_set_expense_account_name();
    $this->assertEquals($str, $this->_paymentitem->getExpenseAccountName());
  }

  public function test_get_uninitialized_expense_account_application_id() {
    $this->assertNull($this->_paymentitem->getExpenseAccountApplicationID());
  }

  public function test_set_expense_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setExpenseAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_expense_account_application_id() {
    $str = $this->test_set_expense_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_paymentitem->getExpenseAccountApplicationID());
  }

  public function test_get_uninitialized_preferred_vendor_list_id() {
    $this->assertNull($this->_paymentitem->getPreferredVendorListID());
  }

  public function test_set_preferred_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setPreferredVendorListID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_list_id() {
    $str = $this->test_set_preferred_vendor_list_id();
    $this->assertEquals($str, $this->_paymentitem->getPreferredVendorListID());
  }

  public function test_get_uninitialized_preferred_vendor_name() {
    $this->assertNull($this->_paymentitem->getPreferredVendorName());
  }

  public function test_set_preferred_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setPreferredVendorName($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_name() {
    $str = $this->test_set_preferred_vendor_name();
    $this->assertEquals($str, $this->_paymentitem->getPreferredVendorName());
  }

  public function test_get_uninitialized_preferred_vendor_application_id() {
    $this->assertNull($this->_paymentitem->getPreferredVendorApplicationID());
  }

  public function test_set_preferred_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentitem->setPreferredVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_application_id() {
    $str = $this->test_set_preferred_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_paymentitem->getPreferredVendorApplicationID());
  }
}

