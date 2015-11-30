<?php

namespace Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CommandHandlersCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('command_bus_console.command_collector')) {
            return;
        }

        $commandHandlersTags = $container->findTaggedServiceIds('command_handler');
        $commandCollector = $container->getDefinition('command_bus_console.command_collector');

        $commands = [];

        foreach ($commandHandlersTags as $service) {
            foreach ($service as $tags) {
                $arguments = ['handles'  => $tags['handles']];

                if (array_key_exists('form_type', $tags)) {
                    $arguments['form_type'] = $tags['form_type'];
                }

                $commands[] = $arguments;
            }
        }

        $commandCollector->addMethodCall('processCommandServices', [$commands]);
    }
}
