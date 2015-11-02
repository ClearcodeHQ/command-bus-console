<?php

namespace tests\Command;

use ClearcodeHQ\CommandBusLauncherBundle\Command\CommandBusListCommand;
use tests\ClearcodeHQ\CommandBusLauncherBundle\CLITestCase;

class CommandBusListCommandTest extends CLITestCase
{
    /** @test */
    public function it_should_execute_command_with_success()
    {
        $this->executeCommand(new CommandBusListCommand());

        $this->assertThatStatusCodeEquals(CommandBusListCommand::SUCCESS_CODE);
        $this->assertThatOutputWasDisplayed();
    }
}
