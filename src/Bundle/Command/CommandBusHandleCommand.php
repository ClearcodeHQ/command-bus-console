<?php

namespace Clearcode\CommandBusConsole\Bundle\Command;

use Clearcode\CommandBusConsole\Bundle\LegacyFormHelper;
use Matthias\SymfonyConsoleForm\Console\Command\InteractiveFormContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandBusHandleCommand extends InteractiveFormContainerAwareCommand
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;

    /** @var string */
    private $alias;

    /** @var string */
    private $formType;

    /** @var string */
    private $legacyFormTypeAlias;

    /**
     * @param string $alias
     * @param string $formType
     * @param string $legacyFormTypeAlias
     */
    public function __construct($alias, $formType, $legacyFormTypeAlias)
    {
        $this->alias = $alias;
        $this->formType = $formType;
        $this->legacyFormTypeAlias = $legacyFormTypeAlias;

        parent::__construct();
    }

    /** {@inheritdoc} */
    public function formType()
    {
        return LegacyFormHelper::getType($this->formType, $this->legacyFormTypeAlias);
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $this
            ->setName(sprintf('command-bus:%s', $this->alias))
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
        $command = $this->formData();

        $output->writeln(sprintf('<error>The %s failed to execute</error>', get_class($command)));

        foreach (get_object_vars($command) as $propertyName => $propertyValue) {
            $output->writeln(sprintf('<error>%s => %s</error>', $propertyName, $propertyValue));
        }

        $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

        return self::ERROR_CODE;
    }

    private function handleSuccess(OutputInterface $output, $commandToLunch)
    {
        $output->writeln(sprintf('The <info>%s</info> executed with success.', $commandToLunch));

        return self::SUCCESS_CODE;
    }
}
