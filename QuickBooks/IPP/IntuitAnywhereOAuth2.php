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
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 *
 * @package QuickBooks
 */

// Base class shared between OAuth1 and OAuth2 implementations
QuickBooks_Loader::load('/QuickBooks/IPP/IntuitAnywhereBase.php');

// OAuth2 Helper, handles mostly keys operations
QuickBooks_Loader::load('/QuickBooks/IPP/OAuth2Helper.php');

/**
 * Class QuickBooks_IPP_IntuitAnywhere_OAuth2
 *
 * @author Evgeniy Bogdanov <e.bogdanov@biz-systems.ru>
 */
class QuickBooks_IPP_IntuitAnywhereOAuth2 extends QuickBooks_IPP_IntuitAnywhereBase
{
    /**
     * ClientId
     *
     * @var string
     */
    private $_client_id;

    /**
     * ClientSecret
     *
     * @var string
     */
    private $_client_secret;

    /**
     *
     * @param string $dsn
     * @param string $encryption_key
     *
     * @param string $client_id		The OAuth2 Client Id key Intuit gives you
     * @param string $client_secret	The OAuth2 Client secret Intuit gives you
     * @param string $this_url		The URL of your QuickBooks_IntuitAnywhere class instance
     * @param string $that_url		The URL the user should be sent to after authenticated
     */
    public function __construct($dsn, $encryption_key, $client_id, $client_secret, $this_url = null, $that_url = null)
    {
        $this->_driver = QuickBooks_Driver_Factory::create($dsn);

        $this->_key = $encryption_key;

        $this->_this_url = $this_url;
        $this->_that_url = $that_url;

        $this->_client_id = $client_id;
        $this->_client_secret = $client_secret;

        $this->_auth_mode = QuickBooks_IPP::AUTHMODE_OAUTH2;

        $this->_debug = false;
    }

    /**
     * Load OAuth credentials from the database
     *
     * @param string $app_username
     * @param string $app_tenant
     *
     * @return array|false
     */
    public function load($app_username, $app_tenant)
    {
        if ($arr = $this->_loadSettings($this->_key, $app_username, $app_tenant))
        {
            $arr['oauth2_client_id']     = $this->_client_id;
            $arr['oauth2_client_secret'] = $this->_client_secret;

            return $arr;
        }

        return false;
    }

    /**
     * Check whether a connection is due for refresh/reconnect
     *
     * @param string $app_username
     * @param string $app_tenant
     * @param integer $within
     *
     * @return string One of the QuickBooks_IPP_IntuitAnywhere::EXPIRY_* constants
     */
    public function expiry($app_username, $app_tenant, $within = 600)
    {
        if ($arr = $this->_loadSettings($this->_key, $app_username, $app_tenant))
        {
            return $this->_expiry($arr, $within);
        }

        return QuickBooks_IPP_IntuitAnywhere::EXPIRY_UNKNOWN;
    }

    /**
     * Perform logic check if about token state
     *
     * @param array $arr
     * @param integer $within (seconds of still alive token, but we consider it as expiring soon)
     *
     * @return string
     */
    protected function _expiry($arr, $within = 600)
    {
        if (!empty($arr))
        {
            $expires = strtotime($arr['oauth2_access_token_expires']);

            $diff = $expires - time();

            if ($diff < 0)
            {
                // Already expired
                return QuickBooks_IPP_IntuitAnywhere::EXPIRY_EXPIRED;
            }
            else if ($diff < $within)
            {
                return QuickBooks_IPP_IntuitAnywhere::EXPIRY_SOON;
            }

            return QuickBooks_IPP_IntuitAnywhere::EXPIRY_NOTYET;
        }

        return QuickBooks_IPP_IntuitAnywhere::EXPIRY_UNKNOWN;
    }

    /**
     * Reconnect/refresh the OAuth tokens
     *
     * For this to succeed, the token expiration must be within 30 days of the
     * date that this method is called (6 months after original token was
     * created). This is an Intuit-imposed security restriction. Calls outside
     * of that date range will fail with an error.
     *
     * @param string $app_username
     * @param string $app_tenant
     *
     * @return bool
     */
    public function reconnect($app_username, $app_tenant)
    {
        if ($arr = $this->_loadSettings($this->_key, $app_username, $app_tenant))
        {
            try
            {
                $oauth2Token = new QuickBooks_IPP_OAuth2(
                    $this->_client_id,
                    $this->_client_secret,
                    $arr['qb_realm'],
                    $arr['oauth2_access_token'],
                    $arr['oauth2_refresh_token']
                );

                $oauth2Helper = new QuickBooks_IPP_OAuth2Helper($oauth2Token);
                $newToken = $oauth2Helper->refreshToken();

                $this->_driver->oauth2->oauth2AccessDelete($app_username, $app_tenant);

                $this->_driver->oauth2AccessWrite(
                    $this->_key,
                    $app_username,
                    $app_tenant,
                    $newToken->getAccessToken(),
                    $newToken->getRefreshToken(),
                    $newToken->getAccessTokenExpiresTime(),
                    $newToken->getRefreshTokenExpiresTime(),
                    $newToken->getRealmId(),
                    null);

                return true;

            }
            catch (\Exception $e)
            {
                $this->_setError($e->getCode(), $e->getMessage());
            }
        }

        return false;
    }

