<?php
/**
 * Description of routes.php
 *
 * @author Vladimir Gromyak
 */

define('THIRD_PARTY_LIB_PATH', dirname(__DIR__) . '/third-party-lib/');

if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', dirname(__DIR__));
}
if (!defined('APPLICATION_ENVIRONMENT')) {
    define('APPLICATION_ENVIRONMENT', getenv('APPLICATION_ENVIRONMENT') ?: 'production');
}

require_once dirname(__DIR__) . '/vendor/autoload.php';
if (APPLICATION_ENVIRONMENT == 'test') {
    require __DIR__ . '/config.test.php';
} elseif (APPLICATION_ENVIRONMENT == 'production') {
    require __DIR__ . '/config.production.php';
} else {
    require __DIR__ . '/config.php';
}

$container = new \Illuminate\Container\Container();
$container->instance('config', $config);

$app = new \Slim\Slim($config['engine']);
$app->container->set('locator', $container);
require 'locator.php';
require 'routes.php';
