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

/** @var \Joomla\Component\Hosting\Site\View\Settings\HtmlView $this */
?>

<div class="container-fluid hosting-dashboard">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <?php echo $this->loadTemplate('sidebar'); ?>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9">
            <?php include JPATH_COMPONENT . '/site/views/settings.php'; ?>
        </div>
    </div>
</div>