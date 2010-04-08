<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class SalesTaxItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_salestaxitem = new QuickBooks_Object_SalesTaxItem();
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
    $this->assertNull($this->_salestaxitem->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salestaxitem->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_salestaxitem->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_salestaxitem->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salestaxitem->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_salestaxitem->getName());
  }

  public function test_get_uninitialized_tax_rate() {
    $this->assertNull($this->_salestaxitem->getTaxRate());
  }

  public function test_set_tax_rate() {
    $str = $this->random_nums();
    $this->assertTrue($this->_salestaxitem->setTaxRate($str));

    return $str;
  }

  public function test_set_get_tax_rate() {
    $str = $this->test_set_tax_rate();
    $this->assertEquals($str, $this->_salestaxitem->getTaxRate());
  }

  public function test_get_uninitialized_description() {
    $this->assertNull($this->_salestaxitem->getDescription());
  }

  public function test_set_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salestaxitem->setDescription($str));

    return $str;
  }

  public function test_set_get_description() {
    $str = $this->test_set_description();
    $this->assertEquals($str, $this->_salestaxitem->getDescription());
  }

  public function test_get_uninitialized_tax_vendor_list_id() {
    $this->assertNull($this->_salestaxitem->getTaxVendorListID());
  }

  public function test_set_tax_vendor_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salestaxitem->setTaxVendorListID($str));

    return $str;
  }

  public function test_set_get_tax_vendor_list_id() {
    $str = $this->test_set_tax_vendor_list_id();
    $this->assertEquals($str, $this->_salestaxitem->getTaxVendorListID());
  }

  public function test_get_uninitialized_tax_vendor_name() {
    $this->assertNull($this->_salestaxitem->getTaxVendorName());
  }

  public function test_set_tax_vendor_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salestaxitem->setTaxVendorName($str));

    return $str;
  }

  public function test_set_get_tax_vendor_name() {
    $str = $this->test_set_tax_vendor_name();
    $this->assertEquals($str, $this->_salestaxitem->getTaxVendorName());
  }

  public function test_get_uninitialized_tax_vendor_application_id() {
    $this->assertNull($this->_salestaxitem->getTaxVendorApplicationID());
  }

  public function test_set_tax_vendor_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salestaxitem->setTaxVendorApplicationID($str));

    return $str;
  }

  public function test_set_get_tax_vendor_application_id() {
    $str = $this->test_set_tax_vendor_application_id();
    $this->assertEquals('Vendor|ListID|'. $str, $this->_salestaxitem->getTaxVendorApplicationID());
  }
}

