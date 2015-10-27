<?php

namespace ClearcodeHQ\CommandBusLauncherBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ClearcodeHQ\CommandBusLauncher\CommandLauncherException;

class CommandLauncherCommand extends ContainerAwareCommand
{
    const SUCCESS_CODE = 1;
    const ERROR_CODE   = 0;

    protected function configure()
    {
        $this
            ->setName('command-bus:launch')
            ->addArgument('commandName', InputArgument::REQUIRED)
            ->addArgument('arguments', InputArgument::IS_ARRAY);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandLauncher = $this->getContainer()->get('command_bus_launcher.command_launcher');

        $commandToLunch = $input->getArgument('commandName');
        $arguments      = $input->getArgument('arguments');

        try {
            $command = $commandLauncher->getCommandToLaunch($commandToLunch, $arguments);
        } catch (CommandLauncherException $e) {
            $output->writeln($e->getMessage());

            return self::ERROR_CODE;
        }

        $this->getContainer()->get('command_bus')->handle($command);
        return self::SUCCESS_CODE;
    }
}