<?php

namespace tests\Clearcode\CommandBusConsole\CommandBus;

final class CommandWithArgumentHandler
{
    public function handle(CommandWithArgument $command)
    {
        if (null === $command->id) {
            throw new \Exception('Missing argument "id".');
        }

        if (1234 !== intval($command->id)) {
            throw new \Exception('Expected argument value is "1234".');
        }
    }
}
