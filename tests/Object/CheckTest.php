<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class CheckTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_check = new QuickBooks_Object_Check();
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


  public function test_get_uninitialized_account_list_id() {
    $this->assertNull($this->_check->getAccountListID());
  }

  public function test_set_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setAccountListID($str));

    return $str;
  }

  public function test_set_get_account_list_id() {
    $str = $this->test_set_account_list_id();
    $this->assertEquals($str, $this->_check->getAccountListID());
  }

  public function test_get_uninitialized_account_application_id() {
    $this->assertNull($this->_check->getAccountApplicationID());
  }

  public function test_set_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_account_application_id() {
    $str = $this->test_set_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_check->getAccountApplicationID());
  }

  public function test_get_uninitialized_account_name() {
    $this->assertNull($this->_check->getAccountName());
  }

  public function test_set_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setAccountName($str));

    return $str;
  }

  public function test_set_get_account_name() {
    $str = $this->test_set_account_name();
    $this->assertEquals($str, $this->_check->getAccountName());
  }

  public function test_get_uninitialized_payee_entity_list_id() {
    $this->assertNull($this->_check->getPayeeEntityListID());
  }

  public function test_set_payee_entity_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setPayeeEntityListID($str));

    return $str;
  }

  public function test_set_get_payee_entity_list_id() {
    $str = $this->test_set_payee_entity_list_id();
    $this->assertEquals($str, $this->_check->getPayeeEntityListID());
  }

  public function test_get_uninitialized_payee_entity_application_id() {
    $this->assertNull($this->_check->getPayeeEntityApplicationID());
  }

  public function test_set_payee_entity_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setPayeeEntityApplicationID($str));

    return $str;
  }

  public function test_set_get_payee_entity_application_id() {
    $str = $this->test_set_payee_entity_application_id();
    $this->assertEquals('QUICKBOOKS_OBJECT_PAYEEENTITY|ListID|'. $str, $this->_check->getPayeeEntityApplicationID());
  }

  public function test_get_uninitialized_payee_entity_name() {
    $this->assertNull($this->_check->getPayeeEntityName());
  }

  public function test_set_payee_entity_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setPayeeEntityName($str));

    return $str;
  }

  public function test_set_get_payee_entity_name() {
    $str = $this->test_set_payee_entity_name();
    $this->assertEquals($str, $this->_check->getPayeeEntityName());
  }

  public function test_get_uninitialized_ref_number() {
    $this->assertNull($this->_check->getRefNumber());
  }

  public function test_set_ref_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setRefNumber($str));

    return $str;
  }

  public function test_set_get_ref_number() {
    $str = $this->test_set_ref_number();
    $this->assertEquals($str, $this->_check->getRefNumber());
  }

  public function test_get_uninitialized_txn_date() {
    $this->assertNull($this->_check->getTxnDate());
  }

  public function test_set_txn_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setTxnDate($str));

    return $str;
  }

  public function test_set_get_txn_date() {
    $str = $this->test_set_txn_date();
    $this->assertEquals('1969-12-31', $this->_check->getTxnDate());
  }

  public function test_get_uninitialized_transaction_date() {
    $this->assertNull($this->_check->getTransactionDate());
  }

  public function test_set_transaction_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setTransactionDate($str));

    return $str;
  }

  public function test_set_get_transaction_date() {
    $str = $this->test_set_transaction_date();
    $this->assertEquals('1969-12-31', $this->_check->getTransactionDate());
  }

  public function test_get_uninitialized_memo() {
    $this->assertNull($this->_check->getMemo());
  }

  public function test_set_memo() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setMemo($str));

    return $str;
  }

  public function test_set_get_memo() {
    $str = $this->test_set_memo();
    $this->assertEquals($str, $this->_check->getMemo());
  }

  public function test_get_uninitialized_is_to_be_printed() {
    $this->assertFalse($this->_check->getIsToBePrinted());
  }

  public function test_set_is_to_be_printed() {
    $str = FALSE;
    $this->assertTrue($this->_check->setIsToBePrinted($str));

    return $str;
  }

  public function test_set_get_is_to_be_printed() {
    $str = $this->test_set_is_to_be_printed();
    $this->assertFalse($this->_check->getIsToBePrinted());
  }

  public function test_get_uninitialized_is_tax_included() {
    $this->assertFalse($this->_check->getIsTaxIncluded());
  }

  public function test_set_is_tax_included() {
    $str = FALSE;
    $this->assertTrue($this->_check->setIsTaxIncluded($str));

    return $str;
  }

  public function test_set_get_is_tax_included() {
    $str = $this->test_set_is_tax_included();
    $this->assertFalse($this->_check->getIsTaxIncluded());
  }

  public function test_get_uninitialized_sales_tax_code_list_id() {
    $this->assertNull($this->_check->getSalesTaxCodeListID());
  }

  public function test_set_sales_tax_code_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setSalesTaxCodeListID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_list_id() {
    $str = $this->test_set_sales_tax_code_list_id();
    $this->assertEquals($str, $this->_check->getSalesTaxCodeListID());
  }

  public function test_get_uninitialized_sales_tax_code_application_id() {
    $this->assertNull($this->_check->getSalesTaxCodeApplicationID());
  }

  public function test_set_sales_tax_code_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setSalesTaxCodeApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_application_id() {
    $str = $this->test_set_sales_tax_code_application_id();
    $this->assertEquals('SalesTaxCode|ListID|'. $str, $this->_check->getSalesTaxCodeApplicationID());
  }

  public function test_get_uninitialized_sales_tax_code_name() {
    $this->assertNull($this->_check->getSalesTaxCodeName());
  }

  public function test_set_sales_tax_code_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_check->setSalesTaxCodeName($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_name() {
    $str = $this->test_set_sales_tax_code_name();
    $this->assertEquals($str, $this->_check->getSalesTaxCodeName());
  }
}

