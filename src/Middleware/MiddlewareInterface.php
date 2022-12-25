<?php

namespace VKCommonBusBundle\Middleware;

use VKCommonBusBundle\Envelope;
use VKCommonBusBundle\Stack\StackInterface;

interface MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope;
}