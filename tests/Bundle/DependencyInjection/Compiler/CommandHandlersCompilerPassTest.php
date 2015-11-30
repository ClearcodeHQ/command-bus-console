<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler;

use Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler\CommandHandlersCompilerPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class CommandHandlersCompilerPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function it_should_collects_classes_names_by_adding_method_when_there_is_handles_argument()
    {
        $collectingService = new Definition();
        $this->setDefinition('command_bus_console.command_collector', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('command_handler', ['handles' => 'test_class']);
        $this->setDefinition('colected_service_id', $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'command_bus_console.command_collector',
            'processCommandServices',
            [[['handles' => 'test_class']]]
        );
    }

    /**
     * @test
     */
    public function it_should_collects_classes_names_and_form_types_by_adding_method_when_there_is_form_type_argument()
    {
        $collectingService = new Definition();
        $this->setDefinition('command_bus_console.command_collector', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('command_handler', ['handles' => 'test_class', 'form_type' => 'form_type_name']);
        $this->setDefinition('colected_service_id', $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'command_bus_console.command_collector',
            'processCommandServices',
            [[[
                'handles'   => 'test_class',
                'form_type' => 'form_type_name'
            ]]]
        );
    }

    /**
     * Register the compiler pass under test, just like you would do inside a bundle's load()
     * method:
     *
     *   $container->addCompilerPass(new MyCompilerPass());
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CommandHandlersCompilerPass());
    }
}