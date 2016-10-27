<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$config = [
    'settings' => [
        'displayErrorDetails' => true,

        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log',
        ],
    ],
];
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "pass";
$config['db']['dbname'] = "slim";

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
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

//employees
$app->get('/employees', '\EmployeesEndPoint:get');

$app->get('/employee/{id}', '\EmployeeEndPoint:get');

$app->post('/employees', '\EmployeeEndPoint:post');

$app->put('/employee/{id}', '\EmployeeEndPoint:put');

$app->delete('/employee/{id}', '\EmployeeEndPoint:delete');

//job
$app->get('/jobs', '\JobsEndPoint:get');

$app->get('/job/{id}', '\JobEndPoint:get');

$app->post('/jobs', '\JobEndPoint:post');

$app->put('/job/{id}', '\JobEndPoint:put');

$app->delete('/job/{id}', '\JobEndPoint:delete');


$app->run();