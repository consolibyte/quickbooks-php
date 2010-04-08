<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class ServiceItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_serviceitem = new QuickBooks_Object_ServiceItem();
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
    $this->assertNull($this->_serviceitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_serviceitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_serviceitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_serviceitem->getName());
  }

  public function test_get_uninitialized_is_active() {
    //$this->assertNull($this->_serviceitem->getIsActive());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_is_active() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_serviceitem->setIsActive($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_is_active() {
    //$str = $this->test_set_is_active();
    //$this->assertEquals($str, $this->_serviceitem->getIsActive());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_parent_list_id() {
    $this->assertNull($this->_serviceitem->getParentListID());
  }

  public function test_set_parent_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setParentListID($str));

    return $str;
  }

  public function test_set_get_parent_list_id() {
    $str = $this->test_set_parent_list_id();
    $this->assertEquals($str, $this->_serviceitem->getParentListID());
  }

  public function test_get_uninitialized_parent_name() {
    $this->assertNull($this->_serviceitem->getParentName());
  }

  public function test_set_parent_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setParentName($str));

    return $str;
  }

  public function test_set_get_parent_name() {
    $str = $this->test_set_parent_name();
    $this->assertEquals($str, $this->_serviceitem->getParentName());
  }

  public function test_get_uninitialized_parent_application_id() {
    //$this->assertNull($this->_serviceitem->getParentApplicationID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_parent_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setParentApplicationID($str));

    return $str;
  }

  public function test_set_get_parent_application_id() {
    $str = $this->test_set_parent_application_id();
    $this->assertEquals($str, $this->_serviceitem->getParentApplicationID());
  }

  public function test_get_uninitialized_sales_tax_code_list_id() {
    $this->assertNull($this->_serviceitem->getSalesTaxCodeListID());
  }

  public function test_set_sales_tax_code_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setSalesTaxCodeListID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_list_id() {
    $str = $this->test_set_sales_tax_code_list_id();
    $this->assertEquals($str, $this->_serviceitem->getSalesTaxCodeListID());
  }

  public function test_get_uninitialized_sales_tax_code_name() {
    $this->assertNull($this->_serviceitem->getSalesTaxCodeName());
  }

  public function test_set_sales_tax_code_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setSalesTaxCodeName($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_name() {
    $str = $this->test_set_sales_tax_code_name();
    $this->assertEquals($str, $this->_serviceitem->getSalesTaxCodeName());
  }

  public function test_get_uninitialized_sales_tax_code_application_id() {
    //$this->assertNull($this->_serviceitem->getSalesTaxCodeApplicationID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_sales_tax_code_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setSalesTaxCodeApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_application_id() {
    $str = $this->test_set_sales_tax_code_application_id();
    $this->assertEquals($str, $this->_serviceitem->getSalesTaxCodeApplicationID());
  }

  public function test_get_uninitialized_description() {
    $this->assertNull($this->_serviceitem->getDescription());
  }

  public function test_set_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setDescription($str));

    return $str;
  }

  public function test_set_get_description() {
    $str = $this->test_set_description();
    $this->assertEquals($str, $this->_serviceitem->getDescription());
  }

  public function test_get_uninitialized_price() {
    $this->assertNull($this->_serviceitem->getPrice());
  }

  public function test_set_price() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setPrice('0.00'));

    return $str;
  }

  public function test_set_get_price() {
    $str = $this->test_set_price();
    $this->assertEquals('0.00', $this->_serviceitem->getPrice());
  }

  public function test_get_uninitialized_price_percent() {
    $this->assertNull($this->_serviceitem->getPricePercent());
  }

  public function test_set_price_percent() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setPricePercent($str));

    return $str;
  }

  public function test_set_get_price_percent() {
    $str = $this->test_set_price_percent();
    $this->assertEquals($str, $this->_serviceitem->getPricePercent());
  }

  public function test_get_uninitialized_account_list_id() {
    $this->assertNull($this->_serviceitem->getAccountListID());
  }

  public function test_set_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setAccountListID($str));

    return $str;
  }

  public function test_set_get_account_list_id() {
    $str = $this->test_set_account_list_id();
    $this->assertEquals($str, $this->_serviceitem->getAccountListID());
  }

  public function test_get_uninitialized_account_name() {
    $this->assertNull($this->_serviceitem->getAccountName());
  }

  public function test_set_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setAccountName($str));

    return $str;
  }

  public function test_set_get_account_name() {
    $str = $this->test_set_account_name();
    $this->assertEquals($str, $this->_serviceitem->getAccountName());
  }

  public function test_get_uninitialized_account_application_id() {
    $this->assertNull($this->_serviceitem->getAccountApplicationID());
  }

  public function test_set_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_account_application_id() {
    $str = $this->test_set_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_serviceitem->getAccountApplicationID());
  }

  public function test_get_uninitialized_sales_description() {
    $this->assertNull($this->_serviceitem->getSalesDescription());
  }

  public function test_set_sales_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setSalesDescription($str));

    return $str;
  }

  public function test_set_get_sales_description() {
    $str = $this->test_set_sales_description();
    $this->assertEquals($str, $this->_serviceitem->getSalesDescription());
  }

  public function test_get_uninitialized_sales_price() {
    $this->assertNull($this->_serviceitem->getSalesPrice());
  }

  public function test_set_sales_price() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setSalesPrice('0.00'));

    return $str;
  }

  public function test_set_get_sales_price() {
    $str = $this->test_set_sales_price();
    $this->assertEquals('0.00', $this->_serviceitem->getSalesPrice());
  }

  public function test_get_uninitialized_income_account_list_id() {
    $this->assertNull($this->_serviceitem->getIncomeAccountListID());
  }

  public function test_set_income_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setIncomeAccountListID($str));

    return $str;
  }

  public function test_set_get_income_account_list_id() {
    $str = $this->test_set_income_account_list_id();
    $this->assertEquals($str, $this->_serviceitem->getIncomeAccountListID());
  }

  public function test_get_uninitialized_income_account_name() {
    $this->assertNull($this->_serviceitem->getIncomeAccountName());
  }

  public function test_set_income_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setIncomeAccountName($str));

    return $str;
  }

  public function test_set_get_income_account_name() {
    $str = $this->test_set_income_account_name();
    $this->assertEquals($str, $this->_serviceitem->getIncomeAccountName());
  }

  public function test_get_uninitialized_income_account_application_id() {
    $this->assertNull($this->_serviceitem->getIncomeAccountApplicationID());
  }

  public function test_set_income_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setIncomeAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_income_account_application_id() {
    $str = $this->test_set_income_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_serviceitem->getIncomeAccountApplicationID());
  }

  public function test_get_uninitialized_purchase_description() {
    $this->assertNull($this->_serviceitem->getPurchaseDescription());
  }

  public function test_set_purchase_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setPurchaseDescription($str));

    return $str;
  }

  public function test_set_get_purchase_description() {
    $str = $this->test_set_purchase_description();
    $this->assertEquals($str, $this->_serviceitem->getPurchaseDescription());
  }

  public function test_get_uninitialized_purchase_cost() {
    $this->assertNull($this->_serviceitem->getPurchaseCost());
  }

  public function test_set_purchase_cost() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setPurchaseCost($str));

    return $str;
  }

  public function test_set_get_purchase_cost() {
    //$str = $this->test_set_purchase_cost();
    //$this->assertEquals($str, $this->_serviceitem->getPurchaseCost());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_expense_account_list_id() {
    $this->assertNull($this->_serviceitem->getExpenseAccountListID());
  }

  public function test_set_expense_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setExpenseAccountListID($str));

    return $str;
  }

  public function test_set_get_expense_account_list_id() {
    $str = $this->test_set_expense_account_list_id();
    $this->assertEquals($str, $this->_serviceitem->getExpenseAccountListID());
  }

  public function test_get_uninitialized_expense_account_name() {
    $this->assertNull($this->_serviceitem->getExpenseAccountName());
  }

  public function test_set_expense_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setExpenseAccountName($str));

    return $str;
  }

  public function test_set_get_expense_account_name() {
    $str = $this->test_set_expense_account_name();
    $this->assertEquals($str, $this->_serviceitem->getExpenseAccountName());
  }

  public function test_get_uninitialized_expense_account_application_id() {
    $this->assertNull($this->_serviceitem->getExpenseAccountApplicationID());
  }

  public function test_set_expense_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setExpenseAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_expense_account_application_id() {
    $str = $this->test_set_expense_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_serviceitem->getExpenseAccountApplicationID());
  }

  public function test_get_uninitialized_preferred_vendor_list_id() {
    $this->assertNull($this->_serviceitem->getPreferredVendorListID());
  }

  public function test_set_preferred_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setPreferredVendorListID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_list_id() {
    $str = $this->test_set_preferred_vendor_list_id();
    $this->assertEquals($str, $this->_serviceitem->getPreferredVendorListID());
  }

  public function test_get_uninitialized_preferred_vendor_name() {
    $this->assertNull($this->_serviceitem->getPreferredVendorName());
  }

  public function test_set_preferred_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setPreferredVendorName($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_name() {
    $str = $this->test_set_preferred_vendor_name();
    $this->assertEquals($str, $this->_serviceitem->getPreferredVendorName());
  }

  public function test_get_uninitialized_preferred_vendor_application_id() {
    $this->assertNull($this->_serviceitem->getPreferredVendorApplicationID());
  }

  public function test_set_preferred_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_serviceitem->setPreferredVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_preferred_vendor_application_id() {
    $str = $this->test_set_preferred_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_serviceitem->getPreferredVendorApplicationID());
  }
}

