<?php

namespace Clearcode\CommandBusConsole\Bundle\Command;

use Matthias\SymfonyConsoleForm\Console\Helper\FormHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use tests\Clearcode\CommandBusConsole\Bundle\Type\SignUpUserType;

class CommandBusInteractiveConsoleCommand extends ContainerAwareCommand
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;

    const INTERACTIVE_COMMAND = 'command-bus:handle';

    private static $commandToFormTypeMap = [
        'DummyCommand' => SignUpUserType::class,
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

        try {
            $this->getContainer()->get('command_bus')->handle($command);
        } catch (\Exception $e) {
            return $this->handleException($output, $e);
        }

        return $this->handleSuccess($output, $commandName);
    }

    private function handleException(OutputInterface $output, \Exception $exception)
    {
        $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

        return self::ERROR_CODE;
    }

    private function handleSuccess(OutputInterface $output, $commandName)
    {
        $output->writeln(sprintf('The <info>%s</info> executed with success.', $commandName));

        return self::SUCCESS_CODE;
    }
}