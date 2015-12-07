<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler;

use Clearcode\CommandBusConsole\Bundle\Command\CommandBusHandleCommand;
use Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler\RegisterConsoleCommandsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class RegisterConsoleCommandsCompilerPassTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_adds_console_command_definition()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new RegisterConsoleCommandsCompilerPass());

        $container->addDefinitions([
            'form.type' => (new Definition())
                    ->setClass('Expected\FormType')
                    ->addTag('form.type')
                    ->addTag(RegisterConsoleCommandsCompilerPass::TAG, [
                        'command' => 'Vendor\Domain\Application\Commands\ExampleCommand',
                        'alias' => 'example-command',
                        ]
                    ),
        ]);

        $container->compile();

        $this->assertTrue($container->has('command_bus_console.example-command'));

        /** @var Definition $consoleCommandDefinition */
        $consoleCommandDefinition = $container->getDefinition('command_bus_console.example-command');

        $this->assertEquals(
            CommandBusHandleCommand::class,
            $consoleCommandDefinition->getClass()
        );

        $this->assertEquals(
            'example-command',
            $consoleCommandDefinition->getArgument(0)
        );

        $this->assertEquals(
            'Expected\FormType',
            $consoleCommandDefinition->getArgument(1)
        );

        $this->assertTrue(
            $consoleCommandDefinition->hasTag('console.command')
        );
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Service with id "form.type" has 2 tags named "command_bus.type", but only one is allowed.
     */
    public function it_throws_exception_if_more_than_one_tag_is_registered()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new RegisterConsoleCommandsCompilerPass());

        $container->addDefinitions([
            'form.type' => (new Definition())
                ->setClass('Expected\FormType')
                ->addTag('form.type')
                ->addTag(RegisterConsoleCommandsCompilerPass::TAG, [
                        'command' => 'Vendor\Domain\Application\Commands\ExampleCommand',
                        'alias' => 'example-command',
                    ]
                )
                ->addTag(RegisterConsoleCommandsCompilerPass::TAG, [
                        'command' => 'Vendor\Domain\Application\Commands\AnotherCommand',
                        'alias' => 'another-command',
                    ]
                ),
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
        $container->addCompilerPass(new RegisterConsoleCommandsCompilerPass());

        $container->addDefinitions([
            'form.type' => (new Definition())
                ->setClass('Expected\FormType')
                ->addTag(RegisterConsoleCommandsCompilerPass::TAG, [
                        'command' => 'Vendor\Domain\Application\Commands\ExampleCommand',
                        'alias' => 'example-command',
                    ]
                ),
        ]);

        $container->compile();
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Service with id "form.type" has tag "command_bus.type" with missing attribute "command".
     */
    public function it_throws_exception_if_attribute_command_is_missing()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new RegisterConsoleCommandsCompilerPass());

        $container->addDefinitions([
            'form.type' => (new Definition())
                ->setClass('Expected\FormType')
                ->addTag('form.type')
                ->addTag(RegisterConsoleCommandsCompilerPass::TAG, [
                        'alias' => 'example-command',
                    ]
                ),
        ]);

        $container->compile();
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Service with id "form.type" has tag "command_bus.type" with missing attribute "alias".
     */
    public function it_throws_exception_if_attribute_alias_is_missing()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new RegisterConsoleCommandsCompilerPass());

        $container->addDefinitions([
            'form.type' => (new Definition())
                ->setClass('Expected\FormType')
                ->addTag('form.type')
                ->addTag(RegisterConsoleCommandsCompilerPass::TAG, [
                        'command' => 'Vendor\Domain\Application\Commands\ExampleCommand',
                    ]
                ),
        ]);

        $container->compile();
    }
}
