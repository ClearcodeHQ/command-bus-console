<?php

namespace tests\Clearcode\CommandBusConsole\CommandBus;

final class UnsuccessfulCommandHandler
{
    public function handle(UnsuccessfulCommand $command)
    {
        throw new \DomainException('Unsuccessful command execution.');
    }
}
