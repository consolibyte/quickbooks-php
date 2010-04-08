<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class EstimateTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_estimate = new QuickBooks_Object_Estimate();
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
    $this->assertNull($this->_estimate->getTransactionID());
  }

  public function test_set_transaction_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTransactionID($str));

    return $str;
  }

  public function test_set_get_transaction_id() {
    $str = $this->test_set_transaction_id();
    $this->assertEquals($str, $this->_estimate->getTransactionID());
  }

  public function test_get_uninitialized_txn_id() {
    $this->assertNull($this->_estimate->getTxnID());
  }

  public function test_set_txn_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTxnID($str));

    return $str;
  }

  public function test_set_get_txn_id() {
    $str = $this->test_set_txn_id();
    $this->assertEquals($str, $this->_estimate->getTxnID());
  }

  public function test_get_uninitialized_customer_list_id() {
    $this->assertNull($this->_estimate->getCustomerListID());
  }

  public function test_set_customer_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setCustomerListID($str));

    return $str;
  }

  public function test_set_get_customer_list_id() {
    $str = $this->test_set_customer_list_id();
    $this->assertEquals($str, $this->_estimate->getCustomerListID());
  }

  public function test_get_uninitialized_customer_application_id() {
    $this->assertFalse($this->_estimate->getCustomerApplicationID());
  }

  public function test_set_customer_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setCustomerApplicationID($str));

    return $str;
  }

  public function test_set_get_customer_application_id() {
    $str = $this->test_set_customer_application_id();
    $this->assertEquals($str, $this->_estimate->getCustomerApplicationID());
  }

  public function test_get_uninitialized_customer_name() {
    $this->assertNull($this->_estimate->getCustomerName());
  }

  public function test_set_customer_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setCustomerName($str));

    return $str;
  }

  public function test_set_get_customer_name() {
    $str = $this->test_set_customer_name();
    $this->assertEquals($str, $this->_estimate->getCustomerName());
  }

  public function test_get_uninitialized_class_list_id() {
    $this->assertNull($this->_estimate->getClassListID());
  }

  public function test_set_class_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setClassListID($str));

    return $str;
  }

  public function test_set_get_class_list_id() {
    $str = $this->test_set_class_list_id();
    $this->assertEquals($str, $this->_estimate->getClassListID());
  }

  public function test_get_uninitialized_class_application_id() {
    $this->assertNull($this->_estimate->getClassApplicationID());
  }

  public function test_set_class_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setClassApplicationID($str));

    return $str;
  }

  public function test_set_get_class_application_id() {
    $str = $this->test_set_class_application_id();
    $this->assertEquals('Class|ListID|'. $str, $this->_estimate->getClassApplicationID());
  }

  public function test_get_uninitialized_class_name() {
    $this->assertNull($this->_estimate->getClassName());
  }

  public function test_set_class_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setClassName($str));

    return $str;
  }

  public function test_set_get_class_name() {
    $str = $this->test_set_class_name();
    $this->assertEquals($str, $this->_estimate->getClassName());
  }

  public function test_get_uninitialized_template_application_id() {
    $this->assertNull($this->_estimate->getTemplateApplicationID());
  }

  public function test_set_template_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTemplateApplicationID($str));

    return $str;
  }

  public function test_set_get_template_application_id() {
    $str = $this->test_set_template_application_id();
    $this->assertEquals('Template|ListID|'. $str, $this->_estimate->getTemplateApplicationID());
  }

  public function test_get_uninitialized_template_name() {
    $this->assertNull($this->_estimate->getTemplateName());
  }

  public function test_set_template_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTemplateName($str));

    return $str;
  }

  public function test_set_get_template_name() {
    $str = $this->test_set_template_name();
    $this->assertEquals($str, $this->_estimate->getTemplateName());
  }

  public function test_get_uninitialized_template_list_id() {
    $this->assertNull($this->_estimate->getTemplateListID());
  }

  public function test_set_template_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTemplateListID($str));

    return $str;
  }

  public function test_set_get_template_list_id() {
    $str = $this->test_set_template_list_id();
    $this->assertEquals($str, $this->_estimate->getTemplateListID());
  }

  public function test_get_uninitialized_txn_date() {
    $this->assertNull($this->_estimate->getTxnDate());
  }

  public function test_set_txn_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTxnDate($str));

    return $str;
  }

  public function test_set_get_txn_date() {
    $str = $this->test_set_txn_date();
    $this->assertEquals('1969-12-31', $this->_estimate->getTxnDate());
  }

  public function test_get_uninitialized_transaction_date() {
    $this->assertNull($this->_estimate->getTransactionDate());
  }

  public function test_set_transaction_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTransactionDate($str));

    return $str;
  }

  public function test_set_get_transaction_date() {
    $str = $this->test_set_transaction_date();
    $this->assertEquals('1969-12-31', $this->_estimate->getTransactionDate());
  }

  public function test_get_uninitialized_ref_number() {
    $this->assertNull($this->_estimate->getRefNumber());
  }

  public function test_set_ref_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setRefNumber($str));

    return $str;
  }

  public function test_set_get_ref_number() {
    $str = $this->test_set_ref_number();
    $this->assertEquals($str, $this->_estimate->getRefNumber());
  }

  public function test_get_uninitialized_ship_address() {
    $this->assertEquals(array(), $this->_estimate->getShipAddress());
  }

  public function test_set_ship_address() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_estimate->setShipAddress($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_ship_address() {
    $str = $this->test_set_ship_address();
    $this->assertEquals($str, $this->_estimate->getShipAddress());
  }

  public function test_get_uninitialized_bill_address() {
    $this->assertEquals(array(), $this->_estimate->getBillAddress());
  }

  public function test_set_bill_address() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_estimate->setBillAddress($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_bill_address() {
    $str = $this->test_set_bill_address();
    $this->assertEquals($str, $this->_estimate->getBillAddress());
  }

  public function test_get_uninitialized_ponumber() {
    $this->assertNull($this->_estimate->getPONumber());
  }

  public function test_set_ponumber() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setPONumber($str));

    return $str;
  }

  public function test_set_get_ponumber() {
    $str = $this->test_set_ponumber();
    $this->assertEquals($str, $this->_estimate->getPONumber());
  }

  public function test_get_uninitialized_terms_list_id() {
    $this->assertNull($this->_estimate->getTermsListID());
  }

  public function test_set_terms_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTermsListID($str));

    return $str;
  }

  public function test_set_get_terms_list_id() {
    $str = $this->test_set_terms_list_id();
    $this->assertEquals($str, $this->_estimate->getTermsListID());
  }

  public function test_get_uninitialized_terms_application_id() {
    $this->assertNull($this->_estimate->getTermsApplicationID());
  }

  public function test_set_terms_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTermsApplicationID($str));

    return $str;
  }

  public function test_set_get_terms_application_id() {
    $str = $this->test_set_terms_application_id();
    $this->assertEquals('Terms|ListID|'. $str, $this->_estimate->getTermsApplicationID());
  }

  public function test_get_uninitialized_terms_name() {
    $this->assertNull($this->_estimate->getTermsName());
  }

  public function test_set_terms_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setTermsName($str));

    return $str;
  }

  public function test_set_get_terms_name() {
    $str = $this->test_set_terms_name();
    $this->assertEquals($str, $this->_estimate->getTermsName());
  }

  public function test_get_uninitialized_due_date() {
    $this->assertNull($this->_estimate->getDueDate());
  }

  public function test_set_due_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setDueDate($str));

    return $str;
  }

  public function test_set_get_due_date() {
    $str = $this->test_set_due_date();
    $this->assertEquals('1969-12-31', $this->_estimate->getDueDate());
  }

  public function test_get_uninitialized_sales_rep_name() {
    $this->assertNull($this->_estimate->getSalesRepName());
  }

  public function test_set_sales_rep_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setSalesRepName($str));

    return $str;
  }

  public function test_set_get_sales_rep_name() {
    $str = $this->test_set_sales_rep_name();
    $this->assertEquals($str, $this->_estimate->getSalesRepName());
  }

  public function test_get_uninitialized_sales_rep_list_id() {
    $this->assertNull($this->_estimate->getSalesRepListID());
  }

  public function test_set_sales_rep_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setSalesRepListID($str));

    return $str;
  }

  public function test_set_get_sales_rep_list_id() {
    $str = $this->test_set_sales_rep_list_id();
    $this->assertEquals($str, $this->_estimate->getSalesRepListID());
  }

  public function test_get_uninitialized_sales_rep_application_id() {
    $this->assertNull($this->_estimate->getSalesRepApplicationID());
  }

  public function test_set_sales_rep_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setSalesRepApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_rep_application_id() {
    $str = $this->test_set_sales_rep_application_id();
    $this->assertEquals('SalesRep|ListID|'. $str, $this->_estimate->getSalesRepApplicationID());
  }

  public function test_get_uninitialized_fob() {
    $this->assertNull($this->_estimate->getFOB());
  }

  public function test_set_fob() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setFOB($str));

    return $str;
  }

  public function test_set_get_fob() {
    $str = $this->test_set_fob();
    $this->assertEquals($str, $this->_estimate->getFOB());
  }

  public function test_get_uninitialized_sales_tax_item_list_id() {
    $this->assertNull($this->_estimate->getSalesTaxItemListID());
  }

  public function test_set_sales_tax_item_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setSalesTaxItemListID($str));

    return $str;
  }

  public function test_set_get_sales_tax_item_list_id() {
    $str = $this->test_set_sales_tax_item_list_id();
    $this->assertEquals($str, $this->_estimate->getSalesTaxItemListID());
  }

  public function test_get_uninitialized_sales_tax_item_application_id() {
    $this->assertNull($this->_estimate->getSalesTaxItemApplicationID());
  }

  public function test_set_sales_tax_item_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setSalesTaxItemApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_tax_item_application_id() {
    $str = $this->test_set_sales_tax_item_application_id();
    $this->assertEquals('ItemSalesTax|ListID|'. $str, $this->_estimate->getSalesTaxItemApplicationID());
  }

  public function test_get_uninitialized_sales_tax_item_name() {
    $this->assertNull($this->_estimate->getSalesTaxItemName());
  }

  public function test_set_sales_tax_item_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setSalesTaxItemName($str));

    return $str;
  }

  public function test_set_get_sales_tax_item_name() {
    $str = $this->test_set_sales_tax_item_name();
    $this->assertEquals($str, $this->_estimate->getSalesTaxItemName());
  }

  public function test_get_uninitialized_memo() {
    $this->assertNull($this->_estimate->getMemo());
  }

  public function test_set_memo() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setMemo($str));

    return $str;
  }

  public function test_set_get_memo() {
    $str = $this->test_set_memo();
    $this->assertEquals($str, $this->_estimate->getMemo());
  }

  public function test_get_uninitialized_is_to_be_emailed() {
    //$this->assertNull($this->_estimate->getIsToBeEmailed());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_is_to_be_emailed() {
    $str = TRUE;
    $this->assertTrue($this->_estimate->setIsToBeEmailed($str));

    return $str;
  }

  public function test_set_get_is_to_be_emailed() {
    $str = $this->test_set_is_to_be_emailed();
    $this->assertTrue($this->_estimate->getIsToBeEmailed());

  }

  public function test_get_uninitialized_customer_sales_tax_code_list_id() {
    $this->assertNull($this->_estimate->getCustomerSalesTaxCodeListID());
  }

  public function test_set_customer_sales_tax_code_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setCustomerSalesTaxCodeListID($str));

    return $str;
  }

  public function test_set_get_customer_sales_tax_code_list_id() {
    $str = $this->test_set_customer_sales_tax_code_list_id();
    $this->assertEquals($str, $this->_estimate->getCustomerSalesTaxCodeListID());
  }

  public function test_get_uninitialized_customer_sales_tax_code_name() {
    $this->assertNull($this->_estimate->getCustomerSalesTaxCodeName());
  }

  public function test_set_customer_sales_tax_code_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setCustomerSalesTaxCodeName($str));

    return $str;
  }

  public function test_set_get_customer_sales_tax_code_name() {
    $str = $this->test_set_customer_sales_tax_code_name();
    $this->assertEquals($str, $this->_estimate->getCustomerSalesTaxCodeName());
  }

  public function test_get_uninitialized_estimate_line() {
    $this->assertNull($this->_estimate->getEstimateLine(''));
  }

  public function test_set_estimate_line() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_estimate->setEstimateLine($str, $str, $str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_estimate_line() {
    $str = $this->test_set_estimate_line();
    $this->assertEquals($str, $this->_estimate->getEstimateLine($str));
  }

  public function test_get_uninitialized_estimate_line_data() {
    $this->assertNull($this->_estimate->getEstimateLineData());
  }

  public function test_set_estimate_line_data() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setEstimateLineData($str, $str, $str));

    return $str;
  }

  public function test_set_get_estimate_line_data() {
    $str = $this->test_set_estimate_line_data();
    $this->assertEquals(array(), $this->_estimate->getEstimateLineData());
  }

  public function test_get_uninitialized_other() {
    $this->assertNull($this->_estimate->getOther());
  }

  public function test_set_other() {
    $str = $this->random_chars();
    $this->assertTrue($this->_estimate->setOther($str));

    return $str;
  }

  public function test_set_get_other() {
    $str = $this->test_set_other();
    $this->assertEquals($str, $this->_estimate->getOther());
  }
}

