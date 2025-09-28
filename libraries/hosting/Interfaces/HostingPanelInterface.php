<?php
/**
 * @package     Hosting
 * @subpackage  Interfaces
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Rameva\Hosting\Interfaces;

\defined('_JEXEC') or die;

/**
 * Hosting Panel Interface
 *
 * @since  1.0.0
 */
interface HostingPanelInterface
{
    /**
     * Authenticate with hosting panel
     *
     * @param   string  $login     Login
     * @param   string  $password  Password
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function authenticate($login, $password);

    /**
     * Create hosting account
     *
     * @param   array  $params  Account parameters
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function createAccount($params);

    /**
     * Suspend hosting account
     *
     * @param   string  $accountId  Account ID
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function suspendAccount($accountId);

    /**
     * Resume hosting account
     *
     * @param   string  $accountId  Account ID
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function resumeAccount($accountId);

    /**
     * Delete hosting account
     *
     * @param   string  $accountId  Account ID
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function deleteAccount($accountId);

    /**
     * Get account statistics
     *
     * @param   string  $accountId  Account ID
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function getAccountStats($accountId);

    /**
     * Test connection to hosting panel
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function testConnection();
}