<?php

namespace VKCommonBus\Command;

interface CommandInterface
{
    /**
     * Executor interface
     */
    public function execute(): void;
}