<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$ohrmConfig = OhrmConfig::getInstance();
$app = new \Slim\App(array('settings'=>$ohrmConfig->getAppConfig()));

$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('ohrm_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

//middleware to check if the header is_logged_in there
$app->add(new AuthorizationMiddleware($container));
$app->add(new JsonTimestampMiddleware($container));

$ohrmConfig->decorateAppContainer($container);

$ohrmConfig->defineRoutes($app);

$app->run();