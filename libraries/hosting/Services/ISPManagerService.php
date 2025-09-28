<?php
/**
 * @package     Hosting
 * @subpackage  Services
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Rameva\Hosting\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Rameva\Hosting\Interfaces\HostingPanelInterface;

\defined('_JEXEC') or die;

/**
 * ISPManager Service Class
 *
 * @since  1.0.0
 */
class ISPManagerService implements HostingPanelInterface
{
    /**
     * HTTP client
     *
     * @var    Client
     * @since  1.0.0
     */
    protected $client;

    /**
     * ISPManager URL
     *
     * @var    string
     * @since  1.0.0
     */
    protected $url;

    /**
     * Authentication token
     *
     * @var    string
     * @since  1.0.0
     */
    protected $token;

    /**
     * Constructor
     *
     * @param   string  $url      ISPManager URL
     * @param   string  $login    Login
     * @param   string  $password Password
     *
     * @since   1.0.0
     */
    public function __construct($url, $login = null, $password = null)
    {
        $this->url = rtrim($url, '/');
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false, // For self-signed certificates
            'headers' => [
                'User-Agent' => 'Joomla-Hosting-Component/1.0'
            ]
        ]);

        if ($login && $password) {
            $this->authenticate($login, $password);
        }
    }

    /**
     * Authenticate with ISPManager
     *
     * @param   string  $login     Login
     * @param   string  $password  Password
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function authenticate($login, $password)
    {
        try {
            $response = $this->client->post($this->url . '/ispmgr', [
                'form_params' => [
                    'func' => 'auth',
                    'username' => $login,
                    'password' => $password,
                    'out' => 'json'
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['doc']['auth']['$id'])) {
                $this->token = $data['doc']['auth']['$id'];
                return true;
            }

            Log::add('ISPManager authentication failed: ' . $response->getBody(), Log::ERROR, 'com_hosting');
            return false;

        } catch (GuzzleException $e) {
            Log::add('ISPManager authentication error: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Create hosting account
     *
     * @param   array  $params  Account parameters
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function createAccount($params)
    {
        if (!$this->token) {
            return false;
        }

        try {
            $response = $this->client->post($this->url . '/ispmgr', [
                'form_params' => array_merge([
                    'func' => 'user.edit',
                    'auth' => $this->token,
                    'out' => 'json',
                    'sok' => 'ok'
                ], $params)
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['doc']['ok'])) {
                return [
                    'success' => true,
                    'account_id' => $params['name'] ?? null,
                    'data' => $data
                ];
            }

            return [
                'success' => false,
                'error' => $data['doc']['error']['msg'] ?? 'Unknown error'
            ];

        } catch (GuzzleException $e) {
            Log::add('ISPManager create account error: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Suspend hosting account
     *
     * @param   string  $accountId  Account ID
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function suspendAccount($accountId)
    {
        if (!$this->token) {
            return false;
        }

        try {
            $response = $this->client->post($this->url . '/ispmgr', [
                'form_params' => [
                    'func' => 'user.suspend',
                    'auth' => $this->token,
                    'out' => 'json',
                    'elid' => $accountId,
                    'sok' => 'ok'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return isset($data['doc']['ok']);

        } catch (GuzzleException $e) {
            Log::add('ISPManager suspend account error: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Resume hosting account
     *
     * @param   string  $accountId  Account ID
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function resumeAccount($accountId)
    {
        if (!$this->token) {
            return false;
        }

        try {
            $response = $this->client->post($this->url . '/ispmgr', [
                'form_params' => [
                    'func' => 'user.resume',
                    'auth' => $this->token,
                    'out' => 'json',
                    'elid' => $accountId,
                    'sok' => 'ok'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return isset($data['doc']['ok']);

        } catch (GuzzleException $e) {
            Log::add('ISPManager resume account error: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Delete hosting account
     *
     * @param   string  $accountId  Account ID
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function deleteAccount($accountId)
    {
        if (!$this->token) {
            return false;
        }

        try {
            $response = $this->client->post($this->url . '/ispmgr', [
                'form_params' => [
                    'func' => 'user.delete',
                    'auth' => $this->token,
                    'out' => 'json',
                    'elid' => $accountId,
                    'sok' => 'ok'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return isset($data['doc']['ok']);

        } catch (GuzzleException $e) {
            Log::add('ISPManager delete account error: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Get account statistics
     *
     * @param   string  $accountId  Account ID
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function getAccountStats($accountId)
    {
        if (!$this->token) {
            return false;
        }

        try {
            $response = $this->client->post($this->url . '/ispmgr', [
                'form_params' => [
                    'func' => 'user',
                    'auth' => $this->token,
                    'out' => 'json',
                    'elid' => $accountId
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['doc']['elem'])) {
                $user = $data['doc']['elem'];
                return [
                    'disk_usage' => $user['disk_usage'] ?? 0,
                    'disk_limit' => $user['disk_limit'] ?? 0,
                    'traffic_usage' => $user['traffic_usage'] ?? 0,
                    'traffic_limit' => $user['traffic_limit'] ?? 0,
                    'domains_count' => $user['domains_count'] ?? 0,
                    'status' => $user['status'] ?? 'unknown'
                ];
            }

            return false;

        } catch (GuzzleException $e) {
            Log::add('ISPManager get stats error: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Get account info
     *
     * @param   string  $accountId  Account ID
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function getAccountInfo($accountId)
    {
        if (!$this->token) {
            return false;
        }

        try {
            $response = $this->client->post($this->url . '/ispmgr', [
                'form_params' => [
                    'func' => 'user.edit',
                    'auth' => $this->token,
                    'out' => 'json',
                    'elid' => $accountId
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['doc']['elem'])) {
                return $data['doc']['elem'];
            }

            return false;

        } catch (GuzzleException $e) {
            Log::add('ISPManager get account info error: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Test connection to ISPManager
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function testConnection()
    {
        try {
            $response = $this->client->get($this->url . '/ispmgr', [
                'query' => [
                    'func' => 'session',
                    'out' => 'json'
                ]
            ]);

            return $response->getStatusCode() === 200;

        } catch (GuzzleException $e) {
            Log::add('ISPManager connection test error: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Get server info
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function getServerInfo()
    {
        if (!$this->token) {
            return false;
        }

        try {
            $response = $this->client->post($this->url . '/ispmgr', [
                'form_params' => [
                    'func' => 'stat.server',
                    'auth' => $this->token,
                    'out' => 'json'
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['doc']['elem'])) {
                return $data['doc']['elem'];
            }

            return false;

        } catch (GuzzleException $e) {
            Log::add('ISPManager get server info error: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }
}