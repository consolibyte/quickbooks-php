<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class StandardTermsTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_standardterms = new QuickBooks_Object_StandardTerms();
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
    $this->assertNull($this->_standardterms->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_standardterms->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_standardterms->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_standardterms->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_standardterms->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_standardterms->getName());
  }

  public function test_get_uninitialized_is_active() {
    $this->assertNull($this->_standardterms->getIsActive());
  }

  public function test_set_is_active() {
    $str = $this->random_chars();
    $this->assertTrue($this->_standardterms->setIsActive($str));

    return $str;
  }

  public function test_set_get_is_active() {
    $str = $this->test_set_is_active();
    $this->assertEquals($str, $this->_standardterms->getIsActive());
  }

  public function test_get_uninitialized_std_due_days() {
    $this->assertNull($this->_standardterms->getStdDueDays());
  }

  public function test_set_std_due_days() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_standardterms->setStdDueDays($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_std_due_days() {
    //$str = $this->test_set_std_due_days();
    //$this->assertEquals($str, $this->_standardterms->getStdDueDays());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_standard_due_days() {
    $this->assertNull($this->_standardterms->getStandardDueDays());
  }

  public function test_set_standard_due_days() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_standardterms->setStandardDueDays($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_standard_due_days() {
    //$str = $this->test_set_standard_due_days();
    //$this->assertEquals($str, $this->_standardterms->getStandardDueDays());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_std_discount_days() {
    $this->assertNull($this->_standardterms->getStdDiscountDays());
  }

  public function test_set_std_discount_days() {
    $str = $this->random_nums();
    $this->assertTrue($this->_standardterms->setStdDiscountDays($str));

    return $str;
  }

  public function test_set_get_std_discount_days() {
    $str = $this->test_set_std_discount_days();
    $this->assertEquals($str, $this->_standardterms->getStdDiscountDays());
  }

  public function test_get_uninitialized_standard_discount_days() {
    $this->assertNull($this->_standardterms->getStandardDiscountDays());
  }

  public function test_set_standard_discount_days() {
    $str = $this->random_nums();
    $this->assertTrue($this->_standardterms->setStandardDiscountDays($str));

    return $str;
  }

  public function test_set_get_standard_discount_days() {
    $str = $this->test_set_standard_discount_days();
    $this->assertEquals($str, $this->_standardterms->getStandardDiscountDays());
  }

  public function test_get_uninitialized_discount_pct() {
    $this->assertNull($this->_standardterms->getDiscountPct());
  }

  public function test_set_discount_pct() {
    $str = $this->random_nums();
    $this->assertTrue($this->_standardterms->setDiscountPct(0));

    return $str;
  }

  public function test_set_get_discount_pct() {
    $str = $this->test_set_discount_pct();
    $this->assertEquals(0, $this->_standardterms->getDiscountPct());
  }

  public function test_get_uninitialized_discount_percent() {
    $this->assertNull($this->_standardterms->getDiscountPercent());
  }

  public function test_set_discount_percent() {
    $str = $this->random_nums(2);
    $this->assertTrue($this->_standardterms->setDiscountPercent($str));
    return $str;
  }

  public function test_set_get_discount_percent() {
    $str = $this->test_set_discount_percent();
    $this->assertEquals($str, $this->_standardterms->getDiscountPercent());
  }
}
