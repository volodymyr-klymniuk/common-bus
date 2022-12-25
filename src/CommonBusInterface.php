<?php

namespace VKCommonBusBundle;

interface CommonBusInterface
{
    /**
     * Dispatches the given message.
     *
     * @param object|Envelope $message
     *
     * @return Envelope
     */
    public function dispatch($message): Envelope;
}