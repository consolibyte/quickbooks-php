<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class DiscountItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_discountitem = new QuickBooks_Object_DiscountItem();
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
    $this->assertNull($this->_discountitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_discountitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_discountitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_discountitem->getName());
  }

  public function test_get_uninitialized_parent_application_id() {
    $this->assertNull($this->_discountitem->getParentApplicationID());
  }

  public function test_set_parent_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setParentApplicationID($str));

    return $str;
  }

  public function test_set_get_parent_application_id() {
    $str = $this->test_set_parent_application_id();
    $this->assertEquals('ItemDiscount|ListID|'. $str, $this->_discountitem->getParentApplicationID());
  }

  public function test_get_uninitialized_parent_list_id() {
    $this->assertNull($this->_discountitem->getParentListID());
  }

  public function test_set_parent_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setParentListID($str));

    return $str;
  }

  public function test_set_get_parent_list_id() {
    $str = $this->test_set_parent_list_id();
    $this->assertEquals($str, $this->_discountitem->getParentListID());
  }

  public function test_get_uninitialized_parent_name() {
    $this->assertNull($this->_discountitem->getParentName());
  }

  public function test_set_parent_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setParentName($str));

    return $str;
  }

  public function test_set_get_parent_name() {
    $str = $this->test_set_parent_name();
    $this->assertEquals($str, $this->_discountitem->getParentName());
  }

  public function test_get_uninitialized_description() {
    $this->assertNull($this->_discountitem->getDescription());
  }

  public function test_set_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setDescription($str));

    return $str;
  }

  public function test_set_get_description() {
    $str = $this->test_set_description();
    $this->assertEquals($str, $this->_discountitem->getDescription());
  }

  public function test_get_uninitialized_sales_tax_code_name() {
    $this->assertNull($this->_discountitem->getSalesTaxCodeName());
  }

  public function test_set_sales_tax_code_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setSalesTaxCodeName($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_name() {
    $str = $this->test_set_sales_tax_code_name();
    $this->assertEquals($str, $this->_discountitem->getSalesTaxCodeName());
  }

  public function test_get_uninitialized_discount_rate() {
    $this->assertNull($this->_discountitem->getDiscountRate());
  }

  public function test_set_discount_rate() {
    $str = $this->random_nums();
    $this->assertTrue($this->_discountitem->setDiscountRate($str));

    return $str;
  }

  public function test_set_get_discount_rate() {
    $str = $this->test_set_discount_rate();
    $this->assertEquals($str, $this->_discountitem->getDiscountRate());
  }

  public function test_get_uninitialized_discount_rate_percent() {
    $this->assertNull($this->_discountitem->getDiscountRatePercent());
  }

  public function test_set_discount_rate_percent() {
    $str = $this->random_nums();
    $this->assertTrue($this->_discountitem->setDiscountRatePercent($str));

    return $str;
  }

  public function test_set_get_discount_rate_percent() {
    $str = $this->test_set_discount_rate_percent();
    $this->assertEquals($str, $this->_discountitem->getDiscountRatePercent());
  }

  public function test_get_uninitialized_account_application_id() {
    $this->assertNull($this->_discountitem->getAccountApplicationID());
  }

  public function test_set_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_account_application_id() {
    $str = $this->test_set_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_discountitem->getAccountApplicationID());
  }

  public function test_get_uninitialized_account_list_id() {
    $this->assertNull($this->_discountitem->getAccountListID());
  }

  public function test_set_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setAccountListID($str));

    return $str;
  }

  public function test_set_get_account_list_id() {
    $str = $this->test_set_account_list_id();
    $this->assertEquals($str, $this->_discountitem->getAccountListID());
  }

  public function test_get_uninitialized_account_name() {
    $this->assertNull($this->_discountitem->getAccountName());
  }

  public function test_set_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_discountitem->setAccountName($str));

    return $str;
  }

  public function test_set_get_account_name() {
    $str = $this->test_set_account_name();
    $this->assertEquals($str, $this->_discountitem->getAccountName());
  }
}

