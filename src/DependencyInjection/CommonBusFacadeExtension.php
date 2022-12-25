<?php

namespace VKCommonBusBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use VKCommonBusBundle\Facade\AbstractFacade;

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