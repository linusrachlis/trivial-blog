<?php

session_start();
ob_start();

define('APP_ENV', getenv('APP_ENV') ?: 'production');
define('APP_ROOT_PATH', __DIR__);

require APP_ROOT_PATH . '/vendor/autoload.php';

function env(): \app\env\Example
{
    static $env;

    if (!isset($env)) {
        $envClass = 'app\\env\\' . APP_ENV;
        $env = new $envClass;
    }

    return $env;
}
