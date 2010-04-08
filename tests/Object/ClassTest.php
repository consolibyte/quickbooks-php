<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class ClassTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_class = new QuickBooks_Object_Class();
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
    $this->assertNull($this->_class->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_class->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_class->getListID());
  }

  public function test_get_uninitialized_parent_list_id() {
    $this->assertNull($this->_class->getParentListID());
  }

  public function test_set_parent_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_class->setParentListID($str));

    return $str;
  }

  public function test_set_get_parent_list_id() {
    $str = $this->test_set_parent_list_id();
    $this->assertEquals($str, $this->_class->getParentListID());
  }

  public function test_get_uninitialized_parent_name() {
    $this->assertNull($this->_class->getParentName());
  }

  public function test_set_parent_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_class->setParentName($str));

    return $str;
  }

  public function test_set_get_parent_name() {
    $str = $this->test_set_parent_name();
    $this->assertEquals($str, $this->_class->getParentName());
  }

  public function test_get_uninitialized_parent_application_id() {
    $this->assertNull($this->_class->getParentApplicationID());
  }

  public function test_set_parent_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_class->setParentApplicationID($str));

    return $str;
  }

  public function test_set_get_parent_application_id() {
    $str = $this->test_set_parent_application_id();
    $this->assertEquals('Class|ListID|'. $str, $this->_class->getParentApplicationID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_class->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_class->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_class->getName());
  }

  public function test_get_uninitialized_full_name() {
    $this->assertNull($this->_class->getFullName());
  }

  public function test_set_full_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_class->setFullName($str));

    return $str;
  }

  public function test_set_get_full_name() {
    $str = $this->test_set_full_name();
    $this->assertEquals($str, $this->_class->getFullName());
  }

  public function test_get_uninitialized_is_active() {
    $this->assertNull($this->_class->getIsActive());
  }

  public function test_set_is_active() {
    $str = $this->random_chars();
    $this->assertTrue($this->_class->setIsActive($str));

    return $str;
  }

  public function test_set_get_is_active() {
    $str = $this->test_set_is_active();
    $this->assertEquals($str, $this->_class->getIsActive());
  }
}

