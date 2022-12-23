<?php

namespace VKCommonBus\Stack;

use VKCommonBus\Envelope;
use VKCommonBus\Middleware\MiddlewareInterface;

class StackMiddleware implements MiddlewareInterface, StackInterface
{
    /**
     * @var \Iterator|null
     */
    private $middlewareIterator;

    /**
     * @param \Iterator|null $middlewareIterator
     */
    public function __construct(\Iterator $middlewareIterator = null)
    {
        $this->middlewareIterator = $middlewareIterator;
    }

    /**
     * @inheritdoc
     */
    public function next(): MiddlewareInterface
    {
        if (null === $iterator = $this->middlewareIterator) {
            return $this;
        }
        $iterator->next();

        if (!$iterator->valid()) {
            $this->middlewareIterator = null;

            return $this;
        }

        return $iterator->current();
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        return $envelope;
    }
}