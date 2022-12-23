<?php

namespace VKCommonBus;

interface MessageBusInterface
{
    /**
     * @param object|Envelope $message The message with pre-wrapper envloped data
     *
     * @return Envelope
     */
    public function dispatch($message): Envelope;
}