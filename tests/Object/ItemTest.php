<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class ItemTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_item = new QuickBooks_Object_Item();
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
    $this->assertNull($this->_item->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_item->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_item->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_item->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_item->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_item->getName());
  }

  public function test_get_uninitialized_full_name() {
    $this->assertNull($this->_item->getFullName());
  }

  public function test_set_full_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_item->setFullName($str));

    return $str;
  }

  public function test_set_get_full_name() {
    $str = $this->test_set_full_name();
    $this->assertEquals($str, $this->_item->getFullName());
  }

  public function test_get_uninitialized_from_modified_date() {
    //$this->assertNull($this->_item->getFromModifiedDate());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_from_modified_date() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_item->setFromModifiedDate($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_from_modified_date() {
    $str = $this->test_set_from_modified_date();
    //$this->assertEquals($str, $this->_item->getFromModifiedDate());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_to_modified_date() {
    //$this->assertNull($this->_item->getToModifiedDate());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_to_modified_date() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_item->setToModifiedDate($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_to_modified_date() {
    //$str = $this->test_set_to_modified_date();
    //$this->assertEquals($str, $this->_item->getToModifiedDate());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }
}

