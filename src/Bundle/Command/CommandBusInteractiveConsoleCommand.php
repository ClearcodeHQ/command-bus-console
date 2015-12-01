<?php

namespace Clearcode\CommandBusConsole\Bundle\Command;

use Matthias\SymfonyConsoleForm\Console\Helper\FormHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use tests\Clearcode\CommandBusConsole\Bundle\Type\DummyCommandType;

class CommandBusInteractiveConsoleCommand extends ContainerAwareCommand
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;

    const INTERACTIVE_COMMAND = 'command-bus:handle';

    private static $commandToFormTypeMap = [
        'DummyCommand' => DummyCommandType::class,
    ];

    protected function configure()
    {
        $this
            ->setName(self::INTERACTIVE_COMMAND)
            ->setDescription('Interactive CLI for command bus.')
            ->addArgument('commandName', InputArgument::REQUIRED);
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FormHelper $formHelper */
        $formHelper = $this->getHelper('form');

        $commandName = $input->getArgument('commandName');
        $command = $formHelper->interactUsingForm(new self::$commandToFormTypeMap[$commandName](), $input, $output);

        $output->writeln(print_r($command, true));
    }
}
