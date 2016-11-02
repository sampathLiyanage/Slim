<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/3/16
 * Time: 12:47 AM
 */
use Symfony\Component\EventDispatcher\EventDispatcher;

class OhrmEventsDispatcher
{
    private static $instance;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new EventDispatcher();
        }

        return static::$instance;
    }

    protected function __construct(){

    }
}