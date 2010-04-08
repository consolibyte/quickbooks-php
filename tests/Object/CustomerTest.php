<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class CustomerTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_customer = new QuickBooks_Object_Customer();
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
    $this->assertNull($this->_customer->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_customer->getListID());
  }

  public function test_get_uninitialized_parent_list_id() {
    $this->assertNull($this->_customer->getParentListID());
  }

  public function test_set_parent_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setParentListID($str));

    return $str;
  }

  public function test_set_get_parent_list_id() {
    $str = $this->test_set_parent_list_id();
    $this->assertEquals($str, $this->_customer->getParentListID());
  }

  public function test_get_uninitialized_parent_name() {
    $this->assertNull($this->_customer->getParentName());
  }

  public function test_set_parent_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setParentName($str));
    
    return $str;
  }

  public function test_set_get_parent_name() {
    $str = $this->test_set_parent_name();
    $this->assertEquals($str, $this->_customer->getParentName());
  }

  public function test_get_uninitialized_parent_application_id() {
    $this->assertNull($this->_customer->getParentApplicationID());
  }

  public function test_set_parent_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setParentApplicationID($str));

    return $str;
  }

  public function test_set_get_parent_application_id() {
    $str = $this->test_set_parent_application_id();
    $this->assertEquals('Customer|ListID|'. $str, $this->_customer->getParentApplicationID());
  }

  public function test_get_uninitialized_customer_type_list_id() {
    $this->assertNull($this->_customer->getCustomerTypeListID());
  }

  public function test_set_customer_type_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setCustomerTypeListID($str));

    return $str;
  }

  public function test_set_get_customer_type_list_id() {
    $str = $this->test_set_customer_type_list_id();
    $this->assertEquals($str, $this->_customer->getCustomerTypeListID());
  }

  public function test_get_uninitialized_customer_type_name() {
    $this->assertNull($this->_customer->getCustomerTypeName());
  }

  public function test_set_customer_type_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setCustomerTypeName($str));

    return $str;
  }

  public function test_set_get_customer_type_name() {
    $str = $this->test_set_customer_type_name();
    $this->assertEquals($str, $this->_customer->getCustomerTypeName());
  }

  public function test_get_uninitialized_customer_type_application_id() {
    $this->assertNull($this->_customer->getCustomerTypeApplicationID());
  }

  public function test_set_customer_type_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setCustomerTypeApplicationID($str));

    return $str;
  }

  public function test_set_get_customer_type_application_id() {
    $str = $this->test_set_customer_type_application_id();
    $this->assertEquals("CustomerType|ListID|$str", $this->_customer->getCustomerTypeApplicationID());
  }

  public function test_get_uninitialized_terms_name() {
    $this->assertNull($this->_customer->getTermsName());
  }

  public function test_set_terms_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setTermsName($str));

    return $str;
  }

  public function test_set_get_terms_name() {
    $str = $this->test_set_terms_name();
    $this->assertEquals($str, $this->_customer->getTermsName());
  }

  public function test_get_uninitialized_terms_list_id() {
    $this->assertNull($this->_customer->getTermsListID());
  }

  public function test_set_terms_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setTermsListID($str));

    return $str;
  }

  public function test_set_get_terms_list_id() {
    $str = $this->test_set_terms_list_id();
    $this->assertEquals($str, $this->_customer->getTermsListID());
  }

  public function test_get_uninitialized_terms_application_id() {
    $this->assertNull($this->_customer->getTermsApplicationID());
  }

  public function test_set_terms_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setTermsApplicationID($str));

    return $str;
  }

  public function test_set_get_terms_application_id() {
    $str = $this->test_set_terms_application_id();
    $this->assertEquals('Terms|ListID|'. $str,  $this->_customer->getTermsApplicationID());
  }

  public function test_get_uninitialized_sales_rep_name() {
    $this->assertNull($this->_customer->getSalesRepName());
  }

  public function test_set_sales_rep_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setSalesRepName($str));

    return $str;
  }

  public function test_set_get_sales_rep_name() {
    $str = $this->test_set_sales_rep_name();
    $this->assertEquals($str, $this->_customer->getSalesRepName());
  }

  public function test_get_uninitialized_sales_rep_list_id() {
    $this->assertNull($this->_customer->getSalesRepListID());
  }

  public function test_set_sales_rep_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setSalesRepListID($str));

    return $str;
  }

  public function test_set_get_sales_rep_list_id() {
    $str = $this->test_set_sales_rep_list_id();
    $this->assertEquals($str, $this->_customer->getSalesRepListID());
  }

  public function test_get_uninitialized_sales_rep_application_id() {
    $this->assertNull($this->_customer->getSalesRepApplicationID());
  }

  public function test_set_sales_rep_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setSalesRepApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_rep_application_id() {
    $str = $this->test_set_sales_rep_application_id();
    $this->assertEquals('SalesRep|ListID|'. $str, $this->_customer->getSalesRepApplicationID());
  }

  public function test_get_uninitialized_delivery_method() {
    $this->assertNull($this->_customer->getDeliveryMethod());
  }

  public function test_set_delivery_method() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setDeliveryMethod($str));

    return $str;
  }

  public function test_set_get_delivery_method() {
    $str = $this->test_set_delivery_method();
    $this->assertEquals($str, $this->_customer->getDeliveryMethod());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_customer->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_customer->getName());
  }

  public function test_get_uninitialized_full_name() {
    $this->assertNull($this->_customer->getFullName());
  }

