<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Hosting\Site\Service;

use Joomla\CMS\Component\Router\RouterBase;

\defined('_JEXEC') or die;

/**
 * Routing class for com_hosting
 *
 * @since  1.0.0
 */
class Router extends RouterBase
{
    /**
     * Build the route for the com_hosting component
     *
     * @param   array  &$query  An array of URL arguments
     *
     * @return  array  The URL arguments to use to assemble the subsequent URL.
     *
     * @since   1.0.0
     */
    public function build(&$query)
    {
        $segments = [];

        if (isset($query['view'])) {
            $segments[] = $query['view'];
            unset($query['view']);
        }

        if (isset($query['id'])) {
            $segments[] = $query['id'];
            unset($query['id']);
        }

        return $segments;
    }

    /**
     * Parse the segments of a URL.
     *
     * @param   array  &$segments  The segments of the URL to parse.
     *
     * @return  array  The URL attributes to be used by the application.
     *
     * @since   1.0.0
     */
    public function parse(&$segments)
    {
        $vars = [];

        if (!empty($segments[0])) {
            $vars['view'] = $segments[0];
        }

        if (!empty($segments[1])) {
            $vars['id'] = (int) $segments[1];
        }

        return $vars;
    }
}