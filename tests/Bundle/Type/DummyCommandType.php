<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use tests\Clearcode\CommandBusConsole\Bundle\Mocks\DummyCommand;

class DummyCommandType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('argument1', 'text', [
            'label' => 'What\'s first argument?',
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DummyCommand::class,
            'empty_data' => function (FormInterface $form) {
                return new DummyCommand($form->get('argument1')->getData());
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
