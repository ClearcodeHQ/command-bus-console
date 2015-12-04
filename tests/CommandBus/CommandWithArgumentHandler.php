<?php

namespace tests\Clearcode\CommandBusConsole\CommandBus;

final class CommandWithArgumentHandler
{
    public function handle(CommandWithArgument $command)
    {
        if (null === $command->id) {
            throw new \Exception('Missing argument "id".');
        }
    }
}
