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
 * Utilities class (for masking and some other misc things)
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

/**
 * HTTP connection class
 */
QuickBooks_Loader::load('/QuickBooks/HTTP.php');

/**
 * Class QuickBooks_IPP_OAuth2Helper
 *
 * @author Evgeniy Bogdanov <e.bogdanov@biz-systems.ru>
 */
class QuickBooks_IPP_OAuth2Helper
{
    const METHOD_POST = 'POST';
    const METHOD_GET  = 'GET';
    const METHOD_PUT  = 'PUT';

    const SCOPE_ACCOUNTING = 'com.intuit.quickbooks.accounting';
    const SCOPE_PAYMENTS   = 'com.intuit.quickbooks.payment';

    const URL_TOKEN_ENDPOINT        = 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer';
    const URL_AUTHORIZATION_REQUEST = 'https://appcenter.intuit.com/connect/oauth2';
    const URL_REVOKE_TOKEN_ENDPOINT = 'https://developer.api.intuit.com/v2/oauth2/tokens/revoke';

    /**
     * @var QuickBooks_IPP_OAuth2
     */
    protected $_oauth2_token_instance;

    /**
     * QuickBooks_IPP_OAuth2Helper constructor.
     *
     * @param QuickBooks_IPP_OAuth2 $oauth2_token
     */
    public function __construct(QuickBooks_IPP_OAuth2 $oauth2_token)
    {
        $this->setOauth2TokenInstance($oauth2_token);
    }

    /**
     * First step of OAuth2
     *
     * @param string $redirect_url URL there user will be landed after grant access to his data
     * @param string|array $scope By default com.intuit.quickbooks.accounting
     * @param string|array $additional_options additional options which will be passed in redirect URL as "state" option
     *
     * @return string
     */
    public function getAuthorizationURL($redirect_url, $scope = self::SCOPE_ACCOUNTING, $additional_options = '')
    {
        if (is_array($additional_options))
        {
            $additional_options = http_build_query($additional_options, null, ';');
        }

        $parameters = array(
            'response_type' => 'code',
            'client_id'     => $this->_oauth2_token_instance->getClientId(),
            'scope'         => $this->getScopeAsString($scope),
            'redirect_uri'  => $redirect_url,
            'state'         => $additional_options ? $additional_options : 'none'
        );

        $auth_request_url = self::URL_AUTHORIZATION_REQUEST;
        $auth_request_url .= '?' . http_build_query($parameters, null, '&', PHP_QUERY_RFC1738);

        return $auth_request_url;
    }

    /**
     * Load token by code Intuit have sent to our redirect url.
     *
     * @param string $code
     * @param string $redirect_url
     * @param int $realm_id
     *
     * @return QuickBooks_IPP_OAuth2
     * @throws Exception
     */
    public function loadTokenByCode($code, $redirect_url, $realm_id = null)
    {
        $headers = array(
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Request-Id'    => QuickBooks_Utilities::GUID(),
            'Authorization' => $this->generateAuthorizationHeader()
        );

        $request_parameters = array(
            'grant_type'   => 'authorization_code',
            'code'         => $code,
            'redirect_uri' => $redirect_url
        );
        $body = http_build_query($request_parameters);

        $HTTP = new QuickBooks_HTTP(self::URL_TOKEN_ENDPOINT);
		$HTTP->setHeaders($headers);
		$HTTP->setRawBody($body);
		$HTTP->verifyHost(false);
		$HTTP->verifyPeer(false);
		$HTTP->POST();

        $token = $this->parseResponse($HTTP);
        $this->setOauth2TokenInstance($token);

        if ($realm_id)
        {
            $token->setRealmId($realm_id);
        }

        return $token;
    }

    /**
     * Generate Authorization header
     *
     * @return string
     */
    protected function generateAuthorizationHeader()
    {
        $parts = array(
            $this->_oauth2_token_instance->getClientId(),
            $this->_oauth2_token_instance->getClientSecret()
        );

        $encodedString = base64_encode(implode(':', $parts));
        $encodedString = rtrim($encodedString, '=');

        return 'Basic ' . $encodedString;
    }

