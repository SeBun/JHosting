<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_hosting  
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;

$currentView = Factory::getApplication()->input->get('view', 'dashboard');
?>

<div class="hosting-sidebar">
    <nav class="nav flex-column">
        <a class="nav-link <?php echo $currentView === 'dashboard' ? 'active' : ''; ?>" href="<?php echo Route::_('index.php?option=com_hosting&view=dashboard'); ?>">
            <i class="fas fa-wallet"></i>
            Баланс
            <span class="ms-auto">0,00 ₽</span>
        </a>
        <a class="nav-link <?php echo $currentView === 'services' ? 'active' : ''; ?>" href="<?php echo Route::_('index.php?option=com_hosting&view=services'); ?>">
            <i class="fas fa-server"></i>
            Мои услуги
        </a>
        <a class="nav-link <?php echo $currentView === 'settings' ? 'active' : ''; ?>" href="<?php echo Route::_('index.php?option=com_hosting&view=settings'); ?>">
            <i class="fas fa-cog"></i>
            Настройки
        </a>
        <a class="nav-link <?php echo $currentView === 'billing' ? 'active' : ''; ?>" href="<?php echo Route::_('index.php?option=com_hosting&view=billing'); ?>">
            <i class="fas fa-history"></i>
            История
        </a>
        <a class="nav-link <?php echo $currentView === 'profile' ? 'active' : ''; ?>" href="<?php echo Route::_('index.php?option=com_hosting&view=profile'); ?>">
            <i class="fas fa-user"></i>
            Профили
        </a>
        <a class="nav-link <?php echo $currentView === 'tickets' ? 'active' : ''; ?>" href="<?php echo Route::_('index.php?option=com_hosting&view=tickets'); ?>">
            <i class="fas fa-envelope"></i>
            Связаться с нами
        </a>
    </nav>
</div>