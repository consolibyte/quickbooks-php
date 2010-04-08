<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class ReceiptItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_receiptitem = new QuickBooks_Object_ReceiptItem();
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
    $this->assertNull($this->_receiptitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_receiptitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_receiptitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_receiptitem->getName());
  }

  public function test_get_uninitialized_is_active() {
    $this->assertFalse($this->_receiptitem->getIsActive());
  }

  public function test_set_is_active() {
    $str = TRUE;
    $this->assertTrue($this->_receiptitem->setIsActive($str));

    return $str;
  }

  public function test_set_get_is_active() {
    $str = $this->test_set_is_active();
    $this->assertEquals($str, $this->_receiptitem->getIsActive());
  }

  public function test_get_uninitialized_parent_list_id() {
    $this->assertNull($this->_receiptitem->getParentListID());
  }

  public function test_set_parent_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setParentListID($str));

    return $str;
  }

  public function test_set_get_parent_list_id() {
    $str = $this->test_set_parent_list_id();
    $this->assertEquals($str, $this->_receiptitem->getParentListID());
  }

  public function test_get_uninitialized_parent_name() {
    $this->assertNull($this->_receiptitem->getParentName());
  }

  public function test_set_parent_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setParentName($str));

    return $str;
  }

  public function test_set_get_parent_name() {
    $str = $this->test_set_parent_name();
    $this->assertEquals($str, $this->_receiptitem->getParentName());
  }

  public function test_get_uninitialized_parent_application_id() {
    $this->assertFalse($this->_receiptitem->getParentApplicationID());
  }

  public function test_set_parent_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setParentApplicationID($str));

    return $str;
  }

  public function test_set_get_parent_application_id() {
    $str = $this->test_set_parent_application_id();
    $this->assertEquals($str, $this->_receiptitem->getParentApplicationID());
  }

  public function test_get_uninitialized_sales_tax_code_list_id() {
    $this->assertNull($this->_receiptitem->getSalesTaxCodeListID());
  }

  public function test_set_sales_tax_code_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setSalesTaxCodeListID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_list_id() {
    $str = $this->test_set_sales_tax_code_list_id();
    $this->assertEquals($str, $this->_receiptitem->getSalesTaxCodeListID());
  }

  public function test_get_uninitialized_sales_tax_code_name() {
    $this->assertNull($this->_receiptitem->getSalesTaxCodeName());
  }

  public function test_set_sales_tax_code_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setSalesTaxCodeName($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_name() {
    $str = $this->test_set_sales_tax_code_name();
    $this->assertEquals($str, $this->_receiptitem->getSalesTaxCodeName());
  }

  public function test_get_uninitialized_sales_tax_code_application_id() {
    $this->assertFalse($this->_receiptitem->getSalesTaxCodeApplicationID());
  }

  public function test_set_sales_tax_code_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setSalesTaxCodeApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_application_id() {
    $str = $this->test_set_sales_tax_code_application_id();
    $this->assertEquals($str, $this->_receiptitem->getSalesTaxCodeApplicationID());
  }

  public function test_get_uninitialized_description() {
    $this->assertNull($this->_receiptitem->getDescription());
  }

  public function test_set_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setDescription($str));

    return $str;
  }

  public function test_set_get_description() {
    $str = $this->test_set_description();
    $this->assertEquals($str, $this->_receiptitem->getDescription());
  }

  public function test_get_uninitialized_price() {
    $this->assertNull($this->_receiptitem->getPrice());
  }

  public function test_set_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_receiptitem->setPrice($str));

    return $str;
  }

  public function test_set_get_price() {
    $str = $this->test_set_price();
    $this->assertEquals($str, $this->_receiptitem->getPrice());
  }

  public function test_get_uninitialized_price_percent() {
    $this->assertNull($this->_receiptitem->getPricePercent());
  }

  public function test_set_price_percent() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setPricePercent($str));

    return $str;
  }

  public function test_set_get_price_percent() {
    $str = $this->test_set_price_percent();
    $this->assertEquals($str, $this->_receiptitem->getPricePercent());
  }

  public function test_get_uninitialized_account_list_id() {
    $this->assertNull($this->_receiptitem->getAccountListID());
  }

  public function test_set_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setAccountListID($str));

    return $str;
  }

  public function test_set_get_account_list_id() {
    $str = $this->test_set_account_list_id();
    $this->assertEquals($str, $this->_receiptitem->getAccountListID());
  }

  public function test_get_uninitialized_account_name() {
    $this->assertNull($this->_receiptitem->getAccountName());
  }

  public function test_set_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setAccountName($str));

    return $str;
  }

  public function test_set_get_account_name() {
    $str = $this->test_set_account_name();
    $this->assertEquals($str, $this->_receiptitem->getAccountName());
  }

  public function test_get_uninitialized_account_application_id() {
    $this->assertNull($this->_receiptitem->getAccountApplicationID());
  }

  public function test_set_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_account_application_id() {
    $str = $this->test_set_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_receiptitem->getAccountApplicationID());
  }

  public function test_get_uninitialized_sales_description() {
    $this->assertNull($this->_receiptitem->getSalesDescription());
  }

  public function test_set_sales_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setSalesDescription($str));

    return $str;
  }

  public function test_set_get_sales_description() {
    $str = $this->test_set_sales_description();
    $this->assertEquals($str, $this->_receiptitem->getSalesDescription());
  }

  public function test_get_uninitialized_sales_price() {
    $this->assertNull($this->_receiptitem->getSalesPrice());
  }

  public function test_set_sales_price() {
    $str = $this->random_nums();
    $this->assertTrue($this->_receiptitem->setSalesPrice($str));

    return $str;
  }

  public function test_set_get_sales_price() {
    $str = $this->test_set_sales_price();
    $this->assertEquals($str, $this->_receiptitem->getSalesPrice());
  }

  public function test_get_uninitialized_income_account_list_id() {
    $this->assertNull($this->_receiptitem->getIncomeAccountListID());
  }

  public function test_set_income_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setIncomeAccountListID($str));

    return $str;
  }

  public function test_set_get_income_account_list_id() {
    $str = $this->test_set_income_account_list_id();
    $this->assertEquals($str, $this->_receiptitem->getIncomeAccountListID());
  }

  public function test_get_uninitialized_income_account_name() {
    $this->assertNull($this->_receiptitem->getIncomeAccountName());
  }

  public function test_set_income_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setIncomeAccountName($str));

    return $str;
  }

  public function test_set_get_income_account_name() {
    $str = $this->test_set_income_account_name();
    $this->assertEquals($str, $this->_receiptitem->getIncomeAccountName());
  }

  public function test_get_uninitialized_income_account_application_id() {
    $this->assertNull($this->_receiptitem->getIncomeAccountApplicationID());
  }

  public function test_set_income_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setIncomeAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_income_account_application_id() {
    $str = $this->test_set_income_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_receiptitem->getIncomeAccountApplicationID());
  }

  public function test_get_uninitialized_purchase_description() {
    $this->assertNull($this->_receiptitem->getPurchaseDescription());
  }

  public function test_set_purchase_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setPurchaseDescription($str));

    return $str;
  }

  public function test_set_get_purchase_description() {
    $str = $this->test_set_purchase_description();
    $this->assertEquals($str, $this->_receiptitem->getPurchaseDescription());
  }

  public function test_get_uninitialized_purchase_cost() {
    $this->assertNull($this->_receiptitem->getPurchaseCost());
  }

  public function test_set_purchase_cost() {
    $str = $this->random_nums();
    $this->assertTrue($this->_receiptitem->setPurchaseCost($str));

    return $str;
  }

  public function test_set_get_purchase_cost() {
    $str = $this->test_set_purchase_cost();
    $this->assertEquals($str, $this->_receiptitem->getPurchaseCost());
  }

  public function test_get_uninitialized_expense_account_list_id() {
    $this->assertNull($this->_receiptitem->getExpenseAccountListID());
  }

  public function test_set_expense_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setExpenseAccountListID($str));

    return $str;
  }

  public function test_set_get_expense_account_list_id() {
    $str = $this->test_set_expense_account_list_id();
    $this->assertEquals($str, $this->_receiptitem->getExpenseAccountListID());
  }

  public function test_get_uninitialized_expense_account_name() {
    $this->assertNull($this->_receiptitem->getExpenseAccountName());
  }

  public function test_set_expense_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setExpenseAccountName($str));

    return $str;
  }

  public function test_set_get_expense_account_name() {
    $str = $this->test_set_expense_account_name();
    $this->assertEquals($str, $this->_receiptitem->getExpenseAccountName());
  }

  public function test_get_uninitialized_expense_account_application_id() {
    $this->assertNull($this->_receiptitem->getExpenseAccountApplicationID());
  }

  public function test_set_expense_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setExpenseAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_expense_account_application_id() {
    $str = $this->test_set_expense_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_receiptitem->getExpenseAccountApplicationID());
  }

  public function test_get_uninitialized_preferred_vendor_list_id() {
    $this->assertNull($this->_receiptitem->getPreferredVendorListID());
  }

  public function test_set_preferred_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setPreferredVendorListID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_list_id() {
    $str = $this->test_set_preferred_vendor_list_id();
    $this->assertEquals($str, $this->_receiptitem->getPreferredVendorListID());
  }

  public function test_get_uninitialized_preferred_vendor_name() {
    $this->assertNull($this->_receiptitem->getPreferredVendorName());
  }

  public function test_set_preferred_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setPreferredVendorName($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_name() {
    $str = $this->test_set_preferred_vendor_name();
    $this->assertEquals($str, $this->_receiptitem->getPreferredVendorName());
  }

  public function test_get_uninitialized_preferred_vendor_application_id() {
    $this->assertNull($this->_receiptitem->getPreferredVendorApplicationID());
  }

  public function test_set_preferred_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receiptitem->setPreferredVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_application_id() {
    $str = $this->test_set_preferred_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_receiptitem->getPreferredVendorApplicationID());
  }
}

