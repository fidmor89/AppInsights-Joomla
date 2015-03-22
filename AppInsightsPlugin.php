<?php

/*
AppInsightsPlugin, integrates a Joomla site with Microsoft Application Insights
Copyright (C) 2015  AyDURL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

defined('_JEXEC') or die;


require_once 'vendor/autoload.php';
require_once 'vendor/microsoft/application-insights/vendor/autoload.php';

class plgSystemAppInsightsPlugin extends JPlugin
{
    // Enables server-side instrumentation
    function onAfterDispatch()
    {
        if (JFactory::getApplication()->isSite())
        {
            $doc = JFactory::getDocument(); 
            $serverInstrumentation = new ApplicationInsights\Joomla\Server_Instrumentation($this->params->get('instrumentationkey'), $doc->getTitle());

            register_shutdown_function(array($serverInstrumentation, 'endRequest'));
        } 
    }

    // Enables client-side instrumentation
    function onBeforeCompileHead()
    {
        if (JFactory::getApplication()->isSite())
        {
            $doc = JFactory::getDocument();
            $clientInstrumentation = new ApplicationInsights\Joomla\Client_Instrumentation();
            $clientInstrumentation->addPrefix($this->params->get('instrumentationkey'), $doc->getTitle());
        }
    }
}
