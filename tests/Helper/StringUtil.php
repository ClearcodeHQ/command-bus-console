<?php

namespace tests\Clearcode\CommandBusConsole\Helper;

final class StringUtil
{
    private function __construct()
    {
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public static function removeEmptyLines($text)
    {
        return implode(
           "\n",
           array_filter(
               explode("\n", $text),
               function ($line) { return '' !== $line; }
           )
       );
    }
}
