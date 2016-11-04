<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/4/16
 * Time: 1:39 AM
 */
class CoreCustomPluginProvider extends  CorePluginProvider
{
    public function getMiddleware()
    {
        $middleware = parent::getMiddleware();
        $middleware[] = 'JsonTimestampMiddleware';
        return $middleware;
    }
}