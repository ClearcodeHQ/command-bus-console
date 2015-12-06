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
            [['test_class']]
        );
    }

    /**
     * @test
     */
    public function it_should_collects_classes_names_by_form_types()
    {
        $collectingService = new Definition();
        $this->setDefinition('command_bus_console.command_form_type_map', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('command_form_type', ['command_class' => 'test_command_class']);
        $collectedService->addTag('form.type', ['alias' => 'test_form_alias']);
        $this->setDefinition('colected_service_id', $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'command_bus_console.command_form_type_map',
            'processFormTypeServices',
            [['test_command_class' => 'colected_service_id']]
        );
    }

    /**
     * @test
     */
    public function it_should_register_more_than_one_command_to_one_form_type()
    {
        $collectingService = new Definition();
        $this->setDefinition('command_bus_console.command_form_type_map', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('command_form_type', ['command_class' => 'test_command_class_1']);
        $collectedService->addTag('command_form_type', ['command_class' => 'test_command_class_2']);
        $collectedService->addTag('form.type', ['alias' => 'test_form_alias']);
        $this->setDefinition('colected_service_id', $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'command_bus_console.command_form_type_map',
            'processFormTypeServices',
            [[
                'test_command_class_1' => 'colected_service_id',
                'test_command_class_2' => 'colected_service_id',

            ]]
        );
    }

    /**
     * @test
     * @expectedException Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler\CommandFormTypeDuplicate
     */
    public function it_should_throw_exception_when_command_name_is_duplicated()
    {
        $collectingService = new Definition();
        $this->setDefinition('command_bus_console.command_form_type_map', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('command_form_type', ['command_class' => 'test_command_class']);
        $collectedService->addTag('form.type', ['alias' => 'test_form_alias']);
        $this->setDefinition('colected_service_id', $collectedService);

        $collectedServiceDuplicate = new Definition();
        $collectedServiceDuplicate->addTag('command_form_type', ['command_class' => 'test_command_class']);
        $collectedServiceDuplicate->addTag('form.type', ['alias' => 'another_test_form_alias']);
        $this->setDefinition('colected_service_duplicate_id', $collectedServiceDuplicate);

        $this->compile();
    }

    /**
     * @test
     * @expectedException Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler\CommandFormTypeMissingFormTypeTag
     */
    public function it_should_throw_exception_when_form_type_tag_is_missing()
    {
        $collectingService = new Definition();
        $this->setDefinition('command_bus_console.command_form_type_map', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('command_form_type', ['command_class' => 'test_command_class']);
        $this->setDefinition('colected_service_id', $collectedService);

        $this->compile();
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