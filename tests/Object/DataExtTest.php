<?php

/**
 *
 * PHPUnit Test
 * 
 * @author Jason Hill, DharmaTech <jason@dharmatech.org>
 */

require_once 'PHPUnit/Framework.php';
require_once 'QuickBooks.php';

class DataExtTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->_dataext = new QuickBooks_Object_DataExt();
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


  public function test_get_uninitialized_owner_id() {
    $this->assertNull($this->_dataext->getOwnerID());
  }

  public function test_set_owner_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setOwnerID($str));

    return $str;
  }

  public function test_set_get_owner_id() {
    $str = $this->test_set_owner_id();
    $this->assertEquals($str, $this->_dataext->getOwnerID());
  }

  public function test_get_uninitialized_data_ext_name() {
    $this->assertNull($this->_dataext->getDataExtName());
  }

  public function test_set_data_ext_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setDataExtName($str));

    return $str;
  }

  public function test_set_get_data_ext_name() {
    $str = $this->test_set_data_ext_name();
    $this->assertEquals($str, $this->_dataext->getDataExtName());
  }

  public function test_get_uninitialized_list_data_ext_type() {
    $this->assertNull($this->_dataext->getListDataExtType());
  }

  public function test_set_list_data_ext_type() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setListDataExtType($str));

    return $str;
  }

  public function test_set_get_list_data_ext_type() {
    $str = $this->test_set_list_data_ext_type();
    $this->assertEquals($str, $this->_dataext->getListDataExtType());
  }

  public function test_get_uninitialized_list_obj_list_id() {
    $this->assertNull($this->_dataext->getListObjListID());
  }

  public function test_set_list_obj_list_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setListObjListID($str));

    return $str;
  }

  public function test_set_get_list_obj_list_id() {
    $str = $this->test_set_list_obj_list_id();
    $this->assertEquals($str, $this->_dataext->getListObjListID());
  }

  public function test_get_uninitialized_list_obj_name() {
    $this->assertNull($this->_dataext->getListObjName());
  }

  public function test_set_list_obj_name() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setListObjName($str));

    return $str;
  }

  public function test_set_get_list_obj_name() {
    $str = $this->test_set_list_obj_name();
    $this->assertEquals($str, $this->_dataext->getListObjName());
  }

  public function test_get_uninitialized_list_obj_application_id() {
    $this->assertNull($this->_dataext->getListObjApplicationID());
  }

  public function test_set_list_obj_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setListObjApplicationID($str, $str));

    return $str;
  }

  public function test_set_get_list_obj_application_id() {
    $str = $this->test_set_list_obj_application_id();
    $this->assertEquals($str .'|ListID|'. $str, $this->_dataext->getListObjApplicationID());
  }

  public function test_get_uninitialized_txn_data_ext_type() {
    $this->assertNull($this->_dataext->getTxnDataExtType());
  }

  public function test_set_txn_data_ext_type() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setTxnDataExtType($str));

    return $str;
  }

  public function test_set_get_txn_data_ext_type() {
    $str = $this->test_set_txn_data_ext_type();
    $this->assertEquals($str, $this->_dataext->getTxnDataExtType());
  }

  public function test_get_uninitialized_txn_id() {
    $this->assertNull($this->_dataext->getTxnID());
  }

  public function test_set_txn_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setTxnID($str));

    return $str;
  }

  public function test_set_get_txn_id() {
    $str = $this->test_set_txn_id();
    $this->assertEquals($str, $this->_dataext->getTxnID());
  }

  public function test_get_uninitialized_txn_application_id() {
    $this->assertNull($this->_dataext->getTxnApplicationID());
  }

  public function test_set_txn_application_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setTxnApplicationID($str));

    return $str;
  }

  public function test_set_get_txn_application_id() {
    $str = $this->test_set_txn_application_id();
    $this->assertEquals('Transaction|TxnID|'. $str, $this->_dataext->getTxnApplicationID());
  }

  public function test_get_uninitialized_txn_line_id() {
    $this->assertNull($this->_dataext->getTxnLineID());
  }

  public function test_set_txn_line_id() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setTxnLineID($str));

    return $str;
  }

  public function test_set_get_txn_line_id() {
    $str = $this->test_set_txn_line_id();
    $this->assertEquals($str, $this->_dataext->getTxnLineID());
  }

  public function test_get_uninitialized_other_data_ext_type() {
    $this->assertNull($this->_dataext->getOtherDataExtType());
  }

  public function test_set_other_data_ext_type() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setOtherDataExtType($str));

    return $str;
  }

  public function test_set_get_other_data_ext_type() {
    $str = $this->test_set_other_data_ext_type();
    $this->assertEquals($str, $this->_dataext->getOtherDataExtType());
  }

  public function test_get_uninitialized_data_ext_value() {
    $this->assertNull($this->_dataext->getDataExtValue());
  }

  public function test_set_data_ext_value() {
    $str = $this->random_chars();
    $this->assertTrue($this->_dataext->setDataExtValue($str));

    return $str;
  }

  public function test_set_get_data_ext_value() {
    $str = $this->test_set_data_ext_value();
    $this->assertEquals($str, $this->_dataext->getDataExtValue());
  }
}

