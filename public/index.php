<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

//settings
$config = [
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => true,
    'logger' => [
        'name' => 'slim-app',
        'level' => Monolog\Logger::DEBUG,
        'path' => __DIR__ . '/../logs/app.log',
    ],
];
$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "pass";
$config['db']['dbname'] = "slim";

$app = new \Slim\App(array('settings'=>$config));

$pluginProviders = array();
$pluginProviders[] = new CoreCustomPluginProvider();
$pluginProviders[] = new EmployeeCustomPluginProvider();

$ohrmProvider = OhrmProvider::getInstance();
$ohrmProvider->setPluginProviders($pluginProviders);

$ohrmProvider->defineContainer($app);
$ohrmProvider->defineMiddleware($app);
$ohrmProvider->defineRoutes($app);
$ohrmProvider->defineEventListners($app);

$app->run();