<?php

namespace examples\Clearcode\CommandBusConsole\Bundle\Command;

use examples\Clearcode\CommandBusConsole\Bundle\Form\Type\SignUpType;
use examples\Clearcode\CommandBusConsole\Domain\Application\SignUp;
use Matthias\SymfonyConsoleForm\Console\Helper\FormHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunInteractiveCommand extends Command
{
    private static $commandToFormTypeMap = [
        SignUp::class => SignUpType::class,
    ];

    protected function configure()
    {
        $this->setName('run:interactive');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FormHelper $formHelper */
        $formHelper = $this->getHelper('form');

        $command = $formHelper->interactUsingForm(new static::$commandToFormTypeMap[SignUp::class](), $input, $output);

        dump($command);
    }
}
