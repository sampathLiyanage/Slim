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

    public function getAppConfig() {
        $config = [
            'settings' => [
                'displayErrorDetails' => true,
                'determineRouteBeforeAppMiddleware' => true,
                'logger' => [
                    'name' => 'slim-app',
                    'level' => Monolog\Logger::DEBUG,
                    'path' => __DIR__ . '/../logs/app.log',
                ],
            ],
        ];

        $config['db']['host']   = "localhost";
        $config['db']['user']   = "root";
        $config['db']['pass']   = "pass";
        $config['db']['dbname'] = "slim";
        return $config;
    }

    public function decorateAppContainer($container) {
        //to modify current dependancies and to add new ones
    }

    public function defineRoutes($app) {

        //employees
        $app->get('/employees', '\EmployeesEndPoint:get');

        $app->get('/employee/{id}', '\EmployeesEndPoint:get');

        $app->post('/employees', '\EmployeesCustomEndPoint:post');

        $app->put('/employee/{id}', '\EmployeeCustomEndPoint:put');

        $app->delete('/employee/{id}', '\EmployeeEndPoint:delete');

        //job
        $app->get('/jobs', '\JobsEndPoint:get');

        $app->get('/job/{id}', '\JobEndPoint:get');

        $app->post('/jobs', '\JobEndPoint:post');

        $app->put('/job/{id}', '\JobEndPoint:put');

        $app->delete('/job/{id}', '\JobEndPoint:delete');

        //task
        $app->get('/tasks', '\EmployeeTasksEndPoint:get');

        $app->get('/task/{id}', '\EmployeeTaskEndPoint:get');

        $app->post('/tasks', '\EmployeeTasksEndPoint:post');

        $app->put('/task/{id}', '\EmployeeTaskEndPoint:put');

        $app->delete('/task/{id}', '\EmployeeTaskEndPoint:delete');

    }


}