<?php

namespace VKCommonBus\Middleware;

use VKCommonBus\Envelope;
use VKCommonBus\Stack\StackInterface;

interface MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope;
}