# AppInsights-Joomla
Main development repository for Application Insights Joomla plugin.

## Contributors ##
  - Fidel Esteban Morales Cifuentes
  - Juan Manuel Lopez Lucero
  - Jose Luis Morales Ruiz
  - Giorgio Balconi
  - Gustavo Andres Zamora Sosa
  - Hugo Orozco
  - Jose Carlos Mendez
  - Jose Rodrigo Gonzalez
  - Josue Mazariegos
  - Manuel Santizo
  - Erick Diaz
  - Raul Guerra Gomez
  

Tags: Application Insights

Requires at least: 3.x

Tested on: 3.4

License: GNU GPL 3.0

License URI: http://opensource.org/licenses/GPL-3.0



Integrates a Joomla site with Microsoft Application Insights.



## Description ##

Integrates a Joomla site with Microsoft Application Insights. More information about Application Insights can be found <a href='http://azure.microsoft.com/en-us/documentation/articles/app-insights-get-started/'>here</a>. 
Other SDKs and documentation can be found <a href='https://github.com/Microsoft/AppInsights-Home'>here</a>.

## Composer Usage ##

We are using a package published by Microsoft.  You can find it on [Packagist](https://packagist.org/packages/microsoft/application-insights). In order to use it, first, you'll need to get [Composer](https://getcomposer.org/). 

Once you've setup your project to use Composer, just add a reference to our package with whichever version you'd like to use to your composer.json file.

```json
require: "microsoft/application-insights": "*"
```

Make sure you add the require statement to pull in the library:

```php
require_once 'vendor/autoload.php';
```



## Changelog ##

= 1.0 = * Initial Version
