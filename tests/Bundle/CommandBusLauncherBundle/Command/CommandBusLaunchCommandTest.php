<?php

namespace tests\ClearcodeHQ\Bundle\CommandBusLauncherBundle\Command;

use ClearcodeHQ\Bundle\CommandBusLauncherBundle\Command\CommandBusLaunchCommand;
use tests\ClearcodeHQ\Bundle\CommandBusLauncherBundle\CLITestCase;
use tests\ClearcodeHQ\Bundle\CommandBusLauncherBundle\Mocks\DummyCommand;

class CommandBusLaunchCommandTest extends CLITestCase
{
    /** @test */
    public function it_should_execute_command_with_success()
    {
        $this->executeCommand(new CommandBusLaunchCommand(), [
            'commandName' => 'DummyCommand',
            'arguments'   => [DummyCommand::HANDLING_WITH_SUCCESS],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusLaunchCommand::SUCCESS_CODE);
        $this->assertThatOutputContains('executed with success');
    }

    /** @test */
    public function it_display_an_error_when_command_does_not_exists()
    {
        $this->executeCommand(new CommandBusLaunchCommand(), [
            'commandName' => 'NonExistingCommand',
        ]);

        $this->assertThatStatusCodeEquals(CommandBusLaunchCommand::ERROR_CODE);
        $this->assertThatOutputContains("Command 'NonExistingCommand' does not exists");
    }

    /** @test */
    public function it_display_an_error_when_required_arguments_was_not_provided()
    {
        $this->markTestIncomplete();

        $this->executeCommand(new CommandBusLaunchCommand(), [
            'commandName' => 'DummyCommand',
            'arguments'   => [],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusLaunchCommand::ERROR_CODE);
        $this->assertThatOutputContains('An unexpected error occurred.');
    }

    /** @test */
    public function it_display_an_error_when_executing_command_will_fail()
    {
        $this->executeCommand(new CommandBusLaunchCommand(), [
            'commandName' => 'DummyCommand',
            'arguments'   => [DummyCommand::HANDLING_WITH_FAIL],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusLaunchCommand::ERROR_CODE);
        $this->assertThatOutputContains('An unexpected error occurred.');
    }
}
