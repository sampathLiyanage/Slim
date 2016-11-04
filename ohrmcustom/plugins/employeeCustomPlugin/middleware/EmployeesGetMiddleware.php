<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/1/16
 * Time: 1:26 AM
 */
class EmployeesGetMiddleware
{
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next) {
        $this->container->logger->info('pre executing employee get request');
        $response = $next($request, $response);
        $this->container->logger->info('post executing employee get request');
        return $response;
    }
}