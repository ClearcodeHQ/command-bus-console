<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\Command;

use Clearcode\CommandBusConsole\Bundle\Command\CommandBusConsoleCommand;
use tests\Clearcode\CommandBusConsole\Bundle\CLITestCase;
use tests\Clearcode\CommandBusConsole\Bundle\Mocks\SendInvitation;

class CommandBusLaunchCommandTest extends CLITestCase
{
    /** @test */
    public function it_should_execute_command_with_success()
    {
        $this->executeCommand(new CommandBusConsoleCommand(), [
            'commandName' => 'SendInvitation',
            'arguments' => [SendInvitation::HANDLING_WITH_SUCCESS],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusConsoleCommand::SUCCESS_CODE);
    }

    /** @test */
    public function it_display_an_error_when_command_does_not_exists()
    {
        $this->executeCommand(new CommandBusConsoleCommand(), [
            'commandName' => 'NonExistingCommand',
        ]);

        $this->assertThatStatusCodeEquals(CommandBusConsoleCommand::ERROR_CODE);
        $this->assertThatOutputContains("Command 'NonExistingCommand' does not exists");
    }

    /** @test */
    public function it_display_an_error_when_required_arguments_was_not_provided()
    {
        $this->markTestIncomplete();

        $this->executeCommand(new CommandBusConsoleCommand(), [
            'commandName' => 'SendInvitation',
            'arguments' => [],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusConsoleCommand::ERROR_CODE);
    }

    /** @test */
    public function it_display_an_error_when_executing_command_will_fail()
    {
        $this->executeCommand(new CommandBusConsoleCommand(), [
            'commandName' => 'NonExistingCommand',
            'arguments' => [SendInvitation::HANDLING_WITH_FAIL],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusConsoleCommand::ERROR_CODE);
    }
}
