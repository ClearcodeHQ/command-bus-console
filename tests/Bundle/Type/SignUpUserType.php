<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use tests\Clearcode\CommandBusConsole\Bundle\Mocks\SendInvitation;

class SignUpUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'text', [
            'label' => 'What\'s first argument?',
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SendInvitation::class,
            'empty_data' => function (FormInterface $form) {
                return new SendInvitation($form->get('argument1')->getData());
            },
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dummy_command_type';
    }
}
