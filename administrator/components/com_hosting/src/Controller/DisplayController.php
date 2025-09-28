<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Hosting\Administrator\Controller;

use Joomla\CMS\MVC\Controller\BaseController;

\defined('_JEXEC') or die;

/**
 * Hosting Component Display Controller
 *
 * @since  1.0.0
 */
class DisplayController extends BaseController
{
    /**
     * The default view.
     *
     * @var    string
     * @since  1.0.0
     */
    protected $default_view = 'dashboard';

    /**
     * Method to display a view.
     *
     * @param   boolean  $cachable   If true, the view output will be cached
     * @param   array    $urlparams  An array of safe URL parameters and their variable types
     *
     * @return  static  This object to support chaining.
     *
     * @since   1.0.0
     */
    public function display($cachable = false, $urlparams = [])
    {
        $view = $this->input->get('view', $this->default_view);
        $layout = $this->input->get('layout', 'default');

        // Set safe URL parameters
        $safeurlparams = [
            'view' => 'CMD',
            'layout' => 'CMD',
            'id' => 'INT',
            'task' => 'CMD',
            'format' => 'CMD',
        ];

        return parent::display($cachable, $safeurlparams);
    }
}