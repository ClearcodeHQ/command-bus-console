<?php

namespace examples\Clearcode\CommandBusConsole\Bundle\Form\Type;

use examples\Clearcode\CommandBusConsole\Domain\Application\SignUp;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', new UuidType(), [
                'label' => 'What\'s the ID?',
                'data' => Uuid::uuid4(),
            ])
            ->add('as', 'text', [
                'label' => 'What\'s your name?',
            ])
            ->add('withEmail', 'text', [
                'label' => 'What\'s your email?',
            ])
            ->add('dateOfBirth', 'date', [
                'label' => 'What\'s the time of sign up?',
                'years' => range(1970, 2010),
            ])
            ->add('sex', 'choice', [
                'label' => 'What\'s your sex?',
                'choices' => [
                    'M' => 'Male',
                    'F' => 'Female',
                ],
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
        return 'sign_up';
    }
}
