<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Hosting\Site\View\Settings;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;

\defined('_JEXEC') or die;

/**
 * Settings view for Hosting component
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The settings data
     *
     * @var    object
     * @since  1.0.0
     */
    protected $settings;

    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function display($tpl = null)
    {
        // Get data from the model
        $this->settings = $this->get('Settings');

        // Check for errors
        if (count($errors = $this->get('Errors'))) {
            Factory::getApplication()->enqueueMessage(implode('<br>', $errors), 'error');
            return;
        }

        // Prepare the document
        $this->prepareDocument();

        parent::display($tpl);
    }

    /**
     * Prepares the document
     *
     * @return  void
     *
     * @since   1.0.0
     */
    protected function prepareDocument()
    {
        $doc = Factory::getDocument();
        
        // Set page title
        $doc->setTitle('Настройки - Хостинг');
        
        // Add CSS and JS
        $doc->addStyleSheet('media/com_hosting/css/bootstrap.min.css');
        $doc->addStyleSheet('media/com_hosting/css/fontawesome.min.css');
        $doc->addStyleSheet('media/com_hosting/css/hosting.css');
        $doc->addScript('media/com_hosting/js/bootstrap.bundle.min.js');
        $doc->addScript('media/com_hosting/js/hosting.js');
    }
}