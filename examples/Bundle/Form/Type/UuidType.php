<?php

namespace examples\Clearcode\CommandBusConsole\Bundle\Form\Type;

use examples\Clearcode\CommandBusConsole\Bundle\Form\Transformer\UuidTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UuidType extends TextType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new UuidTransformer());
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'uuid';
    }
}
