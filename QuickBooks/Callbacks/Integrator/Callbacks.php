<?php

/**
 * Callback methods for the server integrator components
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * QuickBooks API object-oriented classes
 */
QuickBooks_Loader::load('/QuickBooks/API.php');

/**
 * API singleton classes
 */
QuickBooks_Loader::load('/QuickBooks/API/Singleton.php');

/**
 * Server integrator class
 */
QuickBooks_Loader::load('/QuickBooks/Server/Integrator.php');

/**
 * Callback methods for the server integrator 
 */
class QuickBooks_Callbacks_Integrator_Callbacks
{
	static public function onAuthenticate($requestID, $user, $hook, &$err, $hook_data, $callback_config)
	{
		// Get an API instance
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		$module = get_class($Integrator);
		
		// This is the *very first time the integration was run!* 
		//	Orders *will not* be fetched from before this time! 
		$type = null;
		$opts = null;
		//$first_datetime = $API->configRead(get_class($this), 'initial', $type, $opts);
		$first_datetime = $API->configRead($module, 'initial', $type, $opts);
		
		$first = false;
		if (!$first_datetime)
		{
			$first_datetime = date('Y-m-d H:i:s');
			$API->configWrite($module, 'initial', $first_datetime);
			
			$first = true;
		}
		
		// The is the last time the integration was run!
		$type = null;
		$opts = null;
		$last_datetime = $API->configRead($module, 'datetime', $type, $opts);
		
		if (!$last_datetime)
		{
			$last_datetime = date('Y-m-d H:i:s');
		}
		
		/*
		if (!empty($this->_integrator_config['debug_datetime']))
		{
			$last_datetime = date('Y-m-d H:i:s', strtotime($this->_integrator_config['debug_datetime']));
			$first_datetime = date('Y-m-d H:i:s', strtotime($this->_integrator_config['debug_datetime']));
		}
		*/
		
		$force = false;
		/*
		$force = false;
		if (isset($_GET['OrderID']))
		{
			$force = true;
		}
		*/
		
		$this_datetime = date('Y-m-d H:i:s');
		$API->log('Integration handle() has started: [first: ' . $first_datetime . '], [last: ' . $last_datetime . '], [this: ' . $this_datetime . ']', QUICKBOOKS_LOG_VERBOSE);
		
		/*
		if (strtotime($this_datetime) - strtotime($last_datetime) > QUICKBOOKS_SERVER_INTEGRATOR_RECUR or 
			$first or 
			$force)
		{
			$API->log('Last integration timestamp: ' . $last_datetime . ', current timestamp: ' . $this_datetime, QUICKBOOKS_LOG_VERBOSE);
			*/
			
			// Do some integration routines
			QuickBooks_Callbacks_Integrator_Callbacks::_integrate($last_datetime, $first_datetime, $first);
			
			$API->configWrite($module, 'datetime', $this_datetime);
		/*}
		else
		{
			$API->log('Integration was not due yet (only ' . (strtotime($this_datetime) - strtotime($last_datetime)) . ' seconds since last run)', QUICKBOOKS_LOG_DEVELOP);
		}
		*/
	}
	
	/**
	 * 
	 * 
	 * @param string $last_datetime
	 * @param boolean $first_time_running
	 * @return boolean
	 */
	static protected function _integrate($last_datetime, $first_datetime, $first_time_running)
	{
		// Integrator instance
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		// Generics which *must* be present
		if ($Shipping = $Integrator->getGenericShipping())
		{ 
			QuickBooks_Callbacks_Integrator_Callbacks::_integrateShipping($Shipping);
		}
		
		/*
		if ($Handling = $Integrator->getGenericHandling())
		{
			$this->_integrateHandling($Handling);
		}
		*/
		
		if ($Discount = $Integrator->getGenericDiscount())
		{
			QuickBooks_Callbacks_Integrator_Callbacks::_integrateDiscounts($Discount);
		}
		
		/*
		if ($Coupon = $Integrator->getGenericCoupon())
		{
			$this->_integrateCoupons($Coupon);
		}
		*/
		
		//$customers = $Integrator>listNewCustomersSince($last_datetime, $first_datetime, $first_time_running);
		//QuickBooks_Callbacks_Integrator_Callbacks::_integrateNewCustomers($customers);
		
		// 
		$orders = $Integrator->listNewOrdersSince($last_datetime, $first_datetime, $first_time_running);
		QuickBooks_Callbacks_Integrator_Callbacks::_integrateNewOrders($orders);
		
		// 
		$estimates = $Integrator->listNewEstimatesSince($last_datetime, $first_datetime, $first_time_running);
		QuickBooks_Callbacks_Integrator_Callbacks::_integrateNewEstimates($estimates);
		
		// 
		QuickBooks_Callbacks_Integrator_Callbacks::_pullNewAccounts($last_datetime, $first_datetime, $first_time_running);
		
		// 
		QuickBooks_Callbacks_Integrator_Callbacks::_pullNewClasses($last_datetime, $first_datetime, $first_time_running);
		
		// 
		QuickBooks_Callbacks_Integrator_Callbacks::_pullNewPaymentMethods($last_datetime, $first_datetime, $first_time_running);
		
		// 
		QuickBooks_Callbacks_Integrator_Callbacks::_pullNewCustomerTypes($last_datetime, $first_datetime, $first_time_running);
		
		// 
		QuickBooks_Callbacks_Integrator_Callbacks::_pullNewShipMethods($last_datetime, $first_datetime, $first_time_running);
		
		// 
		QuickBooks_Callbacks_Integrator_Callbacks::_pullNewSalesTaxItems($last_datetime, $first_datetime, $first_time_running);
		
		// 
		QuickBooks_Callbacks_Integrator_Callbacks::_pullNewSalesTaxGroupItems($last_datetime, $first_datetime, $first_time_running);
		
		//
		QuickBooks_Callbacks_Integrator_Callbacks::_pullNewSalesTaxCodes($last_datetime, $first_datetime, $first_time_running);
		
		// 
		QuickBooks_Callbacks_Integrator_Callbacks::_pullNewUnitOfMeasureSets($last_datetime, $first_datetime, $first_time_running);
		
		// 
		//QuickBooks_Callbacks_Integrator_Callbacks::_pullNewOrders($last_datetime, $first_datetime, $first_time_running);
		
		// 
		//QuickBooks_Callbacks_Integrator_Callbacks::_pullNewEstimates($last_datetime, $first_datetime, $first_time_running);
	}
	
