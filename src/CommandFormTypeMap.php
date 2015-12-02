<?php

namespace Clearcode\CommandBusConsole;

use SimpleBus\Message\CallableResolver\CallableResolver;
use SimpleBus\Message\CallableResolver\Exception\UndefinedCallable;

class CommandFormTypeMap
{
    /**
     * @var array
     */
    private $commandFormTypes = [];

    /**
     * @var CallableResolver
     */
    private $callableResolver;


    public function __construct(CallableResolver $callableResolver)
    {
        $this->callableResolver = $callableResolver;
    }

    /**
     * @param array $commandFormTypes
     */
    public function processFormTypeServices($commandFormTypes)
    {
        $this->commandFormTypes = $commandFormTypes;
    }

    /**
     * @param string $commandClass
     * @return callable
     */
    public function get($commandClass)
    {
        if (!array_key_exists($commandClass, $this->commandFormTypes)) {
            throw new UndefinedCallable(
                sprintf(
                    'Could not find a callable for name "%s"',
                    $commandClass
                )
            );
        }

        $callable = $this->commandFormTypes[$commandClass];

        return $this->callableResolver->resolve($callable);
    }
}
