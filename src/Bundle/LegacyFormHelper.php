<?php

namespace Clearcode\CommandBusConsole\Bundle;

final class LegacyFormHelper
{
    public static function getType($class, $alias)
    {
        return self::isLegacy() ?
            $alias :
            $class;
    }

    public static function isLegacy()
    {
        return !method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix');
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}
