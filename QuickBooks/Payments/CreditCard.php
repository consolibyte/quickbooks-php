<?php

/**
 * Credit card class
 *
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 *
 *
 * @author Keith Palmer Jr. <keith@ConsoliBYTE.com>
 *
 * @package QuickBooks
 * @subpackage MerchantService
 */

/**
 *
 *
 */
class QuickBooks_Payments_CreditCard
{
	protected $_data;

	public function __construct($name, $number, $expyear, $expmonth, $street = null, $city = null, $region = null, $postalcode = null, $country = 'US', $cvc = null)
	{
		$this->_data = array(
			'expYear' => $expyear,
			'expMonth' => $expmonth,
			'address' => array(
				'region' => $region,
				'postalCode' => $postalcode,
				'streetAddress' => $street,
				'country' => $country,
				'city' => $city
				),
			'name' => $name,
			'cvc' => $cvc,
			'number' => str_replace(array('-', ' '), '', $number)
			);
	}

	public function toJSON()
	{
		return json_encode($this->_data);
	}

	public function toArray($remove_empty_keys = false)
	{
		$retr = $this->_data;

		if ($remove_empty_keys)
		{
			// Remove the empty keys, because it ends up triggering validation on empty keys
			/*
			if (empty($retr['address']['region']) or
				empty($retr['address']['postalCode']) or
				empty($retr['address']['streetAddress']) or
				empty($retr['address']['city']) or
				empty($retr['address']['country']))
			{
				unset($retr['address']);
			}
			*/

			if (empty($retr['address']['region']) and
				empty($retr['address']['postalCode']))
			{
				unset($retr['address']);
			}
			else
			{
				$retr['address'] = array_filter($retr['address'], function($value) { return $value != ''; });
			}

			$retr = array_filter($retr, function($value) { return $value != ''; });
		}

		return $retr;
	}

	static public function fromArray($data)
	{
		return new QuickBooks_Payments_CreditCard($data['name'], $data['number'], $data['expYear'], $data['expMonth'], @$data['address']['streetAddress'], @$data['address']['city'], @$data['address']['region'], @$data['address']['postalCode'], @$data['address']['country']);
	}
}