	/**
	 * 
	 * 
	 */
	static protected function _pullNewAccounts($datetime, $first_datetime, $first_time_running)
	{
		// Get the API instance
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (true) //$first_time_running)
		{
			// A realllly long time ago
			$datetime = '1983-01-02 00:00:01';
		}
			
		$API->log('Pulling in accounts modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
		
		return $API->listAccountsModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listAccountsModifiedAfter');
	}

	/**
	 * 
	 * 
	 * 
	 */
	static protected function _pullNewClasses($datetime, $first_datetime, $first_time_running)
	{
		// Get the API instance
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (true) // $first_time_running)
		{
			// A realllly long time ago
			$datetime = '1983-01-02 00:00:01';
		}
			
		$API->log('Pulling in classes modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
		
		return $API->listClassesModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listClassesModifiedAfter');
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	static protected function _pullNewPaymentMethods($datetime, $first_datetime, $first_time_running)
	{
		// Get the API instance
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (true) // $first_time_running)
		{
			// A realllly long time ago
			$datetime = '1983-01-02 00:00:01';
		}
			
		$API->log('Pulling in payment methods modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
		
		return $API->listPaymentMethodsModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listPaymentMethodsModifiedAfter');
	}
	
	static protected function _pullNewSalesTaxItems($datetime, $first_datetime, $first_time_running)
	{
		// Get the API instance
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (true) // $first_time_running)
		{
			// A realllly long time ago
			$datetime = '1983-01-02 00:00:01';
		}
			
		$API->log('Pulling in sales tax items modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
		
		return $API->listSalesTaxItemsModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listSalesTaxItemsModifiedAfter');		
	}

	static protected function _pullNewSalesTaxGroupItems($datetime, $first_datetime, $first_time_running)
	{
		// Get the API instance
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (true) // $first_time_running)
		{
			// A realllly long time ago
			$datetime = '1983-01-02 00:00:01';
		}
			
		$API->log('Pulling in sales tax *group* items modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
		
		return $API->listSalesTaxGroupItemsModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listSalesTaxGroupItemsModifiedAfter');		
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	static protected function _pullNewShipMethods($datetime, $first_datetime, $first_time_running)
	{
		// Get the API instance
		$API = QuickBooks_API_Singleton::getInstance();

		if (true) // $first_time_running)
		{
			// A realllly long time ago
			$datetime = '1983-01-02 00:00:01';
		}
			
		$API->log('Pulling in ship methods modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
		
		return $API->listShipMethodsModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listShipMethodsModifiedAfter');
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	static protected function _pullNewCustomerTypes($datetime, $first_datetime, $first_time_running)
	{
		// Get the API instance
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (true) // $first_time_running)
		{
			// A realllly long time ago
			$datetime = '1983-01-02 00:00:01';
		}
			
		$API->log('Pulling in customer types modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
		
		return $API->listCustomerTypesModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listCustomerTypesModifiedAfter');
	}

	static protected function _pullNewUnitOfMeasureSets($datetime, $first_datetime, $first_time_running)
	{
		// Get the API instance
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (true) // $first_time_running)
		{
			// A realllly long time ago
			$datetime = '1983-01-02 00:00:01';
		}
			
		$API->log('Pulling in unit of measure sets modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
		
		return $API->listUnitOfMeasureSetsModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listUnitOfMeasureSetsModifiedAfter');
	}

	static protected function _pullNewSalesTaxCodes($datetime, $first_datetime, $first_time_running)
	{
		// Get the API instance
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (true) // $first_time_running)
		{
			// A realllly long time ago
			$datetime = '1983-01-02 00:00:01';
		}
			
		$API->log('Pulling in sales tax codes modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
		
		return $API->listSalesTaxCodesModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listSalesTaxCodesModifiedAfter');
	}	
	
	/**
	 * 
	 * 
	 * @param string $datetime
	 * @return boolean
	 */
	static protected function _pullNewEstimates($datetime, $first_datetime, $first_time_running)
	{
		/*
		if ($this->_integrator_config['pull_estimates'])
		{
			// Use the lookback value... 
			$max = max(strtotime($datetime) - QUICKBOOKS_INTEGRATOR_LOOKBACK, strtotime($first_datetime));
			$datetime = date('Y-m-d H:i:s', $max);
			
			$API->log('Pulling in estimates modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
			
			return $API->listEstimatesModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listEstimatesModifiedAfter');
		}
		*/
		
		return true;
	}
	
	/**
	 * 
	 * 
	 * @param string $datetime
	 * @param string $first_datetime
	 * @param boolean $first_time_running
	 */
	static protected function _pullNewOrders($datetime, $first_datetime, $first_time_running)
	{
		/*
		if ($this->_integrator_config['pull_orders'])
		{
			// Use the lookback value... 
			$max = max(strtotime($datetime) - QUICKBOOKS_INTEGRATOR_LOOKBACK, strtotime($first_datetime));
			$datetime = date('Y-m-d H:i:s', $max);
			
			$API->log('Pulling in invoices modified since ' . $datetime, QUICKBOOKS_LOG_VERBOSE);
			
			return $API->listInvoicesModifiedAfter($datetime, 'QuickBooks_Callbacks_Integrator_Callbacks::listInvoicesModifiedAfter');			
		}
		*/
		
		return true;
	}
	
	static protected function _integrateNewCustomers($customers)
	{
		foreach ($customers as $CustomerID)
		{
			if (true)
			{
				// Try to fetch the customer by name
				$API->getCustomerByName($Integrator->getCustomerNameForQuery($CustomerID), 'QuickBooks_Callbacks_Integrator_Callbacks::getCustomerByName', $CustomerID);
			}
			/*else
			{
				// Add the customer to QuickBooks
				
				QuickBooks_Callbacks_Integrator_Callbacks::integrateAddCustomer($CustomerID);
				//$extras = $Integrator->getCustomerExtras($CustomerID, __FILE__, __LINE__);
				//$Customer = $Integrator->getCustomer($CustomerID, __FILE__, __LINE__);
				//$this->_integrateCustomer($Customer, $CustomerID, $extras);
			}*/
		}
	}
	
	/**
	 * 
	 * 
	 * @param array $estimates
	 * @return boolean
	 */
	static protected function _integrateNewEstimates($estimates)
	{
		// Let's start with new estimates
		foreach ($estimates as $EstimateID)
		{
			$API->log('Analyzing estimate #' . $EstimateID, QUICKBOOKS_LOG_VERBOSE);
			
			$Estimate = $Integrator->getEstimate($EstimateID);
			QuickBooks_Callbacks_Integrator_Callbacks::_integrateEstimate($Estimate, $EstimateID);
			
			// Customer
			$CustomerID = $Estimate->getCustomerApplicationID();
			if ($ListID = $Estimate->getCustomerListID())
			{
				// xxx Do nothing, already in QuickBooks
				// Add it again, just in case!
				
				// 
				QuickBooks_Callbacks_Integrator_Callbacks::integrateAddCustomer($CustomerID);
			}
			else if (true)
			//else if ($this->_integrator_config['lookup_customers'])
			{
				// Try to fetch the customer by name
				$API->getCustomerByName($Integrator->getCustomerNameForQuery($CustomerID), 'QuickBooks_Callbacks_Integrator_Callbacks::getCustomerByName', $CustomerID);
			}
			/*else
			{
				// Add the customer to QuickBooks
				
				QuickBooks_Callbacks_Integrator_Callbacks::integrateAddCustomer($CustomerID);
				//$extras = $Integrator->getCustomerExtras($CustomerID, __FILE__, __LINE__);
				//$Customer = $Integrator->getCustomer($CustomerID, __FILE__, __LINE__);
				//$this->_integrateCustomer($Customer, $CustomerID, $extras);
			}*/
			
			$list = $Integrator->getEstimateItemsForEstimate($EstimateID);
			foreach ($list as $EstimateItem)
			{
				$ProductID = $EstimateItem->getItemApplicationID();
				
				if (!$EstimateID)
				{
					continue;
				}
				
				//				
				if ($ListID = $EstimateItem->getItemListID())
				{
					// Add it again anyway, just in case
					$Product = $Integrator->getProduct($ProductID, __FILE__, __LINE__);
					QuickBooks_Callbacks_Integrator_Callbacks::_integrateProduct($Product, $ProductID);
				}
				else if (true)
				//else if ($this->_integrator_config['lookup_products'])
				{
					//print('getbyname');
					// Queue a request *for each type* of item
					$API->getItemByName($Integrator->getProductNameForQuery($ProductID), 'QuickBooks_Callbacks_Integrator_Callbacks::getProductByName', $ProductID);
				}
				/*
				else
				{
					//print('else');
					$Product = $Integrator->getProduct($ProductID, __FILE__, __LINE__);
					$this->_integrateProduct($Product, $ProductID);
				}
				*/
			}
		}		
	}
	
	static protected function _integrateNewOrders($orders)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		// Let's start with new orders
		foreach ($orders as $OrderID)
		{
			$API->log('Analyzing order #' . $OrderID, QUICKBOOKS_LOG_VERBOSE);
			
			$Order = $Integrator->getOrder($OrderID);
			
			if ($Order)
			{
				// Customer
				$CustomerID = $Order->getCustomerApplicationID();
				if ($ListID = $Order->getCustomerListID())
				{
					// Add it again, just in case!
					QuickBooks_Callbacks_Integrator_Callbacks::integrateAddCustomer($CustomerID);
				}
				else
				{
					// Try to fetch the customer by name
					$API->getCustomerByName($Integrator->getCustomerNameForQuery($CustomerID), 'QuickBooks_Callbacks_Integrator_Callbacks::getCustomerByName', $CustomerID);
				}
				
				// ShipMethod
				/*
				$ShipMethodID = $Order->getShipMethodApplicationID();
				if (
					(is_numeric($ShipMethodID) and (int) $ShipMethodID) or
					(!is_numeric($ShipMethodID) and strlen($ShipMethodID)))
				{
					if ($ListID = $Order->getShipMethodListID())
					{
						// xxx Do nothing, already in QuickBooks
						// Add it again anyway, just in case!
						$ShipMethod = $Integrator->getShipMethod($ShipMethodID);
						QuickBooks_Callbacks_Integrator_Callbacks::_integrateShipMethod($ShipMethod, $ShipMethodID);
					}
					else if ($this->_integrator_config['lookup_shipmethods'] and $ShipMethodID)
					{
						// Try to fetch the shipping method by name
						$API->getShipMethodByName($Integrator->getShipMethodNameForQuery($ShipMethodID), 'QuickBooks_Callbacks_Integrator_Callbacks::getShipMethodByName', $ShipMethodID);
					}
					else if ($ShipMethodID)
					{
						$ShipMethod = $Integrator->getShipMethod($ShipMethodID);
						QuickBooks_Callbacks_Integrator_Callbacks::_integrateShipMethod($ShipMethod, $ShipMethodID);
					}
				}
				*/
								
				$list = $Integrator->getOrderItems($OrderID);
				foreach ($list as $OrderItem)
				{
					// 
					$ProductID = $OrderItem->getItemApplicationID();
					
					if (!$ProductID)
					{
						continue;
					}
					
					// 
					if ($ListID = $OrderItem->getItemListID())
					{
						// Add it again anyway, just in case
						$Product = $Integrator->getProduct($ProductID, __FILE__, __LINE__);
						QuickBooks_Callbacks_Integrator_Callbacks::_integrateProduct($Product, $ProductID);
					}
					else
					{
						// Queue a request *for each type* of item
						
						// Try to fetch the product from QuickBooks
						$API->getItemByName($Integrator->getProductNameForQuery($ProductID), 'QuickBooks_Callbacks_Integrator_Callbacks::getProductByName', $ProductID);
					}
				}
				
				// 
				QuickBooks_Callbacks_Integrator_Callbacks::_integrateOrder($Order, $OrderID);
				
				// 
				$Payment = $Integrator->getPayment($OrderID);
				if ($Payment and $Payment->getTotalAmount() > 0)
				{
					QuickBooks_Callbacks_Integrator_Callbacks::_integratePayment($Payment, $OrderID);
				}
			}
		}		
	}
	
	/**
	 * @deprecated 
	 */
	static protected function _integrateHandling($Handling)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		$API->getItemByName($Handling->getFullName(), 'QuickBooks_Callbacks_Integrator_Callbacks::getProductByName', QUICKBOOKS_INTEGRATOR_HANDLING_ID);
		return QuickBooks_Callbacks_Integrator::_integrateProduct($Handling, QUICKBOOKS_INTEGRATOR_HANDLING_ID);
	}
	
	/**
	 * 
	 */
	static protected function _integrateShipping($Shipping)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		$API->getItemByName($Shipping->getFullName(), 'QuickBooks_Callbacks_Integrator_Callbacks::getProductByName', QUICKBOOKS_INTEGRATOR_SHIPPING_ID);
		return QuickBooks_Callbacks_Integrator_Callbacks::_integrateProduct($Shipping, QUICKBOOKS_INTEGRATOR_SHIPPING_ID);
	}
	
	/**
	 * 
	 */
	static protected function _integrateCoupons($Coupon)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		$API->getItemByName($Coupon->getFullName(), 'QuickBooks_Callbacks_Integrator_Callbacks::getProductByName', QUICKBOOKS_INTEGRATOR_COUPON_ID);
		return QuickBooks_Callbacks_Integrator_Callbacks::_integrateProduct($Coupon, QUICKBOOKS_INTEGRATOR_COUPON_ID);
	}
	
	/**
	 * 
	 */
	static protected function _integrateDiscounts($Discount)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		$API->getItemByName($Discount->getFullName(), 'QuickBooks_Callbacks_Integrator_Callbacks::getProductByName', QUICKBOOKS_INTEGRATOR_DISCOUNT_ID);
		return QuickBooks_Callbacks_Integrator_Callbacks::_integrateProduct($Discount, QUICKBOOKS_INTEGRATOR_DISCOUNT_ID);
	}
	
	/** 
	 * 
	 * 
	 * 
	 */
	static protected function _integrateOrder($Order, $OrderID)
	{
		// 
		$API = QuickBooks_API_Singleton::getInstance();
		
		$API->log('Integrating order #' . $OrderID . ' as a ' . $Order->object(), QUICKBOOKS_LOG_DEVELOP);
		$user = $API->user();
		
		// Call a hook to indicate the order is being pushed to QuickBooks
		$hook_data = array(
			'OrderID' => $OrderID, 
			'Order' => $Order, 
			);
		/*QuickBooks_Callbacks_Integrator_Callbacks::_callHooks(
			QUICKBOOKS_SERVER_INTEGRATOR_HOOK_INTEGRATEORDER, 
			null, 
			$user, 
			null, 
			$err, 
			$hook_data);
		*/
		
		// Send the object to QuickBooks
		switch ($Order->object())
		{
			case QUICKBOOKS_OBJECT_SALESRECEIPT:
				
				return $API->addSalesReceipt($Order, 'QuickBooks_Callbacks_Integrator_Callbacks::addSalesReceipt', $OrderID);
			case QUICKBOOKS_OBJECT_SALESORDER:
				
				return $API->addSalesOrder($Order, 'QuickBooks_Callbacks_Integrator_Callbacks::addSalesOrder', $OrderID);
			case QUICKBOOKS_OBJECT_INVOICE:
				
				return $API->addInvoice($Order, 'QuickBooks_Callbacks_Integrator_Callbacks::addInvoice', $OrderID);
			default:
				return false;
		}
	}

	static protected function _integrateEstimate($Estimate, $EstimateID)
	{
		// 
		$API = QuickBooks_API_Singleton::getInstance();
		
		// 
		$API->log('Integrating estimate #' . $EstimateID . ' as a ' . $Estimate->object(), QUICKBOOKS_LOG_DEVELOP);
		
		// 
		return $API->addEstimate($Estimate, 'QuickBooks_Callbacks_Integrator_Callbacks::addEstimate', $EstimateID);
	}
	
	/**
	 * 
	 * 
	 * @param QuickBooks_Object_ReceivePayment $Payment
	 * @param mixed $OrderID
	 * @return boolean
	 */
	static protected function _integratePayment($Payment, $OrderID)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		$API->log('Integrating payment for order #' . $OrderID, QUICKBOOKS_LOG_DEVELOP);
		return $API->addReceivePayment($Payment, 'QuickBooks_Callbacks_Integrator_Callbacks::addReceivePayment', $OrderID);
	}
	
	/**
	 * 
	 * 
	 * @param QuickBooks_Object $Product
	 * @param mixed $ProductID
	 * @return boolean
	 */
	static protected function _integrateProduct($Product, $ProductID)
	{
		// 
		$API = QuickBooks_API_Singleton::getInstance();
		
		// Call a hook to indicate the order is being pushed to QuickBooks
		/*
		$hook_data = array(
			'ProductID' => $ProductID, 
			'Product' => $Product, 
			);
		$this->_callHooks(
			QUICKBOOKS_SERVER_INTEGRATOR_HOOK_INTEGRATEPRODUCT, 
			null, 
			$user, 
			null, 
			$err, 
			$hook_data);
		*/
		
		switch ($Product->object())
		{
			case QUICKBOOKS_OBJECT_INVENTORYITEM:
				
				return $API->addInventoryItem($Product, 'QuickBooks_Callbacks_Integrator_Callbacks::addInventoryItem', $ProductID);
			case QUICKBOOKS_OBJECT_NONINVENTORYITEM:
				
				return $API->addNonInventoryItem($Product, 'QuickBooks_Callbacks_Integrator_Callbacks::addNonInventoryItem', $ProductID);
			case QUICKBOOKS_OBJECT_SERVICEITEM:
				
				return $API->addServiceItem($Product, 'QuickBooks_Callbacks_Integrator_Callbacks::addServiceItem', $ProductID);
			case QUICKBOOKS_OBJECT_DISCOUNTITEM:
				
				return $API->addDiscountItem($Product, 'QuickBooks_Callbacks_Integrator_Callbacks::addDiscountItem', $ProductID);
			case QUICKBOOKS_OBJECT_OTHERCHARGEITEM:
					
				return $API->addOtherChargeItem($Product, 'QuickBooks_Callbacks_Integrator_Callbacks::addOtherChargeItem', $ProductID);
			default:
				return false;
		}
	}
	
	static protected function _integrateSalesReceipt()
	{
		
	}
	
	static protected function _integrateSalesOrder()
	{
		
	}
	
	static protected function _integrateInventoryItem()
	{
		
	}
	
	static protected function _integrateNonInventoryItem()
	{
		
	}
	
	static protected function _integrateServiceItem()
	{
		
	}
	
	static protected function _integrateDiscountItem()
	{
		
	}
	
	static protected function _integrateSalesTaxItem()
	{
		
	}
	
	static public function integrateQueryCustomer($CustomerID)
	{
		return QuickBooks_Callbacks_Integrator_Callbacks::integrateCustomer($CustomerID, false, true);
	}
	
	static public function integrateAddCustomer($CustomerID)
	{
		//print('adding!');
		return QuickBooks_Callbacks_Integrator_Callbacks::integrateCustomer($CustomerID, false);
	}
	
	static public function integrateModCustomer($CustomerID)
	{
		//print('modifying!');
		return QuickBooks_Callbacks_Integrator_Callbacks::integrateCustomer($CustomerID, true);
	}
	
	static public function integrateCustomer($CustomerID, $modify = false, $query = false)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		$API->log('Analyzing customer #' . $CustomerID, QUICKBOOKS_LOG_DEVELOP);
		
		$extras = $Integrator->getCustomerExtras($CustomerID, __FILE__, __LINE__);
		
		if ($Customer = $Integrator->getCustomer($CustomerID, __FILE__, __LINE__))
		{
			$action = 'add';
			if ($modify)
			{
				$action = 'mod';
			}
			else if ($query)
			{
				$action = 'query';
			}
			
			$API->log('Integrating customer #' . $CustomerID . ' (' . $action . ')', QUICKBOOKS_LOG_DEVELOP);
			
			$continue = false;
			
			// Turn off modifications of customers
			/*
			if ($modify and 
				$API->modifyCustomer($Customer, 'QuickBooks_Callbacks_Integrator_Callbacks::modCustomer', $CustomerID))
			{
				$continue = true;
			}
			else */
			
			if ($query and
				$API->getCustomerByName($Integrator->getCustomerNameForQuery($CustomerID), 'QuickBooks_Callbacks_Integrator_Callbacks::getCustomerByName', $CustomerID))
			{
				return true;
			}
			else if (!$modify and !$query and 
				$API->addCustomer($Customer, 'QuickBooks_Callbacks_Integrator_Callbacks::addCustomer', $CustomerID))
			{
				// Call a hook to indicate the customer is being pushed to QuickBooks
				/*
				$user = $API->user();
				$hook_data = array(
					'CustomerID' => $CustomerID, 
					'Customer' => $Customer, 
					);
				$this->_callHooks(
					QUICKBOOKS_SERVER_INTEGRATOR_HOOK_INTEGRATECUSTOMER, 
					null, 
					$user, 
					null, 
					$err, 
					$hook_data);
				*/
				
				$continue = true;
			}
			
			if ($continue)
			{
				if (is_array($extras))
				{
					foreach ($extras as $key => $Extra)
					{
						$API->addDataExt($Extra, 'QuickBooks_Callbacks_Integrator_Callbacks::addExtra', $CustomerID . '-' . $key, null, QUICKBOOKS_ADD_CUSTOMER);
						
						if ($modify)
						{
							$API->modifyDataExt($Extra, 'QuickBooks_Callbacks_Integrator_Callbacks::modExtra', $CustomerID . '-' . $key, null, QUICKBOOKS_MOD_CUSTOMER);
						}
					}
				}
				
				return true;				
			}
		}
		
		return false;
	}
		
	/**
	 * 
	 * 
	 * @param string $method
	 * @param string $action
	 * @param mixed $ID
	 * @param string $err
	 * @param string $qbxml
	 * @param QuickBooks_Iterator $Iterator
	 * @param resource $qbres
	 * @return boolean
	 */
	static public function getCustomerByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		if ($Iterator->count() == 1)
		{
			// If we found the customer in QuickBooks, create a mapping with the ListID value
			
			$Customer = $Iterator->next();
			if ($API->createMapping(QUICKBOOKS_OBJECT_CUSTOMER, $ID, $Customer->getListID(), $Customer->getEditSequence()))
			{
				// Let's make sure that this customer is up-to-date	
				
				return QuickBooks_Callbacks_Integrator_Callbacks::integrateModCustomer($ID);
			}
		}
		else if ($Iterator->count() == 0)
		{
			// Otherwise, we need to queue up an add request to add this cart item to QuickBooks
			
			return QuickBooks_Callbacks_Integrator_Callbacks::integrateAddCustomer($ID);
		}
		
		return false;
	}
	
	static public function getInvoiceByRefNumber($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		
	}
	
	static public function getProductByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		if ($Iterator->count() == 1)
		{
			// If we found the item in QuickBooks, create a mapping with the ListID value
			$Item = $Iterator->next();
			
			// Save the item in our list of integrator items
			$Integrator->saveItem($Item);
			
			// Create an object mapping
			return $API->createMapping($Item->object(), $ID, $Item->getListID(), $Item->getEditSequence());
		}
		else if ($Iterator->count() == 0)
		{
			// Otherwise, we need to queue up an add request to add this cart item to QuickBooks
			
			if ($ID == QUICKBOOKS_INTEGRATOR_SHIPPING_ID)
			{
				return true;
			}
			else if ($ID == QUICKBOOKS_INTEGRATOR_DISCOUNT_ID)
			{
				return true;
			}
			
			$Product = $Integrator->getProduct($ID, __FILE__, __LINE__);
			
			switch ($Product->object())
			{
				case QUICKBOOKS_OBJECT_SERVICEITEM:
					return $API->addServiceItem($Product, 'QuickBooks_Callbacks_Integrator_Callbacks::addServiceItem', $ID);
					break;
				case QUICKBOOKS_OBJECT_INVENTORYITEM:
					return $API->addInventoryItem($Product, 'QuickBooks_Callbacks_Integrator_Callbacks::addInventoryItem', $ID);
					break;
				case QUICKBOOKS_OBJECT_NONINVENTORYITEM:
					return $API->addNonInventoryItem($Product, 'QuickBooks_Callbacks_Integrator_Callbacks::addNonInventoryItem', $ID);
					break;
			}
		}
		
		return false;
	}
	
	static public function getServiceItemByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		
	}
	
	static public function getInventoryItemByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		
	}
	
	static public function getNonInventoryItemByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		
	}
	
