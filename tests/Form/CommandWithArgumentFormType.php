<?php

namespace tests\Clearcode\CommandBusConsole\Form;

use Clearcode\CommandBusConsole\Bundle\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use tests\Clearcode\CommandBusConsole\CommandBus\CommandWithArgument;

class CommandWithArgumentFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', LegacyFormHelper::getType(TextType::class, 'text'), [
                'label' => 'Id',
                'required' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandWithArgument::class,
        ]);
    }

    public function getName()
    {
        return LegacyFormHelper::getType(self::class, 'command_with_argument');
    }
}
