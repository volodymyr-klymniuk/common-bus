<?php

namespace VKCommonBus\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use VKCommonBus\Facade\AbstractFacade;

final class CommonBusFacadeExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container
            ->registerForAutoconfiguration(AbstractFacade::class)
            ->addTag('command_bus.facade');
    }
}