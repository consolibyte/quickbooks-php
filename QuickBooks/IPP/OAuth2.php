<?php

/**
 * QuickBooks PHP DevKit
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 *
 * @author Keith Palmer <Keith@ConsoliBYTE.com>
 * @license LICENSE.txt
 *
 * @package QuickBooks
 */

/**
 * Class QuickBooks_IPP_OAuth2
 *
 * @author Evgeniy Bogdanov <e.bogdanov@biz-systems.ru>
 */
class QuickBooks_IPP_OAuth2
{
    const METHOD_POST = 'POST';
    const METHOD_GET  = 'GET';
    const METHOD_PUT  = 'PUT';

    const MODE_PRODUCTION  = 'production';
    const MODE_DEVELOPMENT = 'development';

    /**
     * Client Id
     *
     * @var string
     */
    protected $_client_id;

    /**
     * Client secret
     *
     * @var string
     */
    protected $_client_secret;

    /**
     * Access token
     *
     * @var string
     */
    protected $_access_token;

    /**
     * Refresh token
     *
     * @var string
     */
    protected $_refresh_token;

    /**
     * Realm Id
     *
     * @var int
     */
    protected $_realm_id;

    /**
     * Access token expire date
     *
     * @var \DateTime
     */
    protected $_access_token_expires_time;

    /**
     * Refresh token expire time
     *
     * @var \DateTime
     */
    protected $_refresh_token_expires_time;

    /**
     * @var string
     */
    protected $_interaction_mode;

    /**
     * Create our OAuth2 Token instance
     *
     * @param string $oauth2_client_id
     * @param string $oauth2_client_secret
     * @param int    $realm_id
     * @param string $oauth2_access_token
     * @param string $oauth2_refresh_token
     */
    public function __construct($oauth2_client_id, $oauth2_client_secret, $realm_id = null, $oauth2_access_token = '', $oauth2_refresh_token = '')
    {
        $this->setClientId($oauth2_client_id);
        $this->setClientSecret($oauth2_client_secret);

        $this->setAccessToken($oauth2_access_token);
        $this->setRefreshToken($oauth2_refresh_token);
        $this->setRealmId($realm_id);

        $this->_interaction_mode = self::MODE_DEVELOPMENT;
    }

    /**
     * Instantiate object from array with settings
     *
     * @param array $creds
     * @return static
     */
    public static function fromArray($creds)
    {
        $instance = new static($creds['oauth2_client_id'], $creds['oauth2_client_secret'], $creds['qb_realm'], $creds['oauth2_access_token'], $creds['oauth2_refresh_token']);

        return $instance;
    }

    /**
     * Sign an OAuth request and return header value with sign
     *
     * @param string $method
     * @param string $url
     * @param array $params
     *
     * @return string
     */
    public function sign($method, $url, $params = array())
    {
        return 'Bearer ' . $this->_access_token;
    }

    /**
     * Get ClientID
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->_client_id;
    }

    /**
     * Set ClientID
     *
     * @param string $client_id
     */
    public function setClientId($client_id)
    {
        $this->_client_id = $client_id;
    }

    /**
     * Get ClientSecret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->_client_secret;
    }

    /**
     * Set ClientSecret
     *
     * @param string $client_secret
     */
    public function setClientSecret($client_secret)
    {
        $this->_client_secret = $client_secret;
    }

    /**
     * Get Access Token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->_access_token;
    }

    /**
     * Set OAuth2 Access token
     *
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->_access_token = $access_token;
    }

    /**
     * Get Refresh Token
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->_refresh_token;
    }

    /**
     * Set Refresh Token
     *
     * @param string $refresh_token
     */
    public function setRefreshToken($refresh_token)
    {
        $this->_refresh_token = $refresh_token;
    }

    /**
     * Get interaction mode value (development/production)
     *
     * @return string
     */
    public function getInteractionMode()
    {
        return $this->_interaction_mode;
    }

    /**
     * Set interaction mode
     *
     * @param string $interaction_mode
     *
     * @throws Exception
     */
    public function setInteractionMode($interaction_mode)
    {
        $values = array(
            self::MODE_PRODUCTION,
            self::MODE_DEVELOPMENT
        );

        $interaction_mode = strtolower($interaction_mode);

        if (!in_array($interaction_mode, $values))
        {
            $msg = 'Interaction mode %s is not correct. Should be one of [%s]';
            $msg = sprintf($msg, $interaction_mode, implode(', ', $values));

            throw new Exception($msg);
        }

        $this->_interaction_mode = $interaction_mode;
    }

    /**
     * Get Realm Id
     *
     * @return int
     */
    public function getRealmId()
    {
        return $this->_realm_id;
    }

    /**
     * Set Realm Id
     *
     * @param int $realm_id
     */
    public function setRealmId($realm_id)
    {
        $this->_realm_id = $realm_id;
    }

    /**
     * @return string
     */
    public function getAccessTokenExpiresTime()
    {
        return $this->_access_token_expires_time->format('Y-m-d H:i:s');
    }

    /**
     * @param DateTime|string $access_token_expires_time
     */
    public function setAccessTokenExpiresTime($access_token_expires_time)
    {
        if (is_scalar($access_token_expires_time))
        {
            $access_token_expires_time = new \DateTime($access_token_expires_time);
        }

        $this->_access_token_expires_time = $access_token_expires_time;
    }

    /**
     * @return string
     */
    public function getRefreshTokenExpiresTime()
    {
        return $this->_refresh_token_expires_time->format('Y-m-d H:i:s');
    }

    /**
     * @param DateTime|string $refresh_token_expires_time
     */
    public function setRefreshTokenExpiresTime($refresh_token_expires_time)
    {
        if (is_scalar($refresh_token_expires_time))
        {
            $refresh_token_expires_time = new \DateTime($refresh_token_expires_time);
        }

        $this->_refresh_token_expires_time = $refresh_token_expires_time;
    }
}
