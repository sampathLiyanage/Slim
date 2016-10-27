<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/27/16
 * Time: 10:58 PM
 */


Abstract class CollectionEndpoint extends ApiEndPoint
{
    abstract public function post($request, $response);

    abstract public function get($request, $response);

    abstract public function delete($request, $response);

}