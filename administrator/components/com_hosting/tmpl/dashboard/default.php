<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('bootstrap.framework');
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo Text::_('COM_HOSTING_DASHBOARD'); ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>0</h4>
                                        <p><?php echo Text::_('COM_HOSTING_TOTAL_USERS'); ?></p>
                                    </div>
                                    <div>
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>0</h4>
                                        <p><?php echo Text::_('COM_HOSTING_ACTIVE_SERVICES'); ?></p>
                                    </div>
                                    <div>
                                        <i class="fas fa-server fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>0 ₽</h4>
                                        <p><?php echo Text::_('COM_HOSTING_TOTAL_REVENUE'); ?></p>
                                    </div>
                                    <div>
                                        <i class="fas fa-ruble-sign fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>0</h4>
                                        <p><?php echo Text::_('COM_HOSTING_PENDING_TICKETS'); ?></p>
                                    </div>
                                    <div>
                                        <i class="fas fa-ticket-alt fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo Text::_('COM_HOSTING_QUICK_ACTIONS'); ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="<?php echo Route::_('index.php?option=com_hosting&view=users'); ?>" class="list-group-item list-group-item-action">
                                        <i class="fas fa-users me-2"></i>
                                        <?php echo Text::_('COM_HOSTING_MANAGE_USERS'); ?>
                                    </a>
                                    <a href="<?php echo Route::_('index.php?option=com_hosting&view=services'); ?>" class="list-group-item list-group-item-action">
                                        <i class="fas fa-server me-2"></i>
                                        <?php echo Text::_('COM_HOSTING_MANAGE_SERVICES'); ?>
                                    </a>
                                    <a href="<?php echo Route::_('index.php?option=com_hosting&view=transactions'); ?>" class="list-group-item list-group-item-action">
                                        <i class="fas fa-credit-card me-2"></i>
                                        <?php echo Text::_('COM_HOSTING_VIEW_TRANSACTIONS'); ?>
                                    </a>
                                    <a href="<?php echo Route::_('index.php?option=com_hosting&view=tickets'); ?>" class="list-group-item list-group-item-action">
                                        <i class="fas fa-ticket-alt me-2"></i>
                                        <?php echo Text::_('COM_HOSTING_MANAGE_TICKETS'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo Text::_('COM_HOSTING_RECENT_ACTIVITY'); ?></h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted"><?php echo Text::_('COM_HOSTING_NO_RECENT_ACTIVITY'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>