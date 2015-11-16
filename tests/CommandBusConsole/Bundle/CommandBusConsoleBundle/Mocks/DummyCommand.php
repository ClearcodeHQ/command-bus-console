<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\CommandBusConsoleBundle\Mocks;

class DummyCommand
{
    const HANDLING_WITH_SUCCESS = 'HANDLING_WITH_SUCCESS';
    const HANDLING_WITH_FAIL = 'HANDLING_WITH_FAIL';

    /** @var string */
    public $argument1;

    /**
     * @param $argument1
     */
    public function __construct($argument1)
    {
        $this->argument1 = $argument1;
    }
}
