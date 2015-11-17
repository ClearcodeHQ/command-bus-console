<?php

namespace examples\Clearcode\CommandBusConsole\Domain\Application;

use Ramsey\Uuid\Uuid;

final class SignUp
{
    /** @var Uuid */
    public $id;

    /** @var string */
    public $as;

    /** @var string */
    public $withEmail;

    /** @var \DateTime */
    public $dateOfBirth;
}
