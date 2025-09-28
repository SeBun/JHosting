<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Hosting\Site\View\Dashboard;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;

\defined('_JEXEC') or die;

/**
 * Dashboard view for Hosting component
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The dashboard data
     *
     * @var    object
     * @since  1.0.0
     */
    protected $data;

    /**
     * The page class suffix
     *
     * @var    string
     * @since  1.0.0
     */
    protected $pageclass_sfx = '';

    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function display($tpl = null)
    {
        // Get data from the model
        $this->data = $this->get('DashboardData');

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
        $app = Factory::getApplication();
        $doc = Factory::getDocument();
        
        // Set page title
        $doc->setTitle('Личный кабинет - Хостинг');
        
        // Add CSS for the component
        $doc->addStyleSheet('media/com_hosting/css/bootstrap.min.css');
        $doc->addStyleSheet('media/com_hosting/css/fontawesome.min.css');
        $doc->addStyleSheet('media/com_hosting/css/hosting.css');
        
        // Add JavaScript
        $doc->addScript('media/com_hosting/js/bootstrap.bundle.min.js');
        $doc->addScript('media/com_hosting/js/hosting.js');
    }
}