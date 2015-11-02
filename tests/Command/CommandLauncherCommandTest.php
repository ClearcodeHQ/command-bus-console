<?php

namespace tests\Command;

use tests\ClearcodeHQ\CommandBusLauncherBundle\CLITestCase;
use ClearcodeHQ\CommandBusLauncherBundle\Command\CommandLauncherCommand;

class CommandLauncherCommandTest extends CLITestCase
{
    /**
     * @test
     */
    public function it_should_execute_command()
    {
        $statusCode = $this->executeCommand(new CommandLauncherCommand(), [
            'commandName' => 'DummyCommand',
            'arguments' => ['firstArgument'],
        ]);

        $this->assertEquals($statusCode, CommandLauncherCommand::SUCCESS_CODE);
    }

    /**
     * @test
     */
    public function it_throws_exception_when_command_does_not_exists()
    {
        $statusCode = $this->executeCommand(new CommandLauncherCommand(), [
            'commandName' => 'NonExistingCommand',
        ]);

        $this->assertEquals($statusCode, CommandLauncherCommand::ERROR_CODE);
    }
}
