<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/1/16
 * Time: 12:26 AM
 */
class JsonTimestampMiddleware
{
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    protected function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function __invoke($request, $response, $next) {
        $response = $next($request, $response);
        $bodyContent = $response->getBody()->__toString();
        if ($this->isJson($bodyContent)) {
            $responseContentArray['data'] = json_decode($bodyContent);
            $responseContentArray['timestamp'] = date('m/d/Y h:i:s a', time());
            $body = new \Slim\Http\Body(fopen('php://temp', 'r+'));
            $body->write(json_encode($responseContentArray));

            return $response->withBody($body);
        }
        return $response;
    }
}