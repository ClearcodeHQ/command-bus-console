<?php

namespace ClearcodeHQ\Bundle\CommandBusLauncherBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CommandHandlersCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $commandHandlersTags = $container->findTaggedServiceIds('command_handler');
        $commandCollector    = $container->getDefinition('command_bus_launcher.command_collector');

        $commands = [];

        foreach ($commandHandlersTags as $service) {
            foreach ($service as $tags) {
                $commands[] = $tags['handles'];
            }
        }

        $commandCollector->addMethodCall('processCommandServices', [$commands]);
    }
}
