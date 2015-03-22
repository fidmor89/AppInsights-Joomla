<?php
/* @copyright: AyDURL @license:GPLv3 */

namespace ApplicationInsights\Joomla;

defined('_JEXEC') or die;

/**
 * Does server-side instrumentation using the PHP SDK for Application Insights
 * @copyright   Copyright 2015. All rights re-served.
 * @license     No information.
 */
class Server_Instrumentation
{
    private $_telemetryClient;
    private $_title;
    private $_startTime;
    
	/**
	 * Constructor of the class
	 */
    public function __construct($_instrumentationKey, $_title)
    {
        $this->_startTime = $this->getMicrotime();
        $this->_title = $_title;
        $this->_telemetryClient = new \ApplicationInsights\Telemetry_Client();
        $this->_telemetryClient->getContext()->setInstrumentationKey($_instrumentationKey);
        
        set_exception_handler(array($this, 'exceptionHandler'));
    }
    
	/**
	 * Get the information of the request
	 */
    function endRequest()
    {
        $url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
        $requestName = $this->getRequestName();
        $startTime = $_SERVER["REQUEST_TIME"];
        $duration = ($this->getMicrotime() - $this->_startTime) * 1000;
        $this->_telemetryClient->trackRequest($requestName, $url, $startTime, $duration);
        
        // Flush all telemetry items
        $this->_telemetryClient->flush(); 
    }

	/**
	 * Get title for post
	 *
	 * @return      string
	 */
    function getRequestName()
    {
        return $this->_title;
    }
    
	/**
	 * Sets a user-defined exception handler function
	 */
    function exceptionHandler(\Exception $exception)
    {
        if ($exception != NULL)
        {
            $this->_telemetryClient->trackException($exception);
            $this->_telemetryClient->flush();
        }
    }
    
	/**
	 * Get time
	 *
	 * @return      float
	 */
    function getMicrotime()
    {
        list($useg, $seg) = explode(" ", microtime());
        return ((float)$useg + (float)$seg);
    }
}
