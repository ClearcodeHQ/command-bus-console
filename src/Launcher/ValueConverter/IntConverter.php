<?php

namespace ClearcodeHQ\CommandBusLauncherBundle\Launcher\ValueConverter;

class IntConverter implements ValueConverter
{
    public function convert($rawValue)
    {
        if (is_numeric($rawValue)) {
            return (int) $rawValue;
        }

        return;
    }
}
