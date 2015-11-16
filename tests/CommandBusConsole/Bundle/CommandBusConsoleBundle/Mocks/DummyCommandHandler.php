<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\CommandBusConsoleBundle\Mocks;

class DummyCommandHandler
{
    /**
     * @param DummyCommand $command
     *
     * @throws \Exception
     */
    public function handle(DummyCommand $command)
    {
        if ($command->argument1 == DummyCommand::HANDLING_WITH_FAIL) {
            throw new \Exception('An unexpected error occurred.');
        }
    }
}
