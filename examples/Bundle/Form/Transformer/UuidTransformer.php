<?php

namespace examples\Clearcode\CommandBusConsole\Bundle\Form\Transformer;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\DataTransformerInterface;

class UuidTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        return Uuid::fromString($value);
    }
}
