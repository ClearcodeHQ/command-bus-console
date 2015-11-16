<?php

namespace examples\Bundle\Form\Type;

use examples\Domain\Application\DoSomething;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DoSomethingType extends FormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('theThing', 'text', [
                'label' => ''
            ])
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DoSomething::class
        ]);
    }
}