<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class EmployeeTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_employee = new QuickBooks_Object_Employee();
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
    $this->assertNull($this->_employee->getListID());
  }

  public function test_set_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setListID($str));

    return $str;
  }

  public function test_set_get_list_id() {
    $str = $this->test_set_list_id();
    $this->assertEquals($str, $this->_employee->getListID());
  }

  public function test_get_uninitialized_name() {
    $this->assertNull($this->_employee->getName());
  }

  public function test_set_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setName($str));

    return $str;
  }

  public function test_set_get_name() {
    $str = $this->test_set_name();
    $this->assertEquals($str, $this->_employee->getName());
  }

  public function test_get_uninitialized_first_name() {
    $this->assertNull($this->_employee->getFirstName());
  }

  public function test_set_first_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setFirstName($str));

    return $str;
  }

  public function test_set_get_first_name() {
    $str = $this->test_set_first_name();
    $this->assertEquals($str, $this->_employee->getFirstName());
  }

  public function test_get_uninitialized_last_name() {
    $this->assertNull($this->_employee->getLastName());
  }

  public function test_set_last_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setLastName($str));

    return $str;
  }

  public function test_set_get_last_name() {
    $str = $this->test_set_last_name();
    $this->assertEquals($str, $this->_employee->getLastName());
  }

  public function test_get_uninitialized_middle_name() {
    $this->assertNull($this->_employee->getMiddleName());
  }

  public function test_set_middle_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setMiddleName($str));

    return $str;
  }

  public function test_set_get_middle_name() {
    $str = $this->test_set_middle_name();
    $this->assertEquals($str, $this->_employee->getMiddleName());
  }

  public function test_get_uninitialized_employee_address() {
    $this->assertEquals(array(), $this->_employee->getEmployeeAddress());
  }

  public function test_set_employee_address() {
    $str = $this->random_chars();
    //$this->assertTrue($this->_employee->setEmployeeAddress($str));
    $this->markTestIncomplete('This test has not been implemented yet.');

    //return $str;
  }

  public function test_set_get_employee_address() {
    $str = $this->test_set_employee_address();
    $this->assertEquals($str, $this->_employee->getEmployeeAddress());
  }

  public function test_get_uninitialized_phone() {
    $this->assertNull($this->_employee->getPhone());
  }

  public function test_set_phone() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setPhone($str));

    return $str;
  }

  public function test_set_get_phone() {
    $str = $this->test_set_phone();
    $this->assertEquals($str, $this->_employee->getPhone());
  }

  public function test_get_uninitialized_alt_phone() {
    $this->assertNull($this->_employee->getAltPhone());
  }

  public function test_set_alt_phone() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setAltPhone($str));

    return $str;
  }

  public function test_set_get_alt_phone() {
    $str = $this->test_set_alt_phone();
    $this->assertEquals($str, $this->_employee->getAltPhone());
  }

  public function test_get_uninitialized_fax() {
    $this->assertNull($this->_employee->getFax());
  }

  public function test_set_fax() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setFax($str));

    return $str;
  }

  public function test_set_get_fax() {
    $str = $this->test_set_fax();
    $this->assertEquals($str, $this->_employee->getFax());
  }

  public function test_get_uninitialized_email() {
    $this->assertNull($this->_employee->getEmail());
  }

  public function test_set_email() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setEmail($str));

    return $str;
  }

  public function test_set_get_email() {
    $str = $this->test_set_email();
    $this->assertEquals($str, $this->_employee->getEmail());
  }

  public function test_get_uninitialized_salutation() {
    $this->assertNull($this->_employee->getSalutation());
  }

  public function test_set_salutation() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setSalutation($str));

    return $str;
  }

  public function test_set_get_salutation() {
    $str = $this->test_set_salutation();
    $this->assertEquals($str, $this->_employee->getSalutation());
  }

  public function test_get_uninitialized_notes() {
    $this->assertNull($this->_employee->getNotes());
  }

  public function test_set_notes() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setNotes($str));

    return $str;
  }

  public function test_set_get_notes() {
    $str = $this->test_set_notes();
    $this->assertEquals($str, $this->_employee->getNotes());
  }

  public function test_get_uninitialized_mobile() {
    $this->assertNull($this->_employee->getMobile());
  }

  public function test_set_mobile() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setMobile($str));

    return $str;
  }

  public function test_set_get_mobile() {
    $str = $this->test_set_mobile();
    $this->assertEquals($str, $this->_employee->getMobile());
  }

  public function test_get_uninitialized_pager() {
    $this->assertNull($this->_employee->getPager());
  }

  public function test_set_pager() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setPager($str));

    return $str;
  }

  public function test_set_get_pager() {
    $str = $this->test_set_pager();
    $this->assertEquals($str, $this->_employee->getPager());
  }

  public function test_get_uninitialized_gender() {
    $this->assertNull($this->_employee->getGender());
  }

  public function test_set_gender() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setGender($str));

    return $str;
  }

  public function test_set_get_gender() {
    $str = $this->test_set_gender();
    $this->assertEquals($str, $this->_employee->getGender());
  }

  public function test_get_uninitialized_birth_date() {
    $this->assertNull($this->_employee->getBirthDate());
  }

  public function test_set_birth_date() {
    $str = $this->random_chars();
    $this->assertTrue($this->_employee->setBirthDate($str));

    return $str;
  }

  public function test_set_get_birth_date() {
    $str = $this->test_set_birth_date();
    $this->assertEquals('1969-12-31', $this->_employee->getBirthDate());
  }
}

