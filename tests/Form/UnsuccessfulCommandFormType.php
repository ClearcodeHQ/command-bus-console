<?php

namespace tests\Clearcode\CommandBusConsole\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use tests\Clearcode\CommandBusConsole\CommandBus\UnsuccessfulCommand;

class UnsuccessfulCommandFormType extends AbstractType
{
    /** {@inheritdoc} */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => UnsuccessfulCommand::class,
            ]);
    }
}
