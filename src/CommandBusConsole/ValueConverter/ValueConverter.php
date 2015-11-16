<?php

namespace Clearcode\CommandBusConsole\ValueConverter;

interface ValueConverter
{
    public function convert($rawValue);
}
