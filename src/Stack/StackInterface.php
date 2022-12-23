<?php

namespace VKCommonBus\Stack;

use VKCommonBus\Middleware\MiddlewareInterface;

interface StackInterface
{
    /**
     * Returns the next middleware to process a message.
     *
     * @return MiddlewareInterface
     */
    public function next(): MiddlewareInterface;
}