    /**
     * Disconnect application
     *
     * @param string $app_username
     * @param string $app_tenant
     * @param bool $force
     * @return bool
     */
    public function disconnect($app_username, $app_tenant, $force = false)
    {
        if ($arr = $this->_loadSettings($this->_key, $app_username, $app_tenant))
        {
            $oauth2Token = new QuickBooks_IPP_OAuth2(
                $this->_client_id,
                $this->_client_secret,
                $arr['qb_realm'],
                $arr['oauth2_access_token'],
                $arr['oauth2_refresh_token']
            );

            try
            {
                $oauth2Helper = new QuickBooks_IPP_OAuth2Helper($oauth2Token);
                $code = $oauth2Helper->revokeToken();

                if ($code == 0 or
                    $code == 270 or 	// Sometimes it returns "270: OAuth Token rejected" for some reason?
                    $force)
                {
                    return $this->_driver->oauth2AccessDelete($app_username, $app_tenant);
                }
            }
            catch (\Exception $e)
            {
                $this->_setError($e->getCode(), $e->getMessage());
            }
        }

        return false;
    }

    /**
     * Handle an OAuth2 request login thing
     *
     * @param string $app_username
     * @param string $app_tenant
     * @param string $scope
     * @param string $status
     *
     * @throws \Exception
     */
    public function handle($app_username, $app_tenant, $scope = QuickBooks_IPP_OAuth2Helper::SCOPE_PAYMENTS, $status = '')
    {
        if ($this->check($app_username, $app_tenant) and 		// We have tokens ...
            $this->test($app_username, $app_tenant))			// ... and they are valid
        {
            // They are already logged in, send them on to exchange data
            header('Location: ' . $this->_that_url);
            exit;
        }
        else
        {
            $oauth2Token = new QuickBooks_IPP_OAuth2(
                $this->_client_id,
                $this->_client_secret
            );
            $oauth2Helper = new QuickBooks_IPP_OAuth2Helper($oauth2Token);

            $realmId = filter_input(INPUT_GET, 'realmId', FILTER_VALIDATE_INT);

            if (isset($_GET['code']) && $realmId)
            {
                $token = $oauth2Helper->loadTokenByCode($_GET['code'], $this->_this_url, $realmId);

                $this->_driver->oauth2AccessWrite(
                    $this->_key,
                    $app_username,
                    $app_tenant,
                    $token->getAccessToken(),
                    $token->getRefreshToken(),
                    $token->getAccessTokenExpiresTime(),
                    $token->getRefreshTokenExpiresTime(),
                    $token->getRealmId(),
                    QuickBooks_IPP_IDS::FLAVOR_ONLINE);

                header('Location: ' . $this->_that_url);
                exit;
            }
            else
            {
                $auth_url = $oauth2Helper->getAuthorizationURL($this->_this_url, $scope, $status);

                // Forward them to the auth page
                header('Location: ' . $auth_url);
                exit;
            }
        }
    }

    /**
     * Handle refresh of "expired" or "expire soon" access tokens
     *
     * @param string $app_username
     * @param string $app_tenant
     */
    public function refresh_expired_token($app_username, $app_tenant)
    {
        $settings = $this->load($app_username, $app_tenant);

        if (!empty($settings))
        {
            $token = QuickBooks_IPP_OAuth2::fromArray($settings);
            $token_state = $this->expiry($app_username, $app_tenant);

            if (in_array($token_state, array(QuickBooks_IPP_IntuitAnywhere::EXPIRY_EXPIRED, QuickBooks_IPP_IntuitAnywhere::EXPIRY_SOON)))
            {
                try
                {
                    $helper = new QuickBooks_IPP_OAuth2Helper($token);
                    $new_token = $helper->refreshToken();

                    $this->_driver->oauth2AccessWrite(
                        $this->_key,
                        $app_username,
                        $app_tenant,
                        $new_token->getAccessToken(),
                        $new_token->getRefreshToken(),
                        $new_token->getAccessTokenExpiresTime(),
                        $new_token->getRefreshTokenExpiresTime(),
                        $new_token->getRealmId()
                    );
                }
                catch (\Exception $e)
                {
                    $this->_setError($e->getCode(), $e->getMessage());
                }
            }
        }
    }

    public function widgetConnect()
    {

    }

    /**
     * This function returns the html for displaying the "Blue Dot" menu
     *
     * Blue dot menu is deprecated since June 30th, 2017
     *
     * @link https://developer.intuit.com/hub/blog/2017/03/30/developer-alert-intuit-blue-dot-widget-will-deprecated-june-30th-2017
     *
     * @param string $app_username
     * @param string $app_tenant
     *
     * @return string html string
     */
    public function widgetMenu($app_username, $app_tenant)
    {
        /**
         * @kludge
         *
         * Nothing special in logic here, I just suppress IDE warning. Pull requests are welcome
         */
        return ($app_username . $app_tenant) ? '' : '';
    }

    /**
     * Load settings
     *
     * @param string $key
     * @param string $app_username
     * @param string $app_tenant
     *
     * @return mixed
     */
    protected function _loadSettings($key, $app_username, $app_tenant) {
        $return = $this->_driver->oauth2Load($key, $app_username, $app_tenant);

        if (empty($return['oauth2_access_token']) || empty($return['oauth2_refresh_token']))
        {
            return false;
        }

        return $return;
    }
}


