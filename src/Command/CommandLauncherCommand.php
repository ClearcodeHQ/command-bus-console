<?php

namespace ClearcodeHQ\CommandBusLauncherBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ClearcodeHQ\CommandBusLauncher\CommandLauncherException;

class CommandLauncherCommand extends ContainerAwareCommand
{
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

            return;
        }

        $this->getContainer()->get('command_bus')->handle($command);
    }
}