<?php

namespace tests\Clearcode\CommandBusConsole\CommandBus;

final class CommandWithArgument
{
    /** @var int */
    public $id;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
}
