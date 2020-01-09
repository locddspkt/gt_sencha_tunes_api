<?php
/**
 * Created by PhpStorm.
 * User: locdd
 * Date: 10/3/17
 * Time: 09:57
 */

//is local = true only for loc test my.turncollc, for phpunit when HTTP_POST is empty
//change: except the server domain all is local
//todo: Because D90 is supported on all the environments, we should remove it
$host = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'';
switch (true) {
    case $host == 'zf-tutorial.localhost':
        define('IS_LOCAL', true);
        $_SERVER['APPLICATION_ENV'] = 'development';
        break;
    case $host == 'sencha.hptsoft.com':
        define('IS_LOCAL', false);
        $_SERVER['APPLICATION_ENV'] = 'production';
        break;
}