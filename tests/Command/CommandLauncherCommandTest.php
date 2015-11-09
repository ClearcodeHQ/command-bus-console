<?php

namespace tests\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Tester\CommandTester;
use tests\ClearcodeHQ\CommandBusLauncherBundle\CLITestCase;
use ClearcodeHQ\CommandBusLauncherBundle\Command\CommandLauncherCommand;

class CommandLauncherCommandTest extends CLITestCase
{
    /**
     * @test
     */
    public function it_should_execute_command()
    {
        $statusCode = $this->executeCommand('DummyCommand', ['first argument value']);
        \PHPUnit_Framework_Assert::assertEquals(CommandLauncherCommand::SUCCESS_CODE, $statusCode);
    }

    /**
     * @test
     * @expectedException \ClearcodeHQ\CommandBusLauncher\CommandDoesNotExist
     */
    public function it_throws_exception_when_command_does_not_exists()
    {
        $this->executeCommand('NonExistingCommand');
    }
}
