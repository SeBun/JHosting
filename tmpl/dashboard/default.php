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
use Joomla\CMS\Router\Route;

/** @var \Joomla\Component\Hosting\Site\View\Dashboard\HtmlView $this */

$data = $this->data;
?>

<div class="container-fluid hosting-dashboard">
    <!-- Sidebar Navigation -->
    <div class="row">
        <div class="col-md-3">
            <div class="hosting-sidebar">
                <nav class="nav flex-column">
                    <a class="nav-link active" href="<?php echo Route::_('index.php?option=com_hosting&view=dashboard'); ?>">
                        <i class="fas fa-wallet"></i>
                        <?php echo Text::_('COM_HOSTING_DASHBOARD_TITLE'); ?>
                        <span class="ms-auto">0,00 ₽</span>
                    </a>
                    <a class="nav-link" href="<?php echo Route::_('index.php?option=com_hosting&view=services'); ?>">
                        <i class="fas fa-server"></i>
                        <?php echo Text::_('COM_HOSTING_SERVICES_TITLE'); ?>
                    </a>
                    <a class="nav-link" href="<?php echo Route::_('index.php?option=com_hosting&view=settings'); ?>">
                        <i class="fas fa-cog"></i>
                        <?php echo Text::_('COM_HOSTING_SETTINGS_TITLE'); ?>
                    </a>
                    <a class="nav-link" href="<?php echo Route::_('index.php?option=com_hosting&view=billing'); ?>">
                        <i class="fas fa-history"></i>
                        <?php echo Text::_('COM_HOSTING_BILLING_TITLE'); ?>
                    </a>
                    <a class="nav-link" href="<?php echo Route::_('index.php?option=com_hosting&view=profile'); ?>">
                        <i class="fas fa-user"></i>
                        <?php echo Text::_('COM_HOSTING_PROFILE_TITLE'); ?>
                    </a>
                    <a class="nav-link" href="<?php echo Route::_('index.php?option=com_hosting&view=tickets'); ?>">
                        <i class="fas fa-envelope"></i>
                        <?php echo Text::_('COM_HOSTING_TICKETS_TITLE'); ?>
                    </a>
                </nav>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Main Content -->
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="mb-3"><?php echo Text::_('COM_HOSTING_DASHBOARD_TITLE'); ?></h2>
                </div>
            </div>

            <!-- Balance Section -->
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
                                    <button class="btn btn-warning btn-lg" data-action="topup-balance"><?php echo Text::_('COM_HOSTING_BALANCE_TOPUP'); ?></button>
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
                                    <p class="card-text text-muted"><?php echo Text::_('COM_HOSTING_SERVICES_EXPIRING'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Привязанные способы оплаты</h5>
                            <div class="d-flex gap-2 mb-3">
                                <button class="btn btn-warning">Привязать СБП</button>
                                <button class="btn btn-outline-warning">Привязать карту</button>
                            </div>
                            
                            <h6 class="mb-3">Банковские карты</h6>
                            <div class="d-flex align-items-center p-3 border rounded">
                                <div class="me-3">
                                    <i class="fab fa-cc-mastercard fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">427660••••5939</div>
                                </div>
                                <div>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0"><?php echo Text::_('COM_HOSTING_RECENT_TRANSACTIONS'); ?></h5>
                                <a href="<?php echo Route::_('index.php?option=com_hosting&view=billing'); ?>" class="btn btn-outline-primary btn-sm">
                                    Полная история платежей и списаний доступна в разделе <strong>История</strong>
                                </a>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Дата и время</th>
                                            <th>Тип операции</th>
                                            <th>Сумма</th>
                                            <th>Наименование</th>
                                            <th>Статус</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div>25.11.2024</div>
                                                <small class="text-muted">15:38</small>
                                            </td>
                                            <td>Оплата</td>
                                            <td class="text-danger">-849 ₽</td>
                                            <td>Продление vintehnikum.ru</td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-credit-card me-1"></i> Оплата
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>25.11.2023</div>
                                                <small class="text-muted">15:44</small>
                                            </td>
                                            <td>Оплата</td>
                                            <td class="text-danger">-799 ₽</td>
                                            <td>Продление vintehnikum.ru</td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-credit-card me-1"></i> Оплата
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>05.12.2022</div>
                                                <small class="text-muted">10:29</small>
                                            </td>
                                            <td>Оплата</td>
                                            <td class="text-danger">-799 ₽</td>
                                            <td>Продление vintehnikum.ru</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-university me-1"></i> Оплата
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>