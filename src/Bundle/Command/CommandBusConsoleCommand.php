<?php

namespace Clearcode\CommandBusConsole\Bundle\Command;

use Clearcode\CommandBusConsole\CommandConsoleException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandBusConsoleCommand extends ContainerAwareCommand
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;

    protected function configure()
    {
        $this
            ->setName('command-bus:handle')
            ->setDescription('CLI for command bus.')
            ->addArgument('commandName', InputArgument::REQUIRED)
            ->addArgument('arguments', InputArgument::IS_ARRAY);
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandLauncher = $this->getContainer()->get('command_bus_console.command_launcher');

        $commandToLunch = $input->getArgument('commandName');
        $arguments = $input->getArgument('arguments');

        $arguments = $this->parseNamedArguments($arguments);

        try {
            $command = $commandLauncher->getCommandToLaunch($commandToLunch, $arguments);
        } catch (CommandConsoleException $e) {
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

    /**
     * @param string[] $arguments
     *
     * @return string[]
     */
    protected function parseNamedArguments(array $arguments)
    {
        foreach ($arguments as $key => $argument) {
            if (strpos($argument, '=')) {
                list($arg, $value) = explode('=', $argument);

                unset($arguments[$key]);
                $arguments[$arg] = $value;
            }
        }

        return $arguments;
    }
}
