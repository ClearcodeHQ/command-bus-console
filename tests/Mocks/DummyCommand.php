<?php

namespace tests\ClearcodeHQ\CommandBusLauncherBundle\Mocks;

class DummyCommand
{
    public $paramter1;

    /**
     * @param $paramter1
     */
    public function __construct($paramter1)
    {
        $this->paramter1 = $paramter1;
    }
}