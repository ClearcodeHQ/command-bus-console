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
        $this->processCommandServices($container);
        $this->processFormTypes($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function processCommandServices(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('command_bus_console.command_collector')) {
            return;
        }

        $commandHandlersTags = $container->findTaggedServiceIds('command_handler');
        $commandCollector = $container->getDefinition('command_bus_console.command_collector');

        $commands = [];

        foreach ($commandHandlersTags as $service) {
            foreach ($service as $tags) {
                $commands[] = $tags['handles'];
            }
        }

        $commandCollector->addMethodCall('processCommandServices', [$commands]);
    }

    /**
     * @param ContainerBuilder $container
     * @throws CommandFormTypeDuplicate
     * @throws CommandFormTypeMissingFormTypeTag
     */
    private function processFormTypes(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('command_bus_console.command_form_type_map')) {
            return;
        }

        $commandFormTypesTags = $container->findTaggedServiceIds('command_form_type');
        $commandFormTypesCollector = $container->getDefinition('command_bus_console.command_form_type_map');

        $commandFormTypes = [];

        foreach ($commandFormTypesTags as $serviceName => $service) {
            $allTags = $container->getDefinition($serviceName)->getTags();

            if (!array_key_exists('form.type', $allTags)) {
                throw new CommandFormTypeMissingFormTypeTag();
            }

            foreach ($allTags['command_form_type'] as $commandFormTypeTag) {
                if (array_key_exists($commandFormTypeTag['command_class'], $commandFormTypes)) {
                    throw new CommandFormTypeDuplicate();
                }

                $commandFormTypes[$commandFormTypeTag['command_class']] = $serviceName;
            }
        }

        $commandFormTypesCollector->addMethodCall('processFormTypeServices', [$commandFormTypes]);
    }
}
