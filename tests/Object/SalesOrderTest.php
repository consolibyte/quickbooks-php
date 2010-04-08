<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class SalesOrderTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_salesorder = new QuickBooks_Object_SalesOrder();
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
    $this->assertNull($this->_salesorder->getTransactionID());
  }

  public function test_set_transaction_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTransactionID($str));

    return $str;
  }

  public function test_set_get_transaction_id() {
    $str = $this->test_set_transaction_id();
    $this->assertEquals($str, $this->_salesorder->getTransactionID());
  }

  public function test_get_uninitialized_txn_id() {
    $this->assertNull($this->_salesorder->getTxnID());
  }

  public function test_set_txn_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTxnID($str));

    return $str;
  }

  public function test_set_get_txn_id() {
    $str = $this->test_set_txn_id();
    $this->assertEquals($str, $this->_salesorder->getTxnID());
  }

  public function test_get_uninitialized_customer_list_id() {
    $this->assertNull($this->_salesorder->getCustomerListID());
  }

  public function test_set_customer_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setCustomerListID($str));

    return $str;
  }

  public function test_set_get_customer_list_id() {
    $str = $this->test_set_customer_list_id();
    $this->assertEquals($str, $this->_salesorder->getCustomerListID());
  }

  public function test_get_uninitialized_customer_application_id() {
    $this->assertNull($this->_salesorder->getCustomerApplicationID());
  }

  public function test_set_customer_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setCustomerApplicationID($str));

    return $str;
  }

  public function test_set_get_customer_application_id() {
    $str = $this->test_set_customer_application_id();
    $this->assertEquals('Customer|ListID|'. $str, $this->_salesorder->getCustomerApplicationID());
  }

  public function test_get_uninitialized_customer_name() {
    $this->assertNull($this->_salesorder->getCustomerName());
  }

  public function test_set_customer_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setCustomerName($str));

    return $str;
  }

  public function test_set_get_customer_name() {
    $str = $this->test_set_customer_name();
    $this->assertEquals($str, $this->_salesorder->getCustomerName());
  }

  public function test_get_uninitialized_class_list_id() {
    $this->assertNull($this->_salesorder->getClassListID());
  }

  public function test_set_class_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setClassListID($str));

    return $str;
  }

  public function test_set_get_class_list_id() {
    $str = $this->test_set_class_list_id();
    $this->assertEquals($str, $this->_salesorder->getClassListID());
  }

  public function test_get_uninitialized_class_application_id() {
    $this->assertNull($this->_salesorder->getClassApplicationID());
  }

  public function test_set_class_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setClassApplicationID($str));

    return $str;
  }

  public function test_set_get_class_application_id() {
    $str = $this->test_set_class_application_id();
    $this->assertEquals('Class|ListID|'. $str, $this->_salesorder->getClassApplicationID());
  }

  public function test_get_uninitialized_class_name() {
    $this->assertNull($this->_salesorder->getClassName());
  }

  public function test_set_class_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setClassName($str));

    return $str;
  }

  public function test_set_get_class_name() {
    $str = $this->test_set_class_name();
    $this->assertEquals($str, $this->_salesorder->getClassName());
  }

  public function test_get_uninitialized_araccount_application_id() {
    $this->assertNull($this->_salesorder->getARAccountApplicationID());
  }

  public function test_set_araccount_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setARAccountApplicationID($str));

    return $str;
  }

  public function test_set_get_araccount_application_id() {
    $str = $this->test_set_araccount_application_id();
    $this->assertEquals('Account|ListID|'. $str, $this->_salesorder->getARAccountApplicationID());
  }

  public function test_get_uninitialized_araccount_list_id() {
    $this->assertNull($this->_salesorder->getARAccountListID());
  }

  public function test_set_araccount_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setARAccountListID($str));

    return $str;
  }

  public function test_set_get_araccount_list_id() {
    $str = $this->test_set_araccount_list_id();
    $this->assertEquals($str, $this->_salesorder->getARAccountListID());
  }

  public function test_get_uninitialized_araccount_name() {
    $this->assertNull($this->_salesorder->getARAccountName());
  }

  public function test_set_araccount_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setARAccountName($str));

    return $str;
  }

  public function test_set_get_araccount_name() {
    $str = $this->test_set_araccount_name();
    $this->assertEquals($str, $this->_salesorder->getARAccountName());
  }

  public function test_get_uninitialized_template_application_id() {
    $this->assertNull($this->_salesorder->getTemplateApplicationID());
  }

  public function test_set_template_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTemplateApplicationID($str));

    return $str;
  }

  public function test_set_get_template_application_id() {
    $str = $this->test_set_template_application_id();
    $this->assertEquals('Template|ListID|'. $str, $this->_salesorder->getTemplateApplicationID());
  }

  public function test_get_uninitialized_template_name() {
    $this->assertNull($this->_salesorder->getTemplateName());
  }

  public function test_set_template_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTemplateName($str));

    return $str;
  }

  public function test_set_get_template_name() {
    $str = $this->test_set_template_name();
    $this->assertEquals($str, $this->_salesorder->getTemplateName());
  }

  public function test_get_uninitialized_template_list_id() {
    $this->assertNull($this->_salesorder->getTemplateListID());
  }

  public function test_set_template_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTemplateListID($str));

    return $str;
  }

  public function test_set_get_template_list_id() {
    $str = $this->test_set_template_list_id();
    $this->assertEquals($str, $this->_salesorder->getTemplateListID());
  }

  public function test_get_uninitialized_txn_date() {
    $this->assertNull($this->_salesorder->getTxnDate());
  }

  public function test_set_txn_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTxnDate($str));

    return $str;
  }

  public function test_set_get_txn_date() {
    $str = $this->test_set_txn_date();
    $this->assertEquals('1969-12-31', $this->_salesorder->getTxnDate());
  }

  public function test_get_uninitialized_transaction_date() {
    $this->assertNull($this->_salesorder->getTransactionDate());
  }

  public function test_set_transaction_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTransactionDate($str));

    return $str;
  }

  public function test_set_get_transaction_date() {
    $str = $this->test_set_transaction_date();
    $this->assertEquals('1969-12-31', $this->_salesorder->getTransactionDate());
  }

  public function test_get_uninitialized_ref_number() {
    $this->assertNull($this->_salesorder->getRefNumber());
  }

  public function test_set_ref_number() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setRefNumber($str));

    return $str;
  }

  public function test_set_get_ref_number() {
    $str = $this->test_set_ref_number();
    $this->assertEquals($str, $this->_salesorder->getRefNumber());
  }

  public function test_get_uninitialized_ship_address() {
    $this->assertEquals(array(), $this->_salesorder->getShipAddress());
  }

  public function test_set_ship_address() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setShipAddress($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_ship_address() {
    //$str = $this->test_set_ship_address();
    //$this->assertEquals($str, $this->_salesorder->getShipAddress());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_bill_address() {
    $this->assertEquals(array(), $this->_salesorder->getBillAddress());
  }

  public function test_set_bill_address() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setBillAddress($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_bill_address() {
    //$str = $this->test_set_bill_address();
    //$this->assertEquals($str, $this->_salesorder->getBillAddress());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_is_pending() {
    $this->assertNull($this->_salesorder->getIsPending());
  }

  public function test_set_is_pending() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setIsPending($str));

    return $str;
  }

  public function test_set_get_is_pending() {
    $str = $this->test_set_is_pending();
    $this->assertEquals($str, $this->_salesorder->getIsPending());
  }

  public function test_get_uninitialized_ponumber() {
    $this->assertNull($this->_salesorder->getPONumber());
  }

  public function test_set_ponumber() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setPONumber($str));

    return $str;
  }

  public function test_set_get_ponumber() {
    $str = $this->test_set_ponumber();
    $this->assertEquals($str, $this->_salesorder->getPONumber());
  }

  public function test_get_uninitialized_terms_list_id() {
    $this->assertNull($this->_salesorder->getTermsListID());
  }

  public function test_set_terms_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTermsListID($str));

    return $str;
  }

  public function test_set_get_terms_list_id() {
    $str = $this->test_set_terms_list_id();
    $this->assertEquals($str, $this->_salesorder->getTermsListID());
  }

  public function test_get_uninitialized_terms_application_id() {
    $this->assertNull($this->_salesorder->getTermsApplicationID());
  }

  public function test_set_terms_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTermsApplicationID($str));

    return $str;
  }

  public function test_set_get_terms_application_id() {
    $str = $this->test_set_terms_application_id();
    $this->assertEquals('Terms|ListID|'. $str, $this->_salesorder->getTermsApplicationID());
  }

  public function test_get_uninitialized_terms_name() {
    $this->assertNull($this->_salesorder->getTermsName());
  }

  public function test_set_terms_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setTermsName($str));

    return $str;
  }

  public function test_set_get_terms_name() {
    $str = $this->test_set_terms_name();
    $this->assertEquals($str, $this->_salesorder->getTermsName());
  }

  public function test_get_uninitialized_due_date() {
    $this->assertNull($this->_salesorder->getDueDate());
  }

  public function test_set_due_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setDueDate($str));

    return $str;
  }

  public function test_set_get_due_date() {
    $str = $this->test_set_due_date();
    $this->assertEquals('1969-12-31', $this->_salesorder->getDueDate());
  }

  public function test_get_uninitialized_sales_rep_name() {
    $this->assertNull($this->_salesorder->getSalesRepName());
  }

  public function test_set_sales_rep_name() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setSalesRepName($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_sales_rep_name() {
    //$str = $this->test_set_sales_rep_name();
    //$this->assertEquals($str, $this->_salesorder->getSalesRepName());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_sales_rep_list_id() {
    $this->assertNull($this->_salesorder->getSalesRepListID());
  }

  public function test_set_sales_rep_list_id() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setSalesRepListID($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_sales_rep_list_id() {
    //$str = $this->test_set_sales_rep_list_id();
    //$this->assertEquals($str, $this->_salesorder->getSalesRepListID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_sales_rep_application_id() {
    $this->assertNull($this->_salesorder->getSalesRepApplicationID());
  }

  public function test_set_sales_rep_application_id() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setSalesRepApplicationID($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_sales_rep_application_id() {
    //$str = $this->test_set_sales_rep_application_id();
    //$this->assertEquals($str, $this->_salesorder->getSalesRepApplicationID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_fob() {
    $this->assertNull($this->_salesorder->getFOB());
  }

  public function test_set_fob() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setFOB($str));

    return $str;
  }

  public function test_set_get_fob() {
    $str = $this->test_set_fob();
    $this->assertEquals($str, $this->_salesorder->getFOB());
  }

  public function test_get_uninitialized_ship_date() {
    $this->assertNull($this->_salesorder->getShipDate());
  }

  public function test_set_ship_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setShipDate($str));

    return $str;
  }

  public function test_set_get_ship_date() {
    $str = $this->test_set_ship_date();
    $this->assertEquals('1969-12-31', $this->_salesorder->getShipDate());
  }

  public function test_get_uninitialized_ship_method_application_id() {
    $this->assertNull($this->_salesorder->getShipMethodApplicationID());
  }

  public function test_set_ship_method_application_id() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setShipMethodApplicationID($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_ship_method_application_id() {
    $str = $this->test_set_ship_method_application_id();
    //$this->assertEquals($str, $this->_salesorder->getShipMethodApplicationID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_ship_method_name() {
    $this->assertNull($this->_salesorder->getShipMethodName());
  }

  public function test_set_ship_method_name() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setShipMethodName($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_ship_method_name() {
    $str = $this->test_set_ship_method_name();
    //$this->assertEquals($str, $this->_salesorder->getShipMethodName());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_ship_method_list_id() {
    $this->assertNull($this->_salesorder->getShipMethodListID());
  }

  public function test_set_ship_method_list_id() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setShipMethodListID($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_ship_method_list_id() {
    $str = $this->test_set_ship_method_list_id();
    //$this->assertEquals($str, $this->_salesorder->getShipMethodListID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_sales_tax_item_list_id() {
    $this->assertNull($this->_salesorder->getSalesTaxItemListID());
  }

  public function test_set_sales_tax_item_list_id() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setSalesTaxItemListID($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_sales_tax_item_list_id() {
    $str = $this->test_set_sales_tax_item_list_id();
    //$this->assertEquals($str, $this->_salesorder->getSalesTaxItemListID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_sales_tax_item_application_id() {
    $this->assertNull($this->_salesorder->getSalesTaxItemApplicationID());
  }

  public function test_set_sales_tax_item_application_id() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setSalesTaxItemApplicationID($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_sales_tax_item_application_id() {
    $str = $this->test_set_sales_tax_item_application_id();
    //$this->assertEquals($str, $this->_salesorder->getSalesTaxItemApplicationID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_sales_tax_item_name() {
    $this->assertNull($this->_salesorder->getSalesTaxItemName());
  }

  public function test_set_sales_tax_item_name() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setSalesTaxItemName($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_sales_tax_item_name() {
    $str = $this->test_set_sales_tax_item_name();
    //$this->assertEquals($str, $this->_salesorder->getSalesTaxItemName());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_memo() {
    $this->assertNull($this->_salesorder->getMemo());
  }

  public function test_set_memo() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setMemo($str));

    return $str;
  }

  public function test_set_get_memo() {
    $str = $this->test_set_memo();
    $this->assertEquals($str, $this->_salesorder->getMemo());
  }

  public function test_get_uninitialized_is_to_be_printed() {
    $this->assertNull($this->_salesorder->getIsToBePrinted());
  }

  public function test_set_is_to_be_printed() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setIsToBePrinted($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_is_to_be_printed() {
    $str = $this->test_set_is_to_be_printed();
    //$this->assertEquals($str, $this->_salesorder->getIsToBePrinted());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_is_to_be_emailed() {
    $this->assertNull($this->_salesorder->getIsToBeEmailed());
  }

  public function test_set_is_to_be_emailed() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setIsToBeEmailed($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_is_to_be_emailed() {
    $str = $this->test_set_is_to_be_emailed();
    //$this->assertEquals($str, $this->_salesorder->getIsToBeEmailed());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_customer_sales_tax_code_list_id() {
    $this->assertNull($this->_salesorder->getCustomerSalesTaxCodeListID());
  }

  public function test_set_customer_sales_tax_code_list_id() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setCustomerSalesTaxCodeListID($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_customer_sales_tax_code_list_id() {
    $str = $this->test_set_customer_sales_tax_code_list_id();
    //$this->assertEquals($str, $this->_salesorder->getCustomerSalesTaxCodeListID());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_customer_sales_tax_code_name() {
    $this->assertNull($this->_salesorder->getCustomerSalesTaxCodeName());
  }

  public function test_set_customer_sales_tax_code_name() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setCustomerSalesTaxCodeName($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    return $str;
  }

  public function test_set_get_customer_sales_tax_code_name() {
    $str = $this->test_set_customer_sales_tax_code_name();
    //$this->assertEquals($str, $this->_salesorder->getCustomerSalesTaxCodeName());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_link_to_txn_id() {
    $this->assertNull($this->_salesorder->getLinkToTxnID());
  }

  public function test_set_link_to_txn_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setLinkToTxnID($str));

    return $str;
  }

  public function test_set_get_link_to_txn_id() {
    $str = $this->test_set_link_to_txn_id();
    $this->assertEquals($str, $this->_salesorder->getLinkToTxnID());
  }

  public function test_get_uninitialized_invoice_lines() {
    //$this->assertNull($this->_salesorder->getInvoiceLines());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_invoice_lines() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setInvoiceLines($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_invoice_lines() {
    $str = $this->test_set_invoice_lines();
    //$this->assertEquals($str, $this->_salesorder->getInvoiceLines());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_invoice_line() {
    $this->assertNull($this->_salesorder->getInvoiceLine());
  }

  public function test_set_invoice_line() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setInvoiceLine($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_invoice_line() {
    $str = $this->test_set_invoice_line();
    $this->assertEquals($str, $this->_salesorder->getInvoiceLine());
  }

  public function test_get_uninitialized_invoice_line_data() {
    //$this->assertNull($this->_salesorder->getInvoiceLineData());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_invoice_line_data() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_salesorder->setInvoiceLineData($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_invoice_line_data() {
    //$str = $this->test_set_invoice_line_data();
    //$this->assertEquals($str, $this->_salesorder->getInvoiceLineData());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_other() {
    $this->assertNull($this->_salesorder->getOther());
  }

  public function test_set_other() {
    $str = $this->random_chars();
    $this->assertTrue($this->_salesorder->setOther($str));

    return $str;
  }

  public function test_set_get_other() {
    $str = $this->test_set_other();
    $this->assertEquals($str, $this->_salesorder->getOther());
  }
}

