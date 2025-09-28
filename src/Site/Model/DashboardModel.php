<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Hosting\Site\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\User\User;

\defined('_JEXEC') or die;

/**
 * Dashboard Model for Hosting component
 *
 * @since  1.0.0
 */
class DashboardModel extends BaseModel
{
    /**
     * Get user hosting data for dashboard
     *
     * @return  object|null
     *
     * @since   1.0.0
     */
    public function getDashboardData()
    {
        $user = Factory::getUser();
        
        if ($user->guest) {
            return null;
        }

        $db = $this->getDbo();
        
        // Get or create hosting user profile
        $hostingUser = $this->getHostingUser($user->id);
        
        // Get user services
        $services = $this->getUserServices($hostingUser->id);
        
        // Get user balance and transactions
        $balance = $this->getUserBalance($hostingUser->id);
        $recentTransactions = $this->getRecentTransactions($hostingUser->id);
        
        // Get statistics
        $stats = $this->getUserStats($hostingUser->id);
        
        return (object) [
            'user' => $hostingUser,
            'services' => $services,
            'balance' => $balance,
            'recent_transactions' => $recentTransactions,
            'stats' => $stats
        ];
    }

    /**
     * Get or create hosting user profile
     *
     * @param   int  $joomla_user_id  Joomla user ID
     *
     * @return  object|null
     *
     * @since   1.0.0
     */
    protected function getHostingUser($joomla_user_id)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__hosting_users'))
            ->where($db->quoteName('joomla_user_id') . ' = ' . (int) $joomla_user_id);

        $db->setQuery($query);
        $hostingUser = $db->loadObject();

        if (!$hostingUser) {
            // Create new hosting user profile
            $joomlaUser = Factory::getUser($joomla_user_id);
            
            $hostingUser = (object) [
                'joomla_user_id' => $joomla_user_id,
                'balance' => 0.00,
                'currency' => 'RUB',
                'user_type' => 'individual', // individual or legal
                'status' => 'active',
                'created_at' => Factory::getDate()->toSql()
            ];

            $db->insertObject('#__hosting_users', $hostingUser, 'id');
        }

        return $hostingUser;
    }

    /**
     * Get user services
     *
     * @param   int  $hosting_user_id  Hosting user ID
     *
     * @return  array
     *
     * @since   1.0.0
     */
    protected function getUserServices($hosting_user_id)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__hosting_services'))
            ->where($db->quoteName('user_id') . ' = ' . (int) $hosting_user_id)
            ->order($db->quoteName('created_at') . ' DESC');

        $db->setQuery($query);
        return $db->loadObjectList();
    }

    /**
     * Get user balance
     *
     * @param   int  $hosting_user_id  Hosting user ID
     *
     * @return  float
     *
     * @since   1.0.0
     */
    protected function getUserBalance($hosting_user_id)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select($db->quoteName('balance'))
            ->from($db->quoteName('#__hosting_users'))
            ->where($db->quoteName('id') . ' = ' . (int) $hosting_user_id);

        $db->setQuery($query);
        return (float) $db->loadResult();
    }

    /**
     * Get recent transactions
     *
     * @param   int  $hosting_user_id  Hosting user ID
     * @param   int  $limit            Number of transactions to fetch
     *
     * @return  array
     *
     * @since   1.0.0
     */
    protected function getRecentTransactions($hosting_user_id, $limit = 5)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__hosting_transactions'))
            ->where($db->quoteName('user_id') . ' = ' . (int) $hosting_user_id)
            ->order($db->quoteName('created_at') . ' DESC')
            ->setLimit($limit);

        $db->setQuery($query);
        return $db->loadObjectList();
    }

    /**
     * Get user statistics
     *
     * @param   int  $hosting_user_id  Hosting user ID
     *
     * @return  object
     *
     * @since   1.0.0
     */
    protected function getUserStats($hosting_user_id)
    {
        $db = $this->getDbo();
        
        // Count active services
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__hosting_services'))
            ->where($db->quoteName('user_id') . ' = ' . (int) $hosting_user_id)
            ->where($db->quoteName('status') . ' = ' . $db->quote('active'));

        $db->setQuery($query);
        $activeServices = (int) $db->loadResult();

        // Count suspended services
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__hosting_services'))
            ->where($db->quoteName('user_id') . ' = ' . (int) $hosting_user_id)
            ->where($db->quoteName('status') . ' = ' . $db->quote('suspended'));

        $db->setQuery($query);
        $suspendedServices = (int) $db->loadResult();

        // Calculate total spent this month
        $firstDayOfMonth = Factory::getDate('first day of this month')->toSql();
        $query = $db->getQuery(true)
            ->select('SUM(' . $db->quoteName('amount') . ')')
            ->from($db->quoteName('#__hosting_transactions'))
            ->where($db->quoteName('user_id') . ' = ' . (int) $hosting_user_id)
            ->where($db->quoteName('type') . ' = ' . $db->quote('payment'))
            ->where($db->quoteName('created_at') . ' >= ' . $db->quote($firstDayOfMonth));

        $db->setQuery($query);
        $monthlySpent = (float) $db->loadResult();

        return (object) [
            'active_services' => $activeServices,
            'suspended_services' => $suspendedServices,
            'monthly_spent' => $monthlySpent
        ];
    }
}