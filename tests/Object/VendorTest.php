<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class VendorTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_vendor = new QuickBooks_Object_Vendor();
  }

  public function random_chars($len = 0) {
    if ($len == 0) {
      $len = rand(5,20);
    }

    return substr(md5(microtime()), $len);
  }


  public function test_get_uninitialized_list_id() {
    $this->assertNull($this->_vendor->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_vendor->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_vendor->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_vendor->getName());
  }

  public function test_get_uninitialized_full_name() {
    $this->assertNull($this->_vendor->getFullName());
  }

  public function test_set_full_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setFullName($str));

    return $str;
  }

  public function test_set_get_full_name() {
    $str = $this->test_set_full_name();
    $this->assertEquals($str, $this->_vendor->getFullName());
  }

  public function test_get_uninitialized_is_active() {
    $this->assertNull($this->_vendor->getIsActive());
  }

  public function test_set_is_active() {
    $str = TRUE;
    $this->assertTrue($this->_vendor->setIsActive($str));

    return $str;
  }

  public function test_set_get_is_active() {
    $str = $this->test_set_is_active();
    $this->assertEquals($str, $this->_vendor->getIsActive());
  }

  public function test_get_uninitialized_company_name() {
    $this->assertNull($this->_vendor->getCompanyName());
  }

  public function test_set_company_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setCompanyName($str));

    return $str;
  }

  public function test_set_get_company_name() {
    $str = $this->test_set_company_name();
    $this->assertEquals($str, $this->_vendor->getCompanyName());
  }

  public function test_get_uninitialized_first_name() {
    $this->assertNull($this->_vendor->getFirstName());
  }

  public function test_set_first_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setFirstName($str));

    return $str;
  }

  public function test_set_get_first_name() {
    $str = $this->test_set_first_name();
    $this->assertEquals($str, $this->_vendor->getFirstName());
  }

  public function test_get_uninitialized_last_name() {
    $this->assertNull($this->_vendor->getLastName());
  }

  public function test_set_last_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setLastName($str));

    return $str;
  }

  public function test_set_get_last_name() {
    $str = $this->test_set_last_name();
    $this->assertEquals($str, $this->_vendor->getLastName());
  }

  public function test_get_uninitialized_middle_name() {
    $this->assertNull($this->_vendor->getMiddleName());
  }

  public function test_set_middle_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setMiddleName($str));

    return $str;
  }

  public function test_set_get_middle_name() {
    $str = $this->test_set_middle_name();
    $this->assertEquals($str, $this->_vendor->getMiddleName());
  }

  public function test_get_uninitialized_vendor_address() {
    $this->assertEquals(array(), $this->_vendor->getVendorAddress());
  }

  public function test_set_vendor_address() {
    $addr1 = $this->random_chars();
    $addr2 = $this->random_chars();
    $addr3 = $this->random_chars();
    $addr4 = $this->random_chars();
    $addr5 = $this->random_chars();
    $city = $this->random_chars();
    $state = $this->random_chars();
    $postalcode = $this->random_chars();
    $country = $this->random_chars();
    $note = $this->random_chars();

    //$this->assertTrue($this->_vendor->setVendorAddress($addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $postalcode, $country, $note));
    $this->markTestIncomplete('This test has not been implemented yet.');
    $a = array($addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note);

    // return $a; 
  }

  public function test_set_get_vendor_address() {
    $str = $this->test_set_vendor_address();
    $this->assertEquals($str, $this->_vendor->getVendorAddress());
  }

  public function test_get_uninitialized_phone() {
    $this->assertNull($this->_vendor->getPhone());
  }

  public function test_set_phone() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setPhone($str));

    return $str;
  }

  public function test_set_get_phone() {
    $str = $this->test_set_phone();
    $this->assertEquals($str, $this->_vendor->getPhone());
  }

  public function test_get_uninitialized_alt_phone() {
    $this->assertNull($this->_vendor->getAltPhone());
  }

  public function test_set_alt_phone() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setAltPhone($str));

    return $str;
  }

  public function test_set_get_alt_phone() {
    $str = $this->test_set_alt_phone();
    $this->assertEquals($str, $this->_vendor->getAltPhone());
  }

  public function test_get_uninitialized_fax() {
    $this->assertNull($this->_vendor->getFax());
  }

  public function test_set_fax() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setFax($str));

    return $str;
  }

  public function test_set_get_fax() {
    $str = $this->test_set_fax();
    $this->assertEquals($str, $this->_vendor->getFax());
  }

  public function test_get_uninitialized_email() {
    $this->assertNull($this->_vendor->getEmail());
  }

  public function test_set_email() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setEmail($str));

    return $str;
  }

  public function test_set_get_email() {
    $str = $this->test_set_email();
    $this->assertEquals($str, $this->_vendor->getEmail());
  }

  public function test_get_uninitialized_contact() {
    $this->assertNull($this->_vendor->getContact());
  }

  public function test_set_contact() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setContact($str));

    return $str;
  }

  public function test_set_get_contact() {
    $str = $this->test_set_contact();
    $this->assertEquals($str, $this->_vendor->getContact());
  }

  public function test_get_uninitialized_alt_contact() {
    $this->assertNull($this->_vendor->getAltContact());
  }

  public function test_set_alt_contact() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setAltContact($str));

    return $str;
  }

  public function test_set_get_alt_contact() {
    $str = $this->test_set_alt_contact();
    $this->assertEquals($str, $this->_vendor->getAltContact());
  }

  public function test_get_uninitialized_salutation() {
    $this->assertNull($this->_vendor->getSalutation());
  }

  public function test_set_salutation() {
    $str = $this->random_chars();
    $this->assertTrue($this->_vendor->setSalutation($str));

    return $str;
  }

  public function test_set_get_salutation() {
    $str = $this->test_set_salutation();
    $this->assertEquals($str, $this->_vendor->getSalutation());
  }
}

