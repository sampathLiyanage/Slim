<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$ohrmConfig = OhrmConfig::getInstance();
$settings = $ohrmConfig->getSettings();
$app = new \Slim\App(array('settings'=>$settings));

$ohrmConfig->defineContainer($app);
$ohrmConfig->defineMiddleware($app);
$ohrmConfig->defineRoutes($app);

$app->run();