<?php

namespace VKCommonBusBundle\Middleware;

use Psr\Log\LoggerInterface;
use VKCommonBusBundle\Envelope;
use VKCommonBusBundle\Stack\StackInterface;

class LoggingMiddleware implements MiddlewareInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();
        $context = [
            'message' => $message,
            'class' => \get_class($envelope->getMessage()),
        ];
        $this->logger->debug('Starting handling message "{class}"', $context);

        try {
            $envelope = $stack->next()->handle($envelope, $stack);
        } catch (\Throwable $e) {
            $context['exception'] = $e;
            $this->logger->warning('An exception occurred while handling message "{class}"', $context);

            throw $e;
        }

        $this->logger->debug('Finished handling message "{class}"', $context);

        return $envelope;
    }
}