<?php

/*
Plugin Name: Application Insights Plugin
Description: Integrates a Joomla site with Microsoft Application Insights.
Version: 1.0
Author: URL Team
License:  GNU GPL
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
