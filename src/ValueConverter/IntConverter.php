<?php

namespace Clearcode\CommandBusConsole\ValueConverter;

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
