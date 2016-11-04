<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/4/16
 * Time: 1:39 AM
 */
class EmployeePluginProvider implements PluginProvider
{

    public function getRoutes()
    {
        $getRoutes = array(
            '/employees' => array('routeClassMethod' => '\EmployeesEndPoint:get', 'middlewareClass' => 'EmployeesGetMiddleware'),
            '/employee/{id}' => array('routeClassMethod' => '\EmployeesEndPoint:get'),
            '/jobs' => array('routeClassMethod' => '\JobsEndPoint:get'),
            '/job/{id}' => array( 'routeClassMethod' => '\JobEndPoint:get')
        );

        $postRoutes = array(
            '/employees' => array( 'routeClassMethod' => '\EmployeesEndPoint:post'),
            '/employee/{id}' => array( 'routeClassMethod' => '\EmployeeEndPoint:post'),
            '/jobs' => array( 'routeClassMethod' => '\JobsEndPoint:post')
        );

        $putRoutes = array(
            '/employee/{id}' => array( 'routeClassMethod' => '\EmployeeEndPoint:put'),
            '/job/{id}' => array( 'routeClassMethod' => '\JobEndPoint:put'),
            '/task/{id}' => array( 'routeClassMethod' => '\EmployeeTaskEndPoint:put')
        );

        $deleteRoutes = array(
            '/employee/{id}' => array( 'routeClassMethod' => '\EmployeeEndPoint::delete'),
            '/job/{id}' => array( 'routeClassMethod' => '\JobEndPoint::delete'),
            '/task/{id}' => array( 'routeClassMethod' => '\EmployeeTaskEndPoint::delete')
        );

        return array(
            'get' => $getRoutes,
            'post' => $postRoutes,
            'put' => $putRoutes,
            'delete' => $deleteRoutes
        );

    }

    public function getDependancies()
    {
        return array();
    }

    public function getMiddleware()
    {
        return array();
    }

    public function registerEventListners($container)
    {
        OhrmEventsDispatcher::getInstance()->addListener(JobCreateEvent::NAME, array(new JobCreateEventListner($container), 'onCreate'));
    }

    public function registerCliCommands($cli)
    {
        $cli->add(new \AppBundle\Command\GetUserCountCommand());
    }
}