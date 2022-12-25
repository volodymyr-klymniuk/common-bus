<?php

namespace VKCommonBusBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;
use VKCommonBusBundle\Facade\AbstractFacade;

final class AddFacadePass implements CompilerPassInterface
{
    /**
     * @throws \ReflectionException
     */
    public function process(ContainerBuilder $container): void
    {
        $facades = [];

        foreach ($container->findTaggedServiceIds('vk.command_bus.facade') as $id => $attr) {
            $class = $container->getDefinition($id)->getClass();
            $class = $class ?? $id;

            if (!is_subclass_of($class, AbstractFacade::class)) {
                throw new InvalidArgumentException(sprintf(
                    'The service "%s" must extend AbstractFacade.',
                    $class
                ));
            }

            $r = new \ReflectionMethod($class, 'getFacadeAccessor');
            $r->setAccessible(true);
            $ref = $r->invoke(null);

            if (!\is_string($ref)) {
                throw new InvalidArgumentException(sprintf(
                        'Facade accessor must be string, "%s" given.',
                        \is_object($ref) ? \get_class($ref) : \gettype($ref))
                );
            }

            $ref = \is_string($ref) && \str_starts_with($ref, '@') ? substr($ref, 1) : $ref;
            $facades[$id] = new Reference($ref);
        }
        $container->setAlias(
            'vk.command_bus.facade.container',
            new Alias(ServiceLocatorTagPass::register($container, $facades), true)
        );
    }
}