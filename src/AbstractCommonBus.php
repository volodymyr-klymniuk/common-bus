<?php

namespace VKCommonBusBundle;

use VKCommonBusBundle\Middleware\MiddlewareInterface;
use VKCommonBusBundle\Stack\StackMiddleware;

abstract class AbstractCommonBus implements CommonBusInterface
{
    /**
     * @var Object
     */
    private $middlewareAggregate;

    public function __construct(iterable $middlewareHandlers = [])
    {
        $this->middlewareAggregate = new \ArrayObject($middlewareHandlers);
    }

    /**
     * @throws \Exception
     */
    public function dispatch($message): Envelope
    {
        if (!\is_object($message)) {
            throw new \TypeError(\sprintf(
                'Invalid argument provided to "%s()": expected object, but got %s.',
                __METHOD__,
                \gettype($message)
            ));
        }
        $isSupportableMessage = $this->supports() === \get_class($message);

        if (false === $isSupportableMessage) {
            throw new \TypeError('Bus does not support this message.');
        }
        $envelope = $message instanceof Envelope ? $message : new Envelope($message);
        $middlewareIterator = $this->middlewareAggregate->getIterator();

        while ($middlewareIterator instanceof \IteratorAggregate) {
            $middlewareIterator = $middlewareIterator->getIterator();
        }
        $middlewareIterator->rewind();

        if (!$middlewareIterator->valid()) {
            return $envelope;
        }
        $stack = new StackMiddleware($middlewareIterator);

        return $middlewareIterator->current()->handle($envelope, $stack);
    }

    abstract public function supports(): string;
}