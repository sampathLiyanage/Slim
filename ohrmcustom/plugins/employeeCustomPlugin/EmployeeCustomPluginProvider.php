<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/4/16
 * Time: 1:39 AM
 */
class EmployeeCustomPluginProvider extends  EmployeePluginProvider
{

    public function getRoutes()
    {
        $routes = parent::getRoutes();

        $routes['get']['/employees'] = array('routeClassMethod' => '\EmployeesCustomEndPoint:get', 'middlewareClass' => 'EmployeesGetMiddleware');
        $routes['get']['/tasks'] = array('routeClassMethod' => '\EmployeeTasksEndPoint:get');
        $routes['get']['/task/{id}'] = array('routeClassMethod' => '\EmployeeTaskEndPoint:get');

        $routes['post']['/employees'] = array( 'routeClassMethod' => '\EmployeesCustomEndPoint:post');
        $routes['post']['/tasks'] = array( 'routeClassMethod' => '\EmployeesTasksEndPoint:post');

        $routes['put']['/employee/{id}'] = array( 'routeClassMethod' => '\EmployeeCustomEndPoint:put');
        $routes['put']['/task/{id}'] = array( 'routeClassMethod' => '\EmployeeTaskEndPoint:put');

        $routes['delete']['/task/{id}'] = array( 'routeClassMethod' => '\EmployeeTaskEndPoint:delete');

        return $routes;

    }

    public function registerEventListners($container)
    {
        parent::registerEventListners($container);
        OhrmEventsDispatcher::getInstance()->addListener(JobCreateEvent::NAME, array(new JobCreateCustomEventListner($container), 'onCreate'),1);
    }
}