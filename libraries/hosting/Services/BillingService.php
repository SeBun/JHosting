<?php
/**
 * @package     Hosting
 * @subpackage  Services
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Rameva\Hosting\Services;

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Component\ComponentHelper;
use Rameva\Hosting\Services\RobokassaService;

\defined('_JEXEC') or die;

/**
 * Billing Service Class
 *
 * @since  1.0.0
 */
class BillingService
{
    /**
     * Database object
     *
     * @var    \JDatabaseDriver
     * @since  1.0.0
     */
    protected $db;

    /**
     * Component parameters
     *
     * @var    \Joomla\Registry\Registry
     * @since  1.0.0
     */
    protected $params;

    /**
     * Robokassa service
     *
     * @var    RobokassaService
     * @since  1.0.0
     */
    protected $robokassa;

    /**
     * Constructor
     *
     * @since   1.0.0
     */
    public function __construct()
    {
        $this->db = Factory::getDbo();
        $this->params = ComponentHelper::getParams('com_hosting');
        
        // Initialize Robokassa service
        $this->robokassa = new RobokassaService(
            $this->params->get('robokassa_merchant_login'),
            $this->params->get('robokassa_password1'),
            $this->params->get('robokassa_password2'),
            $this->params->get('robokassa_test_mode', true)
        );
    }

    /**
     * Get user balance
     *
     * @param   int  $userId  User ID
     *
     * @return  float
     *
     * @since   1.0.0
     */
    public function getUserBalance($userId)
    {
        $query = $this->db->getQuery(true)
            ->select($this->db->quoteName('balance'))
            ->from($this->db->quoteName('#__hosting_users'))
            ->where($this->db->quoteName('joomla_user_id') . ' = ' . (int) $userId);

        $this->db->setQuery($query);
        return (float) $this->db->loadResult();
    }

