<?php

namespace ClearcodeHQ\CommandBusLauncher;

class CommandCollector
{
    /**
     * @var CommandReflection[]
     */
    public $commands = [];

    /**
     * @param array $services
     */
    public function processCommandServices(array $services)
    {
        foreach ($services as $service) {
            $this->commands[] = CommandReflection::fromClass($service);
        }
    }

    public function getCommandByName($commandName)
    {
        foreach ($this->commands as $command) {
            if ($command->commandName == $commandName) {
                return $command;
            }
        }

        throw new CommandDoesNotExist(sprintf("Command '%s' does not exists", $commandName));
    }
}
