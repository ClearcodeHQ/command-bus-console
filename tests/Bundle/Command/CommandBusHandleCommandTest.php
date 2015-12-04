<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\Command;

use Clearcode\CommandBusConsole\Bundle\Command\CommandBusHandleCommand;
use tests\Clearcode\CommandBusConsole\Bundle\CLITestCase;
use tests\Clearcode\CommandBusConsole\Bundle\Mocks\DummyCommand;

class CommandBusHandleCommandTest extends CLITestCase
{
    /** @test */
    public function it_should_execute_command_with_success()
    {
        $this->executeCommand(new CommandBusHandleCommand(), [
            'commandName' => 'DummyCommand',
            'arguments' => [DummyCommand::HANDLING_WITH_SUCCESS],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusHandleCommand::SUCCESS_CODE);
        $this->assertThatOutputContains('executed with success');
    }

    /** @test */
    public function it_display_an_error_when_command_does_not_exists()
    {
        $this->executeCommand(new CommandBusHandleCommand(), [
            'commandName' => 'NonExistingCommand',
        ]);

        $this->assertThatStatusCodeEquals(CommandBusHandleCommand::ERROR_CODE);
        $this->assertThatOutputContains("Command 'NonExistingCommand' does not exists");
    }

    /** @test */
    public function it_display_an_error_when_required_arguments_was_not_provided()
    {
        $this->markTestIncomplete();

        $this->executeCommand(new CommandBusHandleCommand(), [
            'commandName' => 'DummyCommand',
            'arguments' => [],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusHandleCommand::ERROR_CODE);
        $this->assertThatOutputContains('An unexpected error occurred.');
    }

    /** @test */
    public function it_display_an_error_when_executing_command_will_fail()
    {
        $this->executeCommand(new CommandBusHandleCommand(), [
            'commandName' => 'DummyCommand',
            'arguments' => [DummyCommand::HANDLING_WITH_FAIL],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusHandleCommand::ERROR_CODE);
        $this->assertThatOutputContains('An unexpected error occurred.');
    }
}
