<?php

namespace Clearcode\CommandBusConsole;

final class CommandFormTypeMap
{
    /**
     * @var string[]
     */
    private $map = [];

    /**
     * @param string $commandClass
     * @param string $formTypeClass
     */
    public function add($commandClass, $formTypeClass)
    {
        $this->map[$commandClass] = $formTypeClass;
    }

    /**
     * @param string $commandClass
     *
     * @return null|string|string[]
     */
    public function get($commandClass)
    {
        $noneOrOneOrMore = function ($item) {
            if (is_array($item) && 0 === count($item)) {
                return;
            } elseif (is_array($item) && 1 === count($item)) {
                return reset($item);
            } else {
                return $item;
            }
        };

        if (array_key_exists($commandClass, $this->map)) {
            return $this->map[$commandClass];
        } else {
            return $noneOrOneOrMore(
                array_filter(
                    $this->map,
                    function ($key) use ($commandClass) {
                        $pattern = sprintf('/%s$/', preg_quote('\\'.$commandClass));

                        return preg_match($pattern, $key, $matches);
                    },
                    ARRAY_FILTER_USE_KEY
                )
            );
        }
    }
}
