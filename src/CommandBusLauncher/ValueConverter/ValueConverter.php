<?php

namespace ClearcodeHQ\CommandBusLauncher\ValueConverter;

interface ValueConverter
{
    public function convert($rawValue);
}
