<?php

namespace tests\Clearcode\CommandBusConsole;

use Clearcode\CommandBusConsole\CommandCollector;
use Clearcode\CommandBusConsole\CommandReflection;
use tests\Clearcode\CommandBusConsole\Mocks\DummyCommand;

class CommandCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandCollector
     */
    private $sut;

    /**
     * @var array
     */
    private $commands;

    /**
     * @test
     */
    public function it_process_command_services()
    {
        $this->sut->processCommandServices($this->commands);

        \PHPUnit_Framework_Assert::assertEquals(
            'DummyCommand',
            $this->sut->getCommandByName('DummyCommand')->commandName
        );
    }

    /**
     * @test
     */
    public function it_returns_command_reflection_by_command_name()
    {
        $this->sut->processCommandServices($this->commands);

        $command = $this->sut->getCommandByName('DummyCommand');

        \PHPUnit_Framework_Assert::assertInstanceOf(CommandReflection::class, $command);
    }

    /**
     * @test
     * @expectedException \Clearcode\CommandBusConsole\CommandDoesNotExist
     */
    public function it_throws_exception_when_command_does_not_exist()
    {
        $this->sut->processCommandServices($this->commands);

        $this->sut->getCommandByName('UnexistingCommand');
    }

    public function setUp()
    {
        $this->sut = new CommandCollector();

        $this->commands = [
            DummyCommand::class
        ];
    }
}
