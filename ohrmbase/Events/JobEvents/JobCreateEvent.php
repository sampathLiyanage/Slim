<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/3/16
 * Time: 12:47 AM
 */
use Symfony\Component\EventDispatcher\Event;


class JobCreateEvent extends Event
{
    const NAME = 'job.create';

    protected $order;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function getJob()
    {
        return $this->job;
    }
}