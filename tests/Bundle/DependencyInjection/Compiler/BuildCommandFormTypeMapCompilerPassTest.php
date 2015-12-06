<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler;

use Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler\BuildCommandFormTypeMapCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class BuildCommandFormTypeMapCompilerPassTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_adds_method_call_to_command_form_type_map()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new BuildCommandFormTypeMapCompilerPass());

        $container->addDefinitions([
            'command_bus_console.command_form_type_map' => (new Definition())
                    ->setClass('Clearcode\CommandBusConsole\CommandFormTypeMap'),
            'form.type' => (new Definition())
                    ->setClass('Expected\FormType')
                    ->addTag('form.type')
                    ->addTag('command.type', ['command' => 'Expected\Command']),
        ]);

        $container->compile();

        $this->assertEquals(
            [
                ['add', ['Expected\Command', 'Expected\FormType']],
            ],
            $container->getDefinition('command_bus_console.command_form_type_map')->getMethodCalls()
        );
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Service with id "form.type" has 2 tags named "command.type", but only one is allowed.
     */
    public function it_throws_exception_if_more_than_one_tag_is_registered()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new BuildCommandFormTypeMapCompilerPass());

        $container->addDefinitions([
            'command_bus_console.command_form_type_map' => (new Definition())
                    ->setClass('Clearcode\CommandBusConsole\CommandFormTypeMap'),
            'form.type' => (new Definition())
                    ->setClass('Expected\FormType')
                    ->addTag('form.type')
                    ->addTag('command.type', ['command' => 'Expected\Command'])
                    ->addTag('command.type', ['command' => 'Expected\OtherCommand']),
        ]);

        $container->compile();
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Service with id "form.type" has to be tagged with "form.type".
     */
    public function it_throws_exception_if_service_is_not_a_from_type()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new BuildCommandFormTypeMapCompilerPass());

        $container->addDefinitions([
            'command_bus_console.command_form_type_map' => (new Definition())
                    ->setClass('Clearcode\CommandBusConsole\CommandFormTypeMap'),
            'form.type' => (new Definition())
                    ->setClass('Expected\FormType')
                    ->addTag('command.type', ['command' => 'Expected\Command']),
        ]);

        $container->compile();
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Service with id "form.type" has tag "command.type" with missing attribute "command".
     */
    public function it_throws_exception_if_attribute_command_is_missing()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new BuildCommandFormTypeMapCompilerPass());

        $container->addDefinitions([
            'command_bus_console.command_form_type_map' => (new Definition())
                    ->setClass('Clearcode\CommandBusConsole\CommandFormTypeMap'),
            'form.type' => (new Definition())
                    ->setClass('Expected\FormType')
                    ->addTag('form.type')
                    ->addTag('command.type'),
        ]);

        $container->compile();
    }
}
