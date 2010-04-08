<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class ReceivePaymentTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_receivepayment = new QuickBooks_Object_ReceivePayment();
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


  public function test_get_uninitialized_txn_id() {
    $this->assertNull($this->_receivepayment->getTxnID());
  }

  public function test_set_txn_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setTxnID($str));

    return $str;
  }

  public function test_set_get_txn_id() {
    $str = $this->test_set_txn_id();
    $this->assertEquals($str, $this->_receivepayment->getTxnID());
  }

  public function test_get_uninitialized_transaction_id() {
    $this->assertNull($this->_receivepayment->getTransactionID());
  }

  public function test_set_transaction_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setTransactionID($str));

    return $str;
  }

  public function test_set_get_transaction_id() {
    $str = $this->test_set_transaction_id();
    $this->assertEquals($str, $this->_receivepayment->getTransactionID());
  }

  public function test_get_uninitialized_customer_list_id() {
    $this->assertNull($this->_receivepayment->getCustomerListID());
  }

  public function test_set_customer_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setCustomerListID($str));

    return $str;
  }

  public function test_set_get_customer_list_id() {
    $str = $this->test_set_customer_list_id();
    $this->assertEquals($str, $this->_receivepayment->getCustomerListID());
  }

  public function test_get_uninitialized_customer_application_id() {
    $this->assertNull($this->_receivepayment->getCustomerApplicationID());
  }

  public function test_set_customer_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setCustomerApplicationID($str));

    return $str;
  }

  public function test_set_get_customer_application_id() {
    $str = $this->test_set_customer_application_id();
    $this->assertEquals('Customer|ListID|'. $str, $this->_receivepayment->getCustomerApplicationID());
  }

  public function test_get_uninitialized_customer_name() {
    $this->assertNull($this->_receivepayment->getCustomerName());
  }

  public function test_set_customer_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setCustomerName($str));

    return $str;
  }

  public function test_set_get_customer_name() {
    $str = $this->test_set_customer_name();
    $this->assertEquals($str, $this->_receivepayment->getCustomerName());
  }

  public function test_get_uninitialized_txn_date() {
    $this->assertNull($this->_receivepayment->getTxnDate());
  }

  public function test_set_txn_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setTxnDate($str));

    return $str;
  }

  public function test_set_get_txn_date() {
    $str = $this->test_set_txn_date();
    $this->assertEquals('1969-12-31', $this->_receivepayment->getTxnDate());
  }

  public function test_get_uninitialized_transaction_date() {
    $this->assertNull($this->_receivepayment->getTransactionDate());
  }

  public function test_set_transaction_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setTransactionDate($str));

    return $str;
  }

  public function test_set_get_transaction_date() {
    $str = $this->test_set_transaction_date();
    $this->assertEquals('1969-12-31', $this->_receivepayment->getTransactionDate());
  }

  public function test_get_uninitialized_ref_number() {
    $this->assertNull($this->_receivepayment->getRefNumber());
  }

  public function test_set_ref_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setRefNumber($str));

    return $str;
  }

  public function test_set_get_ref_number() {
    $str = $this->test_set_ref_number();
    $this->assertEquals($str, $this->_receivepayment->getRefNumber());
  }

  public function test_get_uninitialized_total_amount() {
    //$this->assertTrue($this->_receivepayment->getTotalAmount());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_total_amount() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setTotalAmount($str));

    return $str;
  }

  public function test_set_get_total_amount() {
    $str = $this->test_set_total_amount();
    //$this->assertEquals(0, $this->_receivepayment->getTotalAmount());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_araccount_list_id() {
    $this->assertNull($this->_receivepayment->getARAccountListID());
  }

  public function test_set_araccount_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setARAccountListID($str));

    return $str;
  }

  public function test_set_get_araccount_list_id() {
    $str = $this->test_set_araccount_list_id();
    $this->assertEquals($str, $this->_receivepayment->getARAccountListID());
  }

  public function test_get_uninitialized_araccount_name() {
    $this->assertNull($this->_receivepayment->getARAccountName());
  }

  public function test_set_araccount_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setARAccountName($str));

    return $str;
  }

  public function test_set_get_araccount_name() {
    $str = $this->test_set_araccount_name();
    $this->assertEquals($str, $this->_receivepayment->getARAccountName());
  }

  public function test_get_uninitialized_araccount_application_id() {
    $this->assertNull($this->_receivepayment->getARAccountApplicationID());
  }

  public function test_set_araccount_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setARAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_araccount_application_id() {
    $str = $this->test_set_araccount_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_receivepayment->getARAccountApplicationID());
  }

  public function test_get_uninitialized_payment_method_list_id() {
    $this->assertNull($this->_receivepayment->getPaymentMethodListID());
  }

  public function test_set_payment_method_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setPaymentMethodListID($str));

    return $str;
  }

  public function test_set_get_payment_method_list_id() {
    $str = $this->test_set_payment_method_list_id();
    $this->assertEquals($str, $this->_receivepayment->getPaymentMethodListID());
  }

  public function test_get_uninitialized_payment_method_name() {
    $this->assertNull($this->_receivepayment->getPaymentMethodName());
  }

  public function test_set_payment_method_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setPaymentMethodName($str));

    return $str;
  }

  public function test_set_get_payment_method_name() {
    $str = $this->test_set_payment_method_name();
    $this->assertEquals($str, $this->_receivepayment->getPaymentMethodName());
  }

  public function test_get_uninitialized_payment_method_application_id() {
    $this->assertNull($this->_receivepayment->getPaymentMethodApplicationID());
  }

  public function test_set_payment_method_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setPaymentMethodApplicationID($str));

    return $str;
  }

  public function test_set_get_payment_method_application_id() {
    $str = $this->test_set_payment_method_application_id();
    $this->assertEquals('PaymentMethod|ListID|'. $str, $this->_receivepayment->getPaymentMethodApplicationID());
  }

  public function test_get_uninitialized_deposit_to_account_list_id() {
    $this->assertNull($this->_receivepayment->getDepositToAccountListID());
  }

  public function test_set_deposit_to_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setDepositToAccountListID($str));

    return $str;
  }

  public function test_set_get_deposit_to_account_list_id() {
    $str = $this->test_set_deposit_to_account_list_id();
    $this->assertEquals($str, $this->_receivepayment->getDepositToAccountListID());
  }

  public function test_get_uninitialized_deposit_to_account_name() {
    $this->assertNull($this->_receivepayment->getDepositToAccountName());
  }

  public function test_set_deposit_to_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setDepositToAccountName($str));

    return $str;
  }

  public function test_set_get_deposit_to_account_name() {
    $str = $this->test_set_deposit_to_account_name();
    $this->assertEquals($str, $this->_receivepayment->getDepositToAccountName());
  }

  public function test_get_uninitialized_deposit_to_account_application_id() {
    $this->assertNull($this->_receivepayment->getDepositToAccountApplicationID());
  }

  public function test_set_deposit_to_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setDepositToAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_deposit_to_account_application_id() {
    $str = $this->test_set_deposit_to_account_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_receivepayment->getDepositToAccountApplicationID());
  }

  public function test_get_uninitialized_memo() {
    $this->assertNull($this->_receivepayment->getMemo());
  }

  public function test_set_memo() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setMemo($str));

    return $str;
  }

  public function test_set_get_memo() {
    $str = $this->test_set_memo();
    $this->assertEquals($str, $this->_receivepayment->getMemo());
  }

  public function test_get_uninitialized_is_auto_apply() {
    //$this->assertNull($this->_receivepayment->getIsAutoApply());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_is_auto_apply() {
    $str = $this->random_chars();
    $this->assertTrue($this->_receivepayment->setIsAutoApply($str));

    return $str;
  }

  public function test_set_get_is_auto_apply() {
    $str = $this->test_set_is_auto_apply();
    $this->assertEquals($str, $this->_receivepayment->getIsAutoApply());
  }
}

