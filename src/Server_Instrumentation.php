<?php

namespace ApplicationInsights\Joomla;

/**
 *  Does server-side instrumentation using the PHP SDK for Application Insights
 * 
 * @package     Joomla.Platform
 * @since       3.0
 */
class Server_Instrumentation
{
    /**
     * Telemetry context of the client
     *
     * @var    object
     * @since  3.0
     */
    private $_telemetryClient;

    /**
     * Title of the request
     *
     * @var    string
     * @since  3.0
     */
    private $_title;

    /**
     * The start time
     *
     * @var    float
     * @since  3.0
     */
    private $_startTime;
    
    /**
    * The constructor of the class	
    *

    * @package	   Joomla.Platform
    *
    * @param       string  $_instrumentationkey  
    *
	
    * @param       string  $_title
    *
    * @since       3.0  
    
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
    * Send the information to Application Insights	
    *

    * @package	   Joomla.Platform
    *
    * @since       3.0  
    
    */
    function endRequest()
    {
        $url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
        $requestName = $this->getRequestName();
        $startTime = $_SERVER["REQUEST_TIME"];
        $duration = ($this->getMicrotime() - $this->_startTime) * 1000;
        $this->_telemetryClient->trackRequest($requestName, $url, $startTime, $duration);
        echo $duration;
        // Flush all telemetry items
        $this->_telemetryClient->flush(); 
    }

    /**
    * Get the title of the request	
    *

    * @package	   Joomla.Platform
    *
    * @since       3.0  
    
    */
    function getRequestName()
    {
        return $this->_title;
    }
    
    /**
    * Sets a user-defined exception handler function	
    *

    * @package	   Joomla.Platform
    *
    * @param       exception_handler $exception 
    *
    * @since       3.0  
    
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
    * Get the current time	
    *

    * @package	   Joomla.Platform
    *
    * @return      float	
    *
    * @since       3.0  
    
    */
    function getMicrotime()
    {
        list($useg, $seg) = explode(" ", microtime());
        return ((float)$useg + (float)$seg);
    }
}
