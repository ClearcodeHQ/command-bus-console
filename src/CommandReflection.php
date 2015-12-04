<?php

namespace Clearcode\CommandBusConsole;

class CommandReflection
{
    /** @var string */
    public $commandName;
    /** @var string */
    public $commandClass;

    /**
     * @param $commandName
     * @param $commandClass
     */
    public function __construct($commandName, $commandClass)
    {
        $this->commandName = $commandName;
        $this->commandClass = $commandClass;
    }

    /**
     * @param $className
     *
     * @return CommandReflection
     */
    public static function fromClass($className)
    {
        $reflection = new \ReflectionClass($className);

        return new self($reflection->getShortName(), $className);
    }

    /**
     * @return \ReflectionParameter[]
     */
    public function parameters()
    {
        $commandReflection = new \ReflectionClass($this->commandClass);

        return $commandParameters = $commandReflection->getConstructor() ?
            $commandReflection->getConstructor()->getParameters() :
            [];
    }

    /**
     * @param array              $arguments
     * @param ArgumentsProcessor $argumentsProcessor
     *
     * @return object
     *
     * @throws InvalidCommandArgument
     * @throws MissingCommandArgument
     */
    public function createCommand(array $arguments, ArgumentsProcessor $argumentsProcessor)
    {
        $classReflection = new \ReflectionClass($this->commandClass);

        $inputArguments = $argumentsProcessor->process($arguments);

        $arrayDivide = function (array $array, callable $predicate) {
            return [
                array_filter($array, function ($value, $key) use ($predicate) { return $predicate($key, $value); }, ARRAY_FILTER_USE_BOTH),
                array_filter($array, function ($value, $key) use ($predicate) { return !$predicate($key, $value); }, ARRAY_FILTER_USE_BOTH),
            ];
        };

        $isKeyInteger = function ($key) {
            return is_integer($key);
        };

        list($orderedArguments, $namedArguments) = $arrayDivide($inputArguments, $isKeyInteger);

        $constructorArguments = [];

        foreach ($this->parameters() as $commandArgument) {
            $argument = array_key_exists($commandArgument->getName(), $namedArguments) ?
                $namedArguments[$commandArgument->getName()] :
                array_shift($orderedArguments);

            if (null === $argument) {
                throw new MissingCommandArgument(
                    sprintf("Missing argument %s for '%s' command", $commandArgument->getPosition() + 1, $this->commandName)
                );
            }

            if (null !== $commandArgument->getClass()) {
                $argumentClass = $commandArgument->getClass()->getName();

                if (!$argument instanceof $argumentClass) {
                    throw new InvalidCommandArgument(
                        sprintf(
                            "Invalid argument for '%s' command. Expected parameter %s to be instance of '%s'",
                            $this->commandName,
                            $commandArgument->getPosition() + 1,
                            $argumentClass
                        )
                    );
                }
            }

            $constructorArguments[$commandArgument->getPosition()] = $argument;
        }

        return $classReflection->newInstanceArgs($constructorArguments);
    }
}
