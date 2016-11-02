<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/3/16
 * Time: 12:50 AM
 */
use Symfony\Component\EventDispatcher\Event;

class JobCreateEventListner
{
    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function onCreate(Event $event) {
        $this->logger->info('Job Created Event Triggered', $event->getJob());
    }
}