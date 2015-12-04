<?php

namespace tests\Clearcode\CommandBusConsole\Mocks;

class SignUpUser
{
    /** @var string */
    public $fullName;

    /** @var string */
    public $email;

    public function __construct($fullName, $email)
    {
        $this->fullName = $fullName;
        $this->email    = $email;
    }
}
