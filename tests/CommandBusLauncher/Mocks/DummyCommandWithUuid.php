<?php

namespace tests\ClearcodeHQ\CommandBusLauncher\Mocks;

use Ramsey\Uuid\Uuid;

class DummyCommandWithUuid
{
    /** @var string */
    public $argument1;

    /** @var Uuid */
    public $argument2;

    public function __construct($argument1, Uuid $argumentUuid)
    {
        $this->argument1 = $argument1;
        $this->argument2 = $argumentUuid;
    }
}
