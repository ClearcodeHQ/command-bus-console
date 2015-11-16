<?php

namespace examples\Clearcode\CommandBusConsole\Bundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunInteractiveCommand extends Command
{
    protected function configure()
    {
        $this->setName('run:interactive');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('This works!');
    }
}
