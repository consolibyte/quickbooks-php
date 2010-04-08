<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class JournalEntryTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_journalentry = new QuickBooks_Object_JournalEntry();
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


  public function test_get_uninitialized_txn_date() {
    $this->assertNull($this->_journalentry->getTxnDate());
  }

  public function test_set_txn_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_journalentry->setTxnDate($str));

    return $str;
  }

  public function test_set_get_txn_date() {
    $str = $this->test_set_txn_date();
    $this->assertEquals('1969-12-31', $this->_journalentry->getTxnDate());
  }

  public function test_get_uninitialized_transaction_date() {
    $this->assertNull($this->_journalentry->getTransactionDate());
  }

  public function test_set_transaction_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_journalentry->setTransactionDate($str));

    return $str;
  }

  public function test_set_get_transaction_date() {
    $str = $this->test_set_transaction_date();
    //$this->assertEquals($str, $this->_journalentry->getTransactionDate());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_ref_number() {
    $this->assertNull($this->_journalentry->getRefNumber());
  }

  public function test_set_ref_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_journalentry->setRefNumber($str));

    return $str;
  }

  public function test_set_get_ref_number() {
    $str = $this->test_set_ref_number();
    $this->assertEquals($str, $this->_journalentry->getRefNumber());
  }

  public function test_get_uninitialized_memo() {
    $this->assertNull($this->_journalentry->getMemo());
  }

  public function test_set_memo() {
    $str = $this->random_chars();
    $this->assertTrue($this->_journalentry->setMemo($str));

    return $str;
  }

  public function test_set_get_memo() {
    $str = $this->test_set_memo();
    $this->assertEquals($str, $this->_journalentry->getMemo());
  }

  public function test_get_uninitialized_is_adjustment() {
    //$this->assertNull($this->_journalentry->getIsAdjustment());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_is_adjustment() {
    $str = $this->random_chars();
    $this->assertTrue($this->_journalentry->setIsAdjustment($str));

    return $str;
  }

  public function test_set_get_is_adjustment() {
    $str = $this->test_set_is_adjustment();
    //$this->assertEquals($str, $this->_journalentry->getIsAdjustment());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }
}

