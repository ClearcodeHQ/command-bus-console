<?php

namespace ClearcodeHQ\CommandBusLauncher;

class CommandLauncher
{
    /** @var CommandCollector */
    private $commandCollector;
    /** @var ArgumentsProcessor */
    private $argumentsProcessor;

    /**
     * @param CommandCollector   $commandCollector
     * @param ArgumentsProcessor $argumentsProcessor
     */
    public function __construct(CommandCollector $commandCollector, ArgumentsProcessor $argumentsProcessor)
    {
        $this->commandCollector   = $commandCollector;
        $this->argumentsProcessor = $argumentsProcessor;
    }

    /**
     * @param $commandName
     *
     * @return CommandReflection
     *
     * @throws CommandDoesNotExist
     */
    public function getCommandReflection($commandName)
    {
        return $this->commandCollector->getCommandByName($commandName);
    }

    /**
     * @param $commandName
     * @param $arguments
     *
     * @return object
     *
     * @throws CommandDoesNotExist
     */
    public function getCommandToLaunch($commandName, $arguments)
    {
        $commandReflection = $this->commandCollector->getCommandByName($commandName);

        return $commandReflection->createCommand($arguments, $this->argumentsProcessor);
    }
}
