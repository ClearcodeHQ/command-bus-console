<?php

namespace ClearcodeHQ\CommandBusLauncherBundle\Launcher;

use ClearcodeHQ\CommandBusLauncherBundle\Launcher\ValueConverter\ValueConverter;

class ArgumentsProcessor
{
    /**
     * @var ValueConverter[]
     */
    private $valueConverters;

    public function __construct(array $valueConverters = [])
    {
        $this->valueConverters = $valueConverters;
    }

    /**
     * @param $arguments
     *
     * @return mixed
     */
    public function process($arguments)
    {
        foreach ($arguments as $key => $argument) {
            $arguments[$key] = $this->convertValue($argument);
        }

        return $arguments;
    }

    private function convertValue($value)
    {
        foreach ($this->valueConverters as $valueConverter) {
            if (null !== $convertedValue = $valueConverter->convert($value)) {
                return $convertedValue;
            }
        }

        return $value;
    }
}
