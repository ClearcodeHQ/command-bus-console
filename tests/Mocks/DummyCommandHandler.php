<?php

namespace tests\ClearcodeHQ\CommandBusLauncherBundle\Mocks;

class DummyCommandHandler
{
    public function handle(DummyCommand $command)
    {
        return;
    }
}