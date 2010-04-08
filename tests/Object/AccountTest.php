<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class AccountTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_account = new QuickBooks_Object_Account();
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
    $this->assertNull($this->_account->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_account->getListID());
  }

  public function test_get_uninitialized_parent_list_id() {
    $this->assertNull($this->_account->getParentListID());
  }

  public function test_set_parent_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setParentListID($str));

    return $str;
  }

  public function test_set_get_parent_list_id() {
    $str = $this->test_set_parent_list_id();
    $this->assertEquals($str, $this->_account->getParentListID());
  }

  public function test_get_uninitialized_parent_name() {
    $this->assertNull($this->_account->getParentName());
  }

  public function test_set_parent_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setParentName($str));

    return $str;
  }

  public function test_set_get_parent_name() {
    $str = $this->test_set_parent_name();
    $this->assertEquals($str, $this->_account->getParentName());
  }

  public function test_get_uninitialized_parent_application_id() {
    $this->assertNull($this->_account->getParentApplicationID());
  }

  public function test_set_parent_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setParentApplicationID($str));

    return $str;
  }

  public function test_set_get_parent_application_id() {
    $str = $this->test_set_parent_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_account->getParentApplicationID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_account->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_account->getName());
  }

  public function test_get_uninitialized_full_name() {
    $this->assertNull($this->_account->getFullName());
  }

  public function test_set_full_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setFullName($str));

    return $str;
  }

  public function test_set_get_full_name() {
    $str = $this->test_set_full_name();
    $this->assertEquals($str, $this->_account->getFullName());
  }

  public function test_get_uninitialized_is_active() {
    $this->assertNull($this->_account->getIsActive());
  }

  public function test_set_is_active() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setIsActive($str));

    return $str;
  }

  public function test_set_get_is_active() {
    $str = $this->test_set_is_active();
    $this->assertEquals($str, $this->_account->getIsActive());
  }

  public function test_get_uninitialized_account_type() {
    $this->assertNull($this->_account->getAccountType());
  }

  public function test_set_account_type() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setAccountType($str));

    return $str;
  }

  public function test_set_get_account_type() {
    $str = $this->test_set_account_type();
    $this->assertEquals($str, $this->_account->getAccountType());
  }

  public function test_get_uninitialized_account_number() {
    $this->assertNull($this->_account->getAccountNumber());
  }

  public function test_set_account_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setAccountNumber($str));

    return $str;
  }

  public function test_set_get_account_number() {
    $str = $this->test_set_account_number();
    $this->assertEquals($str, $this->_account->getAccountNumber());
  }

  public function test_get_uninitialized_bank_number() {
    $this->assertNull($this->_account->getBankNumber());
  }

  public function test_set_bank_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setBankNumber($str));

    return $str;
  }

  public function test_set_get_bank_number() {
    $str = $this->test_set_bank_number();
    $this->assertEquals($str, $this->_account->getBankNumber());
  }

  public function test_get_uninitialized_description() {
    $this->assertNull($this->_account->getDescription());
  }

  public function test_set_description() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setDescription($str));

    return $str;
  }

  public function test_set_get_description() {
    $str = $this->test_set_description();
    $this->assertEquals($str, $this->_account->getDescription());
  }

  public function test_get_uninitialized_open_balance() {
    $this->assertNull($this->_account->getOpenBalance());
  }

  public function test_set_open_balance() {
    $str = $this->random_nums();
    $this->assertTrue($this->_account->setOpenBalance($str));

    return $str;
  }

  public function test_set_get_open_balance() {
    $str = $this->test_set_open_balance();
    $this->assertEquals($str, $this->_account->getOpenBalance());
  }

  public function test_get_uninitialized_open_balance_date() {
    $this->assertNull($this->_account->getOpenBalanceDate());
  }

  public function test_set_open_balance_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setOpenBalanceDate($str));

    return $str;
  }

  public function test_set_get_open_balance_date() {
    $str = $this->test_set_open_balance_date();
    $this->assertEquals('1969-12-31', $this->_account->getOpenBalanceDate());
  }

  public function test_get_uninitialized_tax_line_id() {
    $this->assertNull($this->_account->getTaxLineID());
  }

  public function test_set_tax_line_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setTaxLineID($str));

    return $str;
  }

  public function test_set_get_tax_line_id() {
    $str = $this->test_set_tax_line_id();
    $this->assertEquals($str, $this->_account->getTaxLineID());
  }

  public function test_get_uninitialized_balance() {
    $this->assertNull($this->_account->getBalance());
  }

  public function test_set_balance() {
    $str = $this->random_nums();
    $this->assertTrue($this->_account->setBalance($str));

    return $str;
  }

  public function test_set_get_balance() {
    $str = $this->test_set_balance();
    $this->assertEquals($str, $this->_account->getBalance());
  }

  public function test_get_uninitialized_total_balance() {
    $this->assertNull($this->_account->getTotalBalance());
  }

  public function test_set_total_balance() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setTotalBalance($str));

    return $str;
  }

  public function test_set_get_total_balance() {
    $str = $this->test_set_total_balance();
    $this->assertEquals($str, $this->_account->getTotalBalance());
  }

  public function test_get_uninitialized_special_account_type() {
    $this->assertNull($this->_account->getSpecialAccountType());
  }

  public function test_set_special_account_type() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setSpecialAccountType($str));

    return $str;
  }

  public function test_set_get_special_account_type() {
    $str = $this->test_set_special_account_type();
    $this->assertEquals($str, $this->_account->getSpecialAccountType());
  }

  public function test_get_uninitialized_cash_flow_classification() {
    $this->assertNull($this->_account->getCashFlowClassification());
  }

  public function test_set_cash_flow_classification() {
    $str = $this->random_chars();
    $this->assertTrue($this->_account->setCashFlowClassification($str));

    return $str;
  }

  public function test_set_get_cash_flow_classification() {
    $str = $this->test_set_cash_flow_classification();
    $this->assertEquals($str, $this->_account->getCashFlowClassification());
  }
}

