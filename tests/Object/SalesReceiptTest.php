<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class SalesReceiptTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_salesreceipt = new QuickBooks_Object_SalesReceipt();
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


  public function test_get_uninitialized_transaction_id() {
    $this->assertNull($this->_salesreceipt->getTransactionID());
  }

  public function test_set_transaction_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setTransactionID($str));

    return $str;
  }

  public function test_set_get_transaction_id() {
    $str = $this->test_set_transaction_id();
    $this->assertEquals($str, $this->_salesreceipt->getTransactionID());
  }

  public function test_get_uninitialized_txn_id() {
    $this->assertNull($this->_salesreceipt->getTxnID());
  }

  public function test_set_txn_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setTxnID($str));

    return $str;
  }

  public function test_set_get_txn_id() {
    $str = $this->test_set_txn_id();
    $this->assertEquals($str, $this->_salesreceipt->getTxnID());
  }

  public function test_get_uninitialized_customer_list_id() {
    $this->assertNull($this->_salesreceipt->getCustomerListID());
  }

  public function test_set_customer_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setCustomerListID($str));

    return $str;
  }

  public function test_set_get_customer_list_id() {
    $str = $this->test_set_customer_list_id();
    $this->assertEquals($str, $this->_salesreceipt->getCustomerListID());
  }

  public function test_get_uninitialized_customer_application_id() {
    //$this->assertNull($this->_salesreceipt->getCustomerApplicationID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_customer_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setCustomerApplicationID($str));

    return $str;
  }

  public function test_set_get_customer_application_id() {
    $str = $this->test_set_customer_application_id();
    $this->assertEquals($str, $this->_salesreceipt->getCustomerApplicationID());
  }

  public function test_get_uninitialized_customer_name() {
    $this->assertNull($this->_salesreceipt->getCustomerName());
  }

  public function test_set_customer_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setCustomerName($str));

    return $str;
  }

  public function test_set_get_customer_name() {
    $str = $this->test_set_customer_name();
    $this->assertEquals($str, $this->_salesreceipt->getCustomerName());
  }

  public function test_get_uninitialized_class_list_id() {
    $this->assertNull($this->_salesreceipt->getClassListID());
  }

  public function test_set_class_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setClassListID($str));

    return $str;
  }

  public function test_set_get_class_list_id() {
    $str = $this->test_set_class_list_id();
    $this->assertEquals($str, $this->_salesreceipt->getClassListID());
  }

  public function test_get_uninitialized_class_application_id() {
    $this->assertNull($this->_salesreceipt->getClassApplicationID());
  }

  public function test_set_class_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setClassApplicationID($str));

    return $str;
  }

  public function test_set_get_class_application_id() {
    $str = $this->test_set_class_application_id();
    $this->assertEquals('Class|ListID|'. $str, $this->_salesreceipt->getClassApplicationID());
  }

  public function test_get_uninitialized_ship_method_application_id() {
    //$this->assertNull($this->_salesreceipt->getShipMethodApplicationID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_ship_method_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setShipMethodApplicationID($str));

    return $str;
  }

  public function test_set_get_ship_method_application_id() {
    $str = $this->test_set_ship_method_application_id();
    $this->assertEquals($str, $this->_salesreceipt->getShipMethodApplicationID());
  }

  public function test_get_uninitialized_ship_method_name() {
    $this->assertNull($this->_salesreceipt->getShipMethodName());
  }

  public function test_set_ship_method_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setShipMethodName($str));

    return $str;
  }

  public function test_set_get_ship_method_name() {
    $str = $this->test_set_ship_method_name();
    $this->assertEquals($str, $this->_salesreceipt->getShipMethodName());
  }

  public function test_get_uninitialized_ship_method_list_id() {
    $this->assertNull($this->_salesreceipt->getShipMethodListID());
  }

  public function test_set_ship_method_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setShipMethodListID($str));

    return $str;
  }

  public function test_set_get_ship_method_list_id() {
    $str = $this->test_set_ship_method_list_id();
    $this->assertEquals($str, $this->_salesreceipt->getShipMethodListID());
  }

  public function test_get_uninitialized_is_pending() {
    //$this->assertNull($this->_salesreceipt->getIsPending());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_is_pending() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setIsPending('FALSE'));

    return $str;
  }

  public function test_set_get_is_pending() {
    //$str = $this->test_set_is_pending();
    //$this->assertEquals($str, $this->_salesreceipt->getIsPending());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_check_number() {
    $this->assertNull($this->_salesreceipt->getCheckNumber());
  }

  public function test_set_check_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setCheckNumber($str));

    return $str;
  }

  public function test_set_get_check_number() {
    $str = $this->test_set_check_number();
    $this->assertEquals($str, $this->_salesreceipt->getCheckNumber());
  }

  public function test_get_uninitialized_payment_method_application_id() {
    $this->assertNull($this->_salesreceipt->getPaymentMethodApplicationID());
  }

  public function test_set_payment_method_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setPaymentMethodApplicationID($str));

    return $str;
  }

  public function test_set_get_payment_method_application_id() {
    $str = $this->test_set_payment_method_application_id();
    $this->assertEquals('PaymentMethod|ListID|'. $str, $this->_salesreceipt->getPaymentMethodApplicationID());
  }

  public function test_get_uninitialized_payment_method_list_id() {
    $this->assertNull($this->_salesreceipt->getPaymentMethodListID());
  }

  public function test_set_payment_method_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setPaymentMethodListID($str));

    return $str;
  }

  public function test_set_get_payment_method_list_id() {
    $str = $this->test_set_payment_method_list_id();
    $this->assertEquals($str, $this->_salesreceipt->getPaymentMethodListID());
  }

  public function test_get_uninitialized_payment_method_name() {
    $this->assertNull($this->_salesreceipt->getPaymentMethodName());
  }

  public function test_set_payment_method_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setPaymentMethodName($str));

    return $str;
  }

  public function test_set_get_payment_method_name() {
    $str = $this->test_set_payment_method_name();
    $this->assertEquals($str, $this->_salesreceipt->getPaymentMethodName());
  }

  public function test_get_uninitialized_due_date() {
    $this->assertNull($this->_salesreceipt->getDueDate());
  }

  public function test_set_due_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setDueDate($str));

    return $str;
  }

  public function test_set_get_due_date() {
    $str = $this->test_set_due_date();
    $this->assertEquals('1969-12-31', $this->_salesreceipt->getDueDate());
  }

  public function test_get_uninitialized_sales_rep_application_id() {
    $this->assertNull($this->_salesreceipt->getSalesRepApplicationID());
  }

  public function test_set_sales_rep_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setSalesRepApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_rep_application_id() {
    $str = $this->test_set_sales_rep_application_id();
    $this->assertEquals('SalesRep|ListID|'. $str, $this->_salesreceipt->getSalesRepApplicationID());
  }

  public function test_get_uninitialized_sales_rep_list_id() {
    $this->assertNull($this->_salesreceipt->getSalesRepListID());
  }

  public function test_set_sales_rep_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setSalesRepListID($str));

    return $str;
  }

  public function test_set_get_sales_rep_list_id() {
    $str = $this->test_set_sales_rep_list_id();
    $this->assertEquals($str, $this->_salesreceipt->getSalesRepListID());
  }

  public function test_get_uninitialized_sales_rep_name() {
    $this->assertNull($this->_salesreceipt->getSalesRepName());
  }

  public function test_set_sales_rep_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setSalesRepName($str));

    return $str;
  }

  public function test_set_get_sales_rep_name() {
    $str = $this->test_set_sales_rep_name();
    $this->assertEquals($str, $this->_salesreceipt->getSalesRepName());
  }

  public function test_get_uninitialized_is_to_be_printed() {
    $this->assertFalse($this->_salesreceipt->getIsToBePrinted());
  }

  public function test_set_is_to_be_printed() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setIsToBePrinted(TRUE));

    return $str;
  }

  public function test_set_get_is_to_be_printed() {
    $str = $this->test_set_is_to_be_printed();
    $this->assertEquals(TRUE, $this->_salesreceipt->getIsToBePrinted());
  }

  public function test_get_uninitialized_is_to_be_emailed() {
    $this->assertFalse($this->_salesreceipt->getIsToBeEmailed());
  }

  public function test_set_is_to_be_emailed() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setIsToBeEmailed(TRUE));

    return $str;
  }

  public function test_set_get_is_to_be_emailed() {
    $str = $this->test_set_is_to_be_emailed();
    $this->assertEquals(TRUE, $this->_salesreceipt->getIsToBeEmailed());
  }

  public function test_get_uninitialized_deposit_to_account_application_id() {
    $this->assertFalse($this->_salesreceipt->getDepositToAccountApplicationID());
  }

  public function test_set_deposit_to_account_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setDepositToAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_deposit_to_account_application_id() {
    $str = $this->test_set_deposit_to_account_application_id();
    $this->assertEquals($str, $this->_salesreceipt->getDepositToAccountApplicationID());
  }

  public function test_get_uninitialized_deposit_to_account_list_id() {
    $this->assertNull($this->_salesreceipt->getDepositToAccountListID());
  }

  public function test_set_deposit_to_account_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setDepositToAccountListID($str));

    return $str;
  }

  public function test_set_get_deposit_to_account_list_id() {
    $str = $this->test_set_deposit_to_account_list_id();
    $this->assertEquals($str, $this->_salesreceipt->getDepositToAccountListID());
  }

  public function test_get_uninitialized_deposit_to_account_name() {
    $this->assertNull($this->_salesreceipt->getDepositToAccountName());
  }

  public function test_set_deposit_to_account_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setDepositToAccountName($str));

    return $str;
  }

  public function test_set_get_deposit_to_account_name() {
    $str = $this->test_set_deposit_to_account_name();
    $this->assertEquals($str, $this->_salesreceipt->getDepositToAccountName());
  }

  public function test_get_uninitialized_txn_date() {
    $this->assertNull($this->_salesreceipt->getTxnDate());
  }

  public function test_set_txn_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setTxnDate($str));

    return $str;
  }

  public function test_set_get_txn_date() {
    $str = $this->test_set_txn_date();
    $this->assertEquals('1969-12-31', $this->_salesreceipt->getTxnDate());
  }

  public function test_get_uninitialized_transaction_date() {
    $this->assertNull($this->_salesreceipt->getTransactionDate());
  }

  public function test_set_transaction_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setTransactionDate($str));

    return $str;
  }

  public function test_set_get_transaction_date() {
    $str = $this->test_set_transaction_date();
    $this->assertEquals('1969-12-31', $this->_salesreceipt->getTransactionDate());
  }

  public function test_get_uninitialized_ship_date() {
    $this->assertNull($this->_salesreceipt->getShipDate());
  }

  public function test_set_ship_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setShipDate($str));

    return $str;
  }

  public function test_set_get_ship_date() {
    $str = $this->test_set_ship_date();
    $this->assertEquals('1969-12-31', $this->_salesreceipt->getShipDate());
  }

  public function test_get_uninitialized_ref_number() {
    $this->assertNull($this->_salesreceipt->getRefNumber());
  }

  public function test_set_ref_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setRefNumber($str));

    return $str;
  }

  public function test_set_get_ref_number() {
    $str = $this->test_set_ref_number();
    $this->assertEquals($str, $this->_salesreceipt->getRefNumber());
  }

  public function test_get_uninitialized_memo() {
    $this->assertNull($this->_salesreceipt->getMemo());
  }

  public function test_set_memo() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setMemo($str));

    return $str;
  }

  public function test_set_get_memo() {
    $str = $this->test_set_memo();
    $this->assertEquals($str, $this->_salesreceipt->getMemo());
  }

  public function test_get_uninitialized_fob() {
    $this->assertNull($this->_salesreceipt->getFOB());
  }

  public function test_set_fob() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setFOB($str));

    return $str;
  }

  public function test_set_get_fob() {
    $str = $this->test_set_fob();
    $this->assertEquals($str, $this->_salesreceipt->getFOB());
  }

  public function test_get_uninitialized_link_to_txn_id() {
    $this->assertNull($this->_salesreceipt->getLinkToTxnID());
  }

  public function test_set_link_to_txn_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setLinkToTxnID($str));

    return $str;
  }

  public function test_set_get_link_to_txn_id() {
    $str = $this->test_set_link_to_txn_id();
    $this->assertEquals($str, $this->_salesreceipt->getLinkToTxnID());
  }

  public function test_get_uninitialized_ship_address() {
    $this->assertEquals(array(), $this->_salesreceipt->getShipAddress());
  }

  public function test_set_ship_address() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_salesreceipt->setShipAddress($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_ship_address() {
    //$str = $this->test_set_ship_address();
    //$this->assertEquals(array(), $this->_salesreceipt->getShipAddress());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_bill_address() {
    $this->assertEquals(array(), $this->_salesreceipt->getBillAddress());
  }

  public function test_set_bill_address() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_salesreceipt->setBillAddress($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_bill_address() {
    //$str = $this->test_set_bill_address();
    //$this->assertEquals($str, $this->_salesreceipt->getBillAddress());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_other() {
    $this->assertNull($this->_salesreceipt->getOther());
  }

  public function test_set_other() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesreceipt->setOther($str));

    return $str;
  }

  public function test_set_get_other() {
    $str = $this->test_set_other();
    $this->assertEquals($str, $this->_salesreceipt->getOther());
  }
}

