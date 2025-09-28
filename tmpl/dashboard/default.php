<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_hosting  
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\Hosting\Site\View\Dashboard\HtmlView $this */

$data = $this->data;
?>

<div class="hosting-dashboard">
    <!-- Balance Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3"><?php echo Text::_('COM_HOSTING_DASHBOARD_TITLE'); ?></h2>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card balance-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 opacity-75"><?php echo Text::_('COM_HOSTING_BALANCE_TITLE'); ?></h6>
                            <h2 class="card-title mb-0"><?php echo number_format($data->balance ?? 0, 2); ?> ₽</h2>
                        </div>
                        <div>
                            <button class="btn btn-warning btn-lg"><?php echo Text::_('COM_HOSTING_BALANCE_TOPUP'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="text-primary mb-2">
                                <i class="fas fa-server fa-2x"></i>
                            </div>
                            <h5 class="card-title"><?php echo $data->stats->suspended_services ?? 0; ?></h5>
                            <p class="card-text text-muted"><?php echo Text::_('COM_HOSTING_SERVICES_SUSPENDED'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="text-success mb-2">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h5 class="card-title"><?php echo $data->stats->active_services ?? 0; ?></h5>
                            <p class="card-text text-muted"><?php echo Text::_('COM_HOSTING_SERVICES_ACTIVE'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <?php if (!empty($data->services)) : ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo Text::_('COM_HOSTING_SERVICES_TITLE'); ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo Text::_('COM_HOSTING_SERVICE_NAME'); ?></th>
                                    <th><?php echo Text::_('COM_HOSTING_SERVICE_TYPE'); ?></th>
                                    <th><?php echo Text::_('COM_HOSTING_SERVICE_STATUS'); ?></th>
                                    <th><?php echo Text::_('COM_HOSTING_SERVICE_PRICE'); ?></th>
                                    <th><?php echo Text::_('COM_HOSTING_SERVICE_NEXT_PAYMENT'); ?></th>
                                    <th><?php echo Text::_('COM_HOSTING_ACTIONS'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data->services as $service) : ?>
                                <tr>
                                    <td><?php echo HTMLHelper::_('string.truncate', $service->name, 30); ?></td>
                                    <td><?php echo Text::_('COM_HOSTING_SERVICE_TYPE_' . strtoupper($service->service_type)); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $service->status === 'active' ? 'success' : ($service->status === 'suspended' ? 'warning' : 'danger'); ?>">
                                            <?php echo Text::_('COM_HOSTING_STATUS_' . strtoupper($service->status)); ?>
                                        </span>
                                    </td>
                                    <td><?php echo number_format($service->price, 2); ?> ₽</td>
                                    <td><?php echo HTMLHelper::_('date', $service->next_payment_date, 'd.m.Y'); ?></td>
                                    <td>
                                        <a href="index.php?option=com_hosting&view=service&id=<?php echo $service->id; ?>" class="btn btn-sm btn-outline-primary">
                                            <?php echo Text::_('COM_HOSTING_MANAGE'); ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Recent Transactions -->
    <?php if (!empty($data->recent_transactions)) : ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo Text::_('COM_HOSTING_RECENT_TRANSACTIONS'); ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo Text::_('COM_HOSTING_TRANSACTION_DATE'); ?></th>
                                    <th><?php echo Text::_('COM_HOSTING_TRANSACTION_TYPE'); ?></th>
                                    <th><?php echo Text::_('COM_HOSTING_TRANSACTION_DESCRIPTION'); ?></th>
                                    <th><?php echo Text::_('COM_HOSTING_TRANSACTION_AMOUNT'); ?></th>
                                    <th><?php echo Text::_('COM_HOSTING_TRANSACTION_STATUS'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data->recent_transactions as $transaction) : ?>
                                <tr>
                                    <td><?php echo HTMLHelper::_('date', $transaction->created_at, 'd.m.Y H:i'); ?></td>
                                    <td><?php echo Text::_('COM_HOSTING_TRANSACTION_TYPE_' . strtoupper($transaction->type)); ?></td>
                                    <td><?php echo HTMLHelper::_('string.truncate', $transaction->description, 40); ?></td>
                                    <td class="<?php echo $transaction->type === 'payment' ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo ($transaction->type === 'payment' ? '+' : '-') . number_format($transaction->amount, 2); ?> ₽
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger'); ?>">
                                            <?php echo Text::_('COM_HOSTING_TRANSACTION_STATUS_' . strtoupper($transaction->status)); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>