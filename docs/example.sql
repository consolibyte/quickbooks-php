-- phpMyAdmin SQL Dump
-- version 2.11.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 28, 2009 at 07:35 AM
-- Server version: 5.0.67
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: 'quickbooks_import'
--

-- --------------------------------------------------------

--
-- Table structure for table 'qb_example_customer'
--

CREATE TABLE IF NOT EXISTS qb_example_customer (
  ListID varchar(40) NOT NULL,
  TimeCreated datetime NOT NULL,
  TimeModified datetime NOT NULL,
  `Name` varchar(50) NOT NULL,
  FullName varchar(255) NOT NULL,
  FirstName varchar(40) NOT NULL,
  MiddleName varchar(10) NOT NULL,
  LastName varchar(40) NOT NULL,
  Contact varchar(50) NOT NULL,
  ShipAddress_Addr1 varchar(50) NOT NULL,
  ShipAddress_Addr2 varchar(50) NOT NULL,
  ShipAddress_City varchar(50) NOT NULL,
  ShipAddress_State varchar(25) NOT NULL,
  ShipAddress_Province varchar(25) NOT NULL,
  ShipAddress_PostalCode varchar(16) NOT NULL,
  PRIMARY KEY  (ListID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Table structure for table 'qb_example_estimate'
--

CREATE TABLE IF NOT EXISTS qb_example_estimate (
  TxnID varchar(40) NOT NULL,
  TimeCreated datetime NOT NULL,
  TimeModified datetime NOT NULL,
  RefNumber varchar(16) NOT NULL,
  Customer_ListID varchar(40) NOT NULL,
  Customer_FullName varchar(255) NOT NULL,
  ShipAddress_Addr1 varchar(50) NOT NULL,
  ShipAddress_Addr2 varchar(50) NOT NULL,
  ShipAddress_City varchar(50) NOT NULL,
  ShipAddress_State varchar(25) NOT NULL,
  ShipAddress_Province varchar(25) NOT NULL,
  ShipAddress_PostalCode varchar(16) NOT NULL,
  BalanceRemaining float NOT NULL,
  PRIMARY KEY  (TxnID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_example_estimate_lineitem'
--

CREATE TABLE IF NOT EXISTS qb_example_estimate_lineitem (
  TxnID varchar(40) NOT NULL,
  TxnLineID varchar(40) NOT NULL,
  Item_ListID varchar(40) NOT NULL,
  Item_FullName varchar(255) NOT NULL,
  Descrip text NOT NULL,
  Quantity int(10) unsigned NOT NULL,
  Rate float NOT NULL,
  PRIMARY KEY  (TxnID,TxnLineID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_example_invoice'
--

CREATE TABLE IF NOT EXISTS qb_example_invoice (
  TxnID varchar(40) NOT NULL,
  TimeCreated datetime NOT NULL,
  TimeModified datetime NOT NULL,
  RefNumber varchar(16) NOT NULL,
  Customer_ListID varchar(40) NOT NULL,
  Customer_FullName varchar(255) NOT NULL,
  ShipAddress_Addr1 varchar(50) NOT NULL,
  ShipAddress_Addr2 varchar(50) NOT NULL,
  ShipAddress_City varchar(50) NOT NULL,
  ShipAddress_State varchar(25) NOT NULL,
  ShipAddress_Province varchar(25) NOT NULL,
  ShipAddress_PostalCode varchar(16) NOT NULL,
  BalanceRemaining float NOT NULL,
  PRIMARY KEY  (TxnID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_example_invoice_lineitem'
--

CREATE TABLE IF NOT EXISTS qb_example_invoice_lineitem (
  TxnID varchar(40) NOT NULL,
  TxnLineID varchar(40) NOT NULL,
  Item_ListID varchar(40) NOT NULL,
  Item_FullName varchar(255) NOT NULL,
  Descrip text NOT NULL,
  Quantity int(10) unsigned NOT NULL,
  Rate float NOT NULL,
  PRIMARY KEY  (TxnID,TxnLineID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


--
-- Table structure for table 'qb_example_item'
--

CREATE TABLE IF NOT EXISTS qb_example_item (
  ListID varchar(40) NOT NULL,
  TimeCreated datetime NOT NULL,
  TimeModified datetime NOT NULL,
  `Name` varchar(50) NOT NULL,
  FullName varchar(255) NOT NULL,
  `Type` varchar(40) NOT NULL,
  Parent_ListID varchar(40) NOT NULL,
  Parent_FullName varchar(255) NOT NULL,
  ManufacturerPartNumber varchar(40) NOT NULL,
  SalesTaxCode_ListID varchar(40) NOT NULL,
  SalesTaxCode_FullName varchar(255) NOT NULL,
  BuildPoint varchar(40) NOT NULL,
  ReorderPoint varchar(40) NOT NULL,
  QuantityOnHand int(10) unsigned NOT NULL,
  AverageCost float NOT NULL,
  QuantityOnOrder int(10) unsigned NOT NULL,
  QuantityOnSalesOrder int(10) unsigned NOT NULL,
  TaxRate varchar(40) NOT NULL,
  SalesPrice float NOT NULL,
  SalesDesc text NOT NULL,
  PurchaseCost float NOT NULL,
  PurchaseDesc text NOT NULL,
  PrefVendor_ListID varchar(40) NOT NULL,
  PrefVendor_FullName varchar(255) NOT NULL,
  PRIMARY KEY  (ListID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_example_salesorder'
--

CREATE TABLE IF NOT EXISTS qb_example_salesorder (
  TxnID varchar(40) NOT NULL,
  TimeCreated datetime NOT NULL,
  TimeModified datetime NOT NULL,
  RefNumber varchar(16) NOT NULL,
  Customer_ListID varchar(40) NOT NULL,
  Customer_FullName varchar(255) NOT NULL,
  ShipAddress_Addr1 varchar(50) NOT NULL,
  ShipAddress_Addr2 varchar(50) NOT NULL,
  ShipAddress_City varchar(50) NOT NULL,
  ShipAddress_State varchar(25) NOT NULL,
  ShipAddress_Province varchar(25) NOT NULL,
  ShipAddress_PostalCode varchar(16) NOT NULL,
  BalanceRemaining float NOT NULL,
  PRIMARY KEY  (TxnID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'qb_example_salesorder_lineitem'
--

CREATE TABLE IF NOT EXISTS qb_example_salesorder_lineitem (
  TxnID varchar(40) NOT NULL,
  TxnLineID varchar(40) NOT NULL,
  Item_ListID varchar(40) NOT NULL,
  Item_FullName varchar(255) NOT NULL,
  Descrip text NOT NULL,
  Quantity int(10) unsigned NOT NULL,
  Rate float NOT NULL,
  PRIMARY KEY  (TxnID,TxnLineID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
