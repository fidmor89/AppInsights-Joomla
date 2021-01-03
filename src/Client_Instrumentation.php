<?php
/* @copyright: AyDURL @license:GPLv3 */

namespace ApplicationInsights\Joomla;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

/**
 * Does client-side instrumentation using the Javascript SDK for Application Insights
 * @copyright   Copyright 2015. All rights re-served.
 * @license     No information.
 */
class Client_Instrumentation
{
    /**
     * Add prefix 
     *
     * @param       string  $_instrumentationkey  
     *
     * @param       string  $_title  
     */
    function addPrefix($_instrumentationkey, $_title)
    {
        $rawSnippet = <<<JOOMLAAISCRIPT
var sdkInstance="appInsightsSDK";window[sdkInstance]="appInsights";var aiName=window[sdkInstance],aisdk=window[aiName]||function(e){function n(e){t[e]=function(){var n=arguments;t.queue.push(function(){t[e].apply(t,n)})}}var t={config:e};t.initialize=!0;var i=document,a=window;setTimeout(function(){var n=i.createElement("script");n.src=e.url||"https://az416426.vo.msecnd.net/scripts/b/ai.2.min.js",i.getElementsByTagName("script")[0].parentNode.appendChild(n)});try{t.cookie=i.cookie}catch(e){}t.queue=[],t.version=2;for(var r=["Event","PageView","Exception","Trace","DependencyData","Metric","PageViewPerformance"];r.length;)n("track"+r.pop());n("startTrackPage"),n("stopTrackPage");var s="Track"+r[0];if(n("start"+s),n("stop"+s),n("setAuthenticatedUserContext"),n("clearAuthenticatedUserContext"),n("flush"),!(!0===e.disableExceptionTracking||e.extensionConfig&&e.extensionConfig.ApplicationInsightsAnalytics&&!0===e.extensionConfig.ApplicationInsightsAnalytics.disableExceptionTracking)){n("_"+(r="onerror"));var o=a[r];a[r]=function(e,n,i,a,s){var c=o&&o(e,n,i,a,s);return!0!==c&&t["_"+r]({message:e,url:n,lineNumber:i,columnNumber:a,error:s}),c},e.autoExceptionInstrumented=!0}return t}(
{
    instrumentationKey:"INSTRUMENTATION_KEY"
}
);window[aiName]=aisdk,aisdk.queue&&0===aisdk.queue.length&&aisdk.trackPageView({});
window.appInsights.trackPageView({name: 'PAGE_NAME', url: 'PAGE_URL'});
JOOMLAAISCRIPT;
        
        $patterns = array();
        $replacements = array();

        $patterns[0] = '/INSTRUMENTATION_KEY/';
        $patterns[1] = '/PAGE_NAME/';
        $patterns[2] = '/PAGE_URL/';

        // Sets Instrumentation Key
        $replacements[0] = $_instrumentationkey;

        // Sets the page title
        $replacements[1] = json_encode($_title, JSON_HEX_APOS);

        // Validate if displaying home page
        if ($_title == 'Home') {
            $replacements[2] = 'window.location.origin';
        } else {
            $replacements[2] = 'window.location.origin + "/' . rawurlencode($_title) . '"';
        }
        
        $document = Factory::getDocument();

        // Add Javascript
        $document->addScriptDeclaration(preg_replace($patterns, $replacements, $rawSnippet));
    }
}
