<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Hosting\Site\Controller;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Response\JsonResponse;
use Rameva\Hosting\Services\BillingService;

\defined('_JEXEC') or die;

/**
 * Payment Controller for Hosting component
 *
 * @since  1.0.0
 */
class PaymentController extends BaseController
{
    /**
     * Create payment
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function create()
    {
        $app = Factory::getApplication();
        $user = Factory::getUser();

        if ($user->guest) {
            echo new JsonResponse(null, 'Unauthorized', true);
            $app->close();
        }

        $input = json_decode($app->input->getRaw('php://input'), true);
        $amount = (float) ($input['amount'] ?? 0);
        $paymentMethod = $input['payment_method'] ?? 'robokassa';

        $billingService = new BillingService();
        $result = $billingService->createPayment($user->id, $amount, $paymentMethod);

        echo new JsonResponse($result, $result['success'] ? 'Payment created' : $result['message'], !$result['success']);
        $app->close();
    }

    /**
     * Handle payment callback
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function callback()
    {
        $app = Factory::getApplication();
        $data = $app->input->getArray();

        $billingService = new BillingService();
        $result = $billingService->processPaymentCallback($data);

        if ($result) {
            echo 'OK' . $data['InvId'];
        } else {
            echo 'ERROR';
        }

        $app->close();
    }

    /**
     * Handle payment result
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function result()
    {
        $app = Factory::getApplication();
        $data = $app->input->getArray();

        $billingService = new BillingService();
        $result = $billingService->processPaymentCallback($data);

        if ($result) {
            $app->redirect('index.php?option=com_hosting&view=dashboard&payment=success');
        } else {
            $app->redirect('index.php?option=com_hosting&view=dashboard&payment=error');
        }
    }

    /**
     * Handle payment success
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function success()
    {
        $app = Factory::getApplication();
        $app->enqueueMessage('Платеж успешно обработан', 'success');
        $app->redirect('index.php?option=com_hosting&view=dashboard');
    }

    /**
     * Handle payment failure
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function fail()
    {
        $app = Factory::getApplication();
        $app->enqueueMessage('Ошибка при обработке платежа', 'error');
        $app->redirect('index.php?option=com_hosting&view=dashboard');
    }
}