<?php

namespace tests\Command;

use ClearcodeHQ\CommandBusLauncherBundle\Command\CommandBusLaunchCommand;
use tests\ClearcodeHQ\CommandBusLauncherBundle\CLITestCase;
use tests\ClearcodeHQ\CommandBusLauncherBundle\Mocks\DummyCommand;

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
        $this->assertThatOutputWasDisplayed();
    }

    /** @test */
    public function it_display_an_error_when_command_does_not_exists()
    {
        $this->executeCommand(new CommandBusLaunchCommand(), [
            'commandName' => 'NonExistingCommand',
        ]);

        $this->assertThatStatusCodeEquals(CommandBusLaunchCommand::ERROR_CODE);
        $this->assertThatOutputWasDisplayed();
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
        $this->assertThatOutputWasDisplayed();
    }

    /** @test */
    public function it_display_an_error_when_executing_command_will_fail()
    {
        $this->executeCommand(new CommandBusLaunchCommand(), [
            'commandName' => 'DummyCommand',
            'arguments'   => [DummyCommand::HANDLING_WITH_FAIL],
        ]);

        $this->assertThatStatusCodeEquals(CommandBusLaunchCommand::ERROR_CODE);
        $this->assertThatOutputWasDisplayed();
    }
}