    /**
     * Update user balance
     *
     * @param   int    $userId  User ID
     * @param   float  $amount  Amount to add/subtract
     * @param   string $type    Transaction type
     * @param   string $description Description
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function updateUserBalance($userId, $amount, $type = 'manual', $description = '')
    {
        $this->db->transactionStart();

        try {
            // Get current balance
            $currentBalance = $this->getUserBalance($userId);
            $newBalance = $currentBalance + $amount;

            // Update balance
            $query = $this->db->getQuery(true)
                ->update($this->db->quoteName('#__hosting_users'))
                ->set($this->db->quoteName('balance') . ' = ' . (float) $newBalance)
                ->set($this->db->quoteName('updated_at') . ' = ' . $this->db->quote(Factory::getDate()->toSql()))
                ->where($this->db->quoteName('joomla_user_id') . ' = ' . (int) $userId);

            $this->db->setQuery($query);
            $this->db->execute();

            // Create transaction record
            $this->createTransaction($userId, null, $type, $amount, $description);

            $this->db->transactionCommit();
            return true;

        } catch (\Exception $e) {
            $this->db->transactionRollback();
            Log::add('Error updating user balance: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Create transaction record
     *
     * @param   int     $userId      User ID
     * @param   int     $serviceId   Service ID (optional)
     * @param   string  $type        Transaction type
     * @param   float   $amount      Amount
     * @param   string  $description Description
     * @param   string  $status      Status
     * @param   array   $gatewayData Gateway data
     *
     * @return  int|false Transaction ID or false on failure
     *
     * @since   1.0.0
     */
    public function createTransaction($userId, $serviceId, $type, $amount, $description, $status = 'completed', $gatewayData = [])
    {
        // Get hosting user ID
        $hostingUserId = $this->getHostingUserId($userId);
        if (!$hostingUserId) {
            return false;
        }

        $transaction = (object) [
            'user_id' => $hostingUserId,
            'service_id' => $serviceId,
            'type' => $type,
            'amount' => $amount,
            'currency' => $this->params->get('default_currency', 'RUB'),
            'description' => $description,
            'status' => $status,
            'gateway_data' => !empty($gatewayData) ? json_encode($gatewayData) : null,
            'created_at' => Factory::getDate()->toSql()
        ];

        try {
            $this->db->insertObject('#__hosting_transactions', $transaction, 'id');
            return $this->db->insertid();
        } catch (\Exception $e) {
            Log::add('Error creating transaction: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Create payment
     *
     * @param   int    $userId  User ID
     * @param   float  $amount  Amount
     * @param   string $method  Payment method
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function createPayment($userId, $amount, $method = 'robokassa')
    {
        if ($amount < 100) {
            return [
                'success' => false,
                'message' => 'Минимальная сумма пополнения: 100 рублей'
            ];
        }

        // Create pending transaction
        $transactionId = $this->createTransaction(
            $userId,
            null,
            'topup',
            $amount,
            'Пополнение баланса',
            'pending'
        );

        if (!$transactionId) {
            return [
                'success' => false,
                'message' => 'Ошибка создания транзакции'
            ];
        }

        switch ($method) {
            case 'robokassa':
                return $this->createRobokassaPayment($userId, $amount, $transactionId);
            
            default:
                return [
                    'success' => false,
                    'message' => 'Неподдерживаемый способ оплаты'
                ];
        }
    }

    /**
     * Create Robokassa payment
     *
     * @param   int  $userId        User ID
     * @param   float $amount       Amount
     * @param   int  $transactionId Transaction ID
     *
     * @return  array
     *
     * @since   1.0.0
     */
    protected function createRobokassaPayment($userId, $amount, $transactionId)
    {
        $paymentUrl = $this->robokassa->generatePaymentUrl(
            $amount,
            $transactionId,
            "Пополнение баланса пользователя #{$userId}"
        );

        if ($paymentUrl) {
            // Update transaction with payment ID
            $query = $this->db->getQuery(true)
                ->update($this->db->quoteName('#__hosting_transactions'))
                ->set($this->db->quoteName('payment_id') . ' = ' . $this->db->quote($transactionId))
                ->set($this->db->quoteName('payment_method') . ' = ' . $this->db->quote('robokassa'))
                ->where($this->db->quoteName('id') . ' = ' . (int) $transactionId);

            $this->db->setQuery($query);
            $this->db->execute();

            return [
                'success' => true,
                'payment_url' => $paymentUrl,
                'transaction_id' => $transactionId
            ];
        }

        return [
            'success' => false,
            'message' => 'Ошибка создания платежа в Robokassa'
        ];
    }

    /**
     * Process payment callback
     *
     * @param   array  $data  Callback data
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function processPaymentCallback($data)
    {
        // Verify signature
        if (!$this->robokassa->verifyCallback($data)) {
            Log::add('Invalid payment callback signature', Log::WARNING, 'com_hosting');
            return false;
        }

        $transactionId = $data['InvId'] ?? null;
        $amount = $data['OutSum'] ?? 0;

        if (!$transactionId) {
            Log::add('Missing transaction ID in payment callback', Log::WARNING, 'com_hosting');
            return false;
        }

        // Get transaction
        $query = $this->db->getQuery(true)
            ->select('*')
            ->from($this->db->quoteName('#__hosting_transactions'))
            ->where($this->db->quoteName('id') . ' = ' . (int) $transactionId)
            ->where($this->db->quoteName('status') . ' = ' . $this->db->quote('pending'));

        $this->db->setQuery($query);
        $transaction = $this->db->loadObject();

        if (!$transaction) {
            Log::add('Transaction not found or already processed: ' . $transactionId, Log::WARNING, 'com_hosting');
            return false;
        }

        // Verify amount
        if (abs($transaction->amount - $amount) > 0.01) {
            Log::add('Amount mismatch in payment callback', Log::WARNING, 'com_hosting');
            return false;
        }

        $this->db->transactionStart();

        try {
            // Update transaction status
            $query = $this->db->getQuery(true)
                ->update($this->db->quoteName('#__hosting_transactions'))
                ->set($this->db->quoteName('status') . ' = ' . $this->db->quote('completed'))
                ->set($this->db->quoteName('gateway_data') . ' = ' . $this->db->quote(json_encode($data)))
                ->set($this->db->quoteName('updated_at') . ' = ' . $this->db->quote(Factory::getDate()->toSql()))
                ->where($this->db->quoteName('id') . ' = ' . (int) $transactionId);

            $this->db->setQuery($query);
            $this->db->execute();

            // Get user ID from hosting_users table
            $query = $this->db->getQuery(true)
                ->select('hu.joomla_user_id')
                ->from($this->db->quoteName('#__hosting_users', 'hu'))
                ->where($this->db->quoteName('hu.id') . ' = ' . (int) $transaction->user_id);

            $this->db->setQuery($query);
            $joomlaUserId = $this->db->loadResult();

            if ($joomlaUserId) {
                // Update user balance
                $currentBalance = $this->getUserBalance($joomlaUserId);
                $newBalance = $currentBalance + $amount;

                $query = $this->db->getQuery(true)
                    ->update($this->db->quoteName('#__hosting_users'))
                    ->set($this->db->quoteName('balance') . ' = ' . (float) $newBalance)
                    ->set($this->db->quoteName('updated_at') . ' = ' . $this->db->quote(Factory::getDate()->toSql()))
                    ->where($this->db->quoteName('joomla_user_id') . ' = ' . (int) $joomlaUserId);

                $this->db->setQuery($query);
                $this->db->execute();

                // Check for suspended services to resume
                $this->checkAndResumeServices($joomlaUserId);
            }

            $this->db->transactionCommit();
            return true;

        } catch (\Exception $e) {
            $this->db->transactionRollback();
            Log::add('Error processing payment callback: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }

    /**
     * Check and resume suspended services
     *
     * @param   int  $userId  User ID
     *
     * @return  void
     *
     * @since   1.0.0
     */
    protected function checkAndResumeServices($userId)
    {
        $balance = $this->getUserBalance($userId);
        
        if ($balance <= 0) {
            return;
        }

        // Get suspended services
        $hostingUserId = $this->getHostingUserId($userId);
        
        $query = $this->db->getQuery(true)
            ->select('*')
            ->from($this->db->quoteName('#__hosting_services'))
            ->where($this->db->quoteName('user_id') . ' = ' . (int) $hostingUserId)
            ->where($this->db->quoteName('status') . ' = ' . $this->db->quote('suspended'))
            ->where($this->db->quoteName('auto_suspend') . ' = 1');

        $this->db->setQuery($query);
        $services = $this->db->loadObjectList();

        foreach ($services as $service) {
            // Check if user has enough balance for at least one month
            if ($balance >= $service->monthly_price) {
                // Resume service via hosting panel
                $hostingService = new HostingService();
                if ($hostingService->resumeService($service->id)) {
                    Log::add("Service {$service->id} resumed for user {$userId}", Log::INFO, 'com_hosting');
                }
            }
        }
    }

    /**
     * Get hosting user ID by Joomla user ID
     *
     * @param   int  $joomlaUserId  Joomla user ID
     *
     * @return  int|false
     *
     * @since   1.0.0
     */
    protected function getHostingUserId($joomlaUserId)
    {
        $query = $this->db->getQuery(true)
            ->select($this->db->quoteName('id'))
            ->from($this->db->quoteName('#__hosting_users'))
            ->where($this->db->quoteName('joomla_user_id') . ' = ' . (int) $joomlaUserId);

        $this->db->setQuery($query);
        return $this->db->loadResult();
    }

    /**
     * Get user transactions
     *
     * @param   int     $userId  User ID
     * @param   string  $type    Transaction type filter
     * @param   int     $limit   Limit
     * @param   int     $offset  Offset
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public function getUserTransactions($userId, $type = null, $limit = 20, $offset = 0)
    {
        $hostingUserId = $this->getHostingUserId($userId);
        
        $query = $this->db->getQuery(true)
            ->select('t.*, s.service_name')
            ->from($this->db->quoteName('#__hosting_transactions', 't'))
            ->leftJoin($this->db->quoteName('#__hosting_services', 's') . ' ON t.service_id = s.id')
            ->where($this->db->quoteName('t.user_id') . ' = ' . (int) $hostingUserId)
            ->order($this->db->quoteName('t.created_at') . ' DESC');

        if ($type) {
            $query->where($this->db->quoteName('t.type') . ' = ' . $this->db->quote($type));
        }

        if ($limit > 0) {
            $this->db->setQuery($query, $offset, $limit);
        } else {
            $this->db->setQuery($query);
        }

        return $this->db->loadObjectList();
    }

    /**
     * Generate invoice
     *
     * @param   int    $userId   User ID
     * @param   array  $items    Invoice items
     * @param   string $dueDate  Due date
     *
     * @return  int|false Invoice ID or false on failure
     *
     * @since   1.0.0
     */
    public function generateInvoice($userId, $items, $dueDate = null)
    {
        $hostingUserId = $this->getHostingUserId($userId);
        
        if (!$dueDate) {
            $dueDate = Factory::getDate('+30 days')->toSql();
        }

        // Calculate total amount
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Generate invoice number
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($hostingUserId, 6, '0', STR_PAD_LEFT) . '-' . time();

        $invoice = (object) [
            'user_id' => $hostingUserId,
            'invoice_number' => $invoiceNumber,
            'amount' => $totalAmount,
            'currency' => $this->params->get('default_currency', 'RUB'),
            'status' => 'pending',
            'due_date' => $dueDate,
            'items' => json_encode($items),
            'created_at' => Factory::getDate()->toSql()
        ];

        try {
            $this->db->insertObject('#__hosting_invoices', $invoice, 'id');
            return $this->db->insertid();
        } catch (\Exception $e) {
            Log::add('Error generating invoice: ' . $e->getMessage(), Log::ERROR, 'com_hosting');
            return false;
        }
    }
}