<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class PaymentMethodTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_paymentmethod = new QuickBooks_Object_PaymentMethod();
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
    $this->assertNull($this->_paymentmethod->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentmethod->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_paymentmethod->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_paymentmethod->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentmethod->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_paymentmethod->getName());
  }

  public function test_get_uninitialized_is_active() {
    $this->assertNull($this->_paymentmethod->getIsActive());
  }

  public function test_set_is_active() {
    $str = $this->random_chars();
    $this->assertTrue($this->_paymentmethod->setIsActive($str));

    return $str;
  }

  public function test_set_get_is_active() {
    $str = $this->test_set_is_active();
    $this->assertEquals($str, $this->_paymentmethod->getIsActive());
  }
}