    /**
     * Get a new access token based on the refresh token
     *
     * @return QuickBooks_IPP_OAuth2
     * @throws Exception
     */
    public function refreshToken()
    {
        $refresh_token = $this->_oauth2_token_instance->getRefreshToken();

        $headers = array(
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Connection'    => 'close',
            'Authorization' => $this->generateAuthorizationHeader()
        );

        $parameters = array(
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refresh_token
        );
        $body = http_build_query($parameters);

        $HTTP = new QuickBooks_HTTP(self::URL_TOKEN_ENDPOINT);
        $HTTP->setHeaders($headers);
        $HTTP->setRawBody($body);
        $HTTP->verifyHost(false);
        $HTTP->verifyPeer(false);
        $HTTP->POST();

        // Build token from response
        $token = $this->parseResponse($HTTP);
        $this->setOauth2TokenInstance($token);

        return $token;
    }

    /**
     * Revoke access token
     *
     * @return bool
     */
    public function revokeToken()
    {
        $request_parameters = array(
            'token' => strval($this->_oauth2_token_instance->getRefreshToken())
        );
        $body = json_encode($request_parameters);

        $headers = array(
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => $this->generateAuthorizationHeader()
        );

        $HTTP = new QuickBooks_HTTP(self::URL_REVOKE_TOKEN_ENDPOINT);
        $HTTP->setHeaders($headers);
        $HTTP->setRawBody($body);
        $HTTP->verifyHost(false);
        $HTTP->verifyPeer(false);
        $HTTP->POST();

        /**
         * @todo Check for success
         */

        return true;
    }

    /**
     * Convert user specified scope to required format
     *
     * @param array|string $scope
     * @return string
     */
    protected function getScopeAsString($scope)
    {
        // if we've spaces, commas and this is string - cast to array
        if (is_string($scope))
        {
            $scope = str_replace(' ', ',', $scope);
            $scope = explode(',', $scope);
        }

        foreach ($scope as $key => $value)
        {
            if (($value != self::SCOPE_ACCOUNTING) && ($value != self::SCOPE_PAYMENTS))
            {
                unset($scope[$key]);
            }
        }

        return implode(' ', $scope);
    }

    /**
     * Parse the JSON Body to store the information to an OAuth 2 Access Token
     *
     * @param QuickBooks_HTTP $HTTP
     *
     * @return QuickBooks_IPP_OAuth2
     *
     * @throws Exception
     */
    private function parseResponse(QuickBooks_HTTP $HTTP)
    {
        $info     = $HTTP->lastInfo();
        $response = $HTTP->lastResponse();

        /**
         * @kludge
         *
         * JSON_BIGINT_AS_STRING helps to solve issues with bigint failed decode
         * this works for PHP 5.4+, but for old versions I do not have good enough fix for now.
         *
         * @author Evgeniy Bogdanov
         */
        $result = version_compare(PHP_VERSION, '5.4.0', '>=')
            ? json_decode($response, false, 512, JSON_BIGINT_AS_STRING)
            : json_decode($response, false);

        $http_code = $info['http_code'];

        if ($http_code < 400)
        {
            $http_code = 0;
        }

        if (json_last_error())
        {
            throw new Exception('JSON error : ' . json_last_error_msg(), $http_code);
        }

        if (property_exists($result, 'error'))
        {
            throw new Exception($result->error, $http_code);
        }

        if ($http_code)
        {
            throw new Exception('Server returned ' . $http_code . ' HTTP error');
        }

        $expire_access_token_date = new \DateTime();
        $expire_access_token_date->modify($result->expires_in . ' seconds');

        $expire_refresh_token_date = new \DateTime();
        $expire_refresh_token_date->modify($result->x_refresh_token_expires_in . ' seconds');

        $instance = $this->_oauth2_token_instance;

        $oauth2_token = new QuickBooks_IPP_OAuth2($instance->getClientId(), $instance->getClientSecret(), $instance->getRealmId());

        $oauth2_token->setAccessToken($result->access_token);
        $oauth2_token->setAccessTokenExpiresTime($expire_access_token_date);
        $oauth2_token->setRefreshToken($result->refresh_token);
        $oauth2_token->setRefreshTokenExpiresTime($expire_refresh_token_date);

        return $oauth2_token;
    }

    /**
     * @return QuickBooks_IPP_OAuth2
     */
    public function getOauth2TokenInstance()
    {
        return $this->_oauth2_token_instance;
    }

    /**
     * @param QuickBooks_IPP_OAuth2 $oauth2_token_instance
     */
    public function setOauth2TokenInstance(QuickBooks_IPP_OAuth2 $oauth2_token_instance)
    {
        $this->_oauth2_token_instance = $oauth2_token_instance;
    }

}