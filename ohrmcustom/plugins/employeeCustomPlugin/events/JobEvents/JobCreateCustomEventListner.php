<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/3/16
 * Time: 12:50 AM
 */
use Symfony\Component\EventDispatcher\Event;

class JobCreateCustomEventListner extends JobCreateEventListner
{
    public function onCreate(Event $event) {
        $this->container->logger->info('Job Created Custom Event Triggered', $event->getJob());
        $event->stopPropagation();
    }
}