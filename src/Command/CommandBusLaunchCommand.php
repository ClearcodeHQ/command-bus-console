<?php

namespace ClearcodeHQ\CommandBusLauncherBundle\Command;

use ClearcodeHQ\CommandBusLauncherBundle\Launcher\CommandLauncherException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandBusLaunchCommand extends ContainerAwareCommand
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE   = 1;

    protected function configure()
    {
        $this
            ->setName('command-bus:launch')
            ->setDescription('Command for launching commands registered in command-bus.')
            ->addArgument('commandName', InputArgument::REQUIRED)
            ->addArgument('arguments', InputArgument::IS_ARRAY);
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandLauncher = $this->getContainer()->get('command_bus_launcher.command_launcher');

        $commandToLunch = $input->getArgument('commandName');
        $arguments      = $input->getArgument('arguments');

        try {
            $command = $commandLauncher->getCommandToLaunch($commandToLunch, $arguments);
        } catch (CommandLauncherException $e) {
            return $this->handleException($output, $e);
        }

        try {
            $this->getContainer()->get('command_bus')->handle($command);
        } catch (\Exception $e) {
            return $this->handleException($output, $e);
        }

        return $this->handleSuccess($output, $commandToLunch);
    }

    private function handleException(OutputInterface $output, \Exception $exception)
    {
        $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

        return self::ERROR_CODE;
    }

    private function handleSuccess(OutputInterface $output, $commandToLunch)
    {
        $output->writeln(sprintf('The <info>%s</info> executed with success.', $commandToLunch));

        return self::SUCCESS_CODE;
    }
}
