<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/28/16
 * Time: 2:30 AM
 */
class OhrmConfig
{
    private static $instance;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new OhrmConfig();
        }

        return static::$instance;
    }

    protected function __construct(){

    }

    public function getSettings() {
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
        return $config;
    }

    public function defineContainer($app) {
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
        return $container;
    }

    public function defineMiddleware($app) {
        $app->add(new AuthorizationMiddleware($app->getContainer()));
        $app->add(new JsonTimestampMiddleware($app->getContainer()));
    }

    public function defineRoutes($app) {

        //employees
        $app->get('/employees', '\EmployeesCustomEndPoint:get')->add(new EmployeesGetMiddleware($app->getContainer()));

        $app->get('/employee/{id}', '\EmployeesEndPoint:get');

        $app->post('/employees', '\EmployeesCustomEndPoint:post');

        $app->put('/employee/{id}', '\EmployeeCustomEndPoint:put');

        $app->delete('/employee/{id}', '\EmployeeEndPoint:delete');

        //job
        $app->get('/jobs', '\JobsEndPoint:get');

        $app->get('/job/{id}', '\JobEndPoint:get');

        $app->post('/jobs', '\JobsEndPoint:post');

        $app->put('/job/{id}', '\JobEndPoint:put');

        $app->delete('/job/{id}', '\JobEndPoint:delete');

        //task
        $app->get('/tasks', '\EmployeeTasksEndPoint:get');

        $app->get('/task/{id}', '\EmployeeTaskEndPoint:get');

        $app->post('/tasks', '\EmployeeTasksEndPoint:post');

        $app->put('/task/{id}', '\EmployeeTaskEndPoint:put');

        $app->delete('/task/{id}', '\EmployeeTaskEndPoint:delete');

    }

    public function defineEventListners($app) {
        $container = $app->getContainer();
        OhrmEventsDispatcher::getInstance()->addListener(JobCreateEvent::NAME, array(new JobCreateEventListner($container['logger']), 'onCreate'));
        OhrmEventsDispatcher::getInstance()->addListener(JobCreateEvent::NAME, array(new JobCreateCustomEventListner($container['logger']), 'onCreate'),1);
    }

    public function defineCliCommands($cli) {
        $cli->add(new \AppBundle\Command\GetUserCountCommand());
    }


}