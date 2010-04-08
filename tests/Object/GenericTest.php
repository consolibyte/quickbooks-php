<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class GenericTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_generic = new QuickBooks_Object_Generic();
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


  public function test_get_uninitialized_override() {
    $this->assertEquals('', $this->_generic->getOverride());
  }

  public function test_set_override() {
    $str = $this->random_chars();
    $this->assertTrue($this->_generic->setOverride($str));

    return $str;
  }

  public function test_set_get_override() {
    $str = $this->test_set_override();
    $this->assertEquals($str, $this->_generic->getOverride());
  }
}