/*
  public function test_set_full_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setFullName($str));

    return $str;
  }

  public function test_set_get_full_name() {
    $str = $this->test_set_full_name();
    $this->assertEquals($str, $this->_customer->getFullName());
  }
*/

  public function test_get_uninitialized_company_name() {
    $this->assertNull($this->_customer->getCompanyName());
  }

  public function test_set_company_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setCompanyName($str));

    return $str;
  }

  public function test_set_get_company_name() {
    $str = $this->test_set_company_name();
    $this->assertEquals($str, $this->_customer->getCompanyName());
  }

  public function test_get_uninitialized_first_name() {
    $this->assertNull($this->_customer->getFirstName());
  }

  public function test_set_first_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setFirstName($str));

    return $str;
  }

  public function test_set_get_first_name() {
    $str = $this->test_set_first_name();
    $this->assertEquals($str, $this->_customer->getFirstName());
  }

  public function test_get_uninitialized_last_name() {
    $this->assertNull($this->_customer->getLastName());
  }

  public function test_set_last_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setLastName($str));

    return $str;
  }

  public function test_set_get_last_name() {
    $str = $this->test_set_last_name();
    $this->assertEquals($str, $this->_customer->getLastName());
  }

  public function test_get_uninitialized_middle_name() {
    $this->assertNull($this->_customer->getMiddleName());
  }

  public function test_set_middle_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setMiddleName($str));

    return $str;
  }

  public function test_set_get_middle_name() {
    $str = $this->test_set_middle_name();
    $this->assertEquals($str, $this->_customer->getMiddleName());
  }

  public function test_get_uninitialized_ship_address() {
    $this->assertEquals(array(), $this->_customer->getShipAddress());
  }

  public function test_set_get_ship_address() {
    //$str = $this->test_set_ship_address();
    //$this->assertEquals($str, $this->_customer->getShipAddress());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_bill_address() {
    $this->assertEquals(array(), $this->_customer->getBillAddress());
  }

  public function test_set_get_bill_address() {
    //$str = $this->test_set_bill_address();
    //$this->assertEquals($str, $this->_customer->getBillAddress());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_ship_address_block() {
    $this->assertEquals(array(), $this->_customer->getShipAddressBlock());
  }

  public function test_set_ship_address_block() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_customer->setShipAddressBlock());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_get_ship_address_block() {
    //$str = $this->test_set_ship_address_block();
    //$this->assertEquals($str, $this->_customer->setShipAddressBlock());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_bill_address_block() {
    $this->assertEquals(array(), $this->_customer->getBillAddressBlock());
  }

  public function test_set_ship_address() {
    $addr1 = $this->random_chars();
    $addr2 = $this->random_chars();
    $addr3 = $this->random_chars();
    $addr4 = $this->random_chars();
    $addr5 = $this->random_chars();
    $city = $this->random_chars();
    $state = $this->random_chars();
    $province = $this->random_chars();
    $postalcode = $this->random_chars();
    $country = $this->random_chars();
    $note = $this->random_chars();

    $this->assertTrue($this->_customer->setShipAddress($addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note));
    $a = array($addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note);

    return $a;
  }

  public function test_set_bill_address() {
    $addr1 = $this->random_chars();
    $addr2 = $this->random_chars();
    $addr3 = $this->random_chars();
    $addr4 = $this->random_chars();
    $addr5 = $this->random_chars();
    $city = $this->random_chars();
    $state = $this->random_chars();
    $province = $this->random_chars();
    $postalcode = $this->random_chars();
    $country = $this->random_chars();
    $note = $this->random_chars();

    $this->assertTrue($this->_customer->setBillAddress($addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note));
    $a = array($addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note);
    
    return $a;
  }

  public function test_set_bill_address_block() {
    //$str = $this->random_chars();
    //$this->assertTrue($this->_customer->setBillAddressBlock());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_set_get_bill_address_block() {
    //$str = $this->test_set_bill_address_block();
    //$this->assertEquals($str, $this->_customer->setBillAddressBlock());
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function test_get_uninitialized_phone() {
    $this->assertNull($this->_customer->getPhone());
  }

  public function test_set_phone() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setPhone($str));

    return $str;
  }

  public function test_set_get_phone() {
    $str = $this->test_set_phone();
    $this->assertEquals($str, $this->_customer->getPhone());
  }

  public function test_get_uninitialized_alt_phone() {
    $this->assertNull($this->_customer->getAltPhone());
  }

  public function test_set_alt_phone() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setAltPhone($str));

    return $str;
  }

  public function test_set_get_alt_phone() {
    $str = $this->test_set_alt_phone();
    $this->assertEquals($str, $this->_customer->getAltPhone());
  }

  public function test_get_uninitialized_fax() {
    $this->assertNull($this->_customer->getFax());
  }

  public function test_set_fax() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setFax($str));

    return $str;
  }

  public function test_set_get_fax() {
    $str = $this->test_set_fax();
    $this->assertEquals($str, $this->_customer->getFax());
  }

  public function test_get_uninitialized_email() {
    $this->assertNull($this->_customer->getEmail());
  }

  public function test_set_email() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setEmail($str));

    return $str;
  }

  public function test_set_get_email() {
    $str = $this->test_set_email();
    $this->assertEquals($str, $this->_customer->getEmail());
  }

  public function test_get_uninitialized_contact() {
    $this->assertNull($this->_customer->getContact());
  }

  public function test_set_contact() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setContact($str));

    return $str;
  }

  public function test_set_get_contact() {
    $str = $this->test_set_contact();
    $this->assertEquals($str, $this->_customer->getContact());
  }

  public function test_get_uninitialized_alt_contact() {
    $this->assertNull($this->_customer->getAltContact());
  }

  public function test_set_alt_contact() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setAltContact($str));

    return $str;
  }

  public function test_set_get_alt_contact() {
    $str = $this->test_set_alt_contact();
    $this->assertEquals($str, $this->_customer->getAltContact());
  }

  public function test_get_uninitialized_salutation() {
    $this->assertNull($this->_customer->getSalutation());
  }

  public function test_set_salutation() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setSalutation($str));

    return $str;
  }

  public function test_set_get_salutation() {
    $str = $this->test_set_salutation();
    $this->assertEquals($str, $this->_customer->getSalutation());
  }

  public function test_get_uninitialized_open_balance() {
    $this->assertNull($this->_customer->getOpenBalance());
  }

  public function test_set_open_balance() {
    $str = $this->random_nums();
    $this->assertTrue($this->_customer->setOpenBalance($str));

    return $str;
  }

  public function test_set_get_open_balance() {
    $str = $this->test_set_open_balance();
    $this->assertEquals($str, $this->_customer->getOpenBalance());
  }

  public function test_get_uninitialized_open_balance_date() {
    $this->assertNull($this->_customer->getOpenBalanceDate());
  }

  public function test_set_open_balance_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setOpenBalanceDate($str));

    return $str;
  }

  public function test_set_get_open_balance_date() {
    $str = $this->test_set_open_balance_date();
    $this->assertEquals('1969-12-31', $this->_customer->getOpenBalanceDate());
  }

  public function test_get_uninitialized_balance() {
    $this->assertNull($this->_customer->getBalance());
  }

  public function test_set_balance() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setBalance($str));

    return $str;
  }

  public function test_set_get_balance() {
    $str = $this->test_set_balance();
    $this->assertEquals($str, $this->_customer->getBalance());
  }

  public function test_get_uninitialized_total_balance() {
    $this->assertNull($this->_customer->getTotalBalance());
  }

  public function test_set_total_balance() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setTotalBalance($str));

    return $str;
  }

  public function test_set_get_total_balance() {
    $str = $this->test_set_total_balance();
    $this->assertEquals($str, $this->_customer->getTotalBalance());
  }

  public function test_get_uninitialized_sales_tax_code_name() {
    $this->assertNull($this->_customer->getSalesTaxCodeName());
  }

  public function test_set_sales_tax_code_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setSalesTaxCodeName($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_name() {
    $str = $this->test_set_sales_tax_code_name();
    $this->assertEquals($str, $this->_customer->getSalesTaxCodeName());
  }

  public function test_get_uninitialized_sales_tax_code_list_id() {
    $this->assertNull($this->_customer->getSalesTaxCodeListID());
  }

  public function test_set_sales_tax_code_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setSalesTaxCodeListID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_list_id() {
    $str = $this->test_set_sales_tax_code_list_id();
    $this->assertEquals($str, $this->_customer->getSalesTaxCodeListID());
  }

  public function test_get_uninitialized_sales_tax_code_application_id() {
    $this->assertNull($this->_customer->getSalesTaxCodeApplicationID());
  }

  public function test_set_sales_tax_code_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setSalesTaxCodeApplicationID($str));

    return $str;
  }

  public function test_set_get_sales_tax_code_application_id() {
    $str = $this->test_set_sales_tax_code_application_id();
    $this->assertEquals("SalesTaxCode|ListID|$str", $this->_customer->getSalesTaxCodeApplicationID());
  }

  public function test_get_uninitialized_credit_card_info() {
    $this->assertEquals(array(), $this->_customer->getCreditCardInfo());
  }

  // XXX: Woefully inadequate tests for credit card info.
  // Maybe CC info should be a class/object.
  public function test_set_credit_card_info() {
    $num = $this->random_chars();
    $expmo = $this->random_chars();
    $expyr = $this->random_chars();
    $noc = $this->random_chars();
    $cca = $this->random_chars();
    $ccpc = $this->random_chars();

    $this->assertTrue($this->_customer->setCreditCardInfo($num, $expmo, $expyr, $noc, $cca, $ccpc));

    $a = array($num, $expmo, $expyr, $noc, $cca, $ccpc);

    return $a;
  }

  public function test_set_get_credit_card_info() {
    $a = $this->test_set_credit_card_info();
    $kv = array_values($a);
    $uv = array_values($this->_customer->getCreditCardInfo());
    $this->assertEquals($kv, $uv);
  }

  public function test_get_uninitialized_notes() {
    $this->assertNull($this->_customer->getNotes());
  }

  public function test_set_notes() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setNotes($str));

    return $str;
  }

  public function test_set_get_notes() {
    $str = $this->test_set_notes();
    $this->assertEquals($str, $this->_customer->getNotes());
  }

  public function test_get_uninitialized_price_level_name() {
    $this->assertNull($this->_customer->getPriceLevelName());
  }

  public function test_set_price_level_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setPriceLevelName($str));

    return $str;
  }

  public function test_set_get_price_level_name() {
    $str = $this->test_set_price_level_name();
    $this->assertEquals($str, $this->_customer->getPriceLevelName());
  }

  public function test_get_uninitialized_price_level_list_id() {
    $this->assertNull($this->_customer->getPriceLevelListID());
  }

  public function test_set_price_level_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setPriceLevelListID($str));

    return $str;
  }

  public function test_set_get_price_level_list_id() {
    $str = $this->test_set_price_level_list_id();
    $this->assertEquals($str, $this->_customer->getPriceLevelListID());
  }

  public function test_get_uninitialized_price_level_application_id() {
    $this->assertNull($this->_customer->getPriceLevelApplicationID());
  }

  public function test_set_price_level_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_customer->setPriceLevelApplicationID($str));

    return $str;
  }

  public function test_set_get_price_level_application_id() {
    $str = $this->test_set_price_level_application_id();
    $this->assertEquals('PriceLevel|ListID|'. $str, $this->_customer->getPriceLevelApplicationID());
  }

  public function test_object_string() {
    $this->assertEquals(QUICKBOOKS_OBJECT_CUSTOMER, $this->_customer->object());
  }
}
?>
