<?php

namespace Clearcode\CommandBusConsole\Bundle;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use tests\Clearcode\CommandBusConsole\Bundle\Type\DummyCommandType;

class BaseInteractiveCommand extends ContainerAwareCommand
{
    private static $commandToFormTypeMap = [
        'DummyCommand' => DummyCommandType::class,
    ];

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function getCommandUsingInteractiveForm(InputInterface $input, OutputInterface $output)
    {
        /** @var FormHelper $formHelper */
        $formHelper = $this->getHelper('form');

        $commandName = $input->getArgument('commandName');
        return $formHelper->interactUsingForm(new self::$commandToFormTypeMap[$commandName](), $input, $output);
    }
}