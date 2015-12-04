<?php

namespace tests\Clearcode\CommandBusConsole;

use Clearcode\CommandBusConsole\ArgumentsProcessor;
use Clearcode\CommandBusConsole\CommandCollector;
use Clearcode\CommandBusConsole\CommandLauncher;
use Clearcode\CommandBusConsole\CommandReflection;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use tests\Clearcode\CommandBusConsole\Mocks\SignUpUser;
use tests\Clearcode\CommandBusConsole\Mocks\DummyCommandWithUuid;

class CommandLauncherTest extends \PHPUnit_Framework_TestCase
{
    /** @var CommandLauncher */
    private $sut;

    /** @var CommandCollector */
    private $commandCollector;
    /** @var ArgumentsProcessor */
    private $argumentsProcessor;

    /** @test */
    public function it_returns_command_with_integer_to_launch()
    {
        $this->commandCollector->getCommandByName('SignUpUser')->willReturn(
            CommandReflection::fromClass(SignUpUser::class)
        );

        $this->argumentsProcessor->process(Argument::any())->willReturn(
            ['Jacek Jagiello', 'j.jagiello@clearcode.cc']
        );

        $command = $this->sut->getCommandToLaunch('SignUpUser', ['Jacek Jagiello', 'j.jagiello@clearcode.cc']);

        $this->assertInstanceOf(SignUpUser::class, $command);
        $this->assertTrue('Jacek Jagiello' === $command->fullName);
        $this->assertTrue('j.jagiello@clearcode.cc' === $command->email);
    }

    /** @test */
    public function it_returns_command_with_uuid_to_launch()
    {
        $this->commandCollector->getCommandByName('DummyCommandWithUuid')->willReturn(
            CommandReflection::fromClass(DummyCommandWithUuid::class)
        );

        $this->argumentsProcessor->process(['lorem ipsum', 'a1df6294-bcd9-43c5-8731-e3cd43401974'])->willReturn(
            ['lorem ipsum', Uuid::fromString('a1df6294-bcd9-43c5-8731-e3cd43401974')]
        );

        $command = $this->sut->getCommandToLaunch('DummyCommandWithUuid', ['lorem ipsum', 'a1df6294-bcd9-43c5-8731-e3cd43401974']);

        $this->assertInstanceOf(DummyCommandWithUuid::class, $command);
        $this->assertTrue(Uuid::fromString('a1df6294-bcd9-43c5-8731-e3cd43401974')->equals($command->argument2));
    }

    /** @test */
    public function it_returns_command_reflection()
    {
        $this->commandCollector->getCommandByName('SignUpUser')->willReturn(
            CommandReflection::fromClass(SignUpUser::class)
        );

        $commandReflection = $this->sut->getCommandReflection('SignUpUser');

        $this->assertInstanceOf(CommandReflection::class, $commandReflection);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->commandCollector = $this->prophesize(CommandCollector::class);
        $this->argumentsProcessor = $this->prophesize(ArgumentsProcessor::class);

        $this->sut = new CommandLauncher($this->commandCollector->reveal(), $this->argumentsProcessor->reveal());
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->commandCollector = null;
        $this->argumentsProcessor = null;

        $this->sut = null;
    }
}
