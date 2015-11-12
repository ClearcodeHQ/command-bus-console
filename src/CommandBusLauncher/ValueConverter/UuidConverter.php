<?php

namespace ClearcodeHQ\CommandBusLauncher\ValueConverter;

use Ramsey\Uuid\Uuid;

class UuidConverter implements ValueConverter
{
    public function convert($rawValue)
    {
        try {
            return Uuid::fromString($rawValue);
        } catch (\Exception $e) {
            return;
        }
    }
}
