<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Hosting\Site\Controller;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\Input\Input;

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
     * Constructor.
     *
     * @param   array                $config   An optional associative array of configuration settings.
     * @param   MVCFactoryInterface  $factory  The factory.
     * @param   SiteApplication      $app      The Application for the dispatcher
     * @param   Input                $input    Input
     *
     * @since   1.0.0
     */
    public function __construct($config = [], MVCFactoryInterface $factory = null, $app = null, $input = null)
    {
        parent::__construct($config, $factory, $app, $input);
    }

    /**
     * Method to display a view.
     *
     * @param   boolean  $cachable   If true, the view output will be cached
     * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link \JFilterInput::clean()}.
     *
     * @return  static  This object to support chaining.
     *
     * @since   1.0.0
     */
    public function display($cachable = false, $urlparams = [])
    {
        // Check if user is logged in
        $user = Factory::getUser();
        
        if ($user->guest) {
            $this->setRedirect('index.php?option=com_users&view=login');
            return $this;
        }

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