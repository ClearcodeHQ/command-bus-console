<?php

namespace examples\Clearcode\CommandBusConsole\Application;

final class SignUpHandler
{
    public function handle(SignUp $command)
    {
        var_dump($command);
        if ('error' === $command->id) {
            throw new \Exception('Error while executing command occurred.');
        }
    }
}
