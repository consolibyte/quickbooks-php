<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class ShipMethodTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_shipmethod = new QuickBooks_Object_ShipMethod();
  }

  public function random_chars($len = 0) {
    if ($len == 0) {
      $len = rand(5,20);
    }

    return substr(md5(microtime()), $len);
  }


  public function test_get_uninitialized_list_id() {
    $this->assertNull($this->_shipmethod->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_shipmethod->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_shipmethod->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_shipmethod->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_shipmethod->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_shipmethod->getName());
  }

  public function test_get_uninitialized_is_active() {
    $this->assertNull($this->_shipmethod->getIsActive());
  }

  public function test_set_is_active() {
    $str = $this->random_chars();
    $this->assertTrue($this->_shipmethod->setIsActive($str));

    return $str;
  }

  public function test_set_get_is_active() {
    $str = $this->test_set_is_active();
    $this->assertEquals($str, $this->_shipmethod->getIsActive());
  }
}

