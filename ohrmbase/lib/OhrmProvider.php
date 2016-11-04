<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/28/16
 * Time: 2:30 AM
 */
class OhrmProvider
{
    private static $instance;
    private $pluginProviders;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new OhrmProvider();
        }

        return static::$instance;
    }

    protected function __construct(){

    }

    public function setPluginProviders($pluginProviders) {
        $this->pluginProviders = $pluginProviders;
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

        foreach($this->pluginProviders as $pluginProvider) {
            $dependancies = $pluginProvider->getDependancies();
            foreach($dependancies as $key=>$dependancy) {
                $container[$key] = $dependancy;
            }
        }
    }

    public function defineMiddleware($app) {
        foreach($this->pluginProviders as $pluginProvider) {
            $middlewareClassNames = $pluginProvider->getMiddleware();
            foreach($middlewareClassNames as $middlewareClassName) {
                $app->add(new $middlewareClassName($app->getContainer()));
            }
        }
    }

    public function defineRoutes($app) {

        foreach($this->pluginProviders as $pluginProvider) {
            $routes = $pluginProvider->getRoutes();
            foreach ($routes['get'] as $key => $route) {
                $routeObj = $app->get($key, $route['routeClassMethod']);
                if ($route['middlewareClass']){
                    $middleware = new $route['middlewareClass']($app->getContainer());
                    $routeObj->add($middleware);
                }
            }
            foreach ($routes['post'] as $key => $route) {
                $routeObj = $app->post($key, $route['routeClassMethod']);
                if ($route['middlewareClass']){
                    $middleware = new $route['middlewareClass']($app->getContainer());
                    $routeObj->add($middleware);
                }
            }
            foreach ($routes['put'] as $key => $route) {
                $routeObj = $app->put($key, $route['routeClassMethod']);
                if ($route['middlewareClass']){
                    $middleware = new $route['middlewareClass']($app->getContainer());
                    $routeObj->add($middleware);
                }
            }
            foreach ($routes['delete'] as $key => $route) {
                $routeObj = $app->delete($key, $route['routeClassMethod']);
                if ($route['middlewareClass']){
                    $middleware = new $route['middlewareClass']($app->getContainer());
                    $routeObj->add($middleware);
                }
            }
        }
    }

    public function defineEventListners($app) {
        $container = $app->getContainer();
        foreach($this->pluginProviders as $pluginProvider) {
            $pluginProvider->registerEventListners($container);
        }
    }

    public function defineCliCommands($cli) {
        foreach($this->pluginProviders as $pluginProvider) {
            $pluginProvider->registerCliCommands($cli);
        }
    }


}