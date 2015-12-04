<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\Mocks;

class SendInvitationHandler
{
    /**
     * @param SendInvitation $command
     *
     * @throws \Exception
     */
    public function handle(SendInvitation $command)
    {
        if ($command->argument1 == SendInvitation::HANDLING_WITH_FAIL) {
            throw new \Exception('An unexpected error occurred.');
        }
    }
}
