<?php

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

//load environment first
if (file_exists(__DIR__ . '/environment.php')) {
    include_once __DIR__ . '/environment.php';
}

/**
 * Display all errors when APPLICATION_ENV is development.
 */
if ($_SERVER['APPLICATION_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}


if (IS_LOCAL) {
    defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__ . '/../'));
}
else {
    defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__ . '/../../../sencha_ModernTunesApi_Application'));
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
//chdir(dirname(APPLICATION_PATH));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Composer autoloading
include APPLICATION_PATH . '/vendor/autoload.php';

if (!class_exists(Application::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
        . "- Type `composer install` if you are developing locally.\n"
        . "- Type `vagrant ssh -c 'composer install'` if you are using Vagrant.\n"
        . "- Type `docker-compose run zf composer install` if you are using Docker.\n"
    );
}

// Retrieve configuration
$appConfig = require APPLICATION_PATH . '/config/application.config.php';
if (file_exists(APPLICATION_PATH . '/config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require APPLICATION_PATH . '/config/development.config.php');
}

// Run the application!
Application::init($appConfig)->run();
