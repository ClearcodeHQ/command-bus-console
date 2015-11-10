<?php

namespace tests\ClearcodeHQ\CommandBusLauncherBundle\Mocks;

class DummyCommand
{
    public $parameter;

    /**
     * @param $parameter
     */
    public function __construct($parameter)
    {
        $this->paramter = $parameter;
    }
}