<?php

namespace VKCommonBus\Facade;

use Psr\Container\ContainerInterface;

abstract class AbstractFacade
{
    /**
     * @var ContainerInterface
     */
    protected static $container;

    public static function setFacadeContainer(ContainerInterface $container): void
    {
        static::$container = $container;
    }

    /**
     * Handler of dynamic calls - service
     *
     * @throws \RuntimeException
     */
    abstract protected static function getFacadeAccessor(): string;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function __callStatic($method, $arguments)
    {
        $class = static::class;

        if (!static::$container->has($class)) {
            throw new \RuntimeException(sprintf('"%s" facade has not been register.', $class));
        }
        $service = static::$container->get($class);

        return $service->$method(...$arguments);
    }
}