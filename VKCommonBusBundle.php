<?php

namespace VKCommonBus;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use VKCommonBus\DependencyInjection\Compiler\AddFacadePass;
use VKCommonBus\Facade\AbstractFacade;
use Psr\Container\ContainerInterface;

class VKCommonBusBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        parent::boot();

        $container = $this->container->get('vk.common_bus.facade.container');
        AbstractFacade::setFacadeContainer($container);
    }

    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new AddFacadePass());
    }
}