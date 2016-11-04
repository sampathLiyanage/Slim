<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/1/16
 * Time: 12:26 AM
 */
class AuthorizationMiddleware
{
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next) {
        $this->container->logger->info('Authorization header', array('value'=>$request->getHeaderLine('Authorization')));
        $response = $next($request, $response);
        return $response;
    }
}