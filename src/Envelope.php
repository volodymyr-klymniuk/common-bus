<?php

namespace VKCommonBus;

final class Envelope
{
    private array $items = [];
    private $message;

    /**
     * @param object                  $message
     * @param EnvelopeItemInterface[] $items
     */
    public function __construct(object $message, array $items = [])
    {
        $this->message = $message;

        foreach ($items as $item) {
            $this->items[\get_class($item)] = $item;
        }
    }
    /**
     * Wrap a message into an envelope if not already wrapped.
     *
     * @param Envelope|object $message
     *
     * @return Envelope
     */
    public static function wrap($message): self
    {
        return $message instanceof self ? $message : new self($message);
    }

    /**
     * @param EnvelopeItemInterface $item
     *
     * @return Envelope a new Envelope instance with additional item
     */
    public function with(EnvelopeItemInterface $item): self
    {
        $cloned = clone $this;
        $cloned->items[\get_class($item)] = $item;

        return $cloned;
    }

    /**
     * @param $message
     *
     * @return Envelope
     */
    public function withMessage($message): self
    {
        $cloned = clone $this;
        $cloned->message = $message;

        return $cloned;
    }

    /**
     * @param string $itemFqcn
     *
     * @return EnvelopeItemInterface|null
     */
    public function get(string $itemFqcn): ?EnvelopeItemInterface
    {
        return $this->items[$itemFqcn] ?? null;
    }

    /**
     * @return EnvelopeItemInterface[] indexed by fqcn
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @return object The original message contained in the envelope
     */
    public function getMessage(): object
    {
        return $this->message;
    }
}