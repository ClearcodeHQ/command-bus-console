<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\App;

use Clearcode\CommandBusConsole\Bundle\BaseInteractiveCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrintDataCommand extends BaseInteractiveCommand
{
    const COMMAND_NAME = 'command-bus:print_command';

    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->addArgument('commandName', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $this->getCommandUsingInteractiveForm($input, $output);

        $output->writeln(print_r($command, true));
    }
}