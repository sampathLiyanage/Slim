<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/4/16
 * Time: 1:45 AM
 */
interface PluginProvider
{
    public function getRoutes();
    public function getDependancies();
    public function getMiddleware();
    public function registerEventListners($container);
    public function registerCliCommands($cli);
}