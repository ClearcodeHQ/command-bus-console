<?php

namespace Clearcode\CommandBusConsole\Bundle\Command;

use Matthias\SymfonyConsoleForm\Console\Command\InteractiveFormContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandBusHandleCommand extends InteractiveFormContainerAwareCommand
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;

    private $formType;

    /** {@inheritdoc} */
    public function formType()
    {
        return $this->formType;
    }

    /**
     * @param string $formType
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
    }

    protected function configure()
    {
        $this
            ->setName('command-bus:handle')
            ->setDescription('CLI for command bus.')
            ->addArgument('commandName', InputArgument::REQUIRED)
        ;
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->getContainer()->get('command_bus')->handle($this->formData());
        } catch (\Exception $e) {
            return $this->handleException($output, $e);
        }

        return $this->handleSuccess($output, get_class($this->formData()));
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