	static public function getDiscountItemByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		
	}
	
	static public function getClassByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		
	}
	
	static public function getAccountByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		
	}
	
	static public function getShipMethodByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		if ($Iterator->count() == 1)
		{
			// If we found the object in QuickBooks, create a mapping with the ListID value
			
			$ShipMethod = $Iterator->next();
			return $API->createMapping(QUICKBOOKS_OBJECT_SHIPMETHOD, $ID, $ShipMethod->getListID(), $ShipMethod->getEditSequence());
		}
		else if ($Iterator->count() == 0)
		{
			// Otherwise, we need to queue up an add request to add this cart item to QuickBooks
			
			$ShipMethod = $Integrator->getShipMethod($ID);
			return $API->addShipMethod($ShipMethod, 'QuickBooks_Callbacks_Integrator_Callbacks::addShipMethod', $ID);
		}
		
		return false;
	}
	
	/** 
	 * 
	 * 
	 * @param string $method
	 * @param string $action
	 * @param mixed $ID
	 * @param string $err
	 * @param string $qbxml
	 * @param QuickBooks_Iterator $Iterator
	 * @param resource $qbres
	 * @return boolean
	 */ 
	static public function getPaymentMethodByName($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		if ($Iterator->count() == 1)
		{
			// If we found the object in QuickBooks, create a mapping with the ListID value
			
			$PaymentMethod = $Iterator->next();
			return $API->createMapping(QUICKBOOKS_OBJECT_PAYMENTMETHOD, $ID, $PaymentMethod->getListID(), $PaymentMethod->getEditSequence());
		}
		else if ($Iterator->count() == 0)
		{
			// Otherwise, we need to queue up an add request to add this cart item to QuickBooks
			
			$PaymentMethod = $Integrator->getPaymentMethod($ID);
			return $API->addPaymentMethod($PaymentMethod, 'QuickBooks_Callbacks_Integrator_Callbacks::addPaymentMethod', $ID);
		}
		
		return false;
	}
	
	static public function listInvoicesModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($Invoice = $Iterator->next())
		{
			return false;
		}
		
		return true;
	}
	
	static public function listSalesTaxItemsModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($SalesTaxItem = $Iterator->next())
		{
			// Store this in the database
			$Integrator->saveSalesTaxItem($SalesTaxItem);
		}
		
		return true;
	}	

	static public function listSalesTaxGroupItemsModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($SalesTaxGroupItem = $Iterator->next())
		{
			// Store this in the database
			$Integrator->saveSalesTaxGroupItem($SalesTaxGroupItem);
		}
		
		return true;
	}	
	
	static public function listAccountsModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($Account = $Iterator->next())
		{
			// Store this in the database
			$Integrator->saveAccount($Account);
		}
		
		return true;
	}

	static public function listClassesModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($Class = $Iterator->next())
		{
			// Store this in the database
			$Integrator->saveClass($Class);
		}
		
		return true;
	}	
	
	static public function listPaymentMethodsModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($PaymentMethod = $Iterator->next())
		{
			// Store this in the database
			$Integrator->savePaymentMethod($PaymentMethod);
		}
		
		return true;
	}	
	
	static public function listCustomerTypesModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($CustomerType = $Iterator->next())
		{
			// Store this in the database
			$Integrator->saveCustomerType($CustomerType);
		}
		
		return true;
	}		
	
	static public function listShipMethodsModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($ShipMethod = $Iterator->next())
		{
			// Store this in the database
			$Integrator->saveShipMethod($ShipMethod);
		}
		
		return true;
	}

	static public function listSalesTaxCodesModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($SalesTaxCode = $Iterator->next())
		{
			// Store this in the database
			$Integrator->saveSalesTaxCode($SalesTaxCode);
		}
		
		return true;
	}

	static public function listUnitOfMeasureSetsModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($UnitOfMeasureSet = $Iterator->next())
		{
			// Store this in the database
			$Integrator->saveUnitOfMeasureSet($UnitOfMeasureSet);
		}
		
		return true;
	}
	
	static public function listEstimatesModifiedAfter($method, $action, $ID, $err, $qbxml, $Iterator, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		$Integrator = QuickBooks_Integrator_Singleton::getInstance();
		
		while ($Estimate = $Iterator->next())
		{
			// Let's check if this estimate already exists in the system
			$EstimateID = null;
			if ($API->hasApplicationID(QUICKBOOKS_OBJECT_ESTIMATE, $Estimate->getTxnID()))
			{
				$EstimateID = $API->fetchApplicationID(QUICKBOOKS_OBJECT_ESTIMATE, $Estimate->getTxnID());
			}
			
			// Now, there's a customer assigned to this estimate, let's make sure the customer exists 
			if ($API->hasApplicationID(QUICKBOOKS_OBJECT_CUSTOMER, $Estimate->getCustomerListID()))
			{
				// Great, it exists!
			}
			else
			{
				// Uh oh... create it!
				$Customer = new QuickBooks_Object_Customer();
				$Customer->setListID($Estimate->getCustomerListID());
				$Customer->setName($Estimate->getCustomerName());
				
				$Integrator->setCustomer(null, $Customer);
			}
			
			// There are line items assigned to this estimate too, and each line item has a product...
			//foreach ($Estimate->listLineItems
			
			$Integrator->setEstimate($EstimateID, $Estimate);
		}
		
		return true;
	}
	
	static public function addPaymentMethod()
	{
		
	}
	
	static public function addShipMethod()
	{
		
	}
	
	static public function addServiceItem($method, $action, $ID, &$err, $qbxml, $ServiceItem, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (is_object($ServiceItem))
		{
			// If we found the customer in QuickBooks, create a mapping with the ListID value
			
			$API->createMapping(
				QUICKBOOKS_OBJECT_SERVICEITEM, 
				$ID, 
				$ServiceItem->getListID(), 
				$ServiceItem->getEditSequence());
		}
	}
	
	static public function addInventoryItem($method, $action, $ID, &$err, $qbxml, $InventoryItem, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (is_object($InventoryItem))
		{
			// If we found the customer in QuickBooks, create a mapping with the ListID value
			
			$API->createMapping(
				QUICKBOOKS_OBJECT_INVENTORYITEM, 
				$ID, 
				$InventoryItem->getListID(), 
				$InventoryItem->getEditSequence());
		}
	}
	
	static public function addNonInventoryItem($method, $action, $ID, &$err, $qbxml, $NonInventoryItem, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (is_object($NonInventoryItem))
		{
			// If we found the customer in QuickBooks, create a mapping with the ListID value
			
			$API->createMapping(
				QUICKBOOKS_OBJECT_NONINVENTORYITEM, 
				$ID, 
				$NonInventoryItem->getListID(), 
				$NonInventoryItem->getEditSequence());
		}
	}
	
	static public function addInvoice($method, $action, $ID, &$err, $qbxml, $Invoice, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (is_object($Invoice))
		{
			// If we found the customer in QuickBooks, create a mapping with the ListID value
			
			$API->createMapping(
				QUICKBOOKS_OBJECT_INVOICE, 
				$ID, 
				$Invoice->getTxnID(), 
				$Invoice->getEditSequence());
		}		
	}
	
	static public function addEstimate()
	{
		
	}
	
	static public function addSalesReceipt()
	{
		
	}
	
	static public function addAccount()
	{
		
	}
	
	static public function addClass()
	{
		
	}
	
	static public function addExtra()
	{
		
	}
	
	static public function modExtra()
	{
		
	}
	
	static public function addCustomer($method, $action, $ID, &$err, $qbxml, $Customer, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (is_object($Customer))
		{
			// If we found the customer in QuickBooks, create a mapping with the ListID value
			
			$API->createMapping(
				QUICKBOOKS_OBJECT_CUSTOMER, 
				$ID, 
				$Customer->getListID(), 
				$Customer->getEditSequence());
		}
	}
	
	static public function modCustomer()
	{
		
	}
	
	static public function addReceivePayment($method, $action, $ID, &$err, $qbxml, $ReceivePayment, $qbres)
	{
		$API = QuickBooks_API_Singleton::getInstance();
		
		if (is_object($ReceivePayment))
		{
			// If we found the customer in QuickBooks, create a mapping with the ListID value
			
			$API->createMapping(
				QUICKBOOKS_OBJECT_RECEIVEPAYMENT, 
				$ID, 
				$ReceivePayment->getTxnID(), 
				$ReceivePayment->getEditSequence());
		}	
	}
}
