<?php

namespace examples\Clearcode\CommandBusConsole\Form;

use examples\Clearcode\CommandBusConsole\Application\SignUp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class, [
                'label' => 'Id',
                'data' => rand(1, 1024),
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('email', TextType::class, [
                'label' => 'email',
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SignUp::class,
        ]);
    }

    public function getName()
    {
        return self::class;
    }
}
