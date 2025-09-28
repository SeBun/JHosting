<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Hosting\Site\Extension;

use Joomla\CMS\Component\Router\RouterServiceInterface;
use Joomla\CMS\Component\Router\RouterServiceTrait;
use Joomla\CMS\Extension\BootableExtensionInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\HTML\HTMLRegistryAwareTrait;
use Joomla\Component\Hosting\Site\Service\Router;
use Psr\Container\ContainerInterface;

\defined('_JEXEC') or die;

/**
 * Component class for com_hosting
 *
 * @since  1.0.0
 */
class HostingComponent extends MVCComponent implements
    BootableExtensionInterface,
    RouterServiceInterface
{
    use RouterServiceTrait;
    use HTMLRegistryAwareTrait;

    /**
     * Booting the extension. This is the function to set up the environment of the extension like
     * registering new class loaders, etc.
     *
     * If required, some initial set up can be done from services of the container, eg.
     * registering HTML services.
     *
     * @param   ContainerInterface  $container  The container
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function boot(ContainerInterface $container)
    {
        // Register additional HTML helpers if needed
    }

    /**
     * Returns the router.
     *
     * @param   string  $name  The name of the router
     *
     * @return  Router
     *
     * @since   1.0.0
     */
    public function createRouter(string $name = ''): Router
    {
        return new Router();
    }
}