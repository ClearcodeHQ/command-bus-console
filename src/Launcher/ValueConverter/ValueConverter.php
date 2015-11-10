<?php

namespace ClearcodeHQ\CommandBusLauncherBundle\Launcher\ValueConverter;

interface ValueConverter
{
    public function convert($rawValue);
}
