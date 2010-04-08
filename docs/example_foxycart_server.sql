-- phpMyAdmin SQL Dump
-- version 2.11.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2010 at 09:30 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: 'quickbooks_foxycart'
--

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_customer'
--

CREATE TABLE qb_foxycart_customer (
  customer_id int(10) unsigned NOT NULL,
  customer_first_name varchar(128) NOT NULL,
  customer_last_name varchar(128) NOT NULL,
  customer_company varchar(128) NOT NULL,
  customer_address1 varchar(255) NOT NULL,
  customer_address2 varchar(255) NOT NULL,
  customer_city varchar(64) NOT NULL,
  customer_state char(2) NOT NULL,
  customer_postal_code varchar(10) NOT NULL,
  customer_country char(2) NOT NULL,
  customer_phone varchar(15) NOT NULL,
  customer_email varchar(255) NOT NULL,
  customer_ip char(15) NOT NULL,
  shipping_first_name varchar(64) NOT NULL,
  shipping_last_name varchar(64) NOT NULL,
  shipping_company varchar(128) NOT NULL,
  shipping_address1 varchar(128) NOT NULL,
  shipping_address2 varchar(128) NOT NULL,
  shipping_city varchar(64) NOT NULL,
  shipping_state char(2) NOT NULL,
  shipping_postal_code varchar(10) NOT NULL,
  shipping_country char(2) NOT NULL,
  shipping_phone varchar(32) NOT NULL,
  foxycart_customer_discovered_datetime datetime NOT NULL,
  foxycart_customer_discovered_datafeed datetime NOT NULL,
  foxycart_customer_refreshed_datetime datetime DEFAULT NULL,
  foxycart_customer_refreshed_datafeed datetime DEFAULT NULL,
  foxycart_customer_user varchar(32) NOT NULL,
  PRIMARY KEY (customer_id,foxycart_customer_user)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_datafeed'
--

CREATE TABLE qb_foxycart_datafeed (
  foxydata longtext NOT NULL,
  datafeed_version varchar(64) NOT NULL,
  foxycart_datafeed_datetime datetime NOT NULL,
  foxycart_datafeed_user varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_log'
--

CREATE TABLE qb_foxycart_log (
  foxycart_log_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  foxycart_log_msg text NOT NULL,
  foxycart_log_user varchar(32) NOT NULL,
  foxycart_log_datafeed datetime DEFAULT NULL,
  foxycart_log_datetime datetime NOT NULL,
  PRIMARY KEY (foxycart_log_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_product'
--

CREATE TABLE qb_foxycart_product (
  _id int(10) unsigned NOT NULL AUTO_INCREMENT,
  _name varchar(255) NOT NULL,
  _price float NOT NULL,
  _weight float NOT NULL,
  _code varchar(255) NOT NULL,
  _category_code varchar(255) NOT NULL,
  _category_description varchar(255) NOT NULL,
  foxycart_product_discovered_datetime datetime NOT NULL,
  foxycart_product_discovered_datafeed datetime NOT NULL,
  foxycart_product_refreshed_datafeed datetime DEFAULT NULL,
  foxycart_product_refreshed_datetime datetime DEFAULT NULL,
  foxycart_product_user varchar(32) NOT NULL,
  PRIMARY KEY (_id),
  KEY _name (_name,_code,foxycart_product_user)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_transaction'
--

CREATE TABLE qb_foxycart_transaction (
  id int(10) unsigned NOT NULL,
  transaction_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  customer_id int(10) unsigned NOT NULL DEFAULT '0',
  customer_first_name varchar(128) NOT NULL,
  customer_last_name varchar(128) NOT NULL,
  customer_company varchar(128) NOT NULL,
  customer_address1 varchar(255) NOT NULL,
  customer_address2 varchar(255) NOT NULL,
  customer_city varchar(64) NOT NULL,
  customer_state char(2) NOT NULL,
  customer_postal_code varchar(10) NOT NULL,
  customer_country char(2) NOT NULL,
  shipping_first_name varchar(64) NOT NULL,
  shipping_last_name varchar(64) NOT NULL,
  shipping_company varchar(128) NOT NULL,
  shipping_address1 varchar(128) NOT NULL,
  shipping_address2 varchar(128) NOT NULL,
  shipping_city varchar(64) NOT NULL,
  shipping_state char(2) NOT NULL,
  shipping_postal_code varchar(10) NOT NULL,
  shipping_country char(2) NOT NULL,
  shipto_shipping_service_description varchar(128) NOT NULL,
  purchase_order varchar(50) NOT NULL DEFAULT '',
  cc_number_masked varchar(16) DEFAULT NULL,
  cc_type varchar(32) DEFAULT NULL,
  cc_exp_month int(10) unsigned DEFAULT NULL,
  cc_exp_year int(10) unsigned DEFAULT NULL,
  product_total decimal(10,2) NOT NULL DEFAULT '0.00',
  tax_total decimal(10,2) NOT NULL DEFAULT '0.00',
  shipping_total decimal(10,2) NOT NULL DEFAULT '0.00',
  order_total decimal(10,2) NOT NULL DEFAULT '0.00',
  processor_response varchar(255) NOT NULL,
  payment_gateway_type varchar(32) NOT NULL,
  foxycart_transaction_discovered_datetime datetime NOT NULL,
  foxycart_transaction_discovered_datafeed datetime NOT NULL,
  foxycart_transaction_refreshed_datetime datetime DEFAULT NULL,
  foxycart_transaction_refreshed_datafeed datetime DEFAULT NULL,
  foxycart_transaction_user varchar(32) NOT NULL,
  PRIMARY KEY (id,foxycart_transaction_user)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_transaction_customfield'
--

CREATE TABLE qb_foxycart_transaction_customfield (
  _id int(10) unsigned NOT NULL AUTO_INCREMENT,
  transaction_id int(10) unsigned NOT NULL DEFAULT '0',
  customfield_custom_field_name varchar(255) NOT NULL,
  customfield_custom_field_value varchar(255) DEFAULT NULL,
  foxycart_transaction_customfield_user varchar(32) NOT NULL,
  PRIMARY KEY (_id),
  KEY transaction_id (transaction_id,foxycart_transaction_customfield_user)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_transaction_detail'
--

CREATE TABLE qb_foxycart_transaction_detail (
  _id int(10) unsigned NOT NULL AUTO_INCREMENT,
  transaction_id int(10) unsigned NOT NULL DEFAULT '0',
  product__id int(10) unsigned NOT NULL,
  product_name varchar(255) DEFAULT NULL,
  product_price decimal(10,2) NOT NULL DEFAULT '0.00',
  product_quantity int(10) unsigned NOT NULL DEFAULT '0',
  product_weight decimal(10,3) NOT NULL DEFAULT '0.000',
  product_code varchar(50) NOT NULL DEFAULT '',
  downloadable_url varchar(255) DEFAULT NULL,
  subscription_frequency varchar(16) DEFAULT NULL,
  subscription_startdate date DEFAULT NULL,
  product_delivery_type varchar(50) NOT NULL DEFAULT '',
  category_description varchar(100) NOT NULL DEFAULT '',
  category_code varchar(50) NOT NULL DEFAULT '',
  foxycart_transaction_detail_user varchar(32) NOT NULL,
  PRIMARY KEY (_id),
  KEY transaction_id (transaction_id,foxycart_transaction_detail_user)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_transaction_detail_option'
--

CREATE TABLE qb_foxycart_transaction_detail_option (
  _id int(10) unsigned NOT NULL AUTO_INCREMENT,
  transaction_detail__id int(10) unsigned NOT NULL DEFAULT '0',
  product_option_name varchar(100) NOT NULL DEFAULT '',
  product_option_value varchar(255) NOT NULL DEFAULT '',
  price_mod decimal(10,2) NOT NULL DEFAULT '0.00',
  weight_mod decimal(10,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (_id),
  KEY transaction_detail_id (transaction_detail__id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_transaction_discount'
--

CREATE TABLE qb_foxycart_transaction_discount (
  _id int(10) unsigned NOT NULL AUTO_INCREMENT,
  transaction_id int(10) unsigned NOT NULL DEFAULT '0',
  discount_code varchar(255) NOT NULL,
  discount_name varchar(255) DEFAULT NULL,
  discount_amount float NOT NULL,
  discount_display varchar(64) NOT NULL,
  discount_coupon_discount_type varchar(64) NOT NULL,
  discount_coupon_discount_details varchar(255) NOT NULL,
  foxycart_transaction_discount_user varchar(32) NOT NULL,
  PRIMARY KEY (_id),
  KEY transaction_id (transaction_id,foxycart_transaction_discount_user)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_foxycart_user'
--

CREATE TABLE qb_foxycart_user (
  foxycart_user_name varchar(32) NOT NULL,
  foxycart_user_firstname varchar(64) NOT NULL,
  foxycart_user_lastname varchar(64) NOT NULL,
  foxycart_user_email varchar(128) NOT NULL,
  foxycart_user_key varchar(64) NOT NULL,
  foxycart_user_customer_format varchar(255) NOT NULL,
  foxycart_user_customer_customertype_format varchar(255) DEFAULT NULL,
  foxycart_user_order_class_format varchar(255) DEFAULT NULL,
  foxycart_user_order_memo_format varchar(128) NOT NULL,
  foxycart_user_order_autoincrement tinyint(1) unsigned NOT NULL DEFAULT '0',
  foxycart_user_order_unitofmeasure tinyint(1) unsigned NOT NULL DEFAULT '0',
  foxycart_user_order_as varchar(32) NOT NULL,
  foxycart_user_item_format varchar(255) NOT NULL,
  foxycart_user_item_account_income varchar(255) NOT NULL,
  foxycart_user_item_account_cogs varchar(255) NOT NULL,
  foxycart_user_item_account_asset varchar(255) NOT NULL,
  foxycart_user_item_account_discount varchar(255) NOT NULL,
  foxycart_user_item_parenting tinyint(1) unsigned NOT NULL DEFAULT '0',
  foxycart_user_item_as varchar(32) DEFAULT NULL,
  foxycart_user_shipping_format varchar(255) DEFAULT NULL,
  foxycart_user_handling_format varchar(255) DEFAULT NULL,
  foxycart_user_discount_format varchar(255) DEFAULT NULL,
  foxycart_user_relay text,
  foxycart_user_status char(1) DEFAULT NULL,
  foxycart_user_enabled_datetime datetime DEFAULT NULL,
  foxycart_user_created_datetime datetime NOT NULL,
  foxycart_user_modified_datetime datetime DEFAULT NULL,
  foxycart_user_notes text NOT NULL,
  PRIMARY KEY (foxycart_user_name)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
