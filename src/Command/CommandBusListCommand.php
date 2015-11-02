<?php

namespace ClearcodeHQ\CommandBusLauncherBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandBusListCommand extends ContainerAwareCommand
{
    const SUCCESS_CODE = 1;
    const ERROR_CODE = 0;

    protected function configure()
    {
        //@todo add description
        $this
            ->setName('command-bus:list');
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //not implemented yet.

        $output->writeln('Currently available commands....');

        return self::SUCCESS_CODE;
    }
}
