<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class InvoiceTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_invoice = new QuickBooks_Object_Invoice();
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
    $this->assertNull($this->_invoice->getTransactionID());
  }

  public function test_set_transaction_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTransactionID($str));

    return $str;
  }

  public function test_set_get_transaction_id() {
    $str = $this->test_set_transaction_id();
    $this->assertEquals($str, $this->_invoice->getTransactionID());
  }

  public function test_get_uninitialized_txn_id() {
    $this->assertNull($this->_invoice->getTxnID());
  }

  public function test_set_txn_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTxnID($str));

    return $str;
  }

  public function test_set_get_txn_id() {
    $str = $this->test_set_txn_id();
    $this->assertEquals($str, $this->_invoice->getTxnID());
  }

  public function test_get_uninitialized_customer_list_id() {
    $this->assertNull($this->_invoice->getCustomerListID());
  }

  public function test_set_customer_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setCustomerListID($str));

    return $str;
  }

  public function test_set_get_customer_list_id() {
    $str = $this->test_set_customer_list_id();
    $this->assertEquals($str, $this->_invoice->getCustomerListID());
  }

  public function test_get_uninitialized_customer_application_id() {
    $this->assertFalse($this->_invoice->getCustomerApplicationID());
  }

  public function test_set_customer_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setCustomerApplicationID($str));

    return $str;
  }

  public function test_set_get_customer_application_id() {
    $str = $this->test_set_customer_application_id();
    $this->assertEquals($str, $this->_invoice->getCustomerApplicationID());
  }

  public function test_get_uninitialized_customer_name() {
    $this->assertNull($this->_invoice->getCustomerName());
  }

  public function test_set_customer_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setCustomerName($str));

    return $str;
  }

  public function test_set_get_customer_name() {
    $str = $this->test_set_customer_name();
    $this->assertEquals($str, $this->_invoice->getCustomerName());
  }

  public function test_get_uninitialized_class_list_id() {
    $this->assertNull($this->_invoice->getClassListID());
  }

  public function test_set_class_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setClassListID($str));

    return $str;
  }

  public function test_set_get_class_list_id() {
    $str = $this->test_set_class_list_id();
    $this->assertEquals($str, $this->_invoice->getClassListID());
  }

  public function test_get_uninitialized_class_application_id() {
    $this->assertFalse($this->_invoice->getClassApplicationID());
  }

  public function test_set_class_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setClassApplicationID($str));

    return $str;
  }

  public function test_set_get_class_application_id() {
    $str = $this->test_set_class_application_id();
    $this->assertEquals($str, $this->_invoice->getClassApplicationID());
  }

  public function test_get_uninitialized_class_name() {
    $this->assertNull($this->_invoice->getClassName());
  }

  public function test_set_class_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setClassName($str));

    return $str;
  }

  public function test_set_get_class_name() {
    $str = $this->test_set_class_name();
    $this->assertEquals($str, $this->_invoice->getClassName());
  }

  public function test_get_uninitialized_araccount_application_id() {
    $this->assertFalse($this->_invoice->getARAccountApplicationID());
  }

  public function test_set_araccount_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setARAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_araccount_application_id() {
    $str = $this->test_set_araccount_application_id();
    $this->assertEquals($str, $this->_invoice->getARAccountApplicationID());
  }

  public function test_get_uninitialized_araccount_list_id() {
    $this->assertNull($this->_invoice->getARAccountListID());
  }

  public function test_set_araccount_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setARAccountListID($str));

    return $str;
  }

  public function test_set_get_araccount_list_id() {
    $str = $this->test_set_araccount_list_id();
    $this->assertEquals($str, $this->_invoice->getARAccountListID());
  }

  public function test_get_uninitialized_araccount_name() {
    $this->assertNull($this->_invoice->getARAccountName());
  }

  public function test_set_araccount_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setARAccountName($str));

    return $str;
  }

  public function test_set_get_araccount_name() {
    $str = $this->test_set_araccount_name();
    $this->assertEquals($str, $this->_invoice->getARAccountName());
  }

  public function test_get_uninitialized_template_application_id() {
    $this->assertFalse($this->_invoice->getTemplateApplicationID());
  }

  public function test_set_template_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTemplateApplicationID($str));

    return $str;
  }

  public function test_set_get_template_application_id() {
    $str = $this->test_set_template_application_id();
    $this->assertEquals($str, $this->_invoice->getTemplateApplicationID());
  }

  public function test_get_uninitialized_template_name() {
    $this->assertNull($this->_invoice->getTemplateName());
  }

  public function test_set_template_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTemplateName($str));

    return $str;
  }

  public function test_set_get_template_name() {
    $str = $this->test_set_template_name();
    $this->assertEquals($str, $this->_invoice->getTemplateName());
  }

  public function test_get_uninitialized_template_list_id() {
    $this->assertNull($this->_invoice->getTemplateListID());
  }

  public function test_set_template_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTemplateListID($str));

    return $str;
  }

  public function test_set_get_template_list_id() {
    $str = $this->test_set_template_list_id();
    $this->assertEquals($str, $this->_invoice->getTemplateListID());
  }

  public function test_get_uninitialized_txn_date() {
    $this->assertNull($this->_invoice->getTxnDate());
  }

  public function test_set_txn_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTxnDate($str));

    return $str;
  }

  public function test_set_get_txn_date() {
    $str = $this->test_set_txn_date();
    $this->assertEquals('1969-12-31', $this->_invoice->getTxnDate());
  }

  public function test_get_uninitialized_transaction_date() {
    $this->assertNull($this->_invoice->getTransactionDate());
  }

  public function test_set_transaction_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTransactionDate($str));

    return $str;
  }

  public function test_set_get_transaction_date() {
    $str = $this->test_set_transaction_date();
    $this->assertEquals('1969-12-31', $this->_invoice->getTransactionDate());
  }

  public function test_get_uninitialized_ref_number() {
    $this->assertNull($this->_invoice->getRefNumber());
  }

  public function test_set_ref_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setRefNumber($str));

    return $str;
  }

  public function test_set_get_ref_number() {
    $str = $this->test_set_ref_number();
    $this->assertEquals($str, $this->_invoice->getRefNumber());
  }

  public function test_get_uninitialized_reference_number() {
    $this->assertNull($this->_invoice->getReferenceNumber());
  }

  public function test_set_reference_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setReferenceNumber($str));

    return $str;
  }

  public function test_set_get_reference_number() {
    $str = $this->test_set_reference_number();
    $this->assertEquals($str, $this->_invoice->getReferenceNumber());
  }

  public function test_get_uninitialized_ship_address() {
    $this->assertEquals(array(), $this->_invoice->getShipAddress());
  }

  public function test_set_ship_address() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_invoice->setShipAddress($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_ship_address() {
    $str = $this->test_set_ship_address();
    $this->assertEquals($str, $this->_invoice->getShipAddress());
  }

  public function test_get_uninitialized_bill_address() {
    $this->assertEquals(array(), $this->_invoice->getBillAddress());
  }

  public function test_set_bill_address() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_invoice->setBillAddress($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_bill_address() {
    $str = $this->test_set_bill_address();
    //$this->assertEquals($str, $this->_invoice->getBillAddress());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_is_pending() {
    $this->assertFalse($this->_invoice->getIsPending());
  }

  public function test_set_is_pending() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setIsPending($str));

    return $str;
  }

  public function test_set_get_is_pending() {
    $str = FALSE;
    $this->assertEquals(FALSE, $this->_invoice->getIsPending());
  }

  public function test_get_uninitialized_ponumber() {
    $this->assertNull($this->_invoice->getPONumber());
  }

  public function test_set_ponumber() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setPONumber($str));

    return $str;
  }

  public function test_set_get_ponumber() {
    $str = $this->test_set_ponumber();
    $this->assertEquals($str, $this->_invoice->getPONumber());
  }

  public function test_get_uninitialized_terms_list_id() {
    $this->assertNull($this->_invoice->getTermsListID());
  }

  public function test_set_terms_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTermsListID($str));

    return $str;
  }

  public function test_set_get_terms_list_id() {
    $str = $this->test_set_terms_list_id();
    $this->assertEquals($str, $this->_invoice->getTermsListID());
  }

  public function test_get_uninitialized_terms_application_id() {
    $this->assertFalse(FALSE, $this->_invoice->getTermsApplicationID());
  }

  public function test_set_terms_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTermsApplicationID($str));

    return $str;
  }

  public function test_set_get_terms_application_id() {
    $str = $this->test_set_terms_application_id();
    $this->assertEquals($str, $this->_invoice->getTermsApplicationID());
  }

  public function test_get_uninitialized_terms_name() {
    $this->assertNull($this->_invoice->getTermsName());
  }

  public function test_set_terms_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setTermsName($str));

    return $str;
  }

  public function test_set_get_terms_name() {
    $str = $this->test_set_terms_name();
    $this->assertEquals($str, $this->_invoice->getTermsName());
  }

  public function test_get_uninitialized_due_date() {
    $this->assertNull($this->_invoice->getDueDate());
  }

  public function test_set_due_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setDueDate($str));

    return $str;
  }

  public function test_set_get_due_date() {
    $str = $this->test_set_due_date();
    $this->assertEquals('1969-12-31', $this->_invoice->getDueDate());
  }

  public function test_get_uninitialized_sales_rep_name() {
    $this->assertNull($this->_invoice->getSalesRepName());
  }

  public function test_set_sales_rep_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setSalesRepName($str));

    return $str;
  }

  public function test_set_get_sales_rep_name() {
    $str = $this->test_set_sales_rep_name();
    $this->assertEquals($str, $this->_invoice->getSalesRepName());
  }

  public function test_get_uninitialized_sales_rep_list_id() {
    $this->assertNull($this->_invoice->getSalesRepListID());
  }

  public function test_set_sales_rep_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setSalesRepListID($str));

    return $str;
  }

  public function test_set_get_sales_rep_list_id() {
    $str = $this->test_set_sales_rep_list_id();
    $this->assertEquals($str, $this->_invoice->getSalesRepListID());
  }

  public function test_get_uninitialized_sales_rep_application_id() {
    $this->assertFalse(FALSE, $this->_invoice->getSalesRepApplicationID());
  }

  public function test_set_sales_rep_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setSalesRepApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_rep_application_id() {
    $str = $this->test_set_sales_rep_application_id();
    $this->assertEquals($str, $this->_invoice->getSalesRepApplicationID());
  }

  public function test_get_uninitialized_fob() {
    $this->assertNull($this->_invoice->getFOB());
  }

  public function test_set_fob() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setFOB($str));

    return $str;
  }

  public function test_set_get_fob() {
    $str = $this->test_set_fob();
    $this->assertEquals($str, $this->_invoice->getFOB());
  }

  public function test_get_uninitialized_ship_date() {
    $this->assertNull($this->_invoice->getShipDate());
  }

  public function test_set_ship_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setShipDate($str));

    return $str;
  }

  public function test_set_get_ship_date() {
    $str = $this->test_set_ship_date();
    $this->assertEquals('1969-12-31', $this->_invoice->getShipDate());
  }

  public function test_get_uninitialized_ship_method_application_id() {
    $this->assertFalse($this->_invoice->getShipMethodApplicationID());
  }

  public function test_set_ship_method_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setShipMethodApplicationID($str));

    return $str;
  }

  public function test_set_get_ship_method_application_id() {
    $str = $this->test_set_ship_method_application_id();
    $this->assertEquals($str, $this->_invoice->getShipMethodApplicationID());
  }

  public function test_get_uninitialized_ship_method_name() {
    $this->assertNull($this->_invoice->getShipMethodName());
  }

  public function test_set_ship_method_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setShipMethodName($str));

    return $str;
  }

  public function test_set_get_ship_method_name() {
    $str = $this->test_set_ship_method_name();
    $this->assertEquals($str, $this->_invoice->getShipMethodName());
  }

  public function test_get_uninitialized_ship_method_list_id() {
    $this->assertNull($this->_invoice->getShipMethodListID());
  }

  public function test_set_ship_method_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setShipMethodListID($str));

    return $str;
  }

  public function test_set_get_ship_method_list_id() {
    $str = $this->test_set_ship_method_list_id();
    $this->assertEquals($str, $this->_invoice->getShipMethodListID());
  }

  public function test_get_uninitialized_sales_tax_item_list_id() {
    $this->assertNull($this->_invoice->getSalesTaxItemListID());
  }

  public function test_set_sales_tax_item_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setSalesTaxItemListID($str));

    return $str;
  }

  public function test_set_get_sales_tax_item_list_id() {
    $str = $this->test_set_sales_tax_item_list_id();
    $this->assertEquals($str, $this->_invoice->getSalesTaxItemListID());
  }

  public function test_get_uninitialized_sales_tax_item_application_id() {
    $this->assertNull($this->_invoice->getSalesTaxItemApplicationID());
  }

  public function test_set_sales_tax_item_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setSalesTaxItemApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_tax_item_application_id() {
    $str = $this->test_set_sales_tax_item_application_id();
    $this->assertEquals('ItemSalesTax|ListID|'. $str, $this->_invoice->getSalesTaxItemApplicationID());
  }

  public function test_get_uninitialized_sales_tax_item_name() {
    $this->assertNull($this->_invoice->getSalesTaxItemName());
  }

  public function test_set_sales_tax_item_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setSalesTaxItemName($str));

    return $str;
  }

  public function test_set_get_sales_tax_item_name() {
    $str = $this->test_set_sales_tax_item_name();
    $this->assertEquals($str, $this->_invoice->getSalesTaxItemName());
  }

  public function test_get_uninitialized_memo() {
    $this->assertNull($this->_invoice->getMemo());
  }

  public function test_set_memo() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setMemo($str));

    return $str;
  }

  public function test_set_get_memo() {
    $str = $this->test_set_memo();
    $this->assertEquals($str, $this->_invoice->getMemo());
  }

  public function test_get_uninitialized_is_to_be_printed() {
    $this->assertFalse($this->_invoice->getIsToBePrinted());
  }

  public function test_set_is_to_be_printed() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setIsToBePrinted($str));

    return $str;
  }

  public function test_set_get_is_to_be_printed() {
    $str = $this->test_set_is_to_be_printed();
    $this->assertFalse(FALSE, $this->_invoice->getIsToBePrinted());
  }

  public function test_get_uninitialized_is_to_be_emailed() {
    $this->assertEquals(FALSE, $this->_invoice->getIsToBeEmailed());
  }

  public function test_set_is_to_be_emailed() {
    $str = $this->random_chars();
    $this->assertEquals(TRUE, $this->_invoice->setIsToBeEmailed($str));

    return $str;
  }

  public function test_set_get_is_to_be_emailed() {
    $str = $this->test_set_is_to_be_emailed();
    $this->assertEquals(FALSE, $this->_invoice->getIsToBeEmailed());
  }

  public function test_get_uninitialized_customer_sales_tax_code_list_id() {
    $this->assertNull($this->_invoice->getCustomerSalesTaxCodeListID());
  }

  public function test_set_customer_sales_tax_code_list_id() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_invoice->setCustomerSalesTaxCodeListID($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_customer_sales_tax_code_list_id() {
    $str = $this->test_set_customer_sales_tax_code_list_id();
    //$this->assertEquals($str, $this->_invoice->getCustomerSalesTaxCodeListID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_customer_sales_tax_code_name() {
    $this->assertNull($this->_invoice->getCustomerSalesTaxCodeName());
  }

  public function test_set_customer_sales_tax_code_name() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_invoice->setCustomerSalesTaxCodeName($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_customer_sales_tax_code_name() {
    $str = $this->test_set_customer_sales_tax_code_name();
    //$this->assertEquals($str, $this->_invoice->getCustomerSalesTaxCodeName());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_link_to_txn_id() {
    $this->assertNull($this->_invoice->getLinkToTxnID());
  }

  public function test_set_link_to_txn_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setLinkToTxnID($str));

    return $str;
  }

  public function test_set_get_link_to_txn_id() {
    $str = $this->test_set_link_to_txn_id();
    $this->assertEquals($str, $this->_invoice->getLinkToTxnID());
  }

  public function test_get_uninitialized_invoice_lines() {
    //$this->assertNull($this->_invoice->getInvoiceLines());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_invoice_lines() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_invoice->setInvoiceLines($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_invoice_lines() {
    //$str = $this->test_set_invoice_lines();
    //$this->assertEquals($str, $this->_invoice->getInvoiceLines());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_invoice_line() {
    //$this->assertNull($this->_invoice->getInvoiceLine());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_invoice_line() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_invoice->setInvoiceLine($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_invoice_line() {
    $str = $this->test_set_invoice_line();
    //$this->assertEquals($str, $this->_invoice->getInvoiceLine());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_invoice_line_data() {
    //$this->assertNull($this->_invoice->getInvoiceLineData());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_invoice_line_data() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_invoice->setInvoiceLineData($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_invoice_line_data() {
    $str = $this->test_set_invoice_line_data();
    //$this->assertEquals($str, $this->_invoice->getInvoiceLineData());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_other() {
    $this->assertNull($this->_invoice->getOther());
  }

  public function test_set_other() {
    $str = $this->random_chars();
    $this->assertTrue($this->_invoice->setOther($str));

    return $str;
  }

  public function test_set_get_other() {
    $str = $this->test_set_other();
    $this->assertEquals($str, $this->_invoice->getOther());
  }

  public function test_get_uninitialized_balance_remaining() {
    $this->assertEquals(0,$this->_invoice->getBalanceRemaining());
  }

  public function test_set_balance_remaining() {
    $str = $this->random_nums();
    //$this->assertTrue($this->_invoice->setBalanceRemaining($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_balance_remaining() {
    $str = $this->test_set_balance_remaining();
    //$this->assertEquals($str, $this->_invoice->getBalanceRemaining());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }
}

