<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/4/16
 * Time: 1:39 AM
 */
class CorePluginProvider implements PluginProvider
{

    public function getRoutes()
    {
        return array();
    }

    public function getDependancies()
    {
        return array();
    }

    public function getMiddleware()
    {
        return array('AuthorizationMiddleware');
    }

    public function registerEventListners($container)
    {

    }

    public function registerCliCommands($cli)
    {

    }

}