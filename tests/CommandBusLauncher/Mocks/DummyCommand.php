<?php

namespace tests\ClearcodeHQ\CommandBusLauncher\Mocks;

class DummyCommand
{
    /** @var string */
    public $argument1;

    /** @var int */
    public $argument2;

    public function __construct($argument1, $argument2)
    {
        $this->argument1 = $argument1;
        $this->argument2 = $argument2;
    }
}
